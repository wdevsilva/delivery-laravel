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
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/cupom.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/tema.php?<?php echo $data['config']->config_colors; ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/app.css" />
    <link href="<?php echo $baseUri; ?>/assets/css/main.css?v=<?= filemtime(__DIR__ . '/../../assets/css/main.css') ?>" rel="stylesheet" />
</head>

<body>
    <div class="container" id="home-content">
        <?php require_once 'menu.php'; ?>
        <div class="<?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
            <h5 class="text-uppercase alert  text-center text-bold">
                <br>
                <i class="fa fa-tags" aria-hidden="true"></i> &nbsp;
                Cupons de desconto
            </h5>
            <?php

            if (count($data['cupons']) > 0) {
                foreach ($data['cupons'] as $r) {
                    if ($r->cupom_tipo == 1) {
                        $desconto = 'R$' .  Currency::moeda($r->cupom_valor);
                    } else {
                        $desconto = $r->cupom_percent . '%';
                    }
                ?>
                    <button class="btn btn-block btn-lg btn-<?= $status->color ?>" data-link="<?php echo $baseUri; ?>/detalhes-do-pedido/<?= $r->pedido_id; ?>/" style="background-color: #fff;">
                        <div class="CouponArea--couponList--1EZpGGW">
                            <div class="ViewMore--moreWrap--eYg-PAk">
                                <div class="ViewMore--moreList--1cH_TBZ">
                                    <div class="Coupon--couponContainer--229aImt">
                                        <div class="Coupon--couponItem--1EfTMUI Coupon--store--14BPOBb">
                                            <div class="Coupon--couponInfo--3n3iphG">
                                                <div class="Coupon--couponPrice--3zHQyxw"><?= $r->cupom_nome ?> - <?= $desconto ?></div>
                                                <div class="Coupon--orderTips--1c1Olye">
                                                    <div class="Coupon--orderTipsContent--3o4o1NQ">Vlr. Pedido R$ <?= $r->pedido_total ?></div>
                                                </div>
                                                <div class="Coupon--couponDate--29fr6OO">
                                                    Utilização <?= date('d/m/Y H:i', strtotime($r->pedido_data)) ?><br>
                                                    Vencimento <?= date('d/m/Y', strtotime($r->cupom_validade)) ?>
                                                </div>
                                                <div class="Coupon--couponRules--3TsRIfc"></div>
                                            </div>
                                            <div class="Coupon--couponAction--2rRma7h">
                                                <div class="Coupon--btn--25KGav6"><span class="Coupon--btnContent--2Zy5U_C">Utilizado</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </button>
                <?php } ?>
            <?php } else { ?>
                <h5 class="text-center alert alert-warning">Você ainda não possui nenhum cupom!</h5>
            <?php } ?>
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