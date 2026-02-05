<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <title>Bot WhatsApp - <?= $data['config']->config_nome ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
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
    <!-- Load jQuery first to avoid reference errors -->
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.js"></script>
    
    <style>
        .bot-container {
            padding: 20px;
        }
        
        /* Modern QR Section */
        .qr-section {
            text-align: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
            border-radius: 16px;
            margin: 30px auto;
            max-width: 900px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        
        .qr-section h4 {
            font-size: 20px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        
        .qr-section .subtitle {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 30px;
        }
        
        #qr-container {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin: 0 auto 25px;
            max-width: 350px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }
        
        #qr-image {
            max-width: 280px !important;
            width: 100%;
            height: auto;
            border: 2px solid #e9ecef !important;
            border-radius: 12px !important;
            padding: 15px !important;
            background: white !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }
        
        #qr-image:hover {
            transform: scale(1.02);
        }
        
        #qr-message {
            font-size: 14px;
            color: #6c757d;
            margin: 0;
            line-height: 1.6;
        }
        
        .status-badge {
            display: inline-block;
            padding: 10px 24px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
            margin: 15px 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            transition: all 0.3s ease;
        }
        
        .status-connected {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }
        
        .status-disconnected {
            background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
            color: white;
        }
        
        .status-connecting {
            background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
            color: #000;
        }
        
        .status-qr_ready {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            color: white;
        }
        
        .connection-info {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .connection-info h4 {
            margin-top: 0;
            color: #1976D2;
        }
        
        /* Modern Buttons */
        .btn-connect {
            padding: 14px 32px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
            margin: 5px;
        }
        
        .btn-connect:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .btn-connect:active {
            transform: translateY(0);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }
        
        .btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
            color: #000;
        }
        
        .btn-info {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        }
        
        .help-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .help-buttons .btn-sm {
            padding: 8px 20px;
            font-size: 13px;
            border-radius: 20px;
            border: 1px solid #dee2e6;
            background: white;
            color: #495057;
            transition: all 0.3s ease;
        }
        
        .help-buttons .btn-sm:hover {
            background: #f8f9fa;
            border-color: #adb5bd;
            transform: translateY(-1px);
        }
        
        .webhook-section {
            margin-top: 30px;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        
        .help-text {
            color: #666;
            font-size: 13px;
            margin-top: 5px;
        }
        
        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        
        #loading-overlay.active {
            display: flex;
        }
        
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Animação de pulsação para o badge */
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.15);
                opacity: 0.8;
            }
        }
        
        .badge-pulse {
            animation: pulse 2s ease-in-out infinite;
        }
        
        /* Animações do Painel de Atendimento */
        #btn-atualizar-sessoes {
            transition: all 0.3s ease !important;
        }
        
        #btn-atualizar-sessoes:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 8px rgba(23,162,184,0.4) !important;
        }
        
        #btn-atualizar-sessoes:active {
            transform: translateY(0) !important;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .panel.panel-default {
            animation: fadeInUp 0.5s ease-out;
        }
        
        #btn-abrir-atendimento {
            position: relative;
        }
        
        #btn-abrir-atendimento .badge {
            transition: all 0.3s ease;
        }
        
        /* Animações dos Cards de Stats */
        .stats-card:hover {
            transform: translateY(-5px) !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
        }
        
        @keyframes countUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .stat-update {
            animation: countUp 0.5s ease-out;
        }
    </style>
</head>

<body class="animated">
    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php require_once 'side-menu.php'; ?>
        </div>
        
        <div class="container-fluid" id="pcont">
            <div class="cl-mcont">
                <div class="block-flat">
                    <div class="header">
                        <h3><i class="fa fa-whatsapp" style="color: #25D366;"></i> Bot WhatsApp</h3>
                    </div>
                    
                    <div class="content bot-container">
                        <!-- Status da Conexão -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center">
                                   
                                </div>
                            </div>
                        </div>

                        <!-- QR Code Section -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="qr-section">
                                    <div id="qr-title-section">
                                        <h4><i class="fa fa-qrcode" style="color: #25D366;"></i> Conectar WhatsApp</h4>
                                        <p class="subtitle">Escaneie o QR Code com seu celular para iniciar</p>
                                    </div>
                                    
                                    <div id="qr-container">
                                        <img id="qr-image" src="" alt="QR Code" style="display: none;">
                                        <p id="qr-message" class="text-muted">
                                            <i class="fa fa-mobile" style="font-size: 48px; color: #25D366; margin-bottom: 15px; display: block;"></i>
                                            Clique em "Conectar WhatsApp" para gerar o QR Code
                                        </p>
                                    </div>
                                    
                                     <h4>Status da Conexão</h4>
                                    <span class="status-badge status-disconnected" id="connection-status">
                                        Desconectado
                                    </span>

                                    <div>
                                        <button type="button" class="btn btn-success btn-connect" id="btn-connect">
                                            <i class="fa fa-whatsapp"></i> Conectar WhatsApp
                                        </button>
                                        
                                        <button type="button" class="btn btn-danger btn-connect" id="btn-disconnect" style="display: none;">
                                            <i class="fa fa-power-off"></i> Desconectar
                                        </button>
                                    </div>
                                    
                                    <div class="help-buttons">
                                        <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modal-como-conectar">
                                            <i class="fa fa-info-circle"></i> Como Conectar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Configuração de API (oculto por padrão) -->
                        <div class="webhook-section" style="display: none;">
                            <h4><i class="fa fa-cog"></i> Configurações Avançadas</h4>
                            <p class="help-text">Configure os endpoints de webhook para integração com o bot</p>
                            
                            <form id="form-webhook">
                                <input type="hidden" id="session" name="session" value="<?= $data['config']->config_token ?>">
                                <input type="hidden" id="apitoken" name="apitoken" value="ApiGratisToken2021">
                                <input type="hidden" id="sessionkey" name="sessionkey" value="<?= $data['config']->config_token ?>">
                                
                                <div class="form-group">
                                    <label for="wh_status">Webhook Status Mensagens:</label>
                                    <input type="text" class="form-control" id="wh_status" name="wh_status" 
                                           placeholder="https://seusite.com/webhook/status">
                                    <span class="help-text">URL que recebe o status das mensagens enviadas</span>
                                </div>
                                
                                <div class="form-group">
                                    <label for="wh_message">Webhook Mensagens Recebidas:</label>
                                    <input type="text" class="form-control" id="wh_message" name="wh_message" 
                                           placeholder="https://seusite.com/webhook/message">
                                    <span class="help-text">URL que recebe as mensagens recebidas pelo bot</span>
                                </div>
                                
                                <div class="form-group">
                                    <label for="wh_qrcode">Webhook QR Code:</label>
                                    <input type="text" class="form-control" id="wh_qrcode" name="wh_qrcode" 
                                           placeholder="https://seusite.com/webhook/qrcode">
                                    <span class="help-text">URL que recebe o QR Code gerado</span>
                                </div>
                                
                                <div class="form-group">
                                    <label for="wh_connect">Webhook Status Conexão:</label>
                                    <input type="text" class="form-control" id="wh_connect" name="wh_connect" 
                                           placeholder="https://seusite.com/webhook/connect">
                                    <span class="help-text">URL que recebe o status da conexão</span>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Salvar Configurações
                                </button>
                            </form>
                        </div>

                        <!-- 📊 PAINEL DE MONITORAMENTO E ESTATÍSTICAS -->
                        <div class="row" style="margin-top: 30px;">
                            <div class="col-md-12">
                                <div class="panel panel-default" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;">
                                    <!-- Header do Painel -->
                                    <div class="panel-heading" style="background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%); color: white; padding: 20px; border: none;">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <div>
                                                <h3 style="margin: 0; font-weight: 600; font-size: 20px;">
                                                    <i class="fa fa-line-chart" style="margin-right: 10px;"></i>
                                                    Monitor de Envios e Estatísticas
                                                </h3>
                                                <p style="margin: 5px 0 0 0; opacity: 0.9; font-size: 13px;">
                                                    Acompanhe em tempo real os envios e limites do bot
                                                </p>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-sm" id="btn-atualizar-stats"
                                                        style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 8px 16px; border-radius: 6px; font-weight: 500; transition: all 0.3s ease;">
                                                    <i class="fa fa-refresh"></i> Atualizar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Corpo do Painel -->
                                    <div class="panel-body" style="padding: 25px; background: #f8f9fa;">
                                        
                                        <!-- Cards de Estatísticas -->
                                        <div class="row" style="margin-bottom: 25px;">
                                            <!-- Card: Mensagens Hoje -->
                                            <div class="col-md-3 col-sm-6">
                                                <div style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 8px; padding: 20px; color: white; box-shadow: 0 2px 8px rgba(40,167,69,0.3); transition: transform 0.3s ease;" class="stats-card">
                                                    <div style="display: flex; justify-content: space-between; align-items: start;">
                                                        <div>
                                                            <p style="margin: 0; opacity: 0.9; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Mensagens Hoje</p>
                                                            <h2 id="stat-msgs-hoje" style="margin: 8px 0 0 0; font-size: 36px; font-weight: 700;">0</h2>
                                                        </div>
                                                        <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                            <i class="fa fa-paper-plane" style="font-size: 24px;"></i>
                                                        </div>
                                                    </div>
                                                    <p style="margin: 10px 0 0 0; font-size: 11px; opacity: 0.8;"><i class="fa fa-clock-o"></i> Últimas 24h</p>
                                                </div>
                                            </div>
                                            
                                            <!-- Card: Fila Pendente -->
                                            <div class="col-md-3 col-sm-6">
                                                <div style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); border-radius: 8px; padding: 20px; color: #000; box-shadow: 0 2px 8px rgba(255,193,7,0.3); transition: transform 0.3s ease;" class="stats-card">
                                                    <div style="display: flex; justify-content: space-between; align-items: start;">
                                                        <div>
                                                            <p style="margin: 0; opacity: 0.8; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Fila Pendente</p>
                                                            <h2 id="stat-fila-pendente" style="margin: 8px 0 0 0; font-size: 36px; font-weight: 700;">0</h2>
                                                        </div>
                                                        <div style="width: 50px; height: 50px; background: rgba(0,0,0,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                            <i class="fa fa-hourglass-half" style="font-size: 24px;"></i>
                                                        </div>
                                                    </div>
                                                    <p id="stat-fila-status" style="margin: 10px 0 0 0; font-size: 11px; opacity: 0.7;"><i class="fa fa-info-circle"></i> Aguardando envio</p>
                                                </div>
                                            </div>
                                            
                                            <!-- Card: Limite Diário -->
                                            <div class="col-md-3 col-sm-6">
                                                <div style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); border-radius: 8px; padding: 20px; color: white; box-shadow: 0 2px 8px rgba(23,162,184,0.3); transition: transform 0.3s ease;" class="stats-card">
                                                    <div style="display: flex; justify-content: space-between; align-items: start;">
                                                        <div>
                                                            <p style="margin: 0; opacity: 0.9; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Limite Diário</p>
                                                            <h2 style="margin: 8px 0 0 0; font-size: 36px; font-weight: 700;">100</h2>
                                                        </div>
                                                        <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                            <i class="fa fa-shield" style="font-size: 24px;"></i>
                                                        </div>
                                                    </div>
                                                    <p style="margin: 10px 0 0 0; font-size: 11px; opacity: 0.8;"><i class="fa fa-check-circle"></i> Por contato/dia</p>
                                                </div>
                                            </div>
                                            
                                            <!-- Card: Delay Aleatório -->
                                            <div class="col-md-3 col-sm-6">
                                                <div style="background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%); border-radius: 8px; padding: 20px; color: white; box-shadow: 0 2px 8px rgba(111,66,193,0.3); transition: transform 0.3s ease;" class="stats-card">
                                                    <div style="display: flex; justify-content: space-between; align-items: start;">
                                                        <div>
                                                            <p style="margin: 0; opacity: 0.9; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Delay Aleatório</p>
                                                            <h2 style="margin: 8px 0 0 0; font-size: 36px; font-weight: 700;">3-7s</h2>
                                                        </div>
                                                        <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                            <i class="fa fa-random" style="font-size: 24px;"></i>
                                                        </div>
                                                    </div>
                                                    <p style="margin: 10px 0 0 0; font-size: 11px; opacity: 0.8;"><i class="fa fa-user-secret"></i> Comportamento humano</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Pedidos por Status -->
                                        <div class="row" style="margin-bottom: 25px;">
                                            <div class="col-md-12">
                                                <div style="background: white; border-radius: 8px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                                                    <h4 style="margin: 0 0 15px 0; font-size: 16px; font-weight: 600; color: #2c3e50;">
                                                        <i class="fa fa-shopping-cart" style="color: #6f42c1; margin-right: 8px;"></i>
                                                        Pedidos Hoje por Status
                                                    </h4>
                                                    <div class="row">
                                                        <div class="col-md-2 col-sm-4 col-xs-6" style="text-align: center; padding: 15px;">
                                                            <div style="background: #fff3cd; border-radius: 8px; padding: 15px; border-left: 4px solid #ffc107;">
                                                                <i class="fa fa-tasks" style="font-size: 24px; color: #ffc107; display: block; margin-bottom: 8px;"></i>
                                                                <h3 id="pedido-producao" style="margin: 0; font-size: 28px; font-weight: 700; color: #856404;">0</h3>
                                                                <p style="margin: 5px 0 0 0; font-size: 11px; color: #856404; font-weight: 500;">Produção</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-sm-4 col-xs-6" style="text-align: center; padding: 15px;">
                                                            <div style="background: #d1ecf1; border-radius: 8px; padding: 15px; border-left: 4px solid #17a2b8;">
                                                                <i class="fa fa-truck" style="font-size: 24px; color: #17a2b8; display: block; margin-bottom: 8px;"></i>
                                                                <h3 id="pedido-saiu-entrega" style="margin: 0; font-size: 28px; font-weight: 700; color: #0c5460;">0</h3>
                                                                <p style="margin: 5px 0 0 0; font-size: 11px; color: #0c5460; font-weight: 500;">Saiu Entrega</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-sm-4 col-xs-6" style="text-align: center; padding: 15px;">
                                                            <div style="background: #d4edda; border-radius: 8px; padding: 15px; border-left: 4px solid #28a745;">
                                                                <i class="fa fa-check-circle" style="font-size: 24px; color: #28a745; display: block; margin-bottom: 8px;"></i>
                                                                <h3 id="pedido-entregue" style="margin: 0; font-size: 28px; font-weight: 700; color: #155724;">0</h3>
                                                                <p style="margin: 5px 0 0 0; font-size: 11px; color: #155724; font-weight: 500;">Entregues</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-sm-4 col-xs-6" style="text-align: center; padding: 15px;">
                                                            <div style="background: #f8d7da; border-radius: 8px; padding: 15px; border-left: 4px solid #dc3545;">
                                                                <i class="fa fa-times-circle" style="font-size: 24px; color: #dc3545; display: block; margin-bottom: 8px;"></i>
                                                                <h3 id="pedido-cancelado" style="margin: 0; font-size: 28px; font-weight: 700; color: #721c24;">0</h3>
                                                                <p style="margin: 5px 0 0 0; font-size: 11px; color: #721c24; font-weight: 500;">Cancelados</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-sm-4 col-xs-6" style="text-align: center; padding: 15px;">
                                                            <div style="background: #d4edda; border-radius: 8px; padding: 15px; border-left: 4px solid #20c997;">
                                                                <i class="fa fa-bell" style="font-size: 24px; color: #20c997; display: block; margin-bottom: 8px;"></i>
                                                                <h3 id="pedido-pronto" style="margin: 0; font-size: 28px; font-weight: 700; color: #155724;">0</h3>
                                                                <p style="margin: 5px 0 0 0; font-size: 11px; color: #155724; font-weight: 500;">Prontos</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-sm-4 col-xs-6" style="text-align: center; padding: 15px;">
                                                            <div style="background: #e2e3e5; border-radius: 8px; padding: 15px; border-left: 4px solid #6c757d;">
                                                                <i class="fa fa-list" style="font-size: 24px; color: #6c757d; display: block; margin-bottom: 8px;"></i>
                                                                <h3 id="pedido-total" style="margin: 0; font-size: 28px; font-weight: 700; color: #383d41;">0</h3>
                                                                <p style="margin: 5px 0 0 0; font-size: 11px; color: #383d41; font-weight: 500;">Total</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Rate Limits e Últimas Mensagens -->
                                        <div class="row">
                                            <!-- Rate Limits por Contato -->
                                            <div class="col-md-7">
                                                <div style="background: white; border-radius: 8px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); height: 100%;">
                                                    <h4 style="margin: 0 0 15px 0; font-size: 16px; font-weight: 600; color: #2c3e50;">
                                                        <i class="fa fa-tachometer" style="color: #6f42c1; margin-right: 8px;"></i>
                                                        Rate Limits por Contato
                                                    </h4>
                                                    <div id="rate-limits-container" style="max-height: 300px; overflow-y: auto;">
                                                        <div class="text-center" style="padding: 40px; color: #95a5a6;">
                                                            <i class="fa fa-inbox" style="font-size: 48px; margin-bottom: 15px;"></i>
                                                            <p style="margin: 0; font-size: 14px;">Nenhum envio recente</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Configurações Ativas -->
                                            <div class="col-md-5">
                                                <div style="background: white; border-radius: 8px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); height: 100%;">
                                                    <h4 style="margin: 0 0 15px 0; font-size: 16px; font-weight: 600; color: #2c3e50;">
                                                        <i class="fa fa-cog" style="color: #6f42c1; margin-right: 8px;"></i>
                                                        Configurações Ativas
                                                    </h4>
                                                    <div style="font-size: 13px; line-height: 2;">
                                                        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                                                            <span style="color: #6c757d;"><i class="fa fa-clock-o" style="width: 20px; color: #6f42c1;"></i> Intervalo Mínimo</span>
                                                            <strong style="color: #2c3e50;">3 segundos</strong>
                                                        </div>
                                                        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                                                            <span style="color: #6c757d;"><i class="fa fa-clock-o" style="width: 20px; color: #6f42c1;"></i> Intervalo Máximo</span>
                                                            <strong style="color: #2c3e50;">7 segundos</strong>
                                                        </div>
                                                        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                                                            <span style="color: #6c757d;"><i class="fa fa-tachometer" style="width: 20px; color: #6f42c1;"></i> Limite/Hora</span>
                                                            <strong style="color: #2c3e50;">40 msgs</strong>
                                                        </div>
                                                        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                                                            <span style="color: #6c757d;"><i class="fa fa-calendar" style="width: 20px; color: #6f42c1;"></i> Limite/Dia</span>
                                                            <strong style="color: #2c3e50;">100 msgs</strong>
                                                        </div>
                                                        <div style="display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f0f0f0;">
                                                            <span style="color: #6c757d;"><i class="fa fa-random" style="width: 20px; color: #6f42c1;"></i> Variações de Msg</span>
                                                            <strong style="color: #28a745;"><i class="fa fa-check-circle"></i> Ativo</strong>
                                                        </div>
                                                        <div style="display: flex; justify-content: space-between; padding: 8px 0;">
                                                            <span style="color: #6c757d;"><i class="fa fa-user-secret" style="width: 20px; color: #6f42c1;"></i> Delay Aleatório</span>
                                                            <strong style="color: #28a745;"><i class="fa fa-check-circle"></i> Ativo</strong>
                                                        </div>
                                                    </div>
                                                    
                                                    <div style="margin-top: 20px; padding: 15px; background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border-radius: 6px; border-left: 4px solid #28a745;">
                                                        <p style="margin: 0; font-size: 12px; color: #155724; font-weight: 500;">
                                                            <i class="fa fa-shield" style="margin-right: 5px;"></i>
                                                            <strong>Proteção Ativa:</strong> Comportamento humanizado para evitar detecção de spam
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 👤 PAINEL DE ATENDIMENTO HUMANO -->
                        <div class="row" style="margin-top: 30px;">
                            <div class="col-md-12">
                                <div class="panel panel-default" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden;">
                                    <!-- Header do Painel -->
                                    <div class="panel-heading" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; padding: 20px; border: none;">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <div>
                                                <h3 style="margin: 0; font-weight: 600; font-size: 20px;">
                                                    <i class="fa fa-headphones" style="margin-right: 10px;"></i>
                                                    Painel de Atendimento Humano
                                                </h3>
                                                <p style="margin: 5px 0 0 0; opacity: 0.9; font-size: 13px;">
                                                    Gerencie atendimentos em tempo real
                                                </p>
                                            </div>
                                            <div>
                                                <span class="badge" id="badge-sessoes-ativas" 
                                                      style="background: #ffc107; color: #000; font-size: 18px; padding: 8px 15px; border-radius: 20px; font-weight: 600; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                                                    0
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Corpo do Painel -->
                                    <div class="panel-body" style="padding: 25px; background: #f8f9fa;">
                                        <!-- Card Informativo -->
                                        <div style="background: white; border-left: 4px solid #17a2b8; padding: 20px; margin-bottom: 25px; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
                                            <div style="display: flex; align-items: flex-start;">
                                                <div style="flex-shrink: 0; width: 40px; height: 40px; background: #e7f6f8; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px;">
                                                    <i class="fa fa-info-circle" style="color: #17a2b8; font-size: 20px;"></i>
                                                </div>
                                                <div style="flex: 1;">
                                                    <h4 style="margin: 0 0 12px 0; font-size: 16px; font-weight: 600; color: #2c3e50;">
                                                        Como funciona o atendimento humano?
                                                    </h4>
                                                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 12px;">
                                                        <div style="display: flex; align-items: start;">
                                                            <i class="fa fa-check-circle" style="color: #28a745; margin-right: 8px; margin-top: 3px; flex-shrink: 0;"></i>
                                                            <span style="font-size: 14px; color: #555; line-height: 1.6;">
                                                                Cliente solicita "Falar com atendente" (opção 6)
                                                            </span>
                                                        </div>
                                                        <div style="display: flex; align-items: start;">
                                                            <i class="fa fa-check-circle" style="color: #28a745; margin-right: 8px; margin-top: 3px; flex-shrink: 0;"></i>
                                                            <span style="font-size: 14px; color: #555; line-height: 1.6;">
                                                                Bot <strong>pausa automaticamente</strong> para esse cliente
                                                            </span>
                                                        </div>
                                                        <div style="display: flex; align-items: start;">
                                                            <i class="fa fa-check-circle" style="color: #28a745; margin-right: 8px; margin-top: 3px; flex-shrink: 0;"></i>
                                                            <span style="font-size: 14px; color: #555; line-height: 1.6;">
                                                                Atenda via <strong>WhatsApp Web</strong> normalmente
                                                            </span>
                                                        </div>
                                                        <div style="display: flex; align-items: start;">
                                                            <i class="fa fa-clock-o" style="color: #ffc107; margin-right: 8px; margin-top: 3px; flex-shrink: 0;"></i>
                                                            <span style="font-size: 14px; color: #555; line-height: 1.6;">
                                                                <strong>5 min</strong> sem interação = bot volta automaticamente
                                                            </span>
                                                        </div>
                                                        <div style="display: flex; align-items: start;">
                                                            <i class="fa fa-hand-stop-o" style="color: #dc3545; margin-right: 8px; margin-top: 3px; flex-shrink: 0;"></i>
                                                            <span style="font-size: 14px; color: #555; line-height: 1.6;">
                                                                Ou <strong>finalize manualmente</strong> quando terminar
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Seção de Sessões -->
                                        <div style="background: white; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); overflow: hidden;">
                                            <!-- Header da Tabela -->
                                            <div style="padding: 18px 20px; background: #fff; border-bottom: 2px solid #e9ecef; display: flex; justify-content: space-between; align-items: center;">
                                                <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: #2c3e50;">
                                                    <i class="fa fa-users" style="color: #17a2b8; margin-right: 8px;"></i>
                                                    Sessões Ativas
                                                </h4>
                                                <button type="button" class="btn btn-sm" id="btn-atualizar-sessoes"
                                                        style="background: #17a2b8; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 500; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(23,162,184,0.2);">
                                                    <i class="fa fa-refresh"></i> Atualizar
                                                </button>
                                            </div>
                                            
                                            <!-- Container da Tabela -->
                                            <div id="sessoes-container" style="min-height: 200px; background: white;">
                                                <div class="text-center" style="padding: 60px 20px; color: #95a5a6;">
                                                    <i class="fa fa-spinner fa-spin" style="font-size: 48px; margin-bottom: 20px; color: #17a2b8;"></i>
                                                    <p style="font-size: 15px; margin: 0; font-weight: 500;">Carregando sessões...</p>
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
    </div>

    <!-- 📚 MODAL: COMO CONECTAR -->
    <div class="modal fade" id="modal-como-conectar" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #28a745; color: white;">
                    <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 0.8;">
                        <span>&times;</span>
                    </button>
                    <h4 class="modal-title"><i class="fa fa-info-circle"></i> Como Conectar</h4>
                </div>
                <div class="modal-body">
                    <ol style="font-size: 14px; line-height: 1.8;">
                        <li>Clique no botão <strong style="color: #25D366;">"Conectar WhatsApp"</strong></li>
                        <li>Aguarde o <strong>QR Code</strong> aparecer na tela</li>
                        <li>Abra o <strong>WhatsApp</strong> no seu celular</li>
                        <li>Vá em: <strong>Menu → Aparelhos conectados</strong></li>
                        <li>Toque em <strong>"Conectar um aparelho"</strong></li>
                        <li>Escaneie o <strong>QR Code</strong> exibido acima</li>
                    </ol>
                    <div class="alert alert-success" style="margin-top: 15px;">
                        <i class="fa fa-check-circle"></i>
                        <strong>Pronto!</strong> Seu bot responderá automaticamente às mensagens.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL CHAT ATENDIMENTO -->
    <div class="modal fade" id="modal-chat-atendimento" tabindex="-1" role="dialog">
        <div class="modal-dialog" style="width: 90%; max-width: 900px;">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #25D366 0%, #128C7E 100%); color: white;">
                    <button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 0.9;">
                        <span>&times;</span>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa fa-comments"></i> Chat com Cliente
                    </h4>
                    <small id="chat-cliente-info" style="opacity: 0.9;"></small>
                </div>
                <div class="modal-body" style="padding: 0; background: #e5ddd5;">
                    <!-- Área de mensagens -->
                    <div id="chat-mensagens-container" style="height: 450px; overflow-y: auto; padding: 20px; background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKCAYAAACNMs+9AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA3FpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTQyIDc5LjE2MDkyNCwgMjAxNy8wNy8xMy0wMTowNjozOSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDpFRjdGNkFGODZCMjA2ODExODIyQUNGMEVFNjVEQjJENCIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo5NTRDNkYxRDRBODUxMUU4QkFBQUQxMUZDN0YxODM1QSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo5NTRDNkYxQzRBODUxMUU4QkFBQUQxMUZDN0YxODM1QSIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChNYWNpbnRvc2gpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6RUY3RjZBRkE2QjIwNjgxMTgyMkFDRjBFRTY1REIyRDQiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6RUY3RjZBRjg2QjIwNjgxMTgyMkFDRjBFRTY1REIyRDQiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz5kO2TyAAAAPklEQVR42mL8//8/AzJgYmAAm4AAEQA6jDEAgzH8/x8RlcAASIUBMjgNXPQfphCkAKQQJAakECQGogQIMABWDBqJu8dIUwAAAABJRU5ErkJggg=='); background-size: 250px; background-attachment: fixed;">
                        <div id="chat-loading" style="text-align: center; padding: 40px; display: none;">
                            <i class="fa fa-spinner fa-spin" style="font-size: 32px; color: #128C7E;"></i>
                            <p style="margin-top: 10px; color: #128C7E;">Carregando mensagens...</p>
                        </div>
                        <div id="chat-mensagens"></div>
                    </div>
                    
                    <!-- Área de digitação -->
                    <div style="background: #f0f0f0; padding: 15px; border-top: 1px solid #ddd;">
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <textarea id="chat-input-mensagem" 
                                      placeholder="Digite sua mensagem..." 
                                      style="flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 20px; resize: none; font-size: 14px; max-height: 100px;"
                                      rows="1"></textarea>
                            <button id="btn-enviar-mensagem" 
                                    class="btn btn-success" 
                                    style="background: #25D366; border: none; padding: 12px 24px; border-radius: 50%; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-paper-plane" style="font-size: 18px;"></i>
                            </button>
                            <button id="btn-finalizar-atendimento" 
                                    class="btn btn-danger" 
                                    style="background: #dc3545; border: none; padding: 12px 20px; border-radius: 20px; font-size: 13px; font-weight: 500; display: flex; align-items: center; gap: 5px; white-space: nowrap;"
                                    title="Finalizar atendimento e retomar bot automático">
                                <i class="fa fa-times-circle"></i>
                                Fechar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay">
        <div style="text-align: center; color: white; display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <div class="spinner"></div>
            <p style="margin-top: 20px; font-size: 16px; font-weight: 500;">Conectando ao WhatsApp...</p>
        </div>
    </div>

    <!-- Scripts (jQuery already loaded in head) -->
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.cooki/jquery.cooki.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/admin/js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/admin/js/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/admin/js/jquery.ui/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/admin/js/jquery.gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/admin/js/behaviour/core.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/bootstrap/dist/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        // Configuração - v1765314007 (5min timeout)
        var companyToken = '<?= $data['config']->config_token ?>';
        var whatsappBaseUri = '<?= $baseUri ?>';
        var statusCheckInterval = null;

        // Aguardar jQuery carregar completamente
        jQuery(document).ready(function($) {

            // 🚀 AUTO-START: Verificar e iniciar bot automaticamente
            checkAndStartBot();

            // Botão Conectar
            $('#btn-connect').click(async function() {
                // Desabilitar botão para evitar cliques múltiplos
                $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Conectando...');
                
                $('#loading-overlay').addClass('active');
                updateStatus('connecting', 'Conectando...');

                try {
                    // 1. Tentar resetar (limpar sessão antiga) - mas não bloquear se falhar
                    console.log('[BOT] Tentando resetar bot...');
                    
                    try {
                        await $.ajax({
                            url: whatsappBaseUri + '/bot-whatsapp/reset/',
                            method: 'POST',
                            dataType: 'json',
                            timeout: 5000 // 5 segundos de timeout
                        });
                        console.log('[BOT] Reset concluído');
                    } catch (resetError) {
                        // Se o reset falhar, apenas logar e continuar
                        console.warn('[BOT] Reset falhou (ignorando):', resetError.statusText || resetError.message);
                    }

                    // 2. Aguardar 1 segundo
                    await new Promise(resolve => setTimeout(resolve, 1000));

                    // 3. Iniciar o bot
                    console.log('[BOT] Iniciando bot...');
                    
                    const response = await $.ajax({
                        url: whatsappBaseUri + '/bot-whatsapp/start/',
                        method: 'POST',
                        dataType: 'json'
                    });

                    if (response.success) {
                        console.log('[BOT] Bot iniciado com sucesso!');
                        showNotification('success', 'Bot iniciado! Aguarde o QR Code...');
                        updateStatus('qr_ready', 'Aguardando QR Code...');
                        
                        // Iniciar polling para buscar QR Code e status
                        startStatusPolling();
                        
                    } else {
                        $('#loading-overlay').removeClass('active');
                        console.error('[BOT] Erro ao iniciar:', response.message);
                        showNotification('error', response.message || 'Erro ao conectar');
                        updateStatus('disconnected', 'Erro na conexão');
                    }
                    
                } catch (error) {
                    console.error('=== ERRO AO CONECTAR ===');
                    console.error('Erro:', error);
                    
                    $('#loading-overlay').removeClass('active');
                    
                    var errorMsg = 'Não foi possível conectar. Tente novamente.';
                    if (error.responseJSON && error.responseJSON.message) {
                        errorMsg = error.responseJSON.message;
                    }
                    
                    showNotification('error', errorMsg);
                    updateStatus('disconnected', 'Erro na conexão');
                } finally {
                    // Re-habilitar botão após 3 segundos
                    setTimeout(function() {
                        $('#btn-connect').prop('disabled', false).html('<i class="fa fa-whatsapp"></i> Conectar WhatsApp');
                    }, 3000);
                }
            });

            // Botão Desconectar
            $('#btn-disconnect').click(async function() {
                if (!confirm('Deseja realmente desconectar o bot WhatsApp?\n\nIsso irá:\n- Parar o bot\n- Limpar a sessão atual\n- Permitir conectar um novo dispositivo')) {
                    return;
                }

                try {
                    showNotification('info', 'Desconectando e limpando sessão...');
                    
                    const response = await $.ajax({
                        url: whatsappBaseUri + '/bot-whatsapp/disconnect/',
                        method: 'POST',
                        dataType: 'json'
                    });
                    
                    if (response.success) {
                        showNotification('success', response.message || 'Bot desconectado e sessão limpa com sucesso');
                        updateStatus('disconnected', 'Desconectado');
                        $('#btn-connect').show();
                        $('#btn-disconnect').hide();
                        
                        // MOSTRAR título e área de QR code novamente
                        $('#qr-title-section').show();
                        $('#qr-container').show();
                        $('#qr-image').hide();
                        $('#qr-message').html('Clique em "Conectar WhatsApp" para gerar um novo QR Code').show();
                        
                        // Parar polling
                        if (statusCheckInterval) {
                            clearInterval(statusCheckInterval);
                            statusCheckInterval = null;
                        }
                    } else {
                        showNotification('warning', response.message);
                    }
                } catch (error) {
                    console.error('Erro ao desconectar:', error);
                    showNotification('error', 'Erro ao desconectar');
                }
            });

            // Salvar configurações de webhook
            $('#form-webhook').submit(function(e) {
                e.preventDefault();
                
                $.post(whatsappBaseUri + '/bot-whatsapp/saveConfig/', $(this).serialize(), function(response) {
                    if (response.success) {
                        showNotification('success', 'Configurações salvas com sucesso');
                    } else {
                        showNotification('error', 'Erro ao salvar configurações');
                    }
                }, 'json');
            });

            // Função para polling de status
            function startStatusPolling() {
                // Verificar status a cada 3 segundosStatus da Conexão
                statusCheckInterval = setInterval(function() {
                    $.ajax({
                        url: whatsappBaseUri + '/bot-whatsapp/status/',
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            
                            if (response.connected) {
                                // Bot está REALMENTE conectado ao WhatsApp
                                updateStatus('connected', 'Bot Conectado');
                                $('#btn-connect').hide();
                                $('#btn-disconnect').show();
                                $('#loading-overlay').removeClass('active');
                                
                                // ESCONDER apenas título e QR code, manter status e botões
                                $('#qr-title-section').hide();
                                $('#qr-container').hide();
                                $('#qr-image').hide();
                                $('#qr-message').html('<i class="fa fa-check-circle" style="color: #28a745; font-size: 48px;"></i><br>WhatsApp Conectado!').show();
                                
                                showNotification('success', 'WhatsApp conectado com sucesso!');
                                
                                // Parar polling quando conectado
                                if (statusCheckInterval) {
                                    clearInterval(statusCheckInterval);
                                    statusCheckInterval = null;
                                }
                            } else if (!response.running) {
                                // Bot não está mais rodando
                                updateStatus('disconnected', 'Desconectado');
                                $('#loading-overlay').removeClass('active');
                            }
                        }
                    });
                }, 3000);
                
                // Iniciar polling de QR Code
                startQrCodePolling();
            }
            
            // Função para polling do QR Code
            function startQrCodePolling() {
                let qrCheckCount = 0;
                const maxQrChecks = 40; // 2 minutos (40 * 3 segundos)
                
                const qrCheckInterval = setInterval(function() {
                    qrCheckCount++;
                    
                    $.ajax({
                        url: whatsappBaseUri + '/bot-whatsapp/qrcode/',
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            
                            if (response.hasQrCode) {
                                // Exibir QR Code
                                $('#qr-image').attr('src', response.qrCode).show();
                                $('#qr-message').html('Escaneie o QR Code acima com seu WhatsApp').show();
                                $('#loading-overlay').removeClass('active');
                                                                
                                // Parar polling após exibir QR Code
                                clearInterval(qrCheckInterval);
                            } else if (qrCheckCount >= maxQrChecks) {
                                // Timeout - parar de buscar QR Code
                                clearInterval(qrCheckInterval);
                                $('#qr-message').html('<i class="fa fa-exclamation-triangle" style="color: #ffc107;"></i><br>QR Code não foi gerado. Verifique os logs do servidor.').show();
                                $('#loading-overlay').removeClass('active');
                            }
                        },
                        error: function(xhr, status, error) {
                            // Em caso de erro, continuar tentando
                            console.error('❌ Erro ao buscar QR Code:', status, error);
                            console.error('Response:', xhr.responseText);
                        }
                    });
                    
                    // Parar polling quando o bot conectar
                    if (!statusCheckInterval) {
                        clearInterval(qrCheckInterval);
                    }
                }, 3000);
            }

            // Atualizar status visual
            function updateStatus(status, text) {
                const badge = $('#connection-status');
                badge.removeClass('status-connected status-disconnected status-connecting');
                
                if (status === 'connected') {
                    badge.addClass('status-connected');
                } else if (status === 'connecting') {
                    badge.addClass('status-connecting');
                } else {
                    badge.addClass('status-disconnected');
                }
                
                badge.text(text);
            }

            // Mostrar notificação
            function showNotification(type, message) {
                const alertClass = type === 'success' ? 'alert-success' : 
                                   type === 'warning' ? 'alert-warning' : 
                                   type === 'info' ? 'alert-info' : 'alert-danger';
                const icon = type === 'success' ? 'fa-check-circle' : 
                            type === 'info' ? 'fa-info-circle' : 'fa-exclamation-circle';
                
                const notification = $(`
                    <div class="alert ${alertClass} alert-dismissible fade in" role="alert" style="position: fixed; top: 70px; right: 20px; z-index: 10000; min-width: 300px;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <i class="fa ${icon}"></i> ${message}
                    </div>
                `);
                
                $('body').append(notification);
                
                setTimeout(function() {
                    notification.alert('close');
                }, 5000);
            }

            // Verificar status inicial ao carregar a página
            $.ajax({
                url: whatsappBaseUri + '/bot-whatsapp/status/',
                method: 'GET',
                dataType: 'json',
                success: function(response) {                    
                    if (response.connected) {
                        // WhatsApp realmente conectado
                        updateStatus('connected', 'Bot Conectado');
                        $('#btn-connect').hide();
                        $('#btn-disconnect').show();
                        
                        // ESCONDER apenas título e QR code, manter status e botões
                        $('#qr-title-section').hide();
                        $('#qr-container').hide();
                        $('#qr-message').html('<i class="fa fa-check-circle" style="color: #28a745; font-size: 48px;"></i><br>WhatsApp Conectado!').show();
                    } else if (response.running && response.connectionStatus === 'qr_ready') {
                        // Bot rodando e QR Code disponível
                        updateStatus('qr_ready', 'QR Code Disponível');
                        $('#btn-connect').hide();
                        $('#btn-disconnect').show();
                        // Iniciar polling para buscar QR Code
                        startQrCodePolling();
                        startStatusPolling();
                    } else if (response.running && (response.connectionStatus === 'connecting' || response.connectionStatus === 'authenticated')) {
                        // Bot rodando e realmente conectando/autenticando
                        updateStatus('connecting', 'Conectando...');
                        $('#btn-connect').hide();
                        $('#btn-disconnect').show();
                        startStatusPolling();
                    } else {
                        // Bot não está rodando OU está rodando mas não tem status claro
                        updateStatus('disconnected', 'Desconectado');
                        $('#btn-connect').show();
                        $('#btn-disconnect').hide();
                        
                        // MOSTRAR título e área de QR code quando desconectado
                        $('#qr-title-section').show();
                        $('#qr-container').show();
                    }
                }
            });
            
            // 👤 FUNÇÕES DE ATENDIMENTO HUMANO
            
            // Carregar sessões ativas
            function carregarSessoesAtivas() {
                $.ajax({
                    url: whatsappBaseUri + '/api/bot-atendimento.php',
                    method: 'GET',
                    data: {
                        acao: 'listar',
                        token: companyToken
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Atualizar badge com total de sessões
                            const badge = $('#badge-sessoes-ativas');
                            badge.text(response.total);
                            
                            // Adicionar animação de pulso se houver sessões
                            if (response.total > 0) {
                                badge.addClass('badge-pulse');
                            } else {
                                badge.removeClass('badge-pulse');
                            }
                            
                            // Renderizar sessões
                            renderizarSessoes(response.sessoes);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao carregar sessões:', error);
                        $('#sessoes-container').html(
                            '<div class="alert alert-danger">' +
                            '<i class="fa fa-exclamation-triangle"></i> Erro ao carregar sessões. Tente novamente.' +
                            '</div>'
                        );
                    }
                });
            }
            
            // Renderizar lista de sessões
            function renderizarSessoes(sessoes) {
                if (sessoes.length === 0) {
                    $('#sessoes-container').html(
                        '<div class="text-center" style="padding: 60px 20px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">' +
                        '<div style="max-width: 400px; margin: 0 auto;">' +
                        '<div style="width: 80px; height: 80px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">' +
                        '<i class="fa fa-inbox" style="font-size: 36px; color: #17a2b8;"></i>' +
                        '</div>' +
                        '<h4 style="font-size: 18px; font-weight: 600; color: #2c3e50; margin-bottom: 10px;">Nenhuma sessão ativa</h4>' +
                        '<p style="font-size: 14px; color: #6c757d; margin: 0; line-height: 1.6;">' +
                        'Quando um cliente solicitar atendimento humano,<br>a sessão aparecerá aqui automaticamente.' +
                        '</p>' +
                        '</div>' +
                        '</div>'
                    );
                    return;
                }
                
                let html = '<div style="overflow-x: auto;">' +
                          '<table class="table" style="margin: 0; background: white;">' +
                          '<thead>' +
                          '<tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">' +
                          '<th style="padding: 15px; font-weight: 600; color: #495057; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; border: none;">' +
                          '<i class="fa fa-user" style="margin-right: 6px; color: #17a2b8;"></i>Cliente' +
                          '</th>' +
                          '<th style="padding: 15px; font-weight: 600; color: #495057; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; border: none;">' +
                          '<i class="fa fa-phone" style="margin-right: 6px; color: #17a2b8;"></i>Telefone' +
                          '</th>' +
                          '<th style="padding: 15px; font-weight: 600; color: #495057; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; border: none;">' +
                          '<i class="fa fa-headphones" style="margin-right: 6px; color: #17a2b8;"></i>Atendente' +
                          '</th>' +
                          '<th style="padding: 15px; font-weight: 600; color: #495057; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; border: none;">' +
                          '<i class="fa fa-clock-o" style="margin-right: 6px; color: #17a2b8;"></i>Início' +
                          '</th>' +
                          '<th style="padding: 15px; font-weight: 600; color: #495057; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; border: none;">' +
                          '<i class="fa fa-refresh" style="margin-right: 6px; color: #17a2b8;"></i>Última Interação' +
                          '</th>' +
                          '<th style="padding: 15px; font-weight: 600; color: #495057; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; border: none;">' +
                          '<i class="fa fa-hourglass-half" style="margin-right: 6px; color: #17a2b8;"></i>Tempo Restante' +
                          '</th>' +
                          '<th style="padding: 15px; font-weight: 600; color: #495057; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; text-align: center; border: none;">' +
                          '<i class="fa fa-cogs" style="margin-right: 6px; color: #17a2b8;"></i>Ações' +
                          '</th>' +
                          '</tr>' +
                          '</thead>' +
                          '<tbody>';
                
                sessoes.forEach(function(sessao, index) {
                    const nomeCliente = sessao.cliente_nome || 'Cliente sem cadastro';
                    const nomeAtendente = sessao.atendente_nome || 'Não identificado';
                    const telefone = sessao.sessao_telefone;
                    const inicio = new Date(sessao.sessao_iniciada_em).toLocaleString('pt-BR', {day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'});
                    const ultimaInteracao = new Date(sessao.sessao_ultima_interacao);
                    const ultimaInteracaoStr = ultimaInteracao.toLocaleString('pt-BR', {day: '2-digit', month: '2-digit', hour: '2-digit', minute: '2-digit'});
                    const agora = new Date();
                    const diffMs = agora - ultimaInteracao;
                    const diffSeg = Math.floor(diffMs / 1000); // Diferença em SEGUNDOS
                    const tempoLimiteSegundos = 5 * 60; // 5 minutos = 300 segundos
                    const segundosRestantes = Math.max(0, tempoLimiteSegundos - diffSeg);
                    
                    // Formatar tempo em MM:SS
                    const minutos = Math.floor(segundosRestantes / 60);
                    const segundos = segundosRestantes % 60;
                    const tempoFormatado = minutos + ':' + (segundos < 10 ? '0' : '') + segundos;
                    
                    let corTempo = '#28a745'; // Verde
                    let bgTempo = '#d4edda';
                    let iconTempo = 'fa-check-circle';
                    if (segundosRestantes <= 30) { // Últimos 30 segundos
                        corTempo = '#dc3545'; // Vermelho
                        bgTempo = '#f8d7da';
                        iconTempo = 'fa-exclamation-triangle';
                    } else if (segundosRestantes <= 60) { // Último minuto
                        corTempo = '#ffc107'; // Amarelo
                        bgTempo = '#fff3cd';
                        iconTempo = 'fa-clock-o';
                    }
                    
                    const rowBg = index % 2 === 0 ? '#ffffff' : '#f8f9fa';
                    
                    html += '<tr style="background: ' + rowBg + '; border-bottom: 1px solid #e9ecef; transition: all 0.2s ease;" ' +
                           'onmouseover="this.style.background=\'#e7f6f8\'" ' +
                           'onmouseout="this.style.background=\'' + rowBg + '\'">' +
                           '<td style="padding: 18px 15px; vertical-align: middle; border: none;">' +
                           '<div style="display: flex; align-items: center;">' +
                           '<div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #17a2b8, #138496); display: flex; align-items: center; justify-content: center; margin-right: 12px; color: white; font-weight: 600; font-size: 14px;">' +
                           nomeCliente.charAt(0).toUpperCase() +
                           '</div>' +
                           '<span style="font-weight: 600; color: #2c3e50; font-size: 14px;">' + nomeCliente + '</span>' +
                           '</div>' +
                           '</td>' +
                           '<td style="padding: 18px 15px; vertical-align: middle; border: none;">' +
                           '<span style="font-family: monospace; color: #495057; background: #f1f3f5; padding: 6px 12px; border-radius: 6px; font-size: 13px; font-weight: 500;">' +
                           telefone +
                           '</span>' +
                           '</td>' +
                           '<td style="padding: 18px 15px; vertical-align: middle; border: none;">' +
                           '<div style="display: flex; align-items: center;">' +
                           '<div style="width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, #6c757d, #495057); display: flex; align-items: center; justify-content: center; margin-right: 8px; color: white; font-weight: 600; font-size: 12px;">' +
                           nomeAtendente.charAt(0).toUpperCase() +
                           '</div>' +
                           '<span style="font-size: 13px; color: #495057; font-weight: 500;">' + nomeAtendente + '</span>' +
                           '</div>' +
                           '</td>' +
                           '<td style="padding: 18px 15px; vertical-align: middle; border: none;">' +
                           '<div style="font-size: 13px; color: #6c757d;">' + inicio + '</div>' +
                           '</td>' +
                           '<td style="padding: 18px 15px; vertical-align: middle; border: none;">' +
                           '<div style="font-size: 13px; color: #6c757d;">' + ultimaInteracaoStr + '</div>' +
                           '</td>' +
                           '<td style="padding: 18px 15px; vertical-align: middle; border: none;">' +
                           '<div class="timer-badge" data-ultima-interacao="' + sessao.sessao_ultima_interacao + '" style="display: inline-flex; align-items: center; background: ' + bgTempo + '; padding: 8px 14px; border-radius: 20px; border: 1px solid ' + corTempo + ';">' +
                           '<i class="fa ' + iconTempo + '" style="color: ' + corTempo + '; margin-right: 6px; font-size: 14px;"></i>' +
                           '<span class="timer-text" style="color: ' + corTempo + '; font-weight: 600; font-size: 14px; font-family: monospace;">' + tempoFormatado + '</span>' +
                           '</div>' +
                           '</td>' +
                           '<td style="padding: 18px 15px; text-align: center; vertical-align: middle; border: none;">' +
                           '<button class="btn btn-sm btn-finalizar-sessao" data-telefone="' + telefone + '" ' +
                           'style="background: linear-gradient(135deg, #dc3545, #c82333); color: white; border: none; padding: 8px 20px; border-radius: 6px; font-weight: 500; box-shadow: 0 2px 4px rgba(220,53,69,0.3); transition: all 0.3s ease;" ' +
                           'onmouseover="this.style.transform=\'translateY(-2px)\'; this.style.boxShadow=\'0 4px 8px rgba(220,53,69,0.4)\'" ' +
                           'onmouseout="this.style.transform=\'translateY(0)\'; this.style.boxShadow=\'0 2px 4px rgba(220,53,69,0.3)\'">' +
                           '<i class="fa fa-stop-circle"></i> Finalizar' +
                           '</button>' +
                           '</td>' +
                           '</tr>';
                });
                
                html += '</tbody></table></div>';
                $('#sessoes-container').html(html);
                
                // Iniciar atualização dos timers em tempo real
                atualizarTimersTempoReal();
            }
            
            // Função para atualizar timers em tempo real (a cada segundo)
            let intervalTimers = null;
            
            function atualizarTimersTempoReal() {
                // Limpar intervalo anterior se existir
                if (intervalTimers) {
                    clearInterval(intervalTimers);
                }
                
                // Atualizar a cada 1 segundo
                intervalTimers = setInterval(function() {
                    $('.timer-badge').each(function() {
                        const $badge = $(this);
                        const ultimaInteracao = new Date($badge.data('ultima-interacao'));
                        const agora = new Date();
                        const diffMs = agora - ultimaInteracao;
                        const diffSeg = Math.floor(diffMs / 1000);
                        const tempoLimiteSegundos = 5 * 60; // 5 minutos = 300 segundos
                        const segundosRestantes = Math.max(0, tempoLimiteSegundos - diffSeg);
                        
                        // Formatar tempo em MM:SS
                        const minutos = Math.floor(segundosRestantes / 60);
                        const segundos = segundosRestantes % 60;
                        const tempoFormatado = minutos + ':' + (segundos < 10 ? '0' : '') + segundos;
                        
                        // Atualizar texto
                        $badge.find('.timer-text').text(tempoFormatado);
                        
                        // Atualizar cores dinamicamente
                        let corTempo = '#28a745';
                        let bgTempo = '#d4edda';
                        let iconClass = 'fa-check-circle';
                        
                        if (segundosRestantes <= 120) {
                            // Vermelho: faltando 2 minuto ou menos
                            corTempo = '#dc3545';
                            bgTempo = '#f8d7da';
                            iconClass = 'fa-exclamation-triangle';
                        } else if (segundosRestantes <= 180) {
                            // Amarelo: faltando 3 minutos ou menos
                            corTempo = '#ffc107';
                            bgTempo = '#fff3cd';
                            iconClass = 'fa-clock-o';
                        }
                        
                        $badge.css({
                            'background': bgTempo,
                            'border-color': corTempo
                        });
                        
                        $badge.find('i').attr('class', 'fa ' + iconClass).css('color', corTempo);
                        $badge.find('.timer-text').css('color', corTempo);
                    });
                }, 1000);
            }
            
            // Botão atualizar sessões
            $('#btn-atualizar-sessoes').click(function() {
                $(this).find('i').addClass('fa-spin');
                carregarSessoesAtivas();
                setTimeout(() => {
                    $(this).find('i').removeClass('fa-spin');
                }, 1000);
            });
            
            // Botão finalizar sessão
            $(document).on('click', '.btn-finalizar-sessao', function() {
                const telefone = $(this).data('telefone');
                const btn = $(this);
                
                if (!confirm('Tem certeza que deseja finalizar este atendimento?\n\nO bot voltará a responder automaticamente para este cliente.')) {
                    return;
                }
                
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Finalizando...');
                
                $.ajax({
                    url: whatsappBaseUri + '/api/bot-atendimento.php',
                    method: 'POST',
                    data: {
                        acao: 'finalizar',
                        telefone: telefone,
                        token: companyToken
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            showNotification('success', 'Atendimento finalizado! Bot voltou a funcionar.');
                            carregarSessoesAtivas();
                        } else {
                            showNotification('error', 'Erro ao finalizar atendimento');
                            btn.prop('disabled', false).html('<i class="fa fa-stop"></i> Finalizar');
                        }
                    },
                    error: function() {
                        showNotification('error', 'Erro ao finalizar atendimento');
                        btn.prop('disabled', false).html('<i class="fa fa-stop"></i> Finalizar');
                    }
                });
            });
            
            // Carregar sessões ao iniciar
            carregarSessoesAtivas();
            
            // Finalizar sessões expiradas
            function finalizarSessoesExpiradas() {
                $.ajax({
                    url: whatsappBaseUri + '/api/bot-atendimento.php',
                    method: 'POST',
                    data: {
                        acao: 'finalizar_expiradas',
                        token: companyToken
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success && response.affected_rows > 0) {
                            console.log('[ATENDIMENTO] ' + response.affected_rows + ' sessões expiradas foram finalizadas');
                            // Recarregar lista após finalizar
                            carregarSessoesAtivas();
                        }
                    },
                    error: function() {
                        console.error('[ATENDIMENTO] Erro ao verificar sessões expiradas');
                    }
                });
            }
            
            // Atualizar sessões a cada 10 segundos
            setInterval(function() {
                finalizarSessoesExpiradas();
                carregarSessoesAtivas();
            }, 10000);
            
            // Verificar sessões expiradas imediatamente
            finalizarSessoesExpiradas();
            
            // 💬 BOTÃO ABRIR CHAT
            let chatIntervalRefresh = null;
            let currentChatTelefone = null;
            
            $(document).on('click', '.btn-abrir-chat', function() {
                const telefone = $(this).data('telefone');
                const clienteNome = $(this).data('cliente-nome');
                
                abrirChat(telefone, clienteNome);
            });
            
            // Fechar chat - parar refresh
            $('#modal-chat-atendimento').on('hidden.bs.modal', function() {
                if (chatIntervalRefresh) {
                    clearInterval(chatIntervalRefresh);
                    chatIntervalRefresh = null;
                }
                currentChatTelefone = null;
            });
            
            // Função para carregar mensagens do chat
            function carregarMensagensChat(telefone, silent = false) {
                if (!silent) {
                    $('#chat-loading').show();
                }
                
                $.ajax({
                    url: whatsappBaseUri + '/api/get-chat-historico.php',
                    method: 'POST',
                    data: { telefone: telefone },
                    dataType: 'json',
                    success: function(response) {
                        $('#chat-loading').hide();
                        
                        if (response.success && response.mensagens) {
                            renderizarMensagensChat(response.mensagens);
                            
                            // Atualizar header com nome do cliente se disponível
                            if (response.cliente && response.cliente.nome) {
                                $('#chat-cliente-info').text('Cliente: ' + response.cliente.nome + ' | ' + telefone);
                            } else if (response.pedido && response.pedido.cliente_nome) {
                                $('#chat-cliente-info').text('Cliente: ' + response.pedido.cliente_nome + ' | ' + telefone);
                            }
                        }
                    },
                    error: function() {
                        $('#chat-loading').hide();
                        if (!silent) {
                            showNotification('error', 'Erro ao carregar mensagens');
                        }
                    }
                });
            }
            
            // Função para renderizar mensagens
            function renderizarMensagensChat(mensagens) {
                let html = '';
                
                mensagens.forEach(function(msg) {
                    const tipo = msg.tipo || 'cliente';
                    const dataHora = new Date(msg.data);
                    const horaFormatada = dataHora.toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'});
                    
                    if (tipo === 'atendente') {
                        // Mensagem do atendente (direita, verde)
                        html += '<div style="display: flex; justify-content: flex-end; margin-bottom: 10px;">';
                        html += '<div style="max-width: 65%; background: #dcf8c6; padding: 8px 12px; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.1);">';
                        if (msg.atendente_nome) {
                            html += '<div style="font-size: 11px; color: #128C7E; font-weight: 600; margin-bottom: 3px;">👨 ' + msg.atendente_nome + '</div>';
                        }
                        html += '<div style="font-size: 14px; color: #000; white-space: pre-wrap; word-wrap: break-word;">' + escapeHtml(msg.msg) + '</div>';
                        html += '<div style="font-size: 11px; color: #667781; text-align: right; margin-top: 4px;">' + horaFormatada + '</div>';
                        html += '</div></div>';
                    } else if (tipo === 'bot') {
                        // Mensagem do bot (esquerda, branco)
                        html += '<div style="display: flex; justify-content: flex-start; margin-bottom: 10px;">';
                        html += '<div style="max-width: 65%; background: white; padding: 8px 12px; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.1);">';
                        html += '<div style="font-size: 11px; color: #128C7E; font-weight: 600; margin-bottom: 3px;">🤖 Bot</div>';
                        html += '<div style="font-size: 14px; color: #000; white-space: pre-wrap; word-wrap: break-word;">' + escapeHtml(msg.msg) + '</div>';
                        html += '<div style="font-size: 11px; color: #667781; text-align: right; margin-top: 4px;">' + horaFormatada + '</div>';
                        html += '</div></div>';
                    } else {
                        // Mensagem do cliente (esquerda, branco)
                        html += '<div style="display: flex; justify-content: flex-start; margin-bottom: 10px;">';
                        html += '<div style="max-width: 65%; background: white; padding: 8px 12px; border-radius: 8px; box-shadow: 0 1px 2px rgba(0,0,0,0.1);">';
                        html += '<div style="font-size: 14px; color: #000; white-space: pre-wrap; word-wrap: break-word;">' + escapeHtml(msg.msg) + '</div>';
                        html += '<div style="font-size: 11px; color: #667781; text-align: right; margin-top: 4px;">' + horaFormatada + '</div>';
                        html += '</div></div>';
                    }
                });
                
                $('#chat-mensagens').html(html);
                
                // Scroll para o final
                const container = $('#chat-mensagens-container');
                container.scrollTop(container[0].scrollHeight);
            }
            
            // Função para escapar HTML
            function escapeHtml(text) {
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
            }
            
            // Botão enviar mensagem
            $('#btn-enviar-mensagem').click(function() {
                enviarMensagemChat();
            });
            
            // Enter para enviar (Shift+Enter para quebra de linha)
            $('#chat-input-mensagem').keydown(function(e) {
                if (e.keyCode === 13 && !e.shiftKey) {
                    e.preventDefault();
                    enviarMensagemChat();
                }
            });
            
            // Função para enviar mensagem
            function enviarMensagemChat() {
                const mensagem = $('#chat-input-mensagem').val().trim();
                
                if (!mensagem) {
                    return;
                }
                
                if (!currentChatTelefone) {
                    showNotification('error', 'Erro: telefone não identificado');
                    return;
                }
                
                // Desabilitar botão e input
                $('#btn-enviar-mensagem').prop('disabled', true).html('<i class="fa fa-spinner fa-spin" style="font-size: 18px;"></i>');
                $('#chat-input-mensagem').prop('disabled', true);
                
                $.ajax({
                    url: whatsappBaseUri + '/api/bot-enviar-mensagem-atendente.php',
                    method: 'POST',
                    data: JSON.stringify({
                        telefone: currentChatTelefone,
                        mensagem: mensagem,
                        token: companyToken
                    }),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Limpar input
                            $('#chat-input-mensagem').val('');
                            
                            // Recarregar mensagens imediatamente
                            carregarMensagensChat(currentChatTelefone, true);
                            
                            // Foco no input
                            $('#chat-input-mensagem').focus();
                        } else {
                            showNotification('error', response.error || 'Erro ao enviar mensagem');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Erro ao enviar mensagem';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMsg = xhr.responseJSON.error;
                        }
                        showNotification('error', errorMsg);
                    },
                    complete: function() {
                        // Re-habilitar botão e input
                        $('#btn-enviar-mensagem').prop('disabled', false).html('<i class="fa fa-paper-plane" style="font-size: 18px;"></i>');
                        $('#chat-input-mensagem').prop('disabled', false);
                    }
                });
            }
            
            // Botão Finalizar Atendimento
            $('#btn-finalizar-atendimento').click(function() {
                if (!currentChatTelefone) {
                    showNotification('error', 'Erro: telefone não identificado');
                    return;
                }
                
                if (!confirm('Deseja finalizar este atendimento?\n\nO cliente retornará a ser atendido pelo bot automático.')) {
                    return;
                }
                
                // Desabilitar botão
                $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Finalizando...');
                
                $.ajax({
                    url: whatsappBaseUri + '/api/bot-atendimento.php',
                    method: 'POST',
                    data: {
                        acao: 'finalizar',
                        telefone: currentChatTelefone,
                        token: companyToken
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            showNotification('success', 'Atendimento finalizado! O bot automático foi retomado.');
                            
                            // Fechar modal após 1 segundo
                            setTimeout(function() {
                                $('#modal-chat-atendimento').modal('hide');
                            }, 1000);
                        } else {
                            showNotification('error', response.error || 'Erro ao finalizar atendimento');
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Erro ao finalizar atendimento';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMsg = xhr.responseJSON.error;
                        }
                        showNotification('error', errorMsg);
                    },
                    complete: function() {
                        // Re-habilitar botão
                        $('#btn-finalizar-atendimento').prop('disabled', false).html('<i class="fa fa-times-circle"></i> Fechar');
                    }
                });
            });
            
            // 🚀 FUNÇÃO: Auto-Start do Bot
            function checkAndStartBot() {
                console.log('[AUTO-START] Verificando status do bot...');
                
                $.ajax({
                    url: whatsappBaseUri + '/api/bot-auto-start.php',
                    method: 'GET',
                    data: { token: companyToken },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success && response.running) {
                            if (response.auto_started) {
                                console.log('[AUTO-START] ✅ Bot iniciado automaticamente!');
                                showNotification('success', 'Bot iniciado automaticamente. Aguarde...');
                            } else {
                                console.log('[AUTO-START] ✅ Bot já estava rodando');
                            }
                            
                            // Iniciar polling para verificar conexão
                            setTimeout(function() {
                                startStatusPolling();
                            }, 2000);
                            
                        } else {
                            console.warn('[AUTO-START] ⚠️ Bot não iniciou:', response.message);
                            updateStatus('disconnected', 'Bot não está rodando');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('[AUTO-START] ❌ Erro ao verificar bot:', error);
                    }
                });
            }
            
        }); // End jQuery ready
    </script>
    
    <!-- Bot Stats - Carregar DEPOIS das variáveis -->
    <script src="<?php echo $baseUri; ?>/view/admin/app-js/bot-stats.js"></script>
</body>
</html>
</html>
