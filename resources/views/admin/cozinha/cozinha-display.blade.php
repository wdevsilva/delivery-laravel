<?php 
// Extract variables from data array for direct access
if (isset($data) && is_array($data)) {
    extract($data);
}
// Ensure config is available with fallback
if (!isset($config) || !$config) {
    $config = (object) ['config_nome' => 'Sistema de Cozinha'];
}
// Ensure pedidos is available with fallback
if (!isset($pedidos)) {
    $pedidos = [];
} ?>
<!DOCTYPE html>
<html>
<head>
    <?php $baseUri = Http::base(); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Cozinha - <?= $config->config_nome ?></title>
    <link rel="icon" type="image/png" href="<?php echo $baseUri; ?>/midias/logo/<?= $_SESSION['base_delivery'] ?>/<?php echo $data['config']->config_foto; ?>" />
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/css/main.css?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/css/main.css') ?>">
    <link rel="stylesheet" href="<?= $baseUri ?>/view/admin/css/cozinha-display.css">
</head>
<body>
    <div class="header-cozinha" id="kitchen-header">
        <h2><i class="fa fa-cutlery"></i> COZINHA - <?= $config->config_nome ?></h2>
    </div>

    <!-- New Order Notification Banner -->
    <div id="newOrderBanner" class="new-order-banner">
        <div style="display: flex; align-items: center;">
            <i class="fa fa-bell" style="margin-right: 8px; font-size: 16px;"></i>
            <span>NOVO PEDIDO AGUARDANDO PREPARO!</span>
        </div>
    </div>

    <div class="stats-bar">
        <div class="stat-item">
            <span class="stat-number" id="stat-aguardando"><?= count(array_filter($pedidos ?: [], function($p) { return $p->pedido_status == 1; })) ?></span>
            <span class="stat-label">Aguardando</span>
        </div>
        <div class="stat-item">
            <span class="stat-number" id="stat-preparo"><?= count(array_filter($pedidos ?: [], function($p) { return $p->pedido_status == 2; })) ?></span>
            <span class="stat-label">Em Preparo</span>
        </div>
        <div class="stat-item clickable" onclick="openReadyOrdersModal()" title="Clique para ver pedidos prontos">
            <span class="stat-number" id="stat-pronto"><?= count(array_filter($pedidos ?: [], function($p) { return $p->pedido_status == 6; })) ?></span>
            <span class="stat-label">Prontos 👁️</span>
        </div>
        <div class="stat-item clickable" onclick="openDeliveredOrdersModal()" title="Clique para ver pedidos entregues">
            <span class="stat-number" id="stat-entregue"><?= count(array_filter($pedidos ?: [], function($p) { return $p->pedido_status == 4; })) ?></span>
            <span class="stat-label">Entregues 📋</span>
        </div>
        <div class="stat-item">
            <span class="stat-number" id="stat-total"><?= count($pedidos ?: []) ?></span>
            <span class="stat-label">Total</span>
        </div>
    </div>

    <div class="main-content">
        <div class="pedidos-grid" id="pedidos-container">
            <?php if ($pedidos && count($pedidos) > 0): ?>
                <?php 
                // Check if there are any active orders (not delivered or cancelled)
                $active_orders = array_filter($pedidos, function($p) { 
                    return $p->pedido_status != 4 && $p->pedido_status != 5; 
                });
                ?>
                <?php if (count($active_orders) > 0): ?>
                    <?php foreach ($pedidos as $pedido): ?>
                        <?php if ($pedido->pedido_status != 6 && $pedido->pedido_status != 4): // Hide ready and delivered orders from main display ?>
                    <div class="pedido-card <?= getPedidoClass($pedido->pedido_status) ?>" 
                         data-pedido="<?= $pedido->pedido_id ?>" 
                         data-status="<?= $pedido->pedido_status ?>"
                         data-source="<?= isset($pedido->source_table) ? $pedido->source_table : 'pedido' ?>">
                        
                        <div class="tempo-pedido">
                            <?= getTempoDecorrido($pedido->pedido_data) ?>
                        </div>
                        
                        <div class="pedido-header">
                            <div class="pedido-numero">
                                <?php if (isset($pedido->source_table) && $pedido->source_table === 'pedido_mesa'): ?>
                                    #<?= str_pad($pedido->pedido_id, 3, '0', STR_PAD_LEFT) ?>
                                <?php else: ?>
                                    #<?= str_pad($pedido->pedido_numero_entrega ?? $pedido->pedido_id, 3, '0', STR_PAD_LEFT) ?>
                                <?php endif; ?>
                            </div>
                            <div class="pedido-tipo"><?= $pedido->tipo_pedido_nome ?></div>
                        </div>
                        
                        <div class="pedido-info">
                            <?php if (isset($pedido->mesa_numero) && $pedido->mesa_numero): ?>
                                <div><strong>Mesa:</strong> <?= $pedido->mesa_numero ?></div>
                                <div><strong>Garçon:</strong> <?= $pedido->garcon_nome ?: 'N/A' ?></div>
                            <?php endif; ?>
                            <div><strong>Horário:</strong> <?= date('H:i', strtotime($pedido->pedido_data)) ?></div>
                        </div>

                        <div class="pedido-itens" id="itens-<?= $pedido->pedido_id ?>">
                            <div class="text-center">
                                <i class="fa fa-spinner fa-spin"></i> Carregando itens...
                            </div>
                        </div>

                        <?php if (isset($pedido->pedido_obs) && !empty(trim($pedido->pedido_obs))): ?>
                            <div style="color: rgb(191, 255, 107);; padding: 10px; border-radius: 8px; margin: 10px 0; font-size: 1.4rem;">
                                <strong>Obs:</strong> <?= nl2br(strip_tags($pedido->pedido_obs)) ?>
                            </div>
                        <?php endif; ?>

                        <div class="pedido-actions">
                            <?php if ($pedido->pedido_status == 1): // Aguardando ?>
                                <button class="btn-action btn-iniciar" onclick="iniciarPreparo(<?= $pedido->pedido_id ?>, '<?= isset($pedido->source_table) ? $pedido->source_table : 'pedido' ?>')">
                                    <i class="fa fa-play"></i> Iniciar Preparo
                                </button>
                            <?php elseif ($pedido->pedido_status == 2): // Em preparo ?>
                                <button class="btn-action btn-pronto" onclick="marcarPronto(<?= $pedido->pedido_id ?>, '<?= isset($pedido->source_table) ? $pedido->source_table : 'pedido' ?>')">
                                    <i class="fa fa-check"></i> Marcar Pronto
                                </button>
                            <?php endif; ?>
                            
                            <!-- Botão de Impressão Térmica -->
                            <button class="btn-action btn-imprimir" 
                                    onclick="imprimirTermicoCozinha(<?= $pedido->pedido_id ?>)" 
                                    title="Imprimir Ticket Térmico (80mm)">
                                <i class="fa fa-print"></i> Imprimir
                            </button>
                        </div>
                    </div>
                    <?php endif; // End if not ready order ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fa fa-check-circle"></i>
                    <h3>Nenhum pedido pendente!</h3>
                    <p>Todos os pedidos foram processados.</p>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fa fa-check-circle"></i>
                <h3>Nenhum pedido pendente!</h3>
                <p>Todos os pedidos foram processados.</p>
            </div>
        <?php endif; ?>
        </div>
    </div>

    <div class="last-update">
        Última atualização: <span id="last-update"><?= date('H:i:s') ?></span>
    </div>

    <!-- Modal for Ready Orders -->
    <div id="readyOrdersModal" class="ready-orders-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fa fa-check-circle"></i> Pedidos Prontos</h3>
                <button class="close-modal" onclick="closeReadyOrdersModal()">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="ready-orders-grid" id="readyOrdersGrid">
                    <!-- Ready orders will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Delivered Orders -->
    <div id="deliveredOrdersModal" class="ready-orders-modal">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);">
                <h3><i class="fa fa-truck"></i> Pedidos Entregues</h3>
                <button class="close-modal" onclick="closeDeliveredOrdersModal()">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="ready-orders-grid" id="deliveredOrdersGrid">
                    <!-- Delivered orders will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script src="<?= $baseUri ?>/assets/vendor/jquery/jquery-2.1.4.min.js"></script>
    <script>
        let ultimoUpdate = '<?= date('Y-m-d H:i:s') ?>';
        let ultimoNumeroPedidos = <?= count(array_filter($pedidos ?: [], function($p) { return $p->pedido_status == 1; })) ?>; // Only count orders waiting for preparation
        let primeiraVerificacao = true;

        // Sound notification function
        function playNotificationSound() {
            try {
                const audio = new Audio();
                audio.volume = 0.8;
                audio.preload = 'auto';
                audio.src = '<?= $baseUri ?>/midias/alerta/alert_cozinha.mp3';
                
                audio.onerror = function() {
                    playFallbackSound();
                };
                
                const playPromise = audio.play();
                if (playPromise !== undefined) {
                    playPromise.catch(function(error) {
                        playFallbackSound();
                    });
                }
            } catch (e) {
                playFallbackSound();
            }
        }
        
        // Fallback sound using Web Audio API
        function playFallbackSound() {
            try {
                if (typeof AudioContext === 'undefined' && typeof webkitAudioContext === 'undefined') {
                    return;
                }
                
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
                oscillator.frequency.setValueAtTime(1000, audioContext.currentTime + 0.1);
                oscillator.frequency.setValueAtTime(800, audioContext.currentTime + 0.2);
                oscillator.frequency.setValueAtTime(600, audioContext.currentTime + 0.3);
                
                gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.5);
            } catch (e) {
                // Silent fail
            }
        }

        // Kitchen shake animation
        function shakeKitchen() {
            // Only shake the main content area, not fixed headers
            const mainContent = document.querySelector('.main-content');
            if (mainContent) {
                mainContent.classList.add('kitchen-shake');
                setTimeout(function() {
                    mainContent.classList.remove('kitchen-shake');
                }, 500);
            }
            
            // Show notification banner with smooth transition
            const banner = document.getElementById('newOrderBanner');
            if (banner) {
                banner.style.display = 'block';
                banner.offsetHeight;
                banner.classList.add('show');
                
                setTimeout(function() {
                    banner.classList.remove('show');
                    banner.classList.add('hide');
                    
                    setTimeout(function() {
                        banner.style.display = 'none';
                        banner.classList.remove('hide');
                    }, 400);
                }, 3000);
            }
        }

        // Check for new orders via AJAX
        function verificarNovosPedidosAjax() {
            $.ajax({
                url: '<?= $baseUri ?>/cozinha/get-novos-pedidos/',
                type: 'GET',
                dataType: 'json',
                timeout: 5000,
                success: function(response) {
                    if (response && response.total_pedidos !== undefined) {
                        // Count orders waiting for preparation (status 1)
                        let pedidosAguardando = 0;
                        if (response.pedidos && response.pedidos.length > 0) {
                            pedidosAguardando = response.pedidos.filter(function(pedido) {
                                return parseInt(pedido.pedido_status) === 1;
                            }).length;
                        }
                        
                        
                        // Trigger notifications for:
                        // 1. First check if there are orders waiting (immediate alert)
                        // 2. Subsequent checks if new orders are added
                        const shouldNotify = (primeiraVerificacao && pedidosAguardando > 0) || 
                                           (!primeiraVerificacao && pedidosAguardando > ultimoNumeroPedidos);
                        
                        if (shouldNotify) {
                            const novosPedidosAguardando = primeiraVerificacao ? pedidosAguardando : (pedidosAguardando - ultimoNumeroPedidos);
                            
                            // Trigger notifications only for orders waiting preparation
                            playNotificationSound();
                            shakeKitchen();
                            
                            // Show notification with details
                            const ordersWaiting = response.pedidos.filter(function(pedido) {
                                return parseInt(pedido.pedido_status) === 1;
                            });
                            
                            if (ordersWaiting.length > 0) {
                                setTimeout(function() {
                                    let mensagem = novosPedidosAguardando > 1 ? 
                                        'NOVOS PEDIDOS AGUARDANDO PREPARO: ' : 
                                        'NOVO PEDIDO AGUARDANDO PREPARO: ';
                                    
                                    ordersWaiting.slice(-novosPedidosAguardando).forEach(function(pedido, index) {
                                        if (index > 0) mensagem += ', ';
                                        mensagem += '#' + (pedido.pedido_numero_entrega || pedido.pedido_id || pedido.pedido_mesa_id);
                                        if (pedido.mesa_numero) {
                                            mensagem += ' (Mesa ' + pedido.mesa_numero + ')';
                                        }
                                    });
                                    
                                    const banner = document.getElementById('newOrderBanner');
                                    if (banner) {
                                        const messageText = banner.querySelector('span');
                                        if (messageText) {
                                            messageText.textContent = mensagem;
                                        } else {
                                            banner.innerHTML = '<div style="display: flex; align-items: center;"><i class="fa fa-bell" style="margin-right: 8px; font-size: 16px;"></i><span>' + mensagem + '</span></div>';
                                        }
                                    }
                                }, 100);
                            }
                        }
                        
                        ultimoNumeroPedidos = pedidosAguardando;
                        primeiraVerificacao = false;
                    }
                },
                error: function(xhr, status, error) {
                    // Silent error handling
                }
            });
        }

        // Highlight orders waiting for preparation
        function highlightWaitingOrders() {
            $('.pedido-card').each(function() {
                const status = $(this).data('status');
                if (parseInt(status) === 1) { // Status 1 = Aguardando
                    $(this).addClass('aguardando-preparo');
                }
            });
        }

        // Modal functions for ready orders
        function openReadyOrdersModal() {
            loadReadyOrders();
            document.getElementById('readyOrdersModal').style.display = 'block';
        }

        function closeReadyOrdersModal() {
            document.getElementById('readyOrdersModal').style.display = 'none';
        }

        // Modal functions for delivered orders
        function openDeliveredOrdersModal() {
            loadDeliveredOrders();
            document.getElementById('deliveredOrdersModal').style.display = 'block';
        }

        function closeDeliveredOrdersModal() {
            document.getElementById('deliveredOrdersModal').style.display = 'none';
        }

        function loadReadyOrders() {
            const readyOrdersGrid = document.getElementById('readyOrdersGrid');
            readyOrdersGrid.innerHTML = '<div style="text-align: center; padding: 40px;"><i class="fa fa-spinner fa-spin" style="font-size: 2rem;"></i><br><br>Carregando pedidos prontos...</div>';
            
            // Get ready orders data from PHP
            const readyOrders = <?= json_encode(array_filter($pedidos ?: [], function($p) { return $p->pedido_status == 6; })) ?>;
            
            if (readyOrders && Object.keys(readyOrders).length > 0) {
                let html = '';
                Object.values(readyOrders).forEach(function(pedido) {
                    html += createReadyOrderCard(pedido);
                });
                readyOrdersGrid.innerHTML = html;
                
                // Load items for each ready order
                Object.values(readyOrders).forEach(function(pedido) {
                    carregarItensReadyOrder(pedido.pedido_id, pedido.source_table || 'pedido');
                });
            } else {
                readyOrdersGrid.innerHTML = `
                    <div class="ready-orders-empty" style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #636e72; min-height: 300px; display: flex; flex-direction: column; justify-content: center; align-items: center; width: 100%;">
                        <i class="fa fa-smile-o"></i>
                        <h3>Nenhum pedido pronto!</h3>
                        <p>Todos os pedidos prontos já foram entregues.</p>
                    </div>
                `;
            }
        }

        function createReadyOrderCard(pedido) {
            const orderNumber = pedido.source_table === 'pedido_mesa' 
                ? String(pedido.pedido_id).padStart(3, '0')
                : String(pedido.pedido_numero_entrega || pedido.pedido_id).padStart(3, '0');
            
            const mesaInfo = pedido.mesa_numero 
                ? `<div><strong>Mesa:</strong> ${pedido.mesa_numero}</div>
                   <div><strong>Garçon:</strong> ${pedido.garcon_nome || 'N/A'}</div>`
                : '';
            
            return `
                <div class="ready-order-card" style="position: relative;">
                    <div class="ready-time">${getTempoDecorrido(pedido.pedido_data)}</div>
                    <div class="ready-order-header">
                        <div class="ready-order-number">#${orderNumber}</div>
                        <div class="ready-badge">PRONTO</div>
                    </div>
                    <div class="ready-order-info">
                        <div><strong>Cliente:</strong> ${pedido.nome_cliente || 'N/A'}</div>
                        ${mesaInfo}
                        <div><strong>Horário:</strong> ${new Date(pedido.pedido_data).toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'})}</div>
                        ${pedido.pedido_obs ? `<div style="margin-top: 8px; padding: 8px; background: #555; border-radius: 6px; font-size: 0.85rem;"><strong>Obs:</strong> ${pedido.pedido_obs}</div>` : ''}
                        <div style="margin-top: 10px; padding: 10px; background: #636e72; border-radius: 8px;" id="ready-itens-${pedido.pedido_id}">
                            <i class="fa fa-spinner fa-spin"></i> Carregando itens...
                        </div>
                    </div>
                </div>
            `;
        }

        function carregarItensReadyOrder(pedidoId, sourceTable) {
            $.ajax({
                url: '<?= $baseUri ?>/cozinha/detalhes-pedido/',
                type: 'GET',
                dataType: 'json',
                data: { 
                    pedido_id: pedidoId,
                    source_table: sourceTable || 'pedido'
                },
                success: function(response) {
                    if (response.status === 'success' && response.lista) {
                        let html = '';
                        response.lista.forEach(function(item) {
                            const itemNome = item.lista_item_nome || item.item_nome || 'Item';
                            const itemQtde = item.lista_qtde || item.qtde || 1;
                            const itemObs = item.lista_item_obs || item.item_obs || '';
                            const itemPreco = item.lista_preco || item.preco || item.lista_opcao_preco || 0;
                            
                            html += `<div style="display: flex; justify-content: space-between; align-items: center; padding: 4px 0; border-bottom: 1px solid #555;">`;
                            html += `<div><span style="background: #00b894; color: white; border-radius: 10px; padding: 2px 6px; margin-right: 8px; font-size: 0.8rem;">${itemQtde}x</span>${itemNome}`;
                            if (itemObs) {
                                html += `<br><small style="color: rgb(191, 255, 107); font-style: italic; margin-left: 0;">Obs: ${itemObs}</small>`;
                            }
                            html += `</div>`;
                            html += `</div>`;
                        });
                        $(`#ready-itens-${pedidoId}`).html(html);
                    } else {
                        $(`#ready-itens-${pedidoId}`).html('<div style="text-align: center; color: #999;">Nenhum item encontrado</div>');
                    }
                },
                error: function() {
                    $(`#ready-itens-${pedidoId}`).html('<div style="text-align: center; color: #ff6b6b;">Erro ao carregar itens</div>');
                }
            });
        }

        function loadDeliveredOrders() {
            const deliveredOrdersGrid = document.getElementById('deliveredOrdersGrid');
            deliveredOrdersGrid.innerHTML = '<div style="text-align: center; padding: 40px;"><i class="fa fa-spinner fa-spin" style="font-size: 2rem;"></i><br><br>Carregando pedidos entregues...</div>';
            
            // Get delivered orders data from PHP
            const deliveredOrders = <?= json_encode(array_filter($pedidos ?: [], function($p) { return $p->pedido_status == 4; })) ?>;
            
            if (deliveredOrders && Object.keys(deliveredOrders).length > 0) {
                let html = '';
                Object.values(deliveredOrders).forEach(function(pedido) {
                    html += createDeliveredOrderCard(pedido);
                });
                deliveredOrdersGrid.innerHTML = html;
                
                // Load items for each delivered order
                Object.values(deliveredOrders).forEach(function(pedido) {
                    carregarItensDeliveredOrder(pedido.pedido_id, pedido.source_table || 'pedido');
                });
            } else {
                deliveredOrdersGrid.innerHTML = `
                    <div class="delivered-orders-empty" style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #636e72; min-height: 300px; display: flex; flex-direction: column; justify-content: center; align-items: center; width: 100%;">
                        <i class="fa fa-truck"></i>
                        <h3>Nenhum pedido entregue!</h3>
                        <p>Ainda não há pedidos entregues no sistema.</p>
                    </div>
                `;
            }
        }

        function createDeliveredOrderCard(pedido) {
            const orderNumber = pedido.source_table === 'pedido_mesa' 
                ? String(pedido.pedido_id).padStart(3, '0')
                : String(pedido.pedido_numero_entrega || pedido.pedido_id).padStart(3, '0');
            
            const mesaInfo = pedido.mesa_numero 
                ? `<div><strong>Mesa:</strong> ${pedido.mesa_numero}</div>
                   <div><strong>Garçon:</strong> ${pedido.garcon_nome || 'N/A'}</div>`
                : '';
            
            // Calculate delivery duration from pedido_obs if available
            const deliveryDuration = getDeliveryDuration(pedido.pedido_obs, pedido.pedido_data);
            
            return `
                <div class="delivered-order-card" style="position: relative;">
                    <div class="delivered-time">${deliveryDuration}</div>
                    <div class="delivered-order-header">
                        <div class="delivered-order-number">#${orderNumber}</div>
                        <div class="delivered-badge">ENTREGUE</div>
                    </div>
                    <div class="delivered-order-info">
                        <div><strong>Cliente:</strong> ${pedido.nome_cliente || 'N/A'}</div>
                        ${mesaInfo}
                        <div><strong>Horário:</strong> ${new Date(pedido.pedido_data).toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'})}</div>
                        <div style="margin-top: 10px; padding: 10px; background: #636e72; border-radius: 8px;" id="delivered-itens-${pedido.pedido_id}">
                            <i class="fa fa-spinner fa-spin"></i> Carregando itens...
                        </div>
                    </div>
                </div>
            `;
        }

        function carregarItensDeliveredOrder(pedidoId, sourceTable) {
            $.ajax({
                url: '<?= $baseUri ?>/cozinha/detalhes-pedido/',
                type: 'GET',
                dataType: 'json',
                data: { 
                    pedido_id: pedidoId,
                    source_table: sourceTable || 'pedido'
                },
                success: function(response) {
                    if (response.status === 'success' && response.lista) {
                        let html = '';
                        response.lista.forEach(function(item) {
                            const itemNome = item.lista_item_nome || item.item_nome || 'Item';
                            const itemQtde = item.lista_qtde || item.qtde || 1;
                            const itemObs = item.lista_item_obs || item.item_obs || '';
                            const itemPreco = item.lista_preco || item.preco || item.lista_opcao_preco || 0;
                            
                            html += `<div style="display: flex; justify-content: space-between; align-items: center; padding: 4px 0; border-bottom: 1px solid #555;">`;
                            html += `<div><span style="background: #74b9ff; color: white; border-radius: 10px; padding: 2px 6px; margin-right: 8px; font-size: 0.8rem;">${itemQtde}x</span>${itemNome}`;
                            if (itemObs) {
                                html += `<br><small style="color: rgb(191, 255, 107);; font-style: italic; margin-left: 0;">Obs: ${itemObs}</small>`;
                            }
                            html += `</div>`;
                            html += `</div>`;
                        });
                        $(`#delivered-itens-${pedidoId}`).html(html);
                    } else {
                        $(`#delivered-itens-${pedidoId}`).html('<div style="text-align: center; color: #999;">Nenhum item encontrado</div>');
                    }
                },
                error: function() {
                    $(`#delivered-itens-${pedidoId}`).html('<div style="text-align: center; color: #ff6b6b;">Erro ao carregar itens</div>');
                }
            });
        }

        // Helper function for time calculation
        function getTempoDecorrido(pedidoData) {
            const agora = new Date();
            const dataPedido = new Date(pedidoData);
            const diffMs = agora - dataPedido;
            const diffMins = Math.floor(diffMs / 60000);
            
            if (diffMins < 1) return 'Agora';
            if (diffMins < 60) return diffMins + 'm';
            
            const diffHours = Math.floor(diffMins / 60);
            const remainingMins = diffMins % 60;
            return diffHours + 'h' + (remainingMins > 0 ? remainingMins + 'm' : '');
        }
        
        // Helper function to calculate delivery duration for completed orders
        function getDeliveryDuration(pedidoObs, pedidoData) {
            if (!pedidoObs) {
                return 'N/A';
            }
            
            // Look for delivery timestamp in pedido_obs: [ENTREGA HH:MM] and full datetime
            const deliveryMatch = pedidoObs.match(/\[ENTREGA (\d{2}:\d{2})\].*?(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/);
            const simpleDeliveryMatch = pedidoObs.match(/\[ENTREGA (\d{2}:\d{2})\]/);
            
            let deliveryDateTime;
            
            if (deliveryMatch && deliveryMatch[2]) {
                // Full datetime available
                deliveryDateTime = new Date(deliveryMatch[2]);
            } else if (simpleDeliveryMatch) {
                // Only time available, estimate date
                const deliveryTime = simpleDeliveryMatch[1]; // HH:MM format
                const orderDate = new Date(pedidoData);
                
                // Create delivery datetime by combining order date with delivery time
                deliveryDateTime = new Date(orderDate);
                const [hours, minutes] = deliveryTime.split(':');
                deliveryDateTime.setHours(parseInt(hours), parseInt(minutes), 0, 0);
                
                // If delivery time is earlier than order time, assume it's next day
                if (deliveryDateTime < orderDate) {
                    deliveryDateTime.setDate(deliveryDateTime.getDate() + 1);
                }
            } else {
                return 'N/A';
            }
            
            const orderDate = new Date(pedidoData);
            const diffMs = deliveryDateTime - orderDate;
            const diffMins = Math.floor(diffMs / 60000);
            
            if (diffMins < 1) return '< 1m';
            if (diffMins < 60) return diffMins + 'm';
            
            const diffHours = Math.floor(diffMins / 60);
            const remainingMins = diffMins % 60;
            
            if (diffHours > 0 && remainingMins > 0) {
                return diffHours + 'h' + remainingMins + 'm';
            } else if (diffHours > 0) {
                return diffHours + 'h';
            } else {
                return remainingMins + 'm';
            }
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const readyModal = document.getElementById('readyOrdersModal');
            const deliveredModal = document.getElementById('deliveredOrdersModal');
            if (event.target === readyModal) {
                closeReadyOrdersModal();
            }
            if (event.target === deliveredModal) {
                closeDeliveredOrdersModal();
            }
        }

        function iniciarPreparo(pedidoId, sourceTable) {
            $.ajax({
                url: '<?= $baseUri ?>/cozinha/atualizar-status/',
                type: 'POST',
                dataType: 'json',
                data: { 
                    pedido_id: pedidoId,
                    status: 2,
                    source_table: sourceTable || 'pedido'
                },
                success: function(response) {
                    if (response.status === 'success') {
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

        function marcarPronto(pedidoId, sourceTable) {
            $.ajax({
                url: '<?= $baseUri ?>/cozinha/atualizar-status/',
                type: 'POST',
                dataType: 'json',
                data: { 
                    pedido_id: pedidoId,
                    status: 6,
                    source_table: sourceTable || 'pedido'
                },
                success: function(response) {
                    if (response.status === 'success') {
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

        function carregarItensPedido(pedidoId, sourceTable) {
            $.ajax({
                url: '<?= $baseUri ?>/cozinha/detalhes-pedido/',
                type: 'GET',
                dataType: 'json',
                data: { 
                    pedido_id: pedidoId,
                    source_table: sourceTable || 'pedido'
                },
                success: function(response) {
                    if (response.status === 'success' && response.lista) {
                        let html = '';
                        response.lista.forEach(function(item) {
                            html += '<div class="item-linha">';
                            // Handle different property names between pedido and pedido_mesa
                            const itemNome = item.lista_item_nome || item.item_nome || 'Item';
                            const itemQtde = item.lista_qtde || item.qtde || 1;
                            const itemObs = item.lista_item_obs || item.item_obs || '';
                            const itemPreco = item.lista_preco || item.preco || item.lista_opcao_preco || 0;
                            
                            html += '<div>';
                            html += '<span class="item-qtd">' + itemQtde + 'x</span> ' + itemNome;
                            if (itemObs) {
                                html += '<br><small style="color: rgb(191, 255, 107); font-style: italic; margin-left: 0;">Obs: ' + itemObs + '</small>';
                            }
                            html += '</div>';
                            html += '<div style="font-weight: bold; white-space: nowrap;">R$ ' + parseFloat(itemPreco).toFixed(2).replace('.', ',') + '</div>';
                            html += '</div>';
                        });
                        $('#itens-' + pedidoId).html(html);
                    } else {
                        $('#itens-' + pedidoId).html('<div class="text-center text-muted">Nenhum item encontrado</div>');
                    }
                },
                error: function() {
                    $('#itens-' + pedidoId).html('<div class="text-center text-danger">Erro ao carregar itens</div>');
                }
            });
        }

        $(document).ready(function() {
            // Load items for all orders (only those on main screen)
            $('.pedido-card').each(function() {
                const pedidoId = $(this).data('pedido');
                const sourceTable = $(this).data('source') || 'pedido';
                carregarItensPedido(pedidoId, sourceTable);
            });

            // Check for new orders on page load (after first load)
            setTimeout(function() {
                verificarNovosPedidosAjax();
                
                // Highlight orders waiting for preparation
                highlightWaitingOrders();
            }, 2000);

            // Auto refresh every 15 seconds
            setInterval(function() {
                location.reload();
            }, 15000);

            // Check for new orders via AJAX every 5 seconds (more frequent than page refresh)
            setInterval(function() {
                verificarNovosPedidosAjax();
            }, 5000);

            // Update timestamp
            setInterval(function() {
                $('#last-update').text(new Date().toLocaleTimeString());
            }, 1000);
            
            // Auto-open modal if there are ready orders
            setTimeout(function() {
                const readyCount = <?= count(array_filter($pedidos ?: [], function($p) { return $p->pedido_status == 6; })) ?>;
                // Silent check for ready orders
            }, 2000);
            
            // Test comment removed
        });
        
        // Função para impressão térmica da cozinha
        function imprimirTermicoCozinha(pedidoId) {
            const url = '<?= $baseUri ?>/cozinha/imprimir-termico/' + pedidoId + '/';
            
            // Abrir em nova janela para impressão
            const printWindow = window.open(url, '_blank', 'width=400,height=600,menubar=no,toolbar=no,location=no,status=no,scrollbars=yes,resizable=yes');
            
            if (printWindow) {
                printWindow.focus();
            } else {
                alert('Pop-up bloqueado! Permita pop-ups para imprimir.');
            }
        }
    </script>
</body>
</html>

<?php
function getPedidoClass($status) {
    switch($status) {
        case 1: return 'novo';
        case 2: return 'preparo';
        case 3: return 'entrega';
        case 6: return 'pronto';
        default: return '';
    }
}

function getStatusNome($status) {
    switch($status) {
        case 1: return 'Aguardando';
        case 2: return 'Em Preparo';
        case 3: return 'Saiu p/ Entrega';
        case 6: return 'Pronto';
        default: return 'N/A';
    }
}

function getTempoDecorrido($data_pedido) {
    $agora = new DateTime();
    $pedido_time = new DateTime($data_pedido);
    $diff = $agora->diff($pedido_time);
    
    if ($diff->h > 0) {
        return $diff->h . 'h ' . $diff->i . 'min';
    } else {
        return $diff->i . 'min';
    }
}
?>