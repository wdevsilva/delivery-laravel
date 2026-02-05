<!DOCTYPE html>
<?php $baseUri = Http::base(); ?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Garçon - <?= $data['config']->config_nome ?></title>
    <link rel="icon" type="image/png" href="<?php echo $baseUri; ?>/midias/logo/<?= $_SESSION['base_delivery'] ?>/<?php echo $data['config']->config_foto; ?>" />
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/css/main.css?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/css/main.css') ?>">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/css/garcon-dashboard.css">
  
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
                    <li class="active">
                        <a href="<?= $baseUri ?>/garcon/">
                            <i class="fa fa-dashboard"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="<?= $baseUri ?>/garcon/mesas/">
                            <i class="fa fa-th-large"></i> Minhas Mesas
                        </a>
                    </li>
                    <li>
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

    <div class="container mt-4">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <div class="row">
                <div class="col-md-8">
                    <h2><i class="fa fa-hand-o-right"></i> Olá, <?= explode(' ', $data['garcon']->garcon_nome)[0] ?>!</h2>
                    <p class="lead">Bem-vindo ao seu painel de atendimento. Aqui você pode gerenciar suas mesas e pedidos.</p>
                </div>
                <div class="col-md-4 text-right">
                    <h4><i class="fa fa-clock-o"></i> <?= date('d/m/Y H:i') ?></h4>
                    <p>Sistema de Atendimento</p>
                </div>
            </div>
        </div>

        <!-- Estatísticas -->
        <div class="row">
            <div class="col-md-3">
                <div class="card bg-primary text-white stat-card">
                    <div class="card-body">
                        <h3><?= $data['estatisticas']->mesas_atendidas ?></h3>
                        <p>Mesas Atendidas Hoje</p>
                        <i class="fa fa-th-large fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white stat-card">
                    <div class="card-body">
                        <h3><?= $data['estatisticas']->pedidos_entregues ?></h3>
                        <p>Pedidos Entregues</p>
                        <i class="fa fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white stat-card">
                    <div class="card-body">
                        <h3><?= $data['estatisticas']->pedidos_pendentes ?></h3>
                        <p>Pedidos Pendentes</p>
                        <i class="fa fa-clock-o fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white stat-card">
                    <div class="card-body">
                        <h3><?= isset($data['mesa_stats']) ? $data['mesa_stats']->total_mesas : '0' ?></h3>
                        <p>Total de Mesas</p>
                        <i class="fa fa-cutlery fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status das Mesas -->
        <?php if (isset($data['mesa_stats'])): ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fa fa-info-circle"></i> Status das Mesas do Restaurante
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="alert alert-success text-center">
                                        <h4><?= isset($data['mesa_stats']->livres) ? $data['mesa_stats']->livres : '0' ?></h4>
                                        <p class="mb-0"><strong>Mesas Livres</strong></p>
                                        <small>Disponíveis para ocupação</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="alert alert-warning text-center">
                                        <h4><?= isset($data['mesa_stats']->ocupadas) ? $data['mesa_stats']->ocupadas : '0' ?></h4>
                                        <p class="mb-0"><strong>Mesas Ocupadas</strong></p>
                                        <small>Com clientes atualmente</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="alert alert-info text-center">
                                        <h4><?= isset($data['mesa_stats']->reservadas) ? $data['mesa_stats']->reservadas : '0' ?></h4>
                                        <p class="mb-0"><strong>Mesas Reservadas</strong></p>
                                        <small>Aguardando cliente</small>
                                        <?php if (isset($data['reserva_stats']) && $data['reserva_stats']): ?>
                                            <br><small class="text-muted"><?= $data['reserva_stats']->reservas_ativas ?> reservas ativas hoje</small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="alert alert-secondary text-center">
                                        <h4><?= isset($data['mesa_stats']->manutencao) ? $data['mesa_stats']->manutencao : '0' ?></h4>
                                        <p class="mb-0"><strong>Em Manutenção</strong></p>
                                        <small>Fora de serviço</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Minhas Mesas -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fa fa-th-large"></i> Minhas Mesas Ativas
                            <button type="button" class="btn btn-primary btn-sm float-right" onclick="location.reload()">
                                <i class="fa fa-refresh"></i> Atualizar
                            </button>
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if ($data['mesas'] && count($data['mesas']) > 0): ?>
                            <div class="row">
                                <?php foreach ($data['mesas'] as $mesa): ?>
                                    <div class="col-md-4">
                                        <div class="card mesa-card mesa-ocupada">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    Mesa <?= $mesa->mesa_numero ?>
                                                    <span class="badge badge-warning status-badge status-ocupada">Ocupada</span>
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text">
                                                    <strong>Cliente:</strong> <?= $mesa->cliente_nome ?: 'N/I' ?><br>
                                                    <strong>Pessoas:</strong> <?= $mesa->numero_pessoas ?: 'N/I' ?><br>
                                                    <strong>Desde:</strong> <?= date('H:i', strtotime($mesa->data_inicio)) ?>
                                                </p>

                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="<?= $baseUri ?>/garcon/cardapio/<?= $mesa->mesa_id ?>/"
                                                        class="btn btn-primary btn-action">
                                                        <i class="fa fa-plus"></i> Pedido
                                                    </a>
                                                    <a href="<?= $baseUri ?>/garcon/pedidos-mesa/<?= $mesa->mesa_id ?>/"
                                                        class="btn btn-info btn-action">
                                                        <i class="fa fa-list"></i> Ver Pedidos
                                                    </a>
                                                    <button type="button" class="btn btn-warning btn-action"
                                                        onclick="liberarMesa(<?= $mesa->mesa_id ?>, <?= $mesa->ocupacao_id ?>)">
                                                        <i class="fa fa-sign-out"></i> Liberar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center">
                                <i class="fa fa-info-circle fa-3x text-muted"></i>
                                <h4>Nenhuma mesa ativa</h4>
                                <p class="text-muted">Você não possui mesas ocupadas no momento.</p>
                                <a href="<?= $baseUri ?>/garcon/mesas/" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Ocupar Mesa
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações Rápidas -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="fa fa-bolt"></i> Ações Rápidas</h5>
                    </div>
                    <div class="card-body text-center">
                        <a href="<?= $baseUri ?>/garcon/mesas/" class="btn btn-primary btn-lg mx-2">
                            <i class="fa fa-th-large"></i><br>Gerenciar Mesas
                        </a>
                        <a href="<?= $baseUri ?>/garcon/estatisticas/" class="btn btn-info btn-lg mx-2">
                            <i class="fa fa-bar-chart"></i><br>Ver Estatísticas
                        </a>
                        <button type="button" class="btn btn-warning btn-lg mx-2" onclick="location.reload()">
                            <i class="fa fa-refresh"></i><br>Atualizar Dashboard
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Counter -->
    <div id="notificationCounter" class="notification-counter">
        <span id="counterText">0</span>
    </div>
    <?= $baseUri ?>
    <!-- Hidden audio element for notification sound -->
    <audio id="notificationSound" preload="auto">
        <source src="<?= $baseUri ?>/midias/alerta/alert_garcon.mp3" type="audio/mpeg">
    </audio>

    <script src="<?= $baseUri ?>/assets/vendor/jquery/jquery-2.1.4.min.js"></script>
    <script src="<?= $baseUri ?>/assets/vendor/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script>
        // Notification System Variables (similar to main.js admin system)
        let lastNotificationCheck = Date.now();
        let notificationCount = 0;
        let knownReadyOrders = new Set();
        let isWaiterLoggedIn = <?= garconModel::esta_logado() ? 'true' : 'false' ?>;
        let waiterId = <?= garconModel::get_id() ?>;
        let lastCheckedOrderId = 0; // Similar to admin system
        let audioContext = null;
        let isAudioUnlocked = false;
        let preloadedAudio = null;
        let currentPlayingAudio = null; // Para controlar o áudio que está tocando

        // Initialize notification system
        $(document).ready(function() {
            if (isWaiterLoggedIn) {                
                // Setup audio unlock strategy
                setupAudioUnlock();
                
                startNotificationMonitoring();
            }
        });
        
        // Setup multiple strategies to unlock audio
        function setupAudioUnlock() {
            // Strategy 1: Use existing HTML audio element
            const htmlAudio = document.getElementById('notificationSound');
            if (htmlAudio) {
                htmlAudio.volume = 1.0;
                htmlAudio.muted = false;
            }
            
            // Strategy 2: Unlock on any user interaction
            const unlockAudio = function() {
                // Try HTML audio element first
                if (htmlAudio && !isAudioUnlocked) {
                    const promise = htmlAudio.play();
                    if (promise) {
                        promise.then(() => {
                            htmlAudio.pause(); // Para o áudio imediatamente
                            htmlAudio.currentTime = 0;
                            isAudioUnlocked = true;
                            preloadedAudio = htmlAudio;
                        }).catch(() => {
                        });
                    }
                }
                
                // Try creating Audio object
                if (!isAudioUnlocked) {
                    try {
                        const testAudio = new Audio('<?= $baseUri ?>/midias/alerta/alert_garcon.mp3');
                        testAudio.volume = 1.0;
                        const promise2 = testAudio.play();
                        if (promise2) {
                            promise2.then(() => {
                                testAudio.pause(); // Para o áudio imediatamente
                                testAudio.currentTime = 0;
                                isAudioUnlocked = true;
                                preloadedAudio = testAudio;
                            }).catch(() => {
                            });
                        }
                    } catch (e) {
                    }
                }
                
                // Remove listeners after first attempt
                if (isAudioUnlocked) {
                    document.removeEventListener('click', unlockAudio);
                    document.removeEventListener('keydown', unlockAudio);
                    document.removeEventListener('touchstart', unlockAudio);
                    document.removeEventListener('mousemove', unlockAudio);
                }
            };
            
            // Listen for any interaction
            document.addEventListener('click', unlockAudio, { passive: true });
            document.addEventListener('keydown', unlockAudio, { passive: true });
            document.addEventListener('touchstart', unlockAudio, { passive: true });
            document.addEventListener('mousemove', unlockAudio, { passive: true, once: true });
            
            // Strategy 3: Try immediate unlock (some browsers allow this)
            setTimeout(() => {
                if (!isAudioUnlocked) {
                    unlockAudio();
                }
            }, 1000);
        }

        // Start monitoring for ready orders
        function startNotificationMonitoring() {
            // Verificação imediata sem delay
            checkForReadyOrdersMainJS();
            
            // Similar to admin main.js - check every 3 seconds (mais frequente)
            setInterval(function() {
                checkForReadyOrdersMainJS();
            }, 1000 * 3); // 3 seconds
            
        }

        // Check for ready orders using main.js style (getJSON)
        function checkForReadyOrdersMainJS() {
            
            var url = '<?= $baseUri ?>/garcon/check-ready-orders/?waiter_id=' + waiterId + '&last_check=0';

            $.getJSON(url).done(function(response) {
                
                if (response && response.status === 'success') {
                    if (response.ready_orders && response.ready_orders.length > 0) {
                        
                        // Pega o primeiro pedido pronto
                        const order = response.ready_orders[0];
                        
                        // Armazena dados do pedido para exibir no alerta central
                        window.currentOrderData = order;
                        
                        // Mostra o alerta
                        playAutomaticNotificationSound();
                        
                        // Animate mesa card
                        animateMesaCardForOrder(order.mesa_numero);
                        
                        updateNotificationCounter();
                        
                    }
                }
            }).fail(function(xhr, status, error) {
            });
        }

        // Play notification sound automatically
        function playAutomaticNotificationSound() {
            // Para qualquer áudio que já esteja tocando
            stopCurrentAudio();
            
            // SEMPRE mostra o botão, mesmo se o áudio falhar
            showStopAudioButton();
            
            // Strategy 1: Use preloaded audio if available
            if (isAudioUnlocked && preloadedAudio) {
                try {
                    preloadedAudio.currentTime = 0;
                    preloadedAudio.loop = true; // Ativa o loop
                    preloadedAudio.volume = 1.0;
                    
                    const promise = preloadedAudio.play();
                    if (promise) {
                        promise.then(() => {
                            currentPlayingAudio = preloadedAudio;
                            return;
                        }).catch((error) => {
                        });
                    }
                } catch (error) {
                }
            }
            
            // Strategy 2: Use HTML audio element
            const htmlAudio = document.getElementById('notificationSound');
            if (htmlAudio && !currentPlayingAudio) {
                try {
                    htmlAudio.currentTime = 0;
                    htmlAudio.volume = 1.0;
                    htmlAudio.loop = true; // Ativa o loop
                    
                    const promise = htmlAudio.play();
                    if (promise) {
                        promise.then(() => {
                            currentPlayingAudio = htmlAudio;
                            return;
                        }).catch((error) => {
                        });
                    }
                } catch (error) {
                }
            }
            
            // Strategy 3: Create fresh Audio object
            if (!currentPlayingAudio) {
                try {
                    const freshAudio = new Audio('<?= $baseUri ?>/midias/alerta/alert_garcon.mp3');
                    freshAudio.volume = 1.0;
                    freshAudio.loop = true; // Ativa o loop
                    
                    const promise = freshAudio.play();
                    if (promise) {
                        promise.then(() => {
                            currentPlayingAudio = freshAudio;
                        }).catch((error) => {
                        });
                    }
                } catch (error) {
                }
            }
        }
        
        // Para o áudio atual que está tocando - SUPER AGRESSIVA
        function stopCurrentAudio() {
            // FASE 1: Parar áudio da variável currentPlayingAudio
            if (currentPlayingAudio) {
                try {
                    currentPlayingAudio.pause();
                    currentPlayingAudio.currentTime = 0;
                    currentPlayingAudio.loop = false;
                    currentPlayingAudio.volume = 0;
                    currentPlayingAudio.src = '';
                    delete currentPlayingAudio.onended;
                    delete currentPlayingAudio.ontimeupdate;
                } catch (error) {
                    // Error handling without logging
                }
                currentPlayingAudio = null;
            }
            
            // FASE 2: Parar preloadedAudio global
            if (window.preloadedAudio) {
                try {
                    preloadedAudio.pause();
                    preloadedAudio.currentTime = 0;
                    preloadedAudio.loop = false;
                    preloadedAudio.volume = 0;
                    preloadedAudio.src = '';
                } catch (error) {
                    // Error handling without logging
                }
                window.preloadedAudio = null;
            }
            
            // FASE 3: Destruir TODOS os elementos de áudio HTML
            const allAudioElements = document.querySelectorAll('audio');
            allAudioElements.forEach((audio, index) => {
                try {
                    audio.pause();
                    audio.currentTime = 0;
                    audio.loop = false;
                    audio.volume = 0;
                    audio.muted = true;
                    audio.src = '';
                    audio.load();
                } catch (e) {
                    // Error handling without logging
                }
            });
            
            // FASE 4: Suspender AudioContext completamente
            if (window.audioContext) {
                try {
                    window.audioContext.suspend();
                    window.audioContext.close();
                    window.audioContext = null;
                } catch (e) {
                    // Error handling without logging
                }
            }
            
            // FASE 5: Limpar TODAS as variáveis de áudio globais
            window.currentPlayingAudio = null;
            window.preloadedAudio = null;
            window.isAudioUnlocked = false;
            
            // FASE 6: Forçar garbage collection (se disponível)
            if (window.gc) {
                try {
                    window.gc();
                } catch (e) {
                    // Error handling without logging
                }
            }
            
            hideStopAudioButton();
        }
        
        // Mostra botão para parar o áudio
        function showStopAudioButton() {
            // Remove botão existente se houver
            const existingButton = document.getElementById('stopAudioButton');
            if (existingButton) {
                existingButton.remove();
            }
            
            // Pega informações do pedido atual (se disponível)
            let orderInfo = '';
            let viewOrderUrl = '#';
            
            if (window.currentOrderData) {
                orderInfo = `
                    <div style="background: rgba(255,255,255,0.15); padding: 12px; border-radius: 8px; margin-bottom: 15px; text-align: left;">
                        <div style="font-weight: bold; margin-bottom: 8px;">Mesa ${window.currentOrderData.mesa_numero}</div>
                        <div style="font-size: 14px; margin-bottom: 4px;">Pedido #${window.currentOrderData.pedido_numero || window.currentOrderData.pedido_id}</div>
                        ${window.currentOrderData.cliente_nome ? `<div style="font-size: 14px; margin-bottom: 4px;">Cliente: ${window.currentOrderData.cliente_nome}</div>` : ''}
                        ${window.currentOrderData.total_itens ? `<div style="font-size: 14px;">${window.currentOrderData.total_itens} itens prontos</div>` : '<div style="font-size: 14px;">Pedido pronto!</div>'}
                    </div>
                `;
                viewOrderUrl = `<?= $baseUri ?>/garcon/pedidos-mesa/${window.currentOrderData.mesa_id}/`;
            }
            
            // Cria novo botão
            const stopButton = document.createElement('div');
            stopButton.id = 'stopAudioButton';
            stopButton.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                display: flex;
                align-items: flex-start;
                justify-content: center;
                padding-top: 20vh;
                z-index: 10001;
                pointer-events: none;
            `;
            
            // Container interno com o alerta
            const alertContainer = document.createElement('div');
            alertContainer.style.cssText = `
                background: linear-gradient(135deg, #ff6b6b, #ee5a24);
                color: white;
                padding: 20px 25px;
                border-radius: 15px;
                font-size: 16px;
                font-weight: bold;
                box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
                cursor: pointer;
                text-align: center;
                animation: pulse 1.5s infinite;
                border: 3px solid #fff;
                min-width: 300px;
                max-width: 90vw;
                pointer-events: auto;
            `;
            
            alertContainer.innerHTML = `
                <div style="margin-bottom: 15px; font-size: 20px;">
                    🔊 PEDIDO PRONTO!
                </div>
                ${orderInfo}
                <div style="font-size: 16px; background: rgba(255,255,255,0.2); padding: 12px; border-radius: 8px;">
                    👁️ VER PEDIDO
                </div>
            `;
            
            // Adiciona evento de clique para ver pedido e parar áudio
            alertContainer.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // PRIMEIRA AÇÃO: Para o áudio IMEDIATAMENTE
                stopCurrentAudio();
                
                // AÇÃO EXTRA MOBILE: Força parada específica para mobile
                const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
                if (isMobile) {
                    // Estratégia 1: Força parada múltipla com delays para mobile
                    setTimeout(() => {
                        document.querySelectorAll('audio').forEach(audio => {
                            try {
                                audio.pause();
                                audio.currentTime = 0;
                                audio.volume = 0;
                                audio.muted = true;
                                audio.src = 'data:audio/wav;base64,UklGRigAAABXQVZFZm10IBAAAAAAg';
                                audio.load();
                            } catch (e) {}
                        });
                    }, 50);
                    
                    // Estratégia 2: Força parada de MediaSession (mobile)
                    if (navigator.mediaSession) {
                        try {
                            navigator.mediaSession.playbackState = 'paused';
                        } catch (e) {}
                    }
                    
                    // Estratégia 3: Força parada final após 200ms
                    setTimeout(() => {
                        document.querySelectorAll('audio').forEach(audio => {
                            try {
                                audio.pause();
                                audio.volume = 0;
                                audio.muted = true;
                            } catch (e) {}
                        });
                    }, 200);
                }
                
                // AÇÃO EXTRA: Força parada total de áudio
                try {
                    document.querySelectorAll('audio').forEach(audio => {
                        audio.pause();
                        audio.currentTime = 0;
                        audio.loop = false;
                        audio.volume = 0;
                    });
                } catch (e) {
                    // Error handling without logging
                }
                
                // SEGUNDA AÇÃO: Limpa dados
                window.currentOrderData = null;
                
                // TERCEIRA AÇÃO: Navega se URL válida (com delay para garantir parada)
                if (viewOrderUrl !== '#') {
                    // Mobile precisa de mais tempo para parar o áudio
                    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
                    const navigationDelay = isMobile ? 500 : 200;
                    
                    setTimeout(() => {
                        window.location.href = viewOrderUrl;
                    }, navigationDelay);
                }
            });
            
            stopButton.appendChild(alertContainer);
            
            document.body.appendChild(stopButton);
        }
        
        // Esconde botão de parar áudio
        function hideStopAudioButton() {
            const stopButton = document.getElementById('stopAudioButton');
            if (stopButton) {
                stopButton.remove();
            }
        }

        // Visual alert when sound completely fails
        function showVisualAlert() {            
            // Flash the page border
            document.body.style.border = '5px solid #ff6b6b';
            setTimeout(() => {
                document.body.style.border = 'none';
            }, 500);

            // Show browser notification if permitted
            if ('Notification' in window && Notification.permission === 'granted') {
                new Notification('Pedido Pronto!', {
                    body: 'Um pedido da sua mesa ficou pronto',
                    icon: '<?= $baseUri ?>/midias/img/combohamburgue.png'
                });
            }
        }

        // Update notification counter
        function updateNotificationCounter() {
            notificationCount++;
            const counter = document.getElementById('notificationCounter');
            const counterText = document.getElementById('counterText');

            if (counter && counterText && notificationCount > 0) {
                counterText.textContent = notificationCount;
                counter.style.display = 'flex';
            }
        }

        // Reset notification counter
        function resetNotificationCounter() {
            notificationCount = 0;
            const counter = document.getElementById('notificationCounter');
            if (counter) {
                counter.style.display = 'none';
            }
        }

        // Animate mesa card when order is ready
        function animateMesaCardForOrder(mesaNumero) {
            // Find the mesa card by mesa number in the title
            const mesaCards = document.querySelectorAll('.mesa-card');
            let targetCard = null;

            mesaCards.forEach(function(card) {
                const cardTitle = card.querySelector('.card-title');
                if (cardTitle && cardTitle.textContent.includes('Mesa ' + mesaNumero)) {
                    targetCard = card;
                }
            });

            if (targetCard) {

                // Add shake animation and visual indicators
                targetCard.classList.add('shake', 'has-ready-order');

                // Stop shaking after 10 seconds
                setTimeout(function() {
                    targetCard.classList.remove('shake');
                }, 10000);

                // Keep the ready order indicator until manually cleared
                // (it will be removed when waiter clicks "Ver Pedidos" or page refreshes)
            } else {
                console.warn('[DASHBOARD NOTIFICATION] Mesa card not found for mesa', mesaNumero);
            }
        }

        // Clear ready order indicators when viewing orders
        function clearMesaReadyIndicators() {
            const cardsWithIndicators = document.querySelectorAll('.mesa-card.has-ready-order');
            cardsWithIndicators.forEach(function(card) {
                card.classList.remove('has-ready-order', 'shake');
            });
        }

        // Add click handler to reset counter when visiting orders
        $(document).on('click', 'a[href*="pedidos-mesa"]', function() {
            clearMesaReadyIndicators();
            resetNotificationCounter();
        });

        // Mesa liberation function (existing)
        function liberarMesa(mesaId, ocupacaoId) {
            if (confirm('Tem certeza que deseja liberar esta mesa?')) {
                $.ajax({
                    url: '<?= $baseUri ?>/garcon/liberar-mesa/',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        mesa_id: mesaId,
                        ocupacao_id: ocupacaoId
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert('Erro: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Erro de conexão.');
                    }
                });
            }
        }

        // Auto refresh a cada 2 minutos
        setInterval(function() {
            location.reload();
        }, 120000);
    </script>
</body>

</html>