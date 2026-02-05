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
    <link rel="stylesheet" type="text/css" href="js/jquery.select2/dist/css/select2.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap.summernote/dist/summernote.css" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/btn-upload.css" rel="stylesheet" />
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
                    <h3 class="text-center">Configurações De Pagamento Online</h3>
                    <div class="header">
                        <h3>PagSeguro</h3>
                    </div>
                    <div class="content">
                        <form action="<?php echo $baseUri; ?>/pagamento/gravar/" method="post" role="form" autocomplete="off">
                            <input type="hidden" name="pagamento_id" id="pagamento_id" value="1">
                            <div class="row">

                                <div class="col-md-12">
                                    <h4 class="text-danger">
                                        Atenção! <br>
                                        Não faça testes de compra no pagseguro utilizando o email de sua conta PagSeguro "<?= $data['pagamento']->pagamento_usuario ?>". <br>
                                        Para testar as compras é necessário informar dados reais, tais como telefone, cpf, email, etc... <br><br>
                                        Se sua conta do pagseguro estiver usando o email "<?= $data['pagamento']->pagamento_usuario ?>" e você se cadastrar no site com o mesmo email, <br>
                                        telefone ou qualquer outro dado do dono da conta pagSeguro a compra será automaticamente cancelada pelo PagSeguro!
                                    </h4>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pagamento_usuario">Email <span class="text-danger">*</span></label>
                                        <input type="text" name="pagamento_usuario" id="pagamento_usuario" class="form-control" placeholder="Conta de e-mail cadastrada no PagSeguro" value="<?= $data['pagamento']->pagamento_usuario ?>" required>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pagamento_senha">API KEY <span class="text-danger">*</span></label>
                                        <input type="text" name="pagamento_senha" id="pagamento_senha" class="form-control" placeholder="Chave API fornecida pelo PagSeguro" value="<?= $data['pagamento']->pagamento_senha ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="pagamento_retorno">URL Notificação Pagseguro </label>
                                        <input disabled type="text" name="pagamento_retorno" id="pagamento_retorno" class="form-control" value="<?= Http::base() ?>/notificacao/pagseguro/" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pagamento_retorno">Status do Módulo </label>
                                        <select class="form-control" name="pagamento_status" id="pagamento_status">
                                            <option value="1">Habilitado</option>
                                            <option value="0">Desabilitado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pagamento_retorno">Modo de testes/produção</label>
                                        <select class="form-control" name="pagamento_gw" id="pagamento_gw">
                                            <option value="SANDBOX">Testes</option>
                                            <option value="PRODUCAO">Produção</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <p class="text-center">
                                <button class="btn btn-primary btn-lg" type="submit"><i class="fa fa-check-circle-o"></i> Gravar Dados</button>
                            </p>

                        </form>
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
    <script type="text/javascript" src="js/jquery.select2/dist/js/select2.js"></script>
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo $baseUri; ?>/assets/vendor/uf-combo/cidades-estados-1.4-utf8.js" charset="utf-8"></script>
    <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery.mask.js"></script>
    <script type="text/javascript" src="js/bootstrap.summernote/dist/summernote.min.js"></script>
    <?php require_once 'switch-color.php'; ?>
    <script src="app-js/main.js"></script>
    <script src="app-js/config.js"></script>
    <script type="text/javascript">
        $('#menu-config-pagseguro').addClass('active');
        $('#pagamento_gw').val("<?= $data['pagamento']->pagamento_gw ?>");
        $('#pagamento_status').val("<?= $data['pagamento']->pagamento_status ?>");
        <?php if (isset($_GET['success'])) : ?>
            _alert_success();
        <?php endif; ?>

        
    </script>
    <script src="js/jquery.parsley/dist/parsley.js" type="text/javascript"></script>
    <script src="js/jquery.parsley/dist/pt-br.js" type="text/javascript"></script>
</body>

</html>