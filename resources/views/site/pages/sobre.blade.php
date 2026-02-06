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
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/style.css"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/tema.php?<?php echo $data['config']->config_colors; ?>" type="text/css"/>
</head>
<body>
<?php require_once 'menu.php'; ?>
<div class="container-fluid" id="home-content">
    <div class="row">
        <div class="col-md-9 col-xs-12">
            <br/>
            <?php echo $data['config']->config_desc; ?>
            <br/>
        </div>
        <div class="col-md-3 col-xs-12">
            <div id="side-carrinho">
                <?php require_once 'side-carrinho.php'; ?>
            </div>
        </div>
    </div>
</div>
<?php require_once 'footer-core-js.php'; ?>
<script type="text/javascript" src="{{ asset('assets/js/carrinho.js"></script>
</body>
</html>