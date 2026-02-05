<?php @session_start(); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= (isset($data['config']->config_nome)) ? $data['config']->config_nome : ''; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUri; ?>/assets/vendor/jquery.gritter/css/jquery.gritter.css" />
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/style.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/tema.php?<?php echo $data['config']->config_colors; ?>" type="text/css" />
</head>
<body style="background: url('<?php echo $baseUri; ?>/assets/img/body-bg.jpg') center center repeat rgb(229, 221, 213);transform: none;overflow: visible;">
    <?php require_once 'menu.php'; ?>
    <div class="container-fluid" id="home-content">
        <div class="<?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>" style="background-color: rgba(255, 255, 255, 0.5);">

            <form action="<?php echo $baseUri; ?>/LoginCliente/recuperar<?= (isset($data['carrinho'])) ? '?carrinho' : '' ?>" style="padding-top: 50px" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="cliente_email">E-mail</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="email" name="cliente_email" id="cliente_email" class="form-control" placeholder="Informe o email de cadastro" required>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block text-uppercase" data-dismiss="modal" type="submit">
                        <i class="fa fa-envelope-o"></i>
                        Enviar
                    </button>
                </div>
                <small class="text-muted">Você precisa ter cadastrado seu email em sua conta!</small>
                <br><br>
            </form>
        </div>
    </div>
</body>
<script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/jquery/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/jquery.ui/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/jquery.gritter/js/jquery.gritter.js"></script>
<script type="text/javascript">
    

    $(function() {
        $("#cl-wrapper").css({
            opacity: 1,
            'margin-left': 0
        });
        <?php if (Post::request('incorreto') != '') : ?>
            $.gritter.add({
                title: 'Email Inválido',
                text: 'Verifique seu email e tente novamente.',
                class_name: 'danger'
            });
        <?php endif; ?>
    });
</script>

</html>