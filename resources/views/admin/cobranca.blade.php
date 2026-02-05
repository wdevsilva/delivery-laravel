<script type="text/javascript">
$(document).ready(function () {
	
    function AbreCobranca(tipo) {
        //Tipo 1 = Aviso mas permite continuar usando o Sistema
        //Tipo 2 = Bloqueia o Sistema permitindo apenas entrar em contato pelo CHAT ou efetuar o Pagamento pelo Pagseguro

        if (tipo == 1) {
            //CABRANÇA DENTRO DO PERÍODO DE  3 DIAS DE CARÊNCIA
            var id = "#cobranca";//$(this).attr("href");
        } else if (tipo == 2) {
            //BLOQUEIO POR FALTA DE PAGAMENTO DA MENSALIDADE APÓS O VENCIMENTO
            x0p({
                title: 'Sistema Bloqueado',
                text: "Não identificamos o pagamento de sua mensalidade até o momento 😔",
                animationType: 'slideUp',
                icon: 'custom',
                iconURL: '<?php echo $baseUri; ?>/midias/img/block.png',
                buttons: [{
                        type: 'error',
                        key: 49,
                        text: 'Sair do sistema'
                    },
                    {
                        type: 'info',
                        key: 50,
                        text: '<img src="<?php echo $baseUri; ?>/midias/img/pix.png" width="20"> Realizar Pagamento'
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
                    location.reload();
                    window.open('<?php echo $baseUri; ?>/pagamento/mensalidade');
                }
            });
        } else if (tipo == 3) {
            //BLOQUEIO PERÍODO EXPERIMENTAL
            //BLOQUEIO POR FALTA DE PAGAMENTO DA MENSALIDADE APÓS O VENCIMENTO
            x0p({
                title: 'Fim da avaliação!',
                text: "Seu período de avaliação terminou! Espero que tenha gostado de toda experiência!",
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
                        // text: '<i class="fa fa-rocket" aria-hidden="true"></i> Escolher um Plano'
                        text: '<i class="fa fa-whatsapp" aria-hidden="true"></i> Mais informações'
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
                    // location.reload();
                    // window.open('echo $baseUri; /pagamento/plano', '_blank');

                    $.ajax({
                        url: '<?php echo $baseUri; ?>/login/logout',
                        success: function(data) {
                            location.reload();
                        }
                    });
                    window.open('https://api.whatsapp.com/send?phone=5585991966570&text=gostaria de contrator um plano no sysvon', '_blank');
                }
            });
        }
    };

    //Abro o Aviso de Pagamento caso vencido e Bloqueio o Sistema se vencido
    <?php

    $dataAtual = date("Y-m-d");

    $data1 = new DateTime($dataAtual);
    $data2 = new DateTime($data['config']->data_final_experimental);
    $intervalo = $data1->diff($data2);

    //verifica se a empresa ainda esta no periodo experimental do sistema.
    if ($data['config']->insento == 0 && $data['config']->periodo_experimental == 1 && strtotime($data['config']->data_final_experimental) > strtotime($dataAtual)) {
        //echo 'AbreCobranca(1);';
        ?>
	    $.gritter.add({
	        title: 'Aviso!',
	        text: "Seu período experimental termina em  <?php echo date("d/m/Y", strtotime($data['config']->data_final_experimental));?>, restando apenas <?php echo $intervalo->d ;?><?php if($intervalo->d > 1){ echo ' dias';}else{ echo ' dia';};?>",
	        class_name: 'warning',
	        before_open: function () {
	            if ($('.gritter-item-wrapper').length == 1) {
	                // prevents new gritter 
	                return false;
	            }
	        }
	    });
	    <?php
    } else if ($data['config']->insento == 0 && $data['config']->periodo_experimental == 1 && strtotime($data['config']->data_final_experimental) == strtotime($dataAtual)) {
        //echo 'AbreCobranca(1);';
        ?>
	    $.gritter.add({
	        title: 'Aviso!',
	        text: 'Seu período experimental termina hoje <?php echo date("d/m/Y", strtotime($data['config']->data_final_experimental)) ?>, não fique sem gerenciar sua empresa de uma forma rápida segura e inteligente!',
	        class_name: 'warning',
	        before_open: function () {
	            if ($('.gritter-item-wrapper').length == 1) {
	                // prevents new gritter 
	                return false;
	            }
	        }
	    });
	    <?php
    } else if ($data['config']->insento == 0 && $data['config']->periodo_experimental == 1 && strtotime($data['config']->data_final_experimental) < strtotime($dataAtual)) {
        echo 'AbreCobranca(3);'; 
    }
    else if($data['config']->insento == 0 && $data['config']->periodo_experimental == 0) {
        //verifica se a empresa pagou a mensalidade.
        
        if(empty($data['mensalidade']->data_vencimento)){
            echo 'AbreCobranca(2);'; 
        } else{
            $dataPg1 = new DateTime($dataAtual);
            $dataPg2 = new DateTime($data['mensalidade']->data_vencimento);
            $intervaloPg = $dataPg1->diff($dataPg2);

            if ($dataPg1 > $dataPg2) {
                $diasRestantes = -$intervaloPg->days;
            } else {
                $diasRestantes = $intervaloPg->days;
            }
            
            if ($diasRestantes >= 0 && $diasRestantes <= 3) { ?>
                $.gritter.add({
                    title: 'Comunicado!',
                    text: "Sua ativação mensal termina em  <?php echo date("d/m/Y", strtotime($data['mensalidade']->data_vencimento));?>, restando apenas <?php echo $intervaloPg->d ;?><?php if($intervaloPg->d > 1){ echo ' dias';}else{ echo ' dia';};?>.",
                    class_name: 'warning',
                    before_open: function () {
                        if ($('.gritter-item-wrapper').length == 1) {
                            // prevents new gritter 
                            return false;
                        }
                    }
                });
	    <?php } elseif($diasRestantes < 0) {
            echo 'AbreCobranca(2);';  
        }
    } ?>
    <?php } ?>
});
</script>