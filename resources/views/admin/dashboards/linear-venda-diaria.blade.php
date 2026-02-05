<?php

$dias_faturamento = '';
$somatorio_venda = 0;

$dias_faturamentoQtd = '';
$somatorio_qtd = 0;

$total_dias = count($data['linear_faturamento_diario']);
for ($i = 0; $i < $total_dias; $i++) {

    $dias_faturamento .= '{"date":"' . $data['linear_faturamento_diario'][$i]->data_pedido . '","value": "' . $data['linear_faturamento_diario'][$i]->faturamento . '"}';
    $somatorio_venda += $data['linear_faturamento_diario'][$i]->faturamento;

    $dias_faturamentoQtd .= '{"date":"' . $data['linear_faturamento_diario'][$i]->data_pedido . '","value": ' . $data['linear_faturamento_diario'][$i]->qtd . '}';
    $somatorio_qtd += $data['linear_faturamento_diario'][$i]->qtd;

    // Adicionar vírgula se não for o último elemento
    if ($i < $total_dias - 1) {
        $dias_faturamento .= ',';
        $dias_faturamentoQtd .= ',';
    }
}

$somatorioTotal = 0;
$qtdTotalMes = 0;
$dia_atual = date("d");
$somatorioTotal = ($somatorio_venda / $dia_atual);
$mediaFormat = number_format($somatorioTotal, 2, '.', '.');
$mediatotal = substr($mediaFormat, 0, 5);

$qtdTotalMes += $somatorio_qtd;
$somatorioQtd = 0;
$somatorioQtd = round($somatorio_qtd / $dia_atual);

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
}
?>

<div class="row-fluid" style="margin-top: 0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="fa fa-signal"></i></span>
                <h5 style="color: #fff; margin-top: -5px;">
                    <span data-toggle="tooltip" title="Valor do faturamento por dia.">Histórico de Vendas Diária</span>                  
                    <label><input type="radio" value="1" name="qtd_venda" id="qtd_venda"> Valor</label>
                    <label><input type="radio" value="2" name="qtd_venda" id="qtd_venda"> Qtd</label>
                    <?php if (isset($_POST['data_inicio'])) {
                        echo " | Referente ao mês de " . $mes . ' de '. $mes_selecionado[2];
                    } ?>
                </h5>
            </div>
            <div class="widget-content">
                <div class="row-fluid">
                    <div class="span2">
                        <div id="linear_diario_faturamento" style="width: 100%; height: 400px;">
                            <div id="loading"><span><i class="fa fa-spinner fa-spin"></i> Carregando Gráfico...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        if (document.getElementById("qtd_venda").checked == false) {
            var chart = AmCharts.makeChart("linear_diario_faturamento", {
                "type": "serial",
                "hideCredits": true,
                "zoomOutText": "Mostrar todo",
                "theme": "light",
                "marginRight": 80,
                "startDuration": 0.5,
                "autoMarginOffset": 20,
                "dataDateFormat": "YYYY-MM-DD HH:NN",
                "dataProvider": [<?= $dias_faturamento ?>],
                "valueAxes": [{
                    "axisAlpha": 0,
                    "guides": [{
                        "dashLength": 6,
                        "inside": true,
                        "label": "M <?= $mediatotal ?>",
                        "color": "#FF8C00",
                        "lineAlpha": 1,
                        "value": <?= $mediatotal ?>
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
                    "balloonText": "[[category]]<br><b><span style='font-size:14px;'>value:[[value]]</span></b>",
                    "bullet": "round",
                    "lineAlpha": 0.8,
                    "dashLength": 3,
                    "colorField": "color",
                    "valueField": "value",
                    "lineColor": "#00CC00",
                    "labelText": "[[value]]"
                }],
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
                    "autoGridCount": true,
                    "axisAlpha": 0,
                    "gridAlpha": 0.1,
                    "gridCount": 50,
                    "minorGridAlpha": 0.1,
                    "minorGridEnabled": true
                },
                "export": {
                    "enabled": true,
                    "fileName": "Histórico vendas por dia Valor",
                    "path": "js/amcharts/plugins/export/",
                    "libs": { "path": "js/amcharts/plugins/export/libs/" }
                },
            });
        }

        $("input[type=radio][name=qtd_venda][value=1]").attr("checked", true);
        $("input[type=radio][name=qtd_venda]").change(function() {
            var val = $(this).val();

            if (val == "1") {
                var chart = AmCharts.makeChart("linear_diario_faturamento", {
                    "type": "serial",
                    "hideCredits": true,
                    "zoomOutText": "Mostrar todo",
                    "theme": "light",
                    "marginRight": 80,
                    "startDuration": 0.5,
                    "autoMarginOffset": 20,
                    "dataDateFormat": "YYYY-MM-DD HH:NN",
                    "dataProvider": [<?= $dias_faturamento ?>],
                    "valueAxes": [{
                        "axisAlpha": 0,
                        "guides": [{
                            "dashLength": 6,
                            "inside": true,
                            "label": "M <?= $mediatotal ?>",
                            "color": "#FF8C00",
                            "lineAlpha": 1,
                            "value": <?= $mediatotal ?>
                        }],
                        "unit": "R$",
                        "unitPosition": "left",
                        "position": "left",
                        "tickLength": 0
                    }],
                    "numberFormatter": {
                        "precision": 2,
                        "decimalSeparator": ",",
                        "thousandsSeparator": ""
                    },
                    "graphs": [{
                        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>value:[[value]]</span></b>",
                        "bullet": "round",
                        "dashLength": 3,
                        "colorField": "color",
                        "valueField": "value",
                        "lineColor": "#00CC00",
                        "labelText": "[[value]]"
                    }],
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
                    "export": {
                        "enabled": true,
                        "fileName": "Histórico vendas por dia Valor",
                        "path": "js/amcharts/plugins/export/",
                        "libs": { "path": "js/amcharts/plugins/export/libs/" }
                    },
                });
            } else if (val == "2") {
                var chart = AmCharts.makeChart("linear_diario_faturamento", {
                    "type": "serial",
                    "hideCredits": true,
                    "zoomOutText": "Mostrar todo",
                    "theme": "light",
                    "marginRight": 80,
                    "startDuration": 0.5,
                    "autoMarginOffset": 20,
                    "dataDateFormat": "YYYY-MM-DD HH:NN",
                    "dataProvider": [<?= $dias_faturamentoQtd ?>],
                    "valueAxes": [{
                        "axisAlpha": 0,
                        "guides": [{
                            "dashLength": 6,
                            "inside": true,
                            "label": "M <?= $somatorioQtd ?>",
                            "color": "#FF8C00",
                            "lineAlpha": 1,
                            "value": <?= $somatorioQtd ?>
                        }],
                        "position": "left",
                        "tickLength": 0
                    }],
                    "titles": [{
                        "text": "Qtd Vendas <?= $qtdTotalMes ?>",
                        "size": 15
                    }],
                    "graphs": [{
                        "balloonText": "[[category]]<br><b><span style='font-size:14px;'>value:[[value]]</span></b>",
                        "bullet": "round",
                        "dashLength": 3,
                        "colorField": "color",
                        "valueField": "value",
                        "lineColor": "#00CC00",
                        "labelText": "[[value]]"
                    }],
                    "chartCursor": {
                        "fullWidth": true,
                        "valueLineEabled": true,
                        "valueLineBalloonEnabled": true,
                        "valueLineAlpha": 0.5,
                        "cursorAlpha": 0,
                    },
                    "categoryField": "date",
                    "categoryAxis": {
                        "parseDates": false,
                        "axisAlpha": 0,
                        "gridAlpha": 0.1,
                        "minorGridAlpha": 0.1,
                        "minorGridEnabled": true
                    },
                    "export": {
                        "enabled": true,
                        "fileName": "Histórico vendas por dia Quantidade",
                        "path": "js/amcharts/plugins/export/",
                        "libs": { "path": "js/amcharts/plugins/export/libs/" }
                    },
                });
            }
        });
    </script>