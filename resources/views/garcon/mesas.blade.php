<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Mesas - <?= $data['config']->config_nome ?></title>
    <link rel="icon" type="image/png" href="<?php echo $baseUri; ?>/midias/logo/<?= $_SESSION['base_delivery'] ?>/<?php echo $data['config']->config_foto; ?>" />
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/css/main.css?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/css/main.css') ?>">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/css/garcon-mesas.css"> 
</head>
<body>
    
    <?php require_once 'menu.php'; ?>

    <div class="container mt-4">
        <!-- Page Header -->
        <div class="section-header">
            <div class="row">
                <div class="col-md-8">
                    <h2><i class="fa fa-th-large"></i> Gerenciar Mesas</h2>
                    <p class="lead">Visualize e gerencie suas mesas ocupadas e disponíveis</p>
                </div>
                <div class="col-md-4 text-right">
                    <button type="button" class="btn btn-success" onclick="location.reload()">
                        <i class="fa fa-refresh"></i> Atualizar
                    </button>
                </div>
            </div>
        </div>

        <!-- Restaurant Floor Plan -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fa fa-map"></i> Mapa de Mesas do Restaurante
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="floor-plan">
                            <div class="floor-plan-grid">
                                <?php 
                                // Function to get status information
                                function getTableStatusInfo($mesa, $mesas_ocupadas_ids) {
                                    // Check if occupied by current waiter
                                    if (in_array($mesa->mesa_id, $mesas_ocupadas_ids)) {
                                        return [
                                            'class' => 'occupied',
                                            'text' => 'Ocupada',
                                            'clickable' => false
                                        ];
                                    }
                                    
                                    // Check mesa_status for other statuses
                                    switch (intval($mesa->mesa_status)) {
                                        case 0: // Livre
                                            return [
                                                'class' => 'available',
                                                'text' => 'Livre',
                                                'clickable' => true
                                            ];
                                        case 1: // Ocupada (by another waiter)
                                            return [
                                                'class' => 'occupied',
                                                'text' => 'Ocupada',
                                                'clickable' => false
                                            ];
                                        case 2: // Reservada
                                            return [
                                                'class' => 'reserved',
                                                'text' => 'Reservada',
                                                'clickable' => false
                                            ];
                                        case 3: // Manutenção
                                            return [
                                                'class' => 'maintenance',
                                                'text' => 'Manutenção',
                                                'clickable' => false
                                            ];
                                        default:
                                            return [
                                                'class' => 'available',
                                                'text' => 'Livre',
                                                'clickable' => true
                                            ];
                                    }
                                }
                                
                                // Combine all tables for the floor plan
                                $todas_mesas = $data['todas_mesas'] ?? [];
                                $mesas_ocupadas_ids = [];
                                
                                // Get occupied table IDs by current waiter
                                if (isset($data['mesas_atendidas']) && $data['mesas_atendidas']) {
                                    foreach ($data['mesas_atendidas'] as $mesa) {
                                        $mesas_ocupadas_ids[] = $mesa->mesa_id;
                                    }
                                }
                                
                                // Sort tables by number
                                usort($todas_mesas, function($a, $b) {
                                    return intval($a->mesa_numero) - intval($b->mesa_numero);
                                });
                                
                                // Display all tables in the floor plan
                                foreach ($todas_mesas as $mesa):
                                    $status_info = getTableStatusInfo($mesa, $mesas_ocupadas_ids);
                                    $onclick = $status_info['clickable'] ? "onclick=\"ocuparMesa({$mesa->mesa_id})\"" : '';
                                ?>
                                    <div class="table-slot <?= $status_info['class'] ?>" <?= $onclick ?> data-mesa-id="<?= $mesa->mesa_id ?>">
                                        <div class="table-icon">
                                            <i class="fa fa-cutlery"></i>
                                        </div>
                                        <div class="table-number"><?= $mesa->mesa_numero ?></div>
                                        <div class="table-status"><?= $status_info['text'] ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <!-- Legend -->
                            <div class="floor-plan-legend">
                                <div class="legend-item">
                                    <div class="legend-color legend-available"></div>
                                    <span>Mesa Livre</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color legend-occupied"></div>
                                    <span>Mesa Ocupada</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color legend-reserved"></div>
                                    <span>Mesa Reservada</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color legend-maintenance"></div>
                                    <span>Mesa em Manutenção</span>
                                </div>
                                <div class="legend-item">
                                    <i class="fa fa-info-circle text-info"></i>
                                    <span>Clique em uma mesa livre para ocupar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="fa fa-exclamation-triangle"></i> <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="fa fa-check"></i> <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php endif; ?>

        <!-- Minhas Mesas Ocupadas -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fa fa-user-circle"></i> Minhas Mesas Ocupadas
                            <span class="badge badge-warning"><?= count($data['mesas_atendidas'] ?? []) ?></span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if ($data['mesas_atendidas'] && count($data['mesas_atendidas']) > 0): ?>
                            <div class="row">
                                <?php foreach ($data['mesas_atendidas'] as $mesa): ?>
                                    <div class="col-md-4">
                                        <div class="card mesa-card mesa-ocupada">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    Mesa <?= $mesa->mesa_numero ?>
                                                    <span class="badge badge-warning">Ocupada</span>
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text">
                                                    <strong>Cliente:</strong> <?= $mesa->cliente_nome ?: 'N/I' ?><br>
                                                    <strong>Pessoas:</strong> <?= $mesa->numero_pessoas ?: 'N/I' ?><br>
                                                    <strong>Localização:</strong> <?= $mesa->mesa_localizacao ?: 'N/I' ?><br>
                                                    <strong>Desde:</strong> <?= date('H:i', strtotime($mesa->data_inicio)) ?>
                                                </p>
                                                
                                                <div class="btn-group btn-group-sm d-flex" role="group">
                                                    <a href="<?= $baseUri ?>/garcon/cardapio/<?= $mesa->mesa_id ?>/" 
                                                       class="btn btn-primary btn-action">
                                                        <i class="fa fa-plus"></i> Novo Pedido
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
                            <div class="text-center py-4">
                                <i class="fa fa-info-circle fa-3x text-muted"></i>
                                <h4>Nenhuma mesa ocupada</h4>
                                <p class="text-muted">Você não possui mesas ocupadas no momento.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mesas Disponíveis -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fa fa-plus-circle"></i> Mesas Disponíveis
                            <span class="badge badge-success"><?= count($data['mesas_livres'] ?? []) ?></span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if ($data['mesas_livres'] && count($data['mesas_livres']) > 0): ?>
                            <div class="row">
                                <?php foreach ($data['mesas_livres'] as $mesa): ?>
                                    <div class="col-md-3">
                                        <div class="card mesa-card mesa-livre">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    Mesa <?= $mesa->mesa_numero ?>
                                                    <span class="badge badge-success status-badge status-livre">Livre</span>
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text">
                                                    <strong>Capacidade:</strong> <?= $mesa->mesa_capacidade ?> pessoas<br>
                                                    <strong>Local:</strong> <?= $mesa->mesa_localizacao ?: 'N/I' ?>
                                                </p>
                                                
                                                <button type="button" class="btn btn-primary btn-sm btn-block" 
                                                        onclick="ocuparMesa(<?= $mesa->mesa_id ?>)">
                                                    <i class="fa fa-user-plus"></i> Ocupar Mesa
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fa fa-check-circle fa-3x text-success"></i>
                                <h4>Nenhuma mesa livre</h4>
                                <p class="text-muted">Todas as mesas livres estão ocupadas no momento.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mesas Reservadas -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fa fa-bookmark"></i> Mesas Reservadas
                            <span class="badge badge-info"><?= count($data['mesas_reservadas'] ?? []) ?></span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (isset($data['mesas_reservadas']) && $data['mesas_reservadas'] && count($data['mesas_reservadas']) > 0): ?>
                            <div class="row">
                                <?php foreach ($data['mesas_reservadas'] as $mesa): ?>
                                    <div class="col-md-3">
                                        <div class="card mesa-card mesa-reservada">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    Mesa <?= $mesa->mesa_numero ?>
                                                    <span class="badge badge-info status-badge status-reservada">Reservada</span>
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <?php if (isset($mesa->reserva_info) && $mesa->reserva_info): ?>
                                                    <div class="reservation-info">
                                                        <p class="card-text">
                                                            <strong><i class="fa fa-user"></i> Cliente:</strong> <?= $mesa->reserva_info->cliente_nome ?><br>
                                                            <?php if ($mesa->reserva_info->cliente_telefone): ?>
                                                                <strong><i class="fa fa-phone"></i> Telefone:</strong> 
                                                                <a href="tel:<?= $mesa->reserva_info->cliente_telefone ?>"><?= $mesa->reserva_info->cliente_telefone ?></a><br>
                                                            <?php endif; ?>
                                                            <strong><i class="fa fa-users"></i> Pessoas:</strong> <?= $mesa->reserva_info->numero_pessoas ?><br>
                                                            <strong><i class="fa fa-clock-o"></i> Horário:</strong> <?= date('H:i', strtotime($mesa->reserva_info->hora_inicio)) ?><br>
                                                            <strong><i class="fa fa-map-marker"></i> Local:</strong> <?= $mesa->mesa_localizacao ?: 'N/I' ?>
                                                        </p>
                                                        
                                                        <div class="alert alert-info alert-sm mb-2">
                                                            <i class="fa fa-info-circle"></i> <strong>Aguardando chegada do cliente</strong>
                                                        </div>
                                                        
                                                        <div class="btn-group btn-group-sm d-flex" role="group">
                                                            <button type="button" class="btn btn-success btn-sm" 
                                                                    onclick="confirmarReserva(<?= $mesa->reserva_info->reserva_id ?>)"
                                                                    title="Confirmar chegada do cliente">
                                                                <i class="fa fa-check"></i> Confirmar Chegada
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm" 
                                                                    onclick="cancelarReserva(<?= $mesa->reserva_info->reserva_id ?>)"
                                                                    title="Cancelar reserva">
                                                                <i class="fa fa-times"></i> Cancelar
                                                            </button>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <!-- Fallback when reservation info is not available -->
                                                    <div class="no-reservation-info">
                                                        <p class="card-text">
                                                            <strong><i class="fa fa-bookmark"></i> Mesa Reservada</strong><br>
                                                            <strong>Capacidade:</strong> <?= $mesa->mesa_capacidade ?> pessoas<br>
                                                            <strong>Local:</strong> <?= $mesa->mesa_localizacao ?: 'N/I' ?>
                                                        </p>
                                                        
                                                        <div class="alert alert-warning alert-sm mb-2">
                                                            <i class="fa fa-exclamation-triangle"></i> <small>Informações da reserva não disponíveis</small>
                                                        </div>
                                                        
                                                        <button type="button" class="btn btn-info btn-sm btn-block" disabled>
                                                            <i class="fa fa-bookmark"></i> Mesa Reservada
                                                        </button>
                                                        
                                                        <!-- Debug button - can be removed in production -->
                                                        <button type="button" class="btn btn-default btn-xs mt-2" 
                                                                onclick="debugReservation(<?= $mesa->mesa_id ?>)"
                                                                title="Debug: Verificar informações da reserva">
                                                            <i class="fa fa-bug"></i> Debug
                                                        </button>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fa fa-bookmark fa-3x text-info"></i>
                                <h4>Nenhuma mesa reservada</h4>
                                <p class="text-muted">Não há mesas reservadas no momento.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mesas em Manutenção -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fa fa-wrench"></i> Mesas em Manutenção
                            <span class="badge badge-secondary"><?= count($data['mesas_manutencao'] ?? []) ?></span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php if (isset($data['mesas_manutencao']) && $data['mesas_manutencao'] && count($data['mesas_manutencao']) > 0): ?>
                            <div class="row">
                                <?php foreach ($data['mesas_manutencao'] as $mesa): ?>
                                    <div class="col-md-3">
                                        <div class="card mesa-card mesa-manutencao">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    Mesa <?= $mesa->mesa_numero ?>
                                                    <span class="badge badge-secondary status-badge status-manutencao">Manutenção</span>
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text">
                                                    <strong>Capacidade:</strong> <?= $mesa->mesa_capacidade ?> pessoas<br>
                                                    <strong>Local:</strong> <?= $mesa->mesa_localizacao ?: 'N/I' ?>
                                                </p>
                                                
                                                <button type="button" class="btn btn-secondary btn-sm btn-block" disabled>
                                                    <i class="fa fa-wrench"></i> Em Manutenção
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4">
                                <i class="fa fa-wrench fa-3x text-muted"></i>
                                <h4>Nenhuma mesa em manutenção</h4>
                                <p class="text-muted">Todas as mesas estão disponíveis para uso.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Ocupar Mesa -->
    <div class="modal fade" id="modalOcuparMesa" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-user-plus"></i> Ocupar Mesa <span id="mesa-numero"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-ocupar-mesa">
                    <div class="modal-body">
                        <input type="hidden" id="mesa-id" name="mesa_id">
                        
                        <div class="form-group">
                            <label for="cliente-nome">Nome do Cliente (opcional)</label>
                            <input type="text" class="form-control" id="cliente-nome" name="cliente_nome" 
                                   placeholder="Digite o nome do cliente (opcional)">
                        </div>
                        
                        <div class="form-group">
                            <label for="observacao">Observações (opcional)</label>
                            <textarea class="form-control" id="observacao" name="observacao" rows="3" 
                                      placeholder="Observações sobre a ocupação"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fa fa-times"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-check"></i> Ocupar Mesa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Liberar Mesa -->
    <div class="modal fade" id="modalLiberarMesa" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa fa-sign-out"></i> Liberar Mesa <span id="liberar-mesa-numero"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja liberar esta mesa?</p>
                    <p><strong>Atenção:</strong> Esta ação não pode ser desfeita.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-warning" id="btn-confirmar-liberar">
                        <i class="fa fa-check"></i> Confirmar Liberação
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= $baseUri ?>/assets/vendor/jquery/jquery-2.1.4.min.js"></script>
    <script src="<?= $baseUri ?>/assets/vendor/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script>
        let mesaIdParaLiberar = null;
        let ocupacaoIdParaLiberar = null;
        let reservaIdParaConfirmar = null;
        let reservaIdParaCancelar = null;

        function ocuparMesa(mesaId) {
            // Find table capacity from the floor plan or available tables
            const tableSlot = $(`[data-mesa-id="${mesaId}"]`);
            let capacidade = 4; // default
            
            // Try to get capacity from available tables section
            const availableTableCard = $(`.mesa-livre [onclick*="${mesaId}"]`).closest('.card');
            if (availableTableCard.length > 0) {
                const capacidadeText = availableTableCard.find('.card-text').text();
                const match = capacidadeText.match(/Capacidade:\s*(\d+)/);
                if (match) {
                    capacidade = parseInt(match[1]);
                }
            }
            
            $('#mesa-id').val(mesaId);
            $('#mesa-numero').text(mesaId);
            
            // Add hidden field for table capacity
            if ($('#mesa-capacidade').length === 0) {
                $('#mesa-id').after('<input type="hidden" id="mesa-capacidade" name="numero_pessoas">');
            }
            $('#mesa-capacidade').val(capacidade);
            
            $('#modalOcuparMesa').modal('show');
        }

        function liberarMesa(mesaId, ocupacaoId) {
            mesaIdParaLiberar = mesaId;
            ocupacaoIdParaLiberar = ocupacaoId;
            $('#liberar-mesa-numero').text(mesaId);
            $('#modalLiberarMesa').modal('show');
        }

        function confirmarReserva(reservaId) {
            
            if (confirm('Tem certeza que deseja confirmar a chegada desta reserva? A mesa será ocupada pelo garçom.')) {
                // Disable button to prevent double clicks
                const btn = $(`button[onclick*="confirmarReserva(${reservaId})"]`);
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Confirmando...');
                
                $.ajax({
                    url: '<?= $baseUri ?>/garcon/confirmar-reserva/',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        reserva_id: reservaId
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showAlert('Reserva confirmada! Mesa ocupada com sucesso. Cliente pode ser atendido.', 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            showAlert(response.message || 'Erro ao confirmar reserva', 'danger');
                            btn.prop('disabled', false).html('<i class="fa fa-check"></i> Confirmar Chegada');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('[' + new Date().toLocaleString() + '] AJAX Error:', {
                            status: status,
                            error: error,
                            responseText: xhr.responseText,
                            statusCode: xhr.status
                        });
                        
                        let errorMessage = 'Erro de conexão. ';
                        if (xhr.status === 404) {
                            errorMessage = 'Endpoint não encontrado. Verifique as rotas.';
                        } else if (xhr.status === 500) {
                            errorMessage = 'Erro interno do servidor. Verifique os logs.';
                        } else if (xhr.responseText) {
                            try {
                                const errorData = JSON.parse(xhr.responseText);
                                errorMessage = errorData.message || errorMessage;
                            } catch (e) {
                                errorMessage += 'Resposta inválida do servidor.';
                            }
                        }
                        
                        showAlert(errorMessage + ' (Código: ' + xhr.status + ')', 'danger');
                        btn.prop('disabled', false).html('<i class="fa fa-check"></i> Confirmar Chegada');
                    }
                });
            }
        }
        
        function debugReserva(mesaId) {
            
            $.ajax({
                url: '<?= $baseUri ?>/garcon/debug-reservas/',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    
                    let message = 'Debug da Mesa ' + mesaId + ':\n';
                    message += 'Tabela mesa_reservas existe: ' + (response.table_exists ? 'Sim' : 'Não') + '\n';
                    message += 'Total de reservas ativas: ' + response.reservas_count + '\n';
                    
                    if (response.reservas && response.reservas.length > 0) {
                        message += '\nReservas encontradas:\n';
                        response.reservas.forEach(function(reserva, index) {
                            message += (index + 1) + '. Mesa ' + reserva.mesa_numero + 
                                     ' - Cliente: ' + reserva.cliente_nome + 
                                     ' - Tel: ' + (reserva.cliente_telefone || 'N/A') + '\n';
                        });
                    } else {
                        message += '\nNenhuma reserva ativa encontrada.';
                    }
                    
                    alert(message);
                },
                error: function(xhr, status, error) {
                    console.error('[' + new Date().toLocaleString() + '] Debug error:', xhr.responseText, status, error);
                    alert('Erro ao executar debug: ' + error);
                }
            });
        }

        function cancelarReserva(reservaId) {
            const motivo = prompt('Motivo do cancelamento (opcional):');
            if (motivo !== null) { // User didn't click cancel
                $.ajax({
                    url: '<?= $baseUri ?>/garcon/cancelar-reserva/',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        reserva_id: reservaId,
                        motivo: motivo
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showAlert(response.message, 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            showAlert(response.message, 'danger');
                        }
                    },
                    error: function() {
                        showAlert('Erro de conexão. Tente novamente.', 'danger');
                    }
                });
            }
        }

        $(document).ready(function() {
            // Form de ocupar mesa
            $('#form-ocupar-mesa').on('submit', function(e) {
                e.preventDefault();
                
                const btn = $(this).find('button[type="submit"]');
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Ocupando...');
                
                $.ajax({
                    url: '<?= $baseUri ?>/garcon/ocupar-mesa/',
                    type: 'POST',
                    dataType: 'json',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#modalOcuparMesa').modal('hide');
                            showAlert(response.message, 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            showAlert(response.message, 'danger');
                        }
                    },
                    error: function() {
                        showAlert('Erro de conexão. Tente novamente.', 'danger');
                    },
                    complete: function() {
                        btn.prop('disabled', false).html('<i class="fa fa-check"></i> Ocupar Mesa');
                    }
                });
            });

            // Confirmar liberação da mesa
            $('#btn-confirmar-liberar').on('click', function() {
                const btn = $(this);
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Liberando...');
                
                $.ajax({
                    url: '<?= $baseUri ?>/garcon/liberar-mesa/',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        mesa_id: mesaIdParaLiberar,
                        ocupacao_id: ocupacaoIdParaLiberar
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#modalLiberarMesa').modal('hide');
                            showAlert(response.message, 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            showAlert(response.message, 'danger');
                        }
                    },
                    error: function() {
                        showAlert('Erro de conexão. Tente novamente.', 'danger');
                    },
                    complete: function() {
                        btn.prop('disabled', false).html('<i class="fa fa-check"></i> Confirmar Liberação');
                    }
                });
            });

            // Auto-refresh every 30 seconds
            setInterval(function() {
                location.reload();
            }, 30000);
            
            // Initialize notification system
            if (typeof garconModel !== 'undefined' && <?= garconModel::esta_logado() ? 'true' : 'false' ?>) {
                startNotificationMonitoring();
            }
            
            // Clear ready indicators when clicking "Ver Pedidos"
            $(document).on('click', 'a[href*="pedidos-mesa"], .btn[onclick*="pedidos"]', function() {
                clearTableReadyIndicators();
                resetNotificationCounter();
            });
            
            // Floor plan interactions
            $('.table-slot.available').hover(
                function() {
                    $(this).find('.table-status').text('Clique para ocupar');
                },
                function() {
                    $(this).find('.table-status').text('Livre');
                }
            );
            
            $('.table-slot.occupied').hover(
                function() {
                    $(this).find('.table-status').text('Em uso');
                },
                function() {
                    $(this).find('.table-status').text('Ocupada');
                }
            );
            
            $('.table-slot.reserved').hover(
                function() {
                    $(this).find('.table-status').text('Não disponível');
                },
                function() {
                    $(this).find('.table-status').text('Reservada');
                }
            );
            
            $('.table-slot.maintenance').hover(
                function() {
                    $(this).find('.table-status').text('Fora de uso');
                },
                function() {
                    $(this).find('.table-status').text('Manutenção');
                }
            );
        });

        function showAlert(message, type) {
            const alertHtml = `
                <div class="alert alert-${type}" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="fa fa-${type === 'success' ? 'check' : 'exclamation-triangle'}"></i> ${message}
                </div>
            `;
            
            // Remove existing alerts
            $('.alert').remove();
            
            // Add new alert at the top of container
            $('.container').prepend(alertHtml);
            
            // Auto-hide after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000);
        }
    </script>

    <!-- Notification Counter -->
    <div id="notificationCounter" class="notification-counter">
        <span id="counterText">0</span>
    </div>
    
    <!-- Hidden audio element for notification sound -->
    <audio id="notificationSound" preload="auto">
        <source src="<?= $baseUri ?>/midias/alerta/alert_garcon.mp3" type="audio/mpeg">
        <source src="<?= $baseUri ?>/midias/alerta/alert.mp3" type="audio/mpeg">
    </audio>
    
    <script>
        // Notification System Variables (same as dashboard)
        let lastNotificationCheck = Date.now();
        let notificationCount = 0;
        let knownReadyOrders = new Set();
        let isWaiterLoggedIn = <?= garconModel::esta_logado() ? 'true' : 'false' ?>;
        let waiterId = <?= garconModel::get_id() ?>;
        let lastCheckedOrderId = 0;
        let audioContext = null;
        let isAudioUnlocked = false;
        let preloadedAudio = null;
        let currentPlayingAudio = null;

        // Initialize notification system
        $(document).ready(function() {
            if (isWaiterLoggedIn) {
                
                // Setup audio unlock strategy
                setupAudioUnlock();
                
                startNotificationMonitoring();
            }
        });
        
        // Setup multiple strategies to unlock audio (same as dashboard)
        function setupAudioUnlock() {
            
            const htmlAudio = document.getElementById('notificationSound');
            if (htmlAudio) {
                htmlAudio.volume = 1.0;
                htmlAudio.muted = false;
            }
            
            const unlockAudio = function() {
                
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
                        console.log('[MESAS NOTIFICATION] Audio() creation failed:', e);
                    }
                }
                
                if (isAudioUnlocked) {
                    document.removeEventListener('click', unlockAudio);
                    document.removeEventListener('keydown', unlockAudio);
                    document.removeEventListener('touchstart', unlockAudio);
                    document.removeEventListener('mousemove', unlockAudio);
                }
            };
            
            document.addEventListener('click', unlockAudio, { passive: true });
            document.addEventListener('keydown', unlockAudio, { passive: true });
            document.addEventListener('touchstart', unlockAudio, { passive: true });
            document.addEventListener('mousemove', unlockAudio, { passive: true, once: true });
            
            setTimeout(() => {
                if (!isAudioUnlocked) {
                    unlockAudio();
                }
            }, 1000);
        }

        // Start monitoring for ready orders
        function startNotificationMonitoring() {
            
            checkForReadyOrdersMainJS();
            
            setInterval(function() {
                checkForReadyOrdersMainJS();
            }, 1000 * 3);
        }

        // Check for ready orders (same as dashboard)
        function checkForReadyOrdersMainJS() {
            var url = '<?= $baseUri ?>/garcon/check-ready-orders/?waiter_id=' + waiterId + '&last_check=0';
            
            $.getJSON(url).done(function(response) {
                if (response && response.status === 'success') {
                    if (response.ready_orders && response.ready_orders.length > 0) {
                        const order = response.ready_orders[0];
                        
                        window.currentOrderData = order;
                        
                        playAutomaticNotificationSound();
                        
                        animateTableForOrder(order.mesa_numero);
                        
                        updateNotificationCounter();
                    }
                }
            }).fail(function(xhr, status, error) {
                // Error handling without logging
            });
        }

        // Play notification sound automatically (same as dashboard)
        function playAutomaticNotificationSound() {
            stopCurrentAudio();
            
            showStopAudioButton();
            
            if (isAudioUnlocked && preloadedAudio) {
                try {
                    preloadedAudio.currentTime = 0;
                    preloadedAudio.loop = true;
                    preloadedAudio.volume = 1.0;
                    
                    const promise = preloadedAudio.play();
                    if (promise) {
                        promise.then(() => {
                            currentPlayingAudio = preloadedAudio;
                            return;
                        }).catch((error) => {
                            // Error handling without logging
                        });
                    }
                } catch (error) {
                    // Error handling without logging
                }
            }
            
            const htmlAudio = document.getElementById('notificationSound');
            if (htmlAudio && !currentPlayingAudio) {
                try {
                    htmlAudio.currentTime = 0;
                    htmlAudio.volume = 1.0;
                    htmlAudio.loop = true;
                    
                    const promise = htmlAudio.play();
                    if (promise) {
                        promise.then(() => {
                            currentPlayingAudio = htmlAudio;
                            return;
                        }).catch((error) => {
                            // Error handling without logging
                        });
                    }
                } catch (error) {
                    // Error handling without logging
                }
            }
            
            if (!currentPlayingAudio) {
                try {
                    const freshAudio = new Audio('<?= $baseUri ?>/midias/alerta/alert_garcon.mp3');
                    freshAudio.volume = 1.0;
                    freshAudio.loop = true;
                    
                    const promise = freshAudio.play();
                    if (promise) {
                        promise.then(() => {
                            currentPlayingAudio = freshAudio;
                        }).catch((error) => {
                            // Error handling without logging
                        });
                    }
                } catch (error) {
                    // Error handling without logging
                }
            }
        }
        
        // Stop current audio - SUPER AGRESSIVA
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
        
        // Show central alert button (same as dashboard)
        function showStopAudioButton() {
            const existingButton = document.getElementById('stopAudioButton');
            if (existingButton) {
                existingButton.remove();
            }
            
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
        
        // Hide central alert button
        function hideStopAudioButton() {
            const stopButton = document.getElementById('stopAudioButton');
            if (stopButton) {
                stopButton.remove();
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

        // Animate table when order is ready
        function animateTableForOrder(mesaNumero) {
            const tableSlots = document.querySelectorAll('.table-slot');
            let targetTable = null;
            
            tableSlots.forEach(function(slot) {
                const tableNumber = slot.querySelector('.table-number');
                if (tableNumber && tableNumber.textContent.trim() === mesaNumero.toString()) {
                    targetTable = slot;
                }
            });
            
            if (targetTable) {
                
                targetTable.classList.add('shake', 'has-ready-order');
                
                setTimeout(function() {
                    targetTable.classList.remove('shake');
                }, 10000);
            } else {
                console.warn('[MESAS NOTIFICATION] Table not found for mesa', mesaNumero);
            }
        }

        // Clear ready order indicators when viewing orders
        function clearTableReadyIndicators() {
            const tablesWithIndicators = document.querySelectorAll('.table-slot.has-ready-order');
            tablesWithIndicators.forEach(function(table) {
                table.classList.remove('has-ready-order', 'shake');
            });
        }
        
        // Add click handler to reset counter when visiting orders
        $(document).on('click', 'a[href*="pedidos-mesa"]', function() {
            clearTableReadyIndicators();
            resetNotificationCounter();
        });
        
        // Auto refresh every 2 minutes
        setInterval(function() {
            location.reload();
        }, 120000);
    </script>
</body>
</html>