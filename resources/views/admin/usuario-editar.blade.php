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
                <h3 class="text-center">Cadastrar Usuário</h3>
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="block-flat">
                            <div class="header">
                                <h3>Dados do Novo Usuário
                                    <span class="pull-right"><a href="<?php echo $baseUri; ?>/usuario/" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i> Listar Usuários</a></span>
                                </h3>
                            </div>
                            <div class="content">
                                <form name="form-novo" id="form-novo" action="<?php echo $baseUri; ?>/usuario/gravar/" method="post">
                                    <?php $u = $data['user']; ?>
                                    <input type="hidden" name="usuario_id" value="<?= $u->usuario_id ?>">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" name="usuario_nome" id="usuario_nome" class="form-control" value="<?= $u->usuario_nome ?>" placeholder="Informe o nome completo" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <span class="text-danger">*</span>
                                        <input type="email" name="usuario_email" id="usuario_email" class="form-control" value="<?= $u->usuario_email ?>" placeholder="informe um usuário válido" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Login</label>
                                        <span class="text-danger">*</span>
                                        <input type="text" name="usuario_login" id="usuario_login" class="form-control" value="<?= $u->usuario_login ?>" placeholder="Login do usuário ex: admin ou operador01" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Senha</label>
                                        <input type="password" name="usuario_senha" id="usuario_senha" class="form-control" placeholder="Informe uma senha de acesso">
                                    </div>
                                    <div class="form-group">
                                        <label>Nível de acesso</label>
                                        <span class="text-danger">*</span>
                                        <select name="usuario_nivel" id="usuario_nivel" class="form-control" required>
                                            <option value="">Selecione um nível de acesso</option>
                                            <option value="1">Administrador</option>
                                            <option value="2">Operador</option>
                                        </select>
                                    </div>
                                    <div class="form-group hide">
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
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-flat">
                                            <i class="fa fa-check-circle-o"></i> GRAVAR DADOS
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Right Chat-->
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
        <script>
            $('#menu-usuario').addClass('active');
        </script>
        <script>
            $('#usuario_nivel').val('<?= $u->usuario_nivel ?>');
        </script>
        <script type="text/javascript">
            
        </script>
</body>

</html>