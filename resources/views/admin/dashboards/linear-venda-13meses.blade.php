<?php

$faturamento_treze_meses = '';

$total_meses = count($data['linear_venda_treze_meses']);
for ($i = $total_meses - 1; $i >= 0; $i--) {

    $faturamento_treze_meses .= '{"date": "' . $data['linear_venda_treze_meses'][$i]->mes . '", "value": ' . $data['linear_venda_treze_meses'][$i]->faturamento . ', "value2": ' . $data['linear_venda_treze_meses'][$i]->faturamento_acumulado . '}';

    // Adicionar vírgula se não for o último elemento
    if ($i > 0) {
        $faturamento_treze_meses .= ',';
    }
}

// Calcula a média do faturamento para os treze meses
$media_faturamento = 0;
if ($total_meses > 0) {
    $faturamento_sum = array_column($data['linear_venda_treze_meses'], 'faturamento');
    $media_faturamento = array_sum($faturamento_sum) / $total_meses;
}

if (isset($_POST['data_inicio'])) {

    $mes_selecionado = explode('/', $_POST['data_inicio']);

    switch($mes_selecionado[1]){
        case "01": $mes = "Janeiro"; break;
        case "02": $mes = "Fevereiro"; break;
        case "03": $mes = "Março"; break;
        case "04": $mes = "Abril"; break;
        case "05": $mes = "Maio"; break;
        case "06": $mes = "Junho"; break;
        case "07": $mes = "Julho"; break;
        case "08": $mes = "Agosto"; break;
        case "09": $mes = "Setembro"; break;
        case "10": $mes = "Outubro"; break;
        case "11": $mes = "Novembro"; break;
        case "12": $mes = "Dezembro"; break;
    }
}?>
<div class="row-fluid" style="margin-top: 0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="fa fa-signal"></i></span>
                <h5 style="color: #fff;">
                    <span data-toggle="tooltip" title="Valor do faturamento acumulado, relativo at&eacute; a data presente, durante 13 meses.">Histórico de Vendas / Mês</span>
                    <?php if (isset($_POST['data_inicio'])) {
                        echo " - Referente ao mês de " . $mes . ' de '. $mes_selecionado[2];
                    } ?>
                </h5>
            </div>
            <div class="widget-content">
                <div class="row-fluid">
                    <div class="span12">
                        <div id="vendas13meses" style="width: auto; height: 400px;">
                            <div id="loading"><span><i class="fa fa-spinner fa-spin"></i> Carregando Gráfico...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var chart = AmCharts.makeChart("vendas13meses", {
            "type": "serial",
            "hideCredits": true,
            "zoomOutText": "Mostrar todo",
            "theme": "light",
            "marginRight": 80,
            "startDuration": 0.2,
            "autoMarginOffset": 20,
            "dataDateFormat": "YYYY-MM-DD HH:NN",
            "dataProvider": [<?= $faturamento_treze_meses ?>],
            "valueAxes": [{
                "axisAlpha": 0,
                "guides": [{
                    "dashLength": 6,
                    "inside": true,
                    "label": "M <?= number_format($media_faturamento, 2, ",", ".") ?>",
                    "color": "#FF8C00",
                    "lineAlpha": 1,
                    "value": <?= $media_faturamento ?>
                }],
                "unit": "R$",
                "unitPosition": "left",
                "position": "left",
                "tickLength": 0
            }],
            "numberFormatter": {
                "precision": 2,
                "decimalSeparator": ",",
                "thousandsSeparator": "."
            },
            "graphs": [{
                    "id": "g1",
                    "bullet": "round",
                    "bulletBorderAlpha": 1,
                    "balloonText": "[[category]]<br><b><span style='font-size:14px;'>value:[[value]]</span></b>",
                    "bulletColor": "#FFFFFF",
                    "bulletSize": 5,
                    "hideBulletsCount": 50,
                    "lineThickness": 2,
                    "title": "Vendas",
                    "lineColor": "#00CC00",
                    "valueField": "value",
                    "useLineColorForBulletBorder": true,
                    "labelText": "R$[[value]]"
                },
                {
                    "id": "g2",
                    "bullet": "round",
                    "bulletBorderAlpha": 1,
                    "bulletColor": "#6ab4d2",
                    "bulletSize": 5,
                    "hideBulletsCount": 50,
                    "lineThickness": 2,
                    "title": "Vendas Acumulado",
                    "lineColor": "#fcb088",
                    "useLineColorForBulletBorder": true,
                    "valueField": "value2",
                    "labelText": "R$[[value]]"
                }
            ],
            "chartCursor": {
                "fullWidth": true,
                "valueLineEabled": true,
                "valueLineBalloonEnabled": true,
                "valueLineAlpha": 0.5,
                "cursorAlpha": 0
            },
            "categoryField": "date",
            "categoryAxis": {
                "parseDates": false,
                "axisAlpha": 0,
                "gridAlpha": 0.1,
                "minorGridAlpha": 0.1,
                "minorGridEnabled": true
            },
            "legend": {
                "useGraphSettings": true,
                "align": "center"
            },
            "export": {
                "enabled": true,
                "fileName": "Histórico vendas 13 Meses",
                "path": "js/amcharts/plugins/export/",
                "libs": { "path": "js/amcharts/plugins/export/libs/" }
            },
        });
    </script>