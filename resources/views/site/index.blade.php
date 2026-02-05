@extends('layouts.site')

@section('content')
    <div class="container" role="main">

        @include('site.components.topo')

        <!-- Mais Vendidos -->
        @if (count($maisVendidos) > 0)
            <div class="mais-vendidos-section">
                <h2 class="section-title">Mais Pedidos</h2>
                <div class="mais-vendidos-slick" id="topSold" aria-label="Carrossel dos itens mais pedidos">
                    @foreach ($maisVendidos as $item)
                        <article class="card" data-id="{{ $item->item_id }}">
                            <div class="card-img-wrapper" style="position: relative;">
                                @if ($item->item_foto)
                                    <img src="{{ asset('assets/item/' . $item->item_foto) }}" alt="{{ $item->item_nome }}"
                                        onerror="this.src='{{ asset('assets/img/sem_foto.jpg') }}'">
                                @else
                                    <img src="{{ asset('assets/img/sem_foto.jpg') }}" alt="{{ $item->item_nome }}">
                                @endif

                                <div class="tags-container">
                                    @if ($item->media_vendida > 0)
                                        <div class="tag-hot" data-id="{{ $item->item_id }}" aria-hidden="true">🔥 Mais
                                            vendido</div>
                                    @endif
                                    @if ($item->item_promo == 1)
                                        <div class="tag-promo" data-id="{{ $item->item_id }}" aria-hidden="true">💥
                                            Promoção</div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-category-conteudo">
                                    <div class="card-category-mais-vendidos"><b>{{ $item->categoria ?? '' }}</b></div>
                                    <div class="card-title-mais-vendidos"><b>{{ $item->item_nome }}</b></div>
                                    @if ($item->item_obs)
                                        <div class="card-description"><strong>Ingredientes:</strong>
                                            {{ strip_tags($item->item_obs) }}</div>
                                    @endif
                                    @if ($item->item_desc)
                                        <div class="card-description"><strong>Descrição Breve:</strong>
                                            {{ strip_tags($item->item_desc) }}</div>
                                    @endif
                                </div>
                                <div class="card-price-mais-vendidos">
                                    <b>R$ {{ number_format($item->item_preco, 2, ',', '.') }}</b>
                                </div>
                                <button class="btn-add mais-vendidos-btn-add" data-id="{{ $item->item_id }}"
                                    data-nome="{{ $item->item_nome }}" data-obs="{{ strip_tags($item->item_obs ?? '') }}"
                                    data-categoria="{{ $item->categoria }}"
                                    data-categoria-nome="{{ $item->categoria ?? '' }}"
                                    data-preco="{{ $item->item_preco }}" data-cod="{{ $item->item_codigo }}"
                                    title="adicionar à sacola">
                                    Adicionar
                                </button>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Categorias -->
        <div class="categorias-section">
            <h2 class="section-title">Categorias</h2>
            <div class="categories" aria-label="Categorias">
                @foreach ($categorias as $categoria)
                    <div class="cat-card category-card-link" role="button" tabindex="0" aria-pressed="false"
                        data-categoria="{{ $categoria->categoria_id }}" data-meia="{{ $categoria->categoria_meia ?? 1 }}"
                        data-nome="{{ $categoria->categoria_nome }}">
                        @if ($categoria->categoria_foto)
                            <img src="{{ asset('assets/categoria/' . $categoria->categoria_foto) }}"
                                alt="{{ strtolower($categoria->categoria_nome) }}"
                                data-categoria="{{ $categoria->categoria_id }}"
                                onerror="this.src='{{ asset('assets/img/sem_foto.jpg') }}'">
                        @else
                            <img src="{{ asset('assets/img/sem_foto.jpg') }}"
                                alt="{{ strtolower($categoria->categoria_nome) }}">
                        @endif
                        <div class="cat-title" data-categoria="{{ $categoria->categoria_id }}">
                            {{ strtolower($categoria->categoria_nome) }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Badge de Fidelidade -->
        @auth
        <div id="fidelidade-badge" class="fidelidade-badge" style="display: none;">
            <div class="fidelidade-content">
                <div class="fidelidade-icon">
                    <i class="fa fa-gift"></i>
                </div>
                <div class="fidelidade-info">
                    <strong id="fidelidade-titulo">Programa Fidelidade</strong>
                    <p id="fidelidade-mensagem">Carregando...</p>
                    <div class="fidelidade-progress">
                        <div class="progress-bar">
                            <div id="fidelidade-progress-fill" class="progress-fill" style="width: 0%"></div>
                        </div>
                        <span id="fidelidade-progress-text" class="progress-text">0/4</span>
                    </div>
                </div>
                <button class="btn-fechar" onclick="fecharFidelidadeBadge()">×</button>
            </div>
        </div>
        @endauth
    </div>

    <!-- Rodapé Fixo -->
    @include('site.components.footer')

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Inicializar Slick Carousel para Mais Vendidos
                $('#topSold').slick({
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
                    responsive: [{
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
            });

            var categoryCards = document.querySelectorAll('.category-card-link');

            categoryCards.forEach(function(card) {
                card.addEventListener('click', function() {
                    var categoriaId = this.getAttribute('data-categoria');
                    var categoriaMeia = parseInt(this.getAttribute('data-meia')) || 1;
                    var categoriaNome = this.getAttribute('data-nome');

                    // Redireciona para página de categoria (comportamento atual)
                    window.location.href = baseUrl + "/categoria/" + categoriaId;
                });
            });

            $('#busca').val('A');
            $('.add-item').addClass('returnIndex');

            // Aguarda carrinho.js carregar antes de chamar rebind_reload
            $(document).ready(function() {
                if (typeof rebind_reload === 'function') {
                    rebind_reload();
                }

                // Esconde o loading quando tudo estiver carregado
                setTimeout(function() {
                    $('#page-loader').addClass('hidden');
                }, 500);
            });

            // Carregar status do programa de fidelidade
            @auth
            $.ajax({
                url: baseUrl + '/fidelidade/status_desconto_frequencia',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        // Atualizar badge
                        $('#fidelidade-mensagem').text(data.mensagem);
                        $('#fidelidade-progress-fill').css('width', (data.progresso / data.progresso_total * 100) + '%');
                        $('#fidelidade-progress-text').text(data.progresso + '/' + data.progresso_total);

                        // Se tem desconto, destacar
                        if (data.tem_desconto) {
                            $('#fidelidade-badge').addClass('tem-desconto');
                            $('#fidelidade-titulo').html('<i class="fa fa-star"></i> VOCÊ GANHOU ' + data.percentual_desconto + '% OFF!');
                        }

                        // Mostrar badge
                        $('#fidelidade-badge').fadeIn();

                        // Auto-fechar após 10 segundos (se não tiver desconto)
                        if (!data.tem_desconto) {
                            setTimeout(function() {
                                $('#fidelidade-badge').fadeOut();
                            }, 10000);
                        }
                    }
                },
                error: function() {
                    console.log('Erro ao carregar status de fidelidade');
                }
            });
            @endauth

            // Função para fechar o badge
            window.fecharFidelidadeBadge = function() {
                $('#fidelidade-badge').fadeOut();
            };
        </script>
    @endpush

    @push('scripts')
        <!-- Scripts do carrinho -->
        <script type="text/javascript" src="{{ asset('assets/js/number.js') }}"></script>
        <script src="{{ asset('assets/js/howler.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/carrinho.js') }}?v={{ time() }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/modal-produto.js') }}"></script>

        <!-- Verificação de atualização de pedido -->
        @auth
        <script>
            function verificarAtualizacao(url, tituloAlerta) {
                $.getJSON(url).done(function(rs) {
                    if (rs != 0) {
                        __alert__(tituloAlerta, 'Pedido ' + rs.text, rs.color);
                        var pedido = baseUrl + '/detalhes-do-pedido/' + rs.id + '/';
                        if (currentUri !== undefined && currentUri == 'pedido') {
                            window.location.href = pedido;
                        }
                    }
                });
            }

            // Verifica pedido a cada 5 segundos
            setInterval(function() {
                verificarAtualizacao(baseUrl + "/pedido/checkPedido/", 'Atualização de pedido');
            }, 5000);
        </script>
        @endauth
    @endpush
@endsection
