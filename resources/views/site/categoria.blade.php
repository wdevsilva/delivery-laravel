@extends('layouts.site')

@section('content')
<div class="container-fluid" style="margin-top: 20px;">
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('/') }}" class="btn btn-link">
                <i class="fa fa-arrow-left"></i> {{ $categoria->categoria_nome ?? 'Categoria' }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <input type="text" class="form-control" id="busca-produto" placeholder="Buscar produtos na categoria {{ $categoria->categoria_nome ?? '' }}..." style="border: 2px solid #28a745; border-radius: 25px; padding: 15px 20px;">
            </div>
        </div>
    </div>

    <div class="row" id="lista-produtos">
        @foreach($itens as $item)
        <div class="col-md-12 produto-item" data-nome="{{ strtolower($item->item_nome) }}">
            <div class="panel panel-default" style="margin-bottom: 15px;">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-8">
                            <h4 style="margin-top: 0;"><strong>{{ $item->item_nome }}</strong></h4>
                            <p class="text-muted" style="font-size: 12px;">{{ $item->item_obs }}</p>
                            <p class="text-success" style="font-size: 18px; font-weight: bold;">
                                R$ {{ number_format($item->item_preco, 2, ',', '.') }}
                            </p>
                        </div>
                        <div class="col-xs-4 text-right">
                            @if(!empty($item->item_foto))
                            <img src="{{ asset('midias/item/' . session('base_delivery') . '/' . $item->item_foto) }}"
                                 alt="{{ $item->item_nome }}"
                                 class="img-responsive"
                                 style="max-height: 80px; border-radius: 8px; margin-left: auto;">
                            @endif
                            <button class="btn btn-success btn-block" style="margin-top: 10px; border-radius: 50px;">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
$(document).ready(function() {
    // Busca de produtos
    $('#busca-produto').on('keyup', function() {
        var busca = $(this).val().toLowerCase();
        $('.produto-item').each(function() {
            var nome = $(this).data('nome');
            if (nome.indexOf(busca) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>
@endsection
