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
    <link rel="stylesheet" type="text/css" href="js/bootstrap.switch/bootstrap-switch.min.css" />
    <link rel="stylesheet" href="<?= $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <style>
        .bootstrap-switch-handle-off {
            padding-right: 30px !important;
        }
    </style>
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
                <div class="block-flat">
                    <div class="header">
                        <h3>
                            <?php if (isset($data['categoria'])) : ?>
                                Produtos da categoria: <b><?= $data['categoria']; ?></b>
                            <?php else : ?>
                                Produtos Cadastrados
                            <?php endif; ?>
                            <span class="pull-right">
                                <!--<button type="button" class="btn btn-primary btn-novo"><i class="fa fa-plus-circle"></i> Cadastrar Novo</button>-->
                                <a href="<?= $baseUri; ?>/item/novo/" class="btn btn-primary btn-novo"><i class="fa fa-plus-circle"></i> Novo Produto</a>
                            </span>
                        </h3>
                    </div>
                    <div class="content">
                        <div class="table-responsives">
                            <table class="table table-bordered table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th width="100" class="text-center">Foto</th>
                                        <th width="80">Código</th>
                                        <th>Produto</th>
                                        <th>Categoria</th>
                                        <th>Preço</th>
                                        <th>Estoque</th>
                                        <th>Status</th>
                                        <th width="260">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($data['item'][0])) : ?>
                                        <?php foreach ($data['item'] as $obj) : ?>
                                            <tr id="tr-<?= $obj->item_id ?>">
                                                <?php if ($obj->item_foto != "") : ?>
                                                    <td class="gradeA" align="center"><img src="<?= $baseUri; ?>/assets/thumb.php?zc=1&w=170&h=160&src=item/<?= $_SESSION['base_delivery'] ?>/<?= $obj->item_foto; ?>" alt="Foto" class="img-responsive" /></td>
                                                <?php else : ?>
                                                    <td class="gradeA" align="center"><img src="<?= $baseUri; ?"?>/assets/thumb.php?zc=1&w=50&h=50&src=img/sem_foto.jpg" alt="Foto" class="img-responsive" /></td>
                                                <?php endif; ?>
                                                <td id="td-codigo" class="text-uppercase"><?= $obj->item_codigo ?></td>
                                                <td id="td-nome"><?= $obj->item_nome ?></td>
                                                <td id="td-categoria"><?= $obj->categoria_nome ?></td>
                                                <td id="td-preco"><?= Currency::moeda($obj->item_preco) ?></td>
                                                <td id="td-estoque" class="bg-<?= ($obj->item_estoque <= 10) ? 'danger' : 'success' ?> text-center">
                                                    <?php if (Sessao::get_nivel() == 2) { //apenas admin pode atualizar o estoque?>
                                                        <?php echo $obj->item_estoque; ?>
                                                    <?php } else { ?>
                                                        <input type="number" class="form-control text-center update-estoque" id="<?php echo $obj->item_id; ?>" style="width:80px;" value="<?php echo $obj->item_estoque; ?>" <?php if (Sessao::get_nivel() == 2) { ?> disabled title="Apenas administradores podem atualizar o estoque" <?php } ?>/>
                                                    <?php } ?>
                                                    <!-- <span data-toggle="tooltip" title="//($obj->item_estoque <= 10) ? 'estoque baixo' : ''"></span> -->
                                                </td>
                                                <td id="td-status<?= $obj->item_id ?>"><?= $obj->item_ativo == 1 ? 'Ativo' : 'Inativo' ?></td>
                                                <td class="text-center text-nowrap">
                                                    <input class="switch" name="item-status" data-size="small" type="checkbox" data-id="<?= $obj->item_id ?>" data-on-color="success" data-off-color="danger" data-on-text="&nbsp; Ativo" data-off-text="Inativo&nbsp;" <?= (isset($obj) && $obj->item_ativo  == 1) ? 'checked' : '' ?>>
                                                    <?php if ($obj->item_promo == 1) : ?>
                                                        <a data-id="<?= $obj->item_id ?>" data-promo="<?= $obj->item_promo ?>" title="Remover de Promoção" data-toggle="tooltip" class="btn btn-sm btn-success btn-promo">
                                                            <i class="fa fa-star"></i>
                                                        </a>
                                                    <?php else : ?>
                                                        <a data-id="<?= $obj->item_id ?>" data-promo="<?= $obj->item_promo ?>" title="Colocar em Promoção" data-toggle="tooltip" class="btn btn-sm btn-danger btn-promo">
                                                            <i class="fa fa-star-o"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <a href="<?= $baseUri; ?>/item/duplicar/<?= $obj->item_id ?>/" title="duplicar item" data-toggle="tooltip" class="btn btn-sm btn-primary"><i class="fa fa-copy"></i>
                                                    </a>

                                                    <a href="<?= $baseUri; ?>/item/editar/<?= $obj->item_id ?>/" title="editar item" data-toggle="tooltip" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i>
                                                    </a>
                                                    <button data-id="<?= $obj->item_id ?>" title="excluir" data-toggle="tooltip" title="excluir item" data-toggle="tooltip" class="btn btn-sm btn-danger btn-remover"><i class="fa fa-trash-o"></i>
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
                        <form name="form-remove" id="form-remove" action="<?= $baseUri; ?>/item/remove/" method="post">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-warning btn-flat btn-confirma-remove">Prosseguir</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
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
    <script>
        var baseUri = '<?= $baseUri; ?>';
    </script>
    <script src="js/jquery.js"></script>
    <script src="js/jquery.cooki/jquery.cooki.js"></script>
    <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="js/behaviour/core.js"></script>
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.switch/bootstrap-switch.js"></script>
    <script type="text/javascript" src="js/jquery.datatables/jquery.datatables.min.js"></script>
    <script type="text/javascript" src="js/jquery.datatables/bootstrap-adapter/js/datatables.js"></script>
    <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
    <script src="app-js/main.js"></script>
    <script src="app-js/item.js"></script>
    <script type="text/javascript">
        $('#menu-item').addClass('active');
        if (oDt) {
            oDt.fnSort([
                [2, 'asc']
            ]);
        }
        <?php if (isset($_GET['success'])) : ?>
            _alert_success();
        <?php endif; ?>

        $('.switch').bootstrapSwitch();

        $('input[name="item-status"]').on('switchChange.bootstrapSwitch', function(event, state) {

            var id = $(this).attr("data-id");

            var url = baseUri + '/item/altera_status_item/';

            if (state == false) {
                state = 0;
                $("#td-status" + id).html("Inativo");
            } else {
                state = 1;
                $("#td-status" + id).html("Ativo");
            }

            $.post(url, {
                status_item: state,
                item: id,
                redir: 'true'
            }, function(data) {
            });
        });
    </script>
</body>

</html>
