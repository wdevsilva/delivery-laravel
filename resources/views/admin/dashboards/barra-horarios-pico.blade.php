<?php
$horarios_pico_data = '';
if (isset($data['horarios_pico']) && !empty($data['horarios_pico'])) {
    $total = count($data['horarios_pico']);
    for ($i = 0; $i < $total; $i++) {
        $hora = str_pad($data['horarios_pico'][$i]->hora, 2, '0', STR_PAD_LEFT) . ':00';
        $horarios_pico_data .= '{"hora": "' . $hora . '", "pedidos": ' . $data['horarios_pico'][$i]->total_pedidos . ', "faturamento": ' . $data['horarios_pico'][$i]->faturamento . '}';
        if ($i < $total - 1) {
            $horarios_pico_data .= ',';
        }
    }
}
?>
<div class="row-fluid" style="margin-top: 20px">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="fa fa-clock-o"></i></span>
                <h5 style="color: #fff;">Horários de Pico - Volume de Pedidos</h5>
            </div>
            <div class="widget-content">
                <div class="row-fluid">
                    <div class="span12">
                        <div id="horariosPico" style="width: auto; height: 400px;">
                            <div id="loading"><span><i class="fa fa-spinner fa-spin"></i> Carregando Gráfico...</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var chart = AmCharts.makeChart("horariosPico", {
            "type": "serial",
            "theme": "light",
            "hideCredits": true,
            "startDuration": 0.2,
            "dataProvider": [<?= $horarios_pico_data ?>],
            "valueAxes": [{
                "position": "left",
                "title": "Quantidade de Pedidos"
            }],
            "graphs": [{
                "balloonText": "[[category]]: [[value]] pedidos<br>Faturamento: R$ [[faturamento]]",
                "fillAlphas": 0.8,
                "lineAlpha": 0.2,
                "type": "column",
                "valueField": "pedidos",
                "fillColors": "#67b7dc",
                "labelText": "[[value]]",
                "precision": 0
            }],
            "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": false
            },
            "categoryField": "hora",
            "categoryAxis": {
                "gridPosition": "start",
                "labelRotation": 45
            },
            "export": {
                "enabled": true,
                "fileName": "Horários de Pico",
                "path": "js/amcharts/plugins/export/",
                "libs": { "path": "js/amcharts/plugins/export/libs/" }
            }
        });
    </script>
</div>
