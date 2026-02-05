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
            <h5 class="text-uppercase alert text-center text-bold">
                <br>
                <i class="fa fa-star" aria-hidden="true"></i> &nbsp;
                Meus Pontos de Fidelidade
            </h5>
            
            <?php if ($data['saldo_atual'] > 0): ?>
                <!-- CARD DE SALDO -->
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; padding: 30px; margin-bottom: 20px; color: white; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                    <div class="text-center">
                        <h3 style="margin: 0; opacity: 0.9;">Saldo Disponível</h3>
                        <h1 style="font-size: 4em; margin: 10px 0; font-weight: bold;"><?= $data['saldo_atual'] ?></h1>
                        <p style="font-size: 1.2em; opacity: 0.9;">pontos acumulados</p>
                        
                        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.3);">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div style="opacity: 0.9;">
                                        <i class="fa fa-trophy" style="font-size: 2em;"></i>
                                        <p style="margin: 5px 0 0 0;">Nível: <strong><?= $data['nivel'] ?></strong></p>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div style="opacity: 0.9;">
                                        <i class="fa fa-gift" style="font-size: 2em;"></i>
                                        <p style="margin: 5px 0 0 0;">Vale: <strong>R$ <?= number_format(($data['saldo_atual'] / 100) * ($data['config']->config_valor_resgate_pontos ?? 5), 2, ',', '.') ?></strong></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- COMO FUNCIONA -->
                <div class="alert alert-info">
                    <h4><i class="fa fa-info-circle"></i> Como Funciona</h4>
                    <div class="row">
                        <div class="col-xs-4 text-center">
                            <i class="fa fa-shopping-cart fa-2x" style="color: #3498db;"></i>
                            <p style="margin-top: 10px; font-size: 0.9em;"><strong><?= $data['config']->config_pontos_por_real ?? 5 ?> pontos</strong><br>por R$ 1,00</p>
                        </div>
                        <div class="col-xs-4 text-center">
                            <i class="fa fa-money fa-2x" style="color: #2ecc71;"></i>
                            <p style="margin-top: 10px; font-size: 0.9em;"><strong>100 pontos</strong><br>= R$ <?= $data['config']->config_valor_resgate_pontos ?? 5 ?></p>
                        </div>
                        <div class="col-xs-4 text-center">
                            <i class="fa fa-clock-o fa-2x" style="color: #f39c12;"></i>
                            <p style="margin-top: 10px; font-size: 0.9em;"><strong><?= $data['config']->config_fidelidade_validade_dias ?? 90 ?> dias</strong><br>de validade</p>
                        </div>
                    </div>
                </div>
                
                <!-- HISTÓRICO -->
                <?php if (!empty($data['historico'])): ?>
                <h5 class="text-uppercase" style="margin-top: 30px; padding: 10px; background: #f5f5f5; border-left: 4px solid #667eea;">
                    <i class="fa fa-history"></i> Histórico de Movimentações
                </h5>
                
                <?php foreach ($data['historico'] as $mov): ?>
                <div class="CouponArea--couponList--1EZpGGW" style="margin-bottom: 15px;">
                    <div class="ViewMore--moreWrap--eYg-PAk">
                        <div class="ViewMore--moreList--1cH_TBZ">
                            <div class="Coupon--couponContainer--229aImt">
                                <div class="Coupon--couponItem--1EfTMUI Coupon--store--14BPOBb">
                                    <div class="Coupon--couponInfo--3n3iphG">
                                        <div class="Coupon--couponPrice--3zHQyxw">
                                            <?php if ($mov->pontos > 0): ?>
                                                <span style="color:rgb(155, 240, 190); font-size: 1.3em;">+<?= $mov->pontos ?> pontos</span>
                                            <?php else: ?>
                                                <span style="color: #e74c3c; font-size: 1.3em;"><?= $mov->pontos ?> pontos</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="Coupon--orderTips--1c1Olye">
                                            <div class="Coupon--orderTipsContent--3o4o1NQ"><?= htmlspecialchars($mov->descricao) ?></div>
                                        </div>
                                        <div class="Coupon--couponDate--29fr6OO">
                                            <?= date('d/m/Y H:i', strtotime($mov->data_criacao)) ?>
                                            <?php if ($mov->data_expiracao && strtotime($mov->data_expiracao) > time()): ?>
                                                <br>Válido até <?= date('d/m/Y', strtotime($mov->data_expiracao)) ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="Coupon--couponAction--2rRma7h">
                                        <div class="Coupon--btn--25KGav6">
                                            <span class="Coupon--btnContent--2Zy5U_C">
                                                <?php if ($mov->tipo == 'ganho'): ?>
                                                    <span style="color: #2ecc71;">✓ Creditado</span>
                                                <?php elseif ($mov->tipo == 'resgate'): ?>
                                                    <span style="color: #e74c3c;">Resgatado</span>
                                                <?php else: ?>
                                                    <?= ucfirst($mov->tipo) ?>
                                                <?php endif; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
                
            <?php else: ?>
                <h5 class="text-center alert alert-warning">
                    <i class="fa fa-star-o fa-3x" style="display: block; margin-bottom: 15px; opacity: 0.5;"></i>
                    Você ainda não possui pontos!<br>
                    <small>Faça seu primeiro pedido e comece a acumular pontos!</small>
                </h5>
            <?php endif; ?>
        </div>
    </div>
    
    <?php 
    require_once 'footer.php'; 
    require 'side-carrinho.php'; 
    ?>
    
    <script type="text/javascript">
        var currentUri = 'fidelidade';
    </script>
    
    <?php require_once 'footer-core-js.php'; ?>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/number.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/carrinho.js"></script>
    <script type="text/javascript">
        rebind_reload();
    </script>
</body>

</html>
