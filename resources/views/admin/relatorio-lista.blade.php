<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
        <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap.datetimepicker/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery.select2.2/select2.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />
</head>

<body class="animated">
    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php require_once 'side-menu.php'; ?>
        </div>
        <div class="container-fluid" id="pcont">
            <!-- TOP NAVBAR -->
            <?php require_once 'top-menu.php'; ?>
            <div class="cl-mcont">
                <h3 class="text-center">Relatório de Ordens de Serviço</h3>
                <div class="block-flat">
                    <div class="header">
                        <h3>Filtros</h3>
                    </div>
                    <div class="content">

                        <form name="form-filtro">
                            <div class="row">

                                <div class="col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label>Cliente</label>
                                        <select name="chamado_cliente" id="chamado_cliente" class="select2" required>
                                            <option value="">Selecione um cliente</option>
                                            <option value="">Todos</option>
                                            <?php if (isset($data['cliente'][0])) : ?>
                                                <?php foreach ($data['cliente'] as $c) : ?>
                                                    <option value="<?= $c->cliente_id ?>"><?= $c->cliente_nome ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 col-xs-12">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="chamado_status" id="chamado_status" class="select2" required>
                                            <option value="">Selecione um status</option>
                                            <option value="">Todos</option>
                                            <option value="1">Aberto</option>
                                            <option value="2">Em Andamento</option>
                                            <option value="3">Aguardando Material</option>
                                            <option value="4">Cancelado</option>
                                            <option value="5">Finalizado</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-xs-12">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Data Inicial</label>
                                            <input class="form-control sys-datas" name="chamado_inicio" id="chamado_inicio" data-format="dd-mm-yyyy hh:ii" type="text" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Data Final</label>
                                            <input class="form-control sys-datas" name="chamado_entrega" id="chamado_entrega" data-format="dd-mm-yyyy hh:ii" type="text" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 col-xs-12">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button class="btn btn-primary"><i class="fa fa-filter"></i> Filtrar</button>
                                    </div>
                                </div>

                            </div>
                        </form>

                        <div class="table-responsives">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Técnico</th>
                                        <th>Serviço</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($data['chamado'][0])) : ?>
                                        <?php foreach ($data['chamado'] as $obj) : ?>
                                            <tr class="gradeA" id="tr-<?= $obj->chamado_id ?>">
                                                <td><?= $obj->cliente_nome ?></td>
                                                <td><?= $obj->tecnico_nome ?></td>
                                                <td><?= $obj->grupo_nome ?></td>
                                                <td>
                                                    <span class="col-lg-offset-2 col-md-8 label label-<?= preg_replace(array('/1/', '/2/', '/3/', '/4/', '/5/'), array('primary', 'info', 'warning', 'danger', 'success'), $obj->chamado_status) ?>">
                                                        <?= preg_replace(array('/1/', '/2/', '/3/', '/4/', '/5/'), array('Aberto', 'Em Andamento', 'Aguardando Material', 'Cancelado', 'Finalizado'), $obj->chamado_status) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Right Chat-->
        <?php //require_once 'side-right-chat.php'; 
        ?>


        <script src="js/jquery.js"></script>
        <script src="js/jquery.cooki/jquery.cooki.js"></script>
        <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
        <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
        <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
        <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
        <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
        <script type="text/javascript" src="js/behaviour/core.js"></script>
        <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/jquery.select2.2/select2.min.js"></script>
        <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.datetimepicker/js/locales/bootstrap-datetimepicker.pt-BR.js"></script>
        <script src="app-js/main.js"></script>
        <script src="app-js/chamado.js"></script>
        <script type="text/javascript">
            $(".select2").select2({
                width: '100%'
            });
            //set menu ativo
            $('#menu-relatorio').addClass('active');
            $('.sys-datas').datetimepicker({
                language: 'pt-BR',
                format: "dd-mm-yyyy hh:ii",
                autoclose: true,
                todayBtn: true
                //minView: 4
            });

            
        </script>
</body>

</html>