<?php @session_start(); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= (isset($data['config']->config_nome)) ? $data['config']->config_nome : ''; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/modal.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/jquery.select2/dist/css/select2.min.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/jquery.select2/dist/css/select2-bootstrap.min.css" />
    <link rel="icon" type="image/png" href="<?php echo $baseUri; ?>/assets/logo/<?= $_SESSION['base_delivery'] ?>/<?php echo (isset($data['config'])) ? $data['config']->config_foto : ''; ?>" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/view/site/app-css/card.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/tema.php?<?php echo $data['config']->config_colors; ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/app.css" />
    <link href="<?php echo $baseUri; ?>/assets/css/main.css?v=<?= filemtime(__DIR__ . '/../../assets/css/main.css') ?>" rel="stylesheet" />
</head>
<body>
    <div class="container" id="home-content">
        <?php require_once 'menu.php'; ?>
        <div class="<?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
            <input type="hidden" name="cliente_id" id="cliente_id" value="<?php $data['cliente']->cliente_id ?>">
            <h5 class="text-uppercase alert  text-center text-bold">
                <br>
                <i class="fa fa-th-list"></i> &nbsp;
                acompanhe seus pedidos
            </h5>
            <?php if (isset($data['pedido'][0])) : ?>
                <select class="form-control btn-status-sel text-uppercase">
                    <option value="0" data-status="0">Filtrar por status do pedido...</option>
                    <option value="0" data-status="0">todos</option>
                    <option value="1" data-status="1">pendentes</option>
                    <option value="2" data-status="2">em produção</option>
                    <option value="3" data-status="3">saiu para entrega</option>
                    <option value="4" data-status="4">entregues</option>
                    <option value="5" data-status="5">cancelados</option>
                </select>
                <hr>
                <?php foreach ($data['pedido'] as $p) : ?>
                    <?php $status = Status::check($p->pedido_status); ?>
                    <div class="status-<?= $p->pedido_status; ?> status-all" data-status="<?= $p->pedido_status; ?>" data-id="<?= $p->pedido_id; ?>" id="tr-<?= $p->pedido_id; ?>">
                        <p>
                            <button class="btn btn-block btn-lg btn-<?= $status->color ?>" data-link="<?php echo $baseUri; ?>/detalhes-do-pedido/<?= $p->pedido_id; ?>/">
                                <small class="pull-left text-uppercase text-left">
                                    <i class="fa fa-shopping-bag"></i> <b>Pedido #<?= $p->pedido_id; ?></b>
                                    <br><small><?= $status->icon ?></small>
                                </small>
                                <small class="pull-right">
                                    <i class="fa fa-clock-o"></i>
                                    <?= date('d/m/Y H:i', strtotime($p->pedido_data)); ?>
                                    <br><span class="pull-right text-bold">R$ <?= Currency::moeda($p->pedido_total) ?></span>
                                </small>
                            </button>
                        </p>
                        <hr />
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <h5 class="text-center alert alert-warning">Você ainda não possui nenhum pedido!</h5>
                <p>
                    <br>
                    <a class="btn btn-success btn-block" href="<?php echo $baseUri; ?>/">
                        <i class="fa fa-shopping-cart"></i>
                        Faça seu primeiro pedido agora
                    </a>
                </p>
            <?php endif; ?>
        </div>
    </div>
    <?php 
    require_once 'footer.php'; 
    require 'side-carrinho.php'; 
    ?>
    <script type="text/javascript">
        var currentUri = 'index';
    </script>
    <?php require_once 'footer-core-js.php'; ?>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/pedido.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/number.js"></script>
    <script src="<?php echo $baseUri; ?>/view/site/app-js/howler.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/carrinho.js"></script>
    <script type="text/javascript">
        

        rebind_reload();
    </script>
</body>
</html>