<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="stylesheet" type="text/css" href="js/jquery.datatables/bootstrap-adapter/css/datatables.css" />
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
                <div class="block-flat">
                    <div class="header">
                        <h3>Entregadores
                            <span class="pull-right">
                                <!--<button type="button" class="btn btn-primary btn-novo"><i class="fa fa-plus-circle"></i> Cadastrar Novo</button>-->
                                <a href="<?php echo $baseUri; ?>/entregador/novo/" class="btn btn-primary btn-novo"><i class="fa fa-plus-circle"></i> Cadastrar Novo</a>
                            </span>
                        </h3>
                    </div>
                    <div class="content">
                        <div class="table-responsives">
                            <table class="datatable display nowrap table table-hover table-striped table-bordered" width="100%" id="tbl_entregador">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">ID</th>
                                        <th style="text-align: center;">Nome</th>
                                        <th style="text-align: center;">Celular</th>
                                        <th style="text-align: center;">Status</th>
                                        <th width="180" class="d-print-none" style="text-align: center;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($data[0])) : ?>
                                        <?php foreach ($data as $obj) : ?>
                                            <tr class="gradeA" id="tr-<?= $obj->entregador_id ?>">
                                                <td id="td-id"><?= $obj->entregador_id ?></td>
                                                <td id="td-nome"><?= $obj->entregador_nome ?></td>
                                                <td id="td-fone" class="center"><?= ($obj->entregador_fone != '') ? $obj->entregador_fone : ''; ?></td>
                                                <td id="td-status" style="text-align: center;">
                                                    <?= ($obj->entregador_status == '1') ? 'Ativo' : 'Inativo'; ?>
                                                </td>
                                                <td class="d-print-none" align="center">
                                                    <a href="<?php echo $baseUri; ?>/entregador/editar/<?= $obj->entregador_id ?>/" title="Editar" data-toggle="tooltip" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                    <button data-id="<?= $obj->entregador_id ?>" title="Remover" data-toggle="tooltip" class="btn btn-sm btn-danger btn-remover"><i class="fa fa-trash-o"></i></button>
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
        <div class="modal fade colored-header warning md-effect-10" id="modal-remove" tabindex="-1" role="dialog">
            <div class="modal-dialog custom-width">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Remover Registro</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="i-circle warning"><i class="fa fa-warning"></i></div>
                            <h4>Atenção!</h4>
                            <p>Você está prestes à remover um registro e esta ação não pode ser desfeita. <br />
                                Deseja realmente prosseguir?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form name="form-remove" id="form-remove" action="<?php echo $baseUri; ?>/entregador/remove/" method="post">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-warning btn-flat btn-confirma-remove">Prosseguir</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <script src="js/jquery.js"></script>
        <script src="js/jquery.cooki/jquery.cooki.js"></script>
        <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
        <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
        <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
        <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
        <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
        <script type="text/javascript" src="js/behaviour/core.js"></script>
        <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="js/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="js/datatables-button/dataTables.buttons.min.js"></script>
        <script src="js/datatables-button/buttons.print.min.js"></script>
        <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
        <script src="app-js/main.js"></script>
        <script src="app-js/datatables.js"></script>
        <script src="app-js/entregador.js"></script>
        <script type="text/javascript">
            $('#menu-entregador').addClass('active');
            <?php if (isset($_GET['success'])) : ?>
                _alert_success();
            <?php endif; ?>

            
        </script>
</body>

</html>