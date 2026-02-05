<?php

// echo '<pre>';
// print_r($data['config']->config_plano);
// echo '</pre>';

// echo '<pre>';
// print_r($data['plano']);
// echo '</pre>';

//$data['plano']->plano = 150;

if($data['plano']->plano <= $data['config']->config_plano){}else{

switch ($data['plano']->plano) {
    case 50:
        $planoIdeal = $data['plano']->plano;
        $totalPedidos = '100';
        break;   
    case 100:
        $planoIdeal = $data['plano']->plano;
        $totalPedidos = '200';
        break;  
    case 150:
        $planoIdeal = $data['plano']->plano;
        $totalPedidos = 'ilimitados';
        break;  
}

?> 
<script type="text/javascript">
    x0p({
        title: 'Plano atingido!',
        text: "Você atingiu a cota do plano contratado 😔 \n O plano ideal para você no momento é o plano <?=$planoIdeal?>.",
        animationType: 'slideUp',
        icon: 'custom',
        iconURL: '<?php echo $baseUri; ?>/midias/img/alerta-plano.png',
        buttons: [{
                type: 'error',
                key: 49,
                text: 'Sair do sistema'
            },
            {
                type: 'info',
                key: 50,
                text: '<i class="fa fa-whatsapp" aria-hidden="true"></i> Saiba mais'
            }
        ]
    }).then(function(data) {
        if (data.button == 'error') {
            $.ajax({
                url: '<?php echo $baseUri; ?>/login/logout',
                success: function(data) {
                    location.reload();
                }
            });

        } else if (data.button == 'info') {
            $.ajax({
                url: '<?php echo $baseUri; ?>/login/logout',
                success: function(data) {
                    location.reload();
                }
            });
            window.open('https://api.whatsapp.com/send?phone=5585991415641&text=gostaria de informações sobre o plano <?=$planoIdeal?>', '_blank');
        }
    });
</script>
<?php } ?>