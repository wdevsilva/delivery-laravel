<?php
@session_start();
$baseUri = Http::base();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= (isset($data['config']->config_nome)) ? $data['config']->config_nome : ''; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUri; ?>/assets/vendor/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/modal.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/jquery.select2/dist/css/select2.min.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/jquery.select2/dist/css/select2-bootstrap.min.css" />
    <link rel="icon" type="image/png" href="<?php echo $baseUri; ?>/assets/logo/<?= $_SESSION['base_delivery'] ?>/<?php echo $data['config']->config_foto; ?>" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/tema.php?<?php echo $data['config']->config_colors; ?>" type="text/css" />
    <link href="<?php echo $baseUri; ?>/assets/css/main.css?v=<?= filemtime(__DIR__ . '/../../assets/css/main.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/app.css" />
</head>

<body>
    <div class="container" id="home-content">
        <?php
        require_once 'menu.php';
        ?>
        <form action="<?php echo $baseUri; ?>/cliente-login-entrar/<?= (isset($data['carrinho'])) ? '?carrinho' : '' ?>" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
            <div class="<?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>" style="background-color: rgba(255, 255, 255, 0.5);">
                <div class="form-group">
                    <hr>
                    <label for="cliente_email">Digite o número do seu celular</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-whatsapp"></i></span>
                        <input type="tel" name="cliente_fone2" id="cliente_fone2" class="form-control" data-mask="cell" placeholder="(99) 99999-9999" required>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block" data-dismiss="modal" type="submit">
                        <i class="fa fa-check-circle-o"></i>
                        CONTINUAR
                    </button>
                </div>
                <hr>
            </div>
        </form>
    </div>
    <?php
    require_once 'footer.php';
    require 'side-carrinho.php';
    require_once 'footer-core-js.php';
    ?>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/slick/slick.min.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/number.js"></script>
    <script src="<?php echo $baseUri; ?>/view/site/app-js/howler.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/carrinho.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/jquery.gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/jquery.maskedinput/jquery.maskedinput.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/cliente.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/carrinho.js"></script>
    <script type="text/javascript">
        

        $(function() {
            <?php if (Post::request('incorreto') != '') : ?>
                $.gritter.add({
                    time: 2000,
                    position: 'center',
                    title: 'Login/Senha Incorreto',
                    text: 'Confira seus telefone e senha.',
                    class_name: 'danger'
                });
            <?php endif; ?>
            <?php if (Post::request('falha') != '') : ?>
                $.gritter.add({
                    title: 'Email não enviado',
                    text: 'Verifique seu email e tente novamente.',
                    class_name: 'danger'
                });
            <?php endif; ?>
            <?php if (Post::request('envio') != '') : ?>
                $.gritter.add({
                    title: 'Email de recuperação enviado',
                    text: 'Por favor verifique sua caixa de entrada.',
                    class_name: 'success'
                });
            <?php endif; ?>
            <?php if (Post::request('muda-senha') != '') : ?>
                $.gritter.add({
                    title: 'A Senha foi alterada com sucesso',
                    text: 'Por favor, entre com seus novos dados.',
                    class_name: 'success'
                });
            <?php endif; ?>
        });
        rebind_reload();
    </script>

</html>