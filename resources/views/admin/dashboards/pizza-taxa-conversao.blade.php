<?php
$clientes_novos = 0;
$clientes_recorrentes = 0;
$taxa_retencao = 0;

if (isset($data['taxa_conversao']) && !is_null($data['taxa_conversao'])) {
    $clientes_novos = $data['taxa_conversao']->clientes_novos ?? 0;
    $clientes_recorrentes = $data['taxa_conversao']->clientes_recorrentes ?? 0;
    $total_clientes = $data['taxa_conversao']->total_clientes ?? 0;
    
    if ($total_clientes > 0) {
        $taxa_retencao = ($clientes_recorrentes / $total_clientes) * 100;
    }
}
?>
<div class="row-fluid" style="margin-top: 20px">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="fa fa-users"></i></span>
                <h5 style="color: #fff;">Taxa de Retenção de Clientes</h5>
            </div>
            <div class="widget-content">
                <div class="row-fluid">
                    <div class="span6">
                        <!-- 3 métricas em linha horizontal -->
                        <div style="display: flex; justify-content: space-between; align-items: stretch;">
                            <div style="flex: 1; text-align: center; padding: 15px;">
                                <h2 style="color: #67b7dc; margin: 0;"><?= $clientes_novos ?></h2>
                                <p style="font-size: 13px; color: #666; margin-top: 5px;">Clientes Novos</p>
                                <i class="fa fa-user-plus" style="font-size: 32px; color: #67b7dc; margin-top: 5px;"></i>
                            </div>
                            <div style="flex: 1; text-align: center; padding: 15px; border-left: 1px solid #e5e5e5; border-right: 1px solid #e5e5e5;">
                                <h2 style="color: #00CC00; margin: 0;"><?= $clientes_recorrentes ?></h2>
                                <p style="font-size: 13px; color: #666; margin-top: 5px;">Clientes Recorrentes</p>
                                <i class="fa fa-refresh" style="font-size: 32px; color: #00CC00; margin-top: 5px;"></i>
                            </div>
                            <div style="flex: 1; text-align: center; padding: 15px;">
                                <h2 style="color: #FF8C00; margin: 0;"><?= number_format($taxa_retencao, 1) ?>%</h2>
                                <p style="font-size: 13px; color: #666; margin-top: 5px;">Taxa de Retenção</p>
                                <i class="fa fa-line-chart" style="font-size: 32px; color: #FF8C00; margin-top: 5px;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div id="taxaConversao" style="width: auto; height: 200px;">
                            <div id="loading"><span><i class="fa fa-spinner fa-spin"></i> Carregando Gráfico...</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var chart = AmCharts.makeChart("taxaConversao", {
            "type": "pie",
            "theme": "light",
            "hideCredits": true,
            "dataProvider": [
                {"tipo": "Clientes Novos", "valor": <?= $clientes_novos ?>},
                {"tipo": "Clientes Recorrentes", "valor": <?= $clientes_recorrentes ?>}
            ],
            "valueField": "valor",
            "titleField": "tipo",
            "labelText": "[[title]]: [[percents]]%",
            "balloonText": "[[title]]: [[value]] clientes ([[percents]]%)",
            "innerRadius": "40%",
            "colors": ["#67b7dc", "#00CC00"],
            "legend": {
                "align": "center",
                "markerType": "circle"
            },
            "export": {
                "enabled": true,
                "fileName": "Taxa de Retenção",
                "path": "js/amcharts/plugins/export/",
                "libs": { "path": "js/amcharts/plugins/export/libs/" }
            }
        });
    </script>
</div>
