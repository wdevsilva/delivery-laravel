<?php
/**
 * Banner de Promoções Ativas
 * Mostra as promoções ativas para o cliente
 */

// Filtrar apenas promoções ativas para o dia atual
$dia_atual = date('w'); // 0 = Domingo, 6 = Sábado
$promocoes_ativas = [];

if (!empty($data['promocoes'])) {
    foreach ($data['promocoes'] as $promo) {
        // Verificar se está ativa para o dia atual
        // Agora o filtro já vem aplicado do model, mas mantemos verificação adicional
        if (empty($promo->promocao_dias_semana)) {
            // Se não tiver dias definidos, não exibir
            continue;
        }
        
        $dias = explode(',', $promo->promocao_dias_semana);
        if (in_array($dia_atual, $dias)) {
            $promocoes_ativas[] = $promo;
        }
    }
}

if (empty($promocoes_ativas)) {
    return; // Não mostrar nada se não houver promoções
}

// Buscar nomes das categorias e produtos para exibição
$categorias_map = [];
if (!empty($data['categoria'])) {
    foreach ($data['categoria'] as $cat) {
        $categorias_map[$cat->categoria_id] = $cat->categoria_nome;
    }
}
// Buscar categorias das promoções que não estão no map (suporte a múltiplas categorias)
foreach ($promocoes_ativas as $promo) {
    if ($promo->promocao_tipo == 'quantidade_categoria' && !empty($promo->promocao_categoria)) {
        // Pode ser múltiplas categorias separadas por vírgula
        $cat_ids = explode(',', $promo->promocao_categoria);
        foreach ($cat_ids as $cat_id) {
            $cat_id = trim($cat_id);
            if (!isset($categorias_map[$cat_id])) {
                $cat_db = (new Factory('categoria'))->where("categoria_id = {$cat_id}")->get();
                if (!empty($cat_db[0])) {
                    $categorias_map[$cat_id] = $cat_db[0]->categoria_nome;
                }
            }
        }
    }
}
?>

<style>
/* Banner de Promoções */
.promocoes-banner {
    margin: 10px 0 15px;
    padding: 0;
}

.promocoes-banner .section-title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0;
    padding: 10px 15px;
    font-size: 16px;
    font-weight: 600;
    color: #fff;
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.promocoes-banner .section-title:hover {
    opacity: 0.95;
}

.promocoes-banner .section-title .title-left {
    display: flex;
    align-items: center;
    gap: 8px;
}

.promocoes-banner .section-title .title-left i {
    font-size: 18px;
}

.promocoes-banner .section-title .badge-count {
    background: rgba(255,255,255,0.3);
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 12px;
    margin-left: 8px;
}

.promocoes-banner .section-title .toggle-icon {
    transition: transform 0.3s ease;
}

.promocoes-banner .section-title.collapsed .toggle-icon {
    transform: rotate(-90deg);
}

.promocoes-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.promocoes-content.expanded {
    max-height: 500px;
    padding-top: 12px;
}

.promocoes-slider {
    display: flex;
    gap: 12px;
    overflow-x: auto;
    overflow-y: hidden;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
    scrollbar-color: rgba(255,107,53,0.3) transparent;
    padding: 5px 0 10px;
    cursor: grab;
}

.promocoes-slider:active {
    cursor: grabbing;
}

.promocoes-slider::-webkit-scrollbar {
    height: 4px;
}

.promocoes-slider::-webkit-scrollbar-track {
    background: rgba(0,0,0,0.05);
    border-radius: 10px;
}

.promocoes-slider::-webkit-scrollbar-thumb {
    background: rgba(255,107,53,0.4);
    border-radius: 10px;
}

.promocoes-slider::-webkit-scrollbar-thumb:hover {
    background: rgba(255,107,53,0.6);
}

.promo-card {
    flex: 0 0 auto;
    width: 280px;
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    border-radius: 12px;
    padding: 15px;
    color: white;
    scroll-snap-align: start;
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
    transition: transform 0.2s ease;
}

.promo-card:hover {
    transform: translateY(-2px);
}

.promo-card.tipo-valor_minimo {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.promo-card.tipo-produto_especifico {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    box-shadow: 0 4px 15px rgba(17, 153, 142, 0.3);
}

.promo-card.tipo-combo {
    background: linear-gradient(135deg, #e91e63 0%, #ff5722 100%);
    box-shadow: 0 4px 15px rgba(233, 30, 99, 0.3);
}

.promo-card-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
    position: relative;
}

.promo-card-header i {
    font-size: 24px;
    opacity: 0.9;
}

.promo-card-header span {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.9;
    font-weight: 500;
    flex: 1;
}

.promo-info-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 18px;
    height: 18px;
    background: rgba(255,255,255,0.25);
    border-radius: 50%;
    font-size: 12px;
    cursor: help;
    position: relative;
    font-style: normal;
}

.promo-info-icon:hover .promo-tooltip {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(0);
}

.promo-tooltip {
    position: absolute;
    bottom: calc(100% + 8px);
    left: 50%;
    transform: translateX(-50%) translateY(-5px);
    padding: 8px 12px;
    background: rgba(0,0,0,0.95);
    color: white;
    font-size: 11px;
    border-radius: 6px;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.2s ease;
    z-index: 1000;
    pointer-events: none;
    font-weight: normal;
    text-transform: none;
    letter-spacing: normal;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
}

.promo-tooltip::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 5px solid transparent;
    border-top-color: rgba(0,0,0,0.95);
}

.promo-card-title {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 8px;
    line-height: 1.3;
}

.promo-card-desc {
    font-size: 13px;
    opacity: 0.95;
    line-height: 1.4;
    margin-bottom: 10px;
}

.promo-card-desc strong {
    font-weight: 600;
}

.promo-card-premio {
    background: rgba(255,255,255,0.2);
    border-radius: 8px;
    padding: 8px 10px;
    font-size: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
}

.promo-card-premio i {
    font-size: 16px;
}

.promo-card-premio strong {
    font-weight: 600;
}

.promo-card-estoque-aviso {
    font-size: 10px;
    opacity: 0.8;
    font-style: italic;
    display: flex;
    align-items: center;
    gap: 5px;
    margin-top: -5px;
    margin-bottom: 8px;
    padding: 5px 8px;
    background: rgba(255,255,255,0.15);
    border-radius: 6px;
}

.promo-card-estoque-aviso i {
    font-size: 11px;
}

.promo-card-regras {
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid rgba(255,255,255,0.2);
}

.regras-title {
    font-size: 11px;
    font-weight: 600;
    opacity: 0.9;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.regras-list {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.regra-item {
    font-size: 10px;
    opacity: 0.85;
    display: flex;
    align-items: center;
    gap: 6px;
    line-height: 1.3;
}

.regra-item i {
    font-size: 11px;
    opacity: 0.8;
}

@media (max-width: 480px) {
    .promo-card {
        width: 250px;
    }
    
    .promo-card-title {
        font-size: 14px;
    }
}
</style>

<div class="promocoes-banner">
    <div class="section-title collapsed" onclick="togglePromocoes(this)">
        <span class="title-left">
            <i class="fa fa-star"></i> 
            Promoções do Dia
            <span class="badge-count"><?= count($promocoes_ativas) ?></span>
        </span>
        <i class="fa fa-chevron-down toggle-icon"></i>
    </div>
    
    <div class="promocoes-content" id="promocoes-content">
        <div class="promocoes-slider">
        <?php foreach ($promocoes_ativas as $promo): 
            // Determinar tipo e construir descrição
            $tipo = $promo->promocao_tipo;
            $icone = 'fa-gift';
            $tipo_label = 'Promoção';
            $descricao = '';
            
            switch ($tipo) {
                case 'quantidade_categoria':
                    $icone = 'fa-th-large';
                    $tipo_label = 'Por Categoria';
                    $tipo_explicacao = 'Compre a quantidade mínima de itens da categoria e ganhe o brinde';
                    
                    // Suporte a múltiplas categorias (separadas por vírgula)
                    $cat_ids = explode(',', $promo->promocao_categoria ?? '');
                    $cat_nomes = [];
                    foreach ($cat_ids as $cid) {
                        $cid = trim($cid);
                        if (isset($categorias_map[$cid])) {
                            $cat_nomes[] = $categorias_map[$cid];
                        }
                    }
                    $cat_nome = !empty($cat_nomes) ? implode(' ou ', $cat_nomes) : 'itens';
                    
                    $qtd = $promo->promocao_qtd_compra ?? 2;
                    $descricao = "<strong>{$qtd}</strong> " . ($qtd > 1 ? 'itens' : 'item') . " de <strong>{$cat_nome}</strong>";
                    break;
                    
                case 'valor_minimo':
                    $icone = 'fa-dollar';
                    $tipo_label = 'Valor Mínimo';
                    $tipo_explicacao = 'Atinja o valor mínimo em compras e ganhe o brinde';
                    $valor = number_format($promo->promocao_valor_minimo ?? 0, 2, ',', '.');
                    $descricao = "Em compras acima de <strong>R$ {$valor}</strong>";
                    break;
                    
                case 'produto_especifico':
                    $icone = 'fa-shopping-basket';
                    $tipo_label = 'Produto';
                    $tipo_explicacao = 'Compre o produto específico e ganhe o brinde';
                    $produtos = json_decode($promo->promocao_produtos_compra ?? '[]', true);
                    
                    if (!empty($produtos)) {
                        // O JSON vem como array direto [{...}] para produto_especifico
                        $lista = $produtos;
                        
                        if (!empty($lista[0]['id'])) {
                            $prod_id = (int)$lista[0]['id'];
                            
                            // Buscar nome e categoria do produto direto do banco
                            $item_db = (new Factory('item'))
                                ->select('item_nome, c.categoria_nome')
                                ->join('categoria c', 'c.categoria_id = item_categoria')
                                ->where("item_id = {$prod_id}")
                                ->get();
                            
                            if (!empty($item_db[0])) {
                                $nome_completo = $item_db[0]->item_nome . ' (' . $item_db[0]->categoria_nome . ')';
                                $descricao = "<strong>" . htmlspecialchars($nome_completo) . "</strong>";
                            } else {
                                $descricao = "<strong>o produto específico</strong>";
                            }
                        } else {
                            $descricao = "<strong>o produto específico</strong>";
                        }
                    } else {
                        $descricao = "<strong>o produto específico</strong>";
                    }
                    break;
                    
                case 'combo':
                    $icone = 'fa-cubes';
                    $tipo_label = 'Combo';
                    $tipo_explicacao = 'Monte o combo com os produtos listados e ganhe o brinde';
                    $produtos = json_decode($promo->promocao_produtos_compra ?? '[]', true);
                    $lista = isset($produtos['produtos']) ? $produtos['produtos'] : $produtos;
                    if (!empty($lista) && count($lista) >= 2) {
                        $nomes = [];
                        foreach (array_slice($lista, 0, 2) as $p) {
                            // Buscar nome e categoria do produto do banco
                            if (!empty($p['id'])) {
                                $item_db = (new Factory('item'))
                                    ->select('item_nome, c.categoria_nome')
                                    ->join('categoria c', 'c.categoria_id = item_categoria')
                                    ->where("item_id = {$p['id']}")
                                    ->get();
                                if (!empty($item_db[0])) {
                                    $nomes[] = $item_db[0]->item_nome . ' (' . $item_db[0]->categoria_nome . ')';
                                } else {
                                    $nomes[] = $p['nome'] ?? '?';
                                }
                            } else {
                                $nomes[] = $p['nome'] ?? '?';
                            }
                        }
                        $descricao = "<strong>" . implode('</strong> + <strong>', $nomes) . "</strong>";
                        if (count($lista) > 2) {
                            $descricao .= " + mais " . (count($lista) - 2);
                        }
                    } else {
                        $descricao = "Monte seu combo";
                    }
                    break;
            }
            
            // Nome do prêmio
            $premio_nome = $promo->promocao_premio_produto ?: ($promo->premio_produto_nome ?? 'Brinde');
            // Adicionar categoria se existir
            if (!empty($promo->premio_categoria_nome)) {
                $premio_nome .= ' (' . $promo->premio_categoria_nome . ')';
            }
            $premio_qtd = $promo->promocao_premio_qtd ?? 1;
            
            // Verificar se tem regras para exibir
            $tem_regras = !empty($promo->promocao_data_inicio) || !empty($promo->promocao_data_fim) 
                       || !empty($promo->promocao_limite_uso) || !empty($promo->promocao_limite_cliente);
            
            // Verifica se desconta estoque e se tem item vinculado
            $desconta_estoque = !empty($promo->promocao_desconta_estoque) && !empty($promo->promocao_premio_item_id);
        ?>
        <div class="promo-card tipo-<?= $tipo ?>">
            <div class="promo-card-header">
                <i class="fa <?= $icone ?>"></i>
                <span><?= $tipo_label ?></span>
            </div>
            
            <div class="promo-card-title">
                <?= htmlspecialchars($promo->promocao_titulo) ?>
            </div>
            
            <div class="promo-card-desc">
                <?= $promo->promocao_descricao ?> <?= $descricao ?> <?= $promo->promocao_descricao_fim ?>
            </div>
            
            <div class="promo-card-premio">
                <i class="fa fa-gift"></i>
                <span>Ganhe: <strong><?= $premio_qtd > 1 ? $premio_qtd . 'x ' : '' ?><?= htmlspecialchars($premio_nome) ?></strong></span>
            </div>
            
            <?php if ($desconta_estoque): ?>
            <div class="promo-card-estoque-aviso">
                <i class="fa fa-clock-o"></i> <em>Válido enquanto durar o estoque</em>
            </div>
            <?php endif; ?>
            
            <?php if ($tem_regras): ?>
            <div class="promo-card-regras">
                <div class="regras-title"><i class="fa fa-info-circle"></i> Regras</div>
                <div class="regras-list">
                    <?php if (!empty($promo->promocao_limite_uso)): ?>
                        <div class="regra-item">
                            <i class="fa fa-users"></i> Limite: <?= $promo->promocao_limite_uso ?> usos no total
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($promo->promocao_limite_cliente)): ?>
                        <div class="regra-item">
                            <i class="fa fa-user"></i> Máximo: <?= $promo->promocao_limite_cliente ?> por cliente
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($promo->promocao_data_inicio) || !empty($promo->promocao_data_fim)): ?>
                        <div class="regra-item">
                            <i class="fa fa-calendar"></i> 
                            <?php if (!empty($promo->promocao_data_inicio) && !empty($promo->promocao_data_fim)): ?>
                                Válida de <?= date('d/m/Y', strtotime($promo->promocao_data_inicio)) ?> até <?= date('d/m/Y', strtotime($promo->promocao_data_fim)) ?>
                            <?php elseif (!empty($promo->promocao_data_inicio)): ?>
                                Válida a partir de <?= date('d/m/Y', strtotime($promo->promocao_data_inicio)) ?>
                            <?php else: ?>
                                Válida até <?= date('d/m/Y', strtotime($promo->promocao_data_fim)) ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
function togglePromocoes(element) {
    element.classList.toggle('collapsed');
    var content = document.getElementById('promocoes-content');
    content.classList.toggle('expanded');
}

// Drag to scroll com mouse
window.addEventListener('DOMContentLoaded', function() {
    const slider = document.querySelector('.promocoes-slider');
    if (!slider) return;
    
    let isDown = false;
    let startX;
    let scrollLeft;
    
    slider.addEventListener('mousedown', (e) => {
        isDown = true;
        slider.style.cursor = 'grabbing';
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });
    
    slider.addEventListener('mouseleave', () => {
        isDown = false;
        slider.style.cursor = 'grab';
    });
    
    slider.addEventListener('mouseup', () => {
        isDown = false;
        slider.style.cursor = 'grab';
    });
    
    slider.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 2; // Multiplicador para velocidade
        slider.scrollLeft = scrollLeft - walk;
    });
});
</script>
