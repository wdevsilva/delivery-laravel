<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    text-center {
        text-align: center;
    }

    .ttu {
        text-transform: uppercase;
    }

    .printer-ticket {
        display: table !important;
        width: 80mm;
        max-width: 400px;
        font-weight: light;
        line-height: 1.3em;
    }

    .printer-ticket,
    .printer-ticket * {
        font-family: Tahoma, Geneva, sans-serif;
        font-size: 10px;
    }

    .printer-ticket th:nth-child(2),
    .printer-ticket td:nth-child(2) {
        width: 50px;
    }

    .printer-ticket th:nth-child(3),
    .printer-ticket td:nth-child(3) {
        width: 90px;
        text-align: right;
    }

    .printer-ticket th {
        font-weight: inherit;
        padding: 10px 0;
        text-align: center;
        border-bottom: 1px dashed #900;
    }

    .printer-ticket tbody tr:last-child td {
        padding-bottom: 10px;
    }

    .printer-ticket tfoot .sup td {
        padding: 10px 0;
        border-top: 1px dashed #900;
    }

    .printer-ticket tfoot .sup.p--0 td {
        padding-bottom: 0;
    }

    .printer-ticket .title {
        font-size: 1.5em;
        padding: 0 0;
    }

    .printer-ticket .top td {
        padding-top: 10px;
    }

    .printer-ticket .last td {
        padding-bottom: 10px;
    }

    #divImprimir {
        size: auto;
        margin: 2mm 2mm 2mm 2mm;
        font-family: monospace;
        font-size: 9pt;
        width: 80mm;
    }

    .boxed-md.boxed-padded {
        padding-bottom: 13px;
        padding-left: 20px;
        padding-right: 20px;
    }

    .boxed-md {
        border: 0px solid #ccc;
        margin-bottom: 14px;
        margin-top: 14px;
    }
</style>

<body class="animated">
    <?php
    function tirarAcentos($string)
    {
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $string);
    }
    ?>
    <div style="margin: 0 auto;align-items: center;display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;" class="row justify-content-center ">
        <div id="divImprimir" style="background-color: #fdfbe3;" class="boxed-md boxed-padded">
            <table class="printer-ticket">
                <thead>
                    <tr>
                        <th class="title" colspan="3">
                            <h4><b>CUPOM NÃO FISCAL</b></h4>
                            <b><?= strtoupper($data['config']->config_nome) ?></b><br>
                            <small>
                                <?= strtoupper($data['config']->config_endereco) ?><br>
                                <?= $data['config']->config_fone1 ?><br>
                            </small>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="3" style="font-size: 12px;">
                            <b>DATA PEDIDO</b> <?= date('d/m/Y H:i', strtotime($data['pedido']->pedido_data)) ?><br>
                            <b>PEDIDO #</b><?= $data['pedido']->pedido_id ?> |
                            <b>Nº ENTREGA #</b><?= str_pad($data['pedido']->pedido_numero_entrega, 2, 0, STR_PAD_LEFT) ?>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="3" style="font-size: 12px;">
                            <b>DADOS DO CLIENTE</b><br>
                            <b>NOME:</b> <?= strtoupper(ucfirst($data['pedido']->cliente_nome)) ?><br>
                            <b>TELEFONE:</b> <?= $data['pedido']->cliente_fone2 ?><br>
                            <?php if (isset($data['endereco'])) : ?>
                                <?php $end = $data['endereco']; ?>
                                <b>END. ENTREGA:</b> <?= (strtoupper($end->endereco_endereco)) ?>,<?= $end->endereco_numero ?>,
                                <?php if ($end->endereco_complemento != "") : ?>
                                    <?= (strtoupper($end->endereco_complemento)) ?> -
                                <?php endif; ?>
                                <?= (strtoupper($end->endereco_bairro)) ?> -
                                <?= (strtoupper($end->endereco_cidade)) ?>,
                                <?= (strtoupper($end->endereco_nome)) ?>
                                <?php if ($end->endereco_referencia != "") : ?>
                                    <br>
                                    <b>PONTO DE REF.:</b> <?= (strtoupper($end->endereco_referencia)) ?>
                                <?php endif; ?>
                            <?php else : ?>
                                RETIRAR NO LOCAL
                            <?php endif; ?>
                        </th>
                    </tr>
                    <tr>
                        <th class="ttu" colspan="3">
                            <b>ITENS DO PEDIDO</b>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalSemTaxa = '';
                    $subtotal = 0;
                    foreach ($data['lista'] as $key => $cart) {
                        $subtotal += $cart->lista_opcao_preco * $cart->lista_qtde;
                    ?>
                        <tr>
                            <td style="width: 20px; font-size: 12px;"><?= $cart->lista_qtde ?><small>x</small></td>
                            <td style="width: 500px; font-size: 12px;">
                                <?= $cart->categoria_nome ?>
                                <?php if (strrpos($cart->lista_item_desc, '1/2') === false) {
                                    echo ' - ' . strtoupper($cart->lista_opcao_nome);
                                }

                                if (strip_tags(($cart->lista_item_desc)) != '') : ?>
                                    (<?= strip_tags(mb_strtolower(($cart->lista_item_desc))) ?>)
                                    <?php endif; ?>
                            </td>
                            <td style="width: 100px; font-size: 12px;">
                                <?php 
                                // Calcula o valor base do item subtraindo os adicionais
                                $valor_adicionais = 0;
                                if($cart->lista_item_extra_vals){
                                    $adicionais_val_array = explode(',', $cart->lista_item_extra_vals);
                                    foreach($adicionais_val_array as $val) {
                                        $valor_adicionais += floatval($val);
                                    }
                                }
                                $valor_base_item = ($cart->lista_opcao_preco - $valor_adicionais) * $cart->lista_qtde;
                                ?>
                                R$<?= Currency::moeda($valor_base_item) ?>
                            </td>
                        </tr>
                        <?php
                        $totalSemTaxa += $cart->lista_opcao_preco * $cart->lista_qtde;
                    }
                    //SE HOUVER PROMOÇÃO GRANHA
                    if (isset($data['lista_premio'])) {
                        foreach ($data['lista_premio'] as $key => $cartPremio) { ?>
                            <tr>
                                <td style="width: 20px; font-size: 12px;"><?= $cartPremio->promocao_qtd ?><small>x</small></td>
                                <td style="width: 500px; font-size: 12px;">
                                    <?= (strtoupper($cartPremio->promocao_produto)) ?>
                                </td>
                                <td style="width: 100px; font-size: 12px;">- GRATIS</td>
                            </tr>
                        <?php
                        }
                    }
                    if ($data['pedido']->pedido_obs != "") : ?>
                        <tr>
                            <td style="border-top: 1px dashed #900; font-size: 12px; font-weight: bold; padding: 10px;" colspan="3">OBS: <?= $data['pedido']->pedido_obs ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="sup ttu p--0">
                        <td colspan="3">
                            <b>TOTAIS</b>
                        </td>
                    </tr>
                    <tr class="ttu">
                        <td colspan="2">SUB-TOTAL</td>
                        <td align="right">R$<?= Currency::moeda($subtotal) ?></td>
                    </tr>
                    <?php
                    $dadosCupom = (new cupomModel)->get_desconto_cupom($data['pedido']->pedido_id);

                    if (!empty($dadosCupom)) {                      
                    ?>
                        <tr class="ttu">
                            <td colspan="2">DESCONTO</td>
                            <?php if($dadosCupom->cupom_tipo == '1'){ ?>
                                <td align="right">R$<?= Currency::moeda($dadosCupom->cupom_valor) ?></td>
                            <?php }else{ ?>
                                <td align="right"><?= $dadosCupom->cupom_percent ?>%</td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                    <tr class="ttu">
                        <td colspan="2">TAXA DE ENTREGA</td>
                        <td align="right">R$<?= Currency::moeda($data['pedido']->pedido_entrega) ?></td>
                    </tr>
                    <?php                 
                        if ($data['pedido']->pedido_taxa_cartao != '' && $data['pedido']->pedido_taxa_cartao != '0.00' && $data['pedido']->pedido_taxa_cartao > 0) {
                    ?>
                            <tr class="ttu">
                                <td colspan="2">TAXA CARTAO</td>
                                <td align="right">R$ <?=number_format($data['pedido']->pedido_taxa_cartao,2,',','.')?></td>
                            </tr>
                        <?php } ?>
                    <tr class="ttu">
                        <td colspan="2"><b>TOTAL A PAGAR</b></td>
                        <td align="right"><b>R$<?= Currency::moeda($data['pedido']->pedido_total); ?></b></td>
                    </tr>
                    <?php if($data['pedido']->pedido_troco != '' && $data['pedido']->pedido_troco != '0.00' && $data['pedido']->pedido_troco > 0){?>
                    <tr class="ttu">
                        <td colspan="2"><b>TROCO</b></td>
                        <td align="right"><b>R$<?= Currency::moeda($data['pedido']->pedido_troco); ?></b></td>
                    </tr>
                    <?php } ?>
                    <tr class="sup ttu p--0">
                        <td colspan="3">
                            <b>PAGAMENTO</b>
                        </td>
                    </tr>
                    <tr class="ttu">
                        <td colspan="3"><?= ($data['pedido']->pedido_obs_pagto) ?></td>
                    </tr>
                    <tr class="sup ttu p--0">
                        <td colspan="3" style="text-align: center;">***OBRIGADO E BOM APETITE***</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <script>
        
        
        setTimeout(function() {
            window.print();
            window.close();
        }, 300);
    </script>
</body>

</html>