<?php $baseUri = Http::base(); ?>
<?php 
// Variables are accessed through $data array like other views in the system
$mesa = isset($data['mesa']) ? $data['mesa'] : new stdClass();
$pedidos = isset($data['pedidos']) ? $data['pedidos'] : [];
$garcon = isset($data['garcon']) ? $data['garcon'] : new stdClass();
$config = isset($data['config']) ? $data['config'] : new stdClass();

// Set default values for mesa
if (!isset($mesa->mesa_id)) $mesa->mesa_id = 'N/A';
if (!isset($mesa->mesa_numero)) $mesa->mesa_numero = 'N/A';
if (!isset($mesa->ocupacao_id)) $mesa->ocupacao_id = 'N/A';
if (!isset($mesa->garcon_id)) $mesa->garcon_id = 'N/A';
if (!isset($mesa->cliente_nome)) $mesa->cliente_nome = 'Não informado';
if (!isset($mesa->numero_pessoas)) $mesa->numero_pessoas = 'Não informado';

// Set default values for garcon
if (!isset($garcon->garcon_id)) $garcon->garcon_id = 'N/A';
if (!isset($garcon->garcon_nome)) $garcon->garcon_nome = 'N/A';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos da Mesa <?= $mesa->mesa_numero ?> - Sistema Garçon</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/css/pedido-mesa.css">   
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/css/mesas.css"> 
</head>
<body>

    <?php require_once 'menu.php'; ?>
    
    <div class="container">
        <!-- Header -->
        <div class="main-header">
            <div class="row">
                <div class="col-md-8">
                    <h2><i class="fa fa-cutlery"></i> Pedidos da Mesa <?= $mesa->mesa_numero ?></h2>
                    <p class="mb-0">Garçon: <?= $garcon->garcon_nome ?></p>
                </div>
                <div class="col-md-4 text-right">
                    <h4><?= date('d/m/Y H:i') ?></h4>
                </div>
            </div>
        </div>

        <!-- Botão Voltar -->
        <a href="<?= $baseUri ?>/garcon/mesas/" class="btn-back">
            <i class="fa fa-arrow-left"></i> Voltar para Mesas
        </a>

        <!-- Informações da Mesa -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-info-circle"></i> Informações da Mesa
            </div>
            <div class="card-body">
                <div class="mesa-info">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Mesa:</strong> <?= $mesa->mesa_numero ?>
                        </div>
                        <div class="col-md-3">
                            <strong>Cliente:</strong> <?= $mesa->cliente_nome ?? 'Não informado' ?>
                        </div>
                        <div class="col-md-3">
                            <strong>Pessoas:</strong> <?= $mesa->numero_pessoas ?? 'Não informado' ?>
                        </div>
                        <div class="col-md-3">
                            <strong>Status:</strong> 
                            <span class="label label-success">Ocupada</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Pedidos -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-list"></i> Pedidos Realizados
                <?php if ($pedidos && count($pedidos) > 0): ?>
                    <span class="badge badge-primary"><?= count($pedidos) ?> pedido(s)</span>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <?php if ($pedidos && count($pedidos) > 0): ?>
                    <?php foreach ($pedidos as $pedido): ?>
                        <div class="pedido-item">
                            <div class="pedido-header">
                                <div>
                                    <strong>Pedido #<?= $pedido->pedido_mesa_id ?></strong>
                                    <small class="text-muted">- <?= date('d/m/Y H:i', strtotime($pedido->pedido_data)) ?></small>
                                </div>
                                <div>
                                    <?php 
                                    $status_text = '';
                                    $status_class = '';
                                    switch($pedido->pedido_status) {
                                        case 1: $status_text = 'Pendente'; $status_class = 'status-1'; break;
                                        case 2: $status_text = 'Em Produção'; $status_class = 'status-2'; break;
                                        case 3: $status_text = 'Pronto'; $status_class = 'status-3'; break;
                                        case 4: $status_text = 'Entregue'; $status_class = 'status-4'; break;
                                        case 5: $status_text = 'Cancelado'; $status_class = 'status-5'; break;
                                        case 6: $status_text = 'Disponível'; $status_class = 'status-6'; break;
                                        default: $status_text = 'Indefinido'; $status_class = 'status-1';
                                    }
                                    ?>
                                    <span class="status-badge <?= $status_class ?>"><?= $status_text ?></span>
                                    
                                    <?php if ($pedido->pedido_status == 6): // Show deliver button for available orders ?>
                                        <button class="btn btn-success btn-sm deliver-btn" 
                                                onclick="marcarComoEntregue(<?= $pedido->pedido_mesa_id ?>, this)" 
                                                title="Marcar como entregue na mesa"
                                                style="margin-left: 10px; font-size: 12px;">
                                            <i class="fa fa-check"></i> Entregar
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="pedido-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <?php if (!empty($pedido->cliente_nome)): ?>
                                            <p><strong>Cliente:</strong> <?= $pedido->cliente_nome ?></p>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($pedido->pedido_obs)): ?>
                                            <p><strong>Observações:</strong> <?= $pedido->pedido_obs ?></p>
                                        <?php endif; ?>
                                        
                                        <!-- Itens do pedido -->
                                        <div class="item-details">
                                            <?php if (isset($pedido->itens) && count($pedido->itens) > 0): ?>
                                                <h5><i class="fa fa-list"></i> Itens do Pedido:</h5>
                                                <div class="mobile-items-list">
                                                    <!-- Desktop Table View -->
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-condensed">
                                                            <thead>
                                                                <tr>
                                                                    <th>Item</th>
                                                                    <th width="60">Qtde</th>
                                                                    <th width="80">Valor</th>
                                                                    <th width="80">Total</th>
                                                                    <th>Obs</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($pedido->itens as $item): ?>
                                                                    <tr id="item-<?= $item->lista_id ?>" class="<?= isset($item->item_removido) && $item->item_removido == 1 ? 'item-removido' : '' ?>">
                                                                        <td>
                                                                            <strong class="<?= isset($item->item_removido) && $item->item_removido == 1 ? 'item-nome-removido' : '' ?>"><?= htmlspecialchars($item->lista_item_nome ?? 'Item sem nome') ?></strong>
                                                                            <?php if (isset($item->produto_nome) && $item->produto_nome): ?>
                                                                                <br><small class="text-muted"><?= htmlspecialchars($item->produto_nome ?? '') ?></small>
                                                                            <?php endif; ?>
                                                                            <?php if (isset($item->item_removido) && $item->item_removido == 1): ?>
                                                                                <br><small class="text-danger"><i class="fa fa-ban"></i> Removido em <?= date('H:i', strtotime($item->removido_em)) ?></small>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge"><?= $item->lista_qtde ?></span>
                                                                        </td>
                                                                        <td>
                                                                            <?php if (isset($item->item_removido) && $item->item_removido == 1): ?>
                                                                                <span class="item-preco-removido">R$ <?= number_format($item->lista_preco, 2, ',', '.') ?></span>
                                                                            <?php else: ?>
                                                                                R$ <?= number_format($item->lista_preco, 2, ',', '.') ?>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php if (isset($item->item_removido) && $item->item_removido == 1): ?>
                                                                                <strong class="item-total item-preco-removido">R$ <?= number_format($item->lista_total, 2, ',', '.') ?></strong>
                                                                            <?php else: ?>
                                                                                <strong class="item-total">R$ <?= number_format($item->lista_total, 2, ',', '.') ?></strong>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php if ($item->lista_item_obs): ?>
                                                                                <small><?= htmlspecialchars($item->lista_item_obs ?? '') ?></small>
                                                                            <?php else: ?>
                                                                                <small class="text-muted">-</small>
                                                                            <?php endif; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                                            
                                                    <!-- Mobile Card View -->
                                                    <?php foreach ($pedido->itens as $item): ?>
                                                        <div class="mobile-item-card <?= isset($item->item_removido) && $item->item_removido == 1 ? 'item-removido' : '' ?>" id="mobile-item-<?= $item->lista_id ?>">
                                                            <div class="mobile-item-header">
                                                                <div class="mobile-item-name <?= isset($item->item_removido) && $item->item_removido == 1 ? 'item-nome-removido' : '' ?>">
                                                                    <?= htmlspecialchars($item->lista_item_nome ?? 'Item sem nome') ?>
                                                                    <?php if (isset($item->item_removido) && $item->item_removido == 1): ?>
                                                                        <br><small class="text-danger"><i class="fa fa-ban"></i> Removido em <?= date('H:i', strtotime($item->removido_em)) ?></small>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div class="mobile-item-qty"><?= $item->lista_qtde ?></div>
                                                            </div>
                                                            <div class="mobile-item-details">
                                                                <?php if (isset($item->item_removido) && $item->item_removido == 1): ?>
                                                                    <span class="item-preco-removido">R$ <?= number_format($item->lista_preco, 2, ',', '.') ?> cada</span>
                                                                    <span class="mobile-item-price item-total item-preco-removido">Total: R$ <?= number_format($item->lista_total, 2, ',', '.') ?></span>
                                                                <?php else: ?>
                                                                    <span>R$ <?= number_format($item->lista_preco, 2, ',', '.') ?> cada</span>
                                                                    <span class="mobile-item-price item-total">Total: R$ <?= number_format($item->lista_total, 2, ',', '.') ?></span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <?php if ($item->lista_item_obs): ?>
                                                                <div class="mobile-item-obs"><?= htmlspecialchars($item->lista_item_obs ?? '') ?></div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php else: ?>
                                                <small class="text-muted">
                                                    <i class="fa fa-info-circle"></i> 
                                                    Nenhum item encontrado para este pedido
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="total-info">
                                            <div><strong>Valor Total:</strong></div>
                                            <div class="h4">R$ <?= number_format($pedido->pedido_total, 2, ',', '.') ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <!-- Resumo Total -->
                    <?php 
                    $total_geral = 0;
                    foreach ($pedidos as $p) {
                        if ($p->pedido_status != 5) { // Não cancelados
                            $total_geral += $p->pedido_total;
                        }
                    }
                    ?>
                    <div class="well well-lg">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Resumo dos Pedidos</h4>
                                <p>Total de pedidos: <strong><?= count($pedidos) ?></strong></p>
                            </div>
                            <div class="col-md-6 text-right">
                                <h4>Total Geral: <strong>R$ <?= number_format($total_geral, 2, ',', '.') ?></strong></h4>
                                <small class="text-muted">Pedidos de mesa não incluem taxa de entrega</small>
                            </div>
                        </div>
                    </div>
                    
                <?php else: ?>
                    <div class="no-pedidos">
                        <i class="fa fa-info-circle fa-3x text-muted"></i>
                        <h4>Nenhum pedido encontrado</h4>
                        <p>Esta mesa ainda não possui pedidos registrados.</p>
                        <div class="btn-group" role="group">
                            <a href="<?= $baseUri ?>/garcon/cardapio/<?= $mesa->mesa_id ?>/" class="btn btn-success" style="margin-right: 15px;">
                                <i class="fa fa-plus"></i> Fazer Primeiro Pedido
                            </a>
                            <a href="<?= $baseUri ?>/garcon/mesas/" class="btn btn-primary">
                                <i class="fa fa-arrow-left"></i> Voltar para Mesas
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Actions -->
        <div class="card">
            <div class="card-header">
                <i class="fa fa-cogs"></i> Ações
            </div>
            <div class="card-body">
                <div class="btn-group" role="group">
                    <a href="<?= $baseUri ?>/garcon/cardapio/<?= $mesa->mesa_id ?>/" class="btn btn-success" style="margin-right: 15px;">
                        <i class="fa fa-plus"></i> Novo Pedido
                    </a>
                    <a href="<?= $baseUri ?>/garcon/mesas/" class="btn btn-default" style="margin-right: 15px;">
                        <i class="fa fa-arrow-left"></i> Voltar para Mesas
                    </a>
                    <button type="button" class="btn btn-warning" onclick="location.reload()">
                        <i class="fa fa-refresh"></i> Atualizar
                    </button>
                </div>
                <div class="mt-3">
                    <p class="text-muted"><i class="fa fa-info-circle"></i> 
                        <strong>Informação:</strong> Para adicionar mais itens, clique em "Novo Pedido". 
                        Apenas o caixa pode modificar pedidos existentes.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="<?= $baseUri ?>/assets/vendor/jquery/jquery-2.1.4.min.js"></script>
    <script src="<?= $baseUri ?>/assets/vendor/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    
    <script>
        // Auto refresh every 2 minutes
        setTimeout(function() {
            location.reload();
        }, 120000);
        
        // Print styles
        window.addEventListener('beforeprint', function() {
            document.body.style.background = 'white';
        });
        
        // Mark order as delivered by waiter
        function marcarComoEntregue(pedidoMesaId, button) {
            if (!confirm('Confirmar que o pedido foi entregue na mesa?')) {
                return;
            }
            
            // Disable button and show loading state
            $(button).prop('disabled', true)
                     .html('<i class="fa fa-spinner fa-spin"></i> Entregando...');
            
            $.ajax({
                url: '<?= $baseUri ?>/garcon/marcar-entregue/',
                type: 'POST',
                dataType: 'json',
                data: {
                    pedido_mesa_id: pedidoMesaId
                },
                success: function(response) {
                    if (response.status === 'success') {
                        showMessage('🎉 Pedido marcado como entregue com sucesso!', 'success');
                        // Update the status badge
                        $(button).closest('.pedido-item').find('.status-badge')
                                 .removeClass('status-6')
                                 .addClass('status-4')
                                 .text('Entregue');
                        // Remove the deliver button
                        $(button).fadeOut(300, function() {
                            $(this).remove();
                        });
                    } else {
                        showMessage('⚠️ Erro: ' + (response.message || 'Não foi possível marcar como entregue'), 'error');
                        // Restore button
                        $(button).prop('disabled', false)
                                 .html('<i class="fa fa-check"></i> Entregar');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('[GARCON ERROR] ' + new Date().toISOString() + ' - Ajax error:', error);
                    showMessage('😱 Erro de conexão. Tente novamente.', 'error');
                    // Restore button
                    $(button).prop('disabled', false)
                             .html('<i class="fa fa-check"></i> Entregar');
                }
            });
        }
        
        // Show messages (kept for future use)
        function showMessage(message, type) {
            var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            var alertHtml = '<div class="alert ' + alertClass + ' alert-dismissible" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">' +
                           '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                           message + '</div>';
            
            $('body').append(alertHtml);
            
            // Auto hide after 3 seconds
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 3000);
        }
    </script>
</body>
</html>