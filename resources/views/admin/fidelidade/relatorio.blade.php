<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once __DIR__ . '/../site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
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
            <?php require_once __DIR__ . '/../side-menu.php'; ?>
        </div>
        <div class="container-fluid" id="pcont">
            <!-- TOP NAVBAR -->
            <?php require_once __DIR__ . '/../top-menu.php'; ?>
            <div class="cl-mcont">
                <div class="block-flat">
                    <div class="header">
                        <h3><i class="fa fa-bar-chart"></i> Relatório do Programa de Fidelidade
                            <span class="pull-right">
                                <a href="<?php echo $baseUri; ?>/fidelidade/" class="btn btn-primary">
                                    <i class="fa fa-chevron-circle-left"></i> Voltar
                                </a>
                            </span>
                        </h3>
                    </div>
                    <div class="content">
                        <?php 
                        $tipo_programa = $data['config']->config_fidelidade_tipo ?? 'pontos';
                        $percentual_desconto = $data['config']->config_fidelidade_frequencia_percentual ?? 10;
                        $meta_pedidos = $data['meta_pedidos'] ?? 3;
                        ?>
                        
                        <?php if ($tipo_programa === 'frequencia'): ?>
                            <!-- PROGRAMA DE FREQUÊNCIA -->
                            <!-- Estatísticas -->
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="panel panel-info">
                                        <div class="panel-body text-center">
                                            <h3><i class="fa fa-users"></i></h3>
                                            <h4><?= $data['estatisticas']->total_clientes_participantes ?? 0 ?></h4>
                                            <p>Clientes Participantes</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="panel panel-success">
                                        <div class="panel-body text-center">
                                            <h3><i class="fa fa-check-circle"></i></h3>
                                            <h4><?= count($data['clientes_elegiveis'] ?? []) ?></h4>
                                            <p>Clientes Elegíveis Agora</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="panel panel-warning">
                                        <div class="panel-body text-center">
                                            <h3><i class="fa fa-gift"></i></h3>
                                            <h4><?= $data['estatisticas']->total_descontos_utilizados ?? 0 ?></h4>
                                            <p>Descontos Utilizados</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="panel panel-danger">
                                        <div class="panel-body text-center">
                                            <h3><i class="fa fa-money"></i></h3>
                                            <h4>R$ <?= number_format($data['estatisticas']->total_economia_gerada ?? 0, 2, ',', '.') ?></h4>
                                            <p>Economia Total Gerada</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabela de Clientes Elegíveis -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-check"></i> Clientes Elegíveis (Próximo Pedido Ganha <?= $percentual_desconto ?>% OFF)</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Cliente</th>
                                                            <th>Telefone</th>
                                                            <th class="text-center">Pedidos Entregues</th>
                                                            <th class="text-center">Descontos Já Usados</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($data['clientes_elegiveis'])): ?>
                                                            <?php foreach ($data['clientes_elegiveis'] as $cliente): ?>
                                                                <tr>
                                                                    <td><?= htmlspecialchars($cliente->cliente_nome ?? 'N/A') ?></td>
                                                                    <td><?= htmlspecialchars($cliente->cliente_fone ?? 'N/A') ?></td>
                                                                    <td class="text-center"><strong class="text-success"><?= $cliente->total_pedidos ?? 0 ?></strong></td>
                                                                    <td class="text-center"><?= $cliente->descontos_usados ?? 0 ?></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="4" class="text-center">Nenhum cliente elegível no momento</td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Tabela de Clientes em Progresso -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-users"></i> Clientes em Progresso</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Cliente</th>
                                                            <th>Telefone</th>
                                                            <th class="text-center">Progresso</th>
                                                            <th class="text-center">Pedidos Totais</th>
                                                            <th class="text-center">Faltam</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($data['clientes_progresso'])): ?>
                                                            <?php foreach ($data['clientes_progresso'] as $cliente): ?>
                                                                <?php 
                                                                $progresso = $cliente->progresso_atual;
                                                                $faltam = $meta_pedidos - $progresso;
                                                                ?>
                                                                <tr>
                                                                    <td><?= htmlspecialchars($cliente->cliente_nome ?? 'N/A') ?></td>
                                                                    <td><?= htmlspecialchars($cliente->cliente_fone ?? 'N/A') ?></td>
                                                                    <td class="text-center">
                                                                        <strong><?= $progresso ?>/<?= $meta_pedidos ?></strong>
                                                                        <div class="progress" style="margin: 5px 0;">
                                                                            <div class="progress-bar progress-bar-info" role="progressbar" 
                                                                                 aria-valuenow="<?= $progresso ?>" aria-valuemin="0" aria-valuemax="<?= $meta_pedidos ?>" 
                                                                                 style="width: <?= ($progresso / $meta_pedidos) * 100 ?>%">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center"><?= $cliente->total_pedidos ?? 0 ?></td>
                                                                    <td class="text-center"><span class="label label-warning"><?= $faltam ?> pedido<?= $faltam > 1 ? 's' : '' ?></span></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="5" class="text-center">Nenhum cliente em progresso</td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        <?php else: ?>
                            <!-- PROGRAMA DE PONTOS (ORIGINAL) -->
                        <!-- Estatísticas -->
                        <div class="row">
                            <div class="col-md-3">
                                <div class="panel panel-info">
                                    <div class="panel-body text-center">
                                        <h3><i class="fa fa-users"></i></h3>
                                        <h4><?= $data['estatisticas']->total_clientes_com_pontos ?? 0 ?></h4>
                                        <p>Clientes Ativos</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="panel panel-success">
                                    <div class="panel-body text-center">
                                        <h3><i class="fa fa-gift"></i></h3>
                                        <h4><?= $data['estatisticas']->total_pontos_ativos ?? 0 ?></h4>
                                        <p>Total de Pontos</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="panel panel-warning">
                                    <div class="panel-body text-center">
                                        <h3><i class="fa fa-exchange"></i></h3>
                                        <h4><?= $data['total_pontos_resgatados'] ?? 0 ?></h4>
                                        <p>Total Resgatado</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="panel panel-danger">
                                    <div class="panel-body text-center">
                                        <h3><i class="fa fa-refresh"></i></h3>
                                        <h4><?= $data['estatisticas']->total_movimentacoes ?? 0 ?></h4>
                                        <p>Movimentações</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tabela de Clientes -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fa fa-users"></i> Clientes com Pontos</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Cliente</th>
                                                        <th>Telefone</th>
                                                        <th class="text-center">Pontos Acumulados</th>
                                                        <th class="text-center">Nível</th>
                                                        <th>Último Acesso</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($data['clientes_ativos'])): ?>
                                                        <?php foreach ($data['clientes_ativos'] as $cliente): ?>
                                                            <tr>
                                                                <td><?= htmlspecialchars($cliente->cliente_nome ?? 'N/A') ?></td>
                                                                <td><?= htmlspecialchars($cliente->cliente_fone ?? 'N/A') ?></td>
                                                                <td class="text-center"><strong><?= $cliente->pontos_acumulados ?? 0 ?></strong></td>
                                                                <td class="text-center">
                                                                    <span class="label 
                                                                        <?php 
                                                                        switch(strtolower($cliente->nivel ?? 'bronze')) {
                                                                            case 'diamante': echo 'label-warning'; break;
                                                                            case 'ouro': echo 'label-primary'; break;
                                                                            case 'prata': echo 'label-default'; break;
                                                                            default: echo 'label-info'; break;
                                                                        }
                                                                        ?>">
                                                                        <?= ucfirst($cliente->nivel ?? 'Bronze') ?>
                                                                    </span>
                                                                </td>
                                                                <td><?= date('d/m/Y H:i', strtotime($cliente->data_ultimo_acesso ?? date('Y-m-d H:i:s'))) ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="5" class="text-center">Nenhum cliente com pontos acumulados</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Configurações Atuais -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fa fa-cog"></i> Configurações Atuais</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Status do Programa:</strong> 
                                                    <span class="label label-<?php echo (isset($data['config']) && $data['config']->config_fidelidade_ativo == 1) ? 'success' : 'danger'; ?>">
                                                        <?php echo (isset($data['config']) && $data['config']->config_fidelidade_ativo == 1) ? 'ATIVO' : 'INATIVO'; ?>
                                                    </span>
                                                </p>
                                                <p><strong>Tipo de Programa:</strong> 
                                                    <?php 
                                                    if (isset($data['config'])) {
                                                        switch($data['config']->config_fidelidade_tipo ?? 'pontos') {
                                                            case 'pontos': echo 'Apenas Pontos'; break;
                                                            case 'cashback': echo 'Apenas Cashback'; break;
                                                            case 'ambos': echo 'Pontos e Cashback'; break;
                                                            default: echo 'Desconhecido';
                                                        }
                                                    }
                                                    ?>
                                                </p>
                                                <p><strong>Pontos por Real:</strong> <?= $data['config']->config_pontos_por_real ?? 5 ?> pontos por R$ 1,00</p>
                                                <p><strong>Valor do Resgate:</strong> R$ <?= $data['config']->config_valor_resgate_pontos ?? 5 ?> por 100 pontos</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Pontos para Resgate:</strong> <?= $data['config']->config_pontos_para_resgatar ?? 100 ?> pontos</p>
                                                <p><strong>Percentual Cashback:</strong> <?= $data['config']->config_cashback_percentual ?? 5 ?>%</p>
                                                <p><strong>Valor Mínimo Cashback:</strong> R$ <?= $data['config']->config_cashback_minimo_pedido ?? 30 ?></p>
                                                <p><strong>Validade dos Pontos:</strong> <?= $data['config']->config_fidelidade_validade_dias ?? 90 ?> dias</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?> <!-- Fim do if/else programa de frequencia/pontos -->
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
