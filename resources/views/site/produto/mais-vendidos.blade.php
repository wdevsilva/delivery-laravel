@php

$baseUri = url('/');
// Caminho base da imagem padrão
$semFoto = "$baseUri/assets/item/semfoto.jpg";

// Converte Collection para array se necessário
if (is_object($maisVendidos) && method_exists($maisVendidos, 'toArray')) {
    $maisVendidos = $maisVendidos->toArray();
}
@endphp

@if (!empty($maisVendidos))
    <div class="mais-vendidos-section">
        <h2 class="section-title">Mais Pedidos</h2>
        <div class="mais-vendidos-slick" id="topSold" aria-label="Carrossel dos itens mais pedidos">
        @php

        // Ordena: produtos com estoque primeiro, depois sem estoque
        usort($maisVendidos, function($a, $b) {
            // Se A tem estoque e B não tem, A vem primeiro
            if ($a['item_estoque'] > 0 && $b['item_estoque'] <= 0) return -1;
            // Se B tem estoque e A não tem, B vem primeiro
            if ($b['item_estoque'] > 0 && $a['item_estoque'] <= 0) return 1;
            // Se ambos têm ou ambos não têm estoque, ordena por vendas
            return $b['media_vendida'] <=> $a['media_vendida'];
        });

        // Pega os top 3 vendidos ENTRE TODOS (com e sem estoque) para marcar a tag
        $todosOrdenadosPorVendas = $maisVendidos;
        usort($todosOrdenadosPorVendas, fn($a, $b) => $b['media_vendida'] <=> $a['media_vendida']);
        $top3_vendidos = array_slice($todosOrdenadosPorVendas, 0, 3);
        // Usa os IDs dos top 3 para comparação unívoca
        $top3_ids = array_map(fn($item) => $item['item_id'], $top3_vendidos);

        // Embaralha para exibição aleatória (mas mantém produtos com estoque primeiro)
        $produtosComEstoque = array_filter($maisVendidos, fn($item) => $item['item_estoque'] > 0);
        $produtosSemEstoque = array_filter($maisVendidos, fn($item) => $item['item_estoque'] <= 0);
        shuffle($produtosComEstoque);
        shuffle($produtosSemEstoque);
        $maisVendidos = array_merge($produtosComEstoque, $produtosSemEstoque);
        @endphp

        @foreach ($maisVendidos as $index => $item)
            @php
                // Verifica se tem estoque
                $semEstoque = ($item['item_estoque'] <= 0);

                // Monta URL da imagem
                $item_foto = isset($item['item_foto'])
                    ? "$baseUri/assets/item/" . session('base_delivery') . "/{$item['item_foto']}"
                    : $semFoto;

                // Usa a foto do item diretamente
                $img_url = $item_foto;
            @endphp

            <article class="card {{ ($semEstoque) ? 'produto-sem-estoque' : '' }}" data-id="{{ $item['item_id'] }}">
                <div class="card-img-wrapper" style="position: relative;">
                    @if ($semEstoque)
                        <div style="position: absolute; top: 8px; right: 8px; background: #dc3545; color: white; padding: 4px 8px; border-radius: 4px; font-size: 10px; font-weight: bold; z-index: 10; text-transform: uppercase;">ESGOTADO</div>
                    @endif
                    <img src="{{ htmlspecialchars($img_url) }}"
                         alt="{{ htmlspecialchars($item['item_nome']) }}"
                         style="<?= $semEstoque ? 'filter: grayscale(100%); opacity: 0.6;' : '' ?>"
                         onerror="this.onerror=null; this.src='{{ $semFoto }}';">

                    <div class="tags-container">
                        @if (in_array($item['item_id'], $top3_ids))
                            <div class="tag-hot" data-id="{{ $item['item_id'] }}" aria-hidden="true">🔥 Mais vendido</div>
                        @endif
                        @if ($item['item_promo'] == 1)
                            <div class="tag-promo" data-id="{{ $item['item_id'] }}" aria-hidden="true">💥 Promoção</div>
                        @endif
                    </div>
                </div>
                <div class="card-body" style="{{ ($semEstoque) ? 'opacity: 0.7;' : '' }}">
                    <div class="card-category-conteudo">
                        <div class="card-category-mais-vendidos"><b>{{ $item['categoria'] }}</b></div>
                        <div class="card-title-mais-vendidos"><b>{{ htmlspecialchars($item['item_nome']) }}</b></div>
                        @if (!empty($item['item_obs']))
                            <div class="card-description"><strong>Ingredientes:</strong> {{ htmlspecialchars(strip_tags($item['item_obs'])) }}</div>
                        @endif
                        @if (!empty($item['item_desc']))
                            <div class="card-description"><strong>Descrição Breve:</strong> {{ htmlspecialchars(strip_tags($item['item_desc'])) }}</div>
                        @endif
                    </div>
                    <div class="card-price-mais-vendidos">
                        <b>R$ <?= number_format($item['item_preco'], 2, ',', '.'); ?></b>
                        @if ($semEstoque)
                            <br><span style="color: #dc3545; font-size: 11px; font-weight: bold;">• SEM ESTOQUE</span>
                        @endif
                    </div>
                    @php
                    // Verifica se deve abrir modal:
                    // - APENAS se tem opções/adicionais
                    // - Descrição/ingredientes NÃO forçam abertura do modal
                    $temOpcoes = (isset($item['opcoes']) && !empty($item['opcoes']) && is_array($item['opcoes']) && count($item['opcoes']) > 0);
                    $deveAbrirModal = $temOpcoes;
                    @endphp
                    @if (!$semEstoque)
                        <button class="btn-add mais-vendidos-btn-add"
                            @if ($deveAbrirModal)
                                data-toggle="modal" data-target="#item-{{ $item['item_id'] }}"
                            @endif
                            data-estoque="{{ intval($item['item_estoque']) }}"
                            data-id="{{ $item['item_id'] }}"
                            data-nome="{{ htmlspecialchars($item['item_nome']) }}"
                            data-obs="{{ htmlspecialchars(strip_tags($item['item_obs'] ?? '')) }}"
                            data-categoria="{{ $item['categoria_id'] }}"
                            data-categoria-nome="{{ htmlspecialchars($item['categoria']) }}"
                            data-preco="{{ $item['item_preco'] }}"
                            data-cod="{{ $item['item_codigo'] }}"
                            data-tem-opcoes="{{ ($deveAbrirModal) ? 1 : 0 }}"
                            title="adicionar à sacola">
                            Adicionar
                        </button>
                    @else
                        <button class="btn-add" style="background: #ccc; cursor: not-allowed; opacity: 0.6;" disabled>
                            Indisponível
                        </button>
                    @endif
                </div>
            </article>
        @endforeach
    </div>

    <script>
    // DEBUG: Verificar se modais existem no DOM
    $(document).ready(function() {
        var totalModals = $('.modal-itens').length;
        console.log('[DEBUG] Total de modais no DOM:', totalModals);

        $('.modal-itens').each(function() {
            console.log('[DEBUG] Modal encontrado:', $(this).attr('id'));
        });

        // Verificar botões
        $('.mais-vendidos-btn-add').each(function() {
            var temOpcoes = $(this).data('tem-opcoes');
            var target = $(this).data('target');
            console.log('[DEBUG] Botão:', {
                temOpcoes: temOpcoes,
                target: target,
                toggle: $(this).data('toggle')
            });
        });
    });

    // Intercepta clique nos botões "Adicionar" dos mais vendidos APENAS para produtos SEM opções
    $(document).on('click', '.mais-vendidos-btn-add', function(e) {
        var $btn = $(this);
        var temOpcoes = $btn.data('tem-opcoes') == '1';

        // Se TEM opções, deixa o Bootstrap abrir o modal naturalmente via data-toggle
        if (temOpcoes) {
            return true;
        }

        console.log('Produto SEM opções - adicionando direto ao carrinho');

        // Se NÃO tem opções, adiciona direto ao carrinho SEM abrir modal
        e.preventDefault();
        e.stopPropagation();

        var itemId = $btn.data('id');
        var itemNome = $btn.data('nome');
        var itemObs = $btn.data('obs') || '';
        var itemCategoria = $btn.data('categoria');
        var categoriaNome = $btn.data('categoria-nome');
        var itemPreco = parseFloat($btn.data('preco'));
        var itemEstoque = parseInt($btn.data('estoque'));
        var itemCod = $btn.data('cod');

        // Desabilita botão temporariamente
        $btn.prop('disabled', true);

        // Verifica estoque
        var urlCheck = baseUri + "/carrinho/add_more/";
        $.post(urlCheck, { id: itemId, hash: '', estoque: itemEstoque }, function(rs) {
            if (rs == '-1') {
                alert('Quantidade indisponível!');
                $btn.prop('disabled', false);
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
                extra: '', // Sem extras
                desc: '',  // Sem descrição adicional
                extra_vals: '',
                extra_preco: 0,
                total: itemPreco
            };

            // Adiciona ao carrinho
            var urlAdd = baseUri + "/carrinho/add/";
            $.post(urlAdd, dados, function() {}).done(function() {

                // Recarrega o carrinho
                if (typeof rebind_reload === 'function') {
                    rebind_reload();
                }

                // Feedback visual no botão
                $btn.text('✓ Adicionado!');
                $btn.addClass('btn-success');

                // Toca som (se existir)
                if (typeof sound === 'function') {
                    sound();
                }

                // Abre o modal do carrinho após 300ms
                setTimeout(function() {
                    $('#modal-carrinho').modal('show');
                }, 300);

                // Reseta botão após 1.5s
                setTimeout(function() {
                    $btn.text('Adicionar');
                    $btn.removeClass('btn-success');
                    $btn.prop('disabled', false);
                }, 1500);

            }).fail(function() {
                alert('Erro ao adicionar item. Tente novamente.');
                $btn.prop('disabled', false);
            });
        });

        return false;
    });

    // Initialize Slick Carousel for Mais Pedidos
    (function() {
        'use strict';

        function initMaisVendidosCarousel() {
            const carousel = document.querySelector('.mais-vendidos-slick');

            if (!carousel || carousel.children.length === 0) {
                console.log('[MAIS_VENDIDOS] Carousel não encontrado ou vazio');
                return;
            }

            // Check if Slick is available
            if (typeof $ === 'undefined' || typeof $.fn.slick === 'undefined') {
                console.error('[MAIS_VENDIDOS] Slick or jQuery not loaded!');
                return;
            }

            // Verifica se já foi inicializado
            var $carousel = $(carousel);
            if ($carousel.hasClass('slick-initialized')) {
                console.log('[MAIS_VENDIDOS] Slick já inicializado');
                return;
            }

            try {
                $('.mais-vendidos-slick').slick({
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    arrows: false,
                    dots: false,
                    pauseOnHover: true,
                    pauseOnFocus: false,
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
                console.error('[MAIS_VENDIDOS] ❌ Slick init error:', error);
            }
        }

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(initMaisVendidosCarousel, 100);
            });
        } else {
            setTimeout(initMaisVendidosCarousel, 100);
        }
    })();
    </script>
    </div>
    <!-- End mais-vendidos-section -->

    {{-- Mostra modal para todos os produtos que têm opções (com ou sem estoque) --}}
    @foreach ($maisVendidos as $item)
        @php
            // Só cria modal se o produto tiver opções (mesma verificação do botão)
            $temOpcoes = (isset($item['opcoes']) && !empty($item['opcoes']) && is_array($item['opcoes']) && count($item['opcoes']) > 0);

            if (!$temOpcoes) {
                continue;
            }

            $opcoes = $item['opcoes'];
            $meia = 0; // Mais vendidos não usam sistema de sabores
            $iterator = 0;
            $itemAll = []; // Não há itemAll para mais vendidos
        @endphp

        {{-- Inclui o componente modal reutilizável --}}
        @include('site.components.modal-produto', compact('item', 'opcoes', 'meia', 'iterator', 'itemAll', 'config'))
    @endforeach
@endif
