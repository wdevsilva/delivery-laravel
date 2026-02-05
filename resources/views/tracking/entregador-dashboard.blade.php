<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>Painel Entregador - <?= $data['entregador']->entregador_nome ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            -webkit-text-size-adjust: 100%;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            overflow-x: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            min-height: 60px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .header h1 {
            font-size: 1.2rem;
        }

        .status-indicator {
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .status-online {
            background: #4CAF50;
            color: white;
        }

        .status-offline {
            background: #f44336;
            color: white;
        }

        .container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .stat-card i {
            font-size: 2rem;
            color: #667eea;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
        }

        .stat-label {
            color: #777;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        .map-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .map-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        #map {
            height: 350px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        #map.navigation-mode {
            border: 3px solid #28a745;
            box-shadow: 0 0 20px rgba(40, 167, 69, 0.5);
        }
        
        .compass-overlay {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .compass-needle {
            width: 30px;
            height: 30px;
            font-size: 24px;
            color: #dc3545;
            transition: transform 0.5s ease;
        }
        
        .navigation-info {
            position: absolute;
            bottom: 10px;
            left: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 10px;
            border-radius: 10px;
            font-size: 14px;
            z-index: 1000;
            display: none;
        }
        
        .navigation-info.active {
            display: block;
        }

        .pedidos-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .pedido-card {
            border: 1px solid #e1e1e1;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s;
        }

        .pedido-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .pedido-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .pedido-numero {
            font-weight: 700;
            color: #333;
        }

        .pedido-status {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-aguardando { background: #fff3cd; color: #856404; }
        .status-coletado { background: #cce5ff; color: #004085; }
        .status-em_rota { background: #d4edda; color: #155724; }
        .status-chegou_destino { background: #f8d7da; color: #721c24; }

        .pedido-endereco {
            color: #666;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .pedido-endereco i {
            margin-right: 8px;
            color: #667eea;
        }

        .pedido-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s;
            font-size: 14px;
            min-height: 44px;
            min-width: 44px;
            justify-content: center;
            touch-action: manipulation;
            -webkit-tap-highlight-color: transparent;
        }

        .btn-primary { background: #667eea; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-warning { background: #ffc107; color: #212529; }
        .btn-danger { background: #dc3545; color: white; }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .location-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            transition: all 0.3s;
        }

        .location-toggle:hover {
            transform: scale(1.1);
        }

        .location-toggle.active {
            background: #28a745;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
            100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
        }
        
        @keyframes pulse-green {
            0% { 
                box-shadow: 0 3px 10px rgba(40, 167, 69, 0.3); 
                transform: scale(1);
            }
            50% { 
                box-shadow: 0 3px 15px rgba(40, 167, 69, 0.6); 
                transform: scale(1.05);
            }
            100% { 
                box-shadow: 0 3px 10px rgba(40, 167, 69, 0.3); 
                transform: scale(1);
            }
        }
        
        .custom-motorista-marker {
            z-index: 1000 !important;
        }
        
        #map {
            transition: transform 1s ease, border 0.3s ease;
            position: relative; /* necessário para posicionar botão dentro do mapa */
        }
        
        #map.modo-navegacao {
            border: 3px solid #28a745;
            border-radius: 15px;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #777;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #ccc;
        }
        
        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 90vw;
        }
        
        .toast {
            background: #28a745;
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 300px;
            animation: slideInRight 0.3s ease-out;
            position: relative;
        }
        
        .toast.success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        
        .toast.warning {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            color: #212529;
        }
        
        .toast.error {
            background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
        }
        
        .toast .toast-icon {
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        
        .toast .toast-content {
            flex: 1;
        }
        
        .toast .toast-title {
            font-weight: 600;
            margin-bottom: 3px;
        }
        
        .toast .toast-message {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .toast .toast-close {
            background: none;
            border: none;
            color: inherit;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.2s;
        }
        
        .toast .toast-close:hover {
            background: rgba(255,255,255,0.2);
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        /* Fallback para painel em 'fullscreen' quando Fullscreen API não estiver disponível */
        .painel-fullscreen {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100% !important;
            height: 100% !important;
            margin: 0 !important;
            border-radius: 0 !important;
            z-index: 99999 !important;
            overflow: auto !important;
            padding: 20px !important;
        }

        /* Fallback visual para colocar o mapa em tela cheia */
        .map-fullscreen {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100% !important;
            height: 100% !important;
            margin: 0 !important;
            border-radius: 0 !important;
            z-index: 99998 !important;
            box-shadow: none !important;
        }

        /* Botão flutuante para sair do fullscreen do mapa (dentro do container #map) */
        .map-exit-fullscreen-btn {
            position: absolute; /* posicionado relativo ao #map */
            top: 10px;
            right: 10px;
            z-index: 100005 !important;
            background: rgba(0,0,0,0.7);
            color: white;
            border: none;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(0,0,0,0.45);
            touch-action: manipulation;
        }

        @media (max-width: 768px) {
            body {
                font-size: 14px;
            }
            
            .header {
                padding: 10px;
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
            
            .header h1 {
                font-size: 1rem;
            }
            
            .container {
                padding: 10px;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
                margin-bottom: 20px;
            }
            
            .stat-card {
                padding: 15px;
            }
            
            .stat-card i {
                font-size: 1.5rem;
            }
            
            .stat-number {
                font-size: 1.2rem;
            }
            
            .map-container {
                padding: 10px;
                margin-bottom: 20px;
            }
            
            .map-header {
                flex-direction: column;
                gap: 10px;
                align-items: stretch;
            }
            
            .map-header > div {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 5px;
            }
            
            #map {
                height: 250px;
            }
            
            .pedidos-container {
                padding: 10px;
            }
            
            .pedido-card {
                padding: 10px;
                margin-bottom: 10px;
            }
            
            .pedido-header {
                flex-direction: column;
                gap: 5px;
                align-items: flex-start;
            }
            
            .pedido-actions {
                flex-direction: column;
                gap: 8px;
            }
            
            .btn {
                justify-content: center;
                padding: 10px 15px;
                font-size: 13px;
            }
            
            .toast-container {
                top: 10px;
                right: 10px;
                left: 10px;
            }
            
            .toast {
                min-width: auto;
                width: 100%;
            }
            
            .location-toggle {
                bottom: 80px;
                right: 15px;
                width: 50px;
                height: 50px;
                font-size: 1.2rem;
            }
            
            .device-info {
                display: none;
            }
            
            /* Painel de navegação responsivo */
            #painel-navegacao {
                top: 60px !important;
                left: 10px !important;
                right: 10px !important;
                padding: 10px !important;
                font-size: 12px !important;
            }
            
            /* Modal responsivo */
            #modal-rota-otimizada > div {
                margin: 10px !important;
                padding: 15px !important;
                max-height: 90vh !important;
            }
            
            /* Aviso de desvio responsivo */
            #aviso-desvio {
                left: 10px !important;
                right: 10px !important;
                transform: translateY(-50%) !important;
                max-width: none !important;
            }
        }
        
        @media (max-width: 480px) {
            .header h1 {
                font-size: 0.9rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .map-header > div {
                grid-template-columns: 1fr;
            }
            
            #map {
                height: 200px;
            }
            
            .btn {
                padding: 12px 15px;
                font-size: 12px;
            }
            
            .pedido-card {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>
            <i class="fas fa-motorcycle"></i>
            Olá, <?= $data['entregador']->entregador_nome ?>
        </h1>
        <div style="display: flex; align-items: center; gap: 15px;">
            <div class="status-indicator" id="status-indicator">
                <i class="fas fa-circle"></i> Offline
            </div>
            <div class="location-status" id="location-status" style="padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: 600; background: #f44336; color: white;">
                <i class="fas fa-map-marker-alt"></i> GPS Inativo
            </div>
            <div class="device-info" id="device-info" style="font-size: 12px; color: #666; margin-right: 10px;">
                <i class="fas fa-info-circle"></i> <span id="device-type">Detectando...</span>
            </div>
            <a href="<?= $baseUri ?>/entrega-tracking/entregador-logout/" 
               class="btn btn-danger btn-sm" 
               onclick="return confirm('Tem certeza que deseja sair?')" 
               style="background: #dc3545; color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; font-size: 14px;">
                <i class="fas fa-sign-out-alt"></i> Sair
            </a>
        </div>
    </div>

    <div class="container">
        <!-- Estatísticas -->
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-box"></i>
                <div class="stat-number" id="pedidos-ativos"><?= $data['pedidos'] ? count($data['pedidos']) : 0 ?></div>
                <div class="stat-label">Pedidos Ativos</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-clock"></i>
                <div class="stat-number" id="tempo-online">00:00</div>
                <div class="stat-label">Tempo Online</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-route"></i>
                <div class="stat-number" id="distancia-percorrida">0 km</div>
                <div class="stat-label">Distância Hoje</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-money-bill-wave"></i>
                <div class="stat-number">R$ 0,00</div>
                <div class="stat-label">Ganhos Hoje</div>
            </div>
        </div>

        <!-- Mapa -->
        <div class="map-container">
            <div class="map-header">
                <h3><i class="fas fa-map-marker-alt"></i> Mapa de Entregas</h3>
                <div style="display: flex; gap: 10px;">
                    <button class="btn btn-primary" onclick="otimizarRota()">
                        <i class="fas fa-route"></i> Otimizar Rota
                    </button>
                    <button class="btn btn-success" onclick="tentarRestaurarRota()" title="Restaurar rota salva">
                        <i class="fas fa-redo"></i> Restaurar Rota
                    </button>
                    <button class="btn btn-primary" onclick="solicitarPermissaoManual()" title="Solicitar permissão de localização" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; box-shadow: 0 3px 10px rgba(40, 167, 69, 0.3); animation: pulse-green 2s infinite;">
                        <i class="fas fa-map-marker-alt"></i> Ativar GPS
                    </button>
                    <button class="btn btn-warning" onclick="centerMapOnUser()">
                        <i class="fas fa-location-arrow"></i> Minha Localização
                    </button>
                    <button class="btn" onclick="toggleMapFullscreen()" id="map-fullscreen-btn" title="Abrir mapa em tela cheia" style="background: #6c757d; color: white;">
                        <i class="fas fa-expand"></i> Mapa Tela Cheia
                    </button>
                    <!-- botão 'Testar APIs' removido -->
                    <button class="btn btn-success" onclick="toggleNavigationMode()" id="nav-mode-btn" title="Alternar modo navegação">
                        <i class="fas fa-compass"></i> Navegação
                    </button>
                </div>
            </div>
            <div id="map"></div>
            
            <!-- Compass Overlay -->
            <div class="compass-overlay" id="compass-overlay" style="display: none;">
                <i class="fas fa-location-arrow compass-needle" id="compass-needle"></i>
            </div>
            
            <!-- Navigation Info -->
            <div class="navigation-info" id="navigation-info">
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <!-- Current Instruction -->
                    <div style="display: flex; align-items: center; gap: 15px; background: rgba(255,255,255,0.1); padding: 10px; border-radius: 8px;">
                        <div id="maneuver-icon" style="font-size: 24px; color: #28a745; min-width: 30px;">→</div>
                        <div style="flex: 1;">
                            <div id="current-instruction" style="font-weight: bold; font-size: 16px;">Iniciando navegação...</div>
                            <div id="instruction-distance" style="font-size: 12px; opacity: 0.8;">--</div>
                        </div>
                        <div style="text-align: right;">
                            <div id="nav-distance" style="font-size: 18px; font-weight: bold;">--</div>
                            <div id="nav-eta" style="font-size: 12px; opacity: 0.8;">--</div>
                        </div>
                    </div>
                    
                    <!-- Next Instruction Preview -->
                    <div id="next-instruction-preview" style="display: none; align-items: center; gap: 10px; padding: 8px; background: rgba(255,255,255,0.05); border-radius: 5px; font-size: 12px;">
                        <div id="next-maneuver-icon" style="font-size: 16px; opacity: 0.7;">→</div>
                        <div id="next-instruction" style="opacity: 0.8;">Próxima: ...</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Pedidos -->
        <div class="pedidos-container">
            <h3><i class="fas fa-list"></i> Seus Pedidos</h3>
            
            <?php if ($data['pedidos']): ?>
                <?php foreach ($data['pedidos'] as $pedido): ?>
                    <div class="pedido-card" data-pedido-id="<?= $pedido->pedido_id ?>" data-dest-lat="<?= $pedido->latitude_destino ?>" data-dest-lng="<?= $pedido->longitude_destino ?>">
                        <div class="pedido-header">
                            <div class="pedido-numero">
                                Pedido #<?= $pedido->pedido_numero_entrega ?>
                            </div>
                            <div class="pedido-status status-<?= $pedido->status_tracking ?>">
                                <?= ucfirst(str_replace('_', ' ', $pedido->status_tracking)) ?>
                            </div>
                        </div>
                        
                        <div class="pedido-endereco">
                            <i class="fas fa-map-marker-alt"></i>
                            <?= $pedido->endereco_endereco ?>, <?= $pedido->endereco_numero ?> - <?= $pedido->endereco_bairro ?>
                            <?php if ($pedido->endereco_complemento): ?>
                                <br><small><?= $pedido->endereco_complemento ?></small>
                            <?php endif; ?>
                        </div>

                        <?php if ($pedido->endereco_referencia): ?>
                            <div style="color: #888; font-size: 14px; margin-bottom: 10px;">
                                <i class="fas fa-info-circle"></i> Referência: <?= $pedido->endereco_referencia ?>
                            </div>
                        <?php endif; ?>

                        <div class="pedido-actions">
                            <?php if ($pedido->status_tracking == 'aguardando_entregador'): ?>
                                <button class="btn btn-success" onclick="coletarPedido(<?= $pedido->pedido_id ?>)">
                                    <i class="fas fa-check"></i> Coletar Pedido
                                </button>
                            <?php endif; ?>

                            <?php if ($pedido->status_tracking == 'coletado'): ?>
                                <button class="btn btn-primary" onclick="iniciarRotaCompleta(<?= $pedido->pedido_id ?>, <?= $pedido->latitude_destino ?>, <?= $pedido->longitude_destino ?>, this)">
                                    <i class="fas fa-route"></i> Iniciar Rota
                                </button>
                            <?php endif; ?>

                            <?php if ($pedido->status_tracking == 'em_rota'): ?>
                                <button class="btn btn-warning" onclick="chegouDestino(<?= $pedido->pedido_id ?>)">
                                    <i class="fas fa-flag-checkered"></i> Cheguei
                                </button>
                            <?php endif; ?>

                            <?php if ($pedido->status_tracking == 'chegou_destino'): ?>
                                <button class="btn btn-success" onclick="confirmarEntrega(<?= $pedido->pedido_id ?>)">
                                    <i class="fas fa-handshake"></i> Entregar
                                </button>
                            <?php endif; ?>



                            <button class="btn btn-info" onclick="verRotaInterna(<?= $pedido->latitude_destino ?>, <?= $pedido->longitude_destino ?>, <?= $pedido->pedido_id ?>)">
                                <i class="fas fa-directions"></i> Ver Rota
                            </button>

                            <a href="tel:<?= $pedido->cliente_fone2 ?>" class="btn btn-warning">
                                <i class="fas fa-phone"></i> Ligar
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>Nenhum pedido ativo</h3>
                    <p>Aguarde novos pedidos chegarem!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Botão de toggle da localização -->
    <button class="location-toggle" id="location-toggle" onclick="toggleTracking()">
        <i class="fas fa-location-arrow"></i>
    </button>

    <!-- Menu de ações rápidas -->
    <div style="position: fixed; bottom: 20px; left: 20px; display: flex; flex-direction: column; gap: 10px;">
        <button onclick="showQuickMenu()" 
                style="background: #28a745; color: white; border: none; border-radius: 50%; width: 50px; height: 50px; cursor: pointer; box-shadow: 0 3px 10px rgba(0,0,0,0.3);">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Menu rápido (oculto por padrão) -->
    <div id="quickMenu" style="position: fixed; bottom: 80px; left: 20px; background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); padding: 10px; display: none; z-index: 1000;">
        <div style="display: flex; flex-direction: column; gap: 8px; min-width: 120px;">
            <a href="<?= $baseUri ?>/entrega-tracking/entregador-logout/" 
               onclick="return confirm('Tem certeza que deseja sair?')" 
               style="display: flex; align-items: center; gap: 8px; padding: 8px 12px; text-decoration: none; color: #dc3545; border: 1px solid #dc3545; border-radius: 5px; transition: all 0.3s;">
                <i class="fas fa-sign-out-alt"></i> Sair
            </a>
            <a href="<?= $baseUri ?>/entrega-tracking/test/" 
               target="_blank" 
               style="display: flex; align-items: center; gap: 8px; padding: 8px 12px; text-decoration: none; color: #007bff; border: 1px solid #007bff; border-radius: 5px; transition: all 0.3s;">
                <i class="fas fa-cog"></i> Teste
            </a>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toast-container"></div>

    <!-- Scripts -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <script>
        let map;
        let userMarker;
        let trackingEnabled = false;
        let watchId = null;
        let startTime = new Date();
        let routeControl = null;
        let pedidoMarkers = [];
        let currentRoutes = [];
        let navegacaoAtiva = false;
        let ultimaDirecao = 0;
        let modoNavegacao = false;
        let rotaAtiva = null;
        let destinoAtivo = null;
        let distanciaMaximaDesvio = 100; // metros
        let contadorDesvios = 0;
        let ultimoRecalculo = 0;
        let compassEnabled = false;
        let currentHeading = 0;
        let currentStep = 0;
        let routeInstructions = [];
        let nextManeuver = null;
        let speechSynthesis = null;
        const entregadorId = <?= $data['entregador']->entregador_id ?>;
        const updateInterval = <?= $data['config']['intervalo_atualizacao_entregador'] ?? 30 ?> * 1000;
        
        // ===== SISTEMA DE PERSISTÊNCIA DE ROTA =====
        
        /**
         * Salvar rota ativa no localStorage
         */
        function salvarRotaAtiva(pedidoId, routeData) {
            const rotaParaSalvar = {
                pedidoId: pedidoId,
                route: routeData.route,
                instructions: routeData.instructions || [],
                distance: routeData.distance,
                duration: routeData.duration,
                method: routeData.method,
                timestamp: Date.now(),
                destinoAtivo: destinoAtivo,
                posicaoOrigem: {
                    lat: routeData.route[0][0],
                    lng: routeData.route[0][1]
                },
                posicaoDestino: {
                    lat: routeData.route[routeData.route.length - 1][0],
                    lng: routeData.route[routeData.route.length - 1][1]
                }
            };
            
            localStorage.setItem('rotaAtiva_entregador_' + entregadorId, JSON.stringify(rotaParaSalvar));
            console.log('💾 Rota salva no localStorage:', rotaParaSalvar);
        }
        
        /**
         * Carregar rota ativa do localStorage
         */
        function carregarRotaAtiva() {
            const rotaSalva = localStorage.getItem('rotaAtiva_entregador_' + entregadorId);
            
            if (rotaSalva) {
                try {
                    const dadosRota = JSON.parse(rotaSalva);
                    const agora = Date.now();
                    const tempoDecorrido = agora - dadosRota.timestamp;
                    
                    console.log('🔍 Verificando rota salva:', dadosRota);
                    
                    // Verificar se a rota não é muito antiga (24 horas)
                    if (tempoDecorrido < 24 * 60 * 60 * 1000) {
                        console.log('🔄 Tentando restaurar rota salva...');
                        
                        // Verificar se o pedido ainda está em rota
                        const pedidoCard = document.querySelector(`[data-pedido-id="${dadosRota.pedidoId}"]`);
                        if (pedidoCard) {
                            const statusBadge = pedidoCard.querySelector('.pedido-status');
                            const isEmRota = statusBadge && (
                                statusBadge.textContent.toLowerCase().includes('em rota') ||
                                statusBadge.textContent.toLowerCase().includes('rota') ||
                                statusBadge.className.includes('em_rota')
                            );
                            
                            console.log('📝 Status do pedido:', statusBadge ? statusBadge.textContent : 'Não encontrado', 'Em rota:', isEmRota);
                            
                            if (isEmRota) {
                                console.log('✅ Pedido ainda está em rota, restaurando...');
                                
                                // Restaurar variáveis globais
                                rotaAtiva = dadosRota.route;
                                destinoAtivo = dadosRota.destinoAtivo;
                                
                                // Aguardar mapa estar pronto e redesenhar rota
                                setTimeout(() => {
                                    if (map) {
                                        console.log('🗺️ Redesenhando rota no mapa...');
                                        
                                        // Limpar rotas anteriores
                                        limparRotasAnteriores();
                                        
                                        // Redesenhar rota no mapa
                                        desenharRotaNoMapa(
                                            dadosRota.posicaoOrigem,
                                            dadosRota.posicaoDestino,
                                            dadosRota.route,
                                            dadosRota.instructions || []
                                        );
                                        
                                        // Mostrar resultado da rota
                                        mostrarResultadoRota(dadosRota, dadosRota.pedidoId);
                                        
                                        // Centralizar mapa na rota
                                        centralizarMapaNaRota(dadosRota.posicaoOrigem, dadosRota.posicaoDestino);
                                        
                                        // Mostrar toast informativo
                                        showToast(
                                            '🔄 Rota Restaurada',
                                            `Rota de ${dadosRota.distance} recuperada após atualização da página`,
                                            'info',
                                            4000
                                        );
                                        
                                        console.log('✅ Rota restaurada com sucesso!');
                                    } else {
                                        console.error('❌ Mapa não está pronto ainda');
                                    }
                                }, 2000); // Aguardar 2 segundos para garantir que o mapa esteja pronto
                                
                                return true;
                            } else {
                                console.log('🗑️ Pedido não está mais em rota, limpando rota salva');
                                limparRotaSalva();
                            }
                        } else {
                            console.log('🗑️ Pedido não encontrado, limpando rota salva');
                            limparRotaSalva();
                        }
                    } else {
                        console.log('🕰️ Rota salva muito antiga (>24h), removendo');
                        limparRotaSalva();
                    }
                } catch (error) {
                    console.error('❌ Erro ao carregar rota salva:', error);
                    limparRotaSalva();
                }
            } else {
                console.log('📄 Nenhuma rota salva encontrada');
            }
            
            return false;
        }
        
        /**
         * Limpar rota salva do localStorage
         */
        function limparRotaSalva() {
            localStorage.removeItem('rotaAtiva_entregador_' + entregadorId);
            console.log('🧹 Rota salva removida do localStorage');
        }
        
        /**
         * Tentar restaurar rota manualmente (botão)
         */
        function tentarRestaurarRota() {
            console.log('🔄 Tentativa manual de restaurar rota...');
            
            const resultado = carregarRotaAtiva();
            
            if (!resultado) {
                // Se não encontrou rota salva, verificar se há pedidos em rota e oferecer opções
                const pedidosEmRota = document.querySelectorAll('[data-pedido-id]');
                let pedidoEmRota = null;
                
                pedidosEmRota.forEach(card => {
                    const statusBadge = card.querySelector('.pedido-status');
                    if (statusBadge && (
                        statusBadge.textContent.toLowerCase().includes('em rota') ||
                        statusBadge.textContent.toLowerCase().includes('rota') ||
                        statusBadge.className.includes('em_rota')
                    )) {
                        pedidoEmRota = card;
                    }
                });
                
                if (pedidoEmRota) {
                    const pedidoId = pedidoEmRota.getAttribute('data-pedido-id');
                    const lat = pedidoEmRota.getAttribute('data-dest-lat');
                    const lng = pedidoEmRota.getAttribute('data-dest-lng');
                    
                    if (lat && lng) {
                        showToast(
                            '🔄 Recriando Rota',
                            'Rota não encontrada no cache. Recalculando rota para o pedido em andamento...',
                            'info',
                            3000
                        );
                        
                        // Recriar a rota
                        setTimeout(() => {
                            calcularRotaSilenciosa(parseFloat(lat), parseFloat(lng), parseInt(pedidoId));
                        }, 1000);
                    } else {
                        showToast('❌ Erro', 'Coordenadas do pedido não encontradas', 'error');
                    }
                } else {
                    showToast('📄 Nenhuma Rota', 'Nenhum pedido em rota encontrado para restaurar', 'warning');
                }
            }
        }
        function limparRotaAoFinalizar(pedidoId) {
            const rotaSalva = localStorage.getItem('rotaAtiva_entregador_' + entregadorId);
            if (rotaSalva) {
                try {
                    const dadosRota = JSON.parse(rotaSalva);
                    if (dadosRota.pedidoId == pedidoId) {
                        limparRotaSalva();
                        // Limpar variáveis globais
                        rotaAtiva = null;
                        destinoAtivo = null;
                        // Limpar rota do mapa
                        limparRotasAnteriores();
                    }
                } catch (error) {
                    console.error('Erro ao limpar rota finalizada:', error);
                }
            }
        }
        
        /**
         * Mostrar toast notification personalizado
         */
        function showToast(title, message, type = 'success', duration = 5000) {
            const container = document.getElementById('toast-container');
            const toastId = 'toast-' + Date.now();
            
            const icons = {
                success: 'fas fa-check-circle',
                warning: 'fas fa-exclamation-triangle', 
                error: 'fas fa-times-circle',
                info: 'fas fa-info-circle'
            };
            
            const toast = document.createElement('div');
            toast.id = toastId;
            toast.className = `toast ${type}`;
            toast.innerHTML = `
                <i class="toast-icon ${icons[type] || icons.success}"></i>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <button class="toast-close" onclick="closeToast('${toastId}')">&times;</button>
            `;
            
            container.appendChild(toast);
            
            // Auto close
            if (duration > 0) {
                setTimeout(() => {
                    closeToast(toastId);
                }, duration);
            }
            
            return toastId;
        }
        
        /**
         * Fechar toast
         */
        function closeToast(toastId) {
            const toast = document.getElementById(toastId);
            if (toast) {
                toast.style.animation = 'slideOutRight 0.3s ease-in forwards';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }
        }

        // Inicializar mapa
        function initMap() {
            map = L.map('map').setView([-23.5505, -46.6333], 13); // São Paulo como padrão

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Solicitar permissão de localização proativamente
            solicitarPermissaoLocalizacao();

            // Adicionar marcadores dos pedidos
            addPedidoMarkers();
        }
        
        /**
         * Solicitar permissão de localização proativamente (otimizado para mobile)
         */
        function solicitarPermissaoLocalizacao() {
            if (!navigator.geolocation) {
                console.log('❌ Geolocalização não suportada');
                showToast(
                    '❌ Localização Não Suportada',
                    'Seu navegador não suporta geolocalização. Atualize seu navegador ou use outro dispositivo.',
                    'error',
                    8000
                );
                return;
            }
            
            const isMobile = /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            
            console.log('📱 Solicitação proativa de permissão - Dispositivo:', isMobile ? 'Móvel' : 'Desktop');
            
            // Verificar se já temos permissão usando Permissions API (se disponível)
            if (navigator.permissions) {
                navigator.permissions.query({name: 'geolocation'})
                    .then(result => {
                        console.log('🔍 Status da permissão:', result.state);
                        
                        if (result.state === 'granted') {
                            // Já temos permissão - obter localização
                            obterLocalizacaoInicial();
                        } else if (result.state === 'denied') {
                            // Permissão negada anteriormente
                            mostrarAvisoPermissaoNegada(isMobile);
                        } else {
                            // Permissão será solicitada - mostrar orientação
                            mostrarOrientacaoPermissao(isMobile);
                            setTimeout(() => {
                                obterLocalizacaoInicial();
                            }, 3000); // Aumentado de 2s para 3s
                        }
                    })
                    .catch(error => {
                        console.warn('🔍 Permissions API não suportada, tentando diretamente');
                        mostrarOrientacaoPermissao(isMobile);
                        setTimeout(() => {
                            obterLocalizacaoInicial();
                        }, 3000);
                    });
            } else {
                // Fallback para navegadores sem Permissions API
                console.log('📱 Tentando obter localização diretamente (sem Permissions API)');
                mostrarOrientacaoPermissao(isMobile);
                setTimeout(() => {
                    obterLocalizacaoInicial();
                }, 3000);
            }
        }
        
        /**
         * Mostrar orientação antes de solicitar permissão
         */
        function mostrarOrientacaoPermissao(isMobile) {
            const titulo = '📍 Ativando Localização';
            let mensagem;
            
            if (isMobile) {
                mensagem = 'Para usar o rastreamento de entregas, vamos solicitar acesso à sua localização.\n\n' +
                          '📱 IMPORTANTE: Quando aparecer a pergunta, toque em "Permitir" ou "Allow".\n\n' +
                          '⚠️ Se negar, você precisará reativar manualmente nas configurações do navegador.';
            } else {
                mensagem = 'Para usar o rastreamento, vamos solicitar acesso à sua localização.\n\n' +
                          '🖥️ IMPORTANTE: Quando aparecer a pergunta, clique em "Permitir" ou "Allow".\n\n' +
                          '💡 Para melhor precisão, use um dispositivo móvel.';
            }
            
            showToast(titulo, mensagem, 'info', 7000);
        }
        
        /**
         * Mostrar aviso quando permissão foi negada anteriormente
         */
        function mostrarAvisoPermissaoNegada(isMobile) {
            const titulo = '🚫 Localização Bloqueada';
            let mensagem;
            
            if (isMobile) {
                mensagem = '⚠️ A localização foi bloqueada anteriormente.\n\n' +
                          '🔓 Para DESBLOQUEAR no celular:\n\n' +
                          '📱 Chrome/Edge:\n' +
                          '1. Toque no ícone de CADEADO na barra de endereços\n' +
                          '2. Toque em "Localização"\n' +
                          '3. Selecione "Permitir"\n\n' +
                          '📱 Safari:\n' +
                          '1. Configurações > Safari > Localização\n' +
                          '2. Selecione "Perguntar" ou "Permitir"\n\n' +
                          '🔄 Ou use o botão "Ativar GPS" acima';
            } else {
                mensagem = '⚠️ A localização foi bloqueada anteriormente.\n\n' +
                          '🔓 Para DESBLOQUEAR no computador:\n\n' +
                          '🖥️ Chrome/Edge:\n' +
                          '1. Clique no ícone de LOCALIZAÇÃO na barra de endereços\n' +
                          '2. Selecione "Sempre permitir localização"\n\n' +
                          '🖥️ Firefox:\n' +
                          '1. Clique no ESCUDO na barra de endereços\n' +
                          '2. Altere as configurações de localização\n\n' +
                          '🔄 Ou use o botão "Ativar GPS"';
            }
            
            showToast(titulo, mensagem, 'warning', 15000);
        }
        
        /**
         * Obter localização inicial com tratamento robusto
         */
        function obterLocalizacaoInicial() {
            atualizarStatusLocalizacao('solicitando', 'Solicitando acesso à localização...');
            
            obterLocalizacaoAtual()
                .then(position => {
                    onLocalizacaoSucesso(position);
                })
                .catch(error => {
                    onLocalizacaoErro(error);
                });
        }
        
        /**
         * Atualizar status de localização na interface
         */
        function atualizarStatusLocalizacao(status, mensagem = '') {
            const locationStatus = document.getElementById('location-status');
            if (!locationStatus) return;
            
            let backgroundColor, texto, icone;
            
            switch(status) {
                case 'ativo':
                    backgroundColor = '#28a745';
                    texto = 'GPS Ativo';
                    icone = 'fas fa-map-marker-alt';
                    break;
                case 'negado':
                    backgroundColor = '#dc3545';
                    texto = 'GPS Bloqueado';
                    icone = 'fas fa-times-circle';
                    break;
                case 'solicitando':
                    backgroundColor = '#ffc107';
                    texto = 'Solicitando GPS';
                    icone = 'fas fa-spinner fa-spin';
                    break;
                default:
                    backgroundColor = '#6c757d';
                    texto = 'GPS Inativo';
                    icone = 'fas fa-map-marker-alt';
            }
            
            locationStatus.style.background = backgroundColor;
            locationStatus.innerHTML = `<i class="${icone}"></i> ${texto}`;
            
            if (mensagem) {
                locationStatus.title = mensagem;
            }
        }
        
        /**
         * Callback de sucesso para localização
         */
        function onLocalizacaoSucesso(position) {
            console.log('✅ Localização obtida com sucesso:', position);
            
            atualizarStatusLocalizacao('ativo', `Localização ativa - Precisão: ${Math.round(position.accuracy)}m`);
            
            map.setView([position.lat, position.lng], 15);
            updateUserMarker(position.lat, position.lng);
            
            const isMobile = /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            
            showToast(
                '✅ Localização Ativada!',
                isMobile ? 
                    '📱 Rastreamento pronto! Você pode iniciar rotas de entrega.' :
                    '🖥️ Localização obtida (use um celular para melhor precisão)',
                'success',
                4000
            );
            
            // Após obter localização, tentar carregar rota salva
            setTimeout(() => {
                carregarRotaAtiva();
            }, 1000);
        }
        
        /**
         * Callback de erro para localização
         */
        function onLocalizacaoErro(error) {
            console.error('❌ Erro ao obter localização inicial:', error);
            
            if (error.message.includes('negada')) {
                atualizarStatusLocalizacao('negado', 'Permissão de localização foi negada');
            } else {
                atualizarStatusLocalizacao('inativo', `Erro: ${error.message}`);
            }
            
            // Tentar carregar rota salva mesmo sem localização
            setTimeout(() => {
                carregarRotaAtiva();
            }, 1000);
        }

        function updateUserMarker(lat, lng) {
            if (userMarker) {
                map.removeLayer(userMarker);
            }

            // Criar marcador com seta de direção se em modo navegação
            let markerIcon;
            if (modoNavegacao) {
                markerIcon = L.divIcon({
                    html: `<div style="transform: rotate(${currentHeading}deg); font-size: 24px; color: #28a745;"><i class="fas fa-location-arrow"></i></div>`,
                    iconSize: [30, 30],
                    className: 'custom-div-icon navigation-marker'
                });
            } else {
                markerIcon = L.divIcon({
                    html: '<i class="fas fa-motorcycle" style="color: #667eea; font-size: 20px;"></i>',
                    iconSize: [30, 30],
                    className: 'custom-div-icon'
                });
            }

            userMarker = L.marker([lat, lng], {
                icon: markerIcon
            }).addTo(map);

            userMarker.bindPopup('Sua localização').openPopup();
            
            // Se em modo navegação, manter o usuário centralizado
            if (modoNavegacao) {
                map.setView([lat, lng], 17);
            }
        }

        function addPedidoMarkers() {
            <?php if ($data['pedidos']): ?>
                <?php foreach ($data['pedidos'] as $pedido): ?>
                    <?php if ($pedido->latitude_destino && $pedido->longitude_destino): ?>
                        L.marker([<?= $pedido->latitude_destino ?>, <?= $pedido->longitude_destino ?>], {
                            icon: L.divIcon({
                                html: '<i class="fas fa-map-marker-alt" style="color: #dc3545; font-size: 20px;"></i>',
                                iconSize: [30, 30],
                                className: 'custom-div-icon'
                            })
                        }).addTo(map)
                        .bindPopup('Pedido #<?= $pedido->pedido_numero_entrega ?><br><?= $pedido->endereco_endereco ?>, <?= $pedido->endereco_numero ?>');
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        }

        function centerMapOnUser() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    map.setView([lat, lng], 15);
                    updateUserMarker(lat, lng);
                });
            }
        }

        function toggleTracking() {
            const button = document.getElementById('location-toggle');
            const indicator = document.getElementById('status-indicator');
            
            if (!trackingEnabled) {
                // Iniciar tracking
                if (navigator.geolocation) {
                    watchId = navigator.geolocation.watchPosition(
                        updatePosition,
                        handleLocationError,
                        {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        }
                    );
                    
                    trackingEnabled = true;
                    button.classList.add('active');
                    indicator.innerHTML = '<i class="fas fa-circle"></i> Online';
                    indicator.className = 'status-indicator status-online';
                    
                    // Iniciar timer
                    startTime = new Date();
                    updateTimer();
                    setInterval(updateTimer, 1000);
                } else {
                    alert('Geolocalização não suportada pelo navegador');
                }
            } else {
                // Parar tracking
                if (watchId) {
                    navigator.geolocation.clearWatch(watchId);
                    watchId = null;
                }
                
                trackingEnabled = false;
                button.classList.remove('active');
                indicator.innerHTML = '<i class="fas fa-circle"></i> Offline';
                indicator.className = 'status-indicator status-offline';
            }
        }

        function updatePosition(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const accuracy = position.coords.accuracy;
            const speed = position.coords.speed || 0;
            const heading = position.coords.heading || 0;

            // Debug: log location data
            console.log('📍 Posição obtida:', {
                lat: lat,
                lng: lng,
                accuracy: accuracy + 'm',
                speed: speed + 'm/s',
                isDesktop: !(/Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
            });

            // Atualizar marcador no mapa
            updateUserMarker(lat, lng);
            
            // Atualizar informações de navegação se ativo
            if (modoNavegacao && destinoAtivo) {
                updateNavigationInfo();
            }

            // Enviar posição para o servidor
            fetch('<?= $baseUri ?>/entrega-tracking/update-position/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    entregador_id: entregadorId,
                    latitude: lat,
                    longitude: lng,
                    velocidade: speed,
                    direcao: heading,
                    precisao_gps: accuracy,
                    status_entregador: 'disponivel'
                })
            })
            .then(response => {
                console.log('📡 Resposta do servidor:', response.status, response.statusText);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Servidor retornou resposta não-JSON');
                }
                return response.json();
            })
            .then(data => {
                console.log('✅ Resposta JSON:', data);
                if (!data.success) {
                    console.error('❌ Erro ao atualizar posição:', data.message);
                    // Se estiver no desktop, mostrar aviso amigável
                    if (!(/Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))) {
                        console.warn('💻 Você está testando no computador. Para melhor funcionamento, use um dispositivo móvel.');
                    }
                } else {
                    console.log('✅ Posição atualizada com sucesso!');
                }
            })
            .catch(error => {
                console.error('❌ Erro ao atualizar posição:', error.message);
                // Verificar se é erro de desktop
                if (!(/Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))) {
                    console.warn('💻 Detectado computador desktop. Erros de localização são normais. Use um celular para teste real.');
                }
            });
        }

        function handleLocationError(error) {
            console.error('❌ Erro de geolocalização:', error);
            
            // Detectar se é desktop
            const isDesktop = !(/Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent));
            
            let message = '';
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    message = isDesktop ? 
                        '🖥️ Permissão de localização negada. No computador, clique no ícone de localização na barra de endereços do navegador.' :
                        '📱 Permissão de localização negada. Permita o acesso nas configurações do navegador.';
                    break;
                case error.POSITION_UNAVAILABLE:
                    message = isDesktop ? 
                        '🖥️ Localização indisponível no computador. Use um dispositivo móvel para melhor precisão.' :
                        '📱 Localização indisponível. Verifique se o GPS está ativado.';
                    break;
                case error.TIMEOUT:
                    message = isDesktop ? 
                        '🖥️ Timeout na obtenção da localização (normal no computador).' :
                        '📱 Timeout na obtenção da localização. Tente novamente.';
                    break;
                default:
                    message = 'Erro desconhecido ao obter localização.';
            }
            
            console.warn(message);
            
            // No desktop, mostrar aviso menos alarmante
            if (isDesktop) {
                console.info('💡 DICA: Para teste real do sistema de rastreamento, acesse este endereço em um celular.');
            } else {
                alert(message);
            }
        }

        function updateTimer() {
            if (trackingEnabled) {
                const now = new Date();
                const diff = now - startTime;
                const hours = Math.floor(diff / 3600000);
                const minutes = Math.floor((diff % 3600000) / 60000);
                
                document.getElementById('tempo-online').textContent = 
                    String(hours).padStart(2, '0') + ':' + String(minutes).padStart(2, '0');
            }
        }

        // Funções de ação dos pedidos
        function coletarPedido(pedidoId) {
            updatePedidoStatus(pedidoId, 'coletado', 'Pedido coletado com sucesso!');
        }

        function iniciarRota(pedidoId) {
            updatePedidoStatus(pedidoId, 'em_rota', 'Rota iniciada!');
        }

        // Nova função consolidada que faz tudo
        async function iniciarRotaCompleta(pedidoId, destLat, destLng, buttonElement) {
            try {
                // Mostrar loading no botão
                const originalText = buttonElement.innerHTML;
                buttonElement.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Calculando rota...';
                buttonElement.disabled = true;
                
                console.log('🛣️ Iniciando rota completa para pedido:', pedidoId);
                
                // 1. Primeiro calcular a rota (sem alert para não bloquear)
                const rotaCalculada = await calcularRotaSilenciosa(destLat, destLng, pedidoId);
                
                if (rotaCalculada) {
                    console.log('✅ Rota calculada com sucesso');
                    
                    // Mostrar toast customizado em vez de alert
                    showToast(
                        '🛣️ Rota traçada no mapa!', 
                        `Distância: ${rotaCalculada.distance} • Tempo: ${rotaCalculada.duration}`,
                        'success',
                        4000
                    );
                    
                    // 2. Depois atualizar o status do pedido
                    updatePedidoStatus(pedidoId, 'em_rota', `🛣️ Rota iniciada! Distância: ${rotaCalculada.distance}, Tempo: ${rotaCalculada.duration}`);
                } else {
                    console.log('⚠️ Rota calculada com fallback');
                    
                    // Toast para rota simples
                    showToast(
                        '🛣️ Rota estimada traçada!', 
                        'Linha reta (APIs de roteamento indisponíveis)',
                        'warning',
                        4000
                    );
                    
                    // Mesmo com fallback, atualizar status
                    updatePedidoStatus(pedidoId, 'em_rota', '🛣️ Rota iniciada com linha reta (APIs indisponíveis)');
                }
                
            } catch (error) {
                console.error('❌ Erro ao iniciar rota completa:', error);
                
                // Em caso de erro na rota, ainda assim atualizar o status
                showToast('⚠️ Problema na Rota', 'Houve um problema ao calcular a rota, mas o status será atualizado.', 'warning');
                updatePedidoStatus(pedidoId, 'em_rota', 'Rota iniciada (cálculo com problemas)');
                
                // Restaurar botão
                buttonElement.innerHTML = '<i class="fas fa-route"></i> Iniciar Rota';
                buttonElement.disabled = false;
            }
        }
        
        /**
         * Calcular rota sem mostrar alerts (versão silenciosa para uso no iniciarRotaCompleta)
         */
        async function calcularRotaSilenciosa(destLat, destLng, pedidoId) {
            // Timeout geral de 30 segundos para toda a operação
            const timeoutPromise = new Promise((_, reject) => {
                setTimeout(() => reject(new Error('Timeout geral de 30 segundos')), 30000);
            });
            
            try {
                const resultado = await Promise.race([
                    calcularRotaInternaComTimeout(destLat, destLng, pedidoId),
                    timeoutPromise
                ]);
                
                return resultado;
                
            } catch (error) {
                console.error('❌ Erro ao calcular rota silenciosa:', error);
                
                // Em caso de timeout ou erro, usar rota simples como fallback
                const posicaoFallback = await obterLocalizacaoRapida();
                if (posicaoFallback) {
                    console.log('🛍️ Usando rota simples como fallback');
                    const rotaSimples = calcularRotaSimples(posicaoFallback, {lat: destLat, lng: destLng});
                    
                    // Salvar rota simples no localStorage
                    salvarRotaAtiva(pedidoId, rotaSimples);
                    
                    // Mostrar no mapa mesmo sendo simples
                    mostrarResultadoRota(rotaSimples, pedidoId);
                    desenharRotaNoMapa(posicaoFallback, {lat: destLat, lng: destLng}, rotaSimples.route, []);
                    centralizarMapaNaRota(posicaoFallback, {lat: destLat, lng: destLng});
                    
                    return rotaSimples;
                }
                
                return null;
            }
        }
        
        /**
         * Versão interna da calcularRotaSilenciosa
         */
        async function calcularRotaInternaComTimeout(destLat, destLng, pedidoId) {
            // Obter localização atual
            const posicaoAtual = await obterLocalizacaoAtual();
            if (!posicaoAtual) {
                console.error('❌ Não foi possível obter localização atual');
                return null;
            }

            console.log(`🛣️ Calculando rota de [${posicaoAtual.lat}, ${posicaoAtual.lng}] para [${destLat}, ${destLng}]`);
            
            // Tentar múltiplas APIs de roteamento
            const resultado = await calcularRotaMultiplasAPIs(posicaoAtual, {lat: destLat, lng: destLng});
            
            if (resultado) {
                // Salvar rota ativa para verificação de desvio
                rotaAtiva = resultado.route;
                destinoAtivo = {lat: destLat, lng: destLng};
                
                // Armazenar instruções de navegação
                routeInstructions = resultado.instructions || [];
                currentStep = 0;
                
                // Salvar rota no localStorage para persistência
                salvarRotaAtiva(pedidoId, resultado);
                
                // Mostrar resultado na tela
                mostrarResultadoRota(resultado, pedidoId);
                
                // Desenhar rota no mapa
                desenharRotaNoMapa(posicaoAtual, {lat: destLat, lng: destLng}, resultado.route, resultado.instructions);
                
                // Centralizar mapa na rota
                centralizarMapaNaRota(posicaoAtual, {lat: destLat, lng: destLng});
                
                console.log(`✅ Rota calculada: ${resultado.distance}, ${resultado.duration}`);
                return resultado;
            } else {
                // Se falhou, desenhar linha reta
                const rotaSimples = calcularRotaSimples(posicaoAtual, {lat: destLat, lng: destLng});
                
                // Salvar rota ativa (mesmo que seja linha reta)
                rotaAtiva = rotaSimples.route;
                destinoAtivo = {lat: destLat, lng: destLng};
                
                // Salvar rota simples no localStorage
                salvarRotaAtiva(pedidoId, rotaSimples);
                
                mostrarResultadoRota(rotaSimples, pedidoId);
                desenharRotaNoMapa(posicaoAtual, {lat: destLat, lng: destLng}, rotaSimples.route, []);
                centralizarMapaNaRota(posicaoAtual, {lat: destLat, lng: destLng});
                
                console.log(`⚠️ Rota estimada: ${rotaSimples.distance}, ${rotaSimples.duration}`);
                return rotaSimples;
            }
        }
        
        /**
         * Obter localização rápida (menos precisa, mas mais rápida)
         */
        function obterLocalizacaoRapida() {
            return new Promise((resolve) => {
                if (!navigator.geolocation) {
                    resolve(null);
                    return;
                }

                // Timeout de apenas 5 segundos
                const timeoutId = setTimeout(() => {
                    resolve(null);
                }, 5000);

                navigator.geolocation.getCurrentPosition(
                    position => {
                        clearTimeout(timeoutId);
                        resolve({
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        });
                    },
                    error => {
                        clearTimeout(timeoutId);
                        resolve(null);
                    },
                    {
                        enableHighAccuracy: false, // Menos precisa, mas mais rápida
                        timeout: 3000,
                        maximumAge: 600000 // 10 minutos
                    }
                );
            });
        }

        function chegouDestino(pedidoId) {
            updatePedidoStatus(pedidoId, 'chegou_destino', 'Chegada confirmada!');
        }

        function confirmarEntrega(pedidoId) {
            const observacoes = prompt('Observações da entrega (opcional):');
            
            // Limpar rota salva quando entrega é finalizada
            limparRotaAoFinalizar(pedidoId);
            
            updatePedidoStatus(pedidoId, 'entregue', 'Entrega confirmada!', observacoes);
        }

        function updatePedidoStatus(pedidoId, status, successMessage, observacoes = '') {
            fetch('<?= $baseUri ?>/entrega-tracking/update-status/', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    pedido_id: pedidoId,
                    status_tracking: status,
                    observacoes: observacoes
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Servidor retornou resposta não-JSON');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // NÃO mostrar alert aqui, o toast já foi mostrado
                    // alert(successMessage); // REMOVIDO
                    
                    // Atualizar interface sem recarregar a página
                    atualizarInterfacePedido(pedidoId, status);
                    
                    // NÃO recarregar a página para manter a rota no mapa
                    // location.reload(); // REMOVIDO
                } else {
                    showToast('❌ Erro', 'Erro: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Erro ao atualizar status:', error.message);
                showToast('❌ Erro de Comunicação', 'Erro na comunicação com o servidor: ' + error.message, 'error');
            });
        }
        
        /**
         * Atualizar interface do pedido sem recarregar a página
         */
        function atualizarInterfacePedido(pedidoId, novoStatus) {
            const pedidoCard = document.querySelector(`[data-pedido-id="${pedidoId}"]`);
            if (!pedidoCard) return;
            
            // Atualizar badge de status
            const statusBadge = pedidoCard.querySelector('.pedido-status');
            if (statusBadge) {
                statusBadge.className = `pedido-status status-${novoStatus}`;
                statusBadge.textContent = ucfirst(novoStatus.replace('_', ' '));
            }
            
            // Atualizar botões de ação
            const actionsDiv = pedidoCard.querySelector('.pedido-actions');
            if (actionsDiv) {
                atualizarBotoesPedido(actionsDiv, pedidoId, novoStatus);
            }
            
            console.log(`✅ Interface do pedido ${pedidoId} atualizada para status: ${novoStatus}`);
        }
        
        /**
         * Atualizar botões do pedido baseado no novo status
         */
        function atualizarBotoesPedido(actionsDiv, pedidoId, status) {
            // Remover botões de status anterior
            const statusButtons = actionsDiv.querySelectorAll('.btn-success, .btn-primary, .btn-warning');
            statusButtons.forEach(btn => {
                if (btn.textContent.includes('Coletar') || btn.textContent.includes('Iniciar') || btn.textContent.includes('Cheguei') || btn.textContent.includes('Entregar')) {
                    btn.remove();
                }
            });
            
            // Obter coordenadas do data attribute
            const pedidoCard = actionsDiv.closest('[data-pedido-id]');
            const lat = pedidoCard.getAttribute('data-dest-lat');
            const lng = pedidoCard.getAttribute('data-dest-lng');
            
            // Adicionar botão apropriado para o novo status
            let novoBtn = '';
            
            if (status === 'coletado' && lat && lng) {
                novoBtn = `<button class="btn btn-primary" onclick="iniciarRotaCompleta(${pedidoId}, ${lat}, ${lng}, this)"><i class="fas fa-route"></i> Iniciar Rota</button>`;
            } else if (status === 'em_rota') {
                novoBtn = `<button class="btn btn-warning" onclick="chegouDestino(${pedidoId})"><i class="fas fa-flag-checkered"></i> Cheguei</button>`;
            } else if (status === 'chegou_destino') {
                novoBtn = `<button class="btn btn-success" onclick="confirmarEntrega(${pedidoId})"><i class="fas fa-handshake"></i> Entregar</button>`;
            }
            
            if (novoBtn) {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = novoBtn;
                actionsDiv.insertBefore(tempDiv.firstElementChild, actionsDiv.firstElementChild);
            }
            
            console.log(`🔄 Botões atualizados para pedido ${pedidoId}, status: ${status}, coordenadas: ${lat}, ${lng}`);
        }
        
        /**
         * Primeira letra maiúscula
         */
        function ucfirst(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        function verRotaNoMapa(lat, lng, pedidoId = null) {
            if (lat && lng) {
                // Primeiro, centralizar o mapa na destinação
                map.setView([lat, lng], 16);
                
                // Se temos a posição do usuário, abrir navegação externa
                if (userMarker) {
                    const userPos = userMarker.getLatLng();
                    const userLat = userPos.lat;
                    const userLng = userPos.lng;
                    
                    // Detectar plataforma e abrir app de navegação apropriado
                    const isMobile = /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
                    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
                    const isAndroid = /Android/.test(navigator.userAgent);
                    
                    let routeUrl;
                    
                    if (isIOS) {
                        // iOS - Apple Maps com direções
                        routeUrl = `https://maps.apple.com/?daddr=${lat},${lng}&saddr=${userLat},${userLng}&dirflg=d`;
                        
                    } else if (isAndroid) {
                        // Android - Google Maps com direções
                        routeUrl = `https://www.google.com/maps/dir/${userLat},${userLng}/${lat},${lng}`;
                        
                    } else {
                        // Desktop - Google Maps no navegador
                        routeUrl = `https://www.google.com/maps/dir/${userLat},${userLng}/${lat},${lng}`;
                    }
                    
                    // Tentar abrir o app de navegação
                    try {
                        window.open(routeUrl, '_blank');
                        
                        // Mostrar mensagem de sucesso
                        const message = '🗺️ Rota aberta no app de navegação!\n\n📍 Destino: ' + lat + ', ' + lng;
                        
                        // Opções adicionais
                        const showOptions = confirm(message + '\n\n🛣️ Quer ver outras opções de navegação?');
                        
                        if (showOptions) {
                            const options = [
                                `🌍 Google Maps: https://www.google.com/maps/dir/${userLat},${userLng}/${lat},${lng}`,
                                `🚗 Waze: https://waze.com/ul?ll=${lat},${lng}&navigate=yes`,
                                `🍏 Apple Maps: https://maps.apple.com/?daddr=${lat},${lng}&saddr=${userLat},${userLng}`,
                                `📍 Coordenadas: ${lat}, ${lng}`
                            ].join('\n\n');
                            
                            // Criar um modal com as opções
                            const optionsModal = `
                                <div style="text-align: left; font-family: monospace; font-size: 12px;">
                                    <h4>🗺️ Opções de Navegação:</h4>
                                    <p><a href="https://www.google.com/maps/dir/${userLat},${userLng}/${lat},${lng}" target="_blank">🌍 Google Maps</a></p>
                                    <p><a href="https://waze.com/ul?ll=${lat},${lng}&navigate=yes" target="_blank">🚗 Waze</a></p>
                                    <p><a href="https://maps.apple.com/?daddr=${lat},${lng}&saddr=${userLat},${userLng}" target="_blank">🍏 Apple Maps</a></p>
                                    <p><strong>Coordenadas:</strong> ${lat}, ${lng}</p>
                                </div>
                            `;
                            
                            // Para simplificar, usar alert por agora
                            alert('🗺️ Opções de Navegação:\n\n' + options);
                        }
                        
                    } catch (error) {
                        console.error('Erro ao abrir navegação:', error);
                        
                        // Fallback: mostrar opções manuais
                        const options = [
                            `🌍 Google Maps: https://www.google.com/maps/dir/${userLat},${userLng}/${lat},${lng}`,
                            `🚗 Waze: https://waze.com/ul?ll=${lat},${lng}&navigate=yes`,
                            `📍 Coordenadas: ${lat}, ${lng}`
                        ].join('\n\n');
                        
                        alert('⚠️ Erro ao abrir navegação automaticamente\n\n🗺️ Opções manuais:\n\n' + options);
                    }
                    
                } else {
                    // Sem localização do usuário - mostrar apenas o destino
                    const destinationUrl = `https://www.google.com/maps/search/${lat},${lng}`;
                    window.open(destinationUrl, '_blank');
                    
                    alert('🗺️ Destino aberto no mapa!\n\nCoordenadas: ' + lat + ', ' + lng + '\n\n📍 Dica: Ative a localização para ver rotas automáticas.');
                }
                
            } else {
                // Se não temos coordenadas, tentar buscar via API
                if (pedidoId) {
                    alert('🔍 Buscando dados da rota...');
                    
                    fetch(`<?= $baseUri ?>/entrega-tracking/ver-rota/${pedidoId}/`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && data.coordenadas && data.coordenadas.latitude && data.coordenadas.longitude) {
                                // Tentar novamente com as coordenadas da API
                                verRotaNoMapa(data.coordenadas.latitude, data.coordenadas.longitude, null);
                            } else {
                                // Usar endereço como fallback
                                if (data.endereco && data.endereco.endereco_completo) {
                                    const enderecoUrl = `https://www.google.com/maps/search/${encodeURIComponent(data.endereco.endereco_completo)}`;
                                    window.open(enderecoUrl, '_blank');
                                    alert(`🗺️ Destino aberto no mapa!\n\nEndereço: ${data.endereco.endereco_completo}`);
                                } else {
                                    alert('⚠️ Não foi possível obter dados da rota.');
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Erro ao buscar rota:', error);
                            alert('⚠️ Erro ao buscar dados da rota.');
                        });
                } else {
                    alert('⚠️ Coordenadas do destino não disponíveis.');
                }
            }
        }

        // Atualizar pedidos periodicamente
        setInterval(function() {
            // Buscar novos pedidos ou atualizações
            fetch('<?= $baseUri ?>/entrega-tracking/entregador-api/' + entregadorId + '/')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('Servidor retornou resposta não-JSON');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.pedidos_novos > 0) {
                        // Recarregar página se houver novos pedidos
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Erro ao verificar novos pedidos:', error.message);
                });
        }, 30000); // Verificar a cada 30 segundos

        // Inicializar quando a página carregar
        document.addEventListener('DOMContentLoaded', function() {
            initMap();
            
            // Detectar tipo de dispositivo
            const isMobile = /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            const deviceType = document.getElementById('device-type');
            
            if (isMobile) {
                deviceType.innerHTML = '📱 Dispositivo Móvel (Ideal para tracking)';
                deviceType.style.color = '#28a745';
            } else {
                deviceType.innerHTML = '🖥️ Computador Desktop (Limitações no GPS)';
                deviceType.style.color = '#ffc107';
            }
            
            // Log para debug
            console.log('🖥️/📱 Dispositivo detectado:', isMobile ? 'Móvel' : 'Desktop');
            console.log('🌍 User Agent:', navigator.userAgent);
        });

        // Solicitar permissão de localização ao carregar
        window.addEventListener('load', function() {
            if ('serviceWorker' in navigator) {
                // Registrar service worker para notificações (opcional)
            }
            
            // Pedir permissão de notificação
            if ('Notification' in window && Notification.permission === 'default') {
                Notification.requestPermission();
            }
        });

        // Função para mostrar/ocultar menu rápido
        function showQuickMenu() {
            const menu = document.getElementById('quickMenu');
            if (menu.style.display === 'none' || menu.style.display === '') {
                menu.style.display = 'block';
                // Fechar menu ao clicar fora
                setTimeout(() => {
                    document.addEventListener('click', function closeMenu(e) {
                        if (!menu.contains(e.target) && !e.target.closest('button')) {
                            menu.style.display = 'none';
                            document.removeEventListener('click', closeMenu);
                        }
                    });
                }, 100);
            } else {
                menu.style.display = 'none';
            }
        }

        // ===== SISTEMA DE ROTEAMENTO INTELIGENTE =====
        
        /**
         * Calcular rota mais rápida até o cliente
         */
        async function calcularRota(destLat, destLng, pedidoId, buttonElement = null) {
            try {
                // Obter localização atual
                const posicaoAtual = await obterLocalizacaoAtual();
                if (!posicaoAtual) {
                    alert('❌ Não foi possível obter sua localização atual');
                    return;
                }

                console.log(`🛣️ Calculando rota de [${posicaoAtual.lat}, ${posicaoAtual.lng}] para [${destLat}, ${destLng}]`);
                
                // Mostrar loading
                let loadingBtn = buttonElement;
                if (!loadingBtn && event && event.target) {
                    loadingBtn = event.target;
                }
                
                let originalText = '';
                if (loadingBtn) {
                    originalText = loadingBtn.innerHTML;
                    loadingBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Calculando...';
                    loadingBtn.disabled = true;
                }

                // Tentar múltiplas APIs de roteamento
                const resultado = await calcularRotaMultiplasAPIs(posicaoAtual, {lat: destLat, lng: destLng});
                
                if (resultado) {
                    // Salvar rota ativa para verificação de desvio
                    rotaAtiva = resultado.route;
                    destinoAtivo = {lat: destLat, lng: destLng};
                    
                    // Mostrar resultado na tela
                    mostrarResultadoRota(resultado, pedidoId);
                    
                    // Desenhar rota no mapa
                    desenharRotaNoMapa(posicaoAtual, {lat: destLat, lng: destLng}, resultado.route, resultado.instructions);
                    
                    // Centralizar mapa na rota
                    centralizarMapaNaRota(posicaoAtual, {lat: destLat, lng: destLng});
                    
                    // Mostrar informações da rota
                    alert(
                        `🛣️ Rota calculada com sucesso!\n\n` +
                        `📆 Distância: ${resultado.distance}\n` +
                        `⏱️ Tempo estimado: ${resultado.duration}\n\n` +
                        `A rota foi traçada no mapa do sistema.\n` +
                        `🔄 Rota será recalculada automaticamente se você sair do caminho.`
                    );
                } else {
                    // Se falhou, desenhar linha reta
                    const rotaSimples = calcularRotaSimples(posicaoAtual, {lat: destLat, lng: destLng});
                    
                    // Salvar rota ativa (mesmo que seja linha reta)
                    rotaAtiva = rotaSimples.route;
                    destinoAtivo = {lat: destLat, lng: destLng};
                    
                    mostrarResultadoRota(rotaSimples, pedidoId);
                    desenharRotaNoMapa(posicaoAtual, {lat: destLat, lng: destLng}, rotaSimples.route, []);
                    centralizarMapaNaRota(posicaoAtual, {lat: destLat, lng: destLng});
                    
                    alert(
                        `⚠️ Rota estimada calculada!\n\n` +
                        `📆 Distância: ${rotaSimples.distance}\n` +
                        `⏱️ Tempo estimado: ${rotaSimples.duration}\n\n` +
                        `Linha reta traçada no mapa (APIs externas indisponíveis).`
                    );
                }
                
                // Restaurar botão
                if (loadingBtn) {
                    loadingBtn.innerHTML = originalText;
                    loadingBtn.disabled = false;
                }
                
            } catch (error) {
                console.error('❌ Erro ao calcular rota:', error);
                alert('❌ Erro ao calcular rota: ' + error.message);
                
                // Restaurar botão em caso de erro
                if (buttonElement || (event && event.target)) {
                    const btn = buttonElement || event.target;
                    btn.innerHTML = '<i class="fas fa-route"></i> Rota Rápida';
                    btn.disabled = false;
                }
            }
        }

        /**
         * Calcular rota usando múltiplas APIs gratuitas com roteamento real
         */
        async function calcularRotaMultiplasAPIs(origem, destino) {
            const apis = [
                // API 1: OSRM (Open Source Routing Machine - totalmente gratuita, sem CORS)
                {
                    name: 'OSRM',
                    url: `https://router.project-osrm.org/route/v1/driving/${origem.lng},${origem.lat};${destino.lng},${destino.lat}?overview=full&geometries=geojson&steps=true`,
                    parser: parseOSRM,
                    needsAuth: false
                },
                // API 2: OSRM Servidor Alternativo
                {
                    name: 'OSRM-Alt',
                    url: `https://routing.openstreetmap.de/routed-car/route/v1/driving/${origem.lng},${origem.lat};${destino.lng},${destino.lat}?overview=full&geometries=geojson&steps=true`,
                    parser: parseOSRM,
                    needsAuth: false
                },
                // API 3: Via Proxy PHP (para contornar CORS)
                {
                    name: 'Proxy-PHP',
                    url: `<?= $baseUri ?>/entrega-tracking/proxy-rota?origem_lat=${origem.lat}&origem_lng=${origem.lng}&destino_lat=${destino.lat}&destino_lng=${destino.lng}`,
                    parser: parseProxyResponse,
                    needsAuth: false
                },
                // API 4: OpenRouteService (gratuita com registro)
                {
                    name: 'OpenRouteService',
                    url: `https://api.openrouteservice.org/v2/directions/driving-car?api_key=5b3ce3597851110001cf6248YOUR_API_KEY&start=${origem.lng},${origem.lat}&end=${destino.lng},${destino.lat}`,
                    parser: parseOpenRouteService,
                    needsAuth: true,
                    disabled: true // Desabilitado até obter API key
                }
            ];
            
            // Filtrar APIs ativas (não desabilitadas)
            const apisAtivas = apis.filter(api => !api.disabled);
            console.log('🗋 APIs ativas para teste:', apisAtivas.map(api => api.name));

            // Tentar cada API com timeout
            for (const api of apisAtivas) {
                try {
                    console.log(`🔄 Tentando ${api.name} com URL:`, api.url);
                    
                    const headers = {
                        'Accept': 'application/json',
                        'User-Agent': 'DeliverySystem/1.0'
                    };
                    
                    // Timeout de 8 segundos por API
                    const controller = new AbortController();
                    const timeoutId = setTimeout(() => controller.abort(), 8000);
                    
                    const response = await fetch(api.url, {
                        method: 'GET',
                        headers: headers,
                        mode: api.name.includes('Proxy') ? 'same-origin' : 'cors',
                        signal: controller.signal
                    });
                    
                    clearTimeout(timeoutId);
                    
                    console.log(`📡 ${api.name} resposta:`, response.status, response.statusText);
                    
                    if (response.ok) {
                        const data = await response.json();
                        console.log(`📄 ${api.name} dados:`, data);
                        
                        const resultado = api.parser(data);
                        console.log(`🔧 ${api.name} resultado parseado:`, resultado);
                        
                        if (resultado && resultado.route && resultado.route.length > 2) {
                            console.log(`✅ ${api.name} funcionou! Rota com ${resultado.route.length} pontos`);
                            return resultado;
                        } else {
                            console.log(`⚠️ ${api.name} resultado inválido:`, {
                                temResultado: !!resultado,
                                temRota: !!(resultado && resultado.route),
                                tamanhoRota: resultado && resultado.route ? resultado.route.length : 0
                            });
                        }
                    } else {
                        console.log(`❌ ${api.name} HTTP Error:`, response.status, response.statusText);
                        
                        // Tentar ler a resposta de erro
                        try {
                            const errorData = await response.text();
                            console.log(`❌ ${api.name} erro detalhado:`, errorData.substring(0, 200));
                        } catch (e) {
                            console.log(`❌ ${api.name} erro sem detalhes`);
                        }
                    }
                } catch (error) {
                    if (error.name === 'AbortError') {
                        console.log(`⏰ ${api.name} timeout (8s)`);
                    } else {
                        console.log(`❌ ${api.name} falhou:`, error.message, error);
                    }
                }
            }

            // Se todas as APIs falharam, tentar Leaflet Routing Machine como último recurso
            console.log('⚠️ Todas as APIs externas falharam, tentando Leaflet Routing Machine...');
            
            try {
                const resultadoLeaflet = await calcularRotaComLeaflet(origem, destino);
                if (resultadoLeaflet) {
                    console.log('✅ Leaflet Routing Machine funcionou!');
                    return resultadoLeaflet;
                }
            } catch (error) {
                console.log('❌ Leaflet Routing Machine também falhou:', error.message);
            }
            
            // Se todas as APIs falharam, calcular rota simples (linha reta)
            console.log('⚠️ Todas as APIs falharam, usando rota simples');
            return calcularRotaSimples(origem, destino);
        }

        /**
         * Calcular rota simples (linha reta) como fallback
         */
        function calcularRotaSimples(origem, destino) {
            const distancia = calcularDistanciaHaversine(origem.lat, origem.lng, destino.lat, destino.lng);
            const tempoEstimado = Math.ceil(distancia / 30 * 60); // 30 km/h média urbana
            
            return {
                distance: `${distancia.toFixed(1)} km`,
                duration: `${tempoEstimado} min`,
                route: [[origem.lat, origem.lng], [destino.lat, destino.lng]],
                method: 'Linha reta (estimativa)'
            };
        }
        
        /**
         * Calcular rota usando Leaflet Routing Machine (fallback)
         */
        function calcularRotaComLeaflet(origem, destino) {
            return new Promise((resolve) => {
                try {
                    console.log('🍃 Tentando Leaflet Routing Machine...');
                    
                    if (!window.L || !window.L.Routing) {
                        throw new Error('Leaflet Routing Machine não carregado');
                    }
                    
                    // Timeout de 10 segundos
                    const timeout = setTimeout(() => {
                        resolve(null);
                    }, 10000);
                    
                    const control = L.Routing.control({
                        waypoints: [
                            L.latLng(origem.lat, origem.lng),
                            L.latLng(destino.lat, destino.lng)
                        ],
                        routeWhileDragging: false,
                        addWaypoints: false,
                        createMarker: () => null, // Não criar marcadores
                        show: false // Não mostrar controles
                    });
                    
                    control.on('routesfound', function(e) {
                        clearTimeout(timeout);
                        
                        const routes = e.routes;
                        if (routes && routes[0]) {
                            const route = routes[0];
                            const coordinates = route.coordinates || [];
                            
                            // Converter coordenadas para formato padrão [lat, lng]
                            const routePoints = coordinates.map(coord => [coord.lat, coord.lng]);
                            
                            const resultado = {
                                distance: `${(route.summary.totalDistance / 1000).toFixed(1)} km`,
                                duration: `${Math.ceil(route.summary.totalTime / 60)} min`,
                                route: routePoints,
                                method: 'Leaflet Routing Machine',
                                instructions: route.instructions || []
                            };
                            
                            console.log('✅ Leaflet resultado:', resultado);
                            resolve(resultado);
                        } else {
                            resolve(null);
                        }
                    });
                    
                    control.on('routingerror', function(e) {
                        clearTimeout(timeout);
                        console.log('❌ Leaflet routing error:', e);
                        resolve(null);
                    });
                    
                    // Adicionar à um mapa temporário (não visível)
                    const tempMap = L.map(document.createElement('div'));
                    control.addTo(tempMap);
                    
                } catch (error) {
                    console.log('❌ Erro Leaflet Routing Machine:', error);
                    resolve(null);
                }
            });
        }

        /**
         * Calcular distância entre dois pontos usando fórmula de Haversine
         */
        function calcularDistanciaHaversine(lat1, lon1, lat2, lon2) {
            const R = 6371; // Raio da Terra em km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }
        
        // Função de teste de APIs removida para produção
        
        /**
         * Alternar modo de navegação
         */
        function toggleNavigationMode() {
            const mapElement = document.getElementById('map');
            const compassOverlay = document.getElementById('compass-overlay');
            const navigationInfo = document.getElementById('navigation-info');
            const navBtn = document.getElementById('nav-mode-btn');
            
            modoNavegacao = !modoNavegacao;
            
            if (modoNavegacao) {
                // Ativar modo navegação
                mapElement.classList.add('navigation-mode');
                compassOverlay.style.display = 'flex';
                navigationInfo.classList.add('active');
                navBtn.innerHTML = '<i class="fas fa-compass"></i> Navegação ON';
                navBtn.style.background = '#28a745';
                
                // Iniciar orientação por bússola
                startCompass();
                
                // Centralizar no usuário e ajustar zoom
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(position => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        map.setView([lat, lng], 17); // Zoom mais próximo para navegação
                        updateUserMarker(lat, lng);
                    });
                }
                
                showToast(
                    '🧮 Modo Navegação Ativado',
                    'Mapa orientado para frente com bússola ativo',
                    'success'
                );
                
            } else {
                // Desativar modo navegação
                mapElement.classList.remove('navigation-mode');
                compassOverlay.style.display = 'none';
                navigationInfo.classList.remove('active');
                navBtn.innerHTML = '<i class="fas fa-compass"></i> Navegação';
                navBtn.style.background = '#17a2b8';
                
                // Parar orientação por bússola
                stopCompass();
                
                // Resetar rotação do mapa
                if (map.setBearing) {
                    map.setBearing(0);
                }
                
                showToast(
                    '🗺️ Modo Normal',
                    'Mapa em visão tradicional',
                    'info'
                );
            }
        }

        /**
         * Iniciar leitura da bússola (DeviceOrientation) e atualizar a visão do motorista
         */
        function startCompass() {
            if (compassEnabled) return;
            compassEnabled = true;

            function handleOrientation(e) {
                try {
                    let heading = null;

                    // iOS fornece webkitCompassHeading
                    if (typeof e.webkitCompassHeading !== 'undefined' && e.webkitCompassHeading !== null) {
                        heading = e.webkitCompassHeading; // 0-360
                    } else if (typeof e.alpha !== 'undefined' && e.alpha !== null) {
                        // alpha é a rotação do dispositivo em torno do eixo Z
                        // muitas implementações usam 360 - alpha para obter o heading
                        heading = 360 - e.alpha;
                    }

                    if (heading === null || isNaN(heading)) return;

                    heading = (heading + 360) % 360;
                    currentHeading = heading;

                    // Atualizar agulha da bússola se existir
                    const needle = document.getElementById('compass-needle');
                    if (needle) {
                        needle.style.transform = `rotate(${heading}deg)`;
                    }

                    // Atualizar marcador do usuário com rotação
                    if (userMarker) {
                        // obter posição atual do marker e atualizar ícone usando currentHeading
                        const pos = userMarker.getLatLng();
                        updateUserMarker(pos.lat, pos.lng);
                    }

                    // Se estiver no modo navegação, rotacionar o mapa conforme heading
                    if (modoNavegacao) {
                        rotacionarMapa(heading);
                    }
                } catch (err) {
                    console.warn('Erro no handler de bússola:', err);
                }
            }

            // Salvar referência para remover depois
            window._orientationHandler = handleOrientation;

            if (window.DeviceOrientationEvent && typeof DeviceOrientationEvent.requestPermission === 'function') {
                // iOS 13+ exige permissão explícita
                DeviceOrientationEvent.requestPermission().then(permission => {
                    if (permission === 'granted') {
                        window.addEventListener('deviceorientation', window._orientationHandler, true);
                    } else {
                        compassEnabled = false;
                        showToast('🚫 Bússola bloqueada', 'Permissão de bússola negada. Ative nas configurações do navegador.', 'warning', 6000);
                    }
                }).catch(err => {
                    compassEnabled = false;
                    console.warn('Erro ao solicitar permissão da bússola:', err);
                    showToast('❌ Erro na bússola', 'Não foi possível ativar a bússola neste dispositivo.', 'error', 5000);
                });
            } else if (window.DeviceOrientationEvent) {
                // Navegadores que não pedem permissão
                window.addEventListener('deviceorientation', window._orientationHandler, true);
            } else {
                compassEnabled = false;
                showToast('❌ Bússola não suportada', 'Seu dispositivo não fornece dados de bússola.', 'warning', 5000);
            }
        }

        /**
         * Parar leitura da bússola
         */
        function stopCompass() {
            if (!compassEnabled) return;
            compassEnabled = false;

            if (window._orientationHandler) {
                window.removeEventListener('deviceorientation', window._orientationHandler, true);
                delete window._orientationHandler;
            }

            // Resetar agulha
            const needle = document.getElementById('compass-needle');
            if (needle) needle.style.transform = 'rotate(0deg)';

            // Resetar rotação do mapa visual
            const mapContainer = document.getElementById('map');
            if (mapContainer) {
                mapContainer.style.transform = 'rotate(0deg)';
                mapContainer.style.border = 'none';
                mapContainer.style.borderRadius = '10px';
            }
        }

        /**
         * Atualizar informações de navegação curva a curva
         */
        function updateNavigationInfo() {
            if (!modoNavegacao || !destinoAtivo) return;
            
            navigator.geolocation.getCurrentPosition(position => {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;
                
                if (routeInstructions && routeInstructions.length > 0) {
                    // Navegação curva a curva
                    const nextStep = findNextManeuver(userLat, userLng);
                    
                    if (nextStep) {
                        const distanceToManeuver = calcularDistanciaHaversine(
                            userLat, userLng,
                            nextStep.location[0], nextStep.location[1]
                        );
                        
                        const distanciaTotal = calcularDistanciaHaversine(
                            userLat, userLng,
                            destinoAtivo.lat, destinoAtivo.lng
                        );
                        
                        const tempoMinutos = Math.ceil(distanciaTotal / 30 * 60);
                        
                        updateTurnByTurnDisplay(nextStep, distanceToManeuver, distanciaTotal, tempoMinutos);
                        checkVoiceInstruction(distanceToManeuver, nextStep);
                    }
                } else {
                    // Navegação simples (sem instruções)
                    const distancia = calcularDistanciaHaversine(
                        userLat, userLng,
                        destinoAtivo.lat, destinoAtivo.lng
                    );
                    
                    const bearing = calcularBearing(userLat, userLng, destinoAtivo.lat, destinoAtivo.lng);
                    const direction = getDirectionText(bearing);
                    const tempoMinutos = Math.ceil(distancia / 30 * 60);
                    
                    document.getElementById('current-instruction').textContent = `Siga em direção ${direction}`;
                    document.getElementById('instruction-distance').textContent = `${(distancia * 1000).toFixed(0)}m restantes`;
                    document.getElementById('nav-distance').textContent = `${(distancia * 1000).toFixed(0)}m`;
                    document.getElementById('nav-eta').textContent = `${tempoMinutos}min`;
                }
                
            }, error => {
                console.error('❌ Erro ao obter localização para navegação:', error);
            });
        }

        /**
         * Obter localização atual do usuário com timeout aprimorado para mobile
         */
        function obterLocalizacaoAtual() {
            return new Promise((resolve, reject) => {
                if (!navigator.geolocation) {
                    reject(new Error('Geolocalização não suportada pelo navegador'));
                    return;
                }

                // Detectar se é dispositivo móvel
                const isMobile = /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
                
                // Timeout de 15 segundos para evitar travamento
                const timeoutId = setTimeout(() => {
                    reject(new Error('Timeout ao obter localização (15s)'));
                }, 15000);

                // Opções otimizadas para dispositivos móveis
                const options = {
                    enableHighAccuracy: isMobile, // Alta precisão apenas em mobile
                    timeout: isMobile ? 15000 : 10000, // Mais tempo para mobile
                    maximumAge: isMobile ? 60000 : 300000 // Cache menor para mobile
                };

                console.log('📱 Solicitando localização:', {
                    isMobile,
                    options,
                    userAgent: navigator.userAgent.substring(0, 50) + '...'
                });
                
                navigator.geolocation.getCurrentPosition(
                    position => {
                        clearTimeout(timeoutId);
                        console.log('✅ Localização obtida com sucesso:', {
                            coords: position.coords,
                            accuracy: position.coords.accuracy + 'm',
                            timestamp: new Date(position.timestamp).toLocaleTimeString()
                        });
                        resolve({
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                            accuracy: position.coords.accuracy
                        });
                    },
                    error => {
                        clearTimeout(timeoutId);
                        console.error('❌ Erro de geolocalização:', {
                            code: error.code,
                            message: error.message,
                            isMobile,
                            timestamp: new Date().toLocaleTimeString()
                        });
                        
                        let errorMessage = '';
                        let toastTitle = '';
                        let toastMessage = '';
                        let toastType = 'error';
                        
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                if (isMobile) {
                                    toastTitle = '📱 Permissão Negada - SOLUÇÃO';
                                    toastMessage = '🔴 AÇÃO NECESSÁRIA: Você negou a localização.\n\n' +
                                                 '🔓 COMO CORRIGIR:\n' +
                                                 '1️⃣ Toque no ÍCONE DE CADEADO 🔒 na barra de endereços\n' +
                                                 '2️⃣ Toque em "Localização"\n' +
                                                 '3️⃣ Selecione "PERMITIR"\n' +
                                                 '4️⃣ Recarregue a página\n\n' +
                                                 '🔄 Ou use o botão "Ativar GPS" no mapa';
                                    errorMessage = 'Permissão de localização negada no dispositivo móvel';
                                } else {
                                    toastTitle = '🖥️ Permissão Negada - SOLUÇÃO';
                                    toastMessage = '🔴 AÇÃO NECESSÁRIA: Você negou a localização.\n\n' +
                                                 '🔓 COMO CORRIGIR:\n' +
                                                 '1️⃣ Clique no ÍCONE DE LOCALIZAÇÃO 📍 na barra de endereços\n' +
                                                 '2️⃣ Selecione "Sempre permitir localização"\n' +
                                                 '3️⃣ Recarregue a página\n\n' +
                                                 '💡 DICA: Use um celular para melhor precisão';
                                    errorMessage = 'Permissão de localização negada no computador';
                                }
                                break;
                            case error.POSITION_UNAVAILABLE:
                                if (isMobile) {
                                    toastTitle = '📡 GPS Indisponível';
                                    toastMessage = 'Verifique se:\n• O GPS está ativado\n• Você está em área aberta\n• O sinal de internet está bom';
                                    errorMessage = 'Localização indisponível no dispositivo móvel';
                                } else {
                                    toastTitle = '🖥️ Localização Indisponível';
                                    toastMessage = 'Computadores têm precisão limitada. Use um celular para melhor resultado.';
                                    errorMessage = 'Localização indisponível no computador';
                                    toastType = 'warning';
                                }
                                break;
                            case error.TIMEOUT:
                                if (isMobile) {
                                    toastTitle = '⏰ Timeout na Localização';
                                    toastMessage = 'Demorando muito para obter localização. Verifique se está em área aberta e tente novamente.';
                                    errorMessage = 'Timeout ao obter localização no móvel';
                                } else {
                                    toastTitle = '⏰ Timeout na Localização';
                                    toastMessage = 'Timeout ao obter localização no computador (normal)';
                                    errorMessage = 'Timeout ao obter localização no computador';
                                    toastType = 'warning';
                                }
                                break;
                            default:
                                toastTitle = '❌ Erro de Localização';
                                toastMessage = `Erro desconhecido (${error.code}): ${error.message}`;
                                errorMessage = `Erro desconhecido (${error.code})`;
                        }
                        
                        // Mostrar toast com instruções detalhadas
                        showToast(toastTitle, toastMessage, toastType, 12000);
                        
                        reject(new Error(errorMessage));
                    },
                    options
                );
            });
        }
        
        /**
         * Solicitar permissão de localização manualmente (botão Ativar GPS)
         */
        function solicitarPermissaoManual() {
            const isMobile = /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            
            console.log('🔘 Solicitação manual de permissão de localização iniciada');
            
            if (!navigator.geolocation) {
                showToast(
                    '❌ Não Suportado', 
                    'Seu navegador não suporta geolocalização', 
                    'error'
                );
                return;
            }
            
            atualizarStatusLocalizacao('solicitando', 'Verificando permissões...');
            
            // Verificar se já temos permissão
            if (navigator.permissions) {
                navigator.permissions.query({name: 'geolocation'}).then(result => {
                    console.log('🔍 Status da permissão atual:', result.state);
                    
                    if (result.state === 'granted') {
                        showToast(
                            '✅ Permissão Já Concedida', 
                            'Localização já está ativada! Testando localização...', 
                            'success'
                        );
                        
                        // Testar localização
                        testarLocalizacao();
                        return;
                    }
                    
                    if (result.state === 'denied') {
                        atualizarStatusLocalizacao('negado', 'Permissão foi negada anteriormente');
                        mostrarInstrucoesPelimissaoNegada(isMobile);
                        return;
                    }
                    
                    // Se state === 'prompt', prosseguir com solicitação
                    solicitarPermissaoAgora(isMobile);
                });
            } else {
                // Fallback para navegadores que não suportam Permissions API
                solicitarPermissaoAgora(isMobile);
            }
        }
        
        /**
         * Mostrar instruções quando permissão foi negada
         */
        function mostrarInstrucoesPelimissaoNegada(isMobile) {
            let titulo, mensagem;
            
            if (isMobile) {
                titulo = '🚫 Permissão Negada Anteriormente';
                mensagem = `Para reativar a localização:\n\n` +
                          `📱 Chrome/Edge Mobile:\n` +
                          `1. Toque no ícone de cadeado na barra de endereços\n` +
                          `2. Toque em "Localização"\n` +
                          `3. Selecione "Permitir"\n\n` +
                          `📱 Safari Mobile:\n` +
                          `1. Vá em Configurações > Safari > Localização\n` +
                          `2. Selecione "Perguntar" ou "Permitir"\n\n` +
                          `📱 Firefox Mobile:\n` +
                          `1. Toque no ícone de escudo na barra\n` +
                          `2. Altere as configurações de localização`;
            } else {
                titulo = '🚫 Permissão Negada Anteriormente';
                mensagem = `Para reativar a localização no computador:\n\n` +
                          `🖥️ Chrome/Edge:\n` +
                          `1. Clique no ícone de localização na barra de endereços\n` +
                          `2. Selecione "Sempre permitir localização"\n\n` +
                          `🖥️ Firefox:\n` +
                          `1. Clique no escudo na barra de endereços\n` +
                          `2. Altere as configurações de localização\n\n` +
                          `🖥️ Safari:\n` +
                          `1. Safari > Preferências > Sites > Localização`;
            }
            
            showToast(titulo, mensagem, 'warning', 15000);
        }
        
        /**
         * Solicitar permissão agora
         */
        function solicitarPermissaoAgora(isMobile) {
            atualizarStatusLocalizacao('solicitando', 'Solicitando permissão ao usuário...');
            
            showToast(
                '📱 Solicitando Permissão',
                isMobile ? 
                    'Quando aparecer a pergunta de localização, toque em "Permitir"' :
                    'Quando aparecer a pergunta de localização, clique em "Permitir"',
                'info',
                5000
            );
            
            // Aguardar um pouco antes de solicitar para dar tempo do usuário ler o toast
            setTimeout(() => {
                obterLocalizacaoAtual()
                    .then(position => {
                        console.log('✅ Permissão concedida e localização obtida:', position);
                        
                        atualizarStatusLocalizacao('ativo', `Localização ativa - Precisão: ${Math.round(position.accuracy)}m`);
                        
                        // Atualizar mapa
                        map.setView([position.lat, position.lng], 15);
                        updateUserMarker(position.lat, position.lng);
                        
                        showToast(
                            '✅ Localização Ativada!',
                            `Coordenadas: ${position.lat.toFixed(6)}, ${position.lng.toFixed(6)}\nPrecisão: ${Math.round(position.accuracy)}m`,
                            'success',
                            5000
                        );
                    })
                    .catch(error => {
                        console.error('❌ Falha ao obter localização após solicitação manual:', error);
                        
                        if (error.message.includes('Permissão negada')) {
                            atualizarStatusLocalizacao('negado', 'Usuário negou a permissão');
                            mostrarInstrucoesPelimissaoNegada(isMobile);
                        } else {
                            atualizarStatusLocalizacao('inativo', `Erro: ${error.message}`);
                            showToast(
                                '❌ Erro na Localização',
                                `Falha: ${error.message}

Tente:
• Recarregar a página
• Verificar se GPS está ativo
• Usar outro navegador`,
                                'error',
                                8000
                            );
                        }
                    });
            }, 1000);
        }
        
        /**
         * Testar localização atual
         */
        function testarLocalizacao() {
            atualizarStatusLocalizacao('solicitando', 'Testando localização...');
            
            obterLocalizacaoAtual()
                .then(position => {
                    atualizarStatusLocalizacao('ativo', `Teste OK - Precisão: ${Math.round(position.accuracy)}m`);
                    
                    map.setView([position.lat, position.lng], 15);
                    updateUserMarker(position.lat, position.lng);
                    
                    showToast(
                        '✅ Teste de Localização OK!',
                        `📍 Sua posição: ${position.lat.toFixed(6)}, ${position.lng.toFixed(6)}\n🎯 Precisão: ${Math.round(position.accuracy)}m`,
                        'success',
                        4000
                    );
                })
                .catch(error => {
                    atualizarStatusLocalizacao('inativo', `Teste falhou: ${error.message}`);
                    
                    showToast(
                        '❌ Teste Falhou',
                        `Erro no teste: ${error.message}`,
                        'error',
                        5000
                    );
                });
        }

        /**
         * Mostrar resultado da rota na interface
         */
        function mostrarResultadoRota(resultado, pedidoId) {
            // Criar ou atualizar elemento de resultado
            let resultDiv = document.getElementById(`rota-resultado-${pedidoId}`);
            if (!resultDiv) {
                resultDiv = document.createElement('div');
                resultDiv.id = `rota-resultado-${pedidoId}`;
                resultDiv.style.cssText = `
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                    padding: 10px;
                    border-radius: 8px;
                    margin: 10px 0;
                    font-size: 14px;
                    box-shadow: 0 3px 10px rgba(0,0,0,0.2);
                `;
                
                const pedidoCard = document.querySelector(`[data-pedido-id="${pedidoId}"]`);
                pedidoCard.appendChild(resultDiv);
            }
            
            resultDiv.innerHTML = `
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                    <i class="fas fa-route"></i>
                    <strong>Rota Calculada</strong>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; font-size: 13px;">
                    <div><i class="fas fa-road"></i> <strong>${resultado.distance}</strong></div>
                    <div><i class="fas fa-clock"></i> <strong>${resultado.duration}</strong></div>
                </div>
                ${resultado.method ? `<div style="font-size: 12px; opacity: 0.8; margin-top: 5px;">Método: ${resultado.method}</div>` : ''}
            `;
        }

        /**
         * Desenhar rota no mapa com recursos avançados e instruções
         */
        function desenharRotaNoMapa(origem, destino, route, instructions = []) {
            // Remover rotas anteriores
            limparRotasAnteriores();

            // Desenhar rota principal com estilo melhorado
            const rotaPolyline = L.polyline(route, {
                color: '#667eea',
                weight: 6,
                opacity: 0.9,
                smoothFactor: 1.0,
                lineCap: 'round',
                lineJoin: 'round'
            }).addTo(map);
            
            // Adicionar sombra à rota
            const rotaSombra = L.polyline(route, {
                color: '#000000',
                weight: 8,
                opacity: 0.3,
                smoothFactor: 1.0,
                lineCap: 'round',
                lineJoin: 'round'
            }).addTo(map);
            
            // Adicionar animação à rota
            adicionarAnimacaoRota(rotaPolyline);
            
            // Salvar referência da rota
            currentRoutes.push(rotaSombra, rotaPolyline);

            // Adicionar marcadores de início e fim melhorados
            const marcadorOrigem = L.marker([origem.lat, origem.lng], {
                icon: L.divIcon({
                    html: '<div style="background: #28a745; color: white; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 3px solid white; box-shadow: 0 3px 10px rgba(0,0,0,0.4); z-index: 1000;"><i class="fas fa-play" style="font-size: 12px;"></i></div>',
                    iconSize: [30, 30],
                    className: 'custom-start-marker'
                }),
                zIndexOffset: 1000
            }).addTo(map);
            
            const marcadorDestino = L.marker([destino.lat, destino.lng], {
                icon: L.divIcon({
                    html: '<div style="background: #dc3545; color: white; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 3px solid white; box-shadow: 0 3px 10px rgba(0,0,0,0.4); z-index: 1000;"><i class="fas fa-flag-checkered" style="font-size: 10px;"></i></div>',
                    iconSize: [30, 30],
                    className: 'custom-end-marker'
                }),
                zIndexOffset: 1000
            }).addTo(map);
            
            marcadorOrigem.bindPopup('🏁 <strong>Início da Rota</strong><br>Sua localização atual');
            marcadorDestino.bindPopup('🏁 <strong>Destino</strong><br>Local de entrega');
            
            // Salvar marcadores para limpeza posterior
            currentRoutes.push(marcadorOrigem, marcadorDestino);
            
            // Adicionar marcadores de instruções se disponíveis
            if (instructions && instructions.length > 0) {
                adicionarMarcadoresInstrucoes(instructions, route);
            }
            
            // Adicionar pontos intermediários se a rota for complexa
            if (route.length > 50) {
                adicionarPontosIntermediarios(route);
            }
            
            // Criar painel de instruções - REMOVIDO
            // if (instructions && instructions.length > 0) {
            //     criarPainelInstrucoes(instructions);
            // }
        }
        
        /**
         * Adicionar marcadores de instruções de navegação
         */
        function adicionarMarcadoresInstrucoes(instructions, route) {
            instructions.forEach((instruction, index) => {
                // Pular primeira e última instrução (início e fim)
                if (index === 0 || index === instructions.length - 1) return;
                
                // Encontrar posição da instrução na rota
                let posicao = null;
                
                // Tentar diferentes formatos de instrução
                if (instruction.location) {
                    posicao = [instruction.location[1], instruction.location[0]];
                } else if (instruction.maneuver && instruction.maneuver.location) {
                    posicao = [instruction.maneuver.location[1], instruction.maneuver.location[0]];
                } else if (instruction.interval && route[instruction.interval[0]]) {
                    posicao = route[instruction.interval[0]];
                }
                
                if (posicao && posicao[0] && posicao[1]) {
                    // Determinar ícone da instrução
                    const icone = obterIconeInstrucao(instruction);
                    
                    const marcadorInstrucao = L.marker(posicao, {
                        icon: L.divIcon({
                            html: `<div style="background: #ffc107; color: #212529; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 2px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.3); font-size: 10px;">${icone}</div>`,
                            iconSize: [24, 24],
                            className: 'custom-instruction-marker'
                        }),
                        zIndexOffset: 500
                    }).addTo(map);
                    
                    // Adicionar popup com instrução
                    const texto = instruction.instruction || instruction.text || instruction.maneuver?.instruction || 'Continuar';
                    marcadorInstrucao.bindPopup(`<strong>Instrução ${index}</strong><br>${texto}`);
                    
                    currentRoutes.push(marcadorInstrucao);
                }
            });
        }
        
        /**
         * Obter ícone apropriado para instrução
         */
        function obterIconeInstrucao(instruction) {
            const texto = (instruction.instruction || instruction.text || instruction.maneuver?.instruction || '').toLowerCase();
            
            if (texto.includes('left') || texto.includes('esquerda')) {
                return '←'; // Seta esquerda
            } else if (texto.includes('right') || texto.includes('direita')) {
                return '→'; // Seta direita
            } else if (texto.includes('straight') || texto.includes('continue') || texto.includes('reto')) {
                return '↑'; // Seta para cima
            } else if (texto.includes('u-turn') || texto.includes('retorno')) {
                return '↻'; // Símbolo de retorno
            } else if (texto.includes('roundabout') || texto.includes('rotatória')) {
                return '🔄'; // Símbolo de rotatória
            } else {
                return '•'; // Ponto simples
            }
        }
        
        /**
         * Criar painel de instruções de navegação - REMOVIDO
         */
        function criarPainelInstrucoes(instructions) {
            // Funcionalidade removida a pedido do usuário
            console.log('📋 Instruções de rota removidas');
        }
        
        /**
         * Fechar painel de instruções - REMOVIDO  
         */
        function fecharPainelInstrucoes() {
            // Funcionalidade removida
        }
        
        /**
         * Adicionar animação à rota
         */
        function adicionarAnimacaoRota(polyline) {
            // Efeito de "drawing" da linha
            let index = 0;
            const coords = polyline.getLatLngs();
            const tempCoords = [];
            
            function desenharPasso() {
                if (index < coords.length) {
                    tempCoords.push(coords[index]);
                    polyline.setLatLngs(tempCoords);
                    index++;
                    setTimeout(desenharPasso, 50); // 50ms entre cada ponto
                }
            }
            
            // Iniciar animação
            desenharPasso();
        }
        
        /**
         * Adicionar pontos intermediários na rota
         */
        function adicionarPontosIntermediarios(route) {
            const step = Math.floor(route.length / 5); // 5 pontos intermediários
            
            for (let i = step; i < route.length - step; i += step) {
                const ponto = route[i];
                const marcador = L.circleMarker([ponto[0], ponto[1]], {
                    radius: 4,
                    fillColor: '#667eea',
                    color: 'white',
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 0.8
                }).addTo(map);
                
                currentRoutes.push(marcador);
            }
        }
        
        /**
         * Limpar todas as rotas anteriores
         */
        function limparRotasAnteriores() {
            currentRoutes.forEach(item => {
                if (map.hasLayer(item)) {
                    map.removeLayer(item);
                }
            });
            currentRoutes = [];
        }
        
        /**
         * Centralizar mapa na rota
         */
        function centralizarMapaNaRota(origem, destino) {
            const group = new L.featureGroup([
                L.marker([origem.lat, origem.lng]),
                L.marker([destino.lat, destino.lng])
            ]);
            
            map.fitBounds(group.getBounds().pad(0.1));
        }

        /**
         * Otimizar rota para múltiplos pedidos
         */
        async function otimizarRota() {
            try {
                const posicaoAtual = await obterLocalizacaoAtual();
                if (!posicaoAtual) {
                    alert('❌ Não foi possível obter sua localização atual');
                    return;
                }

                // Obter todos os pedidos ativos
                const pedidos = [];
                <?php if ($data['pedidos']): ?>
                    <?php foreach ($data['pedidos'] as $pedido): ?>
                        <?php if ($pedido->latitude_destino && $pedido->longitude_destino): ?>
                            pedidos.push({
                                id: <?= $pedido->pedido_id ?>,
                                numero: '<?= $pedido->pedido_numero_entrega ?>',
                                lat: <?= $pedido->latitude_destino ?>,
                                lng: <?= $pedido->longitude_destino ?>,
                                endereco: '<?= addslashes($pedido->endereco_endereco . ', ' . $pedido->endereco_numero) ?>'
                            });
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>

                if (pedidos.length === 0) {
                    alert('ℹ️ Nenhum pedido com coordenadas disponível para otimização');
                    return;
                }

                if (pedidos.length === 1) {
                    alert('ℹ️ Apenas um pedido disponível. Use "Rota Rápida" no pedido.');
                    return;
                }

                // Calcular rota otimizada
                const rotaOtimizada = calcularRotaOtimizada(posicaoAtual, pedidos);
                
                // Mostrar resultado
                mostrarRotaOtimizada(rotaOtimizada);
                
            } catch (error) {
                console.error('❌ Erro ao otimizar rota:', error);
                alert('❌ Erro ao otimizar rota: ' + error.message);
            }
        }

        /**
         * Calcular rota otimizada usando algoritmo do vizinho mais próximo
         */
        function calcularRotaOtimizada(origem, pedidos) {
            const rotaOtimizada = [];
            const pedidosRestantes = [...pedidos];
            let posicaoAtual = origem;
            let distanciaTotal = 0;
            let tempoTotal = 0;

            while (pedidosRestantes.length > 0) {
                // Encontrar pedido mais próximo
                let maisProximo = null;
                let menorDistancia = Infinity;
                let indiceMaisProximo = -1;

                pedidosRestantes.forEach((pedido, index) => {
                    const distancia = calcularDistanciaHaversine(
                        posicaoAtual.lat, posicaoAtual.lng,
                        pedido.lat, pedido.lng
                    );
                    
                    if (distancia < menorDistancia) {
                        menorDistancia = distancia;
                        maisProximo = pedido;
                        indiceMaisProximo = index;
                    }
                });

                // Adicionar à rota otimizada
                rotaOtimizada.push({
                    ...maisProximo,
                    distancia: menorDistancia.toFixed(1),
                    tempoEstimado: Math.ceil(menorDistancia / 30 * 60) // 30 km/h média
                });

                distanciaTotal += menorDistancia;
                tempoTotal += Math.ceil(menorDistancia / 30 * 60);

                // Atualizar posição atual e remover pedido processado
                posicaoAtual = { lat: maisProximo.lat, lng: maisProximo.lng };
                pedidosRestantes.splice(indiceMaisProximo, 1);
            }

            return {
                rota: rotaOtimizada,
                distanciaTotal: distanciaTotal.toFixed(1),
                tempoTotal: tempoTotal
            };
        }

        /**
         * Mostrar rota otimizada na interface
         */
        function mostrarRotaOtimizada(resultado) {
            let modal = document.getElementById('modal-rota-otimizada');
            if (!modal) {
                // Criar modal
                modal = document.createElement('div');
                modal.id = 'modal-rota-otimizada';
                modal.style.cssText = `
                    position: fixed;
                    top: 0; left: 0; right: 0; bottom: 0;
                    background: rgba(0,0,0,0.7);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 2000;
                    padding: 20px;
                `;
                document.body.appendChild(modal);
            }

            modal.innerHTML = `
                <div style="
                    background: white;
                    border-radius: 15px;
                    padding: 25px;
                    max-width: 500px;
                    width: 100%;
                    max-height: 80vh;
                    overflow-y: auto;
                ">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h3><i class="fas fa-route"></i> Rota Otimizada</h3>
                        <button onclick="fecharModal()" style="
                            background: none;
                            border: none;
                            font-size: 24px;
                            cursor: pointer;
                            color: #666;
                        ">&times;</button>
                    </div>
                    
                    <div style="
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        color: white;
                        padding: 15px;
                        border-radius: 10px;
                        margin-bottom: 20px;
                        text-align: center;
                    ">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div>
                                <div style="font-size: 24px; font-weight: bold;">${resultado.distanciaTotal} km</div>
                                <div style="font-size: 14px; opacity: 0.9;">Distância Total</div>
                            </div>
                            <div>
                                <div style="font-size: 24px; font-weight: bold;">${resultado.tempoTotal} min</div>
                                <div style="font-size: 14px; opacity: 0.9;">Tempo Estimado</div>
                            </div>
                        </div>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <h4 style="margin-bottom: 10px;">Sequência Otimizada:</h4>
                        ${resultado.rota.map((pedido, index) => `
                            <div style="
                                display: flex;
                                align-items: center;
                                padding: 10px;
                                border: 1px solid #eee;
                                border-radius: 8px;
                                margin-bottom: 8px;
                                background: ${index === 0 ? '#e8f5e8' : 'white'};
                            ">
                                <div style="
                                    background: #667eea;
                                    color: white;
                                    width: 25px;
                                    height: 25px;
                                    border-radius: 50%;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-weight: bold;
                                    margin-right: 10px;
                                    font-size: 12px;
                                ">${index + 1}</div>
                                <div style="flex: 1;">
                                    <div style="font-weight: bold;">Pedido #${pedido.numero}</div>
                                    <div style="font-size: 13px; color: #666;">${pedido.endereco}</div>
                                </div>
                                <div style="text-align: right; font-size: 12px; color: #667eea;">
                                    <div>${pedido.distancia} km</div>
                                    <div>${pedido.tempoEstimado} min</div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                    
                    <div style="display: flex; gap: 10px; justify-content: flex-end;">
                        <button onclick="fecharModal()" class="btn" style="background: #6c757d; color: white;">
                            Fechar
                        </button>
                        <button onclick="visualizarRotaOtimizada()" class="btn btn-primary">
                            <i class="fas fa-map"></i> Visualizar no Mapa
                        </button>
                        <button onclick="iniciarNavegacaoInterna()" class="btn btn-success">
                            <i class="fas fa-play"></i> Iniciar Navegação
                        </button>
                    </div>
                </div>
            `;
            
            modal.style.display = 'flex';
        }

        /**
         * Fechar modal
         */
        function fecharModal() {
            const modal = document.getElementById('modal-rota-otimizada');
            if (modal) {
                modal.style.display = 'none';
            }
        }

        /**
         * Iniciar rota otimizada (mantido para compatibilidade)
         */
        function iniciarRotaOtimizada() {
            iniciarNavegacaoInterna();
        }
        
        /**
         * Visualizar rota otimizada no mapa
         */
        function visualizarRotaOtimizada() {
            fecharModal();
            
            // Obter dados da rota do modal
            const modal = document.getElementById('modal-rota-otimizada');
            if (!modal) return;
            
            // Simular visualização da rota otimizada
            alert('🗺️ Rota otimizada visualizada no mapa!\n\nFuncionalidade em desenvolvimento para traçar toda a sequência no mapa.');
        }
        
        /**
         * Iniciar navegação interna do sistema
         */
        function iniciarNavegacaoInterna() {
            fecharModal();
            
            // Criar painel de navegação
            criarPainelNavegacao();
            
            // Iniciar tracking de localização em tempo real
            iniciarTrackingNavegacao();
            
            // Ativar modo navegação automaticamente
            setTimeout(() => {
                if (!modoNavegacao) {
                    alternarModoNavegacao();
                }
            }, 2000);
        }
        
        /**
         * Criar painel de navegação interno
         */
        function criarPainelNavegacao() {
            // Remover painel anterior se existir
            const painelExistente = document.getElementById('painel-navegacao');
            if (painelExistente) {
                painelExistente.remove();
            }
            
            // Criar novo painel
            const painel = document.createElement('div');
            painel.id = 'painel-navegacao';
            painel.style.cssText = `
                position: fixed;
                top: 80px;
                left: 20px;
                right: 20px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 15px;
                border-radius: 15px;
                box-shadow: 0 8px 25px rgba(0,0,0,0.3);
                z-index: 1500;
                font-family: 'Segoe UI', sans-serif;
            `;
            
            painel.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <h4 style="margin: 0; display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-route"></i> Modo de Navegação
                    </h4>
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <button onclick="toggleFullscreenNavigation()" id="btn-fullscreen-nav" style="
                            background: rgba(255,255,255,0.12);
                            border: none;
                            color: white;
                            padding: 6px 10px;
                            border-radius: 6px;
                            cursor: pointer;
                            font-size: 13px;
                        ">
                            <i class="fas fa-expand"></i> Tela Cheia
                        </button>
                        <button onclick="pararNavegacao()" style="
                            background: rgba(255,255,255,0.2);
                            border: none;
                            color: white;
                            padding: 6px 10px;
                            border-radius: 6px;
                            cursor: pointer;
                            font-size: 13px;
                        ">
                            <i class="fas fa-times"></i> Parar
                        </button>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 15px;">
                    <div style="text-align: center;">
                        <div style="font-size: 18px; font-weight: bold;" id="nav-distancia">--</div>
                        <div style="font-size: 12px; opacity: 0.8;">Distância</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 18px; font-weight: bold;" id="nav-tempo">--</div>
                        <div style="font-size: 12px; opacity: 0.8;">Tempo Rest.</div>
                    </div>
                    <div style="text-align: center;">
                        <div style="font-size: 18px; font-weight: bold;" id="nav-velocidade">--</div>
                        <div style="font-size: 12px; opacity: 0.8;">Velocidade</div>
                    </div>
                </div>
                
                <div style="background: rgba(255,255,255,0.1); padding: 10px; border-radius: 8px; margin-bottom: 10px;">
                    <div style="font-size: 14px; font-weight: bold; margin-bottom: 5px;">Próximo Destino:</div>
                    <div id="proximo-destino" style="font-size: 13px;">Carregando...</div>
                    <div style="margin-top: 8px;">
                        <button onclick="recalcularRotaManual()" style="
                            background: rgba(255,255,255,0.2);
                            border: none;
                            color: white;
                            padding: 5px 10px;
                            border-radius: 5px;
                            cursor: pointer;
                            font-size: 11px;
                        ">
                            🔄 Recalcular Rota
                        </button>
                    </div>
                </div>
                
                <div style="display: flex; gap: 8px;">
                    <button onclick="centralizarMapaNavegacao()" style="
                        flex: 1;
                        background: rgba(255,255,255,0.2);
                        border: none;
                        color: white;
                        padding: 8px;
                        border-radius: 5px;
                        cursor: pointer;
                        font-size: 12px;
                    ">
                        <i class="fas fa-crosshairs"></i> Centralizar
                    </button>
                    <button onclick="alternarModoNavegacao()" id="btn-modo-navegacao" title="Alternar entre Modo Norte e Modo de Navegação" style="
                        flex: 1;
                        background: rgba(255,255,255,0.2);
                        border: none;
                        color: white;
                        padding: 8px;
                        border-radius: 5px;
                        cursor: pointer;
                        font-size: 12px;
                    ">
                        <i class="fas fa-compass"></i> <span id="texto-modo">Modo Norte</span>
                    </button>
                    <button onclick="resetarRotacao()" style="
                        flex: 1;
                        background: rgba(255,255,255,0.2);
                        border: none;
                        color: white;
                        padding: 8px;
                        border-radius: 5px;
                        cursor: pointer;
                        font-size: 12px;
                    ">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                    <button onclick="compartilharLocalizacao()" style="
                        flex: 1;
                        background: rgba(255,255,255,0.2);
                        border: none;
                        color: white;
                        padding: 8px;
                        border-radius: 5px;
                        cursor: pointer;
                        font-size: 12px;
                    ">
                        <i class="fas fa-share"></i> Compartilhar
                    </button>
                </div>
            `;
            
            document.body.appendChild(painel);
        }

        /**
         * Alternar tela cheia para o painel de navegação
         */
        function toggleFullscreenNavigation() {
            const painel = document.getElementById('painel-navegacao');
            const btn = document.getElementById('btn-fullscreen-nav');
            if (!painel) return;

            // Se não estiver em fullscreen, pedir para entrar
            if (!document.fullscreenElement) {
                if (painel.requestFullscreen) {
                    painel.requestFullscreen().then(() => {
                        if (btn) btn.innerHTML = '<i class="fas fa-compress"></i> Sair Tela Cheia';
                        // Ajustar mapa após transição
                        setTimeout(() => { if (map && map.invalidateSize) map.invalidateSize(); }, 300);
                    }).catch(err => console.warn('Erro ao entrar em fullscreen:', err));
                } else {
                    // Fallback: aplicar classe que expande visualmente
                    painel.classList.add('painel-fullscreen');
                    if (btn) btn.innerHTML = '<i class="fas fa-compress"></i> Sair Tela Cheia';
                    setTimeout(() => { if (map && map.invalidateSize) map.invalidateSize(); }, 300);
                }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen().then(() => {
                        if (btn) btn.innerHTML = '<i class="fas fa-expand"></i> Tela Cheia';
                        setTimeout(() => { if (map && map.invalidateSize) map.invalidateSize(); }, 300);
                    }).catch(err => console.warn('Erro ao sair do fullscreen:', err));
                } else {
                    painel.classList.remove('painel-fullscreen');
                    if (btn) btn.innerHTML = '<i class="fas fa-expand"></i> Tela Cheia';
                    setTimeout(() => { if (map && map.invalidateSize) map.invalidateSize(); }, 300);
                }
            }
        }

        // Manter botão sincronizado quando o estado de fullscreen mudar (tecla ESC ou API externa)
        document.addEventListener('fullscreenchange', function() {
            const painelBtn = document.getElementById('btn-fullscreen-nav');
            const mapBtn = document.getElementById('map-fullscreen-btn');
            const painel = document.getElementById('painel-navegacao');
            const mapEl = document.getElementById('map');

            if (document.fullscreenElement) {
                // Se entrou em fullscreen, atualizar botões
                if (painelBtn) painelBtn.innerHTML = '<i class="fas fa-compress"></i> Sair Tela Cheia';
                if (mapBtn) mapBtn.innerHTML = '<i class="fas fa-compress"></i> Sair Tela Cheia';

                // Se o elemento em fullscreen for o mapa, garantir que o botão de saída apareça
                if (mapEl && document.fullscreenElement === mapEl) {
                    addMapExitButton();
                }
            } else {
                // Saiu do fullscreen — resetar botões e classes
                if (painelBtn) painelBtn.innerHTML = '<i class="fas fa-expand"></i> Tela Cheia';
                if (mapBtn) mapBtn.innerHTML = '<i class="fas fa-expand"></i> Mapa Tela Cheia';

                if (painel && painel.classList.contains('painel-fullscreen')) {
                    painel.classList.remove('painel-fullscreen');
                }

                // Remover fallback visual do mapa se ainda existir
                if (mapEl && mapEl.classList && mapEl.classList.contains('map-fullscreen')) {
                    mapEl.classList.remove('map-fullscreen');
                }

                // Remover botão de saída caso exista
                removeMapExitButton();
            }

            // Garantir que o mapa redesenhe após mudança de tela cheia
            setTimeout(() => { if (map && map.invalidateSize) map.invalidateSize(); }, 250);
        });

        // Função para alternar fullscreen do mapa
        function toggleMapFullscreen() {
            const mapEl = document.getElementById('map');
            const btn = document.getElementById('map-fullscreen-btn');
            if (!mapEl) return;

            // Se não estiver em fullscreen, tentar entrar com o container do mapa
            if (!document.fullscreenElement) {
                if (mapEl.requestFullscreen) {
                    mapEl.requestFullscreen().then(() => {
                        if (btn) btn.innerHTML = '<i class="fas fa-compress"></i> Sair Tela Cheia';
                        addMapExitButton();
                        setTimeout(() => { if (map && map.invalidateSize) map.invalidateSize(); }, 300);
                    }).catch(err => {
                        console.warn('Erro ao entrar em fullscreen do mapa:', err);
                        // fallback visual
                        mapEl.classList.add('map-fullscreen');
                        if (btn) btn.innerHTML = '<i class="fas fa-compress"></i> Sair Tela Cheia';
                        addMapExitButton();
                        setTimeout(() => { if (map && map.invalidateSize) map.invalidateSize(); }, 300);
                    });
                } else {
                    // fallback visual
                    mapEl.classList.add('map-fullscreen');
                    if (btn) btn.innerHTML = '<i class="fas fa-compress"></i> Sair Tela Cheia';
                    addMapExitButton();
                    setTimeout(() => { if (map && map.invalidateSize) map.invalidateSize(); }, 300);
                }
            } else {
                // Se já estiver em fullscreen, sair
                if (document.exitFullscreen) {
                    document.exitFullscreen().then(() => {
                        if (btn) btn.innerHTML = '<i class="fas fa-expand"></i> Mapa Tela Cheia';
                        removeMapExitButton();
                        setTimeout(() => { if (map && map.invalidateSize) map.invalidateSize(); }, 300);
                    }).catch(err => {
                        console.warn('Erro ao sair do fullscreen do mapa:', err);
                        mapEl.classList.remove('map-fullscreen');
                        if (btn) btn.innerHTML = '<i class="fas fa-expand"></i> Mapa Tela Cheia';
                        removeMapExitButton();
                        setTimeout(() => { if (map && map.invalidateSize) map.invalidateSize(); }, 300);
                    });
                } else {
                    mapEl.classList.remove('map-fullscreen');
                    if (btn) btn.innerHTML = '<i class="fas fa-expand"></i> Mapa Tela Cheia';
                    removeMapExitButton();
                    setTimeout(() => { if (map && map.invalidateSize) map.invalidateSize(); }, 300);
                }
            }
        }

        // Criar botão flutuante para sair do fullscreen do mapa
        function addMapExitButton() {
            // Se já existe, não criar novamente
            if (document.getElementById('map-exit-fullscreen-btn')) return;

            const btn = document.createElement('button');
            btn.id = 'map-exit-fullscreen-btn';
            btn.className = 'map-exit-fullscreen-btn';
            btn.setAttribute('aria-label', 'Sair da tela cheia do mapa');
            btn.innerHTML = '<i class="fas fa-compress"></i> Sair';
            btn.onclick = function(e) {
                e.stopPropagation();
                // Tentar sair do fullscreen (isso acionará fullscreenchange)
                if (document.exitFullscreen) {
                    document.exitFullscreen().catch(() => {});
                }

                // Remover fallback visual se aplicado
                const mapEl = document.getElementById('map');
                if (mapEl && mapEl.classList.contains('map-fullscreen')) {
                    mapEl.classList.remove('map-fullscreen');
                }

                removeMapExitButton();
            };

            // Anexar dentro do container do mapa para ficar acessível no celular
            const mapEl = document.getElementById('map');
            if (mapEl) {
                mapEl.appendChild(btn);
            } else {
                document.body.appendChild(btn);
            }
        }

        // Remover botão flutuante de saída do fullscreen do mapa
        function removeMapExitButton() {
            const existing = document.getElementById('map-exit-fullscreen-btn');
            if (existing) existing.remove();
        }
        
        /**
         * Iniciar tracking de navegação em tempo real
         */
        function iniciarTrackingNavegacao() {
            if (navigator.geolocation) {
                // Ativar tracking de alta precisão
                const opcoes = {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 1000
                };
                
                // Armazenar ID do tracking
                window.navegacaoWatchId = navigator.geolocation.watchPosition(
                    atualizarPosicaoNavegacao,
                    erroNavegacao,
                    opcoes
                );
                
                // Atualizar painel a cada segundo
                window.navegacaoInterval = setInterval(atualizarPainelNavegacao, 1000);
                
                console.log('🗺️ Navegação iniciada com tracking ativo');
            } else {
                alert('❌ Geolocalização não suportada neste dispositivo');
            }
        }
        
        /**
         * Atualizar posição durante navegação com rotação e verificação de desvio
         */
        function atualizarPosicaoNavegacao(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const velocidade = position.coords.speed || 0;
            const heading = position.coords.heading; // Direção da bússola
            
            // Calcular direção baseada no movimento se heading não estiver disponível
            let direcao = heading;
            if (direcao === null || direcao === undefined) {
                if (window.ultimaPosicaoNavegacao) {
                    direcao = calcularDirecaoMovimento(
                        window.ultimaPosicaoNavegacao.lat, 
                        window.ultimaPosicaoNavegacao.lng,
                        lat, 
                        lng
                    );
                }
            }
            
            // Verificar se saiu da rota (se houver uma rota ativa)
            if (rotaAtiva && navegacaoAtiva && velocidade > 1) {
                verificarDesvioRota(lat, lng);
            }
            
            // Atualizar marcador no mapa com rotação
            if (userMarker) {
                userMarker.setLatLng([lat, lng]);
                
                // Atualizar ícone do marcador com direção
                if (direcao !== null && direcao !== undefined) {
                    atualizarIconeMotorista(lat, lng, direcao, velocidade);
                }
            }
            
            // Rotacionar mapa se estiver no modo navegação
            if (modoNavegacao && direcao !== null && direcao !== undefined) {
                rotacionarMapa(direcao);
                ultimaDirecao = direcao;
            }
            
            // Centralizar mapa na posição atual se navegando
            if (navegacaoAtiva) {
                map.setView([lat, lng], map.getZoom(), {
                    animate: true,
                    pan: {
                        duration: 0.5
                    }
                });
            }
            
            // Salvar última posição
            window.ultimaPosicaoNavegacao = { lat, lng, velocidade, direcao };
            
            console.log(`🗺️ Posição: ${lat}, ${lng} - Vel: ${(velocidade * 3.6).toFixed(1)} km/h - Dir: ${direcao ? direcao.toFixed(0) + '°' : 'N/A'}`);
        }
        
        /**
         * Calcular direção do movimento baseado em duas posições
         */
        function calcularDirecaoMovimento(lat1, lng1, lat2, lng2) {
            const dLng = (lng2 - lng1) * Math.PI / 180;
            const lat1Rad = lat1 * Math.PI / 180;
            const lat2Rad = lat2 * Math.PI / 180;
            
            const y = Math.sin(dLng) * Math.cos(lat2Rad);
            const x = Math.cos(lat1Rad) * Math.sin(lat2Rad) - 
                     Math.sin(lat1Rad) * Math.cos(lat2Rad) * Math.cos(dLng);
            
            let bearing = Math.atan2(y, x) * 180 / Math.PI;
            
            // Normalizar para 0-360°
            return (bearing + 360) % 360;
        }
        
        /**
         * Atualizar ícone do motorista com direção
         */
        function atualizarIconeMotorista(lat, lng, direcao, velocidade) {
            // Escolher ícone baseado na velocidade
            let icone, cor;
            if (velocidade > 5) { // Movendo (> 18 km/h)
                icone = 'fa-motorcycle';
                cor = '#28a745'; // Verde
            } else if (velocidade > 1) { // Movendo devagar
                icone = 'fa-motorcycle';
                cor = '#ffc107'; // Amarelo
            } else { // Parado
                icone = 'fa-motorcycle';
                cor = '#dc3545'; // Vermelho
            }
            
            // Criar HTML do marcador com rotação
            const marcadorHTML = `
                <div style="
                    transform: rotate(${direcao}deg);
                    transition: transform 0.5s ease;
                ">
                    <div style="
                        background: ${cor};
                        color: white;
                        border-radius: 50%;
                        width: 35px;
                        height: 35px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-weight: bold;
                        border: 3px solid white;
                        box-shadow: 0 3px 10px rgba(0,0,0,0.4);
                        position: relative;
                    ">
                        <i class="fas ${icone}" style="font-size: 16px;"></i>
                        <div style="
                            position: absolute;
                            top: -5px;
                            right: -5px;
                            width: 12px;
                            height: 12px;
                            background: ${cor};
                            border: 2px solid white;
                            border-radius: 50%;
                            animation: pulse 2s infinite;
                        "></div>
                    </div>
                </div>
            `;
            
            // Atualizar marcador
            if (userMarker) {
                userMarker.setIcon(L.divIcon({
                    html: marcadorHTML,
                    iconSize: [35, 35],
                    className: 'custom-motorista-marker'
                }));
            }
        }
        
        /**
         * Rotacionar mapa baseado na direção
         */
        function rotacionarMapa(direcao) {
            // Aplicar rotação suave ao container do mapa
            const mapContainer = document.getElementById('map');
            if (mapContainer) {
                // Rotacionar para que a direção do movimento fique "para cima"
                const rotacao = -direcao; // Negativo para rotacionar mapa na direção oposta
                
                mapContainer.style.transform = `rotate(${rotacao}deg)`;
                mapContainer.style.transition = 'transform 1s ease';
                
                // Atualizar borda para indicar modo navegação
                mapContainer.style.border = '3px solid #28a745';
                mapContainer.style.borderRadius = '15px';
            }
        }
        
        /**
         * Alternar modo de navegação (Norte fixo vs Direção)
         */
        function alternarModoNavegacao() {
            modoNavegacao = !modoNavegacao;
            
            const btnTexto = document.getElementById('texto-modo');
            const mapContainer = document.getElementById('map');
            
            if (modoNavegacao) {
                // Ativar modo navegação
                btnTexto.textContent = 'Modo de Navegação';
                navegacaoAtiva = true;
                
                // Aplicar rotação atual se houver
                if (ultimaDirecao) {
                    rotacionarMapa(ultimaDirecao);
                }
                
                mostrarNotificacao(
                    '🧭 Modo de Navegação Ativado',
                    'Mapa agora gira seguindo sua direção (modo de condução)',
                    'success'
                );
            } else {
                // Voltar ao modo norte
                btnTexto.textContent = 'Modo Norte';
                navegacaoAtiva = false;
                
                // Resetar rotação
                if (mapContainer) {
                    mapContainer.style.transform = 'rotate(0deg)';
                    mapContainer.style.border = 'none';
                    mapContainer.style.borderRadius = '10px';
                }
                
                mostrarNotificacao(
                    '🧭 Modo Norte Ativado',
                    'Mapa fixo com norte para cima',
                    'info'
                );
            }
        }
        
        /**
         * Resetar rotação do mapa
         */
        function resetarRotacao() {
            const mapContainer = document.getElementById('map');
            if (mapContainer) {
                mapContainer.style.transform = 'rotate(0deg)';
                mapContainer.style.border = 'none';
                mapContainer.style.borderRadius = '10px';
            }
            
            modoNavegacao = false;
            navegacaoAtiva = false;
            ultimaDirecao = 0;
            
            const btnTexto = document.getElementById('texto-modo');
            if (btnTexto) {
                btnTexto.textContent = 'Norte';
            }
            
            mostrarNotificacao('🔄 Rotação resetada', 'Mapa voltou à orientação original', 'info');
        }
        
        /**
         * Atualizar painel de navegação
         */
        function atualizarPainelNavegacao() {
            if (!window.ultimaPosicaoNavegacao) return;
            
            const posicao = window.ultimaPosicaoNavegacao;
            
            // Atualizar velocidade
            const velocidadeKmh = (posicao.velocidade * 3.6) || 0;
            const velElement = document.getElementById('nav-velocidade');
            if (velElement) {
                velElement.textContent = velocidadeKmh.toFixed(0) + ' km/h';
            }
            
            // Simular atualização de distância e tempo (seria calculado com base no próximo destino)
            const distElement = document.getElementById('nav-distancia');
            const tempoElement = document.getElementById('nav-tempo');
            
            if (distElement && tempoElement) {
                // Aqui você calcularia a distância real para o próximo destino
                distElement.textContent = '1.2 km'; // Placeholder
                tempoElement.textContent = '4 min'; // Placeholder
            }
        }
        
        /**
         * Parar navegação
         */
        function pararNavegacao() {
            // Parar tracking
            if (window.navegacaoWatchId) {
                navigator.geolocation.clearWatch(window.navegacaoWatchId);
                window.navegacaoWatchId = null;
            }
            
            // Parar interval
            if (window.navegacaoInterval) {
                clearInterval(window.navegacaoInterval);
                window.navegacaoInterval = null;
            }
            
            // Limpar variáveis de rota
            rotaAtiva = null;
            destinoAtivo = null;
            navegacaoAtiva = false;
            contadorDesvios = 0;
            
            // Ocultar avisos
            ocultarAvisoDesvio();
            
            // Remover painel
            const painel = document.getElementById('painel-navegacao');
            if (painel) {
                // Se estivermos em fullscreen, sair primeiro
                try {
                    if (document.fullscreenElement && document.exitFullscreen) {
                        document.exitFullscreen().catch(() => {});
                    }
                } catch (e) {
                    // ignore
                }

                // Remover classe fallback se presente
                if (painel.classList && painel.classList.contains('painel-fullscreen')) {
                    painel.classList.remove('painel-fullscreen');
                }

                painel.remove();
            }
            
            console.log('🛑 Navegação parada');
        }
        
        /**
         * Centralizar mapa na navegação
         */
        function centralizarMapaNavegacao() {
            if (window.ultimaPosicaoNavegacao) {
                const pos = window.ultimaPosicaoNavegacao;
                map.setView([pos.lat, pos.lng], 17);
            }
        }
        
        /**
         * Alterar modo do mapa
         */
        function alterarModoMapa() {
            // Implementar troca entre normal e satélite
            alert('🗺️ Modo satélite em desenvolvimento!');
        }
        
        /**
         * Compartilhar localização
         */
        function compartilharLocalizacao() {
            if (window.ultimaPosicaoNavegacao) {
                const pos = window.ultimaPosicaoNavegacao;
                const url = `https://maps.google.com/maps?q=${pos.lat},${pos.lng}`;
                
                if (navigator.share) {
                    navigator.share({
                        title: 'Minha localização atual',
                        url: url
                    });
                } else {
                    // Fallback para copiar para clipboard
                    navigator.clipboard.writeText(url).then(() => {
                        alert('📍 Link copiado para a área de transferência!');
                    });
                }
            }
        }
        
        /**
         * Verificar se o usuário saiu da rota planejada
         */
        function verificarDesvioRota(latAtual, lngAtual) {
            if (!rotaAtiva || rotaAtiva.length < 2) return;
            
            // Encontrar o ponto mais próximo da rota
            let menorDistancia = Infinity;
            let pontoMaisProximo = null;
            
            for (let i = 0; i < rotaAtiva.length; i++) {
                const pontoRota = rotaAtiva[i];
                const distancia = calcularDistanciaHaversine(
                    latAtual, lngAtual, 
                    pontoRota[0], pontoRota[1]
                );
                
                if (distancia < menorDistancia) {
                    menorDistancia = distancia;
                    pontoMaisProximo = pontoRota;
                }
            }
            
            const distanciaMetros = menorDistancia * 1000;
            
            console.log(`🔍 Distância da rota: ${distanciaMetros.toFixed(0)}m (máx: ${distanciaMaximaDesvio}m)`);
            
            // Se está muito longe da rota
            if (distanciaMetros > distanciaMaximaDesvio) {
                contadorDesvios++;
                
                // Mostrar aviso visual
                mostrarAvisoDesvio(distanciaMetros);
                
                // Recalcular após 3 desvios consecutivos ou se passou mais de 30 segundos
                const agora = Date.now();
                if (contadorDesvios >= 3 || (agora - ultimoRecalculo) > 30000) {
                    recalcularRota(latAtual, lngAtual);
                    contadorDesvios = 0;
                    ultimoRecalculo = agora;
                }
            } else {
                // Voltar à rota - resetar contador
                if (contadorDesvios > 0) {
                    contadorDesvios = 0;
                    ocultarAvisoDesvio();
                    mostrarNotificacao(
                        '✅ De volta à rota!', 
                        'Você retornou ao caminho planejado', 
                        'success'
                    );
                }
            }
        }
        
        /**
         * Mostrar aviso visual de desvio
         */
        function mostrarAvisoDesvio(distanciaMetros) {
            let avisoElement = document.getElementById('aviso-desvio');
            
            if (!avisoElement) {
                avisoElement = document.createElement('div');
                avisoElement.id = 'aviso-desvio';
                avisoElement.style.cssText = `
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background: #ff6b6b;
                    color: white;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 5px 20px rgba(0,0,0,0.4);
                    z-index: 2500;
                    text-align: center;
                    max-width: 300px;
                    animation: pulse 1s infinite;
                `;
                document.body.appendChild(avisoElement);
            }
            
            avisoElement.innerHTML = `
                <div style="font-size: 24px; margin-bottom: 10px;">🚨</div>
                <div style="font-weight: bold; margin-bottom: 10px;">Fora da Rota!</div>
                <div style="font-size: 14px; margin-bottom: 15px;">Você está ${distanciaMetros.toFixed(0)}m longe do caminho</div>
                <button onclick="recalcularRotaManual()" style="
                    background: white;
                    color: #ff6b6b;
                    border: none;
                    padding: 8px 15px;
                    border-radius: 5px;
                    cursor: pointer;
                    font-weight: bold;
                ">
                    🔄 Recalcular Agora
                </button>
            `;
        }
        
        /**
         * Ocultar aviso de desvio
         */
        function ocultarAvisoDesvio() {
            const avisoElement = document.getElementById('aviso-desvio');
            if (avisoElement) {
                avisoElement.remove();
            }
        }
        
        /**
         * Recalcular rota automaticamente
         */
        async function recalcularRota(latAtual, lngAtual) {
            if (!destinoAtivo) return;
            
            try {
                console.log('🔄 Recalculando rota...');
                
                mostrarNotificacao(
                    '🔄 Recalculando rota...', 
                    'Encontrando novo caminho para o destino', 
                    'info'
                );
                
                // Calcular nova rota
                const origem = { lat: latAtual, lng: lngAtual };
                const resultado = await calcularRotaMultiplasAPIs(origem, destinoAtivo);
                
                if (resultado) {
                    // Atualizar rota ativa
                    rotaAtiva = resultado.route;
                    
                    // Redesenhar no mapa
                    desenharRotaNoMapa(origem, destinoAtivo, resultado.route, resultado.instructions);
                    
                    // Ocultar aviso de desvio
                    ocultarAvisoDesvio();
                    
                    // Mostrar confirmação
                    mostrarNotificacao(
                        '✅ Rota recalculada!', 
                        `Nova rota: ${resultado.distance} • ${resultado.duration}`, 
                        'success'
                    );
                    
                    console.log('✅ Rota recalculada com sucesso');
                } else {
                    throw new Error('Não foi possível calcular nova rota');
                }
                
            } catch (error) {
                console.error('❌ Erro ao recalcular rota:', error);
                mostrarNotificacao(
                    '❌ Erro no recálculo', 
                    'Não foi possível recalcular a rota', 
                    'error'
                );
            }
        }
        
        /**
         * Recalcular rota manualmente (botão)
         */
        async function recalcularRotaManual() {
            if (!window.ultimaPosicaoNavegacao) {
                alert('📍 Localização atual não disponível');
                return;
            }
            
            const pos = window.ultimaPosicaoNavegacao;
            await recalcularRota(pos.lat, pos.lng);
        }
        
        /**
         * Tratamento de erros de navegação
         */
        function erroNavegacao(error) {
            console.error('❌ Erro na navegação:', error.message);
        }

        /**
         * Ver rota no mapa interno (sem redirecionamento)
         */
        async function verRotaInterna(destLat, destLng, pedidoId) {
            try {
                // Obter localização atual
                const posicaoAtual = await obterLocalizacaoAtual();
                if (!posicaoAtual) {
                    alert('❌ Não foi possível obter sua localização atual');
                    return;
                }

                console.log(`🗺️ Mostrando rota no mapa interno: [${posicaoAtual.lat}, ${posicaoAtual.lng}] para [${destLat}, ${destLng}]`);
                
                // Calcular rota usando APIs gratuitas
                const resultado = await calcularRotaMultiplasAPIs(posicaoAtual, {lat: destLat, lng: destLng});
                
                if (resultado) {
                    // Desenhar rota no mapa interno
                    desenharRotaNoMapa(posicaoAtual, {lat: destLat, lng: destLng}, resultado.route, resultado.instructions);
                    
                    // Centralizar mapa na rota
                    centralizarMapaNaRota(posicaoAtual, {lat: destLat, lng: destLng});
                    
                    // Mostrar informações da rota no card do pedido
                    mostrarResultadoRota(resultado, pedidoId);
                    
                    // Mostrar notificação de sucesso
                    mostrarNotificacao(
                        `🗺️ Rota traçada no mapa!`,
                        `Distância: ${resultado.distance} • Tempo: ${resultado.duration}`,
                        'success'
                    );
                } else {
                    // Se APIs falharam, desenhar linha reta
                    const rotaSimples = calcularRotaSimples(posicaoAtual, {lat: destLat, lng: destLng});
                    desenharRotaNoMapa(posicaoAtual, {lat: destLat, lng: destLng}, rotaSimples.route, []);
                    centralizarMapaNaRota(posicaoAtual, {lat: destLat, lng: destLng});
                    mostrarResultadoRota(rotaSimples, pedidoId);
                    
                    mostrarNotificacao(
                        `🗺️ Rota estimada traçada`,
                        `Distância: ${rotaSimples.distance} • Tempo: ${rotaSimples.duration}`,
                        'warning'
                    );
                }
                
            } catch (error) {
                console.error('❌ Erro ao mostrar rota:', error);
                mostrarNotificacao('❌ Erro ao traçar rota', error.message, 'error');
            }
        }
        
        /**
         * Mostrar notificação no sistema
         */
        function mostrarNotificacao(titulo, mensagem, tipo = 'info') {
            // Remover notificações anteriores
            const notificacaoExistente = document.getElementById('notificacao-sistema');
            if (notificacaoExistente) {
                notificacaoExistente.remove();
            }
            
            // Cores por tipo
            const cores = {
                'success': '#28a745',
                'warning': '#ffc107',
                'error': '#dc3545',
                'info': '#17a2b8'
            };
            
            const cor = cores[tipo] || cores['info'];
            
            // Criar notificação
            const notificacao = document.createElement('div');
            notificacao.id = 'notificacao-sistema';
            notificacao.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${cor};
                color: white;
                padding: 15px 20px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.3);
                z-index: 2000;
                max-width: 300px;
                animation: slideIn 0.3s ease-out;
            `;
            
            notificacao.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px;">
                    <div>
                        <div style="font-weight: bold; margin-bottom: 5px;">${titulo}</div>
                        <div style="font-size: 14px; opacity: 0.9;">${mensagem}</div>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" style="
                        background: none;
                        border: none;
                        color: white;
                        cursor: pointer;
                        font-size: 18px;
                        padding: 0;
                        line-height: 1;
                    ">&times;</button>
                </div>
            `;
            
            // Adicionar CSS de animação
            if (!document.getElementById('notificacao-styles')) {
                const styles = document.createElement('style');
                styles.id = 'notificacao-styles';
                styles.innerHTML = `
                    @keyframes slideIn {
                        from {
                            transform: translateX(100%);
                            opacity: 0;
                        }
                        to {
                            transform: translateX(0);
                            opacity: 1;
                        }
                    }
                `;
                document.head.appendChild(styles);
            }
            
            document.body.appendChild(notificacao);
            
            // Auto-remover após 5 segundos
            setTimeout(() => {
                if (notificacao && notificacao.parentElement) {
                    notificacao.remove();
                }
            }, 5000);
        }

        // Parsers para diferentes APIs de roteamento com ruas reais
        function parseProxyResponse(data) {
            try {
                // O proxy retorna dados já processados
                if (data.success && data.route) {
                    return {
                        distance: data.distance,
                        duration: data.duration,
                        route: data.route,
                        method: data.method || 'Proxy PHP',
                        instructions: data.instructions || []
                    };
                }
                console.log('❌ Proxy: resposta inválida');
                return null;
            } catch (error) {
                console.log('❌ Erro parseProxyResponse:', error);
                return null;
            }
        }
        
        function parseOpenRouteService(data) {
            try {
                if (!data.features || !data.features[0]) {
                    console.log('❌ OpenRouteService: dados inválidos');
                    return null;
                }
                
                const route = data.features[0];
                const properties = route.properties;
                const geometry = route.geometry;
                
                // Extrair coordenadas da geometria (já vem no formato [lng, lat])
                const coordinates = geometry.coordinates.map(coord => [coord[1], coord[0]]); // Inverter para [lat, lng]
                
                return {
                    distance: `${(properties.segments[0].distance / 1000).toFixed(1)} km`,
                    duration: `${Math.ceil(properties.segments[0].duration / 60)} min`,
                    route: coordinates,
                    method: 'OpenRouteService (ruas reais)',
                    instructions: properties.segments[0].steps || []
                };
            } catch (error) {
                console.log('❌ Erro parseOpenRouteService:', error);
                return null;
            }
        }

        function parseOSRM(data) {
            try {
                console.log('🔧 parseOSRM chamado com dados:', data);
                
                if (!data.routes || !data.routes[0]) {
                    console.log('❌ OSRM: nenhuma rota encontrada');
                    return null;
                }
                
                const route = data.routes[0];
                const geometry = route.geometry;
                
                console.log('📄 OSRM rota:', {
                    distance: route.distance,
                    duration: route.duration,
                    geometryType: geometry ? geometry.type : 'N/A',
                    coordinatesLength: geometry && geometry.coordinates ? geometry.coordinates.length : 0
                });
                
                if (!geometry || !geometry.coordinates || geometry.coordinates.length < 2) {
                    console.log('❌ OSRM: geometria inválida');
                    return null;
                }
                
                // OSRM retorna coordenadas no formato [lng, lat]
                const coordinates = geometry.coordinates.map(coord => [coord[1], coord[0]]); // Inverter para [lat, lng]
                
                const resultado = {
                    distance: `${(route.distance / 1000).toFixed(1)} km`,
                    duration: `${Math.ceil(route.duration / 60)} min`,
                    route: coordinates,
                    method: 'OSRM (ruas reais)',
                    instructions: route.legs && route.legs[0] && route.legs[0].steps ? route.legs[0].steps : []
                };
                
                console.log('✅ OSRM resultado final:', resultado);
                return resultado;
                
            } catch (error) {
                console.log('❌ Erro parseOSRM:', error);
                return null;
            }
        }

        function parseGraphHopper(data) {
            try {
                if (!data.paths || !data.paths[0]) {
                    console.log('❌ GraphHopper: nenhuma rota encontrada');
                    return null;
                }
                
                const path = data.paths[0];
                
                // GraphHopper retorna points como array de coordenadas
                let coordinates = [];
                if (path.points && path.points.coordinates) {
                    // Formato GeoJSON
                    coordinates = path.points.coordinates.map(coord => [coord[1], coord[0]]);
                } else if (path.points && Array.isArray(path.points)) {
                    // Formato array simples
                    for (let i = 0; i < path.points.length; i += 2) {
                        coordinates.push([path.points[i+1], path.points[i]]); // [lat, lng]
                    }
                }
                
                return {
                    distance: `${(path.distance / 1000).toFixed(1)} km`,
                    duration: `${Math.ceil(path.time / 60000)} min`,
                    route: coordinates,
                    method: 'GraphHopper',
                    instructions: path.instructions || []
                };
            } catch (error) {
                console.log('❌ Erro parseGraphHopper:', error);
                return null;
            }
        }

        function parseMapbox(data) {
            try {
                if (!data.routes || !data.routes[0]) {
                    console.log('❌ Mapbox: nenhuma rota encontrada');
                    return null;
                }
                
                const route = data.routes[0];
                const geometry = route.geometry;
                
                // Mapbox retorna coordenadas no formato [lng, lat]
                const coordinates = geometry.coordinates.map(coord => [coord[1], coord[0]]); // Inverter para [lat, lng]
                
                return {
                    distance: `${(route.distance / 1000).toFixed(1)} km`,
                    duration: `${Math.ceil(route.duration / 60)} min`,
                    route: coordinates,
                    method: 'Mapbox',
                    instructions: route.legs[0].steps || []
                };
            } catch (error) {
                console.log('❌ Erro parseMapbox:', error);
                return null;
            }
        }
        /**
         * Abrir navegação externa (função legada mantida para compatibilidade)
         */
        function verRotaNoMapa(lat, lng, pedidoId) {
            // Redirecionar para função interna por padrão
            verRotaInterna(lat, lng, pedidoId);
        }
        
        /**
         * Abrir navegação externa (melhorada)
         */
        function abrirNavegacaoExterna(lat, lng) {
            const userAgent = navigator.userAgent || navigator.vendor || window.opera;
            
            // Detectar plataforma e abrir app apropriado
            if (/iPad|iPhone|iPod/.test(userAgent)) {
                // iOS - tentar Apple Maps primeiro, depois Google Maps
                const appleMapsUrl = `http://maps.apple.com/?daddr=${lat},${lng}&dirflg=d`;
                const googleMapsUrl = `https://maps.google.com/maps?daddr=${lat},${lng}&amp;ll=`;
                
                window.open(appleMapsUrl, '_blank');
                
                setTimeout(() => {
                    if (confirm('Apple Maps não abriu? Tentar Google Maps?')) {
                        window.open(googleMapsUrl, '_blank');
                    }
                }, 2000);
                
            } else if (/android/i.test(userAgent)) {
                // Android - tentar Google Maps
                const googleMapsUrl = `https://maps.google.com/maps?daddr=${lat},${lng}&amp;ll=`;
                window.open(googleMapsUrl, '_blank');
                
            } else {
                // Desktop - abrir Google Maps no navegador
                const googleMapsUrl = `https://maps.google.com/maps?daddr=${lat},${lng}&amp;ll=`;
                window.open(googleMapsUrl, '_blank');
            }
        }

    </script>
</body>
</html>