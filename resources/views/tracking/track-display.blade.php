<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rastreamento do Pedido #<?= $data['tracking']->pedido_numero_entrega ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .header p {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .tracking-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .status-timeline {
            position: relative;
        }

        .timeline-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            position: relative;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .timeline-icon.completed {
            background: #28a745;
            color: white;
        }

        .timeline-icon.current {
            background: #667eea;
            color: white;
            animation: pulse 2s infinite;
        }

        .timeline-icon.pending {
            background: #e9ecef;
            color: #999;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(102, 126, 234, 0); }
            100% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0); }
        }

        .timeline-content {
            flex: 1;
        }

        .timeline-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .timeline-time {
            color: #666;
            font-size: 0.9rem;
        }

        .pedido-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .info-item i {
            color: #667eea;
            font-size: 1.2rem;
        }

        .info-value {
            font-weight: 600;
            color: #333;
        }

        .map-container {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        #map {
            height: 400px;
            border-radius: 10px;
        }

        .map-legend {
            display: flex;
            justify-content: space-around;
            margin-top: 15px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
            font-size: 0.9rem;
        }

        .legend-icon {
            width: 20px;
            height: 20px;
            border-radius: 50%;
        }

        .legend-entregador { background: #667eea; }
        .legend-destino { background: #dc3545; }
        .legend-origem { background: #28a745; }

        .eta-card {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            text-align: center;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
        }

        .eta-time {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .eta-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .entregador-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .entregador-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .entregador-avatar {
            width: 50px;
            height: 50px;
            background: #667eea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .refresh-info {
            text-align: center;
            color: #666;
            font-size: 0.9rem;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .tracking-grid {
                grid-template-columns: 1fr;
            }
            
            .pedido-info {
                grid-template-columns: 1fr;
            }
            
            .map-legend {
                justify-content: center;
            }
            
            .eta-time {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>
            <i class="fas fa-box"></i>
            Pedido #<?= $data['tracking']->pedido_numero_entrega ?>
        </h1>
        <p>Acompanhe sua entrega em tempo real</p>
    </div>

    <div class="container">
        <!-- Tempo estimado -->
        <?php if ($data['tracking']->tempo_estimado_entrega && $data['tracking']->status_tracking == 'em_rota'): ?>
            <div class="eta-card">
                <div class="eta-time" id="eta-countdown">
                    <?= $data['tracking']->tempo_estimado_entrega ?> min
                </div>
                <div class="eta-label">Tempo estimado para entrega</div>
            </div>
        <?php endif; ?>

        <div class="tracking-grid">
            <!-- Informações do Pedido -->
            <div class="card">
                <div class="card-title">
                    <i class="fas fa-receipt"></i>
                    Detalhes do Pedido
                </div>
                
                <div class="pedido-info">
                    <div class="info-item">
                        <i class="fas fa-calendar"></i>
                        <div>
                            <div>Data do Pedido</div>
                            <div class="info-value"><?= Timer::parse_date_br($data['tracking']->pedido_data) ?></div>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-money-bill-wave"></i>
                        <div>
                            <div>Valor Total</div>
                            <div class="info-value">R$ <?= Currency::moeda($data['tracking']->pedido_total) ?></div>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <div>Entregar em</div>
                            <div class="info-value"><?= $data['tracking']->endereco_endereco ?>, <?= $data['tracking']->endereco_numero ?></div>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <i class="fas fa-building"></i>
                        <div>
                            <div>Bairro</div>
                            <div class="info-value"><?= $data['tracking']->endereco_bairro ?></div>
                        </div>
                    </div>
                </div>

                <!-- Informações do Entregador (se configurado) -->
                <?php if (isset($data['config']['mostrar_entregador_cliente']) && $data['config']['mostrar_entregador_cliente'] == '1' && $data['tracking']->entregador_nome): ?>
                    <div class="entregador-info">
                        <div class="entregador-header">
                            <div class="entregador-avatar">
                                <i class="fas fa-motorcycle"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: #333;">Seu Entregador</div>
                                <div style="color: #666;"><?= $data['tracking']->entregador_nome ?></div>
                            </div>
                        </div>
                        
                        <?php if ($data['tracking']->entregador_fone): ?>
                            <a href="tel:<?= $data['tracking']->entregador_fone ?>" class="btn btn-success">
                                <i class="fas fa-phone"></i> Ligar para o Entregador
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Status do Rastreamento -->
            <div class="card">
                <div class="card-title">
                    <i class="fas fa-route"></i>
                    Status da Entrega
                </div>
                
                <div class="status-timeline">
                    <?php
                    $statuses = [
                        'aguardando_entregador' => ['icon' => 'clock', 'title' => 'Aguardando Entregador', 'desc' => 'Procurando entregador disponível'],
                        'coletado' => ['icon' => 'check', 'title' => 'Pedido Coletado', 'desc' => 'Entregador coletou seu pedido'],
                        'em_rota' => ['icon' => 'motorcycle', 'title' => 'Em Rota de Entrega', 'desc' => 'Entregador a caminho do destino'],
                        'chegou_destino' => ['icon' => 'map-marker-alt', 'title' => 'Chegou ao Destino', 'desc' => 'Entregador chegou ao local'],
                        'entregue' => ['icon' => 'handshake', 'title' => 'Entregue', 'desc' => 'Pedido foi entregue com sucesso']
                    ];
                    
                    $current_status = $data['tracking']->status_tracking;
                    $status_order = array_keys($statuses);
                    $current_index = array_search($current_status, $status_order);
                    ?>
                    
                    <?php foreach ($statuses as $status_key => $status_info): ?>
                        <?php
                        $item_index = array_search($status_key, $status_order);
                        $icon_class = 'pending';
                        
                        if ($item_index < $current_index) {
                            $icon_class = 'completed';
                        } elseif ($item_index == $current_index) {
                            $icon_class = 'current';
                        }
                        ?>
                        
                        <div class="timeline-item">
                            <div class="timeline-icon <?= $icon_class ?>">
                                <i class="fas fa-<?= $status_info['icon'] ?>"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title"><?= $status_info['title'] ?></div>
                                <div class="timeline-time"><?= $status_info['desc'] ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Mapa -->
        <div class="map-container">
            <div class="card-title">
                <i class="fas fa-map"></i>
                Localização em Tempo Real
            </div>
            <div id="map"></div>
            <div class="map-legend">
                <div class="legend-item">
                    <div class="legend-icon legend-origem"></div>
                    <span>Restaurante</span>
                </div>
                <div class="legend-item">
                    <div class="legend-icon legend-entregador"></div>
                    <span>Entregador</span>
                </div>
                <div class="legend-item">
                    <div class="legend-icon legend-destino"></div>
                    <span>Seu Endereço</span>
                </div>
            </div>
        </div>

        <div class="refresh-info">
            <i class="fas fa-sync-alt"></i>
            Esta página é atualizada automaticamente a cada <?= $data['config']['intervalo_atualizacao_cliente'] ?? 60 ?> segundos
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let map;
        const trackingCode = '<?= Http::get_param(2) ?>';
        const updateInterval = <?= ($data['config']['intervalo_atualizacao_cliente'] ?? 60) * 1000 ?>;
        
        // Dados do tracking
        const trackingData = <?= json_encode($data['tracking']) ?>;
        
        function initMap() {
            // Coordenadas padrão (centro entre origem e destino)
            let centerLat = trackingData.latitude_destino || -23.5505;
            let centerLng = trackingData.longitude_destino || -46.6333;
            
            map = L.map('map').setView([centerLat, centerLng], 13);
            
            // Usar OpenStreetMap (gratuito)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            addMapMarkers();
        }
        
        function addMapMarkers() {
            const bounds = [];
            
            // Marcador da origem (restaurante)
            if (trackingData.latitude_origem && trackingData.longitude_origem) {
                const origemMarker = L.marker([trackingData.latitude_origem, trackingData.longitude_origem], {
                    icon: L.divIcon({
                        html: '<i class="fas fa-store" style="color: #28a745; font-size: 20px;"></i>',
                        iconSize: [30, 30],
                        className: 'custom-div-icon'
                    })
                }).addTo(map);
                origemMarker.bindPopup('Restaurante');
                bounds.push([trackingData.latitude_origem, trackingData.longitude_origem]);
            }
            
            // Marcador do destino
            if (trackingData.latitude_destino && trackingData.longitude_destino) {
                const destinoMarker = L.marker([trackingData.latitude_destino, trackingData.longitude_destino], {
                    icon: L.divIcon({
                        html: '<i class="fas fa-home" style="color: #dc3545; font-size: 20px;"></i>',
                        iconSize: [30, 30],
                        className: 'custom-div-icon'
                    })
                }).addTo(map);
                destinoMarker.bindPopup('Seu Endereço');
                bounds.push([trackingData.latitude_destino, trackingData.longitude_destino]);
            }
            
            // Marcador do entregador (se disponível)
            if (trackingData.latitude_atual && trackingData.longitude_atual) {
                const entregadorMarker = L.marker([trackingData.latitude_atual, trackingData.longitude_atual], {
                    icon: L.divIcon({
                        html: '<i class="fas fa-motorcycle" style="color: #667eea; font-size: 20px;"></i>',
                        iconSize: [30, 30],
                        className: 'custom-div-icon'
                    })
                }).addTo(map);
                entregadorMarker.bindPopup('Entregador');
                bounds.push([trackingData.latitude_atual, trackingData.longitude_atual]);
            }
            
            // Ajustar zoom para mostrar todos os marcadores
            if (bounds.length > 0) {
                map.fitBounds(bounds, { padding: [20, 20] });
            }
        }
        
        function updateTrackingData() {
            fetch('<?= $baseUri ?>/entrega-tracking/track-api/' + trackingCode + '/')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Atualizar posição do entregador no mapa
                        if (data.tracking.posicao_atual) {
                            updateEntregadorPosition(data.tracking.posicao_atual.lat, data.tracking.posicao_atual.lng);
                        }
                        
                        // Verificar se o status mudou
                        if (data.tracking.status !== trackingData.status_tracking) {
                            // Recarregar página se status mudou
                            location.reload();
                        }
                        
                        // Atualizar tempo estimado se disponível
                        if (data.tracking.tempo_estimado) {
                            updateETA(data.tracking.tempo_estimado);
                        }
                    }
                })
                .catch(error => {
                    console.error('Erro ao atualizar tracking:', error);
                });
        }
        
        let entregadorMarker = null;
        
        function updateEntregadorPosition(lat, lng) {
            if (entregadorMarker) {
                map.removeLayer(entregadorMarker);
            }
            
            entregadorMarker = L.marker([lat, lng], {
                icon: L.divIcon({
                    html: '<i class="fas fa-motorcycle" style="color: #667eea; font-size: 20px;"></i>',
                    iconSize: [30, 30],
                    className: 'custom-div-icon'
                })
            }).addTo(map);
            entregadorMarker.bindPopup('Entregador');
        }
        
        function updateETA(minutes) {
            const etaElement = document.getElementById('eta-countdown');
            if (etaElement) {
                etaElement.textContent = minutes + ' min';
            }
        }
        
        // Inicializar quando a página carregar
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
            
            // Atualizar dados periodicamente
            setInterval(updateTrackingData, updateInterval);
        });
        
        // Notificações do navegador (se suportado)
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }
        
        // Verificar mudanças de status para notificar
        let lastStatus = '<?= $data['tracking']->status_tracking ?>';
        setInterval(function() {
            fetch('<?= $baseUri ?>/entrega-tracking/track-api/' + trackingCode + '/')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.tracking.status !== lastStatus) {
                        if ('Notification' in window && Notification.permission === 'granted') {
                            new Notification('Status do Pedido Atualizado', {
                                body: 'Seu pedido: ' + data.tracking.status_description,
                                icon: '/favicon.ico'
                            });
                        }
                        lastStatus = data.tracking.status;
                    }
                })
                .catch(error => console.error('Erro:', error));
        }, 30000); // Verificar a cada 30 segundos
    </script>
</body>
</html>