@php

// Garante que as variáveis necessárias existem
if (!isset($item) || !isset($opcoes) || !isset($meia)) {
    return;
}

// Prepara variáveis
$item_id = is_object($item) ? $item->item_id : $item['item_id'];
$item_nome = is_object($item) ? $item->item_nome : $item['item_nome'];
$item_obs = is_object($item) ? $item->item_obs : $item['item_obs'];
$item_preco = is_object($item) ? $item->item_preco : $item['item_preco'];
$item_estoque = is_object($item) ? intval($item->item_estoque) : intval($item['item_estoque']);
$item_codigo = is_object($item) ? $item->item_codigo : $item['item_codigo'];
$item_foto = is_object($item) ? $item->item_foto : $item['item_foto'];
$categoria_id = is_object($item) ? $item->categoria_id : $item['categoria_id'];
$categoria_nome_item = is_object($item) ? ($item->categoria_nome ?? '') : ($item['categoria_nome'] ?? '');

// Para "mais vendidos", categoria pode vir diferente
if (empty($categoria_nome_item) && isset($item['categoria'])) {
    $categoria_nome_item = $item['categoria'];
}

$foto_url = "midias/item/" . session('base_delivery') . "/$item_foto";
@endphp
<div class="modal fade bs-example-modal-lg modal-itens" tabindex="-1" id="item-{{ $item_id }}" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" id="myNav">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title text-uppercase text-center">Detalhes e Opções</h5>
            </div>

            <!-- Ícone de sacola flutuante -->
            <div class="floating-cart-badge" id="floating-cart-{{ $item_id }}" title="Ver itens selecionados">
                <div class="cart-icon">
                    <i class="fa fa-shopping-bag"></i>
                    <span class="cart-count" id="cart-count-{{ $item_id }}">0</span>
                </div>
            </div>

            <!-- Popup de itens selecionados -->
            <div class="selected-items-popup" id="popup-{{ $item_id }}">
                <div class="selected-items-popup-header">
                    <span>Itens Selecionados</span>
                    <button class="close-popup" onclick="$('#popup-{{ $item_id }}').removeClass('show')">×</button>
                </div>
                <div class="selected-items-popup-body" id="popup-body-{{ $item_id }}">
                    <!-- Itens serão inseridos aqui via JS -->
                </div>
                <div class="selected-items-popup-footer" id="popup-footer-{{ $item_id }}">
                    <span class="total-label">Total:</span>
                    <span class="total-value" id="popup-total-{{ $item_id }}">R$ 0,00</span>
                </div>
            </div>

            <div class="modal-body">

                <!-- Informação do Produto - SEMPRE PRIMEIRO -->
                <div class="produto-info-header" style="background: #f8f9fa; padding: 16px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #e9ecef; display: block !important; visibility: visible !important; opacity: 1 !important;">
                    <div class="produto-nome" style="font-size: 18px; font-weight: 700; color: #333; margin-bottom: 8px;"><?= ucfirst(mb_strtolower($item_nome)) ?></div>
                    <?php if (!empty($item_obs)): ?>
                        <div class="produto-descricao" style="font-size: 13px; color: #28a745; line-height: 1.5; margin-bottom: 6px;"><strong>Ingredientes:</strong> <?= strip_tags($item_obs); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($item_desc)): ?>
                        <div class="produto-descricao" style="font-size: 13px; color: #28a745; line-height: 1.5; margin-bottom: 10px;"><strong>Descrição Breve:</strong> <?= strip_tags($item_desc); ?></div>
                    <?php endif; ?>
                    <div class="produto-preco" style="font-size: 24px; font-weight: 700; color: #28a745;">R$ <?= strip_tags(number_format($item_preco, 2, ',', '.')); ?></div>
                </div>

                <input type="hidden" id="divisao_valor_pizza" value="<?= $config->config_divisao_valor_pizza ?>">

                <?php if ($meia >= 1) { ?>
                    <input type="hidden" id="sabores-{{ $item_id }}" value="{{ $meia }}">

                    <!-- Seção de Sabores -->
                    <div class="opcoes-section">
                        <div class="opcoes-section-title">
                            <?php if ($meia > 1) { ?>
                                <span>Selecione até {{ $meia }} sabores</span>
                                <span class="badge-optional">Opcional</span>
                            <?php } else { ?>
                                <span>CATEGORIA: {{ $categoria_nome_item }}</span>
                            <?php } ?>
                        </div>
                        <?php if ($meia > 1) { ?>
                            <p style="font-size: 12px; color: #6c757d; margin-bottom: 12px;">
                                <?php if ($config->config_divisao_valor_pizza == 0) { ?>
                                    Será cobrado o preço do sabor com maior valor
                                <?php } else { ?>
                                    Será cobrado o preço médio proporcional
                                <?php } ?>
                            </p>
                        <?php } else { ?>
                            <p style="font-size: 11px; color: #999; margin: 8px 0 12px 0; font-style: italic;">
                                💡 Clique para desmarcar e escolher outro item
                            </p>
                        <?php } ?>

                        <?php
                        // Se itemAll existe, mostra lista de sabores (para pizzas)
                        if (isset($itemAll) && is_array($itemAll)) {
                            foreach ($itemAll as $sab) :
                        ?>
                            <div class="lista-sabores lista-sab-{{ $item_id }}" data-preco="{{ floatval($sab->item_preco) }}">
                                <label for="sab-<?= $sab->item_id ?>-<?= $iterator ?>">
                                    <input type="checkbox"
                                        class="sabores"
                                        id="sab-{{ $sab->item_id }}-{{ $iterator }}"
                                        name="sab-{{ $sab->item_id }}-{{ $iterator }}"
                                        data-id="{{ $sab->item_id }}-{{ $iterator }}"
                                        data-item-id="{{ $item_id }}"
                                        data-item="{{ $item_id }}-{{ $iterator }}"
                                        data-nome="{{ $sab->item_nome }}"
                                        data-estoque="{{ intval($item_estoque); }}"
                                        data-preco="{{ $sab->item_preco; }}"
                                        value="{{ $sab->item_id }}" />
                                    <div class="opcao-info">
                                        <span class="opcao-nome">{{ ucfirst(mb_strtolower($sab->item_nome)) }}</span>
                                        <?php if (!empty($sab->item_obs)): ?>
                                            <span class="opcao-descricao">{{ strip_tags($sab->item_obs); }}</span>
                                        <?php endif; ?>
                                    </div>
                                    <span class="opcao-preco">R$ {{ strip_tags(number_format($sab->item_preco, 2, ',', '.')); }}</span>
                                </label>
                            </div>
                            <?php
                                $iterator++;
                            endforeach;
                        }
                        ?>
                    </div>
                <?php } ?>

                <?php if (isset($opcoes[0])) : ?>
                    <?php foreach ($opcoes as $opcao) : ?>
                        <?php if (isset($opcao[0]->opcao_id)) : ?>
                            <!-- Seção de Opções -->
                            <div class="opcoes-section">
                                <div class="opcoes-section-title">
                                    <span><?= $opcao[0]->grupo_nome ?></span>
                                    <?php if ($opcao[0]->grupo_tipo == 1) : ?>
                                        <span class="badge-required">Obrigatório</span>
                                    <?php else : ?>
                                        <?php $lim = $opcao[0]->grupo_limite; ?>
                                        <span class="badge-optional">
                                            Opcional<?= ($lim > 0) ? ' (até ' . $lim . ($lim > 1 ? ' itens)' : ' item)') : '' ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <?php foreach ($opcao as $opc) : ?>
                                    <?php $tipo = ($opc->grupo_selecao == 1) ? 'radio' : 'checkbox'; ?>
                                    <div class="opcao-card opt-{{ $opc->grupo_id }} opt-{{ $item_id }} grupo-{{ $opc->grupo_id }}" data-preco="{{ floatval($item_preco) }}">
                                        <label for="opt-{{ $opc->opcao_id }}-{{ $item_id }}">
                                            <input class="tamanho-{{ $item_id }}"
                                                type="{{ $tipo }}"
                                                name="opt-{{ $opc->grupo_id }}-{{ $item_id }}"
                                                id="opt-{{ $opc->opcao_id }}-{{ $item_id }}"
                                                data-limite="{{ ($opc->grupo_limite <= 0) ? 100 : $opc->grupo_limite }}"
                                                data-grupo="{{ $opc->grupo_id }}"
                                                data-item="{{ $item_id }}"
                                                data-estoque="{{ intval($item_estoque); }}"
                                                data-id="{{ $opc->opcao_id }}"
                                                data-nome="{{ $opc->opcao_nome }}"
                                                data-preco_real="{{ floatval($opc->opcao_preco) }}"
                                                data-preco="{{ ($opc->opcao_preco > 0) ? ' + R$ ' . \App\Helpers\Filter::moeda($opc->opcao_preco) : ''; }}"
                                                {{ ($opc->grupo_tipo == 1) ? 'required' : ''; }}
                                                value="{{ $opc->opcao_id }}" />
                                            <div class="opcao-info">
                                                <span class="opcao-nome">{{ mb_strtolower($opc->opcao_nome) }}</span>
                                            </div>
                                            <span class="opcao-preco <?= ($opc->opcao_preco <= 0) ? 'gratis' : '' ?>">
                                                <?= ($opc->opcao_preco > 0) ? '+ R$ ' . \App\Helpers\Filter::moeda($opc->opcao_preco) : 'Grátis' ?>
                                            </span>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default btn-lg">
                    <i class="fa fa-arrow-left"></i> Voltar
                </button>
                <button type="button"
                    id="btn-add-{{ $item_id }}"
                    data-id="{{ $item_id }}"
                    data-nome="{{ $item_nome }}"
                    data-obs="{{ strip_tags($item_obs) }}"
                    data-categoria="{{ $categoria_id }}"
                    data-categoria-nome="{{ $categoria_nome_item }}"
                    data-preco="{{ floatval($item_preco) }}"
                    data-estoque="{{ intval($item_estoque) }}"
                    data-cod="{{ $item_codigo }}"
                    class="btn btn-primary btn-lg add-item"
                    title="adicionar à sacola">
                    <i class="fa fa-shopping-cart"></i> Adicionar
                </button>
                <div id="msg-{{ $item_id }}" class="text-center" style="margin-top: 10px; display: none;"></div>
            </div>
        </div>
    </div>
</div>
