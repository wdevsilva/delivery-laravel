<?php @session_start(); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= (isset($data['config']->config_nome)) ? $data['config']->config_nome : ''; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css"/>
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo $baseUri; ?>/assets/vendor/jquery.gritter/css/jquery.gritter.css"/>
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/style.css"/>
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/css/tema.php?<?php echo $data['config']->config_colors; ?>"
          type="text/css"/>
</head>
<body>
<?php require_once 'menu.php'; ?>
<div class="container-fluid" id="home-content">
    <div class="<?= (!$isMobile) ? 'col-md-offset-5 col-md-6' : ''; ?>">
        <br><br><br><br>
        <form action="<?php echo $baseUri; ?>/LoginCliente/muda_senha/<?= (isset($data['carrinho'])) ? '?carrinho' : '' ?>"
              method="post" role="form" autocomplete="off" enctype="multipart/form-data">
            <div class="col-md-6">
                <input type="hidden" name="cliente_id" value="<?= $data['cliente']->cliente_id ?>">
                <div class="form-group">
                    <label for="cliente_email">Nova Senha</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock fa-2x"></i></span>
                        <input type="password" name="cliente_senha" id="cliente_senha" class="form-control input-lg"
                               placeholder="Informe a nova senha" required>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block" data-dismiss="modal" type="submit">
                        <i class="fa fa-lock"></i>
                        ALTERAR SENHA
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
<script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/jquery/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/jquery.ui/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/jquery.gritter/js/jquery.gritter.js"></script>
<script type="text/javascript">
    $(function () {
        $("#cl-wrapper").css({opacity: 1, 'margin-left': 0});
        <?php if (Post::request('incorreto') != '') : ?>
        $.gritter.add({
            title: 'Login/Senha Incorreto',
            text: 'Verifique seus dados de acesso e tente novamente.',
            class_name: 'danger'
        });
        <?php endif; ?>
        <?php if (Post::request('falha') != '') : ?>
        $.gritter.add({
            title: 'Email Não Enviado',
            text: 'Verifique seu email e tente novamente.',
            class_name: 'danger'
        });
        <?php endif; ?>
        <?php if (Post::request('envio') != '') : ?>
        $.gritter.add({
            title: 'Email de Recuperação Enviado',
            text: 'Por favor verifique sua caixa de entrada.',
            class_name: 'success'
        });
        <?php endif; ?>


    });
</script>
</html>