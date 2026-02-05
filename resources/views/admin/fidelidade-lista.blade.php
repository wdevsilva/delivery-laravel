<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="block-flat">
                            <div class="header">
                                <h3>
                                    <i class="fa fa-gift"></i> Programa de Fidelidade
                                </h3>
                            </div>
                            <div class="content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="fa fa-cog"></i> Configurações</h3>
                                            </div>
                                            <div class="panel-body">
                                                <p>Configure o programa de fidelidade: ative/desative, defina tipo (pontos, cashback ou ambos), regras de acúmulo e resgate.</p>
                                                <a href="<?php echo $baseUri; ?>/fidelidade/configuracoes/" class="btn btn-primary btn-block">
                                                    <i class="fa fa-cog"></i> Acessar Configurações
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="fa fa-bar-chart"></i> Relatórios</h3>
                                            </div>
                                            <div class="panel-body">
                                                <p>Visualize estatísticas do programa: clientes ativos, pontos distribuídos, pontos resgatados e muito mais.</p>
                                                <a href="<?php echo $baseUri; ?>/fidelidade/relatorio/" class="btn btn-info btn-block">
                                                    <i class="fa fa-bar-chart"></i> Ver Relatórios
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="panel panel-success">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="fa fa-gift"></i> Histórico de Descontos</h3>
                                            </div>
                                            <div class="panel-body">
                                                <p>Veja todos os descontos de fidelidade concedidos aos clientes, valor total economizado e ROI do programa.</p>
                                                <a href="<?php echo $baseUri; ?>/fidelidade/historico-descontos/" class="btn btn-success btn-block">
                                                    <i class="fa fa-history"></i> Ver Histórico
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><i class="fa fa-info-circle"></i> Status Atual</h3>
                                            </div>
                                            <div class="panel-body">
                                                <?php if (isset($data['config'])): ?>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <p><strong>Status do Programa:</strong></p>
                                                            <?php if ($data['config']->config_fidelidade_ativo == 1): ?>
                                                                <span class="label label-success" style="font-size: 14px;"><i class="fa fa-check"></i> ATIVO</span>
                                                            <?php else: ?>
                                                                <span class="label label-danger" style="font-size: 14px;"><i class="fa fa-ban"></i> INATIVO</span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p><strong>Tipo de Programa:</strong></p>
                                                            <p>
                                                                <?php 
                                                                switch($data['config']->config_fidelidade_tipo ?? 'pontos') {
                                                                    case 'pontos': echo '<i class="fa fa-star"></i> Pontos'; break;
                                                                    case 'cashback': echo '<i class="fa fa-money"></i> Cashback'; break;
                                                                    case 'ambos': echo '<i class="fa fa-star"></i><i class="fa fa-money"></i> Pontos + Cashback'; break;
                                                                    case 'frequencia': echo '<i class="fa fa-gift"></i> Frequência (A cada X pedidos, ganhe Y% OFF)'; break;
                                                                    default: echo 'Não configurado';
                                                                }
                                                                ?>
                                                            </p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p><strong>Validade dos Pontos:</strong></p>
                                                            <p><?= $data['config']->config_fidelidade_validade_dias ?? 90 ?> dias</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <?php if (($data['config']->config_fidelidade_tipo ?? '') === 'frequencia'): ?>
                                                    <div class="row" style="margin-top: 15px;">
                                                        <div class="col-md-12">
                                                            <div class="alert alert-info">
                                                                <h4><i class="fa fa-gift"></i> Detalhes do Programa de Frequência</h4>
                                                                <p style="margin: 10px 0;">
                                                                    <?php 
                                                                        $pedidos = $data['config']->config_fidelidade_frequencia_pedidos ?? 3;
                                                                        $percentual = $data['config']->config_fidelidade_frequencia_percentual ?? 10;
                                                                        // Remover decimais se for número inteiro
                                                                        $percentual_formatado = (floor($percentual) == $percentual) ? (int)$percentual : number_format($percentual, 1);
                                                                    ?>
                                                                    <strong>A cada <?= $pedidos ?> pedidos, o próximo ganha <?= $percentual_formatado ?>% de desconto!</strong>
                                                                </p>
                                                                <p style="margin: 0;">
                                                                    <small><i class="fa fa-info-circle"></i> O desconto é aplicado automaticamente no checkout quando o cliente atingir a meta de pedidos entregues.</small>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/jquery.cooki/jquery.cooki.js"></script>
    <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="js/behaviour/core.js"></script>
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="app-js/main.js"></script>
    <script type="text/javascript">
        var baseUri = '<?php echo $baseUri; ?>';
        $('#menu-fidelidade').addClass('active');
    </script>
</body>

</html>
