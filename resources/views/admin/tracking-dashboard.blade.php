<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Rastreamento de Entregas</title>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
        <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />
    
    <style>
        .tracking-dashboard {
            margin: 20px 0;
        }
        
        .stats-row {
            margin-bottom: 30px;
        }
        
        .stat-box {
            background: white;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid;
            margin-bottom: 20px;
        }
        
        .stat-box.entregadores { border-left-color: #3498db; }
        .stat-box.pedidos { border-left-color: #2ecc71; }
        .stat-box.em-rota { border-left-color: #f39c12; }
        .stat-box.entregues { border-left-color: #27ae60; }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #7f8c8d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .tracking-map {
            height: 400px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .pedidos-ativos {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .pedido-item {
            border: 1px solid #ecf0f1;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s;
        }
        
        .pedido-item:hover {
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .pedido-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .pedido-numero {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-aguardando { background: #fff3cd; color: #856404; }
        .status-coletado { background: #cce5ff; color: #004085; }
        .status-em_rota { background: #d4edda; color: #155724; }
        .status-chegou_destino { background: #f8d7da; color: #721c24; }
        
        .entregador-info {
            color: #7f8c8d;
            font-size: 0.9rem;
        }
        
        .btn-action {
            margin: 2px;
        }
        
        .map-controls {
            margin-bottom: 15px;
        }
        
        .legend {
            background: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 1px 5px rgba(0,0,0,0.2);
            margin-top: 10px;
        }
        
        .legend-item {
            display: inline-flex;
            align-items: center;
            margin-right: 15px;
            font-size: 0.85rem;
        }
        
        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 5px;
        }
        
        .auto-refresh {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(52, 152, 219, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(52, 152, 219, 0); }
            100% { box-shadow: 0 0 0 0 rgba(52, 152, 219, 0); }
        }
    </style>
</head>

<body class="animated">
    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php require_once 'side-menu.php'; ?>
        </div>
        <!-- Main Content -->
        <div class="container-fluid" id="pcont">
            <div class="page-head">
                <h2>Rastreamento de Entregas</h2>
                <ol class="breadcrumb">
                    <li><a href="<?= $baseUri ?>/admin/">Início</a></li>
                    <li class="active">Rastreamento</li>
                </ol>
            </div>
            <!-- Page Content -->
            <div class="cl-mcont tracking-dashboard">
                
                <?php if (isset($data['migration_needed']) && $data['migration_needed']): ?>
                    <!-- Migration Warning -->
                    <div class="alert alert-warning" style="margin-bottom: 30px;">
                        <h4><i class="fa fa-exclamation-triangle"></i> Migração Necessária</h4>
                        <p><?= $data['error_message'] ?></p>
                        <p><strong>Para usar o módulo de rastreamento:</strong></p>
                        <ol>
                            <li>Execute o arquivo SQL: <code>docs_modulo_mesas/migration_entrega_tracking.sql</code></li>
                            <li>Recarregue esta página</li>
                        </ol>
                        <p><a href="<?= $baseUri ?>/docs_modulo_mesas/migration_entrega_tracking.sql" target="_blank" class="btn btn-info">Ver Arquivo SQL</a></p>
                    </div>
                <?php endif; ?>
                
                <!-- Estatísticas -->
                <div class="row stats-row">
                    <div class="col-md-3">
                        <div class="stat-box entregadores">
                            <div class="stat-number" id="stat-entregadores">
                                <?= $data['entregadores'] ? count($data['entregadores']) : 0 ?>
                            </div>
                            <div class="stat-label">Entregadores Online</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-box pedidos">
                            <div class="stat-number" id="stat-pedidos">
                                <?= $data['pedidos_tracking'] ? count($data['pedidos_tracking']) : 0 ?>
                            </div>
                            <div class="stat-label">Pedidos Ativos</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-box em-rota">
                            <div class="stat-number" id="stat-em-rota">
                                <?php
                                $em_rota = 0;
                                if ($data['pedidos_tracking']) {
                                    foreach ($data['pedidos_tracking'] as $p) {
                                        if ($p->status_tracking == 'em_rota') $em_rota++;
                                    }
                                }
                                echo $em_rota;
                                ?>
                            </div>
                            <div class="stat-label">Em Rota</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-box entregues">
                            <div class="stat-number" id="stat-entregues">0</div>
                            <div class="stat-label">Entregues Hoje</div>
                        </div>
                    </div>
                </div>

                <!-- Controles e Mapa -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="block-flat">
                            <div class="header">
                                <h3><i class="fa fa-map-marker"></i> Mapa em Tempo Real</h3>
                            </div>
                            <div class="content">
                                <div class="map-controls">
                                    <button class="btn btn-primary btn-sm" onclick="refreshMap()">
                                        <i class="fa fa-refresh"></i> Atualizar Mapa
                                    </button>
                                    <button class="btn btn-info btn-sm" onclick="centerMap()">
                                        <i class="fa fa-crosshairs"></i> Centralizar
                                    </button>
                                    <a href="<?= $baseUri ?>/entrega-tracking/mapa-tempo-real/" class="btn btn-success btn-sm">
                                        <i class="fa fa-expand"></i> Tela Cheia
                                    </a>
                                </div>
                                <div id="tracking-map" class="tracking-map"></div>
                                <div class="legend">
                                    <div class="legend-item">
                                        <div class="legend-color" style="background: #3498db;"></div>
                                        <span>Entregadores</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-color" style="background: #e74c3c;"></div>
                                        <span>Destinos</span>
                                    </div>
                                    <div class="legend-item">
                                        <div class="legend-color" style="background: #2ecc71;"></div>
                                        <span>Restaurante</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="block-flat">
                            <div class="header">
                                <h3><i class="fa fa-list"></i> Pedidos Ativos</h3>
                            </div>
                            <div class="content">
                                <div id="pedidos-list">
                                    <?php if ($data['pedidos_tracking']): ?>
                                        <?php foreach ($data['pedidos_tracking'] as $pedido): ?>
                                            <div class="pedido-item" data-pedido-id="<?= $pedido->pedido_id ?>">
                                                <div class="pedido-header">
                                                    <div class="pedido-numero">
                                                        Pedido #<?= $pedido->pedido_numero_entrega ?>
                                                    </div>
                                                    <div class="status-badge status-<?= $pedido->status_tracking ?>">
                                                        <?= ucfirst(str_replace('_', ' ', $pedido->status_tracking)) ?>
                                                    </div>
                                                </div>
                                                
                                                <div class="entregador-info">
                                                    <i class="fa fa-user"></i> 
                                                    <?= $pedido->entregador_nome ?: 'Sem entregador' ?>
                                                </div>
                                                
                                                <div class="entregador-info">
                                                    <i class="fa fa-map-marker"></i> 
                                                    <?= $pedido->endereco_endereco ?>, <?= $pedido->endereco_numero ?>
                                                </div>
                                                
                                                <div class="entregador-info">
                                                    <i class="fa fa-clock-o"></i> 
                                                    <?= Timer::parse_date_br($pedido->pedido_data) ?>
                                                </div>
                                                
                                                <div style="margin-top: 10px;">
                                                    <?php if (!$pedido->entregador_nome): ?>
                                                        <button class="btn btn-success btn-xs btn-action" onclick="atribuirEntregador(<?= $pedido->pedido_id ?>)">
                                                            <i class="fa fa-user-plus"></i> Atribuir
                                                        </button>
                                                    <?php endif; ?>
                                                    
                                                    <button class="btn btn-info btn-xs btn-action" onclick="verDetalhesPedido(<?= $pedido->pedido_id ?>)">
                                                        <i class="fa fa-eye"></i> Ver
                                                    </button>
                                                    
                                                    <button class="btn btn-primary btn-xs btn-action" onclick="verNoMapa(<?= $pedido->latitude_destino ?>, <?= $pedido->longitude_destino ?>)">
                                                        <i class="fa fa-map"></i> Mapa
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div style="text-align: center; padding: 30px; color: #7f8c8d;">
                                            <i class="fa fa-inbox" style="font-size: 3rem; margin-bottom: 15px;"></i>
                                            <p>Nenhum pedido ativo no momento</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Links Rápidos -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="block-flat">
                            <div class="header">
                                <h3><i class="fa fa-cogs"></i> Ações Rápidas</h3>
                            </div>
                            <div class="content">
                                <a href="<?= $baseUri ?>/entrega-tracking/configuracoes/" class="btn btn-default">
                                    <i class="fa fa-cog"></i> Configurações
                                </a>
                                <a href="<?= $baseUri ?>/entrega-tracking/relatorio/" class="btn btn-info">
                                    <i class="fa fa-bar-chart"></i> Relatórios
                                </a>
                                <a href="<?= $baseUri ?>/entrega-tracking/mapa-tempo-real/" class="btn btn-success">
                                    <i class="fa fa-map"></i> Mapa Completo
                                </a>
                                <a href="<?= $baseUri ?>/entregador/" class="btn btn-warning">
                                    <i class="fa fa-users"></i> Gerenciar Entregadores
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Button de auto-refresh -->
    <button class="auto-refresh" onclick="toggleAutoRefresh()" title="Auto-atualização ativa">
        <i class="fa fa-refresh" id="refresh-icon"></i>
    </button>

    <!-- Modal para atribuir entregador -->
    <div class="modal fade" id="modal-atribuir" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Atribuir Entregador</h4>
                </div>
                <div class="modal-body">
                    <form id="form-atribuir">
                        <input type="hidden" id="pedido-id" name="pedido_id">
                        <div class="form-group">
                            <label>Selecione o Entregador:</label>
                            <select class="form-control" name="entregador_id" required>
                                <option value="">Selecione...</option>
                                <?php if ($data['entregadores']): ?>
                                    <?php foreach ($data['entregadores'] as $entregador): ?>
                                        <option value="<?= $entregador->entregador_id ?>">
                                            <?= $entregador->entregador_nome ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" onclick="confirmarAtribuicao()">Atribuir</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        let map;
        let autoRefreshEnabled = true;
        let refreshInterval;
        const markers = {};

        // Inicializar mapa
        function initMap() {
            map = L.map('tracking-map').setView([-23.5505, -46.6333], 12);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            loadMapData();
        }

        function loadMapData() {
            // Carregar entregadores e pedidos
            // Esta seria uma chamada AJAX real em produção
            console.log('Carregando dados do mapa...');
            
            // Exemplo de dados (substitua por chamada AJAX real)
            <?php if ($data['entregadores']): ?>
                <?php foreach ($data['entregadores'] as $entregador): ?>
                    <?php 
                    // Verificar se as colunas de latitude/longitude existem
                    $lat = isset($entregador->entregador_latitude) ? $entregador->entregador_latitude : null;
                    $lng = isset($entregador->entregador_longitude) ? $entregador->entregador_longitude : null;
                    ?>
                    <?php if ($lat && $lng): ?>
                        addEntregadorMarker(<?= $lat ?>, <?= $lng ?>, '<?= addslashes($entregador->entregador_nome) ?>');
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        }

        function addEntregadorMarker(lat, lng, nome) {
            const marker = L.marker([lat, lng], {
                icon: L.divIcon({
                    html: '<i class="fa fa-motorcycle" style="color: #3498db; font-size: 20px;"></i>',
                    iconSize: [30, 30],
                    className: 'custom-div-icon'
                })
            }).addTo(map);
            
            marker.bindPopup(`<strong>Entregador:</strong> ${nome}`);
            markers[nome] = marker;
        }

        function refreshMap() {
            // Remover marcadores existentes
            Object.keys(markers).forEach(key => {
                map.removeLayer(markers[key]);
                delete markers[key];
            });
            
            // Recarregar dados
            loadMapData();
        }

        function centerMap() {
            map.setView([-23.5505, -46.6333], 12);
        }

        function verNoMapa(lat, lng) {
            if (lat && lng) {
                map.setView([lat, lng], 16);
            }
        }

        function atribuirEntregador(pedidoId) {
            document.getElementById('pedido-id').value = pedidoId;
            $('#modal-atribuir').modal('show');
        }

        function confirmarAtribuicao() {
            const form = document.getElementById('form-atribuir');
            const formData = new FormData(form);
            
            fetch('<?= $baseUri ?>/entrega-tracking/iniciar-tracking/', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Tracking iniciado com sucesso!');
                    $('#modal-atribuir').modal('hide');
                    location.reload();
                } else {
                    alert('Erro: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro na comunicação com o servidor');
            });
        }

        function verDetalhesPedido(pedidoId) {
            window.open('<?= $baseUri ?>/admin/pedido/' + pedidoId + '/', '_blank');
        }

        function toggleAutoRefresh() {
            autoRefreshEnabled = !autoRefreshEnabled;
            const icon = document.getElementById('refresh-icon');
            
            if (autoRefreshEnabled) {
                icon.style.animationPlayState = 'running';
                startAutoRefresh();
            } else {
                icon.style.animationPlayState = 'paused';
                stopAutoRefresh();
            }
        }

        function startAutoRefresh() {
            refreshInterval = setInterval(() => {
                refreshMap();
                updateStats();
            }, 30000); // 30 segundos
        }

        function stopAutoRefresh() {
            if (refreshInterval) {
                clearInterval(refreshInterval);
            }
        }

        function updateStats() {
            // Atualizar estatísticas via AJAX
            fetch('<?= $baseUri ?>/entrega-tracking/stats-api/')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('stat-entregadores').textContent = data.entregadores_online;
                        document.getElementById('stat-pedidos').textContent = data.pedidos_ativos;
                        document.getElementById('stat-em-rota').textContent = data.em_rota;
                        document.getElementById('stat-entregues').textContent = data.entregues_hoje;
                    }
                })
                .catch(error => console.error('Erro ao atualizar stats:', error));
        }

        // Inicializar quando carregar
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
            startAutoRefresh();
        });

        // Adicionar item ao menu ativo
        $('#menu-tracking').addClass('active');
    </script>
</body>
</html>