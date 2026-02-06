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
<div class="container">
    <?php if (($data['config']->config_fidelidade_tipo ?? 'pontos') === 'frequencia'): ?>
    <!-- ========== PROGRAMA DE FREQUÊNCIA ========== -->
    <div class="row">
        <div class="col-md-12">
            <h2>🎉 Programa de Fidelidade</h2>
            <p class="lead">A cada <?= $data['config']->config_fidelidade_frequencia_pedidos ?? 3 ?> pedidos entregues, você ganha <?= (floor($data['config']->config_fidelidade_frequencia_percentual ?? 10) == ($data['config']->config_fidelidade_frequencia_percentual ?? 10)) ? (int)($data['config']->config_fidelidade_frequencia_percentual ?? 10) : number_format($data['config']->config_fidelidade_frequencia_percentual ?? 10, 1) ?>% de desconto no próximo!</p>
            <hr>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">🎯 Seu Progresso</h3>
                </div>
                <div class="panel-body" style="padding: 40px;">
                    <?php 
                        // Buscar status de frequência do cliente
                        $fidelidadeModel = new fidelidadeModel();
                        $status = $fidelidadeModel->verificar_desconto_frequencia($_SESSION['__CLIENTE__ID__']);
                    ?>
                    
                    <?php if ($status['tem_desconto']): ?>
                    <!-- TEM DESCONTO! -->
                    <div class="text-center" style="padding: 30px 0;">
                        <div style="font-size: 80px; color: #11998e; animation: pulse 2s infinite;">🎁</div>
                        <h2 style="color: #11998e; font-weight: bold; margin: 20px 0;">🎉 PARABÉNS!</h2>
                        <h3 style="color: #333;">Você completou o ciclo de pedidos!</h3>
                        <h3 style="color: #11998e; margin-top: 20px;">O próximo pedido ganha <strong><?= (floor($data['config']->config_fidelidade_frequencia_percentual ?? 10) == ($data['config']->config_fidelidade_frequencia_percentual ?? 10)) ? (int)($data['config']->config_fidelidade_frequencia_percentual ?? 10) : number_format($data['config']->config_fidelidade_frequencia_percentual ?? 10, 1) ?>% de desconto</strong>!</h3>
                        <p style="font-size: 16px; color: #666; margin: 20px 0;">O desconto será aplicado automaticamente no checkout.</p>
                        <a href="<?php echo $baseUri; ?>/" class="btn btn-lg" style="background: #11998e; color: white; margin-top: 20px; padding: 15px 40px; font-size: 18px;">
                            🛍️ Fazer Pedido Agora
                        </a>
                    </div>
                    <?php else: ?>
                    <!-- MOSTRA PROGRESSO -->
                    <div class="text-center">
                        <h3 style="color: #666; margin-bottom: 30px;"><?= $status['mensagem'] ?></h3>
                        <div style="position: relative; width: 300px; height: 300px; margin: 0 auto;">
                            <svg width="300" height="300" style="transform: rotate(-90deg);">
                                <!-- Círculo de fundo -->
                                <circle cx="150" cy="150" r="130" fill="none" stroke="#e0e0e0" stroke-width="25"/>
                                <!-- Círculo de progresso -->
                                <?php 
                                    $progresso_atual = $status['progresso'];
                                    $progresso_total = $status['progresso_total'];
                                    $percentual_progresso = ($progresso_atual / $progresso_total) * 100;
                                    $circumference = 2 * 3.14159 * 130;
                                    $offset = $circumference - ($percentual_progresso / 100) * $circumference;
                                ?>
                                <circle cx="150" cy="150" r="130" fill="none" 
                                        stroke="#11998e" stroke-width="25" 
                                        stroke-dasharray="<?= $circumference ?>" 
                                        stroke-dashoffset="<?= $offset ?>" 
                                        stroke-linecap="round"/>
                            </svg>
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                                <div style="font-size: 70px; font-weight: bold; color: #11998e;"><?= $progresso_atual ?></div>
                                <div style="font-size: 30px; color: #999;">/ <?= $progresso_total ?></div>
                                <div style="font-size: 18px; color: #666; margin-top: 10px;">pedidos</div>
                            </div>
                        </div>
                        <div style="margin-top: 40px;">
                            <?php if ($progresso_atual >= 1): ?>
                            <p style="font-size: 20px; color: #333;">Você já fez <strong style="color: #11998e;"><?= $progresso_atual ?> pedido<?= $progresso_atual > 1 ? 's' : '' ?></strong> entregue<?= $progresso_atual > 1 ? 's' : '' ?>!</p>
                            <?php endif; ?>
                            <p style="font-size: 18px; color: #666;">Faltam <strong style="color: #ff9800;"><?= $status['pedidos_ate_desconto'] ?> pedidos</strong> para ganhar o desconto!</p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Histórico de Descontos -->
    <div class="row">
        <div class="col-md-12">
            <h3>📜 Histórico de Descontos de Frequência</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Descrição</th>
                            <th>Pedido</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $historico_freq = $fidelidadeModel->get_historico_frequencia($_SESSION['__CLIENTE__ID__']);
                        if ($historico_freq && count($historico_freq) > 0): 
                        ?>
                        <?php foreach ($historico_freq as $mov): ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($mov->data_criacao)) ?></td>
                            <td>
                                <span class="label label-success" style="margin-right: 5px;">
                                    <i class="fa fa-check-circle"></i> Usado
                                </span>
                                <?= $mov->descricao ?>
                            </td>
                            <td>
                                <a href="<?php echo $baseUri; ?>/detalhes-do-pedido/<?= $mov->pedido_id ?>" class="btn btn-xs btn-info">
                                    <i class="fa fa-eye"></i> Ver Pedido #<?= $mov->pedido_id ?>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center" style="padding: 30px; color: #999;">
                                <i class="fa fa-info-circle" style="font-size: 2em; margin-bottom: 10px;"></i><br>
                                <strong>Nenhum desconto de frequência utilizado ainda</strong><br>
                                <small>Continue fazendo pedidos para ganhar descontos!</small>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <style>
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    </style>
    
    <?php else: ?>
    <!-- ========== PROGRAMA DE PONTOS/CASHBACK ========== -->
    <div class="row">
        <div class="col-md-12">
            <h2>🎁 Meus Pontos</h2>
            <hr>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">Pontos Acumulados</h3>
                </div>
                <div class="panel-body text-center">
                    <h1 style="color: #4CAF50; font-size: 2.5em;"><?= $data['saldo']->pontos_acumulados ?></h1>
                    <p>Pontos</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">Cashback Disponível</h3>
                </div>
                <div class="panel-body text-center">
                    <h1 style="color: #2196F3; font-size: 2.5em;">R$ <?= number_format($data['saldo']->cashback_disponivel, 2, ',', '.') ?></h1>
                    <p>Cashback</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h3 class="panel-title">Nível</h3>
                </div>
                <div class="panel-body text-center">
                    <h1 style="color: #FF9800; font-size: 2.5em; text-transform: uppercase;"><?= $data['saldo']->nivel ?></h1>
                    <p>
                        <?php if ($data['saldo']->nivel == 'bronze'): ?>
                            0 - R$ 499
                        <?php elseif ($data['saldo']->nivel == 'prata'): ?>
                            R$ 500 - R$ 1.499
                        <?php elseif ($data['saldo']->nivel == 'ouro'): ?>
                            R$ 1.500 - R$ 2.999
                        <?php else: ?>
                            R$ 3.000+
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Como Funciona</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <h4>🎁 Ganhe Pontos</h4>
                            <p><strong><?= $data['config']->config_pontos_por_real ?> pontos</strong> por cada <strong>R$ 1,00</strong> gasto</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <h4>💰 Resgate Desconto</h4>
                            <p><strong>100 pontos</strong> = <strong>R$ <?= $data['config']->config_valor_resgate_pontos ?></strong> de desconto</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <h4>⏰ Validade</h4>
                            <p>Pontos valem <strong><?= $data['config']->config_fidelidade_validade_dias ?> dias</strong> (renovam com cada compra!)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php if ($data['saldo']->pontos_acumulados >= $data['config']->config_pontos_para_resgatar): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <h4>🎉 Você pode resgatar pontos!</h4>
                <p>Você tem <strong><?= $data['saldo']->pontos_acumulados ?> pontos</strong> acumulados, o suficiente para resgatar <strong>R$ <?= number_format(($data['saldo']->pontos_acumulados / 100) * $data['config']->config_valor_resgate_pontos, 2, ',', '.') ?></strong> de desconto!</p>
                <button class="btn btn-success" onclick="resgatarPontos()">Resgatar Pontos</button>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info">
                <h4>📊 Progresso para resgate</h4>
                <p>Você precisa de <strong><?= $data['config']->config_pontos_para_resgatar ?></strong> pontos para resgatar desconto.</p>
                <p>Faltam <strong><?= $data['config']->config_pontos_para_resgatar - $data['saldo']->pontos_acumulados ?></strong> pontos para liberar seu primeiro resgate!</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" 
                         style="width: <?= min(100, ($data['saldo']->pontos_acumulados / $data['config']->config_pontos_para_resgatar) * 100) ?>%">
                        <?= min(100, ($data['saldo']->pontos_acumulados / $data['config']->config_pontos_para_resgatar) * 100) ?>%
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-12">
            <h3>📜 Histórico de Movimentações</h3>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Data</th>
                            <th>Tipo</th>
                            <th>Pontos</th>
                            <th>Cashback</th>
                            <th>Descrição</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data['historico']): ?>
                        <?php foreach ($data['historico'] as $mov): ?>
                        <tr>
                            <td><?= date('d/m/Y H:i', strtotime($mov->data_criacao)) ?></td>
                            <td>
                                <span class="label label-<?= $mov->tipo == 'ganho' ? 'success' : ($mov->tipo == 'resgate' ? 'warning' : 'danger') ?>">
                                    <?= ucfirst($mov->tipo) ?>
                                </span>
                            </td>
                            <td><?= $mov->pontos > 0 ? '+' . $mov->pontos : '' ?></td>
                            <td><?= $mov->cashback > 0 ? '+R$ ' . number_format($mov->cashback, 2, ',', '.') : '' ?></td>
                            <td><?= $mov->descricao ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="5">Nenhuma movimentação registrada</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>
<!-- FIM: PROGRAMA DE PONTOS/CASHBACK -->
</div>

<script>
function resgatarPontos() {
    if (confirm('Tem certeza que deseja resgatar seus pontos?')) {
        // Implementar resgate via API
        alert('Função de resgate será implementada em breve!');
    }
}
</script>

        </div>
    </div>
    <?php 
    require_once 'footer.php'; 
    require 'side-carrinho.php'; 
    ?>
    <script type="text/javascript">
        var currentUri = 'fidelidadeCliente';
    </script>
    <?php require_once 'footer-core-js.php'; ?>
    <script type="text/javascript" src="{{ asset('assets/js/pedido.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/number.js"></script>
    <script src="{{ asset('assets/js/howler.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/carrinho.js"></script>
</body>

</html>
