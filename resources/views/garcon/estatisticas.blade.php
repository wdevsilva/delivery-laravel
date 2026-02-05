<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estatísticas - <?= $data['config']->config_nome ?></title>
    <link rel="icon" type="image/png" href="<?php echo $baseUri; ?>/midias/logo/<?= $_SESSION['base_delivery'] ?>/<?php echo $data['config']->config_foto; ?>" />    
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/css/main.css?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/css/main.css') ?>">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/css/garcon-estatisticas.css"> 
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= $baseUri ?>/garcon/">
                    <i class="fa fa-cutlery"></i> <?= $data['config']->config_nome ?>
                </a>
            </div>
            
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="<?= $baseUri ?>/garcon/">
                            <i class="fa fa-dashboard"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="<?= $baseUri ?>/garcon/mesas/">
                            <i class="fa fa-th-large"></i> Minhas Mesas
                        </a>
                    </li>
                    <li class="active">
                        <a href="<?= $baseUri ?>/garcon/estatisticas/">
                            <i class="fa fa-bar-chart"></i> Estatísticas
                        </a>
                    </li>
                </ul>
                
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-user"></i> <?= $data['garcon']->garcon_nome ?> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?= $baseUri ?>/garcon/logout/">
                                    <i class="fa fa-sign-out"></i> Sair
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Page Header -->
        <div class="section-header">
            <div class="row">
                <div class="col-md-8">
                    <h2><i class="fa fa-bar-chart"></i> Estatísticas - <?= explode(' ', $data['garcon']->garcon_nome)[0] ?></h2>
                    <p class="lead">Acompanhe seu desempenho e produtividade</p>
                </div>
                <div class="col-md-4 text-right">
                    <h4><i class="fa fa-clock-o"></i> <?= date('d/m/Y H:i') ?></h4>
                    <p>Relatório de Performance</p>
                </div>
            </div>
        </div>

        <!-- Period Selection -->
        <div class="row">
            <div class="col-md-12">
                <div class="period-buttons">
                    <button type="button" class="btn btn-primary" onclick="carregarEstatisticas('hoje')">
                        <i class="fa fa-calendar-o"></i> Hoje
                    </button>
                    <button type="button" class="btn btn-default" onclick="carregarEstatisticas('semana')">
                        <i class="fa fa-calendar"></i> Esta Semana
                    </button>
                    <button type="button" class="btn btn-default" onclick="carregarEstatisticas('mes')">
                        <i class="fa fa-calendar"></i> Este Mês
                    </button>
                    <button type="button" class="btn btn-success float-right" onclick="location.reload()">
                        <i class="fa fa-refresh"></i> Atualizar
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row" id="stats-cards">
            <div class="col-md-3">
                <div class="card bg-primary text-white stat-card">
                    <div class="card-body">
                        <h3 id="stat-mesas"><?= $data['estatisticas']->mesas_atendidas ?? 0 ?></h3>
                        <p>Mesas Atendidas</p>
                        <i class="fa fa-th-large fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white stat-card">
                    <div class="card-body">
                        <h3 id="stat-pedidos"><?= $data['estatisticas']->pedidos_entregues ?? 0 ?></h3>
                        <p>Pedidos Realizados</p>
                        <i class="fa fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white stat-card">
                    <div class="card-body">
                        <h3 id="stat-tempo"><?= $data['estatisticas']->tempo_medio ?? '0min' ?></h3>
                        <p>Tempo Médio/Mesa</p>
                        <i class="fa fa-clock-o fa-2x"></i>
                    </div>
                </div>
            </div>

        </div>

        <!-- Performance Chart -->
        <div class="row">
            <div class="col-md-8">
                <div class="chart-container">
                    <h4><i class="fa fa-line-chart"></i> Performance Diária</h4>
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="performance-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="chart-container">
                    <h4><i class="fa fa-pie-chart"></i> Distribuição de Atendimentos</h4>
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="distribution-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Statistics Table -->
        <div class="row">
            <div class="col-md-12">
                <div class="table-stats">
                    <div class="panel-heading" style="background-color: #2c3e50; color: white; padding: 15px;">
                        <h4 class="panel-title" style="margin: 0;">
                            <i class="fa fa-table"></i> Histórico Detalhado de Atendimentos
                        </h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Mesa</th>
                                    <th>Cliente</th>
                                    <th>Pessoas</th>
                                    <th>Duração</th>
                                    <th>Pedidos</th>
                                    <th>Performance</th>
                                </tr>
                            </thead>
                            <tbody id="historico-tbody">
                                <?php if (isset($data['historico']) && count($data['historico']) > 0): ?>
                                    <?php foreach ($data['historico'] as $atendimento): ?>
                                        <tr>
                                            <td><?= date('d/m/Y', strtotime($atendimento->data_inicio)) ?></td>
                                            <td>Mesa <?= $atendimento->mesa_numero ?></td>
                                            <td><?= $atendimento->cliente_nome ?: 'N/I' ?></td>
                                            <td><?= $atendimento->numero_pessoas ?: 'N/I' ?></td>
                                            <td><?= $atendimento->duracao_formatada ?: 'N/I' ?></td>
                                            <td><?= $atendimento->total_pedidos ?: 0 ?></td>
                                            <td>
                                                <?php 
                                                $performance = $atendimento->performance ?? 'average';
                                                $performanceLabels = [
                                                    'excellent' => 'Excelente',
                                                    'good' => 'Bom', 
                                                    'average' => 'Regular',
                                                    'poor' => 'Ruim'
                                                ];
                                                ?>
                                                <span class="performance-indicator performance-<?= $performance ?>">
                                                    <?= $performanceLabels[$performance] ?? 'Regular' ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <i class="fa fa-info-circle"></i> Nenhum atendimento encontrado para o período selecionado
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Tips -->
        <div class="row">
            <div class="col-md-12">
                <div class="chart-container">
                    <h4><i class="fa fa-lightbulb-o"></i> Dicas de Performance</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <i class="fa fa-clock-o"></i> <strong>Tempo de Atendimento</strong><br>
                                Mantenha o tempo médio por mesa entre 45-60 minutos para otimizar o fluxo.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-success">
                                <i class="fa fa-users"></i> <strong>Satisfação do Cliente</strong><br>
                                Sempre confirme os pedidos e mantenha comunicação clara com os clientes.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= $baseUri ?>/assets/vendor/jquery/jquery-2.1.4.min.js"></script>
    <script src="<?= $baseUri ?>/assets/vendor/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var baseUri = '<?= $baseUri ?>';
        var currentPeriod = 'hoje';
        var performanceChart;
        var distributionChart;
        
        // Dados iniciais do PHP
        var dadosGraficos = <?= json_encode($data['dados_graficos'] ?? []) ?>;
        var dadosDistribuicao = <?= json_encode($data['distribuicao'] ?? ['manha' => 0, 'tarde' => 0, 'noite' => 0]) ?>;

        $(document).ready(function() {
            initializeCharts();
            
            // Auto refresh every 5 minutes
            setInterval(function() {
                carregarEstatisticas(currentPeriod);
            }, 300000);
        });

        function carregarEstatisticas(periodo) {
            currentPeriod = periodo;
            
            // Update button states
            $('.period-buttons .btn').removeClass('btn-primary').addClass('btn-default');
            $('button[onclick="carregarEstatisticas(\'' + periodo + '\')"]').removeClass('btn-default').addClass('btn-primary');
            
            // Load statistics via AJAX
            $.ajax({
                url: baseUri + '/garcon/get-estatisticas/',
                type: 'POST',
                dataType: 'json',
                data: { periodo: periodo },
                success: function(response) {
                    if (response.status === 'success') {
                        updateStatistics(response.data);
                        updateCharts(response.graficos, response.distribuicao);
                        updateHistorico(response.historico || []);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    // Continue with static data if AJAX fails
                }
            });
        }

        function updateStatistics(data) {
            $('#stat-mesas').text(data.mesas_atendidas || 0);
            $('#stat-pedidos').text(data.pedidos_entregues || 0);
            $('#stat-tempo').text(data.tempo_medio || '0min');
        }

        function updateHistorico(historico) {
            var tbody = $('#historico-tbody');
            tbody.empty();
            
            if (historico && historico.length > 0) {
                historico.forEach(function(item) {
                    var performanceClass = 'performance-' + (item.performance || 'average');
                    var performanceLabel = {
                        'excellent': 'Excelente',
                        'good': 'Bom',
                        'average': 'Regular',
                        'poor': 'Ruim'
                    }[item.performance] || 'Regular';
                    
                    var row = `
                        <tr>
                            <td>${item.data_formatada || 'N/I'}</td>
                            <td>Mesa ${item.mesa_numero || 'N/I'}</td>
                            <td>${item.cliente_nome || 'N/I'}</td>
                            <td>${item.numero_pessoas || 'N/I'}</td>
                            <td>${item.duracao_formatada || 'N/I'}</td>
                            <td>${item.total_pedidos || 0}</td>
                            <td><span class="performance-indicator ${performanceClass}">${performanceLabel}</span></td>
                        </tr>
                    `;
                    tbody.append(row);
                });
            } else {
                tbody.append(`
                    <tr>
                        <td colspan="7" class="text-center">
                            <i class="fa fa-info-circle"></i> Nenhum atendimento encontrado para o período selecionado
                        </td>
                    </tr>
                `);
            }
        }

        function initializeCharts() {
            // Preparar dados do gráfico de performance
            var labels = [];
            var dados = [];
            
            if (dadosGraficos && dadosGraficos.length > 0) {
                dadosGraficos.forEach(function(item) {
                    labels.push(item.dia);
                    dados.push(item.mesas);
                });
            } else {
                // Dados padrão se não houver dados
                labels = ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'];
                dados = [0, 0, 0, 0, 0, 0, 0];
            }
            
            // Performance Chart
            var ctxPerformance = document.getElementById('performance-chart').getContext('2d');
            performanceChart = new Chart(ctxPerformance, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Mesas Atendidas',
                        data: dados,
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 2,
                    animation: {
                        duration: 0
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    }
                }
            });

            // Distribution Chart
            var ctxDistribution = document.getElementById('distribution-chart').getContext('2d');
            var distribuicaoData = [dadosDistribuicao.manha, dadosDistribuicao.tarde, dadosDistribuicao.noite];
            
            distributionChart = new Chart(ctxDistribution, {
                type: 'doughnut',
                data: {
                    labels: ['Manhã', 'Tarde', 'Noite'],
                    datasets: [{
                        data: distribuicaoData,
                        backgroundColor: ['#28a745', '#ffc107', '#dc3545']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 1,
                    animation: {
                        duration: 0
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        function updateCharts(dadosGraficos, dadosDistribuicao) {
            // Atualizar gráfico de performance
            if (performanceChart && dadosGraficos) {
                var labels = [];
                var dados = [];
                
                dadosGraficos.forEach(function(item) {
                    labels.push(item.dia);
                    dados.push(item.mesas);
                });
                
                performanceChart.data.labels = labels;
                performanceChart.data.datasets[0].data = dados;
                performanceChart.update();
            }
            
            // Atualizar gráfico de distribuição
            if (distributionChart && dadosDistribuicao) {
                var distribuicaoData = [dadosDistribuicao.manha, dadosDistribuicao.tarde, dadosDistribuicao.noite];
                distributionChart.data.datasets[0].data = distribuicaoData;
                distributionChart.update();
            }
        }
    </script>
</body>
</html>