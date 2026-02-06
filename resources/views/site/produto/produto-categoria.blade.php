@extends('layouts.site')

@section('content')
@php
    $_SESSION['base_delivery'] = 'deliciasnopote';
@endphp
<style>
    .tremer {
        animation: treme 0.1s;
        animation-iteration-count: 3;
    }

    @keyframes treme {
        0% {
            margin-left: 0;
        }

        25% {
            margin-left: 5px;
        }

        50% {
            margin-left: 0;
        }

        75% {
            margin-left: -5px;
        }

        100% {
            margin-left: 0;
        }
    }

    /* Loading Screen */
    .page-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 99999;
        transition: opacity 0.5s ease, visibility 0.5s ease;
    }

    .page-loader.hidden {
        opacity: 0;
        visibility: hidden;
    }

    .loader-container {
        text-align: center;
    }

    .loader-logo {
        width: 120px;
        height: 120px;
        margin: 0 auto 30px;
        animation: pulse-logo 1.5s infinite;
    }

    .loader-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 50%;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    @keyframes pulse-logo {
        0%, 100% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.05);
            opacity: 0.9;
        }
    }

    .spinner {
        width: 60px;
        height: 60px;
        position: relative;
        margin: 0 auto 30px;
    }

    .double-bounce1, .double-bounce2 {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: white;
        opacity: 0.6;
        position: absolute;
        top: 0;
        left: 0;
        animation: sk-bounce 2.0s infinite ease-in-out;
    }

    .double-bounce2 {
        animation-delay: -1.0s;
    }

    @keyframes sk-bounce {
        0%, 100% { transform: scale(0.0); }
        50% { transform: scale(1.0); }
    }

    .loader-text h3 {
        color: white;
        font-size: 24px;
        font-weight: 600;
        margin: 0 0 10px 0;
        animation: pulse 1.5s infinite;
    }

    .loader-text p {
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
        margin: 0;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Estilos para produtos sem estoque */
    .produto-sem-estoque {
        opacity: 0.75;
        position: relative;
    }

    .produto-sem-estoque::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.3);
        pointer-events: none;
        z-index: 1;
    }
</style>

<body>
    <!-- Loading Screen -->
    <div id="page-loader" class="page-loader">
        <div class="loader-container">
            <?php if (isset($dados['config']->config_foto) && !empty($dados['config']->config_foto)): ?>
                <!-- Logo do delivery -->
                <div class="loader-logo">
                    <img src="<?php echo $baseUri; ?>/assets/logo/{{ $baseDelivery }}/<?php echo $dados['config']->config_foto; ?>"
                         alt="<?= (isset($dados['config']->config_nome)) ? $dados['config']->config_nome : 'Loading'; ?>">
                </div>
            <?php else: ?>
                <!-- Spinner padrão -->
                <div class="spinner">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
            <?php endif; ?>
            <div class="loader-text">
                <h3>Carregando...</h3>
                <p>Preparando seu delivery</p>
            </div>
        </div>
    </div>
    <div data-v-5734e810="" data-v-56e5d68e="" class="navigation-header flex items-center justify-between navigation-header--floating-bg bg-white">
        <div data-v-5734e810="" class="flex items-center">
            <a href="{{ route('home') }}" id="back-link" class="navigation-header__back navigation-header__back--floating-bg">
                <div data-v-d15b4698="" data-v-5734e810="" class="icon-container navigation-header__back__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left voltar">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </div>
            </a>
            <h3 data-v-5734e810="" class="navigation-header__title voltar"><?= $dados['lista'][0]['categoria'] ?></h3>
        </div>
    </div>
    <div class="container-fluid">
        <div id="home-content">
            <div class="lista-item">
                <?php if (isset($dados['lista'][0])) :

                    $categoria_nome = $dados['lista'][0]['categoria'];

                    // Adicionar barra de busca para a categoria
                    echo '<div class="categoria-search-container">';
                    echo '<div class="categoria-search-wrapper">';
                    echo '<input type="text" id="categoria-search-input" class="categoria-search-input" placeholder="Buscar produtos na categoria ' . mb_strtolower($categoria_nome) . '..." aria-label="Buscar produtos">';
                    echo '<i class="fa fa-search categoria-search-icon"></i>';
                    echo '<span id="categoria-search-results" class="categoria-search-results"></span>';
                    echo '</div>';
                    echo '</div>';

                    foreach ($dados['lista'] as $obj) : ?>

                        <?php $categoria_img = $obj['categoria_img'];
                        $categoria_img_url = "$baseUri/assets/categoria/$_SESSION[base_delivery]/$categoria_img";
                        ?>
                        <?php $categoria_id = $obj['categoria_id']; ?>
                        <?php $estoque = $obj['item'][0]->item_estoque; ?>
                        <?php $opcoes = $obj['opcoes']; ?>
                        <?php $meia = $obj['categoria_meia']; ?>
                        <?php $iterator = 0; ?>
                        <?php if (strlen($categoria_img) >= 4) : ?>
                            <!-- <div class="categoria-banner" style="background: url('<?= $categoria_img_url ?>')"></div> -->
                        <?php endif; ?>
                        <div class="box28">
                            <ul>
                                <?php
                                // Ordena produtos: com estoque primeiro, sem estoque depois
                                usort($obj['item'], function($a, $b) {
                                    // Se A tem estoque e B não tem, A vem primeiro
                                    if ($a->item_estoque > 0 && $b->item_estoque <= 0) return -1;
                                    // Se B tem estoque e A não tem, B vem primeiro
                                    if ($b->item_estoque > 0 && $a->item_estoque <= 0) return 1;
                                    // Se ambos têm ou ambos não têm estoque, mantém ordem original
                                    return 0;
                                });

                                foreach ($obj['item'] as $item) :
                                    // Verifica se tem estoque
                                    $semEstoque = ($item->item_estoque <= 0);
                                    $opcao = $opcoes ?? [];
                                    $grupo_nome = isset($opcao[0][0]->grupo_nome) ? $opcao[0][0]->grupo_nome : '';
                                ?>
                                    <?php $foto_url = "item/$_SESSION[base_delivery]/$item->item_foto"; ?>
                                    <div class="itemClicado" id="<?= $item->item_nome ?>,<?= $grupo_nome ?>">
                                        <li>
                                            <?php
                                            // Verifica se deve abrir modal:
                                            // - APENAS se tem opções/adicionais OU sistema de múltiplos sabores (meia > 1)
                                            // - Se meia = 1 (sabor único), adiciona direto ao carrinho
                                            $deveAbrirModal = (isset($opcoes[0]) || $meia > 1);
                                            ?>
                                            <?php if ($deveAbrirModal) : ?>
                                                <div class="box170 itemClicado <?= $semEstoque ? 'produto-sem-estoque' : '' ?>"
                                                     data-toggle="modal"
                                                     data-sabor-id="<?= $item->item_id ?>"
                                                     data-estoque="<?= intval($item->item_estoque); ?>"
                                                     title="<?php echo $semEstoque ? 'PRODUTO INDISPONÍVEL' : 'adicionar à sacola'; ?>"
                                                     data-target="#item-<?php echo $semEstoque ? 'indisponivel' : $item->item_id; ?>"
                                                     <?= $semEstoque ? 'style="cursor: not-allowed; pointer-events: none;"' : '' ?>>
                                                <?php else : ?>
                                                    <div class="box170 itemClicado categoria-btn-add <?php echo $semEstoque ? 'produto-sem-estoque' : 'add-item-categoria'; ?>"
                                                        id="btn-add-<?= $item->item_id; ?>"
                                                        data-id="<?= $item->item_id; ?>"
                                                        data-nome="<?= $item->item_nome; ?>"
                                                        data-obs="<?= strip_tags($item->item_obs); ?>"
                                                        data-categoria="<?= $item->categoria_id; ?>"
                                                        data-categoria-nome="<?= $item->categoria_nome; ?>"
                                                        data-preco="<?= \App\Helpers\Currency::moedaUS($item->item_preco); ?>"
                                                        data-cod="<?= $item->item_codigo; ?>"
                                                        data-estoque="<?= intval($item->item_estoque); ?>"
                                                        data-tem-opcoes="0"
                                                        <?= $semEstoque ? 'style="cursor: not-allowed; pointer-events: none;"' : '' ?>
                                                        title="<?php echo $semEstoque ? 'PRODUTO INDISPONÍVEL' : 'adicionar à sacola'; ?>">
                                                    <?php endif; ?>
                                                    <div class="box29 itemClicado" id="<?= $item->item_nome ?>,<?= $grupo_nome ?>" style="position: relative;">
                                                        <?php if ($semEstoque): ?>
                                                            <div style="position: absolute; top: 8px; right: 8px; background: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; z-index: 10; text-transform: uppercase;">ESGOTADO</div>
                                                        <?php endif; ?>
                                                        <?php if ($item->item_foto != "" && file_exists($foto_url)) : ?>
                                                            <img src="<?php echo $baseUri; ?>/assets/thumb.php?zc=2&w=200&h=200&src=item/{{ $baseDelivery }}/<?= $item->item_foto ?>"
                                                                 alt="foto produto"
                                                                 class="img-radius itemClicado"
                                                                 id="<?= $item->item_nome ?>,<?= $grupo_nome ?>"
                                                                 style="<?= $semEstoque ? 'filter: grayscale(100%); opacity: 0.6;' : '' ?>">
                                                        <?php else : ?>
                                                            <img src="<?php echo $baseUri; ?>/assets/thumb.php?zcx=3&w=200&h=200&src=img/sem_foto.jpg"
                                                                 alt="..."
                                                                 class="img-radius itemClicado"
                                                                 id="<?= $item->item_nome ?>,<?= $grupo_nome ?>"
                                                                 style="<?= $semEstoque ? 'filter: grayscale(100%); opacity: 0.6;' : '' ?>">
                                                        <?php endif; ?>
                                                        <?php if (!$semEstoque) : ?>
                                                            <div class="retina itemClicado" id="<?= $item->item_nome ?>,<?= $grupo_nome ?>">
                                                                <div class="add1 itemClicado" id="<?= $item->item_nome ?>,<?= $grupo_nome ?>">COMPRAR</div>
                                                                <div class="add2 itemClicado" id="<?= $item->item_nome ?>,<?= $grupo_nome ?>">Adicionar ao meu pedido</div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <span class="itemClicado" id="<?= $item->item_nome ?>,<?= $grupo_nome ?>"><i class="itemClicado" id="<?= $item->item_nome ?>,<?= $grupo_nome ?>"></i></span>
                                                    </div>
                                                    <!-- Sempre mostra informações do produto -->
                                                    <div class="product-info" style="<?= $semEstoque ? 'opacity: 0.7;' : '' ?>">
                                                        <div class="box30 itemClicado" data-nome="<?= $item->item_nome ?>" id="<?= $item->item_nome ?>,<?= $grupo_nome ?>"><?php echo mb_strtolower($item->item_nome); ?></div>
                                                        <?php if (!empty($item->item_obs)): ?>
                                                            <div class="box32 itemClicado" id="<?= $item->item_nome ?>,<?= $grupo_nome ?>" style="font-size: 11px; color: #666; margin-top: 4px; line-height: 1.3;">
                                                                Ingredientes: <?php echo strip_tags($item->item_obs); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if (!empty($item->item_desc)): ?>
                                                            <div class="box32 itemClicado" id="<?= $item->item_nome ?>,<?= $grupo_nome ?>" style="font-size: 11px; color: #666; margin-top: 4px; line-height: 1.3;">
                                                                Descrição Breve: <?php echo strip_tags($item->item_desc); ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="box31 itemClicado" id="<?= $item->item_nome ?>,<?= $grupo_nome ?>">
                                                            R$ <?php echo strip_tags(number_format($item->item_preco, 2, ',', '.')); ?>
                                                            <?php if ($semEstoque): ?>
                                                                <br><span style="color: #dc3545; font-size: 11px; font-weight: bold;">• SEM ESTOQUE</span>
                                                            <?php elseif ($_SESSION['base_delivery'] == 'sorvanna'): ?>
                                                                <br><?php echo ($item->item_estoque == 1) ? $item->item_estoque . ' restante' : $item->item_estoque . ' restantes'; ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                    <?php if (!$semEstoque): ?>
                                                        <button class="btn-comprar">+</button>
                                                    <?php else: ?>
                                                        <button class="btn-comprar" style="background: #ccc; cursor: not-allowed;" disabled>✗</button>
                                                    <?php endif; ?>
                                                    </div>
                                                </div>
                                        </li>
                                        <?php if (isset($opcoes[0]) || $meia >= 1) : ?>
                                            <div class="modal fade bs-example-modal-lg modal-itens" tabindex="-1" id="item-<?= $item->item_id; ?>" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="static">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header" id="myNav">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                                            </button>
                                                            <h5 class="modal-title text-uppercase text-center">Detalhes e Opções</h5>
                                                        </div>
                                                        <!-- Ícone de sacola flutuante -->
                                                        <div class="floating-cart-badge" id="floating-cart-<?= $item->item_id ?>" title="Ver itens selecionados">
                                                            <div class="cart-icon">
                                                                <i class="fa fa-shopping-bag"></i>
                                                                <span class="cart-count" id="cart-count-<?= $item->item_id ?>">0</span>
                                                            </div>
                                                        </div>
                                                        <!-- Popup de itens selecionados -->
                                                        <div class="selected-items-popup" id="popup-<?= $item->item_id ?>">
                                                            <div class="selected-items-popup-header">
                                                                <span>Itens Selecionados</span>
                                                                <button class="close-popup" onclick="$('#popup-<?= $item->item_id ?>').removeClass('show')">×</button>
                                                            </div>
                                                            <div class="selected-items-popup-body" id="popup-body-<?= $item->item_id ?>">
                                                                <!-- Itens serão inseridos aqui via JS -->
                                                            </div>
                                                            <div class="selected-items-popup-footer" id="popup-footer-<?= $item->item_id ?>">
                                                                <span class="total-label">Total:</span>
                                                                <span class="total-value" id="popup-total-<?= $item->item_id ?>">R$ 0,00</span>
                                                            </div>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Informação do Produto -->
                                                            <div class="produto-info-header" id="produto-info-<?= $item->item_id ?>" style="display: none;">
                                                                <div class="produto-nome"><?= ucfirst(mb_strtolower($item->item_nome)) ?></div>
                                                                <?php if (!empty($item->item_obs)): ?>
                                                                    <div class="produto-descricao"><?= strip_tags($item->item_obs); ?></div>
                                                                <?php endif; ?>
                                                                <div class="produto-preco">R$ <?= strip_tags(number_format($item->item_preco, 2, ',', '.')); ?></div>
                                                            </div>

                                                            <input type="hidden" id="divisao_valor_pizza" value="<?= $dados['config']->config_divisao_valor_pizza ?>">
                                                            <?php if ($meia >= 1) { ?>
                                                                <input type="hidden" id="sabores-<?= $item->item_id ?>" value="<?= $meia ?>">

                                                                <!-- Seção de Sabores -->
                                                                <div class="opcoes-section">
                                                                    <div class="opcoes-section-title">
                                                                        <?php if ($meia > 1) { ?>
                                                                            <span>Selecione até <?= $meia ?> sabores</span>
                                                                            <span class="badge-optional">Opcional</span>
                                                                        <?php } else { ?>
                                                                            <span>CATEGORIA: <?= $item->categoria_nome ?></span>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <?php if ($meia > 1) { ?>
                                                                        <p style="font-size: 12px; color: #6c757d; margin-bottom: 12px;">
                                                                            <?php if ($dados['config']->config_divisao_valor_pizza == 0) { ?>
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

                                                                    <?php foreach ($obj['item'] as $sab) : ?>
                                                                        <div class="lista-sabores lista-sab-<?= $item->item_id ?>" data-preco="<?= \App\Helpers\Currency::moedaUS($sab->item_preco) ?>">
                                                                            <label for="sab-<?= $sab->item_id ?>-<?= $iterator ?>" data-id="sab-<?= $sab->item_id ?>">
                                                                                <input type="checkbox"
                                                                                    class="sabores"
                                                                                    id="sab-<?= $sab->item_id ?>-<?= $iterator ?>"
                                                                                    name="sab-<?= $sab->item_id ?>-<?= $iterator ?>"
                                                                                    data-id="<?= $sab->item_id ?>-<?= $iterator ?>"
                                                                                    data-item-id="<?= $item->item_id ?>"
                                                                                    data-item="<?= $item->item_id ?>-<?= $iterator ?>"
                                                                                    data-nome="<?= $sab->item_nome ?>"
                                                                                    data-estoque="<?= intval($item->item_estoque); ?>"
                                                                                    data-preco="<?= $sab->item_preco; ?>"
                                                                                    value="<?= $sab->item_id ?>" />
                                                                                <div class="opcao-info">
                                                                                    <span class="opcao-nome"><?= ucfirst(mb_strtolower($sab->item_nome)) ?></span>
                                                                                    <?php if (!empty($sab->item_obs)): ?>
                                                                                        <span class="opcao-descricao"><?= strip_tags($sab->item_obs); ?></span>
                                                                                    <?php endif; ?>
                                                                                </div>
                                                                                <span class="opcao-preco">R$ <?= strip_tags(number_format($sab->item_preco, 2, ',', '.')); ?></span>
                                                                            </label>
                                                                        </div>
                                                                        <?php $iterator++; ?>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            <?php } ?>

                                                            <?php if (isset($opcoes[0])) : ?>
                                                                <?php foreach ($opcoes as $opcao) : ?>
                                                                    <?php if (isset($opcao[0]->opcao_id)) : ?>
                                                                        <!-- Seção de Opções -->
                                                                        <div class="opcoes-section">
                                                                            <div class="opcoes-section-title">
                                                                                <span><?= $grupo_nome ?></span>
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
                                                                                <div class="opcao-card opt-<?= $opc->grupo_id ?> opt-<?= $item->item_id ?> grupo-<?= $opc->grupo_id ?>" data-preco="<?= \App\Helpers\Currency::moedaUS($item->item_preco) ?>">
                                                                                    <label for="opt-<?= $opc->opcao_id ?>-<?= $item->item_id ?>">
                                                                                        <input class="tamanho-<?= $item->item_id ?>"
                                                                                            type="<?= $tipo ?>"
                                                                                            name="opt-<?= $opc->grupo_id ?>-<?= $item->item_id ?>"
                                                                                            id="opt-<?= $opc->opcao_id ?>-<?= $item->item_id ?>"
                                                                                            data-limite="<?= ($opc->grupo_limite <= 0) ? 100 : $opc->grupo_limite ?>"
                                                                                            data-grupo="<?= $opc->grupo_id ?>"
                                                                                            data-item="<?= $item->item_id ?>"
                                                                                            data-estoque="<?= intval($item->item_estoque); ?>"
                                                                                            data-id="<?= $opc->opcao_id ?>"
                                                                                            data-nome="<?= $opc->opcao_nome ?>"
                                                                                            data-preco_real="<?= \App\Helpers\Currency::moedaUS($opc->opcao_preco) ?>"
                                                                                            data-preco="<?= ($opc->opcao_preco > 0) ? ' + R$ ' . \App\Helpers\Currency::moeda($opc->opcao_preco) : ''; ?>"
                                                                                            <?= ($opc->grupo_tipo == 1) ? 'required' : ''; ?>
                                                                                            value="<?= $opc->opcao_id ?>" />
                                                                                        <div class="opcao-info">
                                                                                            <span class="opcao-nome"><?= mb_strtolower($opc->opcao_nome) ?></span>
                                                                                        </div>
                                                                                        <span class="opcao-preco <?= ($opc->opcao_preco <= 0) ? 'gratis' : '' ?>">
                                                                                            <?= ($opc->opcao_preco > 0) ? '+ R$ ' . \App\Helpers\Currency::moeda($opc->opcao_preco) : 'Grátis' ?>
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
                                                            <button type="button"
                                                                data-dismiss="modal"
                                                                class="btn btn-default btn-lg">
                                                                <i class="fa fa-arrow-left"></i> Voltar
                                                            </button>
                                                            <button type="button"
                                                                id="btn-add-<?= $item->item_id; ?>"
                                                                data-id="<?= $item->item_id; ?>"
                                                                data-nome="<?= $item->item_nome; ?>"
                                                                data-obs="<?= strip_tags($item->item_obs); ?>"
                                                                data-categoria="<?= $item->categoria_id; ?>"
                                                                data-categoria-nome="<?= $item->categoria_nome; ?>"
                                                                data-preco="<?= \App\Helpers\Currency::moedaUS($item->item_preco); ?>"
                                                                data-estoque="<?= intval($item->item_estoque); ?>"
                                                                data-cod="<?= $item->item_codigo; ?>"
                                                                class="btn btn-primary btn-lg add-item"
                                                                title="adicionar à sacola">
                                                                <i class="fa fa-shopping-cart"></i> Adicionar
                                                            </button>
                                                            <div id="msg-<?= $item->item_id ?>" class="text-center" style="margin-top: 10px; display: none;"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php
                                endforeach; ?>
                                    </div>
                            </ul>
                        </div>
                    <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="modal fade bs-example-modal" tabindex="-1" id="item-indisponivel" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title text-uppercase text-center">
                            <strong>INDISPONÍVEL</strong>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <p class="text-center text-uppercase">
                            <b>Lamentamos mas o item selecionado está indisponível no momento!</b>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <p class="text-center">
                            <img src="<?php echo $baseUri; ?>/assets/thumb.php?zcx=3&w=218&h=178&src=img/icon-triste.png" alt="...">
                            <br><br>
                            <button type="button" class="btn btn-warning btn-lg" data-dismiss="modal">Temos outras opções, clique aqui!
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div id="count_bag" data-toggle="modal" data-target="#modal-carrinho"></div>
        </div>
        @include('site.components.footer')
        @include('site.carrinho.side-carrinho')
        <script type="text/javascript">
            var currentUri = 'index';
        </script>
        @include('site.footer-core-js')
        <script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/slick/slick.min.js"></script>
        <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/number.js"></script>
        <script src="<?php echo $baseUri; ?>/view/site/app-js/howler.js"></script>
        <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/carrinho.js?v=<?= time() ?>"></script>
        <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/modal-produto.js?v=<?= time() ?>"></script>
        <script type="text/javascript">
            // Intercepta clique nos produtos SEM opções das categorias
            $(document).on('click', '.add-item-categoria', function(e) {
                e.preventDefault();
                e.stopPropagation();

                var $btn = $(this);
                var itemId = $btn.data('id');
                var itemNome = $btn.data('nome');
                var itemObs = $btn.data('obs') || '';
                var itemCategoria = $btn.data('categoria');
                var categoriaNome = $btn.data('categoria-nome');
                var itemPreco = parseFloat($btn.data('preco'));
                var itemEstoque = parseInt($btn.data('estoque'));
                var itemCod = $btn.data('cod');

                // Desabilita cliques temporariamente
                $btn.css('pointer-events', 'none');

                // Verifica estoque
                var urlCheck = baseUri + "/carrinho/add_more/";
                $.post(urlCheck, { id: itemId, hash: '', estoque: itemEstoque }, function(rs) {
                    if (rs == '-1') {
                        alert('Quantidade indisponível!');
                        $btn.css('pointer-events', 'auto');
                        return false;
                    }

                    // Prepara dados do item (sem extras/opções)
                    var dados = {
                        item_id: itemId,
                        item_estoque: itemEstoque,
                        item_codigo: itemCod,
                        item_nome: itemNome,
                        categoria_nome: categoriaNome,
                        categoria_id: itemCategoria,
                        item_obs: itemObs,
                        item_preco: itemPreco,
                        extra: '',
                        desc: '',
                        extra_vals: '',
                        extra_preco: 0,
                        total: itemPreco
                    };

                    // Adiciona ao carrinho
                    var urlAdd = baseUri + "/carrinho/add/";
                    $.post(urlAdd, dados, function() {}).done(function() {

                        // Feedback visual no botão
                        var $btnComprar = $btn.find('.btn-comprar');
                        if ($btnComprar.length) {
                            $btnComprar.text('✓').css('background', '#28a745');
                        }

                        // Toca som
                        if (typeof sound === 'function') {
                            sound();
                        }

                        // Recarrega o carrinho
                        if (typeof rebind_reload === 'function') {
                            rebind_reload();
                        }

                        // Abre modal do carrinho
                        setTimeout(function() {
                            $('#modal-carrinho').modal('show');
                        }, 800);

                        // Reseta botão
                        setTimeout(function() {
                            if ($btnComprar.length) {
                                $btnComprar.text('+').css('background', '');
                            }
                            $btn.css('pointer-events', 'auto');
                        }, 1500);

                    }).fail(function() {
                        alert('Erro ao adicionar item. Tente novamente.');
                        $btn.css('pointer-events', 'auto');
                    });
                });

                return false;
            });
        </script>
        <script type="text/javascript">
            var backLinks = document.querySelectorAll('.voltar, .voltarFooter');
            backLinks.forEach(function(backLink) {
                backLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    window.location.href = 'index';
                });
            });

            //BLOQEIA O BROWSER EDGE
            // if (/Edg/.test(navigator.userAgent)) {
            //     alert("Favor utilize Google Chrome");
            //     window.location = "error";
            // }

            $('#busca').val('A');
            $('.add-item').addClass('returnIndex');
            $('#busca').val('A');
            $('.add-item').addClass('returnIndex');
            if (typeof rebind_reload === 'function') {
                rebind_reload();
            }
            <?= (isset($dados['config']->config_chat) && trim($dados['config']->config_chat) != "") ? $dados['config']->config_chat : ''; ?>


            // Auto-abre o primeiro modal se categoria tem meia > 1
            <?php if ($meia > 1): ?>
            $(document).ready(function() {
                // Aguarda um momento para garantir que tudo foi carregado
                setTimeout(function() {
                    var $firstModal = $('.box170[data-toggle="modal"]').first();
                    if ($firstModal.leng                                                                                                th) {
                        var targetModal = $firstModal.attr('data-target');
                        if (targetModal) {
                            $(targetModal).modal('show');
                        }
                    }
                }, 300);
            });
            <?php endif; ?>

            // Esconde o loading quando tudo estiver carregado
            $(window).on('load', function() {
                setTimeout(function() {
                    $('#page-loader').addClass('hidden');
                }, 300);
            });

            // FUNCIONALIDADE DE BUSCA NA CATEGORIA
            $(document).ready(function() {
                var $searchInput = $('#categoria-search-input');
                var $searchResults = $('#categoria-search-results');
                var $allProducts = $('.box170');
                var allProductsData = [];

                // Armazena dados dos produtos (apenas nome)
                $allProducts.each(function() {
                    var $product = $(this);
                    var productName = $product.find('.box30').text().toLowerCase();

                    allProductsData.push({
                        element: $product,
                        name: productName
                    });
                });

                // Função de filtragem - BUSCA APENAS NO NOME DO PRODUTO
                function filterProducts(searchTerm) {
                    searchTerm = searchTerm.toLowerCase().trim();
                    var visibleCount = 0;
                    var totalCount = allProductsData.length;

                    if (searchTerm === '') {
                        // Mostrar todos os produtos
                        allProductsData.forEach(function(product) {
                            product.element.show();
                        });
                        $searchResults.text('');
                        return;
                    }

                    // Filtrar produtos - APENAS PELO NOME
                    allProductsData.forEach(function(product) {
                        var matches = product.name.includes(searchTerm);

                        if (matches) {
                            product.element.show();
                            visibleCount++;
                        } else {
                            product.element.hide();
                        }
                    });

                    // Atualizar contador de resultados
                    if (visibleCount === 0) {
                        $searchResults.text('Nenhum produto encontrado');
                    } else if (visibleCount === 1) {
                        $searchResults.text('1 produto encontrado');
                    } else {
                        $searchResults.text(visibleCount + ' produtos encontrados');
                    }
                }

                // Event listeners
                $searchInput.on('input', function() {
                    var searchTerm = $(this).val();
                    filterProducts(searchTerm);
                });

                // Limpar busca ao pressionar ESC
                $searchInput.on('keydown', function(e) {
                    if (e.key === 'Escape') {
                        $(this).val('').trigger('input').blur();
                    }
                });

                // Foco no campo de busca ao carregar
                setTimeout(function() {
                    $searchInput.focus();
                }, 500);
            });
        </script>
@endsection
