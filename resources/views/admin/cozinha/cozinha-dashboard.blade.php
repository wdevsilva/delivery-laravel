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
}
?>
<?php include "view/admin/side-menu.php"; ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-cutlery"></i> Cozinha - Dashboard
            <small>Gerenciamento de Pedidos da Cozinha</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/"><i class="fa fa-dashboard"></i> Início</a></li>
            <li class="active">Cozinha</li>
        </ol>
    </section>

    <section class="content">
        <!-- Estatísticas Rápidas -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3 id="stat-aguardando"><?= count(array_filter($pedidos ?: [], function($p) { return $p->pedido_status == 1; })) ?></h3>
                        <p>Aguardando Preparo</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-clock-o"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-orange">
                    <div class="inner">
                        <h3 id="stat-preparo"><?= count(array_filter($pedidos ?: [], function($p) { return $p->pedido_status == 2; })) ?></h3>
                        <p>Em Preparo</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-fire"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 id="stat-pronto"><?= count(array_filter($pedidos ?: [], function($p) { return $p->pedido_status == 6; })) ?></h3>
                        <p>Prontos</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3 id="stat-total"><?= count($pedidos ?: []) ?></h3>
                        <p>Total do Dia</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-list"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações Rápidas -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-cogs"></i> Ações Rápidas</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" onclick="location.reload()">
                                <i class="fa fa-refresh"></i> Atualizar
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <a href="<?= $baseUri ?>/admin/cozinha/display/" class="btn btn-app" target="_blank">
                                    <i class="fa fa-tv"></i> Display Full Screen
                                </a>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-app" onclick="atualizarTodos()">
                                    <i class="fa fa-refresh"></i> Atualizar Pedidos
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-app" onclick="carregarEstatisticas()">
                                    <i class="fa fa-bar-chart"></i> Estatísticas
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-app" onclick="marcarTodosProntos()">
                                    <i class="fa fa-check-circle"></i> Marcar Todos Prontos
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Pedidos -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-list"></i> Pedidos Ativos</h3>
                        <div class="box-tools pull-right">
                            <span class="badge bg-green" id="badge-total"><?= count($pedidos ?: []) ?></span>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row" id="pedidos-container">
                            <?php if ($pedidos && count($pedidos) > 0): ?>
                                <?php foreach ($pedidos as $pedido): ?>
                                    <div class="col-md-6" data-pedido="<?= $pedido->pedido_id ?>">
                                        <div class="box box-widget widget-user-2">
                                            <div class="widget-user-header <?= getStatusColor($pedido->pedido_status) ?>">
                                                <div class="widget-user-image">
                                                    <span class="label <?= getStatusLabelColor($pedido->pedido_status) ?>">
                                                        #<?= str_pad($pedido->pedido_numero_entrega, 3, '0', STR_PAD_LEFT) ?>
                                                    </span>
                                                </div>
                                                <h3 class="widget-user-username"><?= $pedido->nome_cliente ?></h3>
                                                <h5 class="widget-user-desc">
                                                    <?= $pedido->tipo_pedido_nome ?> - <?= getStatusNome($pedido->pedido_status) ?>
                                                </h5>
                                            </div>
                                            <div class="box-footer no-padding">
                                                <ul class="nav nav-stacked">
                                                    <li><a href="#">Horário <span class="pull-right"><?= date('H:i', strtotime($pedido->pedido_data)) ?></span></a></li>
                                                    <li><a href="#">Total <span class="pull-right text-green">R$ <?= number_format($pedido->pedido_total, 2, ',', '.') ?></span></a></li>
                                                    <?php if ($pedido->mesa_numero): ?>
                                                        <li><a href="#">Mesa <span class="pull-right"><?= $pedido->mesa_numero ?></span></a></li>
                                                        <li><a href="#">Garçon <span class="pull-right"><?= $pedido->garcon_nome ?></span></a></li>
                                                    <?php endif; ?>
                                                    <li><a href="#">Tempo <span class="pull-right text-red"><?= getTempoDecorrido($pedido->pedido_data) ?></span></a></li>
                                                </ul>
                                                <div class="box-footer">
                                                    <?php if ($pedido->pedido_status == 1): ?>
                                                        <button class="btn btn-warning btn-xs" onclick="iniciarPreparo(<?= $pedido->pedido_id ?>)">
                                                            <i class="fa fa-play"></i> Iniciar Preparo
                                                        </button>
                                                    <?php elseif ($pedido->pedido_status == 2): ?>
                                                        <button class="btn btn-success btn-xs" onclick="marcarPronto(<?= $pedido->pedido_id ?>)">
                                                            <i class="fa fa-check"></i> Marcar Pronto
                                                        </button>
                                                    <?php endif; ?>
                                                    <button class="btn btn-info btn-xs" onclick="verDetalhes(<?= $pedido->pedido_id ?>)">
                                                        <i class="fa fa-eye"></i> Detalhes
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-md-12">
                                    <div class="callout callout-success">
                                        <h4><i class="fa fa-check"></i> Nenhum pedido pendente!</h4>
                                        <p>Todos os pedidos foram processados com sucesso.</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Detalhes do Pedido -->
<div class="modal fade" id="modal-detalhes">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-list"></i> Detalhes do Pedido</h4>
            </div>
            <div class="modal-body" id="modal-detalhes-body">
                <div class="text-center">
                    <i class="fa fa-spinner fa-spin fa-2x"></i>
                    <p>Carregando detalhes...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
function iniciarPreparo(pedidoId) {
    if (confirm('Iniciar preparo do pedido?')) {
        $.ajax({
            url: '<?= $baseUri ?>/admin/cozinha/iniciar-preparo/',
            type: 'POST',
            dataType: 'json',
            data: { pedido_id: pedidoId },
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success('Preparo iniciado com sucesso!');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error('Erro: ' + response.message);
                }
            },
            error: function() {
                toastr.error('Erro de conexão.');
            }
        });
    }
}

function marcarPronto(pedidoId) {
    if (confirm('Marcar pedido como pronto?')) {
        $.ajax({
            url: '<?= $baseUri ?>/admin/cozinha/marcar-pronto/',
            type: 'POST',
            dataType: 'json',
            data: { pedido_id: pedidoId },
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success('Pedido marcado como pronto!');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    toastr.error('Erro: ' + response.message);
                }
            },
            error: function() {
                toastr.error('Erro de conexão.');
            }
        });
    }
}

function verDetalhes(pedidoId) {
    $('#modal-detalhes').modal('show');
    $('#modal-detalhes-body').html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p>Carregando detalhes...</p></div>');
    
    $.ajax({
        url: '<?= $baseUri ?>/admin/cozinha/detalhes-pedido/',
        type: 'GET',
        dataType: 'json',
        data: { pedido_id: pedidoId },
        success: function(response) {
            if (response.pedido && response.itens) {
                let html = '<div class="row">';
                html += '<div class="col-md-6">';
                html += '<h4>Informações do Pedido</h4>';
                html += '<table class="table table-bordered">';
                html += '<tr><td><strong>Número:</strong></td><td>#' + response.pedido.pedido_numero_entrega + '</td></tr>';
                html += '<tr><td><strong>Cliente:</strong></td><td>' + response.pedido.nome_cliente + '</td></tr>';
                html += '<tr><td><strong>Data/Hora:</strong></td><td>' + response.pedido.pedido_data + '</td></tr>';
                html += '<tr><td><strong>Total:</strong></td><td>R$ ' + parseFloat(response.pedido.pedido_total).toFixed(2).replace('.', ',') + '</td></tr>';
                html += '</table>';
                html += '</div>';
                
                html += '<div class="col-md-6">';
                html += '<h4>Itens do Pedido</h4>';
                html += '<table class="table table-striped">';
                html += '<thead><tr><th>Qtd</th><th>Item</th><th>Valor</th></tr></thead>';
                html += '<tbody>';
                response.itens.forEach(function(item) {
                    html += '<tr>';
                    html += '<td><span class="badge bg-blue">' + item.lista_qtde + '</span></td>';
                    html += '<td>' + item.lista_item_nome;
                    if (item.lista_item_obs) {
                        html += '<br><small class="text-red">(' + item.lista_item_obs + ')</small>';
                    }
                    html += '</td>';
                    html += '<td>R$ ' + parseFloat(item.lista_opcao_preco).toFixed(2).replace('.', ',') + '</td>';
                    html += '</tr>';
                });
                html += '</tbody></table>';
                html += '</div>';
                html += '</div>';
                
                if (response.pedido.pedido_obs) {
                    html += '<div class="row"><div class="col-md-12">';
                    html += '<h4>Observações</h4>';
                    html += '<div class="callout callout-info">' + response.pedido.pedido_obs.replace(/\n/g, '<br>') + '</div>';
                    html += '</div></div>';
                }
                
                $('#modal-detalhes-body').html(html);
            } else {
                $('#modal-detalhes-body').html('<div class="alert alert-danger">Erro ao carregar detalhes do pedido.</div>');
            }
        },
        error: function() {
            $('#modal-detalhes-body').html('<div class="alert alert-danger">Erro de conexão.</div>');
        }
    });
}

function atualizarTodos() {
    location.reload();
}

function carregarEstatisticas() {
    $.ajax({
        url: '<?= $baseUri ?>/admin/cozinha/estatisticas/',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.pedidos_hoje !== undefined) {
                toastr.info('Estatísticas do dia: ' + response.pedidos_hoje + ' pedidos processados');
            }
        },
        error: function() {
            toastr.error('Erro ao carregar estatísticas.');
        }
    });
}

function marcarTodosProntos() {
    if (confirm('Marcar TODOS os pedidos em preparo como prontos?')) {
        const pedidosEmPreparo = $('[data-pedido]').filter(function() {
            return $(this).find('.btn-success').length > 0;
        });
        
        if (pedidosEmPreparo.length === 0) {
            toastr.info('Nenhum pedido em preparo encontrado.');
            return;
        }
        
        let processados = 0;
        pedidosEmPreparo.each(function() {
            const pedidoId = $(this).data('pedido');
            $.ajax({
                url: '<?= $baseUri ?>/admin/cozinha/marcar-pronto/',
                type: 'POST',
                dataType: 'json',
                data: { pedido_id: pedidoId },
                success: function(response) {
                    processados++;
                    if (processados === pedidosEmPreparo.length) {
                        toastr.success('Todos os pedidos foram marcados como prontos!');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                }
            });
        });
    }
}

// Auto refresh a cada 30 segundos
setInterval(function() {
    location.reload();
}, 30000);
</script>

<?php
function getStatusColor($status) {
    switch($status) {
        case 1: return 'bg-yellow';
        case 2: return 'bg-orange';
        case 3: return 'bg-blue';
        case 6: return 'bg-green';
        default: return 'bg-gray';
    }
}

function getStatusLabelColor($status) {
    switch($status) {
        case 1: return 'label-warning';
        case 2: return 'label-danger';
        case 3: return 'label-primary';
        case 6: return 'label-success';
        default: return 'label-default';
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

<?php include "view/admin/footer.php"; ?>