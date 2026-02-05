<?php
$formas_pagamento_data = '';
if (isset($data['formas_pagamento']) && !empty($data['formas_pagamento'])) {
    $total = count($data['formas_pagamento']);
    for ($i = 0; $i < $total; $i++) {
        $formas_pagamento_data .= '{"forma": "' . $data['formas_pagamento'][$i]->forma_pagamento . '", "total": ' . $data['formas_pagamento'][$i]->total_pedidos . ', "faturamento": ' . $data['formas_pagamento'][$i]->faturamento . '}';
        if ($i < $total - 1) {
            $formas_pagamento_data .= ',';
        }
    }
}
?>
<div class="row-fluid" style="margin-top: 20px">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon"><i class="fa fa-credit-card"></i></span>
                <h5 style="color: #fff;">Distribuição de Formas de Pagamento</h5>
            </div>
            <div class="widget-content">
                <div class="row-fluid">
                    <div class="span12">
                        <div id="formasPagamento" style="width: auto; height: 400px;">
                            <div id="loading"><span><i class="fa fa-spinner fa-spin"></i> Carregando Gráfico...</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var chart = AmCharts.makeChart("formasPagamento", {
            "type": "pie",
            "theme": "light",
            "hideCredits": true,
            "dataProvider": [<?= $formas_pagamento_data ?>],
            "valueField": "total",
            "titleField": "forma",
            "labelText": "[[title]]: [[percents]]%",
            "balloonText": "[[title]]: [[value]] pedidos<br>Faturamento: R$ [[faturamento]]",
            "precision": 0,
            "legend": {
                "align": "center",
                "markerType": "circle"
            },
            "export": {
                "enabled": true,
                "fileName": "Formas de Pagamento",
                "path": "js/amcharts/plugins/export/",
                "libs": { "path": "js/amcharts/plugins/export/libs/" }
            }
        });
    </script>
</div>
