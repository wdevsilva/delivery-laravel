@extends('layouts.site')

@section('content')
@php
@session_start();
$isMobile = preg_match('/Mobile|Android|iPhone|iPad/', request()->header('User-Agent'));
@endphp

<div class="container" id="home-content">
    <br>
    <div class="<?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
        <br>
        <?php $status = \App\Models\Status::check($pedido->pedido_status); ?>

        <div class="well well-sm">
            <div class="row">
                <div class="col-xs-6">
                    <span>
                        PEDIDO #<?= $pedido->pedido_id ?><br>
                        Nº ENTREGA #<?= str_pad($pedido->pedido_numero_entrega, 2, 0, STR_PAD_LEFT) ?><br>
                        <br>
                        <?php if ($pedido->pedido_entrega > 0) : ?>
                            TAXA ENTREGA R$ <?= \App\Helpers\Currency::moeda($pedido->pedido_entrega) ?><br>
                        <?php endif; ?>
                        <?php if ($pedido->pedido_taxa_cartao != '' && floatval($pedido->pedido_taxa_cartao) > 0) : ?>
                            TAXA CARTÃO R$ <?= \App\Helpers\Currency::moeda($pedido->pedido_taxa_cartao, 2, ',', '.') ?><br>
                        <?php endif; ?>
                        <span class="text-bold"> TOTAL R$ <?= \App\Helpers\Currency::moeda($pedido->pedido_total); ?></span>
                        <?php if ($pedido->pedido_troco != '' && $pedido->pedido_troco != '0.00' && $pedido->pedido_troco > 0) : ?>
                            <br>
                            <span class="text-bold"> TROCO R$ <?= \App\Helpers\Currency::moeda($pedido->pedido_troco); ?></span>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="col-xs-6">
                    <small class="pull-right">
                        <i class="fa fa-clock-o"></i>
                        <?= date('d/m/Y H:i', strtotime($pedido->pedido_data)); ?>
                        <br>
                    </small>
                </div>
            </div>
        </div>

        <?php if (isset($lista)) : ?>
            <?php foreach ($lista as $cart) : ?>
                <div class="row">
                    <div class="ol-md-5 col-xs-7">
                        <p class="text-capitalize">
                            <?= $cart->lista_qtde ?>
                            <small class="text-muted">x</small>
                            <?= mb_strtolower($cart->categoria_nome) ?>
                            <?php if (strrpos($cart->lista_item_desc ?? '', '1/2') === false) : ?>
                                - <?= mb_strtolower($cart->item_nome) ?>
                            <?php endif; ?>
                            <br>
                            <small class="text-muted">
                                <?php if (strlen($cart->lista_item_desc ?? '') >= 0) : ?>
                                    <?= mb_strtolower($cart->item_obs) ?>
                                <?php endif; ?>
                                <?= $cart->lista_item_desc ?? '' ?>
                            </small>
                        </p>
                    </div>
                    <div class="col-md-2 col-xs-5">
                        R$ <?= \App\Helpers\Currency::moeda($cart->item_preco * $cart->lista_qtde) ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if ($pedido->pedido_obs != "") : ?>
                <h5 class="text-uppercase text-bold">Observações</h5>
                <small class="text-muted"><?= $pedido->pedido_obs ?></small>
                <hr>
            <?php endif; ?>

            <!-- BOX DE STATUS DO PEDIDO -->
            <div class="alert alert-<?= $status->color ?> text-center" id="status-pedido-box" style="margin: 20px 0; padding: 20px; border-radius: 8px;">
                <h4 class="text-uppercase" style="margin: 0;">STATUS DO PEDIDO</h4>
                <h2 id="status-icon" style="margin: 10px 0;"><?= $status->icon ?></h2>
            </div>
            <hr>

            <?php if (isset($endereco)) : ?>
                <?php
                $compl = ($endereco->endereco_complemento != "") ? $endereco->endereco_complemento . " - " : '';
                $ref = ($endereco->endereco_referencia != "") ? " (" . $endereco->endereco_referencia . ") " : '';
                $endereco_full = ucfirst("$endereco->endereco_endereco, $endereco->endereco_numero, $compl  $endereco->endereco_bairro - $endereco->endereco_cidade $ref  ");
                ?>
                <h5 class="text-uppercase text-bold">Entregar em: <?= strtoupper($endereco->endereco_nome) ?></h5>
                <?= $endereco_full ?>
                <br><small>Tempo estimado: <?= $pedido->pedido_entrega_prazo ?></small>
            <?php endif; ?>

            <?php if ($pedido->pedido_local == 0) : ?>
                <h5 class="text-uppercase text-bold">Retirar no local</h5>
                <p><a href="http://maps.google.com/maps?daddr=<?= $config->config_endereco; ?>&amp;ll=" target="__blank" class="maps" role="button"><i class="fa fa-map-marker" aria-hidden="true"></i> <?= $config->config_endereco; ?></a></p>
                <hr>
            <?php endif; ?>

            <?php if (isset($_GET['new'])) : ?>
                <h5 class="text-uppercase alert alert-success text-center">
                    Pedido realizado com sucesso!<br><br>
                    Manteremos você informado(a) sempre que a nossa cozinha alterar o status do seu pedido!
                </h5>
            <?php endif; ?>
            <hr>

        <?php endif; ?>
    </div>
</div>

<script type="text/javascript">
    var currentUri = 'pedido';

    function copyToClipboradFunc() {
        let copiedText = document.getElementById("pix");
        copiedText.select();
        copiedText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        alert('Chave copiada com sucesso');
    }

    rebind_reload();

    // Auto-refresh do status do pedido a cada 5 segundos
    var pedidoId = <?= $pedido->pedido_id ?>;
    var lastStatus = <?= $pedido->pedido_status ?>;
    var baseUri = '{{ url('/') }}';

    function checkOrderStatus() {
        $.ajax({
            url: baseUri + '/pedido/status/' + pedidoId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success && response.status !== lastStatus) {
                    lastStatus = response.status;

                    // Atualiza o box de status
                    $('#status-pedido-box').removeClass('alert-warning alert-info alert-success alert-danger')
                                            .addClass('alert-' + response.color);
                    $('#status-icon').html(response.icon);

                    console.log('🔔 Status do pedido atualizado:', response.icon);
                }
            },
            error: function() {
                console.log('⚠️ Erro ao verificar status do pedido');
            }
        });
    }

    // Verifica o status apenas se o pedido não estiver finalizado (status < 4)
    <?php if ($pedido->pedido_status < 4): ?>
    setInterval(checkOrderStatus, 5000);
    <?php endif; ?>
</script>
@endsection
