@extends('layouts.app')

@section('title', $config->config_nome ?? 'Delivery')

@section('content')
<div class="container">
    <!-- Header da Loja -->
    <header>
        <div class="brand">
            @if($config->config_foto)
                <img src="{{ asset('midias/' . $config->config_foto) }}" alt="{{ $config->config_nome }}" class="logo-img">
            @else
                <div class="logo">{{ substr($config->config_nome, 0, 1) }}</div>
            @endif
            <div class="store-info">
                <div class="store-name">{{ $config->config_nome }}</div>
                <div class="store-sub">
                    <i class="bi bi-geo-alt"></i> Centro
                </div>
            </div>
        </div>

        <div class="status-row">
            @if($config->config_aberto)
                <span class="badge-success">
                    <i class="bi bi-check-circle-fill"></i> Aberto
                </span>
            @else
                <span class="badge-danger">
                    <i class="bi bi-x-circle-fill"></i> Fechado
                </span>
            @endif
            <button class="action-btn">
                <i class="bi bi-clock"></i> Nossos Horários
            </button>
        </div>
    </header>

    <!-- Mais Pedidos -->
    @if($maisPedidos->count() > 0)
    <section class="mais-vendidos-section">
        <h3 class="section-title">Mais Pedidos</h3>
        <div class="mais-vendidos-slick">
            @foreach($maisPedidos as $item)
                <div>
                    <div class="card" onclick="window.location.href='#'">
                        <div class="card-img-wrapper">
                            @if($item->item_promo || $item->item_promocao)
                                <div class="tags-container">
                                    @if($item->item_promo)
                                        <span class="tag-hot">★ Mais vendido</span>
                                    @endif
                                    @if($item->item_promocao)
                                        <span class="tag-promo">★ Promoção</span>
                                    @endif
                                </div>
                            @endif

                            @if($item->item_foto)
                                <img src="{{ asset('midias/' . $item->item_foto) }}" alt="{{ $item->item_nome }}">
                            @else
                                <img src="{{ asset('midias/img/sem-foto.png') }}" alt="Produto sem foto">
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="card-category-conteudo">
                                <div class="card-category-mais-vendidos">{{ $item->categoria ? $item->categoria->categoria_nome : 'DIVERSOS' }}</div>
                                <div class="card-title-mais-vendidos">{{ $item->item_nome }}</div>
                                @if($item->item_desc)
                                    <div class="card-description">{{ Str::limit($item->item_desc, 50) }}</div>
                                @endif
                            </div>
                            <div class="card-price-mais-vendidos">R$ {{ number_format($item->item_preco, 2, ',', '.') }}</div>
                            @if($item->item_estoque > 0)
                                <button class="btn-add"><i class="bi bi-cart-plus"></i> Adicionar</button>
                            @else
                                <button class="btn-add btn-disabled" disabled>+ SEM ESTOQUE</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Promoções -->
    @if($promocoes->count() > 0)
    <section class="mais-vendidos-section">
        <h3 class="section-title"><i class="bi bi-star-fill" style="color: #f6b24d;"></i> Promoção</h3>
        <div class="mais-vendidos-slick">
            @foreach($promocoes as $item)
                <div>
                    <div class="card" onclick="window.location.href='#'">
                        <div class="card-img-wrapper">
                            <div class="tags-container">
                                <span class="tag-promo">★ Promoção</span>
                            </div>

                            @if($item->item_foto)
                                <img src="{{ asset('midias/' . $item->item_foto) }}" alt="{{ $item->item_nome }}">
                            @else
                                <img src="{{ asset('midias/img/sem-foto.png') }}" alt="Produto sem foto">
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="card-category-conteudo">
                                <div class="card-category-mais-vendidos">{{ $item->categoria ? $item->categoria->categoria_nome : 'DIVERSOS' }}</div>
                                <div class="card-title-mais-vendidos">{{ $item->item_nome }}</div>
                                @if($item->item_desc)
                                    <div class="card-description">{{ Str::limit($item->item_desc, 50) }}</div>
                                @endif
                            </div>
                            <div class="card-price-mais-vendidos">R$ {{ number_format($item->item_preco, 2, ',', '.') }}</div>
                            @if($item->item_estoque > 0)
                                <button class="btn-add"><i class="bi bi-cart-plus"></i> Adicionar</button>
                            @else
                                <button class="btn-add btn-disabled" disabled>+ SEM ESTOQUE</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    <!-- Categorias -->
    <section>
        <h3 class="section-title">Categorias</h3>
        <div class="categories">
            @foreach($categorias as $categoria)
                <a href="{{ route('categoria.show', $categoria->categoria_id) }}" class="cat-card">
                    @if($categoria->categoria_img)
                        <img src="{{ asset('midias/' . $categoria->categoria_img) }}" alt="{{ $categoria->categoria_nome }}">
                    @else
                        <img src="{{ asset('midias/img/sem-foto.png') }}" alt="Categoria">
                    @endif
                    <div class="cat-title">{{ $categoria->categoria_nome }}</div>
                </a>
            @endforeach
        </div>
    </section>
</div>

<!-- Botão Carrinho Flutuante -->
<div class="cart-float" onclick="window.location.href='{{ route('carrinho.index') }}'">
    <i class="bi bi-cart3" style="font-size: 20px;"></i>
    <span id="cart-count">0</span>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
<script>
$(document).ready(function(){
    $('.mais-vendidos-slick').slick({
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: true,
        dots: false,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1.5
                }
            }
        ]
    });
});
</script>
@endpush
