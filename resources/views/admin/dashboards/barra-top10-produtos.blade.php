<?php

$top_produtos = '';

$total_produtos = count($data['barra_top_dez_produtos']);
for ($i = 0; $i < $total_produtos; $i++) {

    $descricao = $data['barra_top_dez_produtos'][$i]->categoria_nome . ' ' . $data['barra_top_dez_produtos'][$i]->item_nome;
    $top_produtos .= '{"year": "' . $descricao . '","color": "#85c5e3","income": ' . $data['barra_top_dez_produtos'][$i]->total . '}';

    // Adicionar vírgula se não for o último elemento
    if ($i < $total_produtos - 1) {
        $top_produtos .= ',';
    }
}
?>

<div class="span6">
    <div class="widget-box">
        <div class="widget-title">
            <span class="icon"><i class="fa fa-signal"></i></span>
            <h5 style="color: #fff;">
                <span data-toggle="tooltip" title="Produtos mais vendidos referente a data presente.">Top 10 Produtos</span>
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
                    <div id="top10Produtos" style="width: auto; height: 400px;">
                        <div id="loading"><span><i class="fa fa-spinner fa-spin"></i> Carregando Gráfico...</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- produtos destaques-->
<script type="text/javascript">
    var chart = AmCharts.makeChart("top10Produtos", {
        "theme": "light",
        "type": "serial",
        "hideCredits": true,
        "startDuration": 0.5,
        "dataProvider": [<?= $top_produtos ?>],
        "valueAxes": [{
            //"title": "Income in millions, USD"
        }],
        "graphs": [{
            "balloonText": "<b>[[title]]</b><br><span style='font-size:14px'>[[category]]: <b>[[value]]</b></span>",
            "fillAlphas": 1,
            "lineAlpha": 0.2,
            "title": "Produto",
            "labelText": "[[value]]",
            "type": "column",
            "colorField": "color",
            "color": "#900",
            "valueField": "income"
        }],
        "numberFormatter": {
            "precision": 0,
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
            "fileName": "top 10 produtos",
            "path": "js/amcharts/plugins/export/",
            "libs": { "path": "js/amcharts/plugins/export/libs/" }
        }
    });
</script>