<?php extract($data); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once __DIR__ . '/../site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Detalhes da Mesa - Sistema de Gerenciamento">
    <meta name="author" content="">
    <title>Mesa <?php echo $mesa->mesa_numero ?? 'N/A'; ?> - Detalhes - <?php echo $config->config_nome; ?></title>
    
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery.select2/dist/css/select2.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
        <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap.summernote/dist/summernote.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />
    <link href="css/mesa-detalhes.css" rel="stylesheet" />
</head>
<body class="animated">
    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php require_once __DIR__ . '/../side-menu.php'; ?>
        </div>
        <div class="container-fluid" id="pcont">
            <div class="cl-mcont">
                <div class="block-flat">
                    <div class="header">
                        <h3>
                            <i class="fa fa-info-circle"></i> Detalhes da Mesa
                            <small id="refreshTime" class="refresh-indicator">
                                <i class="fa fa-refresh fa-spin"></i> Atualizando...
                            </small>
                            <span class="pull-right">
                                <button class="btn btn-primary btn-sm" onclick="atualizarDados()">
                                    <i class="fa fa-refresh"></i> Atualizar
                                </button>
                                <a href="<?php echo $baseUri; ?>/mesa/lista" class="btn btn-default btn-sm">
                                    <i class="fa fa-list"></i> Lista
                                </a>
                                <a href="<?php echo $baseUri; ?>/mesa/" class="btn btn-info btn-sm">
                                    <i class="fa fa-dashboard"></i> Dashboard
                                </a>
                            </span>
                            <div class="row hidden-desktop"></div>
                        </h3>
                    </div>
                    <div class="content">
                        
                        <?php if (!$mesa): ?>
                            <div class="alert alert-danger">
                                <h3><i class="fa fa-exclamation-triangle"></i> Mesa não encontrada!</h3>
                                <p>A mesa solicitada não foi encontrada no sistema.</p>
                                <br>
                                <a href="/admin/mesa/lista" class="btn btn-default btn-lg">
                                    <i class="fa fa-arrow-left"></i> Voltar para Lista
                                </a>
                            </div>
                        <?php else: ?>
                            <?php
                            $status_info = '';
                            $header_class = '';
                            
                            switch ($mesa->mesa_status) {
                                case 0:
                                    $status_info = 'Livre';
                                    $header_class = 'status-livre';
                                    break;
                                case 1:
                                    $status_info = 'Ocupada';
                                    $header_class = 'status-ocupada';
                                    break;
                                case 2:
                                    $status_info = 'Reservada';
                                    $header_class = 'status-reservada';
                                    break;
                                case 3:
                                    $status_info = 'Manutenção';
                                    $header_class = 'status-manutencao';
                                    break;
                            }
                            ?>
                            
                            <!-- Header da Mesa -->
                            <div class="detail-header <?= $header_class ?>">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h1 class="mesa-title">Mesa <?= $mesa->mesa_numero ?></h1>
                                        <p class="mesa-subtitle">
                                            <i class="fa fa-users"></i> <?= $mesa->mesa_capacidade ?> pessoas
                                            <span style="margin-left: 20px;">
                                                <i class="fa fa-map-marker"></i> <?= htmlspecialchars($mesa->mesa_localizacao) ?>
                                            </span>
                                        </p>
                                        <?php if ($mesa->mesa_status == 1 && isset($mesa->ocupacao_inicio)): ?>
                                            <div class="duration-badge">
                                                <i class="fa fa-clock-o"></i> 
                                                <?php 
                                                if ($mesa->ocupacao_inicio) {
                                                    $inicio = new DateTime($mesa->ocupacao_inicio);
                                                    $agora = new DateTime();
                                                    $duracao = $agora->diff($inicio);
                                                    echo $duracao->format('%h:%I:%S');
                                                } else {
                                                    echo 'N/A';
                                                }
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <div class="status-badge">
                                            <i class="fa fa-circle"></i> <?= $status_info ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- Informações da Mesa -->
                                    <div class="info-card">
                                        <div class="info-card-header">
                                            <i class="fa fa-info-circle"></i> Informações da Mesa
                                        </div>
                                        <div class="info-card-body">
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="fa fa-hashtag"></i> Número
                                                </span>
                                                <span class="info-value">Mesa <?= $mesa->mesa_numero ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="fa fa-users"></i> Capacidade
                                                </span>
                                                <span class="info-value"><?= $mesa->mesa_capacidade ?> pessoas</span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="fa fa-map-marker"></i> Localização
                                                </span>
                                                <span class="info-value"><?= htmlspecialchars($mesa->mesa_localizacao) ?></span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="fa fa-toggle-on"></i> Status
                                                </span>
                                                <span class="info-value">
                                                    <?php 
                                                        $status_colors = [
                                                            0 => 'success',
                                                            1 => 'danger', 
                                                            2 => 'warning',
                                                            3 => 'default'
                                                        ];
                                                        $color = $status_colors[$mesa->mesa_status] ?? 'default';
                                                    ?>
                                                    <span class="label label-<?= $color ?>"><?= $status_info ?></span>
                                                </span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="fa fa-check-circle"></i> Ativa
                                                </span>
                                                <span class="info-value">
                                                    <?= $mesa->mesa_ativa ? '<span class="text-success">Sim</span>' : '<span class="text-danger">Não</span>' ?>
                                                </span>
                                            </div>
                                            <?php if (!empty($mesa->mesa_observacao)): ?>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="fa fa-comment"></i> Observações
                                                </span>
                                                <span class="info-value"><?= htmlspecialchars($mesa->mesa_observacao) ?></span>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Ações Rápidas -->
                                    <div class="action-card">
                                        <div class="action-card-header">
                                            <i class="fa fa-bolt"></i> Ações Rápidas
                                        </div>
                                        <div class="action-card-body">
                                            <?php if ($mesa->mesa_status == 0): // Livre ?>
                                                <button class="btn btn-action btn-manutencao" onclick="colocarManutencao(<?= $mesa->mesa_id ?>)">
                                                    <i class="fa fa-wrench"></i> Manutenção
                                                </button>
                                            <?php elseif ($mesa->mesa_status == 1): // Ocupada ?>
                                                <a href="/admin/mesa/pedido/<?= $mesa->mesa_id ?>" class="btn btn-action btn-pedidos">
                                                    <i class="fa fa-cutlery"></i> Gerenciar Pedidos
                                                </a>
                                                <button class="btn btn-action btn-liberar" onclick="liberarMesa(<?= $mesa->mesa_id ?>, <?= $mesa->ocupacao_id ?? 0 ?>)">
                                                    <i class="fa fa-check"></i> Liberar Mesa
                                                </button>
                                            <?php elseif ($mesa->mesa_status == 2): // Reservada ?>
                                                <button class="btn btn-action btn-confirmar" onclick="confirmarReservaMesa(<?= $mesa->mesa_id ?>)">
                                                    <i class="fa fa-check"></i> Confirmar Chegada
                                                </button>
                                                <button class="btn btn-action btn-cancelar" onclick="cancelarReservaMesa(<?= $mesa->mesa_id ?>)">
                                                    <i class="fa fa-times"></i> Cancelar Reserva
                                                </button>
                                            <?php elseif ($mesa->mesa_status == 3): // Manutenção ?>
                                                <button class="btn btn-action btn-confirmar" onclick="liberarManutencao(<?= $mesa->mesa_id ?>)">
                                                    <i class="fa fa-check"></i> Liberar Manutenção
                                                </button>
                                            <?php endif; ?>
                                            
                                            <hr style="margin: 20px 0;">
                                            <a href="/delivery/mesa/editar/<?= $mesa->mesa_id ?>" class="btn btn-action" style="background: linear-gradient(45deg, #667eea, #764ba2); color: white;">
                                                <i class="fa fa-edit"></i> Editar Mesa
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <!-- Status Atual -->
                                    <?php if ($mesa->mesa_status == 1 && isset($mesa->ocupacao_id)): ?>
                                        <div class="occupation-card">
                                            <h3 style="margin-top: 0;"><i class="fa fa-users"></i> Mesa Ocupada</h3>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="info-row" style="border-bottom: 1px solid rgba(255,255,255,0.3); color: rgba(255,255,255,0.9);">
                                                        <span><i class="fa fa-user"></i> <strong>Cliente:</strong></span>
                                                        <span><?= htmlspecialchars($mesa->ocupacao_cliente_nome ?? 'N/A') ?></span>
                                                    </div>
                                                    <div class="info-row" style="border-bottom: 1px solid rgba(255,255,255,0.3); color: rgba(255,255,255,0.9);">
                                                        <span><i class="fa fa-user-md"></i> <strong>Garçom:</strong></span>
                                                        <span><?= htmlspecialchars($mesa->garcon_nome ?? 'N/A') ?></span>
                                                    </div>
                                                    <div class="info-row" style="color: rgba(255,255,255,0.9);">
                                                        <span><i class="fa fa-users"></i> <strong>Pessoas:</strong></span>
                                                        <span><?= $mesa->ocupacao_numero_pessoas ?? 'N/A' ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-row" style="border-bottom: 1px solid rgba(255,255,255,0.3); color: rgba(255,255,255,0.9);">
                                                        <span><i class="fa fa-clock-o"></i> <strong>Início:</strong></span>
                                                        <span><?= $mesa->ocupacao_inicio ? date('d/m/Y H:i', strtotime($mesa->ocupacao_inicio)) : 'N/A' ?></span>
                                                    </div>
                                                    <div class="info-row" style="color: rgba(255,255,255,0.9);">
                                                        <span><i class="fa fa-hourglass-half"></i> <strong>Duração:</strong></span>
                                                        <span>
                                                            <?php 
                                                            if ($mesa->ocupacao_inicio) {
                                                                $inicio = new DateTime($mesa->ocupacao_inicio);
                                                                $agora = new DateTime();
                                                                $duracao = $agora->diff($inicio);
                                                                echo $duracao->format('%h:%I:%S');
                                                            } else {
                                                                echo 'N/A';
                                                            }
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php elseif ($mesa->mesa_status == 2 && isset($mesa->reserva_id)): ?>
                                        <div class="reservation-card">
                                            <h3 style="margin-top: 0;"><i class="fa fa-calendar"></i> Mesa Reservada</h3>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="info-row" style="border-bottom: 1px solid rgba(0,0,0,0.1);">
                                                        <span><i class="fa fa-user"></i> <strong>Cliente:</strong></span>
                                                        <span><?= htmlspecialchars($mesa->reserva_cliente_nome ?? 'N/A') ?></span>
                                                    </div>
                                                    <div class="info-row" style="border-bottom: 1px solid rgba(0,0,0,0.1);">
                                                        <span><i class="fa fa-phone"></i> <strong>Telefone:</strong></span>
                                                        <span><?= htmlspecialchars($mesa->reserva_cliente_telefone ?? 'N/A') ?></span>
                                                    </div>
                                                    <div class="info-row">
                                                        <span><i class="fa fa-users"></i> <strong>Pessoas:</strong></span>
                                                        <span><?= $mesa->reserva_numero_pessoas ?? 'N/A' ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="info-row" style="border-bottom: 1px solid rgba(0,0,0,0.1);">
                                                        <span><i class="fa fa-clock-o"></i> <strong>Horário:</strong></span>
                                                        <span><?= $mesa->reserva_hora_inicio ? date('H:i', strtotime($mesa->reserva_hora_inicio)) : 'N/A' ?></span>
                                                    </div>
                                                    <?php if (!empty($mesa->reserva_observacoes)): ?>
                                                    <div class="info-row">
                                                        <span><i class="fa fa-comment"></i> <strong>Observações:</strong></span>
                                                        <span><?= htmlspecialchars($mesa->reserva_observacoes) ?></span>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Pedidos -->
                                    <?php if (!empty($pedidos)): ?>
                                        <div class="info-card">
                                            <div class="info-card-header">
                                                <i class="fa fa-cutlery"></i> Pedidos da Mesa
                                            </div>
                                            <div class="info-card-body">
                                                <?php foreach ($pedidos as $pedido): ?>
                                                    <div class="pedido-card">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h4 style="margin: 0; color: #333;">
                                                                    <i class="fa fa-receipt"></i> Pedido #<?= $pedido->pedido_id ?>
                                                                </h4>
                                                                <small style="color: #6c757d;">
                                                                    <i class="fa fa-calendar"></i> 
                                                                    <?= date('d/m/Y H:i', strtotime($pedido->pedido_data)) ?>
                                                                </small>
                                                            </div>
                                                            <div class="col-md-3 text-center">
                                                                <?php 
                                                                    $status_pedido = [
                                                                        1 => '<span class="label label-warning">Pendente</span>',
                                                                        2 => '<span class="label label-info">Preparando</span>',
                                                                        3 => '<span class="label label-primary">Pronto</span>',
                                                                        4 => '<span class="label label-success">Entregue</span>',
                                                                        5 => '<span class="label label-danger">Cancelado</span>'
                                                                    ];
                                                                    echo $status_pedido[$pedido->pedido_status] ?? '<span class="label label-default">Desconhecido</span>';
                                                                ?>
                                                            </div>
                                                            <div class="col-md-3 text-right">
                                                                <div style="margin-bottom: 5px;">
                                                                    <strong style="color: #28a745; font-size: 1.1em;">
                                                                        R$ <?= number_format($pedido->pedido_total ?? 0, 2, ',', '.') ?>
                                                                    </strong>
                                                                </div>
                                                                <a href="/admin/pedido/<?= $pedido->pedido_id ?>" class="btn btn-xs btn-info">
                                                                    <i class="fa fa-eye"></i> Visualizar
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Histórico -->
                                    <div class="info-card">
                                        <div class="info-card-header">
                                            <i class="fa fa-history"></i> Histórico Recente
                                        </div>
                                        <div class="info-card-body">
                                            <div class="timeline-item">
                                                <div class="timeline-time">
                                                    <i class="fa fa-clock-o"></i> Agora
                                                </div>
                                                <div class="timeline-content">
                                                    Visualizando detalhes da mesa
                                                </div>
                                            </div>
                                            <?php if ($mesa->mesa_status == 1): ?>
                                                <div class="timeline-item">
                                                    <div class="timeline-time">
                                                        <i class="fa fa-users"></i> 
                                                        <?= $mesa->ocupacao_inicio ? date('H:i', strtotime($mesa->ocupacao_inicio)) : 'N/A' ?>
                                                    </div>
                                                    <div class="timeline-content">
                                                        Mesa ocupada por <strong><?= htmlspecialchars($mesa->ocupacao_cliente_nome ?? 'N/A') ?></strong>
                                                    </div>
                                                </div>
                                            <?php elseif ($mesa->mesa_status == 2): ?>
                                                <div class="timeline-item">
                                                    <div class="timeline-time">
                                                        <i class="fa fa-calendar"></i> Hoje
                                                    </div>
                                                    <div class="timeline-content">
                                                        Reserva para <strong><?= htmlspecialchars($mesa->reserva_cliente_nome ?? 'N/A') ?></strong>
                                                        às <?= $mesa->reserva_hora_inicio ? date('H:i', strtotime($mesa->reserva_hora_inicio)) : 'N/A' ?>
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <div class="timeline-item">
                                                    <div class="timeline-time">
                                                        <i class="fa fa-check-circle"></i> Atual
                                                    </div>
                                                    <div class="timeline-content">
                                                        Mesa disponível para uso
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?php echo $baseUri; ?>/assets/vendor/jquery/jquery-2.1.4.min.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.cooki/jquery.cooki.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.ui/jquery-ui.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.gritter/js/jquery.gritter.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/behaviour/core.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.select2/dist/js/select2.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.maskedinput/jquery.maskedinput.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.mask.js"></script>
    
    <?php require_once __DIR__ . '/../switch-color.php'; ?>
    <script src="<?php echo $baseUri; ?>/view/admin/app-js/main.js"></script>

    <script>
        var baseUri = '<?= $baseUri; ?>';
        
        // Auto-refresh da página a cada 30 segundos se mesa estiver ocupada
        <?php if ($mesa->mesa_status == 1): ?>
        setInterval(function() {
            atualizarDados();
        }, 30000);
        <?php endif; ?>
        
        function atualizarDados() {
            $('#refreshTime').show();
            location.reload();
        }
        
        // Função para colocar em manutenção
        function colocarManutencao(mesaId) {
            if (confirm('Colocar esta mesa em manutenção?\n\nA mesa ficará indisponível para uso.')) {
                $.ajax({
                    url: baseUri + '/admin/mesa/atualizar-status',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        mesa_id: mesaId,
                        status: 3
                    },
                    success: function(response) {
                        try {
                            // Handle both string and object responses
                            if (typeof response === 'string') {
                                response = JSON.parse(response);
                            }
                            if (response && response.status === 'success') {
                                alert('Mesa colocada em manutenção com sucesso!');
                                location.reload();
                            } else {
                                alert('Erro: ' + (response && response.message ? response.message : 'Resposta inválida do servidor'));
                            }
                        } catch (e) {
                            console.error('[' + new Date().toLocaleString() + '] Error parsing response:', e, response);
                            alert('Erro: Resposta inválida do servidor');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('[' + new Date().toLocaleString() + '] AJAX Error:', {
                            status: status,
                            error: error,
                            responseText: xhr.responseText,
                            statusCode: xhr.status
                        });
                        alert('Erro ao comunicar com o servidor: ' + error);
                    }
                });
            }
        }

        function liberarManutencao(mesaId) {
            if (confirm('Liberar esta mesa da manutenção?')) {
                $.ajax({
                    url: baseUri + '/admin/mesa/atualizar-status',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        mesa_id: mesaId,
                        status: 0
                    },
                    success: function(response) {
                        try {
                            if (typeof response === 'string') {
                                response = JSON.parse(response);
                            }
                            if (response && response.status === 'success') {
                                alert('Mesa liberada da manutenção com sucesso!');
                                location.reload();
                            } else {
                                alert('Erro: ' + (response && response.message ? response.message : 'Resposta inválida do servidor'));
                            }
                        } catch (e) {
                            console.error('[' + new Date().toLocaleString() + '] Error parsing response:', e, response);
                            alert('Erro: Resposta inválida do servidor');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('[' + new Date().toLocaleString() + '] AJAX Error:', {
                            status: status,
                            error: error,
                            responseText: xhr.responseText,
                            statusCode: xhr.status
                        });
                        alert('Erro ao comunicar com o servidor: ' + error);
                    }
                });
            }
        }

        function confirmarReservaMesa(mesaId) {
            if (confirm('Confirmar chegada do cliente para a reserva desta mesa?')) {
                $.ajax({
                    url: baseUri + '/admin/mesa/confirmar-reserva',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        mesa_id: mesaId
                    },
                    success: function(response) {
                        try {
                            if (typeof response === 'string') {
                                response = JSON.parse(response);
                            }
                            if (response && response.status === 'success') {
                                alert('Reserva confirmada com sucesso!');
                                location.reload();
                            } else {
                                alert('Erro: ' + (response && response.message ? response.message : 'Resposta inválida do servidor'));
                            }
                        } catch (e) {
                            console.error('[' + new Date().toLocaleString() + '] Error parsing response:', e, response);
                            alert('Erro: Resposta inválida do servidor');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('[' + new Date().toLocaleString() + '] AJAX Error:', {
                            status: status,
                            error: error,
                            responseText: xhr.responseText,
                            statusCode: xhr.status
                        });
                        alert('Erro ao comunicar com o servidor: ' + error);
                    }
                });
            }
        }

        function cancelarReservaMesa(mesaId) {
            var motivo = prompt('Motivo do cancelamento (opcional):');
            if (motivo !== null) {
                $.ajax({
                    url: baseUri + '/admin/mesa/cancelar-reserva',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        mesa_id: mesaId,
                        motivo: motivo
                    },
                    success: function(response) {
                        try {
                            if (typeof response === 'string') {
                                response = JSON.parse(response);
                            }
                            if (response && response.status === 'success') {
                                alert('Reserva cancelada com sucesso!');
                                location.reload();
                            } else {
                                alert('Erro: ' + (response && response.message ? response.message : 'Resposta inválida do servidor'));
                            }
                        } catch (e) {
                            console.error('[' + new Date().toLocaleString() + '] Error parsing response:', e, response);
                            alert('Erro: Resposta inválida do servidor');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('[' + new Date().toLocaleString() + '] AJAX Error:', {
                            status: status,
                            error: error,
                            responseText: xhr.responseText,
                            statusCode: xhr.status
                        });
                        alert('Erro ao comunicar com o servidor: ' + error);
                    }
                });
            }
        }

        // Função para liberar mesa
        function liberarMesa(mesaId, ocupacaoId) {
            if (confirm('ATENÇÃO: Deseja realmente liberar esta mesa?\n\nTodos os pedidos pendentes serão mantidos.')) {
                $.ajax({
                    url: baseUri + '/admin/mesa/liberar',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        mesa_id: mesaId,
                        ocupacao_id: ocupacaoId
                    },
                    success: function(response) {
                        try {
                            if (typeof response === 'string') {
                                response = JSON.parse(response);
                            }
                            if (response && response.status === 'success') {
                                alert('Mesa liberada com sucesso!');
                                location.reload();
                            } else {
                                alert('Erro: ' + (response && response.message ? response.message : 'Resposta inválida do servidor'));
                            }
                        } catch (e) {
                            console.error('[' + new Date().toLocaleString() + '] Error parsing response:', e, response);
                            alert('Erro: Resposta inválida do servidor');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('[' + new Date().toLocaleString() + '] AJAX Error:', {
                            status: status,
                            error: error,
                            responseText: xhr.responseText,
                            statusCode: xhr.status
                        });
                        alert('Erro ao comunicar com o servidor: ' + error);
                    }
                });
            }
        }
        
        // Inicialização
        $(document).ready(function() {
            // Hide refresh indicator after page load
            setTimeout(function() {
                $('#refreshTime').hide();
            }, 1000);
            
            // Add tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // Keyboard shortcuts
            $(document).keydown(function(e) {
                // F5 or Ctrl+R: Refresh
                if (e.which == 116 || (e.ctrlKey && e.which == 82)) {
                    e.preventDefault();
                    atualizarDados();
                }
                // ESC: Back to list
                if (e.which == 27) {
                    window.location.href = baseUri + '/admin/mesa/lista';
                }
            });
        });
        
    </script>

</body>

</html>