<?php @session_start(); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= (isset($data['config']->config_nome)) ? $data['config']->config_nome : ''; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css"/>
        <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
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
            <div class="col-md-9 col-xs-12">
                <div class="panel panel-danger" id="painel-carrinho">
                    <div class="panel-heading well well-lg">
                        <h3>
                            <i class="fa fa-shopping-cart fa-2x text-write"></i> 
                            Itens de compra do seu carrinho<br/><br/><br/><br/>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="item">
                            <?php foreach ($data['item'][0] as $item): ?>
                                <div class="col-md-4 col-xs-12">
                                    <img src="<?php echo $baseUri; ?>/midias/assets/thumb.php?zcx=3&w=218&h=178&src=item/<?= $item->item_foto ?>" alt="..."  class="img-responsive">
                                </div>
                                <div class="col-md-8 col-xs-12">
                                    <span class="item-span">
                                        <i class="fa fa-minus-circle btn-plus-minus text-danger" data-toggle="tooltip" title="-1"></i> 01 
                                        <i class="fa fa-plus-circle  btn-plus-minus text-success" data-toggle="tooltip" title="+1"></i> &nbsp;
                                        <span data-toggle="tooltip" title="<?= $item->item_nome ?> - 04 Unidades"><?= $item->item_nome ?>... <span class="pull-right mar-right-3"><?= $item->opcao_preco ?></span></span>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php require_once 'carrinho.php'; ?>
        </div>
    </body>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/jquery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/assets/js/main.js"></script>
</html>