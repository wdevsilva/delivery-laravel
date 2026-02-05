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
                <h3 class="text-center">Faixas Cadastradas</h3>
                <div class="block-flat">
                    <div class="header">
                        <h3>Faixas de Entrega</h3>
                    </div>
                    <div class="content">
                        <form action="<?php echo $baseUri; ?>/entrega/gravar/" method="post" class>
                            <input type="hidden" name="entrega_id" value="" />
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-3">
                                        <label>Início</label>
                                        <input type="text" name="entrega_inicio" class="form-control cep" required placeholder="Ex: 09000-000" maxlength="9" />
                                    </div>
                                    <div class="col-md-3">
                                        <label>Fim</label>
                                        <input type="text" name="entrega_fim" class="form-control cep" required placeholder="Ex: 09500-000" maxlength="9" />
                                    </div>
                                    <div class="col-md-2">
                                        <label>Descrição:</label>
                                        <input type="text" name="entrega_nome" class="form-control" required placeholder="Ex: São Paulo " />
                                    </div>
                                    <div class="col-md-2">
                                        <label>Taxa:</label>
                                        <input type="text" name="entrega_taxa" id="entrega_taxa" class="form-control money" required placeholder="2.00" />
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary" style="margin-top: 26px;"><i class="fa fa-save"></i> Cadastrar</button>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </form>
                        <div class="table-responsivse">
                            <table class="table table-bordered table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Taxa de Entrega</th>
                                        <th>Início</th>
                                        <th>Fim</th>
                                        <th width="90">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($data[0])) : ?>
                                        <?php foreach ($data as $obj) : ?>
                                            <tr class="gradeA" id="tr-<?= $obj->entrega_id ?>">
                                                <td id="td-nome"><?= $obj->entrega_nome ?></td>
                                                <td id="td-taxa"><?= $obj->entrega_taxa ?></td>
                                                <td id="td-inicio"><?= (strlen($obj->entrega_inicio) >= 5) ? $obj->entrega_inicio : "0" . $obj->entrega_inicio ?></td>
                                                <td id="td-fim"><?= (strlen($obj->entrega_fim) >= 5) ? $obj->entrega_fim : "0" . $obj->entrega_fim ?></td>
                                                <td class="center">
                                                    <a href="<?php echo $baseUri; ?>/entrega/remove/<?= $obj->entrega_id ?>/" title="Remover" data-toggle="tooltip" class="btn btn-sm btn-danger btn-remover"><i class="fa fa-trash-o"></i>
                                                    </a>
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
                        <form name="form-remove" id="form-remove" action="<?php echo $baseUri; ?>/entrega/remove/" method="post">
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
        <script type="text/javascript" src="js/jquery.datatables/jquery.datatables.min.js"></script>
        <script type="text/javascript" src="js/jquery.datatables/bootstrap-adapter/js/datatables.js"></script>
        <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
        <script src="app-js/main.js"></script>
        <script type="text/javascript" src="js/jquery.mask.js"></script>
        <script type="text/javascript">
            $('.money').mask("#.##0,00", {
                reverse: true
            });
            $('.cep').mask('99999-999');
            $('#menu-config-entrega').addClass('active');
            oDt.fnSort([
                [0, 'desc']
            ]); //ordem da tabela   
            <?php if (isset($_GET['success'])) : ?>
                _alert_success();
            <?php endif; ?>

            
        </script>
</body>

</html>