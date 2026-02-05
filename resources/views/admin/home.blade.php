<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="washington mendes">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap.switch/bootstrap-switch.min.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery.easypiechart/jquery.easy-pie-chart.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
        <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery.datatables/bootstrap-adapter/css/datatables.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />
    <link href="<?php echo $baseUri; ?>/assets/css/bloqueio.css" rel="stylesheet" />
    <link href="<?php echo $baseUri; ?>/assets/css/matrix-style.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/bootstrap.datetimepicker/css/bootstrap-datetimepicker.css">
    <style>
        .bootstrap-switch-handle-off {
            padding-right: 30px !important;
        }
    </style>
    <link rel="stylesheet" href="css/export.css" type="text/css" media="all" />
    <script src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="js/amcharts/amcharts.js"></script>
    <script type="text/javascript" src="js/amcharts/pie.js"></script>
    <script type="text/javascript" src="js/amcharts/serial.js"></script>
    <script type="text/javascript" src="js/amcharts/animate.min.js"></script>
    <script type="text/javascript" src="js/export.min.js"></script>
    <script type="text/javascript" src="js/amcharts/themes/light.js"></script>
    <link href="<?php echo $baseUri; ?>/assets/css/x0popup-master/dist/x0popup.min.css" rel="stylesheet">
    <script src="<?php echo $baseUri; ?>/assets/css/x0popup-master/dist/x0popup.min.js"></script>
</head>

<body class="animated">
    <?php
    require_once 'cobranca.php';
    //require_once 'bloqueio.php';
    ?>
    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php require_once 'side-menu.php'; ?>
        </div>
        <div class="container-fluid" id="pcont">
            <?php require_once 'top-menu.php'; ?>
            <div class="cl-mcont">
                
                <!-- ALERTA CENTRALIZADO DO MÓDULO MESAS -->
                <?php if (isset($_SESSION['mesas_alert_show']) && $_SESSION['mesas_alert_show']): ?>
                <div id="mesas-success-alert" class="alert alert-success alert-dismissible" role="alert" style="margin: 20px; border-left: 5px solid #5cb85c; background-color: #dff0d8; border-color: #d6e9c6; font-size: 16px; padding: 20px;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="dismissMesasAlert()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div style="display: flex; align-items: center;">
                        <i class="fa fa-check-circle" style="font-size: 24px; color: #5cb85c; margin-right: 15px;"></i>
                        <div>
                            <h4 style="margin: 0 0 5px 0; color: #3c763d;"><strong>Módulo de mesas ativo com sucesso!</strong></h4>
                            <p style="margin: 0; color: #3c763d;">
                                O sistema de restaurante foi instalado e está pronto para uso. Você agora tem acesso completo a:
                                <br><strong>Gestão de Mesas, Sistema de Garçons, Caixa, Display da Cozinha e Reservas.</strong>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="block-flat">
                    <h3>Status da Loja </h3>
                    <input class="switch" name="loja-status" data-size="large" type="checkbox" data-on-color="success" data-off-color="danger" data-on-text="&nbsp; ABERTA" data-off-text="FECHADA&nbsp;" <?= (isset($data['config']) && $data['config']->config_aberto == 1) ? 'checked' : '' ?>>
                    <br /><br /><br /><br /><br />
                    <input type="hidden" name="nivel" id="nivel" value="<?php echo Sessao::get_nivel(); ?>">
                    <?php if (Sessao::get_nivel() == 1) : ?>

                        <form action="" method="post">
                            <?php
                            Post::change('data_inicio', date('d/m/Y', strtotime(str_replace('/', '-', Post::get('data_inicio')))));
                            Post::change('data_fim', date('d/m/Y', strtotime(str_replace('/', '-', Post::get('data_fim')))));

                            if (isset($_POST['data_inicio']) && isset($_POST['data_fim'])) {
                                $dataInicio = $_POST['data_inicio'];
                                $dataFim = $_POST['data_fim'];
                            } else {
                                $dataInicio = date('01/m/Y');
                                $dataFim = date('d/m/Y');
                            }
                            ?>
                            <div class="col-md-2 form-group">
                                <input type="text" name="data_inicio" id="data_inicio" class="form-control  data-inicio" autocomplete="off" placeholder="Data Inicial" value="<?= $dataInicio ?>" required />
                            </div>
                            <div class="col-md-2 form-group">
                                <input type="text" name="data_fim" id="data_fim" class="form-control data-fim" autocomplete="off" placeholder="Data Final" value="<?= $dataFim ?>" required />
                            </div>
                            <div class="col-md-2 form-group">
                                <button type="submit" class="btn btn-xs btn-status" data-status="6">
                                    <i class="fa fa-search"></i> Pesquisar</button>
                            </div>
                        </form>
                    <?php
                    endif;
                    ?>
                    <?php if (isset($data['pedido'][0])) : ?>
                        <div class="header">
                            <h3>Últimos Pedidos Pendentes</h3>
                        </div>
                        <table class="table table-bordered table-striped datatable" id="datatable">
                            <thead>
                                <tr>
                                    <th>Pedido</th>
                                    <th>Cliente</th>
                                    <th>Forma de Pagto</th>
                                    <th>Valor</th>
                                    <th width="170">Data</th>
                                    <th>Status Pagseguro</th>
                                    <th>Status Pedido</th>
                                    <th width="50"><i class="fa fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['pedido'] as $obj) : ?>
                                    <?php
                                    $status = Status::check($obj->pedido_status);
                                    $status_pg = Status::pagseguro($obj->pedido_pagseguro);
                                    $obj->cliente_fone2 = preg_replace('/\D/', '', $obj->cliente_fone2);
                                    ?>
                                    <tr class="status-<?= $obj->pedido_status ?>">
                                        <td><?= $obj->pedido_id ?></td>
                                        <td><?= ucfirst($obj->cliente_nome) ?></td>
                                        <td><?= $obj->pedido_obs_pagto ?></td>
                                        <td><?= Currency::moeda($obj->pedido_total) ?></td>
                                        <td class="text-center"><?= Timer::parse_date_br($obj->pedido_data) ?></td>
                                        <td width="170" class="bg-<?= $status_pg->color ?>"><?= $status_pg->icon ?></td>
                                        <td width="170" class="bg-<?= $status->color ?>"><?= $status->icon ?></td>
                                        <td width="160" class="text-center">
                                            <a href="https://api.whatsapp.com/send?phone=+55<?= $obj->cliente_fone2 ?>" data-toggle="tooltip" title="chamar no whats" target="_blank" class="btn btn-success btn-xs">
                                                <i class="fa fa-whatsapp"></i> </span>
                                            </a>

                                            <a class="btn btn-warning btn-xs" data-toggle="tooltip" href="<?php echo $baseUri; ?>/admin/imprimir/<?= $obj->pedido_id ?>/" target="_blank" title="Imprimir"><i class="fa fa-print"></i></a>

                                            <a href="<?php echo $baseUri; ?>/admin/pedido/<?= $obj->pedido_id ?>/" data-toggle="tooltip" title="detalhes" class="btn btn-xs btn-prusia"><i class="fa fa-search"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <br>
                    <?php if (isset($data['estoque'][0])) : ?>
                        <div class="header">
                            <h3>Itens com estoque baixo</h3>
                        </div>
                        <table class="table table-bordered table-striped datatable" id="datatabler">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Categoria</th>
                                    <th>Quantidade</th>
                                    <th width="60"><i class="fa fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['estoque'] as $obj) : ?>
                                    <tr>
                                        <td><?= $obj->item_nome ?></td>
                                        <td><?= $obj->categoria_nome ?></td>
                                        <td width="120" class=" text-center bg-<?= ($obj->item_estoque < 10) ? 'danger' : ''; ?>"><?= $obj->item_estoque ?></td>
                                        <td width="60" class="text-center"><a href="<?php echo $baseUri; ?>/item/editar/<?= $obj->item_id ?>/" title="repor" data-toggle="tooltip" class="btn btn-xs btn-prusia"><i class="fa fa-refresh"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <br> <br>
                    <?php if (isset($data['cliente'][0])) : ?>
                        <div class="header">
                            <h3>Últimos Clientes Cadastrados</h3>
                        </div>
                        <table class="table table-bordered table-striped datatable" id="datatablex">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Fone</th>
                                    <th>Cidade</th>
                                    <th>Bairro</th>
                                    <th width="60"><i class="fa fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['cliente'] as $obj) : ?>
                                    <tr>
                                        <td><?= $obj->cliente_id ?></td>
                                        <td><?= $obj->cliente_nome ?></td>
                                        <td><?= $obj->cliente_email ?></td>
                                        <td><?= ($obj->cliente_fone != '') ? $obj->cliente_fone : $obj->cliente_fone2; ?></td>
                                        <td><?= $obj->endereco_cidade ?></td>
                                        <td><?= $obj->endereco_bairro ?></td>
                                        <td width="60" class="text-center"><a href="<?php echo $baseUri; ?>/cliente/editar/<?= $obj->cliente_id ?>/" class="btn btn-xs btn-prusia"><i class="fa fa-search"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
        $last_pedido = 0;
        if (isset($data['pedido'][0])) :
            $last_pedido = end($data['pedido']);
            $last_pedido = $last_pedido->pedido_id;
        endif;
        ?>
        <input type="hidden" id="last-pedido" value="<?= $last_pedido ?>">
        <?php //require_once 'side-right-chat.php'; 
        ?>
        <script type="text/javascript">
            var empresa = "<?= $_SESSION['base_delivery'] ?>";
            var idcliente = <?= isset($data['pedido'][0]->pedido_cliente) ? $data['pedido'][0]->pedido_cliente : 0 ?>;
        </script>
        <script src="js/jquery.cooki/jquery.cooki.js"></script>
        <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
        <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
        <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
        <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
        <script type="text/javascript" src="js/behaviour/core.js"></script>
        <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.switch/bootstrap-switch.js"></script>
        <script type="text/javascript" src="js/jquery.datatables/jquery.datatables.min.js"></script>
        <script type="text/javascript" src="js/jquery.datatables/bootstrap-adapter/js/datatables.js"></script>
        <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
        <script src="app-js/main.js"></script>
        <script src="js/cupom-desconto/moment.js"></script>
        <script src="js/cupom-desconto/moment-pt-br.js"></script>
        <script src="js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.data-inicio, .data-fim').datetimepicker({
                    format: 'DD/MM/YYYY'
                });
            });

            var baseUrl = '<?php echo $baseUri; ?>';
            $("#cl-wrapper").removeClass("sb-collapsed");
            $('#menu-home').addClass('active');
            $('.switch').bootstrapSwitch();
            if (oDt) {
                oDt.fnSort([
                    [0, 'desc']
                ]);
            }
            var nivel = $('#nivel').val();

            $('input[name="loja-status"]').on('switchChange.bootstrapSwitch', function(event, state) {
                const $switch = $(this);
                const url = `${baseUrl}/StatusLoja/gravar/`;

                // Converte true/false em 1/0
                const novoEstado = +state;

                // Desabilita o switch enquanto grava no servidor
                $switch.bootstrapSwitch('disabled', true);

                $.post(url, {
                        config_aberto: novoEstado,
                        redir: 'true'
                    })
                    .done(data => {
                        // console.log('Servidor respondeu:', data);
                        // Aqui você pode tratar a resposta se precisar
                        // Por exemplo, mostrar um toast de sucesso
                    })
                    .fail(err => {
                        // console.error('Erro ao gravar status da loja:', err);
                        // Em caso de erro, volta o switch para o estado anterior
                        $switch.bootstrapSwitch('state', !novoEstado, true);
                    })
                    .always(() => {
                        // Reabilita o switch
                        $switch.bootstrapSwitch('disabled', false);
                    });
            });
        </script>
        
        <!-- JavaScript para o alerta do módulo mesas -->
        <script>
            function dismissMesasAlert() {
                const alertElement = document.getElementById('mesas-success-alert');
                
                // Animação de fade out
                if (alertElement) {
                    alertElement.style.transition = 'opacity 0.5s ease';
                    alertElement.style.opacity = '0';
                    
                    setTimeout(() => {
                        alertElement.remove();
                    }, 500);
                }
                
                // Chama o servidor para marcar como dismissado
                $.ajax({
                    url: '<?php echo $baseUri; ?>/admin/dismiss_mesas_alert/',
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao dismissar alerta:', error);
                    }
                });
            }
            
            // Auto-hide após 15 segundos (opcional)
            $(document).ready(function() {
                if ($('#mesas-success-alert').length > 0) {
                    setTimeout(function() {
                        dismissMesasAlert();
                    }, 15000); // 15 segundos
                }
            });
            
            <?php if (Sessao::get_bot_whatsapp() == 1) : ?>
            // 🚚 VERIFICAR NOTIFICAÇÕES DE ENTREGADOR A CADA 5 SEGUNDOS
            setInterval(function() {
                $.ajax({
                    url: '<?php echo $baseUri; ?>/api/check-notificacoes-entregador.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Notificações de aceitação
                            if (response.notificacoes_aceitas && response.notificacoes_aceitas.length > 0) {
                                response.notificacoes_aceitas.forEach(function(notif) {
                                    $.gritter.add({
                                        title: '🏍️ Entregador a Caminho!',
                                        text: '<strong>' + notif.entregador_nome + '</strong> aceitou a entrega<br>' +
                                              'Pedido #' + notif.pedido_numero_entrega + '<br>' +
                                              'Cliente: ' + notif.cliente_nome,
                                        class_name: 'success',
                                        sticky: false,
                                        time: 8000
                                    });
                                });
                            }
                            
                            // Notificações de entrega confirmada
                            if (response.notificacoes_entregues && response.notificacoes_entregues.length > 0) {
                                response.notificacoes_entregues.forEach(function(notif) {
                                    $.gritter.add({
                                        title: '✅ Entrega Confirmada!',
                                        text: '<strong>' + notif.entregador_nome + '</strong> confirmou a entrega<br>' +
                                              'Pedido #' + notif.pedido_numero_entrega + '<br>' +
                                              'Cliente: ' + notif.cliente_nome,
                                        class_name: 'success',
                                        sticky: false,
                                        time: 8000
                                    });
                                });
                            }
                            
                            // Notificações de entrega RECUSADA
                            if (response.notificacoes_recusadas && response.notificacoes_recusadas.length > 0) {
                                response.notificacoes_recusadas.forEach(function(notif) {
                                    $.gritter.add({
                                        title: '❌ Entrega Recusada!',
                                        text: '<strong>' + notif.entregador_nome + '</strong> recusou a entrega<br>' +
                                              'Pedido #' + notif.pedido_numero_entrega + '<br>' +
                                              'Cliente: ' + notif.cliente_nome,
                                        class_name: 'danger',
                                        sticky: true,
                                        time: 30000
                                    });
                                });
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        // Silenciar erros para não poluir console
                    }
                });
            }, 5000); // A cada 5 segundos
            <?php endif; ?>
        </script>
</body>

</html>