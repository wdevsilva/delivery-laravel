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
    <link rel="stylesheet" href="<?= $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="<?= $baseUri; ?>/assets/vendor/html5/html5.js"></script>
          <script src="<?= $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
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
                <h3 class="text-center">Categoria x Grupos</h3>
                <div class="block-flat">
                    <div class="header">
                        <h3>
                            <?= $data['categoria']->categoria_nome; ?>
                            <span class="pull-right">
                                <a href="javascript:void(0);" class="btn btn-primary btn-add-grupo">
                                    <i class="fa fa-plus-circle"></i> Vincular Grupo</a>
                            </span>
                        </h3>
                    </div>
                    <div class="content">
                        <div class="table-responsives">
                            <table class="table table-bordered table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th width="50">Ordem</th>
                                        <th>Grupo</th>
                                        <th>Tipo</th>
                                        <th width="80">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($data['grupo'][0])) : ?>
                                        <?php foreach ($data['grupo'] as $obj) : ?>
                                            <tr id="tr-<?= $obj->grupo_id ?>">
                                                <td id="td-pos" class="text-center">
                                                    <input type="number" class="form-control relpos" name="relprod_pos" id="<?= $obj->relprod_id ?>" style="width: 70px; text-align: center;" value="<?= $obj->relprod_pos ?>" maxlength="999" />
                                                </td>
                                                <td id="td-nome"><?= $obj->grupo_nome ?> - <?= $obj->grupo_desc ?></td>
                                                <td id="td-preco"><?= ($obj->grupo_tipo == 1) ? 'Obrigatório' : 'Opcional'; ?></td>
                                                <td class="text-center">
                                                    <a data-cat="<?= $obj->relprod_categoria ?>" data-grp="<?= $obj->relprod_grupo ?>" title="Desvincular Grupo" data-toggle="tooltip" class="btn btn-sm btn-danger btn-rem-grupo">
                                                        <i class="fa fa-trash"></i>
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

        <div class="modal fade colored-header md-effect-10" id="modal-add-grupo" tabindex="-1" role="dialog">
            <div class="modal-dialog custom-width">
                <form name="form-remove" id="form-status" action="<?= $baseUri; ?>/categoria/grupo_add/" method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Vincular Grupo x Categoria</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="categoria_id" value="<?php echo $data['categoria']->categoria_id; ?>" />
                                <label>Grupo de Opcionais / Extras</label>
                                <select class="form-control" name="grupo_id" id="grupo_id">
                                    <?php if (isset($data['grupos'])) : ?>
                                        <?php foreach ($data['grupos'] as $grp) : ?>
                                            <option value="<?php echo $grp->grupo_id ?>">
                                                <?php echo $grp->grupo_nome ?> - <?php echo $grp->grupo_desc ?>
                                                (<?= ($grp->grupo_tipo == 1) ? 'Obrigatório' : 'Opcional'; ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">
                                <i class="fa fa-times"></i>
                                Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary btn-flat btn-confirma-status">
                                <i class="fa fa-plus-circle"></i>
                                Vincular
                            </button>
                        </div>
                    </div><!-- /.modal-content -->
                </form>
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <div class="modal fade colored-header md-effect-10" id="modal-status" tabindex="-1" role="dialog">
            <div class="modal-dialog custom-width">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Alterar Status do Registro</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="i-circle warning"><i class="fa fa-warning"></i></div>
                            <h4><strong>Atenção!</strong></h4>
                            <p><strong>Você está prestes à <span id="status-exibe-nome"></span> o status de um registro
                                </strong></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form name="form-remove" id="form-status" action="<?= $baseUri; ?>/item/altera_status/" method="post">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary btn-flat btn-confirma-status">Prosseguir</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div>
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
    <script type="text/javascript">
        $('#menu-categoria').addClass('active');
        $('.btn-add-grupo').on('click', function() {
            $('#modal-add-grupo').modal('show');
        });
        $('.btn-rem-grupo').on('click', function() {
            var cat = $(this).data('cat');
            var grp = $(this).data('grp');
            var url = baseUri + '/categoria/grupo_rem/'
            $.post(url, {
                categoria_id: cat,
                grupo_id: grp
            }, function(rs) {
                window.location = rs;
            })
        });
        $('.relpos').on('change', function() {
            var pos = $(this).val()
            var id = $(this).attr('id')
            var url = baseUri + '/grupo/update_pos/'
            $.post(url, {
                relprod_id: id,
                relprod_pos: pos
            }, function(rs) {
                _alert_success();
            })
        })
        <?php if (isset($_GET['success'])) : ?>
            _alert_success();
        <?php endif; ?>

        
    </script>
</body>

</html>