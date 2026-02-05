<?php extract($data); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once __DIR__ . '/../site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Relatório de Garçons - Sistema de Caixa">
    <meta name="author" content="">

    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery.select2/dist/css/select2.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
        <![endif]-->
    <link href="css/style-prusia.css" rel="stylesheet" />
    <link href="css/caixa-relatorio-garcon.css" rel="stylesheet" />
</head>

<body class="animated">
    <div id="cl-wrapper">
        <div class="cl-sidebar no-print">
            <?php require_once __DIR__ . '/../side-menu.php'; ?>
        </div>
        <div class="container-fluid" id="pcont">
            <div class="cl-mcont">
                <div class="block-flat">
                    
                    <!-- Header -->
                    <div class="report-header">
                        <div class="row">
                            <div class="col-md-8">
                                <h2><i class="fa fa-user-md"></i> Relatório de Garçons</h2>
                                <p class="mb-0">Acompanhamento de performance e cálculo de comissão</p>
                            </div>
                            <div class="col-md-4 text-right">
                                <button onclick="window.print()" class="btn btn-print no-print">
                                    <i class="fa fa-print"></i> Imprimir Relatório
                                </button>
                                <a href="<?= $baseUri ?>/admin/caixa/" class="btn btn-default no-print">
                                    <i class="fa fa-arrow-left"></i> Voltar ao Caixa
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Filtros -->
                    <div class="report-filters no-print">
                        <form method="GET" action="">
                            <div class="row">
                                <div class="col-md-4">
                                    <label><i class="fa fa-user"></i> Garçom:</label>
                                    <select name="garcon_id" class="form-control" required>
                                        <option value="">Selecione um garçom...</option>
                                        <?php foreach ($garcons as $garcon): ?>
                                            <option value="<?= $garcon->garcon_id ?>" 
                                                    <?= ($garcon_selecionado == $garcon->garcon_id) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($garcon->garcon_nome) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label><i class="fa fa-calendar"></i> Data Início:</label>
                                    <input type="date" name="data_inicio" class="form-control" 
                                           value="<?= $data_inicio ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label><i class="fa fa-calendar"></i> Data Fim:</label>
                                    <input type="date" name="data_fim" class="form-control" 
                                           value="<?= $data_fim ?>" required>
                                </div>
                                <div class="col-md-2">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary form-control">
                                        <i class="fa fa-search"></i> Gerar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Conteúdo do Relatório -->
                    <?php if ($relatorio_dados): ?>
                        
                        <!-- Informações do Garçom -->
                        <div class="alert alert-info">
                            <h4><i class="fa fa-user-md"></i> <?= htmlspecialchars($relatorio_dados['garcon']->garcon_nome) ?></h4>
                            <p class="mb-0">Período: <?= date('d/m/Y', strtotime($data_inicio)) ?> a <?= date('d/m/Y', strtotime($data_fim)) ?></p>
                        </div>

                        <!-- Estatísticas Gerais -->
                        <div class="stats-grid">
                            <div class="stat-card">
                                <div class="stat-number text-success">
                                    <?= $relatorio_dados['estatisticas']->mesas_fechadas ?? 0 ?>
                                </div>
                                <div class="stat-label">Mesas Fechadas</div>
                            </div>
                            
                            <div class="stat-card commission">
                                <div class="stat-number text-warning">
                                    R$ <?= number_format($relatorio_dados['comissao_10_porcento'], 2, ',', '.') ?>
                                </div>
                                <div class="stat-label">Comissão 10%</div>
                            </div>
                            
                            <div class="stat-card average">
                                <div class="stat-number text-info">
                                    R$ <?= number_format(floatval($relatorio_dados['estatisticas']->ticket_medio ?? 0), 2, ',', '.') ?>
                                </div>
                                <div class="stat-label">Ticket Médio</div>
                            </div>
                            
                            <div class="stat-card time">
                                <div class="stat-number text-primary">
                                    <?= round($relatorio_dados['tempo_medio_minutos']) ?> min
                                </div>
                                <div class="stat-label">Tempo Médio</div>
                            </div>
                        </div>

                        <!-- Destaque da Comissão -->
                        <div class="commission-highlight">
                            <h3><i class="fa fa-money"></i> Comissão do Garçom</h3>
                            <div class="commission-amount">R$ <?= number_format($relatorio_dados['comissao_10_porcento'], 2, ',', '.') ?></div>
                            <p class="mb-0">
                                Calculada sobre R$ <?= number_format($relatorio_dados['valor_total_fechadas'], 2, ',', '.') ?> 
                                em vendas de mesas fechadas (10%)
                            </p>
                        </div>

                        <!-- Detalhamento das Mesas -->
                        <div class="table-section">
                            <div class="table-header">
                                <i class="fa fa-table"></i> Detalhamento das Mesas Atendidas
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Mesa</th>
                                            <th>Cliente</th>
                                            <th>Pessoas</th>
                                            <th>Início</th>
                                            <th>Fim</th>
                                            <th>Duração</th>
                                            <th>Pedidos</th>
                                            <th>Valor</th>
                                            <th>Performance</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($relatorio_dados['mesas_detalhes'] as $mesa): ?>
                                            <?php
                                            $valor_mesa = floatval($mesa->valor_mesa);
                                            $performance = 'poor';
                                            $performance_label = 'Ruim';
                                            
                                            if ($valor_mesa >= 100) {
                                                $performance = 'excellent';
                                                $performance_label = 'Excelente';
                                            } elseif ($valor_mesa >= 50) {
                                                $performance = 'good';
                                                $performance_label = 'Bom';
                                            } elseif ($valor_mesa >= 20) {
                                                $performance = 'average';
                                                $performance_label = 'Regular';
                                            }
                                            
                                            $horas = floor($mesa->tempo_atendimento_minutos / 60);
                                            $minutos = $mesa->tempo_atendimento_minutos % 60;
                                            $duracao_formatada = $horas > 0 ? "{$horas}h {$minutos}min" : "{$minutos}min";
                                            ?>
                                            <tr>
                                                <td><strong>Mesa <?= $mesa->mesa_numero ?></strong></td>
                                                <td><?= htmlspecialchars($mesa->cliente_nome ?: 'N/I') ?></td>
                                                <td><?= $mesa->numero_pessoas ?: 'N/I' ?></td>
                                                <td><?= date('d/m H:i', strtotime($mesa->data_inicio)) ?></td>
                                                <td>
                                                    <?= $mesa->data_fim ? date('d/m H:i', strtotime($mesa->data_fim)) : 'Em andamento' ?>
                                                </td>
                                                <td><?= $duracao_formatada ?></td>
                                                <td><?= $mesa->qtd_pedidos ?></td>
                                                <td><strong>R$ <?= number_format($valor_mesa, 2, ',', '.') ?></strong></td>
                                                <td>
                                                    <span class="performance-indicator performance-<?= $performance ?>">
                                                        <?= $performance_label ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="mesa-status <?= $mesa->ocupacao_status == 0 ? 'fechada' : 'aberta' ?>">
                                                        <?= $mesa->ocupacao_status == 0 ? 'Fechada' : 'Aberta' ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="active">
                                            <th colspan="7">Total (Mesas Fechadas)</th>
                                            <th>R$ <?= number_format($relatorio_dados['valor_total_fechadas'], 2, ',', '.') ?></th>
                                            <th colspan="2">
                                                <span class="label label-warning">
                                                    Comissão: R$ <?= number_format($relatorio_dados['comissao_10_porcento'], 2, ',', '.') ?>
                                                </span>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="no-data">
                            <i class="fa fa-search fa-3x text-muted"></i>
                            <h3>Selecione um garçom e período</h3>
                            <p>Use os filtros acima para gerar o relatório de comissão</p>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?php echo $baseUri; ?>/assets/vendor/jquery/jquery-2.1.4.min.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.cooki/jquery.cooki.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.ui/jquery-ui.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.gritter/js/jquery.gritter.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/behaviour/core.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.select2/dist/js/select2.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <?php require_once __DIR__ . '/../switch-color.php'; ?>
    <script src="<?php echo $baseUri; ?>/view/admin/app-js/main.js"></script>

    <script>
        var baseUri = '<?= $baseUri; ?>';
        
        // Auto-fill today's date if no date is selected
        $(document).ready(function() {
            if (!$('input[name="data_inicio"]').val()) {
                $('input[name="data_inicio"]').val(new Date().toISOString().split('T')[0]);
            }
            if (!$('input[name="data_fim"]').val()) {
                $('input[name="data_fim"]').val(new Date().toISOString().split('T')[0]);
            }
        });
    </script>
</body>

</html>