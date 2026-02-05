<?php

$resultFaturamento = "";
$alpha = "";

$total_anos = count($data['barra_faturamento_anual']);
for ($i = 0; $i < $total_anos; $i++) {

    if ($data['barra_faturamento_anual'][$i]->ano == date("Y")) {
        $alpha = '"0.2",';
    } else {
        $alpha = '"",';
    }

    $resultFaturamento .= '{"year":"' . $data['barra_faturamento_anual'][$i]->ano . '","total": ' . $data['barra_faturamento_anual'][$i]->faturamento . ',"avista": ' . $data['barra_faturamento_anual'][$i]->avista . ',"pix": ' . $data['barra_faturamento_anual'][$i]->pix . ',"credito": ' . $data['barra_faturamento_anual'][$i]->credito . ',"debito": ' . $data['barra_faturamento_anual'][$i]->debito . ',"dashLengthLine": 5, "alpha": ' . $alpha . '}';

    // Adicionar vírgula se não for o último elemento
    if ($i < $total_anos - 1) {
        $resultFaturamento .= ',';
    }
} ?>
<div class="span6">
    <div class="widget-box">
        <div class="widget-title"><span class="icon"><i class="fa fa-signal"></i></span>
            <h5 style="color: #fff;">
                <span>Faturamento Anual</span>
            </h5>
        </div>
        <div class="widget-content">
            <div class="row-fluid">
                <div class="span12">
                    <div id="faturamentoAnual" style="width: auto; height: 420px;">
                        <div id="loading"><span><i class="fa fa-spinner fa-spin"></i> Carregando Gráfico...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var chart = AmCharts.makeChart("faturamentoAnual", {
        "type": "serial",
        "addClassNames": true,
        "theme": "light",
        "autoMargins": false,
        "marginLeft": 30,
        "marginRight": 8,
        "marginTop": 10,
        "marginBottom": 26,
        "hideCredits": true,
        "balloon": {
            "adjustBorderColor": false,
            "horizontalPadding": 10,
            "verticalPadding": 8,
            "color": "#ffffff"
        },
        "dataProvider": [<?= $resultFaturamento ?>],
        "valueAxes": [{
            "unit": "R$",
            "unitPosition": "left",
            "axisAlpha": 0,
            "tickLength": 0,
            "position": "left"
        }],
        "numberFormatter": {
            "precision": 2,
            "decimalSeparator": ",",
            "thousandsSeparator": "."
        },
        "startDuration": 1,
        "graphs": [{
                "alphaField": "alpha",
                "balloonText": "<span style='font-size:12px;'>[[title]] em [[category]]:<br>R$<span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                "fillAlphas": 1,
                "title": "Total",
                "type": "column",
                "valueField": "total",
                "labelText": "R$[[value]]",
                "dashLengthField": "dashLengthColumn"
            }, {
                "id": "graph2",
                "balloonText": "<span style='font-size:12px;'>[[title]] em [[category]]:<br>R$<span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                "bullet": "round",
                "lineThickness": 3,
                "bulletSize": 7,
                "bulletBorderAlpha": 1,
                "bulletColor": "#FFFFFF",
                "useLineColorForBulletBorder": true,
                "bulletBorderThickness": 3,
                "fillAlphas": 0,
                "lineAlpha": 1,
                "title": "À Vista",
                "valueField": "avista",
                "dashLengthField": "dashLengthLine"
            }, {
                "id": "graph3",
                "balloonText": "<span style='font-size:12px;'>[[title]] em [[category]]:<br>R$<span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                "bullet": "round",
                "lineThickness": 3,
                "bulletSize": 7,
                "bulletBorderAlpha": 1,
                "bulletColor": "#FFFFFF",
                "useLineColorForBulletBorder": true,
                "bulletBorderThickness": 3,
                "fillAlphas": 0,
                "lineAlpha": 1,
                "title": "Pix",
                "valueField": "pix"
            }, {
                "id": "graph4",
                "balloonText": "<span style='font-size:12px;'>[[title]] em [[category]]:<br>R$<span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                "bullet": "round",
                "lineThickness": 3,
                "bulletSize": 7,
                "bulletBorderAlpha": 1,
                "bulletColor": "#FFFFFF",
                "useLineColorForBulletBorder": true,
                "bulletBorderThickness": 3,
                "fillAlphas": 0,
                "lineAlpha": 1,
                "title": "Cartão Crédito",
                "valueField": "credito"
            },
            {
                "id": "graph5",
                "balloonText": "<span style='font-size:12px;'>[[title]] em [[category]]:<br>R$<span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                "bullet": "round",
                "lineThickness": 3,
                "bulletSize": 7,
                "bulletBorderAlpha": 1,
                "bulletColor": "#FFFFFF",
                "useLineColorForBulletBorder": true,
                "bulletBorderThickness": 3,
                "fillAlphas": 0,
                "lineAlpha": 1,
                "title": "Cartão Débito",
                "valueField": "debito"
            }
        ],
        "legend": {
            "position": "right",
            "maxColumns": 1,
            "top": 1,
            "align": "center"
        },
        "categoryField": "year",
        "categoryAxis": {
            "gridPosition": "start",
            "axisAlpha": 0,
            "tickLength": 0
        },
        "marginLeft": 60,
        "export": {
            "enabled": true,
            "fileName": "Faturamento Anual",
            "path": "js/amcharts/plugins/export/",
            "libs": { "path": "js/amcharts/plugins/export/libs/" }
        }
    });
</script>