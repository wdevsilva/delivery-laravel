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
                        <h3>
                            Categorias
                            <span class="pull-right">
                                <a href="<?php echo $baseUri; ?>/categoria/novo/" class="btn btn-primary btn-novo"><i class="fa fa-plus-circle"></i> Nova Categoria</a>
                            </span>
                        </h3>
                    </div>
                    <div class="content">
                        <div class="table-responsives">
                            <table class="table table-bordered table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th width="10">Ordem de Exibição</th>
                                        <th width="100">Requer Cozinha</th>
                                        <th width="360">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($data['categoria'][0])) : ?>
                                        <?php foreach ($data['categoria'] as $obj) : ?>
                                            <tr class="gradeA" id="tr-<?= $obj->categoria_id ?>">
                                                <td id="td-nome"><?= $obj->categoria_nome ?></td>
                                                <td>
                                                    <span class="hide"><?php echo Math::zeroEsquerda($obj->categoria_pos, 2); ?></span>
                                                    <input type="text" class="form-control text-center mudar-ordem" id="<?php echo $obj->categoria_id; ?>" value="<?php echo $obj->categoria_pos; ?>" />
                                                </td>
                                                <td class="text-center">
                                                    <?php $requer_cozinha = isset($obj->requer_cozinha) ? $obj->requer_cozinha : 1; ?>
                                                    <?php if ($requer_cozinha == 1) : ?>
                                                        <a data-id="<?= $obj->categoria_id ?>" data-cozinha="<?= $requer_cozinha ?>" title="Não enviar para cozinha" data-toggle="tooltip" class="btn btn-sm btn-success btn-cozinha">
                                                            <i class="fa fa-cutlery"></i> Sim
                                                        </a>
                                                    <?php else : ?>
                                                        <a data-id="<?= $obj->categoria_id ?>" data-cozinha="<?= $requer_cozinha ?>" title="Enviar para cozinha" data-toggle="tooltip" class="btn btn-sm btn-warning btn-cozinha">
                                                            <i class="fa fa-ban"></i> Não
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($obj->categoria_ativa == 1) : ?>
                                                        <a data-id="<?= $obj->categoria_id ?>" data-status="<?= $obj->categoria_ativa ?>" title="Desativar categoria" data-toggle="tooltip" class="btn btn-sm btn-success btn-status">
                                                            <i class="fa fa-check"></i>
                                                        </a>
                                                    <?php else : ?>
                                                        <a data-id="<?= $obj->categoria_id ?>" data-status="<?= $obj->categoria_ativa ?>" title="Ativar categoria" data-toggle="tooltip" class="btn btn-sm btn-danger btn-status">
                                                            <i class="fa fa-ban"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <button data-id="<?= $obj->categoria_id ?>/" title="remover banner" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger btn-banner"><i class="fa fa-picture-o"></i>
                                                    </button>

                                                    <a href="<?php echo $baseUri; ?>/categoria/duplicar/<?= $obj->categoria_id ?>/" title="duplicar categoria" data-toggle="tooltip" class="btn btn-sm btn-primary"><i class="fa fa-copy"></i>
                                                    </a>

                                                    <a href="<?php echo $baseUri; ?>/categoria/editar/<?= $obj->categoria_id ?>/" title="editar categoria" data-toggle="tooltip" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i>
                                                    </a>

                                                    <a href="<?php echo $baseUri; ?>/categoria/item/<?= $obj->categoria_id ?>/" title="Produtos da Categoria" data-toggle="tooltip" class="btn btn-sm btn-info"><i class="fa fa-th-list"></i>
                                                    </a>

                                                    <a href="<?php echo $baseUri; ?>/categoria/grupo/<?= $obj->categoria_id ?>/" title="Grupos da Categoria" data-toggle="tooltip" class="btn btn-sm btn-warning"><i class="fa fa-th"></i>
                                                    </a>

                                                    <button data-id="<?= $obj->categoria_id ?>" title="Remover Categoria" data-toggle="tooltip" class="btn btn-sm btn-danger btn-remover"><i class="fa fa-trash-o"></i>
                                                    </button>
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
                        <form name="form-remove" id="form-remove" action="<?php echo $baseUri; ?>/categoria/remove/" method="post">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-warning btn-flat btn-confirma-remove">Prosseguir</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
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
                        <p><strong>Você está prestes à <span id="status-exibe-nome"></span> o status de um registro </strong></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <form name="form-remove" id="form-status" action="<?php echo $baseUri; ?>/categoria/altera_status/" method="post">
                        <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary btn-flat btn-confirma-status">Prosseguir</button>
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
    <script src="app-js/categoria.js"></script>
    <script type="text/javascript">
        var baseUri = '<?php echo $baseUri; ?>';
        $('#menu-categoria').addClass('active');
        oDt.fnSort([
            [1, 'asc']
        ]); //ordem da tabela
        <?php if (isset($_GET['success'])) : ?>
            _alert_success();
        <?php endif; ?>
    </script>
</body>

</html>