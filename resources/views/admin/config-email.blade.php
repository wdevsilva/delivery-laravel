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
    <link href="css/style-prusia.css" rel="stylesheet" />
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
                <h3 class="text-center">Configurações SMTP</h3>
                <div class="block-flat">
                    <div class="header">
                        <h3>Configurações de envio de Email</h3>
                    </div>
                    <div class="content">
                        <form action="<?php echo $baseUri; ?>/configuracao-email-atualizar/gravar/" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
                            <input type="hidden" name="smtp_id" id="smtp_id" value="<?= $data['smtp']->smtp_id ?>">
                            <div class="">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="smtp_host">Host SMTP <span class="text-danger">*</span></label>
                                            <input type="text" name="smtp_host" id="smtp_host" class="form-control" placeholder="Informe o endereço SMTP ex: mail.site.com.br" value="<?= $data['smtp']->smtp_host ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="smtp_port">Porta SMTP <span class="text-danger">*</span></label>
                                            <input type="text" name="smtp_port" id="smtp_port" class="form-control" placeholder="Informe a porta SMTP ex: 587" value="<?= $data['smtp']->smtp_port ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="smtp_nome">Nome de Exibição </label>
                                            <input type="text" name="smtp_nome" id="smtp_nome" class="form-control" placeholder="Informe o nome de exibição ex: Abidu Esfihas" value="<?= $data['smtp']->smtp_nome ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="smtp_email">Email (smtp)<span class="text-danger">*</span></label>
                                            <input type="email" name="smtp_email" id="smtp_email" class="form-control" placeholder="Informe a conta SMTP contato@site.com.br" value="<?= $data['smtp']->smtp_email ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="smtp_pass">Senha (smtp)<span class="text-danger">*</span> </label>
                                            <input type="password" name="smtp_pass" id="smtp_pass" class="form-control" placeholder="Informe a senha SMTP" value="<?= $data['smtp']->smtp_pass ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="smtp_bcc">Cópia oculta: </label>
                                            <input type="email" name="smtp_bcc" id="smtp_bcc" class="form-control" placeholder="Informe um email alternativo ex: outro@gmail.com" value="<?= $data['smtp']->smtp_bcc ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <p class="text-center">
                                        <button class="btn btn-primary btn-lg" type="submit"><i class="fa fa-check-circle-o"></i> Gravar Dados</button>
                                    </p>
                                </div>
                            </div>
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
    <script type="text/javascript" src="js/bootstrap.summernote/dist/summernote.min.js"></script>

    <script src="app-js/main.js"></script>
    <script src="app-js/config.js"></script>
    <script src="js/jquery.parsley/dist/parsley.js" type="text/javascript"></script>
    <script src="js/jquery.parsley/dist/pt-br.js" type="text/javascript"></script>
    <script type="text/javascript">
        $('#menu-config-email').addClass('active');
        <?php if (isset($_GET['success'])) : ?>
            _alert_success();
        <?php endif; ?>

        
    </script>
</body>

</html>