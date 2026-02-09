@extends('layouts.site')

@section('content')
<div class="container" id="home-content">
    <br>
    <div class="<?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
        <h5 class="text-uppercase alert text-center text-bold" style="margin-top: 20px;">
            <i class="fa fa-th-list"></i> MEUS PEDIDOS
            <br>
            <small style="font-size: 12px;">ACOMPANHE SEUS PEDIDOS</small>
        </h5>

        @if(count($pedidos) > 0)
            <select class="form-control btn-status-sel text-uppercase" style="margin-bottom: 15px;">
                <option value="0" data-status="0">FILTRAR POR STATUS DO PEDIDO...</option>
                <option value="0" data-status="0">TODOS</option>
                <option value="1" data-status="1">PENDENTES</option>
                <option value="2" data-status="2">EM PRODUÇÃO</option>
                <option value="3" data-status="3">SAIU PARA ENTREGA</option>
                <option value="4" data-status="4">ENTREGUES</option>
                <option value="5" data-status="5">CANCELADOS</option>
            </select>
            <hr>

            @foreach($pedidos as $pedido)
                <?php
                $status = \App\Models\StatusModel::check($pedido->pedido_status);
                ?>
                <div class="status-<?= $pedido->pedido_status; ?> status-all" data-status="<?= $pedido->pedido_status; ?>" data-id="<?= $pedido->pedido_id; ?>" id="tr-<?= $pedido->pedido_id; ?>" style="margin-bottom: 10px;">
                    <a href="{{ url('/detalhes-do-pedido/' . $pedido->pedido_id) }}" class="btn btn-block btn-lg btn-<?= $status->color ?>" style="text-decoration: none; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <div class="row">
                            <div class="col-xs-6 text-left">
                                <i class="fa fa-shopping-bag"></i> <b>Pedido #<?= $pedido->pedido_id; ?></b>
                                <br>
                                <small style="margin-top: 5px; display: block;"><?= $status->icon ?></small>
                            </div>
                            <div class="col-xs-6 text-right">
                                <i class="fa fa-clock-o"></i>
                                <?= date('d/m/Y H:i', strtotime($pedido->pedido_data)); ?>
                                <br>
                                <span class="text-bold" style="font-size: 16px; margin-top: 5px; display: block;">Total: R$ <?= \App\Helpers\Currency::moeda($pedido->pedido_total) ?></span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        @else
            <h5 class="text-center alert alert-warning">Você ainda não possui nenhum pedido!</h5>
            <p>
                <br>
                <a class="btn btn-success btn-block" href="{{ url('/') }}">
                    <i class="fa fa-shopping-cart"></i>
                    Faça seu primeiro pedido agora
                </a>
            </p>
        @endif
    </div>
</div>

<script type="text/javascript">
    var currentUri = 'pedidos';
    var baseUri = '{{ url('/') }}';

    // Filtro de status
    $('.btn-status-sel').change(function() {
        var status = $(this).val();

        if (status == '0') {
            $('.status-all').show();
        } else {
            $('.status-all').hide();
            $('.status-' + status).show();
        }
    });
</script>
@endsection
