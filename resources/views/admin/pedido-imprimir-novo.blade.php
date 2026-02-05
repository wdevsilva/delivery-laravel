<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- Argon CSS -->
    <link type="text/css" href="http://food263.olhardigital.xyz/argon/css/argon.css?v=1.0.0" rel="stylesheet">
    <!-- Argon CSS -->
    <link type="text/css" href="http://food263.olhardigital.xyz/custom/css/custom.css" rel="stylesheet">
    <style>
        body {
            margin-top: 20px;
            color: #484b51;
        }

        .text-secondary-d1 {
            color: #728299 !important;
        }

        .page-header {
            margin: 0 0 1rem;
            padding-bottom: 1rem;
            padding-top: .5rem;
            border-bottom: 1px dotted #e2e2e2;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: justify;
            justify-content: space-between;
            -ms-flex-align: center;
            align-items: center;
        }

        .page-title {
            padding: 0;
            margin: 0;
            font-size: 1.75rem;
            font-weight: 300;
        }

        .brc-default-l1 {
            border-color: #dce9f0 !important;
        }

        .ml-n1,
        .mx-n1 {
            margin-left: -.25rem !important;
        }

        .mr-n1,
        .mx-n1 {
            margin-right: -.25rem !important;
        }

        .mb-4,
        .my-4 {
            margin-bottom: 1.5rem !important;
        }

        hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, .1);
        }

        .text-grey-m2 {
            color: #888a8d !important;
        }

        .text-success-m2 {
            color: #86bd68 !important;
        }

        .font-bolder,
        .text-600 {
            font-weight: 600 !important;
        }

        .text-110 {
            font-size: 110% !important;
        }

        .text-blue {
            color: #478fcc !important;
        }

        .pb-25,
        .py-25 {
            padding-bottom: .75rem !important;
        }

        .pt-25,
        .py-25 {
            padding-top: .75rem !important;
        }

        .bgc-default-tp1 {
            background-color: #5e72e4 !important;
        }

        .bgc-default-l4,
        .bgc-h-default-l4:hover {
            background-color: #f3f8fa !important;
        }

        .page-header .page-tools {
            -ms-flex-item-align: end;
            align-self: flex-end;
        }

        .btn-light {
            color: #757984;
            background-color: #f5f6f9;
            border-color: #dddfe4;
        }

        .w-2 {
            width: 1rem;
        }

        .text-120 {
            font-size: 120% !important;
        }

        .text-primary-m1 {
            color: #4087d4 !important;
        }

        .text-danger-m1 {
            color: #dd4949 !important;
        }

        .text-blue-m2 {
            color: #68a3d5 !important;
        }

        .text-150 {
            font-size: 150% !important;
        }

        .text-60 {
            font-size: 60% !important;
        }

        .text-grey-m1 {
            color: #7b7d81 !important;
        }

        .align-bottom {
            vertical-align: bottom !important;
        }

        body {
            background-color: #e9ecef
        }

        #print_area {
            border-radius: 20px;
            padding-top: 10px;
            background-color: #ffffff
        }

        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <div id="print_area" style="width:393px; margin-top:-13px; margin-left:-15px" class="card-body">
        <center>
            <h5>CUPOM NÃO FISCAL</h5>
            <small>
                <b><?= strtoupper($data['config']->config_nome) ?></b></br>
                <?= strtoupper($data['config']->config_endereco) ?><br>
                <?= $data['config']->config_fone1 ?><br>
            </small>
        </center>
        -------------------------------------------------------
        <center>
            <small>
                <b>DATA PEDIDO</b> <?= date('d/m/Y H:i', strtotime($data['pedido']->pedido_data)) ?><br>
                <b>PEDIDO #</b><?= $data['pedido']->pedido_id ?> |
                <b>Nº ENTREGA #</b><?= str_pad($data['pedido']->pedido_numero_entrega, 2, 0, STR_PAD_LEFT) ?>
            </small>
        </center>
        -------------------------------------------------------
        <h6 class="heading-small"><b>ITENS DO PEDIDO</b></h6>
        <small>
            <?php
            $totalSemTaxa = '';
            $subtotal = 0;
            foreach ($data['lista'] as $key => $cart) {
                $subtotal += $cart->lista_opcao_preco * $cart->lista_qtde;
            ?>
                <?= $cart->lista_qtde ?><small>x</small>
                <?= $cart->categoria_nome ?>
                <?php if (strrpos($cart->lista_item_desc, '1/2') === false) {
                    echo ' - ' . strtoupper($cart->lista_opcao_nome);
                }
                if (strip_tags($cart->lista_item_desc) != '') { ?>
                    <small>(<?= strip_tags(strtolower($cart->lista_item_desc)) ?>)</small>
                <?php } ?>
                <div class="pull-right">
                    R$ <?= Currency::moeda($cart->lista_opcao_preco * $cart->lista_qtde) ?>
                </div>
                <br>
                <?php $totalSemTaxa += $cart->lista_opcao_preco * $cart->lista_qtde;
            }
            //SE HOUVER PROMOÇÃO GRANHA
            if (isset($data['lista_premio'])) {
                foreach ($data['lista_premio'] as $key => $cartPremio) { ?>
                    <?= $cartPremio->promocao_qtd ?><small>x</small>
                    <?= (strtoupper($cartPremio->promocao_produto)) ?>
                    <div class="pull-right">
                        GRÁTIS
                    </div>
                <?php  }
            }
            if ($data['pedido']->pedido_obs != "") { ?>
                <br>
                <b>OBS: <?= $data['pedido']->pedido_obs ?></b>
            <?php } ?>
        </small>
        <br>
        -------------------------------------------------------
        <small>
            <b>SUB-TOTAL:</b>
            <div class="pull-right">
                R$<?= Currency::moeda($subtotal) ?>
            </div><br>
            <?php
            $dadosCupom = (new cupomModel)->get_desconto_cupom($data['pedido']->pedido_id);

            if (!empty($dadosCupom)) {
            ?>
                <b>
                    DESCONTO:
                    <?php if ($dadosCupom->cupom_tipo == '1') { ?>
                        R$<?= Currency::moeda($dadosCupom->cupom_valor) ?>
                    <?php } else { ?>
                        <?= $dadosCupom->cupom_percent ?>%
                    <?php } ?>
                </b><br>
            <?php } ?>
            <b>TAXA DE ENTREGA:</b>
            <div class="pull-right">
                R$<?= Currency::moeda($data['pedido']->pedido_entrega) ?>
            </div><br>
            <?php
            if ($_SESSION['base_delivery'] == 'dgustsalgados') {
                if ($data['pedido']->pedido_id_pagto == 2 || $data['pedido']->pedido_id_pagto == 3) {
            ?>
                    <b>TAXA CARTAO:</b>
                    <div class="pull-right">
                        R$2,00
                    </div><br>
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
                    <b>TAXA CARTAO:</b>
                <?php } ?>
            <?php } ?>
        </small>
        <b>TOTAL A PAGAR:</b>
        <div class="pull-right">
            <b>R$<?= Currency::moeda($data['pedido']->pedido_total); ?></b>
        </div>
        <?php if($data['pedido']->pedido_troco != '' || $data['pedido']->pedido_troco > 0){?>
        <b>TROCO:</b>
        <div class="pull-right">
            <b>R$<?= Currency::moeda($data['pedido']->pedido_troco); ?></b>
        </div>
        <?php } ?>
        <br>
        <center><b><?= ($data['pedido']->pedido_obs_pagto) ?></b></center>
        -------------------------------------------------------
        <h6 class="heading-small"><b>INFORMAÇÕES DO CLIENTE</b></h6>
        <small>
            <b>NOME:</b> <?= strtoupper(ucfirst($data['pedido']->cliente_nome)) ?></br>
            <b>CEL.:</b> <?= $data['pedido']->cliente_fone2 ?></br>
        </small>
        -------------------------------------------------------
        <h6 class="heading-small"><b>INFORMAÇÕES ENTREGA</b></h6>
        <small>
            <?php if (isset($data['endereco'])) { ?>
                <?php $end = $data['endereco']; ?>
                <b>END. ENTREGA:</b> <?= (strtoupper($end->endereco_endereco)) ?>,<?= $end->endereco_numero ?>,
                <?php if ($end->endereco_complemento != "") { ?>
                    <?= (strtoupper($end->endereco_complemento)) ?> -
                <?php } ?>
                <?= (strtoupper($end->endereco_bairro)) ?> -
                <?= (strtoupper($end->endereco_cidade)) ?>,
                <?= (strtoupper($end->endereco_nome)) ?>
                <?php if ($end->endereco_referencia != "") { ?>
                    <br>
                    <b>PONTO DE REF.:</b> <?= (strtoupper($end->endereco_referencia)) ?>
                <?php } ?>
            <?php } else { ?>
                RETIRAR NO LOCAL
            <?php } ?>
        </small>
    </div>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script>
        // $('#printBtn').on("click", function() {
        //     window.print();
        //     window.close();
        // });
        setTimeout(function() {
            window.print();
            window.close();
        }, 300);
        
        
    </script>
</body>

</html>