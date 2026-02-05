<?php extract($data); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Cozinha - Pedido #<?= $pedido->pedido_mesa_id ?></title>
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

    .kitchen-header {
        background: #ff6b6b;
        color: white;
        padding: 10px;
        text-align: center;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .order-priority {
        background: #fdcb6e;
        color: #2d3436;
        padding: 5px;
        text-align: center;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .item-urgente {
        background: #ff7675;
        color: white;
        padding: 2px 5px;
        border-radius: 3px;
        font-weight: bold;
    }

    .obs-cozinha {
        background: #74b9ff;
        color: white;
        padding: 8px;
        margin: 5px 0;
        border-radius: 5px;
    }
</style>

<body class="animated">
    <div style="margin: 0 auto;align-items: center;display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;" class="row justify-content-center ">
        <div id="divImprimir" style="background-color: #fdfbe3;" class="boxed-md boxed-padded">
            
            <!-- Header da Cozinha -->
            <div class="kitchen-header">
                🍽️ TICKET COZINHA 🍽️<br>
                <?= strtoupper($config->config_nome) ?>
            </div>

            <table class="printer-ticket">
                <thead>
                    <tr>
                        <th class="title" colspan="3">
                            <h3><b>MESA <?= $pedido->mesa_numero ?? 'N/A' ?></b></h3>
                            <small>
                                <b>GARÇOM:</b> <?= strtoupper($pedido->garcon_nome ?? 'N/A') ?><br>
                                <b>CLIENTE:</b> <?= strtoupper($pedido->cliente_nome ?? 'N/A') ?><br>
                            </small>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="3" style="font-size: 12px;">
                            <b>PEDIDO #<?= $pedido->pedido_mesa_id ?></b><br>
                            <b>DATA:</b> <?= date('d/m/Y H:i', strtotime($pedido->pedido_data)) ?>
                        </th>
                    </tr>
                    
                    <!-- Prioridade baseada no tempo -->
                    <?php
                    $agora = new DateTime();
                    $pedido_time = new DateTime($pedido->pedido_data);
                    $diff = $agora->diff($pedido_time);
                    $minutos_passados = ($diff->h * 60) + $diff->i;
                    ?>
                    <?php if ($minutos_passados > 30): ?>
                        <tr>
                            <td colspan="3" class="order-priority">
                                ⚠️ PEDIDO URGENTE - <?= $minutos_passados ?> MIN ⚠️
                            </td>
                        </tr>
                    <?php elseif ($minutos_passados > 15): ?>
                        <tr>
                            <td colspan="3" style="background: #fdcb6e; padding: 5px; text-align: center;">
                                🕐 ATENÇÃO - <?= $minutos_passados ?> MIN
                            </td>
                        </tr>
                    <?php endif; ?>
                    
                    <tr>
                        <th class="ttu" colspan="3">
                            <b>🍳 ITENS PARA PREPARAR 🍳</b>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($lista && count($lista) > 0): ?>
                        <?php foreach ($lista as $item): ?>
                            <tr>
                                <td style="width: 20px; font-size: 14px; font-weight: bold;">
                                    <?= $item->lista_qtde ?><small>x</small>
                                </td>
                                <td style="width: 500px; font-size: 14px; font-weight: bold;">
                                    <?php
                                    $nome_item = $item->lista_item_nome;
                                    $obs_item = $item->lista_item_obs ?? '';
                                    ?>
                                    
                                    <?= strtoupper($nome_item) ?>
                                    
                                    <?php if (!empty(trim($obs_item))): ?>
                                        <br>
                                        <div class="obs-cozinha">
                                            <strong>📝 OBS:</strong> <?= strtoupper(strip_tags($obs_item)) ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (isset($item->categoria_nome)): ?>
                                        <br><small style="background: #ddd; padding: 2px 4px; border-radius: 3px;">
                                            <?= strtoupper($item->categoria_nome) ?>
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td style="width: 100px; font-size: 12px; text-align: center;">
                                    <?php if ($minutos_passados > 30): ?>
                                        <span class="item-urgente">URGENTE</span>
                                    <?php else: ?>
                                        <span style="background: #00b894; color: white; padding: 2px 4px; border-radius: 3px;">OK</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 20px;">
                                <strong>⚠️ NENHUM ITEM PARA COZINHA ⚠️</strong>
                            </td>
                        </tr>
                    <?php endif; ?>
                    
                    <!-- Observações do pedido -->
                    <?php if (isset($pedido->pedido_obs) && !empty(trim($pedido->pedido_obs))): ?>
                        <tr>
                            <td style="border-top: 2px solid #ff6b6b; font-size: 12px; font-weight: bold; padding: 15px; background: #fff3cd;" colspan="3">
                                <strong>📋 OBSERVAÇÕES GERAIS:</strong><br>
                                <?= strtoupper(nl2br(strip_tags($pedido->pedido_obs))) ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: center; padding: 10px; font-size: 10px;">
                            Impresso em: <?= date('d/m/Y H:i:s') ?><br>
                            Sistema de Cozinha - <?= $config->config_nome ?>
                        </td>
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