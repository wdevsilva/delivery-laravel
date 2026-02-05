<?php

$top_clientes = '';

$total_clientes = count($data['barra_top_dez_clientes']);
for ($i = 0; $i < $total_clientes; $i++) {

    $descricao = $data['barra_top_dez_clientes'][$i]->cliente_nome . ' ' . $data['barra_top_dez_clientes'][$i]->endereco_bairro;
    $top_clientes .= '{"year": "' . $descricao . '","color": "#85c5e3","income": ' . $data['barra_top_dez_clientes'][$i]->total_pedidos . '}';

    // Adicionar vírgula se não for o último elemento
    if ($i < $total_clientes - 1) {
        $top_clientes .= ',';
    }
}
?>
<div class="row-fluid" style="margin-top: 0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="fa fa-signal"></i></span>
                <h5 style="color: #fff;">
                    <span data-toggle="tooltip" title="Melhores clientes com os valores comprados referente a data presente.">Top 10 Clientes</span>
                    <?php
                    if (isset($_POST['data_fim'])) {
                        echo " - Referente a: " . $_POST['data_inicio'] . " à " . $_POST['data_fim'];
                    } else {
                        echo " - Referente a: " . date('01/m/Y') . " à " . date('d/m/Y');
                    }
                    ?>
                </h5>
            </div>
            <div class="widget-content">
                <div class="row-fluid">
                    <div class="span12">
                        <div id="topcliente" style="width: auto; height: 500px;">
                            <div id="loading"><span><i class="fa fa-spinner fa-spin"></i> Carregando Gráfico...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var chart = AmCharts.makeChart("topcliente", {
            "theme": "light",
            "type": "serial",
            "startDuration": 1.5,
            "hideCredits": true,
            "dataProvider": [<?= $top_clientes ?>],
            "valueAxes": [{
                //"title": "Income in millions, USD"
            }],
            "graphs": [{
                "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>R$[[value]]</b></span>",
                "fillAlphas": 1,
                "lineAlpha": 0.2,
                "labelText": "R$[[value]]",
                "title": "Cliente",
                "type": "column",
                "colorField": "color",
                "valueField": "income"
            }],
            "numberFormatter": {
                "precision": 2,
                "decimalSeparator": ",",
                "thousandsSeparator": "."
            },
            "depth3D": 20,
            "angle": 30,
            "rotate": true,
            "categoryField": "year",
            "categoryAxis": {
                "gridPosition": "start",
                "fillAlpha": 0.05,
                "position": "left"
            },
            "export": {
                "enabled": true,
                "fileName": "top 10 clientes",
                "path": "js/amcharts/plugins/export/",
                "libs": { "path": "js/amcharts/plugins/export/libs/" }
            }
        });
    </script>