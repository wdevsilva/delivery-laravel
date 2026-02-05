<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8" />
    <title>Avaliações - <?= $data['config']->config_nome ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />   
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.js"></script>
    
    <style>
        /* Cards de Estatísticas Modernos */
        .stats-card {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            border-radius: 12px;
            padding: 20px 15px;
            margin: 0;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border-left: 4px solid #007bff;
            text-align: center;
            height: 100%;
        }
        
        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        }
        
        .stats-card.total {
            border-left-color: #28a745;
        }
        
        .stats-card.rating {
            border-left-color: #ffc107;
        }
        
        .stats-card.nps {
            border-left-color: #17a2b8;
        }
        
        .stats-card.response {
            border-left-color: #6f42c1;
        }
        
        .stats-number {
            font-size: 32px;
            font-weight: 700;
            color: #2c3e50;
            margin: 8px 0;
            line-height: 1;
        }
        
        .stats-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        
        .stats-icon {
            font-size: 22px;
            opacity: 0.3;
            margin-bottom: 3px;
        }
        
        /* Tabs Modernizados */
        .nav-tabs > li > a {
            border-radius: 8px 8px 0 0 !important;
            font-weight: 600;
            font-size: 14px;
            padding: 12px 20px;
        }
        
        .nav-tabs > li.active > a {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
            color: white !important;
            border: none !important;
        }
        
        /* Tabelas Modernas */
        .table-modern {
            margin-top: 0 !important;
        }
        
        .table-modern thead th {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: none !important;
            color: #495057;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 15px 10px;
        }
        
        .table-modern tbody tr {
            transition: all 0.2s ease;
        }
        
        .table-modern tbody tr:hover {
            background: #f8f9fa;
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        
        /* Badges Modernos */
        .label {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 11px;
            letter-spacing: 0.3px;
        }
        
        /* Card de Cliente */
        .cliente-card {
            background: white;
            border-radius: 12px;
            padding: 0;
            margin-bottom: 20px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .cliente-card:hover {
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
            transform: translateY(-3px);
        }
        
        .cliente-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .cliente-header:hover {
            background: linear-gradient(135deg, #5568d3 0%, #653a8b 100%);
        }
        
        .cliente-info {
            flex: 1;
        }
        
        .cliente-nome {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .cliente-stats {
            font-size: 13px;
            opacity: 0.9;
        }
        
        .cliente-resumo {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        
        .resumo-item {
            text-align: center;
        }
        
        .resumo-numero {
            font-size: 24px;
            font-weight: 700;
            display: block;
        }
        
        .resumo-label {
            font-size: 11px;
            opacity: 0.8;
            text-transform: uppercase;
        }
        
        .cliente-body {
            padding: 20px;
            display: none;
            background: #f8f9fa;
        }
        
        .cliente-body.active {
            display: block;
        }
        
        .pedido-item {
            background: white;
            border-left: 4px solid #007bff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 12px;
            transition: all 0.2s ease;
        }
        
        .pedido-item:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transform: translateX(5px);
        }
        
        .pedido-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .pedido-numero {
            font-weight: 700;
            color: #2c3e50;
        }
        
        .pedido-data {
            color: #6c757d;
            font-size: 12px;
        }
        
        .pedido-notas {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
            margin: 10px 0;
        }
        
        .nota-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 10px;
            background: #f8f9fa;
            border-radius: 6px;
        }
        
        .nota-label {
            font-size: 12px;
            color: #6c757d;
        }
        
        .nota-valor {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .pedido-comentario {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 12px;
            border-radius: 6px;
            margin-top: 10px;
            font-style: italic;
            color: #856404;
        }
        
        .toggle-icon {
            transition: transform 0.3s ease;
        }
        
        .toggle-icon.active {
            transform: rotate(180deg);
        }
        
        /* Card de Comentário */
        .comment-card {
            background: white;
            border-left: 4px solid #007bff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
        }
        
        .comment-card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            transform: translateX(5px);
        }
        
        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .comment-author {
            font-weight: 700;
            color: #2c3e50;
            font-size: 15px;
        }
        
        .comment-rating {
            font-size: 18px;
        }
        
        .comment-text {
            color: #495057;
            line-height: 1.6;
            font-size: 14px;
            margin: 12px 0;
        }
        
        .comment-date {
            color: #6c757d;
            font-size: 12px;
            font-style: italic;
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
                        <h3>
                            <i class="fa fa-star"></i> Avaliações de Pedidos
                            <a href="#" id="btn-info-avaliacoes" style="margin-left: 10px; color: #17a2b8; font-size: 18px; text-decoration: none;" title="Como funciona?">
                                <i class="fa fa-info-circle"></i>
                            </a>
                        </h3>
                    </div>

                    <div class="content">
                        <!-- ESTATÍSTICAS MODERNAS -->
                        <div class="row-fluid" style="margin-bottom: 30px;">
                            <div class="span12">
                                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                                    <div style="flex: 1; min-width: 200px;">
                                        <div class="stats-card total">
                                            <div class="stats-icon"><i class="fa fa-check-circle"></i></div>
                                            <div class="stats-number" id="total-avaliacoes">-</div>
                                            <div class="stats-label">Total de Avaliações</div>
                                        </div>
                                    </div>
                                    <div style="flex: 1; min-width: 200px;">
                                        <div class="stats-card rating">
                                            <div class="stats-icon"><i class="fa fa-star"></i></div>
                                            <div class="stats-number" id="nota-media">-</div>
                                            <div class="stats-label">Nota Média</div>
                                        </div>
                                    </div>
                                    <div style="flex: 1; min-width: 200px;">
                                        <div class="stats-card nps">
                                            <div class="stats-icon"><i class="fa fa-line-chart"></i></div>
                                            <div class="stats-number" id="nps-score">-</div>
                                            <div class="stats-label">NPS Score</div>
                                        </div>
                                    </div>
                                    <div style="flex: 1; min-width: 200px;">
                                        <div class="stats-card response">
                                            <div class="stats-icon"><i class="fa fa-percentage"></i></div>
                                            <div class="stats-number" id="taxa-resposta">-</div>
                                            <div class="stats-label">Taxa de Resposta</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TABS -->
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="widget-box">
                                    <div class="widget-title">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a data-toggle="tab" href="#tab-agendadas">📅 Agendadas</a></li>
                                            <li><a data-toggle="tab" href="#tab-respostas">💬 Respostas</a></li>
                                            <li><a data-toggle="tab" href="#tab-comentarios">📝 Comentários</a></li>
                                            <li><a data-toggle="tab" href="#tab-por-cliente">👥 Por Cliente</a></li>
                                            <li><a data-toggle="tab" href="#tab-insights">📊 Insights</a></li>
                                            <li><a data-toggle="tab" href="#tab-alertas">🚨 Alertas</a></li>
                                        </ul>
                                    </div>
                                    <div class="widget-content tab-content">
                                        <!-- TAB AGENDADAS -->
                                        <div id="tab-agendadas" class="tab-pane active">
                                            <table class="table table-bordered table-striped table-modern" id="table-agendadas">
                                                <thead>
                                                    <tr>
                                                        <th>Pedido</th>
                                                        <th>Cliente</th>
                                                        <th>Telefone</th>
                                                        <th>Data Entrega</th>
                                                        <th>Envio Agendado</th>
                                                        <th>Status</th>
                                                        <th>Tentativas</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-agendadas">
                                                    <tr>
                                                        <td colspan="7" class="text-center">Carregando...</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- TAB RESPOSTAS -->
                                        <div id="tab-respostas" class="tab-pane">
                                            <table class="table table-bordered table-striped table-modern" id="table-respostas">
                                                <thead>
                                                    <tr>
                                                        <th>Pedido</th>
                                                        <th>Cliente</th>
                                                        <th>Telefone</th>
                                                        <th>Nota Geral</th>
                                                        <th>NPS</th>
                                                        <th>Etapa</th>
                                                        <th>Tempo Resposta</th>
                                                        <th>Data</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-respostas">
                                                    <tr>
                                                        <td colspan="8" class="text-center">Carregando...</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- TAB COMENTÁRIOS -->
                                        <div id="tab-comentarios" class="tab-pane">
                                            <div id="comentarios-container" style="padding: 15px;">
                                                <p class="text-center">Carregando...</p>
                                            </div>
                                        </div>

                                        <!-- TAB POR CLIENTE -->
                                        <div id="tab-por-cliente" class="tab-pane">
                                            <div style="padding: 15px;">
                                                <div class="row-fluid" style="margin-bottom: 15px;">
                                                    <div class="span6">
                                                        <input type="text" id="filtro-cliente" class="form-control" placeholder="🔍 Buscar cliente..." style="padding: 8px;">
                                                    </div>
                                                    <div class="span6 text-right">
                                                        <select id="filtro-nota" class="form-control" style="width: 200px; display: inline-block;">
                                                            <option value="">Todas as notas</option>
                                                            <option value="5">⭐⭐⭐⭐⭐ (5 estrelas)</option>
                                                            <option value="4">⭐⭐⭐⭐ (4 estrelas)</option>
                                                            <option value="3">⭐⭐⭐ (3 estrelas)</option>
                                                            <option value="2">⭐⭐ (2 estrelas)</option>
                                                            <option value="1">⭐ (1 estrela)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="clientes-container">
                                                    <p class="text-center">Carregando...</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- TAB INSIGHTS -->
                                        <div id="tab-insights" class="tab-pane">
                                            <div style="padding: 20px;">
                                                <h4 style="margin-bottom: 20px;">💡 Análises e Insights</h4>
                                                
                                                <!-- Produtos Problemáticos -->
                                                <div style="margin-bottom: 30px;">
                                                    <h5>🍔 Produtos com Menor Satisfação</h5>
                                                    <table class="table table-bordered table-striped table-modern" id="table-produtos">
                                                        <thead>
                                                            <tr>
                                                                <th>Produto</th>
                                                                <th>Avaliações</th>
                                                                <th>Nota Média</th>
                                                                <th>Nota Comida</th>
                                                                <th>Negativas</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tbody-produtos">
                                                            <tr><td colspan="5" class="text-center">Carregando...</td></tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- Horários Críticos -->
                                                <div style="margin-bottom: 30px;">
                                                    <h5>⏰ Horários com Mais Reclamações</h5>
                                                    <table class="table table-bordered table-striped table-modern" id="table-horarios">
                                                        <thead>
                                                            <tr>
                                                                <th>Horário</th>
                                                                <th>Total Pedidos</th>
                                                                <th>Nota Média</th>
                                                                <th>Nota Entrega</th>
                                                                <th>Negativas</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tbody-horarios">
                                                            <tr><td colspan="5" class="text-center">Carregando...</td></tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- Tempo vs Satisfação -->
                                                <div style="margin-bottom: 30px;">
                                                    <h5>⏱️ Tempo de Resposta vs Satisfação</h5>
                                                    <table class="table table-bordered table-striped table-modern" id="table-tempo">
                                                        <thead>
                                                            <tr>
                                                                <th>Faixa de Tempo</th>
                                                                <th>Total</th>
                                                                <th>Nota Média</th>
                                                                <th>Nota Entrega</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tbody-tempo">
                                                            <tr><td colspan="4" class="text-center">Carregando...</td></tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- Segmentação NPS -->
                                                <div>
                                                    <h5>👥 Segmentação por NPS</h5>
                                                    <table class="table table-bordered table-striped table-modern" id="table-nps-seg">
                                                        <thead>
                                                            <tr>
                                                                <th>Segmento</th>
                                                                <th>Total Clientes</th>
                                                                <th>Nota Média</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="tbody-nps-seg">
                                                            <tr><td colspan="3" class="text-center">Carregando...</td></tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- TAB ALERTAS -->
                                        <div id="tab-alertas" class="tab-pane">
                                            <div style="padding: 20px;">
                                                <h4 style="margin-bottom: 20px;">🚨 Alertas Automáticos</h4>
                                                <div id="alertas-container">
                                                    <p class="text-center">Carregando...</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

                <script>
                    $(document).ready(function() {
                        // Carregar estatísticas
                        function carregarEstatisticas() {
                            $.get('<?= $baseUri; ?>/api/avaliacoes-estatisticas.php', function(data) {
                                if (data.success) {
                                    $('#total-avaliacoes').html(data.total_avaliacoes || '0');
                                    $('#nota-media').html(data.nota_media ? '⭐ ' + data.nota_media : '-');
                                    $('#nps-score').html(data.nps_score || '0');
                                    $('#taxa-resposta').html((data.taxa_resposta || 0) + '%');
                                }
                            }).fail(function() {
                                console.error('Erro ao carregar estatísticas');
                            });
                        }

                        // Carregar pesquisas agendadas
                        function carregarAgendadas() {
                            console.log('[DEBUG] Iniciando carregarAgendadas...');
                            $.get('<?= $baseUri; ?>/api/avaliacoes-agendadas.php', function(data) {
                                console.log('[DEBUG] Resposta recebida:', data);
                                if (data.success && data.agendadas.length > 0) {
                                    let html = '';
                                    data.agendadas.forEach(function(item) {
                                        let statusBadge = '';
                                        switch (item.status_agendamento) {
                                            case 'pendente':
                                                statusBadge = '<span class="label label-warning">Pendente</span>';
                                                break;
                                            case 'enviado':
                                                statusBadge = '<span class="label label-success">Enviado</span>';
                                                break;
                                            case 'cancelado':
                                                statusBadge = '<span class="label label-default">Cancelado</span>';
                                                break;
                                            case 'erro':
                                                statusBadge = '<span class="label label-danger">Erro</span>';
                                                break;
                                        }
                                        html += '<tr>' +
                                            '<td>#' + item.pedido_id + '</td>' +
                                            '<td>' + item.cliente_nome + '</td>' +
                                            '<td>' + item.cliente_telefone + '</td>' +
                                            '<td>' + formatarData(item.data_entrega) + '</td>' +
                                            '<td>' + formatarData(item.data_envio_agendada) + '</td>' +
                                            '<td>' + statusBadge + '</td>' +
                                            '<td>' + item.tentativas_envio + '</td>' +
                                            '</tr>';
                                    });
                                    $('#tbody-agendadas').html(html);
                                } else {
                                    $('#tbody-agendadas').html('<tr><td colspan="7" class="text-center">Nenhuma pesquisa agendada</td></tr>');
                                }
                            }).fail(function(xhr, status, error) {
                                console.error('[DEBUG] Erro na requisição:');
                                console.error('Status:', xhr.status);
                                console.error('Response:', xhr.responseText);
                                console.error('Error:', error);
                                $('#tbody-agendadas').html('<tr><td colspan="7" class="text-center text-danger">Erro ao carregar dados</td></tr>');
                            });
                        }

                        // Carregar respostas
                        function carregarRespostas() {
                            $.get('<?= $baseUri; ?>/api/avaliacoes-respostas.php', function(data) {
                                if (data.success && data.respostas.length > 0) {
                                    let html = '';
                                    data.respostas.forEach(function(item) {
                                        let etapaBadge = '';
                                        switch (item.etapa_atual) {
                                            case 'pendente':
                                                etapaBadge = '<span class="label label-default">Pendente</span>';
                                                break;
                                            case 'nota_geral':
                                                etapaBadge = '<span class="label label-info">Nota Geral</span>';
                                                break;
                                            case 'detalhamento':
                                                etapaBadge = '<span class="label label-warning">Detalhamento</span>';
                                                break;
                                            case 'comentario':
                                                etapaBadge = '<span class="label label-primary">Comentário</span>';
                                                break;
                                            case 'nps':
                                                etapaBadge = '<span class="label label-info">NPS</span>';
                                                break;
                                            case 'concluido':
                                                etapaBadge = '<span class="label label-success">✓ Concluído</span>';
                                                break;
                                        }
                                        html += '<tr>' +
                                            '<td>#' + item.pedido_id + '</td>' +
                                            '<td>' + item.cliente_nome + '</td>' +
                                            '<td>' + (item.cliente_telefone || '-') + '</td>' +
                                            '<td>' + renderEstrelas(item.nota_geral) + '</td>' +
                                            '<td>' + (item.nps_score || '-') + '</td>' +
                                            '<td>' + etapaBadge + '</td>' +
                                            '<td>' + (item.tempo_resposta_minutos ? item.tempo_resposta_minutos + ' min' : '-') + '</td>' +
                                            '<td>' + formatarData(item.created_at) + '</td>' +
                                            '</tr>';
                                    });
                                    $('#tbody-respostas').html(html);
                                } else {
                                    $('#tbody-respostas').html('<tr><td colspan="8" class="text-center">Nenhuma resposta recebida</td></tr>');
                                }
                            }).fail(function() {
                                $('#tbody-respostas').html('<tr><td colspan="8" class="text-center text-danger">Erro ao carregar dados</td></tr>');
                            });
                        }

                        // Carregar avaliações por cliente
                        function carregarPorCliente(filtroNome = '', filtroNota = '') {
                            $.get('<?= $baseUri; ?>/api/avaliacoes-por-cliente.php', { 
                                nome: filtroNome,
                                nota: filtroNota
                            }, function(data) {
                                if (data.success && data.clientes && data.clientes.length > 0) {
                                    let html = '';
                                    data.clientes.forEach(function(cliente) {
                                        // DEBUG
                                        console.log('Cliente:', cliente.cliente_nome);
                                        console.log('Total avaliações (API):', cliente.total_avaliacoes);
                                        console.log('Avaliações array:', cliente.avaliacoes);
                                        console.log('Avaliações length:', cliente.avaliacoes ? cliente.avaliacoes.length : 0);
                                        console.log('---');
                                        
                                        // Calcular estatísticas
                                        let mediaNotas = cliente.media_geral ? parseFloat(cliente.media_geral).toFixed(1) : '-';
                                        let totalAvaliacoes = cliente.total_avaliacoes || 0;
                                        let npsScore = cliente.nps_medio ? Math.round(cliente.nps_medio) : '-';
                                        
                                        // Header do card
                                        html += '<div class="cliente-card" data-cliente-id="' + cliente.cliente_id + '">';
                                        html += '<div class="cliente-header" onclick="toggleCliente(' + cliente.cliente_id + ')">';
                                        html += '<div class="cliente-info">';
                                        html += '<div class="cliente-nome">👤 ' + cliente.cliente_nome + '</div>';
                                        html += '<div class="cliente-stats">';
                                        html += '📱 ' + (cliente.cliente_telefone || 'Não informado');
                                        if (cliente.cliente_endereco) {
                                            let enderecoCompleto = cliente.cliente_endereco;
                                            if (cliente.endereco_numero) {
                                                enderecoCompleto += ', ' + cliente.endereco_numero;
                                            }
                                            if (cliente.endereco_bairro) {
                                                enderecoCompleto += ' - ' + cliente.endereco_bairro;
                                            }
                                            html += ' | 📍 ' + enderecoCompleto;
                                        }
                                        html += '</div></div>';
                                        html += '<div class="cliente-resumo">';
                                        html += '<div class="resumo-item">';
                                        html += '<span class="resumo-numero">' + totalAvaliacoes + '</span>';
                                        html += '<span class="resumo-label">Avaliações</span>';
                                        html += '</div>';
                                        html += '<div class="resumo-item">';
                                        html += '<span class="resumo-numero">⭐ ' + mediaNotas + '</span>';
                                        html += '<span class="resumo-label">Média</span>';
                                        html += '</div>';
                                        html += '<div class="resumo-item">';
                                        html += '<span class="resumo-numero">' + npsScore + '</span>';
                                        html += '<span class="resumo-label">NPS</span>';
                                        html += '</div>';
                                        html += '<div class="resumo-item">';
                                        html += '<i class="fa fa-chevron-down toggle-icon" id="icon-' + cliente.cliente_id + '"></i>';
                                        html += '</div></div></div>';
                                        
                                        // Body com pedidos (inicialmente oculto)
                                        html += '<div class="cliente-body" id="body-' + cliente.cliente_id + '">';
                                        
                                        if (cliente.avaliacoes && cliente.avaliacoes.length > 0) {
                                            cliente.avaliacoes.forEach(function(av) {
                                                html += '<div class="pedido-item">';
                                                html += '<div class="pedido-header">';
                                                html += '<span class="pedido-numero">Pedido #' + av.pedido_id + '</span>';
                                                html += '<span class="pedido-data">' + formatarData(av.data_avaliacao) + '</span>';
                                                html += '</div>';
                                                
                                                // Notas detalhadas
                                                html += '<div class="pedido-notas">';
                                                if (av.nota_geral) {
                                                    html += '<div class="nota-item">';
                                                    html += '<span class="nota-label">Geral</span>';
                                                    html += '<span class="nota-valor">' + renderEstrelas(av.nota_geral) + '</span>';
                                                    html += '</div>';
                                                }
                                                if (av.nota_comida) {
                                                    html += '<div class="nota-item">';
                                                    html += '<span class="nota-label">🍕 Comida</span>';
                                                    html += '<span class="nota-valor">' + renderEstrelas(av.nota_comida) + '</span>';
                                                    html += '</div>';
                                                }
                                                if (av.nota_entrega) {
                                                    html += '<div class="nota-item">';
                                                    html += '<span class="nota-label">🚚 Entrega</span>';
                                                    html += '<span class="nota-valor">' + renderEstrelas(av.nota_entrega) + '</span>';
                                                    html += '</div>';
                                                }
                                                if (av.nota_atendimento) {
                                                    html += '<div class="nota-item">';
                                                    html += '<span class="nota-label">💬 Atendimento</span>';
                                                    html += '<span class="nota-valor">' + renderEstrelas(av.nota_atendimento) + '</span>';
                                                    html += '</div>';
                                                }
                                                if (av.nps_score) {
                                                    html += '<div class="nota-item">';
                                                    html += '<span class="nota-label">📊 NPS</span>';
                                                    html += '<span class="nota-valor">' + av.nps_score + '/10</span>';
                                                    html += '</div>';
                                                }
                                                html += '</div>';
                                                
                                                // Comentário (se houver)
                                                if (av.comentario && av.comentario.trim() !== '') {
                                                    html += '<div class="pedido-comentario">';
                                                    html += '<i class="fa fa-quote-left"></i> ' + av.comentario;
                                                    html += '</div>';
                                                }
                                                
                                                html += '</div>'; // fecha pedido-item
                                            });
                                        } else {
                                            html += '<p class="text-center" style="padding: 20px; color: #999;">Nenhuma avaliação encontrada</p>';
                                        }
                                        
                                        html += '</div>'; // fecha cliente-body
                                        html += '</div>'; // fecha cliente-card
                                    });
                                    $('#clientes-container').html(html);
                                } else if (data.mensagem) {
                                    // Mostrar mensagem específica (ex: tabela não existe)
                                    $('#clientes-container').html('<div style="text-align: center; padding: 40px;">' +
                                        '<i class="fa fa-info-circle" style="font-size: 48px; color: #17a2b8; margin-bottom: 15px; display: block;"></i>' +
                                        '<p style="color: #6c757d; font-size: 14px;">' + data.mensagem + '</p>' +
                                        '<p style="margin-top: 20px;"><a href="<?= $baseUri; ?>/bot_documentacao/migration_avaliacao_pedido.sql" target="_blank" class="btn btn-primary">Ver Migration SQL</a></p>' +
                                        '</div>');
                                } else {
                                    $('#clientes-container').html('<p class="text-center" style="padding: 40px; color: #999;"><i class="fa fa-users" style="font-size: 48px; display: block; margin-bottom: 15px;"></i>Nenhum cliente com avaliações</p>');
                                }
                            }).fail(function(xhr, status, error) {
                                console.error('Erro na requisição:', error);
                                console.error('Status:', status);
                                console.error('Response:', xhr.responseText);
                                
                                let errorMsg = 'Erro ao carregar dados';
                                try {
                                    const response = JSON.parse(xhr.responseText);
                                    if (response.error) {
                                        errorMsg = response.error;
                                    }
                                } catch (e) {
                                    errorMsg = xhr.responseText || 'Erro desconhecido';
                                }
                                
                                $('#clientes-container').html('<div style="text-align: center; padding: 40px;">' +
                                    '<i class="fa fa-exclamation-triangle" style="font-size: 48px; color: #dc3545; margin-bottom: 15px; display: block;"></i>' +
                                    '<p class="text-danger" style="font-size: 14px;">' + errorMsg + '</p>' +
                                    '<p style="margin-top: 20px; color: #6c757d; font-size: 12px;">Verifique o console (F12) para mais detalhes</p>' +
                                    '</div>');
                            });
                        }

                        // Toggle expansão do card do cliente
                        window.toggleCliente = function(clienteId) {
                            const body = $('#body-' + clienteId);
                            const icon = $('#icon-' + clienteId);
                            
                            body.toggleClass('active');
                            icon.toggleClass('active');
                        };

                        // Filtros
                        $('#filtro-cliente').on('keyup', function() {
                            const nome = $(this).val();
                            const nota = $('#filtro-nota').val();
                            carregarPorCliente(nome, nota);
                        });

                        $('#filtro-nota').on('change', function() {
                            const nome = $('#filtro-cliente').val();
                            const nota = $(this).val();
                            carregarPorCliente(nome, nota);
                        });

                        // Carregar comentários
                        function carregarComentarios() {
                            $.get('<?= $baseUri; ?>/api/avaliacoes-comentarios.php', function(data) {
                                if (data.success && data.comentarios.length > 0) {
                                    let html = '';
                                    data.comentarios.forEach(function(item) {
                                        html += '<div class="comment-card">' +
                                            '<div class="comment-header">' +
                                            '<div>' +
                                            '<span class="comment-author">Pedido #' + item.pedido_id + ' - ' + item.cliente_nome + '</span>' +
                                            '</div>' +
                                            '<div class="comment-rating">' + renderEstrelas(item.nota_geral) + '</div>' +
                                            '</div>' +
                                            '<div class="comment-text">' + (item.comentario || '<em style="color: #999;">Sem comentário</em>') + '</div>' +
                                            '<div class="comment-date"><i class="fa fa-clock-o"></i> ' + formatarData(item.created_at) + '</div>' +
                                            '</div>';
                                    });
                                    $('#comentarios-container').html(html);
                                } else {
                                    $('#comentarios-container').html('<p class="text-center" style="padding: 40px; color: #999;"><i class="fa fa-inbox" style="font-size: 48px; display: block; margin-bottom: 15px;"></i>Nenhum comentário disponível</p>');
                                }
                            }).fail(function() {
                                $('#comentarios-container').html('<p class="text-center text-danger">Erro ao carregar comentários</p>');
                            });
                        }

                        // Helpers
                        function formatarData(data) {
                            if (!data) return '-';
                            let d = new Date(data);
                            return d.toLocaleString('pt-BR');
                        }

                        function renderEstrelas(nota) {
                            if (!nota) return '-';
                            let estrelas = '';
                            for (let i = 1; i <= 5; i++) {
                                estrelas += i <= nota ? '⭐' : '☆';
                            }
                            return estrelas + ' (' + nota + ')';
                        }

                        // 📊 Carregar Insights
                        function carregarInsights() {
                            $.get('<?= $baseUri; ?>/api/avaliacoes-insights.php', function(data) {
                                if (data.success && data.insights) {
                                    const insights = data.insights;
                                    
                                    // Produtos problemáticos
                                    if (insights.produtos_problematicos && insights.produtos_problematicos.length > 0) {
                                        let html = '';
                                        insights.produtos_problematicos.forEach(function(p) {
                                            html += '<tr>' +
                                                '<td>' + p.produto + '</td>' +
                                                '<td>' + p.vezes_avaliado + '</td>' +
                                                '<td>' + parseFloat(p.nota_media).toFixed(1) + ' ⭐</td>' +
                                                '<td>' + parseFloat(p.nota_comida_media || 0).toFixed(1) + ' ⭐</td>' +
                                                '<td><span class="label label-danger">' + p.avaliacoes_negativas + '</span></td>' +
                                                '</tr>';
                                        });
                                        $('#tbody-produtos').html(html);
                                    } else {
                                        $('#tbody-produtos').html('<tr><td colspan="5" class="text-center" style="color: #28a745;">✅ Nenhum produto com problemas!</td></tr>');
                                    }
                                    
                                    // Horários críticos
                                    if (insights.horarios_criticos && insights.horarios_criticos.length > 0) {
                                        let html = '';
                                        insights.horarios_criticos.forEach(function(h) {
                                            html += '<tr>' +
                                                '<td>' + h.hora + ':00</td>' +
                                                '<td>' + h.total_pedidos + '</td>' +
                                                '<td>' + parseFloat(h.nota_media).toFixed(1) + ' ⭐</td>' +
                                                '<td>' + parseFloat(h.nota_entrega_media || 0).toFixed(1) + ' ⭐</td>' +
                                                '<td><span class="label label-warning">' + h.avaliacoes_negativas + '</span></td>' +
                                                '</tr>';
                                        });
                                        $('#tbody-horarios').html(html);
                                    } else {
                                        $('#tbody-horarios').html('<tr><td colspan="5" class="text-center" style="color: #28a745;">✅ Todos os horários estão bem!</td></tr>');
                                    }
                                    
                                    // Tempo vs Satisfação
                                    if (insights.tempo_vs_satisfacao && insights.tempo_vs_satisfacao.length > 0) {
                                        let html = '';
                                        insights.tempo_vs_satisfacao.forEach(function(t) {
                                            html += '<tr>' +
                                                '<td>' + t.faixa_tempo + '</td>' +
                                                '<td>' + t.total + '</td>' +
                                                '<td>' + parseFloat(t.nota_media).toFixed(1) + ' ⭐</td>' +
                                                '<td>' + parseFloat(t.nota_entrega_media || 0).toFixed(1) + ' ⭐</td>' +
                                                '</tr>';
                                        });
                                        $('#tbody-tempo').html(html);
                                    } else {
                                        $('#tbody-tempo').html('<tr><td colspan="4" class="text-center">Sem dados suficientes</td></tr>');
                                    }
                                    
                                    // Segmentação NPS
                                    if (insights.segmentacao_nps && insights.segmentacao_nps.length > 0) {
                                        let html = '';
                                        insights.segmentacao_nps.forEach(function(s) {
                                            let badge = '';
                                            if (s.segmento === 'Promotor') badge = '<span class="label label-success">' + s.segmento + '</span>';
                                            else if (s.segmento === 'Detrator') badge = '<span class="label label-danger">' + s.segmento + '</span>';
                                            else badge = '<span class="label label-warning">' + s.segmento + '</span>';
                                            
                                            html += '<tr>' +
                                                '<td>' + badge + '</td>' +
                                                '<td>' + s.total_clientes + '</td>' +
                                                '<td>' + parseFloat(s.nota_media).toFixed(1) + ' ⭐</td>' +
                                                '</tr>';
                                        });
                                        $('#tbody-nps-seg').html(html);
                                    } else {
                                        $('#tbody-nps-seg').html('<tr><td colspan="3" class="text-center">Sem dados de NPS</td></tr>');
                                    }
                                }
                            }).fail(function() {
                                console.error('Erro ao carregar insights');
                            });
                        }

                        // 🚨 Carregar Alertas
                        function carregarAlertas() {
                            $.get('<?= $baseUri; ?>/api/avaliacoes-insights.php', function(data) {
                                if (data.success && data.insights && data.insights.alertas) {
                                    const alertas = data.insights.alertas;
                                    
                                    if (alertas.length > 0) {
                                        let html = '';
                                        alertas.forEach(function(alerta) {
                                            let icone = '';
                                            let classeAlerta = '';
                                            
                                            if (alerta.tipo === 'danger') {
                                                icone = '🔴';
                                                classeAlerta = 'alert-danger';
                                            } else if (alerta.tipo === 'warning') {
                                                icone = '🟡';
                                                classeAlerta = 'alert-warning';
                                            } else {
                                                icone = '🔵';
                                                classeAlerta = 'alert-info';
                                            }
                                            
                                            html += '<div class="alert ' + classeAlerta + '" style="border-left: 4px solid; margin-bottom: 15px;">' +
                                                '<h5 style="margin: 0 0 10px 0;">' + icone + ' ' + alerta.titulo + '</h5>' +
                                                '<p style="margin: 0; font-size: 14px;">' + alerta.mensagem + '</p>' +
                                                '</div>';
                                        });
                                        $('#alertas-container').html(html);
                                    } else {
                                        $('#alertas-container').html('<div class="alert alert-success" style="text-align: center; padding: 40px;">' +
                                            '<i class="fa fa-check-circle" style="font-size: 64px; display: block; margin-bottom: 20px; opacity: 0.5;"></i>' +
                                            '<h4>✅ Tudo Certo!</h4>' +
                                            '<p style="color: #6c757d; margin-top: 10px;">Nenhum alerta no momento. Continue assim!</p>' +
                                            '</div>');
                                    }
                                } else {
                                    $('#alertas-container').html('<p class="text-center">Sem alertas disponíveis</p>');
                                }
                            }).fail(function() {
                                $('#alertas-container').html('<p class="text-center text-danger">Erro ao carregar alertas</p>');
                            });
                        }

                        // Carregar tudo ao iniciar
                        carregarEstatisticas();
                        carregarAgendadas();
                        carregarRespostas();
                        carregarComentarios();
                        carregarPorCliente();
                        carregarInsights();
                        carregarAlertas();

                        // Auto-refresh a cada 30 segundos
                        setInterval(function() {
                            carregarEstatisticas();
                            carregarAgendadas();
                            carregarRespostas();
                            carregarInsights();
                            carregarAlertas();
                        }, 30000);
                        
                        // 💡 MODAL INFORMATIVO: Como funciona o sistema
                        $('#btn-info-avaliacoes').on('click', function(e) {
                            e.preventDefault();
                            
                            var modalHtml = '<div class="modal fade" id="modal-info-avaliacoes" tabindex="-1" role="dialog">' +
                                '<div class="modal-dialog" style="width: 700px;">' +
                                '<div class="modal-content">' +
                                '<div class="modal-header" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white;">' +
                                '<button type="button" class="close" data-dismiss="modal" style="color: white; opacity: 0.8;">&times;</button>' +
                                '<h4 class="modal-title"><i class="fa fa-info-circle"></i> Como Funciona o Sistema de Avalia\u00e7\u00f5es?</h4>' +
                                '</div>' +
                                '<div class="modal-body" style="padding: 25px; line-height: 1.8;">' +
                                '<p style="font-size: 15px; margin-bottom: 20px;">' +
                                '<strong>🧠 Sistema Inteligente Anti-Fadiga Híbrido:</strong> Para não incomodar clientes frequentes, as pesquisas seguem regras inteligentes:' +
                                '</p>' +
                                '<ul style="margin-left: 20px; margin-bottom: 25px;">' +
                                '<li style="margin-bottom: Requisito Bot:12px;"><strong>🆕 Clientes Novos:</strong> SEMPRE recebem pesquisa no <strong>1º pedido</strong> (feedback de primeira impressão é essencial)</li>' +
                                '<li style="margin-bottom: 12px;"><strong>🔄 Clientes Recorrentes:</strong> Recebem se passou <strong>30 dias</strong> desde última pesquisa <strong>OU</strong> completou <strong>5 pedidos</strong> entregues</li>' +
                                '<li style="margin-bottom: 12px;"><strong>⏰ Agendamento:</strong> Enviada via WhatsApp <strong>40 minutos após a entrega</strong></li>' +
                                '</ul>' +
                                '<div style="background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #17a2b8; margin-bottom: 20px;">' +
                                '<strong style="font-size: 15px;">📊 Exemplo Prático:</strong><br><br>' +
                                '• Cliente faz <strong>20 pedidos em 1 semana</strong> → Recebe no 1º e no 6º pedido (depois só após 30 dias) ✅<br>' +
                                '• Cliente faz <strong>1 pedido/mês</strong> → Recebe pesquisa todo mês (passou 30 dias) ✅<br>' +
                                '• Cliente faz <strong>3 pedidos em 2 semanas</strong> → NÃO recebe (aguarda 30 dias ou 5 pedidos) ⏭️<br>' +
                                '• Cliente novo → Recebe no <strong>1º pedido sempre</strong> ✅' +
                                '</div>' +
                                '<div style="background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107;">' +
                                '<strong style="color: #856404;">💡 Vantagens:</strong><br>' +
                                '✅ Clientes frequentes não são incomodados a cada pedido<br>' +
                                '✅ Feedback de novos clientes sempre coletado<br>' +
                                '✅ Mantém contato regular com clientes esporádicos<br>' +
                                '</div>' +
                                '</div>' +
                                '<div class="modal-footer">' +
                                '<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-check"></i> Entendi</button>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                            
                            // Remover modal anterior se existir
                            $('#modal-info-avaliacoes').remove();
                            
                            // Adicionar e mostrar modal
                            $('body').append(modalHtml);
                            $('#modal-info-avaliacoes').modal('show');
                        });
                    });
                </script>
                <script>
                    $('#menu-avaliacoes').addClass('active');
                </script>
            </div> <!-- /content -->
        </div> <!-- /block-flat -->
    </div> <!-- /cl-mcont -->
    </div> <!-- /container-fluid -->
    </div> <!-- /cl-wrapper -->
</body>

</html>