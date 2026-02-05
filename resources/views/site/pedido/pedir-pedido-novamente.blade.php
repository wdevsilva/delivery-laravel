<?php
/**
 * Component: Pedir Pedido Novamente (Re-order Complete Orders)
 * Displays customer's recent complete orders to facilitate reordering
 * 
 * NEW BEHAVIOR:
 * - Shows complete recent orders (not individual items)
 * - Clicking "Pedir Novamente" adds ALL items from that order to cart
 * - Shows order summary: items count, total, date
 * - Only shows orders with all items still active
 */

$pedidosRecentes = $data['pedidosRecentes'] ?? [];
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
    
    <div class="pedir-novamente-slick" id="pedirNovamenteCarousel" aria-label="Carrossel de pedidos recentes">
        <!-- Orders will be injected via JavaScript -->
    </div>
</div>

<!-- HTML Template for each order (used by JavaScript) -->
<template id="pedido-recente-template">
    <article class="card-pedido-novamente" data-pedido-id="">
        <div class="card-img-wrapper">
            <img src="" alt="" class="pedido-image">
            <div class="badge-frequente-wrapper">
                <span class="badge-frequente">
                    <i class="fa fa-star"></i> <span class="frequencia-text">Você adora</span>
                </span>
            </div>
        </div>
        <div class="card-body-pedido">
            <div class="pedido-info">
                <div class="pedido-items">
                    <i class="fa fa-list"></i>
                    <span class="items-count"></span> itens
                </div>
                <div class="pedido-resumo"></div>
                <div class="pedido-total">
                    Total: <span class="valor-total"></span>
                </div>
            </div>
            <button class="btn-pedir-pedido-novamente"
                title="repetir este pedido">
                <i class="fa fa-refresh"></i> Pedir Novamente
            </button>
        </div>
    </article>
</template>

<style>
/* Styles for Complete Order Cards */
#pedir-novamente-container {
    display: block;
    width: 100%;
    margin: 30px 0;
    padding: 0;
    overflow: hidden;
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

.pedir-novamente-slick {
    margin: 0;
    padding: 10px 0;
    min-height: 200px;
    width: 100%;
    display: block;
}

.pedir-novamente-slick .slick-list {
    margin: 0 -6px;
}

.pedir-novamente-slick .slick-slide {
    padding: 0 6px;
}

.pedir-novamente-slick .slick-track {
    display: flex !important;
    align-items: stretch;
}

.pedir-novamente-slick .slick-slide {
    height: auto;
    display: flex !important;
    box-sizing: border-box;
}

.pedir-novamente-slick .slick-slide > div {
    height: 100%;
    width: 100%;
    display: flex !important;
}

/* Slick dots styling */
.pedir-novamente-slick .slick-dots {
    bottom: -30px;
}

.pedir-novamente-slick .slick-dots li button:before {
    font-size: 10px;
    color: #c62828;
    opacity: 0.3;
}

.pedir-novamente-slick .slick-dots li.slick-active button:before {
    opacity: 1;
    color: #c62828;
}

/* Slick arrows styling */
.pedir-novamente-slick .slick-prev,
.pedir-novamente-slick .slick-next {
    z-index: 10;
}

.pedir-novamente-slick .slick-prev {
    left: -20px;
}

.pedir-novamente-slick .slick-next {
    right: -20px;
}

.pedir-novamente-slick .slick-prev:before,
.pedir-novamente-slick .slick-next:before {
    color: #c62828;
    font-size: 24px;
}

.card-pedido-novamente {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    display: flex !important;
    flex-direction: column;
    height: 360px;
    max-width: 100%;
}

.card-pedido-novamente:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.card-pedido-novamente .card-img-wrapper {
    position: relative;
    width: 100%;
    height: 140px;
    overflow: hidden;
}

.card-pedido-novamente .card-img-wrapper img {
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

.frequencia-text {
    font-size: 10px;
}

.card-body-pedido {
    padding: 15px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.pedido-info {
    flex: 1;
    margin-bottom: 10px;
}

.pedido-items {
    font-size: 12px;
    color: #666;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.pedido-resumo {
    font-size: 11px;
    color: #333;
    margin: 8px 0;
    padding: 8px;
    background: #f5f5f5;
    border-radius: 6px;
    line-height: 1.4;
    max-height: 70px;
    overflow-y: auto;
    border-left: 3px solid #c62828;
}

.pedido-total {
    font-size: 16px;
    font-weight: 700;
    color: #c62828;
    margin-top: 8px;
}

.valor-total {
    font-size: 18px;
}

.btn-pedir-pedido-novamente {
    width: 100%;
    padding: 12px;
    background: #c62828;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.btn-pedir-pedido-novamente:hover {
    background: #a52222;
    transform: scale(1.02);
}

.btn-pedir-pedido-novamente i {
    font-size: 12px;
}

.btn-pedir-pedido-novamente.loading {
    background: #ccc;
    cursor: wait;
}

.btn-pedir-pedido-novamente.loading::after {
    content: "";
    margin-left: 8px;
    border: 2px solid #fff;
    border-radius: 50%;
    border-top: 2px solid #c62828;
    width: 14px;
    height: 14px;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive */
@media (min-width: 768px) {
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
(function() {
    'use strict';
    
    const serverPedidos = <?= !empty($pedidosRecentes) ? json_encode($pedidosRecentes) : 'null' ?>;
    const clienteId = <?= $cliente_id > 0 ? $cliente_id : '0' ?>;
    const baseUri = '<?= $baseUri ?>';
    
    /**
     * Format date to Brazilian format
     */
    function formatDate(dateString) {
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        return `${day}/${month}/${year} ${hours}:${minutes}`;
    }
    
    /**
     * Format currency to Brazilian Real
     */
    function formatCurrency(value) {
        const num = parseFloat(value);
        if (isNaN(num)) return 'R$ 0,00';
        return 'R$ ' + num.toFixed(2).replace('.', ',');
    }
    
    /**
     * Add complete order to cart
     */
    async function addPedidoToCart(pedidoId, button) {
        if (!pedidoId) {
            alert('Erro: ID do pedido não encontrado.');
            return;
        }
        
        // Disable button and show loading
        button.disabled = true;
        button.classList.add('loading');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fa fa-spinner"></i> Adicionando...';
        
        try {
            // Fetch all items from this order
            const response = await fetch(`${baseUri}/index/get_pedido_items?pedido_id=${pedidoId}`);
            const data = await response.json();
            
            if (data.error) {
                throw new Error(data.error);
            }
            
            if (!data.items || data.items.length === 0) {
                throw new Error('Nenhum item encontrado no pedido.');
            }
            
            // Add each item to cart with correct quantity
            let addedCount = 0;
            for (const item of data.items) {
                // Calculate extra_preco from extra_vals
                let extraPreco = 0;
                if (item.lista_item_extra_vals) {
                    const vals = item.lista_item_extra_vals.split(',');
                    vals.forEach(val => {
                        const v = parseFloat(val.trim());
                        if (!isNaN(v)) {
                            extraPreco += v;
                        }
                    });
                }
                
                const cartData = {
                    item_id: item.item_id,
                    item_nome: item.item_nome,
                    item_codigo: item.item_codigo || '',
                    item_estoque: item.item_estoque || 999,
                    categoria_id: item.categoria_id,
                    categoria_nome: item.categoria_nome,
                    item_obs: item.lista_item_obs || '',
                    item_preco: parseFloat(item.item_preco) || 0,
                    extra: item.lista_item_extra || '',
                    extra_vals: item.lista_item_extra_vals || '',
                    extra_preco: extraPreco,
                    total: parseFloat(item.item_preco_total) / parseFloat(item.qtde) || 0,
                    qtde: parseInt(item.qtde) || 1
                };
                
                // Add to cart with quantity
                const addUrl = baseUri + "/carrinho/add/";
                await $.post(addUrl, cartData);
                addedCount++;
            }
            
            // Reload cart display
            if (typeof rebind_reload === 'function') {
                rebind_reload();
            }
            
            // Show success
            button.innerHTML = '<i class="fa fa-check"></i> Adicionado!';
            button.style.background = '#4caf50';
            
            // Show cart modal after a short delay
            setTimeout(function() {
                $("#modal-carrinho").modal("show");
                if (typeof sound === 'function') {
                    sound();
                }
                
                // Reset button after modal is shown
                setTimeout(function() {
                    button.disabled = false;
                    button.classList.remove('loading');
                    button.style.background = '';
                    button.innerHTML = originalText;
                }, 2000);
            }, 500);
            
        } catch (error) {
            console.error('[PEDIR_NOVAMENTE] Error adding order to cart:', error);
            alert('Erro ao adicionar pedido ao carrinho: ' + error.message);
            button.disabled = false;
            button.classList.remove('loading');
            button.innerHTML = originalText;
        }
    }
    
    /**
     * Render orders on the page
     */
    function renderOrders(pedidos) {
        if (!pedidos || pedidos.length === 0) {
            document.getElementById('pedir-novamente-container').classList.add('hidden');
            return;
        }
        
        const carousel = document.getElementById('pedirNovamenteCarousel');
        const template = document.getElementById('pedido-recente-template');
        
        if (!carousel || !template) return;
        
        // Destroy previous Slick instance if exists
        if ($(carousel).hasClass('slick-initialized')) {
            $(carousel).slick('unslick');
        }
        
        carousel.innerHTML = '';
        
        pedidos.forEach((pedido) => {
            const clone = template.content.cloneNode(true);
            const card = clone.querySelector('.card-pedido-novamente');
            
            card.setAttribute('data-pedido-id', pedido.pedido_id);
            
            // Set image
            const img = card.querySelector('.pedido-image');
            const sessionBase = '<?= $_SESSION['base_delivery'] ?? '' ?>';
            const semFoto = baseUri + '/assets/item/semfoto.jpg';
            
            if (pedido.first_item_foto) {
                img.src = baseUri + '/assets/item/' + sessionBase + '/' + pedido.first_item_foto;
            } else {
                img.src = semFoto;
            }
            img.alt = 'Pedido #' + pedido.pedido_id;
            
            // Set frequencia badge text
            const badgeText = card.querySelector('.frequencia-text');
            const freq = parseInt(pedido.frequencia) || 1;
            if (freq > 1) {
                badgeText.textContent = `Você pediu ${freq}x`;
            } else {
                badgeText.textContent = 'Você adora';
            }
            
            card.querySelector('.items-count').textContent = pedido.total_items;
            
            // Format items with extras (no prices in the card display)
            const resumoElement = card.querySelector('.pedido-resumo');
            if (pedido.items_resumo) {
                const items = pedido.items_resumo.split('##');
                let formattedHtml = '';
                items.forEach(item => {
                    const parts = item.split('||');
                    const itemName = parts[0];
                    const extras = parts[1] || '';
                    
                    formattedHtml += `<div style="margin-bottom:6px;">`;
                    formattedHtml += `<strong>${itemName}</strong>`;
                    if (extras) {
                        formattedHtml += ` <small style="color:#666;font-size:10px;">(${extras})</small>`;
                    }
                    formattedHtml += `</div>`;
                });
                resumoElement.innerHTML = formattedHtml;
            } else {
                resumoElement.textContent = 'Sem descrição';
            }
            
            card.querySelector('.valor-total').textContent = formatCurrency(pedido.pedido_total);
            
            const btnAdd = card.querySelector('.btn-pedir-pedido-novamente');
            btnAdd.onclick = function(e) {
                e.preventDefault();
                const pedidoId = card.getAttribute('data-pedido-id');
                addPedidoToCart(pedidoId, this);
                return false;
            };
            
            carousel.appendChild(clone);
        });
        
        // Show container
        document.getElementById('pedir-novamente-container').classList.remove('hidden');
        
        // Initialize Slick carousel
        setTimeout(function() {
            try {
                $(carousel).slick({
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true,
                    autoplay: true,
                    autoplaySpeed: 4000,
                    arrows: false,
                    dots: false,
                    pauseOnHover: true,
                    pauseOnFocus: true,
                    adaptiveHeight: true,
                    mobileFirst: true,
                    variableWidth: false,
                    centerMode: false,
                    responsive: [
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
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
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 4,
                                slidesToScroll: 4
                            }
                        }
                    ]
                });
            } catch (error) {
                console.error('[PEDIR_NOVAMENTE] Slick init error:', error);
            }
        }, 50);
    }
    
    /**
     * Initialize
     */
    function init() {
        if (clienteId > 0 && serverPedidos && serverPedidos.length > 0) {
            renderOrders(serverPedidos);
        } else {
            document.getElementById('pedir-novamente-container').classList.add('hidden');
        }
    }
    
    // Expose globally
    window.pedirPedidoNovamente = {
        init: init,
        addPedidoToCart: addPedidoToCart
    };
    
    // Auto-initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
