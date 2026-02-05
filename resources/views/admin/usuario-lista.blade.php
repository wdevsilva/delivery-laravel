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
    <link rel="stylesheet" type="text/css" href="css/jasny-bootstrap.css" />
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
                        <h3>Usuários
                            <span class="pull-right"><a href="<?= $baseUri ?>/usuario/novo/" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Cadastrar Novo</a></span>
                        </h3>
                    </div>
                    <div class="content">

                        <div class="table-responsives">
                            <table class="table table-bordered table-striped" id="datatable">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Login</th>
                                        <th>Email</th>
                                        <th width="140" class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($data['usuario'][0])) : ?>
                                        <?php foreach ($data['usuario'] as $obj) : ?>
                                            <tr class="gradeA" id="tr-<?= $obj->usuario_id ?>">
                                                <td id="td-nome"><?= $obj->usuario_nome ?></td>
                                                <td id="td-login"><?= $obj->usuario_login ?></td>
                                                <td id="td-email"><?= $obj->usuario_email ?></td>
                                                <td class="center">
                                                    <a href="<?= $baseUri ?>/usuario/editar/<?= $obj->usuario_id ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i>
                                                    </a>
                                                    <button data-id="<?= $obj->usuario_id ?>" class="btn btn-sm btn-danger btn-remover"><i class="fa fa-trash-o"></i></button>
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

        <div class="modal fade colored-header" id="modal-editar" tabindex="-1" role="dialog">
            <div class="modal-dialog custom-width">
                <div class="modal-content">
                    <form name="form-editar" id="form-editar" action="<?php echo $baseUri; ?>/usuario/gravar/" method="post">
                        <div class="modal-header">
                            <h3>Editar Usuário</h3>
                            <button type="button" class="close md-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body form">
                            <div class="form-group">
                                <label>Nome</label> <input type="text" name="usuario_nome" id="usuario_nome" class="form-control" placeholder="Informe o nome completo" required>
                            </div>
                            <!--
                                <div class="form-group">
                                    <label>Fone</label> <input type="text" data-mask="phone" name="usuario_fone"  id="usuario_fone" class="form-control" placeholder="Telefone de contato" >
                                </div>
                                -->
                            <div class="form-group">
                                <label>Email</label> <input type="email" name="usuario_email" id="usuario_email" class="form-control" placeholder="informe um usuário válido" required>
                            </div>
                            <div class="form-group">
                                <label>Login</label> <input type="text" name="usuario_login" id="usuario_login" class="form-control" placeholder="Login do usuário ex: admin" required>
                            </div>
                            <div class="form-group">
                                <label>Senha</label> <input type="password" name="usuario_senha" id="usuario_senha" class="form-control" placeholder="Informe uma senha de acesso">
                            </div>
                            <input type="hidden" name="usuario_id" id="usuario_id">

                            <div class="form-group">
                                <label>Foto</label> <br>
                                <textarea class="hide" id="usuario_avatar" name="usuario_avatar"></textarea>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" id="imgeditar" style="width: 150px; height: 100px;"></div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" id="tes" style="max-width: 150px; max-height: 120px;"></div>
                                    <div>
                                        <span class="btn btn-default btn-file"><span class="fileinput-new">Selecionar Foto</span><span class="fileinput-exists">Alterar</span><input type="file" name="..."></span>
                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat md-close" data-dismiss="modal">
                                <i class="fa fa-times-circle-o"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary btn-flat">
                                <i class="fa fa-check-circle-o"></i> Prosseguir
                            </button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade colored-header" id="modal-novo" tabindex="-1" role="dialog">
            <div class="modal-dialog custom-width">
                <div class="modal-content">
                    <form name="form-novo" id="form-novo" action="<?php echo $baseUri; ?>/usuario/gravar/" method="post">
                        <div class="modal-header">
                            <h3>Novo Usuário</h3>
                            <button type="button" class="close md-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body form">
                            <div class="form-group">
                                <label>Nome</label> <input type="text" name="usuario_nome" id="usuario_nome" class="form-control" placeholder="Informe o nome completo" required>
                            </div>
                            <!--
                                <div class="form-group">
                                    <label>Fone</label> <input type="text" data-mask="phone" placeholder="(99) 999-999-999"  name="usuario_fone"  id="usuario_fone" class="form-control">
                                </div>
                                -->
                            <div class="form-group">
                                <label>Email</label> <input type="email" name="usuario_email" id="usuario_email" class="form-control" placeholder="informe um usuário válido" required>
                            </div>
                            <div class="form-group">
                                <label>Login</label> <input type="text" name="usuario_login" id="usuario_login" class="form-control" placeholder="Login do usuário ex: admin" required>
                            </div>
                            <div class="form-group">
                                <label>Senha</label> <input type="password" name="usuario_senha" id="usuario_senha" class="form-control" placeholder="Informe uma senha de acesso" required>
                            </div>

                            <div class="form-group">
                                <label>Foto</label> <br>
                                <textarea class="hide" id="usuario_avatar" name="usuario_avatar"></textarea>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" id="imgeditar" style="width: 150px; height: 100px;">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" id="tes" style="max-width: 150px; max-height: 120px;"></div>
                                    <div>
                                        <span class="btn btn-default btn-file"><span class="fileinput-new">Selecionar Foto</span><span class="fileinput-exists">Alterar</span><input type="file" name="..."></span>
                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat md-close" data-dismiss="modal">
                                <i class="fa fa-times-circle-o"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary btn-flat">
                                <i class="fa fa-check-circle-o"></i> Prosseguir
                            </button>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

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
                        <form name="form-remove" id="form-remove" action="<?php echo $baseUri; ?>/usuario/remove/" method="post">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-warning btn-flat btn-confirma-remove">Prosseguir</button>
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
        <script type="text/javascript" src="js/jasny.bootstrap/extend/js/jasny-bootstrap.min.js"></script>
        <script src="app-js/main.js"></script>
        <script src="app-js/usuario.js"></script>
        <script type="text/javascript">
            

            $(function() {
                <?php if (isset($data['me'][0])) : ?>
                    $('.btn-editar').each(function() {
                        if ($(this).data('id') == <?= $data['me'][0] ?>) {
                            $(this).trigger('click');
                        }
                    });
                <?php endif; ?>
                $('#menu-usuario').addClass('active');
                oDt.fnSort([
                    [0, 'asc']
                ]); //ordem da tabela   
            });
            <?php if (isset($_GET['success'])) : ?>
                _alert_success();
            <?php endif; ?>
        </script>
</body>

</html>