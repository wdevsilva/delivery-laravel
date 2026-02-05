<?php include "view/admin/side-menu.php"; ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-cutlery"></i> Cozinha - Módulo Principal
            <small>Central de Controle da Cozinha</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/admin/"><i class="fa fa-dashboard"></i> Início</a></li>
            <li class="active">Cozinha</li>
        </ol>
    </section>

    <section class="content">
        <!-- Welcome Box -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-info-circle"></i> Bem-vindo ao Módulo da Cozinha</h3>
                    </div>
                    <div class="box-body">
                        <p class="lead">Este módulo centraliza todas as operações da cozinha do restaurante.</p>
                        <p>
                            Aqui você pode gerenciar pedidos, acompanhar o status de preparação, 
                            visualizar estatísticas em tempo real e controlar todo o fluxo de trabalho da cozinha.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access Cards -->
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h4>Dashboard</h4>
                        <p>Visão geral dos pedidos ativos</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-dashboard"></i>
                    </div>
                    <a href="<?= $baseUri ?>/admin/cozinha/display/" class="small-box-footer">
                        Acessar Dashboard <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h4>Display Full Screen</h4>
                        <p>Tela dedicada para a cozinha</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-tv"></i>
                    </div>
                    <a href="<?= $baseUri ?>/admin/cozinha/display/" target="_blank" class="small-box-footer">
                        Abrir Display <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h4>Estatísticas</h4>
                        <p>Relatórios e métricas</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-bar-chart"></i>
                    </div>
                    <a href="#" onclick="carregarEstatisticas()" class="small-box-footer">
                        Ver Estatísticas <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Current Status Overview -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-clock-o"></i> Status Atual</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" onclick="atualizarStatus()">
                                <i class="fa fa-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row text-center" id="status-overview">
                            <div class="col-md-3">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-yellow">
                                        <i class="fa fa-clock-o"></i>
                                    </span>
                                    <h5 class="description-header" id="status-aguardando">-</h5>
                                    <span class="description-text">AGUARDANDO PREPARO</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-orange">
                                        <i class="fa fa-fire"></i>
                                    </span>
                                    <h5 class="description-header" id="status-preparo">-</h5>
                                    <span class="description-text">EM PREPARO</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-green">
                                        <i class="fa fa-check"></i>
                                    </span>
                                    <h5 class="description-header" id="status-pronto">-</h5>
                                    <span class="description-text">PRONTOS</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="description-block">
                                    <span class="description-percentage text-blue">
                                        <i class="fa fa-list"></i>
                                    </span>
                                    <h5 class="description-header" id="status-total">-</h5>
                                    <span class="description-text">TOTAL DO DIA</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-bolt"></i> Ações Rápidas</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-3">
                                <button class="btn btn-block btn-warning" onclick="buscarNovosPedidos()">
                                    <i class="fa fa-refresh"></i><br>
                                    Atualizar Pedidos
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-block btn-success" onclick="marcarTodosProntos()">
                                    <i class="fa fa-check-circle"></i><br>
                                    Marcar Todos Prontos
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-block btn-info" onclick="abrirDisplayFullScreen()">
                                    <i class="fa fa-tv"></i><br>
                                    Display Full Screen
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-block btn-primary" onclick="gerarRelatorioDia()">
                                    <i class="fa fa-file-text"></i><br>
                                    Relatório do Dia
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders Preview -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-list"></i> Últimos Pedidos</h3>
                        <div class="box-tools pull-right">
                            <a href="<?= $baseUri ?>/admin/cozinha/display/" class="btn btn-primary btn-sm">
                                <i class="fa fa-eye"></i> Ver Todos
                            </a>
                        </div>
                    </div>
                    <div class="box-body" id="recent-orders">
                        <div class="text-center">
                            <i class="fa fa-spinner fa-spin"></i> Carregando pedidos...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    atualizarStatus();
    carregarPedidosRecentes();
    
    // Auto refresh a cada 60 segundos
    setInterval(function() {
        atualizarStatus();
        carregarPedidosRecentes();
    }, 60000);
});

function atualizarStatus() {
    $.ajax({
        url: '<?= $baseUri ?>/admin/cozinha/estatisticas/',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            $('#status-aguardando').text(response.pedidos_pendentes || 0);
            $('#status-preparo').text(response.pedidos_preparo || 0);
            $('#status-pronto').text(response.pedidos_prontos || 0);
            $('#status-total').text(response.pedidos_hoje || 0);
        },
        error: function() {
            console.log('Erro ao carregar estatísticas');
        }
    });
}

function carregarPedidosRecentes() {
    $.ajax({
        url: '<?= $baseUri ?>/admin/cozinha/get-novos-pedidos/',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            let html = '';
            if (response && response.length > 0) {
                html += '<div class="table-responsive">';
                html += '<table class="table table-striped">';
                html += '<thead><tr><th>#</th><th>Cliente</th><th>Tipo</th><th>Status</th><th>Horário</th><th>Total</th></tr></thead>';
                html += '<tbody>';
                
                response.slice(0, 5).forEach(function(pedido) {
                    html += '<tr>';
                    html += '<td><strong>#' + String(pedido.pedido_numero_entrega).padStart(3, '0') + '</strong></td>';
                    html += '<td>' + pedido.cliente_nome + '</td>';
                    html += '<td>' + getTypeLabel(pedido.pedido_tipo) + '</td>';
                    html += '<td>' + getStatusBadge(pedido.pedido_status) + '</td>';
                    html += '<td>' + new Date(pedido.pedido_data).toLocaleTimeString() + '</td>';
                    html += '<td>R$ ' + parseFloat(pedido.pedido_total).toFixed(2).replace('.', ',') + '</td>';
                    html += '</tr>';
                });
                
                html += '</tbody></table></div>';
            } else {
                html = '<div class="callout callout-success"><h4><i class="fa fa-check"></i> Tudo em dia!</h4><p>Nenhum pedido pendente no momento.</p></div>';
            }
            
            $('#recent-orders').html(html);
        },
        error: function() {
            $('#recent-orders').html('<div class="alert alert-danger">Erro ao carregar pedidos.</div>');
        }
    });
}

function getTypeLabel(tipo) {
    switch(parseInt(tipo)) {
        case 1: return '<span class="label label-primary">Delivery</span>';
        case 2: return '<span class="label label-info">Balcão</span>';
        case 3: return '<span class="label label-warning">Mesa</span>';
        default: return '<span class="label label-default">Outros</span>';
    }
}

function getStatusBadge(status) {
    switch(parseInt(status)) {
        case 1: return '<span class="badge bg-yellow">Aguardando</span>';
        case 2: return '<span class="badge bg-orange">Em Preparo</span>';
        case 3: return '<span class="badge bg-blue">Saiu p/ Entrega</span>';
        case 6: return '<span class="badge bg-green">Pronto</span>';
        default: return '<span class="badge bg-gray">N/A</span>';
    }
}

function buscarNovosPedidos() {
    toastr.info('Atualizando pedidos...');
    carregarPedidosRecentes();
    atualizarStatus();
}

function marcarTodosProntos() {
    if (confirm('Tem certeza que deseja marcar TODOS os pedidos em preparo como prontos?')) {
        // Implementar lógica para marcar todos como prontos
        toastr.info('Funcionalidade em desenvolvimento...');
    }
}

function abrirDisplayFullScreen() {
    window.open('<?= $baseUri ?>/admin/cozinha/display/', '_blank');
}

function gerarRelatorioDia() {
    toastr.info('Gerando relatório do dia...');
    carregarEstatisticas();
}

function carregarEstatisticas() {
    $.ajax({
        url: '<?= $baseUri ?>/admin/cozinha/estatisticas/',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            let message = 'Estatísticas do dia:\n';
            message += '• Total de pedidos: ' + (response.pedidos_hoje || 0) + '\n';
            message += '• Aguardando: ' + (response.pedidos_pendentes || 0) + '\n';
            message += '• Em preparo: ' + (response.pedidos_preparo || 0) + '\n';
            message += '• Prontos: ' + (response.pedidos_prontos || 0);
            
            toastr.info(message);
        },
        error: function() {
            toastr.error('Erro ao carregar estatísticas.');
        }
    });
}
</script>

<?php include "view/admin/footer.php"; ?>