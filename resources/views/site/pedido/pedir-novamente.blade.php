<?php
/**
 * Component: Order Again (Customer Frequent Items)
 * Displays customer's most purchased products to facilitate reordering
 * 
 * IMPORTANT BEHAVIOR:
 * - Server data (logged users): Already filtered - only ACTIVE items (item_ativo=1, categoria_ativa=1)
 * - LocalStorage data (guest users): Validated before rendering to filter inactive items
 * - Items are ordered by: frequency DESC, quantity DESC, last purchase DESC
 * - Maximum 6 items shown
 * - 7-day cache validity for localStorage
 * 
 * VALIDATION RULES:
 * 1. Never suggest inactive items (even if frequently purchased)
 * 2. Server data takes priority over localStorage when user logs in
 * 3. LocalStorage items are re-validated on each render
 * 4. Items without stock (item_estoque = 0) show as "Indisponível"
 */

$itensFrequentes = $data['itensFrequentes'] ?? [];
$cliente_id = ClienteSessao::get_id();

// Default image path
$semFoto = "$baseUri/assets/item/semfoto.jpg";
?>

<!-- Order Again Container -->
<div id="pedir-novamente-container">
    <h2 class="pedir-novamente-title">
        <i class="fa fa-history" style="color: #c62828;"></i>
        Pedir Novamente
    </h2>
    
    <div class="pedir-novamente-slick" id="pedirNovamenteCarousel" aria-label="Carrossel de itens frequentes">
        <!-- Items will be injected via JavaScript -->
    </div>
</div>

<!-- HTML Template for each item (used by JavaScript) -->
<template id="item-frequente-template">
    <article class="card-pedir-novamente" data-id="">
        <div class="card-img-wrapper">
            <img src="" alt="" class="item-image">
            <div class="badge-frequente-wrapper">
                <span class="badge-frequente">
                    <i class="fa fa-star"></i> Você adora
                </span>
            </div>
        </div>
        <div class="card-body-pedir">
            <div class="item-info">
                <div class="item-categoria"></div>
                <div class="item-nome"></div>
                <div class="item-descricao"></div>
                <div class="item-preco"></div>
            </div>
            <button class="btn-pedir-novamente"
                data-toggle="modal"
                data-target=""
                title="adicionar à sacola">
                <i class="fa fa-refresh"></i> Pedir novamente
            </button>
        </div>
    </article>
</template>

<?php
// Generate modals for frequent items (if they exist from server)
if (!empty($itensFrequentes)) {
    foreach ($itensFrequentes as $item) {
        // Get item options
        $opcoes = (new opcaoModel)->get_by_categoria($item->categoria_id);
        $foto_url = "midias/item/$_SESSION[base_delivery]/" . ($item->item_foto ?? '');
        $meia = 0; // Default, can be adjusted as needed
?>
<div class="modal fade bs-example-modal-lg modal-itens" tabindex="-1" id="item-<?= $item->item_id; ?>" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title text-uppercase text-center">Detalhes e Opções
                    <small class="text-muted"><br><?= $item->categoria_nome ?? '' ?></small>
                </h5>
            </div>
            <div class="modal-body">
                <span class="label-text">
                    <span class="lista-item-opcao"><?= ucfirst(mb_strtolower($item->item_nome ?? '')) ?></span><br>
                    <span class="text-success">(<?= strip_tags($item->item_obs ?? ''); ?>)</span><br>
                    <span class="text-success" style="font-size: 14px;">R$ <?= number_format($item->item_preco ?? 0, 2, ',', '.'); ?></span>
                </span>
                
                <?php if (isset($opcoes[0])) {
                    foreach ($opcoes as $opcao) {
                ?>
                    <div class="grupo<?= $opcao[0]->grupo_nome ?>">
                        <?php if (isset($opcao[0]->opcao_id)) { ?>
                            <div class="<?= ($opcao[0]->grupo_tipo == 1) ? 'elmRequerido' : ''; ?>">
                                <small class="text-uppercase">
                                    <br>
                                    <div class="grupo<?= $opcao[0]->grupo_nome ?>">
                                        <b><?= $opcao[0]->grupo_nome ?></b>
                                        <?php if ($opcao[0]->grupo_tipo == 1) { ?>
                                            <small class="text-muted text-success"> &nbsp;* obrigatório</small>
                                        <?php } else { ?>
                                            <?php $lim = $opcao[0]->grupo_limite; ?>
                                            <small class="text-muted"> * opcional
                                                <?= ($lim <= 0) ? '' : '(até ' . $lim  ?>
                                                <?= ($lim != 0) ? ($lim > 1) ? ' itens)' : 'item) ' : '' ?>
                                            </small>
                                        <?php } ?>
                                    </div>
                                </small>
                                <br>
                            </div>
                            <?php
                            foreach ($opcao as $opc) {
                            ?>
                                <div class="form-check opt-<?= $opc->grupo_id ?> opt-<?= $item->item_id ?> grupo-<?= $opc->grupo_id ?> " data-preco="<?= Currency::moedaUS($item->item_preco ?? 0) ?>">
                                    <label for="opt-<?= $opc->opcao_id ?>-<?= $item->item_id ?>">
                                        <?php $tipo = ($opc->grupo_selecao == 1) ? 'radio' : 'checkbox'; ?>
                                        <div class="grupo tamanho-<?= $item->item_id ?>">
                                            <input class="tamanho-<?= $item->item_id ?>" type="<?= $tipo ?>" name="opt-<?= $opc->grupo_id ?>-<?= $item->item_id ?>" id="opt-<?= $opc->opcao_id ?>-<?= $item->item_id ?>" data-limite="<?= ($opc->grupo_limite <= 0) ? 100 : $opc->grupo_limite ?>" data-grupo="<?= $opc->grupo_id ?>" data-item="<?= $item->item_id ?>" data-estoque="<?= intval($item->item_estoque ?? 0); ?>" data-id="<?= $opc->opcao_id ?>" data-nome="<?= $opc->opcao_nome ?>" data-preco_real="<?= Currency::moedaUS($opc->opcao_preco) ?>" data-preco=" <?= ($opc->opcao_preco > 0) ? ' + R$ ' . Currency::moeda($opc->opcao_preco) : ''; ?>" <?= ($opc->grupo_tipo == 1) ? 'required' : ''; ?> value="<?= $opc->opcao_id ?>" />
                                            <span class="label-text">
                                                <span class="lista-item-opcao text-capitalize"><?= mb_strtolower($opc->opcao_nome) ?></span>
                                                <span class="text-success">
                                                    <?= ($opc->opcao_preco > 0) ? ' R$ ' . Currency::moeda($opc->opcao_preco) : ''; ?>
                                                </span>
                                                <span class="text-warning acrescimo<?= $opc->opcao_nome ?>"></span>
                                            </span>
                                        </div>
                                    </label>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <p class="text-center">
                    <button type="button" id="btn-add-<?= $item->item_id ?>" data-id="<?= $item->item_id ?>" data-nome="<?= $item->item_nome ?? '' ?>" data-obs="<?= strip_tags($item->item_obs ?? '') ?>" data-categoria="<?= $item->categoria_id ?? 0 ?>" data-categoria-nome="<?= $item->categoria_nome ?? '' ?>" data-preco="<?= Currency::moedaUS($item->item_preco ?? 0) ?>" data-estoque="<?= intval($item->item_estoque ?? 0); ?>" data-cod="<?= $item->item_codigo ?? ''; ?>" class="btn btn-primary btn-lg add-item btn-block" title="adicionar à sacola">
                        <i class="fa fa-plus-circle"></i> Adicionar ao carrinho
                    </button>
                    <button type="button" data-dismiss="modal" class="btn btn-defaul btn-lg btn-block" title="voltar">
                        <i class="fa fa-chevron-circle-left"></i> Voltar à lista
                    </button>
                    <br><br>
                    <strong class="text-success" id="msg-<?= $item->item_id ?>"> </strong>
                </p>
            </div>
        </div>
    </div>
</div>
<?php
    }
}
?>

<style>
/* Custom styles for Pedir Novamente - With Slick Carousel */
#pedir-novamente-container {
    margin: 15px 0 10px 0;
    padding: 0;
}

#pedir-novamente-container.hidden {
    display: none;
}

.pedir-novamente-title {
    font-size: 22px;
    font-weight: 700;
    color: #333;
    margin: 0 0 12px 0;
    padding: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Slick carousel container - CRITICAL: Keep visible */
.pedir-novamente-slick {
    margin: 30px 0; /* Adiciona espaço superior e inferior */
    padding: 10px 0;
    min-height: 200px;
}

/* Remove Slick default styles */
.pedir-novamente-slick .slick-list {
    margin: 0 -6px;
}

.pedir-novamente-slick .slick-slide {
    padding: 0 6px;
}

/* Card - CRITICAL: Fixed dimensions prevent layout breaking */
.card-pedir-novamente {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.05);
    display: flex !important;
    flex-direction: column;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin: 0 auto;
    width: 100%;
    height: 360px; /* Increased height to accommodate more content */
    max-width: 100%;
}

.card-pedir-novamente:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.card-pedir-novamente .card-img-wrapper {
    position: relative;
    width: 100%;
    height: 110px; /* Reduced slightly to give more space to description */
    overflow: hidden;
}

.card-pedir-novamente .card-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.badge-frequente-wrapper {
    position: absolute;
    top: 8px;
    right: 8px;
    z-index: 5;
}

.badge-frequente {
    background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
    color: #fff;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 700;
    box-shadow: 0 2px 6px rgba(255, 165, 0, 0.3);
    display: inline-flex;
    align-items: center;
    gap: 3px;
    white-space: nowrap;
}

.badge-frequente i {
    font-size: 10px;
}

.card-body-pedir {
    padding: 10px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    flex: 1;
}

.item-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.item-categoria {
    font-size: 11px;
    color: #666;
    font-weight: 600;
    text-transform: uppercase;
}

.item-nome {
    font-size: 14px;
    font-weight: 700;
    color: #333;
    line-height: 1.3;
    max-height: 2.6em;
    overflow: hidden;
}

.item-preco {
    font-size: 16px;
    font-weight: 700;
    color: #c62828;
    margin-top: 2px;
}

.btn-pedir-novamente {
    background: #c62828;
    color: white;
    border: none;
    padding: 8px 10px;
    width: 100%;
    border-radius: 6px;
    font-weight: 700;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}

.btn-pedir-novamente:hover {
    background: #a01f1f;
    transform: scale(1.02);
}

.btn-pedir-novamente.btn-disabled {
    background: #ccc;
    color: #666;
    cursor: not-allowed;
}

.btn-pedir-novamente i {
    font-size: 11px;
}

/* Item description styling - CRITICAL: Must be visible and readable */
.card-pedir-novamente .item-info .item-descricao {
    font-size: 9px;
    color: #333;
    margin: 6px 0 4px 0;
    padding: 6px 8px;
    background: #f5f5f5;
    border-radius: 4px;
    line-height: 1.3;
    max-height: 95px; /* Increased to show more content */
    overflow-y: auto; /* Add scroll if content is too long */
    text-align: left;
    display: block !important;
    word-wrap: break-word;
    word-break: break-word;
    border-left: 3px solid #c62828;
}

.card-pedir-novamente .item-info .item-descricao b {
    display: none; /* Remove bold tags from display */
}

/* Responsive */
@media (min-width: 768px) {
    .card-pedir-novamente .card-img-wrapper {
        height: 140px;
    }
    
    .pedir-novamente-title {
        font-size: 24px;
    }
}

/* Entry animation */
@keyframes slideInFromBottom {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

#pedir-novamente-container {
    animation: slideInFromBottom 0.5s ease-out;
}
</style>

<script>
// Script to manage Order Again
(function() {
    'use strict';
    
    const STORAGE_KEY_PREFIX = 'delivery_frequent_items';
    const STORAGE_STATS_KEY = 'delivery_client_stats';
    
    /**
     * Validates if items from localStorage are still active
     * Makes an AJAX request to check item_ativo and categoria_ativa status
     * @param {Array} items - Items from localStorage
     * @returns {Promise<Array>} - Only active items (both item and category active)
     */
    async function validateActiveItems(items) {
        if (!items || items.length === 0) return [];
        
        try {
            const itemIds = items.map(item => item.item_id).join(',');
            const ajaxUrl = `${baseUri}/index/validate_items?ids=${itemIds}`;
            
            const response = await fetch(ajaxUrl);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const responseText = await response.text();
            let validationData;
            
            try {
                validationData = JSON.parse(responseText);
            } catch (e) {
                console.error('[PEDIR_NOVAMENTE] Failed to parse validation response');
                throw e;
            }
            
            const validationMap = {};
            validationData.forEach(v => {
                validationMap[v.item_id] = v;
            });
            
            const validatedItems = items.filter(item => {
                const validation = validationMap[parseInt(item.item_id)];
                if (!validation) return false;
                
                const isItemActive = validation.item_ativo === 1;
                const isCategoryActive = validation.categoria_ativa === 1;
                const isValid = validation.is_valid === true;
                
                return isValid && isItemActive && isCategoryActive;
            });
            
            if (validatedItems.length !== items.length) {
                saveToLocalStorage(validatedItems);
            }
            
            return validatedItems;
        } catch (error) {
            console.error('[PEDIR_NOVAMENTE] Validation error:', error);
            
            return items.filter(item => {
                if (typeof item.item_ativo !== 'undefined' && item.item_ativo != 1) return false;
                if (typeof item.categoria_ativa !== 'undefined' && item.categoria_ativa != 1) return false;
                return true;
            });
        }
    }
    
    const serverItems = <?= !empty($itensFrequentes) ? json_encode($itensFrequentes) : 'null' ?>;
    const clienteId = <?= $cliente_id > 0 ? $cliente_id : '0' ?>;
    const baseUri = '<?= $baseUri ?>';
    const sessionBase = '<?= $_SESSION['base_delivery'] ?? '' ?>';
    const semFoto = '<?= $semFoto ?>';
    
    // Unique storage key per store (token) - CRITICAL for multi-store isolation
    const STORAGE_KEY = STORAGE_KEY_PREFIX + '_' + sessionBase;
    
    function saveToLocalStorage(items) {
        try {
            const dataToSave = {
                items: items,
                timestamp: new Date().getTime(),
                clienteId: clienteId,
                storeToken: sessionBase // CRITICAL: Save store token
            };
            localStorage.setItem(STORAGE_KEY, JSON.stringify(dataToSave));
        } catch (e) {
            console.warn('[PEDIR_NOVAMENTE] Error saving to localStorage:', e);
        }
    }
    
    function getFromLocalStorage() {
        try {
            const data = localStorage.getItem(STORAGE_KEY);
            if (!data) return null;
            
            const parsed = JSON.parse(data);
            const sevenDays = 7 * 24 * 60 * 60 * 1000;
            
            // CRITICAL: Validate store token to prevent cross-store data leakage
            if (parsed.storeToken && parsed.storeToken !== sessionBase) {
                localStorage.removeItem(STORAGE_KEY);
                return null;
            }
            
            if (new Date().getTime() - parsed.timestamp > sevenDays) {
                localStorage.removeItem(STORAGE_KEY);
                return null;
            }
            
            return parsed.items;
        } catch (e) {
            console.warn('[PEDIR_NOVAMENTE] Error reading from localStorage:', e);
            return null;
        }
    }
    
    function mergeItems(serverItems, localItems) {
        if (!localItems || localItems.length === 0) return serverItems || [];
        if (!serverItems || serverItems.length === 0) return localItems;
        
        const merged = [...serverItems];
        const serverIds = new Set(serverItems.map(item => item.item_id));
        
        localItems.forEach(item => {
            if (!serverIds.has(item.item_id) && merged.length < 6) {
                merged.push(item);
            }
        });
        
        return merged.slice(0, 6);
    }
    
    function renderItems(items) {
        if (!items || items.length === 0) {
            document.getElementById('pedir-novamente-container').classList.add('hidden');
            return;
        }
        
        // SAFETY: Double-check for active items and categories
        // Filter out any items that shouldn't be displayed
        const safeItems = items.filter(item => {
            if (typeof item.item_ativo !== 'undefined') {
                if (item.item_ativo != 1 && item.item_ativo !== '1') {
                    return false;
                }
            }
            
            if (typeof item.categoria_ativa !== 'undefined') {
                if (item.categoria_ativa != 1 && item.categoria_ativa !== '1') {
                    return false;
                }
            }
            
            return true;
        });
        
        if (safeItems.length === 0) {
            document.getElementById('pedir-novamente-container').classList.add('hidden');
            return;
        }
        
        const carousel = document.getElementById('pedirNovamenteCarousel');
        const template = document.getElementById('item-frequente-template');
        
        if (!carousel || !template) return;
        
        // Destroy previous Slick instance if exists
        if ($(carousel).hasClass('slick-initialized')) {
            $(carousel).slick('unslick');
        }
        
        carousel.innerHTML = '';
        
        safeItems.forEach((item) => {
            const clone = template.content.cloneNode(true);
            const card = clone.querySelector('.card-pedir-novamente');
            
            let itemFoto = semFoto;
            if (item.item_foto) {
                itemFoto = `${baseUri}/assets/item/${sessionBase}/${item.item_foto}`;
            }
            
            card.setAttribute('data-id', item.item_id);
            card.querySelector('.item-image').src = itemFoto;
            card.querySelector('.item-image').alt = item.item_nome || '';
            card.querySelector('.item-categoria').textContent = item.categoria_nome || '';
            card.querySelector('.item-nome').textContent = item.item_nome || '';
            
            // Show last order description - now formatted from database
            const descElement = card.querySelector('.item-descricao');
            
            if (item.last_order_desc && item.last_order_desc.trim() !== '') {
                // Keep <br> tags but remove <b> tags
                const formattedDesc = item.last_order_desc
                    .replace(/<b>/g, '')
                    .replace(/<\/b>/g, '')
                    .replace(/,\s*<br>/g, '<br>') // Clean up comma before line break
                    .replace(/,\s*$/, '') // Remove trailing comma
                    .trim();
                
                descElement.innerHTML = formattedDesc;
                descElement.style.display = 'block';
                descElement.style.visibility = 'visible';
            } else {
                descElement.style.display = 'none';
            }
            
            card.querySelector('.item-preco').textContent = 'R$ ' + parseFloat(item.item_preco || 0).toFixed(2).replace('.', ',');
            
            // DECLARAR estoque ANTES de usar
            const estoque = parseInt(item.item_estoque) || 0;
            
            const btnAdd = card.querySelector('.btn-pedir-novamente');
            
            // Get last_lista_id from item data (comes from server)
            const listaId = item.last_lista_id || '';
            
            // Configure button to call addPedirNovamenteToCart with lista_id
            btnAdd.setAttribute('data-id', item.item_id);
            btnAdd.setAttribute('data-lista-id', listaId);
            
            // Set onclick handler to add directly to cart
            btnAdd.onclick = function(e) {
                e.preventDefault();
                const itemId = this.getAttribute('data-id');
                const listaId = this.getAttribute('data-lista-id');
                
                if (window.addPedirNovamenteToCart) {
                    window.addPedirNovamenteToCart(itemId, listaId);
                } else {
                    console.error('[PEDIR_NOVAMENTE] addPedirNovamenteToCart function not found');
                    alert('Erro: Função não carregada. Recarregue a página.');
                }
                return false;
            };
            
            if (estoque <= 0) {
                btnAdd.classList.add('btn-disabled');
                btnAdd.setAttribute('disabled', 'disabled');
                btnAdd.innerHTML = '<i class="fa fa-ban"></i> Indisponível';
                btnAdd.title = 'Item indisponível';
            }
            
            carousel.appendChild(clone);
        });
        
        // CRITICAL: Initialize Slick with proper timing to prevent breaking
        // Show container immediately, then init Slick
        document.getElementById('pedir-novamente-container').classList.remove('hidden');
        
        // Wait for next frame to ensure DOM is fully updated
        setTimeout(() => {
            if (carousel.children.length === 0) {
                console.warn('[PEDIR_NOVAMENTE] No children in carousel');
                document.getElementById('pedir-novamente-container').classList.add('hidden');
                return;
            }
            
            // Check if Slick is available
            if (typeof $ === 'undefined' || typeof $.fn.slick === 'undefined') {
                console.error('[PEDIR_NOVAMENTE] Slick or jQuery not loaded!');
                return;
            }
            
            try {
                // Initialize Slick carousel
                $(carousel).slick({
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    infinite: true,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    arrows: false,
                    dots: false,
                    pauseOnHover: true,
                    pauseOnFocus: false,
                    adaptiveHeight: false,
                    responsive: [
                        {
                            breakpoint: 9999,
                            settings: {
                                slidesToShow: 4,
                                slidesToScroll: 4
                            }
                        },
                        {
                            breakpoint: 900,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        }
                    ]
                });
            } catch (error) {
                console.error('[PEDIR_NOVAMENTE] ❌ Slick init error:', error);
            }
        }, 50);
    }
    
    async function init() {
        let itemsToRender = [];
        
        if (clienteId > 0 && serverItems && serverItems.length > 0) {
            itemsToRender = await validateActiveItems(serverItems);
            saveToLocalStorage(itemsToRender);
        } else {
            const localItems = getFromLocalStorage();
            
            if (localItems && localItems.length > 0) {
                itemsToRender = await validateActiveItems(localItems);
            } else {
                itemsToRender = [];
            }
        }
        
        if (itemsToRender && itemsToRender.length > 0) {
            renderItems(itemsToRender);
        } else {
            document.getElementById('pedir-novamente-container').classList.add('hidden');
        }
    }
    
    function trackItemAdd(itemId) {
        try {
            const items = getFromLocalStorage() || [];
            const itemIndex = items.findIndex(i => i.item_id === itemId);
            
            if (itemIndex !== -1) {
                items[itemIndex].frequencia = (parseInt(items[itemIndex].frequencia) || 0) + 1;
            }
            
            saveToLocalStorage(items);
        } catch (e) {
            console.warn('Error tracking item:', e);
        }
    }
    
    window.pedirNovamente = {
        init: init,
        trackItemAdd: trackItemAdd,
        refresh: function() {
            // Force re-validation and refresh
            init();
        },
        clearCache: function() {
            // Clear localStorage cache and reload from server
            localStorage.removeItem(STORAGE_KEY);
            localStorage.removeItem(STORAGE_STATS_KEY);
            
            // Re-initialize with fresh server data
            init();
            
            return 'Cache cleared! Reloading...';
        },
        forceValidation: async function() {
            // Force validation of current items
            const localItems = getFromLocalStorage();
            if (localItems && localItems.length > 0) {
                const validItems = await validateActiveItems(localItems);
                renderItems(validItems);
                return `Validated: ${validItems.length} of ${localItems.length} items are active`;
            }
            return 'No items to validate';
        },
    };
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
})();
</script>