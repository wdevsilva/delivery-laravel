<?php

$ticket_medio = '';
$nMeses = 0;

$total_meses = count($data['linear_ticket_medio']);
for ($i = $total_meses - 1; $i >= 0; $i--) {

    $ticket_medio .= '{
        "date": "' . $data['linear_ticket_medio'][$i]->mes . '",
        "value": ' . $data['linear_ticket_medio'][$i]->ticket_medio . '
    }';

    // Adicionar vírgula se não for o último elemento
    if ($i > 0) {
        $ticket_medio .= ',';
    }

    // Contar apenas os meses com ticket médio diferente de zero
    if ($data['linear_ticket_medio'][$i]->ticket_medio <> 0) {
        $nMeses += 1;
    }
}

// Calcula a média do ticket médio para os meses trabalhados
$media_linha = 0;
if ($nMeses > 0) {
    $ticket_medio_sum = array_column(array_slice($data['linear_ticket_medio'], 0, $nMeses), 'ticket_medio');
    $media_linha = array_sum($ticket_medio_sum) / $nMeses;
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
}
?>
<div class="row-fluid" style="margin-top: 0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="fa fa-signal"></i></span>
                <h5 style="color: #fff;">
                    <span data-toggle="tooltip" title="Valor médio que cada cliente compra, relativo at&eacute; a data presente, durante 13 meses.">Ticket Médio</span>
                    <?php if (isset($_POST['data_inicio'])) {
                        echo " - Referente ao mês de " . $mes . ' de '. $mes_selecionado[2];
                    } ?>
                </h5>
            </div>
            <div class="widget-content">
                <div class="row-fluid">
                    <div class="span12">
                        <div id="ticket" style="width: 100%; height: 400px;">
                            <div id="loading"><span><i class="fa fa-spinner fa-spin"></i> Carregando Gráfico...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var chart = AmCharts.makeChart("ticket", {
            "type": "serial",
            "hideCredits": true,
            "zoomOutText": "Mostrar todo",
            "theme": "light",
            "marginRight": 80,
            "startDuration": 0.5,
            "autoMarginOffset": 20,
            "dataDateFormat": "YYYY-MM-DD HH:NN",
            "dataProvider": [<?= $ticket_medio ?>],
            "valueAxes": [{
                "axisAlpha": 0,
                "guides": [{
                    "dashLength": 6,
                    "inside": true,
                    "label": "M <?=number_format($media_linha,2,",",".")?>",
                    "color": "#FF8C00",
                    "lineAlpha": 1,
                    "value": <?=$media_linha?>
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
                "dashLength": 3,
                "colorField": "color",
                "valueField": "value",
                "lineColor": "#00CC00",
                "labelText": "R$[[value]]"
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
                "fileName": "Ticket Médio",
                "path": "js/amcharts/plugins/export/",
                "libs": { "path": "js/amcharts/plugins/export/libs/" }
            },
        });
    </script>