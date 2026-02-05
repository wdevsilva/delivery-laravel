<?php error_reporting(0) ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<style>
    @page {
        size: 80mm auto;
        margin: 0;
    }
    
    @media print {
        body {
            margin: 0;
            padding: 0;
        }
        #divImprimir {
            page-break-after: always;
        }
        .printer-ticket tfoot tr:last-child td {
            padding-bottom: 3mm !important;
        }
    }
    
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

    /* Remove espaçamento extra após o rodapé */
    .printer-ticket tfoot tr:last-child td {
        padding-bottom: 0 !important;
        margin-bottom: 0 !important;
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
        margin: 2mm 2mm 0mm 2mm;
        padding-bottom: 0;
        font-family: monospace;
        font-size: 9pt;
        width: 80mm;
    }

    .boxed-md.boxed-padded {
        padding-bottom: 0px;
        padding-left: 20px;
        padding-right: 20px;
    }

    .boxed-md {
        border: 0px solid #ccc;
        margin-bottom: 0px;
        margin-top: 14px;
    }
</style>
<?php
function checkStatusPix($status)
{
    $status = strtolower($status);

    $mapTexts = [
        'peding'     => 'Pendente',
        'approved'    => 'Aprovado',
        'rejected'    => 'Rejeitado',
        'in_process'  => 'Processando',
        'cancelled'   => 'Cancelado',
        'expired'     => 'Expirado',
    ];

    return $mapTexts[$status] ?? 'Status Desconhecido';
}
?>

<body class="animated">
    <div style="margin: 0 auto;align-items: center;display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;" class="row justify-content-center ">
        <div id="divImprimir" style="background-color: #fdfbe3;" class="boxed-md boxed-padded">
            <table class="printer-ticket">
                <thead>
                    <tr>
                        <th class="title" colspan="3">
                            <h4><b>COMPROVANTE PAGAMENTO PIX</b></h4>
                            <b><?= strtoupper($data['config']->config_nome) ?></b><br>
                            <small>
                                <?= strtoupper($data['config']->config_endereco) ?><br>
                                <?= $data['config']->config_fone1 ?><br>
                            </small>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="3" style="font-size: 12px;">
                            <b>DATA</b> <?= date('d/m/Y H:i') ?><br>
                            <b>CLIENTE:</b> <?= strtoupper(ucfirst($data['pedido']->cliente_nome)) ?><br>
                            <b>TELEFONE:</b> <?= $data['pedido']->cliente_fone2 ?><br>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3" style="font-size: 12px;">
                            <b>PEDIDO:</b> #<?= $data['pixPagamento']->pedido_id ?><br>
                            <b>STATUS:</b> <?= strtoupper(checkStatusPix($data['pixPagamento']->status)) ?><br>
                            <b>CÓDIGO:</b> <?= $data['pixPagamento']->codigo ?><br>
                            <b>DATA GERAÇÃO:</b> <?= date('d/m/Y H:i', strtotime($data['pixPagamento']->criado_em)) ?><br>
                            <b>DATA PAGAMENTO:</b> <?= ($data['pixPagamento']->data_pagamento ? date('d/m/Y H:i', strtotime($data['pixPagamento']->data_pagamento)) : '---') ?><br>
                            <b>VALOR PAGO:</b> R$ <?= number_format($data['pedido']->pedido_total, 2, ',', '.') ?><br>
                        </td>
                    </tr>
                </tbody>

                <tfoot>
                    <tr class="sup ttu p--0">
                        <td colspan="3" style="text-align: center;">
                            *** PAGAMENTO <?= strtoupper(checkStatusPix($data['pixPagamento']->status)) ?> ***
                        </td>
                    </tr>
                    <tr class="sup ttu p--0">
                        <td colspan="3" style="text-align: center; padding-bottom: 0 !important; margin-bottom: 0 !important;">*** OBRIGADO PELA PREFERÊNCIA ***</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <script>
        // setTimeout(function() {
        //     window.print();
        //     window.close();
        // }, 300);
    </script>
</body>

</html>