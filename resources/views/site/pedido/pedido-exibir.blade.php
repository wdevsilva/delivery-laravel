@extends('layouts.site')

@section('content')
<div class="container" id="home-content">
        <br>
        <div class="<?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
            <br>
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
                            <?php
                            if ($pedido->pedido_taxa_cartao != '' && floatval($pedido->pedido_taxa_cartao) > 0) {
                            ?>
                                TAXA CARTÃO R$ <?= \App\Helpers\Currency::moeda($pedido->pedido_taxa_cartao, 2, ',', '.') ?><br>
                            <?php } ?>
                            <span class="text-bold"> TOTAL R$ <?= \App\Helpers\Currency::moeda($pedido->pedido_total); ?></span>
                            <?php

                            if ($pedido->pedido_troco != '' && $pedido->pedido_troco != '0.00' && $pedido->pedido_troco > 0) { ?>
                                <br>
                                <span class="text-bold"> TROCO R$ <?= \App\Helpers\Currency::moeda($pedido->pedido_troco); ?></span>
                            <?php } ?>
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
            <?php
            if (isset($lista)) :

                $re_id = $pedido->pedido_id;
                $cliente = $cliente;
                $resumo = "*RESUMO DO PEDIDO*\n";
                $resumo .= "Número do Pedido: $re_id \n";
                $resumo .= "Nome: $cliente->cliente_nome \n";
                $resumo .= "Telefone: $cliente->cliente_fone2 \n";

                foreach ($lista as $cart) : ?>
                    <div class="row">
                        <div class="ol-md-5 col-xs-7">
                            <p class="text-capitalize">
                                <?= $cart->lista_qtde ?>
                                <small class="text-muted">x</small>
                                <?= mb_strtolower($cart->categoria_nome) ?>
                                <?php if (strrpos($cart->lista_item_desc ?? '', '1/2') === false) { ?>
                                    - <?= mb_strtolower($cart->item_nome) ?>
                                <?php } ?>
                                <br>
                                <small class="text-muted">
                                    <?php
                                    if (strlen($cart->lista_item_desc ?? '') >= 0) : ?>
                                        <?= mb_strtolower($cart->item_obs) ?>
                                    <?php endif; ?>
                                    <?= $cart->lista_item_desc ?? '' ?>
                                </small>
                            </p>
                        </div>
                        <div class="col-md-2 col-xs-5">
                            R$ <?= \App\Helpers\Currency::moeda($cart->lista_opcao_preco * $cart->lista_qtde) ?>
                        </div>
                        <?php if (isset($cart->lista_promocao_id) != '') { ?>
                            <div class="text-capitalize well-sm well">
                                <span class="text-bold">
                                    <?= $cart->lista_promocao_premio_produto ?>
                                </span>
                                <small class="text-muted pull-right">
                                    <span style="font-size: 9px">x</span>
                                    <?= $cart->lista_promocao_premio_qtd ?>
                                </small>
                                <br>
                                <p>
                                    <small class="pull-right text-muted text-bold">
                                        GRÁTIS
                                    </small>
                                </p>
                            </div>
                        <?php } ?>
                    </div>
                    <?php
                    $re_preco = \App\Helpers\Currency::moeda($cart->lista_opcao_preco);
                    $resumo .= "Item: $cart->lista_item_nome x $cart->lista_qtde - R$ $re_preco \n";
                    if (strip_tags($cart->lista_item_desc ?? '') != '') {
                        $resumo .= "($cart->lista_item_desc)\n";
                    }
                    $resumo .= "\n";

                endforeach;

                //EXIBE O PRÊMIO DA COMPRA
                if (isset($lista_premio)) {
                    foreach ($lista_premio as $cartPremio) : ?>
                        <div class="rows">
                            <div class="text-capitalize well-sm well">
                                <span class="text-bold">
                                    <?= $cartPremio->promocao_produto ?>
                                </span>
                                <small class="text-muted pull-right">
                                    <span style="font-size: 9px">x</span>
                                    <?= $cartPremio->promocao_qtd ?>
                                </small>
                                <br>
                                <p>
                                    <small class="pull-right text-muted text-bold">
                                        GRÁTIS
                                    </small>
                                </p>
                            </div>
                        </div>
                <?php
                    endforeach;
                }

                $re_obs = trim($pedido->pedido_obs);
                $re_obs_pagto = trim($pedido->pedido_obs_pagto);
                $re_total = \App\Helpers\Currency::moeda($pedido->pedido_total);
                $prazo = $pedido->pedido_entrega_prazo;
                $re_obs = ($re_obs != "") ? "Obs: $re_obs \n" : "";
                $taxa_entrega = \App\Helpers\Currency::moeda($pedido->pedido_entrega);
                $resumo .= "Taxa de entrega: R$  $taxa_entrega \n";
                if ($prazo != "") {
                    $resumo .= "Tempo estimado: $prazo \n";
                }
                $resumo .= "*Total: R$ $re_total*\n";
                $resumo .= "$re_obs_pagto \n";
                ?>
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
                    <?php $end = $endereco; ?>
                    <?php
                    $compl = ($end->endereco_complemento != "") ? $end->endereco_complemento . " - " : '';
                    $ref = ($end->endereco_referencia != "") ? " (" . $end->endereco_referencia . ") " : '';
                    $endereco_full = ucfirst("$end->endereco_endereco, $end->endereco_numero, $compl  $end->endereco_bairro - $end->endereco_cidade $ref  ");
                    ?>
                    <h5 class="text-uppercase text-bold">Entregar em: <?= strtoupper($end->endereco_nome) ?></h5>
                    <?= $endereco_full ?>
                    <?php $resumo .= "Local de entrega: $endereco_full \n"; ?>
                    <?php $resumo .= "$re_obs \n \n"; ?>
                    <Br><small>Tempo estimado: <?= $prazo ?></small>
                <?php endif; ?>
                <?php if (isset($pedido->retirar_no_local)) : ?>
                    <h5 class="text-uppercase text-bold">Retirar no local</h5>
                    <p><a href="http://maps.google.com/maps?daddr=<?= $config->config_endereco; ?>&amp;ll=" target="__blank" class="maps" role="button" data-toggle="popover" title="Google Maps" data-content="Clique para abrir."><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $config->config_endereco; ?></a></p>
                    <?php $resumo .= "Local de entrega: Irá retirar no local \n"; ?>
                    <?php $resumo .= "$re_obs \n \n"; ?>
                    <hr>
                <?php endif; ?>
                <?php if (isset($_GET['new'])) { ?>
                    <h5 class="text-uppercase alert alert-success text-center">
                        Pedido realizado com sucesso!<br><br>
                        Manteremos você informado(a) sempre que a nossa cozinha alterar o status do seu pedido!
                    </h5>
                <?php } ?>
                <hr>
                <?php
                // Exibir QR Code PIX se disponível
                if (isset($pixData) && $pixData !== null) {
                ?>
                    <div class="alert alert-info">
                        <label>QrCode:</label>
                        <center><img src="data:image/png;base64, <?= $pixData['image'] ?>" style="width: 20%;"></center>
                        <br>
                        <label>Chave Pix:</label>
                        <textarea class="form-control" id="pix" rows="4" readonly><?= $pixData['payload'] ?></textarea>
                        <br>
                        <center><button class="btn btn-info" style="margin: 0 auto;" onclick="copyToClipboradFunc()">Copiar Chave</button></center>
                    </div>

                    <?php if ($_SESSION['base_delivery'] == 'sorvanna') { ?>
                        <div class="alert alert-warning">Após o pagamento, favor enviar o comprovante para
                            <a href="https://api.whatsapp.com/send?phone=5585991973141" target="_blank">
                                <i class="fa fa-whatsapp" aria-hidden="true"></i> Whatsapp
                            </a> para iniciarmos o seu pedido
                            <br><br>
                            Caso não consiga realizar o pagamento pelo QrCode ou chave pix a cima,
                            Você pode estar realizando o pagamento direto para chave: <b><?= $config->config_chave_pix ?></b>
                        </div>
                    <?php } else { ?>
                        <div class="alert alert-warning">Após o pagamento, favor enviar o comprovante para
                            <a href="https://api.whatsapp.com/send?phone=55<?= preg_replace('/\D/', '', $config->config_fone1) ?>" target="_blank">
                                <i class="fa fa-whatsapp" aria-hidden="true"></i> Whatsapp
                            </a> para iniciarmos o seu pedido
                        </div>
                    <?php } ?>
                <?php } ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        var currentUri = 'pedido';
        var baseUri = '{{ url('/') }}';

        rebind_reload();

        // Auto-refresh do status do pedido a cada 5 segundos
        var pedidoId = <?= $pedido->pedido_id ?>;
        var lastStatus = <?= $pedido->pedido_status ?>;

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

        function copyToClipboradFunc() {
            let copiedText = document.getElementById("pix");
            copiedText.select();
            copiedText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            alert('Chave copiada com sucesso');
        }
    </script>
@endsection
