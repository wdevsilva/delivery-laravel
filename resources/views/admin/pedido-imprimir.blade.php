<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
</head>
<style>
    /* print styles */
    @media print {
        body {
            margin: 10px !important;
            padding: 10px !important;
            /*background-color: #fff;*/
            color: black;
            font-weight: 900;
            height: 100%;
        }

        p {
            margin: 0;
            padding: 0;
            line-height: 20px;
            font-weight: 900;
            font-size: 14px;
            color: black !important;
        }
    }
</style>

<body class="animated">
    <?php
    function tirarAcentos($string)
    {
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $string);
    }
    ?>
    <div id="cl-wrapper" style="width: 320px;">
        <div class="container" id="pcont">
            <div class="cl-mcontX text-center">
                <div class="block-flats text-center">
                    <?php if (isset($data['lista'])) : ?>
                        <div class="text-center">
                            DOCUMENTO NAO FISCAL<br>
                            <?= $data['config']->config_nome ?><br>
                            <?= $data['config']->config_endereco ?><br>
                            <?= $data['config']->config_fone1 ?><br>
                        </div>
                        ------------------------------------------------
                        <div class="text-center" style="color: black!important; clear: both !important; font-size: 16px;">
                            <p>
                                <strong>PEDIDO #<?= $data['pedido']->pedido_id ?></strong><br>
                                <strong>Nº ENTREGA #<?= str_pad($data['pedido']->pedido_numero_entrega, 2, 0, STR_PAD_LEFT) ?></strong><br>
                            <p style="font-family; color: black!important: 'Open Sans',arial,verdana;"><strong>DATA: <?= Timer::parse_date_br($data['pedido']->pedido_data) ?></strong></p>
                            <p style="font-family; color: black!important: 'Open Sans',arial,verdana;"><strong> CLIENTE: <?= strtoupper(ucfirst($data['pedido']->cliente_nome)) ?></strong></p>
                            <p style="font-family; color: black!important: 'Open Sans',arial,verdana;"><strong>CONTATO: <?= $data['pedido']->cliente_fone2 ?> </strong></p>
                            </p>
                        </div>
                        ------------------------------------------------
                        <div class="panel-bodys text-center" style="font-size: 16px;">
                            <div class="">
                                <?php 
                                $totalSemTaxa = '';
                                foreach ($data['lista'] as $key => $cart) : ?>
                                    <div class="item" id="list-item-<?= $cart->item_id ?>">
                                        <p class="item text-center" style="color: black!important;">
                                            <?= $cart->lista_qtde ?><small>x</small>
                                            <?= $cart->categoria_nome ?>
                                            <?php if (strrpos($cart->lista_item_desc, '1/2') === false) {
                                                echo ' - ' . strtoupper($cart->lista_opcao_nome);
                                            } ?>
                                            - R$ <?= Currency::moeda($cart->lista_opcao_preco * $cart->lista_qtde) ?>
                                            <?php if (strip_tags(tirarAcentos($cart->lista_item_desc)) != '') : ?>
                                                <center><small>(<?= strip_tags(strtolower(tirarAcentos($cart->lista_item_desc))) ?>)</small></center>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <?php
                                    $totalSemTaxa += $cart->lista_opcao_preco * $cart->lista_qtde;
                                endforeach;

                                if (isset($data['lista_premio'])) {
                                    foreach ($data['lista_premio'] as $key => $cartPremio) : ?>
                                        <div class="item">
                                            <p class="item text-center" style="color: black!important;">
                                                <?= $cartPremio->promocao_qtd ?><small>x</small>
                                                <?= tirarAcentos($cartPremio->promocao_produto) ?>
                                                - GRATIS
                                            </p>
                                        </div>
                                <?php
                                    endforeach;
                                }
                                ?>
                            </div>
                            <?php if ($data['pedido']->pedido_obs != "") : ?>
                                <div>
                                    <p style="color: black!important;">
                                        <b><strong>Observações:</strong></b>
                                        <?= $data['pedido']->pedido_obs ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                            --------------------------------------------
                            <div class="float-right pull-rights">
                                <?php
                                if ($_SESSION['base_delivery'] == 'dgustsalgados') {
                                    if ($data['pedido']->pedido_id_pagto == 2 || $data['pedido']->pedido_id_pagto == 3) {
                                ?>
                                        <p>Taxa Cartão R$ 2,00</p>
                                <?php } ?>
                                <?php } ?>
                                <?php
                                if ($_SESSION['base_delivery'] == 'paulistalanches') {
                                    if ($data['pedido']->pedido_id_pagto == 2 || $data['pedido']->pedido_id_pagto == 3) {

                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 10 && $totalSemTaxa + $data['pedido']->pedido_entrega < 20) {
                                            $taxaCartao = 0.50;
                                        }
                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 20 && $totalSemTaxa + $data['pedido']->pedido_entrega < 30) {
                                            $taxaCartao = 1.00;
                                        }
                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 30 && $totalSemTaxa + $data['pedido']->pedido_entrega < 40) {
                                            $taxaCartao = 1.50;
                                        }
                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 40 && $totalSemTaxa + $data['pedido']->pedido_entrega < 50) {
                                            $taxaCartao = 2.00;
                                        }
                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 50 && $totalSemTaxa + $data['pedido']->pedido_entrega < 60) {
                                            $taxaCartao = 2.50;
                                        }
                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 60 && $totalSemTaxa + $data['pedido']->pedido_entrega < 70) {
                                            $taxaCartao = 3.00;
                                        }
                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 70 && $totalSemTaxa + $data['pedido']->pedido_entrega < 80) {
                                            $taxaCartao = 3.50;
                                        }
                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 80 && $totalSemTaxa + $data['pedido']->pedido_entrega < 90) {
                                            $taxaCartao = 4.00;
                                        }
                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 90 && $totalSemTaxa + $data['pedido']->pedido_entrega < 100) {
                                            $taxaCartao = 4.50;
                                        }
                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 100 && $totalSemTaxa + $data['pedido']->pedido_entrega < 110) {
                                            $taxaCartao = 5.00;
                                        }
                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 110 && $totalSemTaxa + $data['pedido']->pedido_entrega < 120) {
                                            $taxaCartao = 5.50;
                                        }
                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 120 && $totalSemTaxa + $data['pedido']->pedido_entrega < 130) {
                                            $taxaCartao = 6.00;
                                        }
                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 130 && $totalSemTaxa + $data['pedido']->pedido_entrega < 140) {
                                            $taxaCartao = 6.50;
                                        }
                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 140 && $totalSemTaxa + $data['pedido']->pedido_entrega < 150) {
                                            $taxaCartao = 7.00;
                                        }
                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 150 && $totalSemTaxa + $data['pedido']->pedido_entrega < 160) {
                                            $taxaCartao = 7.50;
                                        }
                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 160 && $totalSemTaxa + $data['pedido']->pedido_entrega < 170) {
                                            $taxaCartao = 8.00;
                                        }
                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 170 && $totalSemTaxa + $data['pedido']->pedido_entrega < 180) {
                                            $taxaCartao = 8.50;
                                        }
                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 180 && $totalSemTaxa + $data['pedido']->pedido_entrega < 190) {
                                            $taxaCartao = 9.00;
                                        }
                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 190 && $totalSemTaxa + $data['pedido']->pedido_entrega < 200) {
                                            $taxaCartao = 9.50;
                                        }
                                        if ($totalSemTaxa + $data['pedido']->pedido_entrega >= 200 && $totalSemTaxa + $data['pedido']->pedido_entrega < 210) {
                                            $taxaCartao = 10.00;
                                        }                                        
                                ?>
                                        <p>Taxa Cartão R$ <?=number_format($taxaCartao,2,',','.')?></p>
                                    <?php } ?>
                                <?php } ?>
                                <p style="color: black!important;">Taxa de Entrega R$ <?= Currency::moeda($data['pedido']->pedido_entrega) ?></p>
                                <p style="color: black!important;"><strong>Total R$ <?= Currency::moeda($data['pedido']->pedido_total); ?></strong></p>
                                <?php if($data['pedido']->pedido_troco != '' || $data['pedido']->pedido_troco > 0){?>
                                    <p style="color: black!important;"><strong>Troco R$ <?= Currency::moeda($data['pedido']->pedido_troco); ?></strong></p>
                                <?php } ?>
                                <?php if (isset($data['endereco'])) : ?>
                                    <p style="color: black!important;">Entrega Estimada: <?= $data['pedido']->pedido_entrega_prazo ?></p>
                                <?php endif; ?>
                                <p style="color: black!important;"><strong><?= $data['pedido']->pedido_obs_pagto ?></strong></p>
                            </div>
                            ----------------------------------------------
                            <div style="clear: both !important;">
                                <?php if (isset($data['endereco'])) : ?>
                                    <?php $end = $data['endereco']; ?>
                                    End. entrega: <?= tirarAcentos($end->endereco_nome) ?><br>
                                    <?= tirarAcentos($end->endereco_endereco) ?><br>
                                    <?= $end->endereco_numero ?>,
                                    <?php if ($end->endereco_complemento != "") : ?>
                                        <?= tirarAcentos($end->endereco_complemento) ?> -
                                    <?php endif; ?>
                                    <?= tirarAcentos($end->endereco_bairro) ?> -
                                    <?= tirarAcentos($end->endereco_cidade) ?>
                                    <?php if ($end->endereco_referencia != "") : ?>
                                        <br>
                                        Ponto de Ref.: <?= tirarAcentos($end->endereco_referencia) ?>
                                    <?php endif; ?>
                                <?php else : ?>
                                    Retirada no Local
                                <?php endif; ?>
                            </div>
                            ------------------------------------------------
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <script src="js/jquery.js"></script>
        <script src="js/jquery.cooki/jquery.cooki.js"></script>
        <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
        <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
        <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
        <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
        <script type="text/javascript" src="js/behaviour/core.js"></script>
        <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
        <script>
            setTimeout(function() {
                window.print();
                window.close();
            }, 300);
        </script>
</body>

</html>