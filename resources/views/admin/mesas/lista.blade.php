<?php extract($data); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once __DIR__ . '/../site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de Gerenciamento de Mesas">
    <meta name="author" content="">
    <title>Lista de Mesas - <?php echo $config->config_nome; ?></title>
    
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
    <link href="css/mesa-lista.css" rel="stylesheet" />
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
                            <i class="fa fa-list"></i> Lista de Mesas - Gerenciamento Completo
                            <small id="refreshTime" class="refresh-indicator">
                                <i class="fa fa-refresh fa-spin"></i> Atualizando...
                            </small>
                            <span class="pull-right">
                                <button class="btn btn-primary btn-sm" onclick="atualizarDados()">
                                    <i class="fa fa-refresh"></i> Atualizar
                                </button>
                                <a href="<?php echo $baseUri; ?>/mesa/novo" class="btn btn-success btn-sm">
                                    <i class="fa fa-plus"></i> Nova Mesa
                                </a>
                                <a href="<?php echo $baseUri; ?>/mesa/" class="btn btn-default btn-sm">
                                    <i class="fa fa-dashboard"></i> Dashboard
                                </a>
                            </span>
                            <div class="row hidden-desktop"></div>
                        </h3>
                    </div>
                    <div class="content">
                        
                        <!-- Estatísticas das Mesas -->
                        <div class="row mesa-stats">
                            <?php 
                            $total_mesas = count($mesas ?? []);
                            $mesas_livres = 0;
                            $mesas_ocupadas = 0;
                            $mesas_reservadas = 0;
                            $mesas_manutencao = 0;
                            
                            if (!empty($mesas)) {
                                foreach ($mesas as $mesa) {
                                    switch ($mesa->mesa_status) {
                                        case 0: $mesas_livres++; break;
                                        case 1: $mesas_ocupadas++; break;
                                        case 2: $mesas_reservadas++; break;
                                        case 3: $mesas_manutencao++; break;
                                    }
                                }
                            }
                            ?>
                            <div class="col-md-3">
                                <div class="stats-box">
                                    <div class="stats-number" style="color: #28a745;">
                                        <?= $total_mesas ?>
                                    </div>
                                    <div class="stats-label">Total de Mesas</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-box">
                                    <div class="stats-number" style="color: #17a2b8;">
                                        <?= $mesas_livres ?>
                                    </div>
                                    <div class="stats-label">Mesas Livres</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-box">
                                    <div class="stats-number" style="color: #dc3545;">
                                        <?= $mesas_ocupadas ?>
                                    </div>
                                    <div class="stats-label">Mesas Ocupadas</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-box">
                                    <div class="stats-number" style="color: #ffc107;">
                                        <?= $mesas_reservadas ?>
                                    </div>
                                    <div class="stats-label">Mesas Reservadas</div>
                                </div>
                            </div>
                        </div>

                        <!-- Filtros -->
                        <div class="filter-bar">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Filtrar por Status:</label>
                                        <select class="form-control" id="statusFilter" onchange="filtrarMesas()">
                                            <option value="">Todos os Status</option>
                                            <option value="0">Livres</option>
                                            <option value="1">Ocupadas</option>
                                            <option value="2">Reservadas</option>
                                            <option value="3">Manutenção</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Filtrar por Localização:</label>
                                        <select class="form-control" id="localizacaoFilter" onchange="filtrarMesas()">
                                            <option value="">Todas as Localizações</option>
                                            <?php 
                                            $localizacoes = [];
                                            if (!empty($mesas)) {
                                                foreach ($mesas as $mesa) {
                                                    if (!in_array($mesa->mesa_localizacao, $localizacoes)) {
                                                        $localizacoes[] = $mesa->mesa_localizacao;
                                                    }
                                                }
                                            }
                                            foreach ($localizacoes as $loc): ?>
                                                <option value="<?= htmlspecialchars($loc) ?>"><?= htmlspecialchars($loc) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Buscar Mesa:</label>
                                        <input type="text" class="form-control" id="searchMesa" placeholder="Número da mesa ou cliente..." oninput="filtrarMesas()">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lista de Mesas -->
                        <div id="mesasContainer">
                            <?php if (!empty($mesas)): ?>
                                <div class="row">
                                    <?php foreach ($mesas as $mesa): ?>
                                        <?php
                                        $status_info = '';
                                        $status_class = '';
                                        $header_class = '';

                                        switch ($mesa->mesa_status) {
                                            case 0:
                                                $status_info = 'Livre';
                                                $status_class = 'success';
                                                $header_class = 'status-livre';
                                                break;
                                            case 1:
                                                $status_info = 'Ocupada';
                                                $status_class = 'danger';
                                                $header_class = 'status-ocupada';
                                                break;
                                            case 2:
                                                $status_info = 'Reservada';
                                                $status_class = 'warning';
                                                $header_class = 'status-reservada';
                                                break;
                                            case 3:
                                                $status_info = 'Manutenção';
                                                $status_class = 'default';
                                                $header_class = 'status-manutencao';
                                                break;
                                        }
                                        ?>
                                        <div class="col-md-6" data-status="<?= $mesa->mesa_status ?>" data-localizacao="<?= htmlspecialchars($mesa->mesa_localizacao) ?>" data-numero="<?= $mesa->mesa_numero ?>" data-cliente="<?= htmlspecialchars($mesa->ocupacao_cliente_nome ?? $mesa->reserva_cliente_nome ?? '') ?>">
                                            <div class="mesa-card">
                                                <div class="mesa-header <?= $header_class ?>">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <h2 class="mesa-number">Mesa <?= $mesa->mesa_numero ?></h2>
                                                            <div class="mesa-info">
                                                                <i class="fa fa-users"></i> <?= $mesa->mesa_capacidade ?> pessoas
                                                                <br>
                                                                <i class="fa fa-map-marker"></i> <?= htmlspecialchars($mesa->mesa_localizacao) ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 text-right">
                                                            <div class="mesa-status">
                                                                <i class="fa fa-circle"></i> <?= $status_info ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="mesa-body">
                                                    <?php if ($mesa->mesa_status == 1 && !empty($mesa->ocupacao_cliente_nome)): ?>
                                                        <div class="info-item">
                                                            <span class="info-label"><i class="fa fa-user"></i> Cliente:</span>
                                                            <span class="info-value"><?= htmlspecialchars($mesa->ocupacao_cliente_nome) ?></span>
                                                        </div>
                                                        <div class="info-item">
                                                            <span class="info-label"><i class="fa fa-user-md"></i> Garçom:</span>
                                                            <span class="info-value"><?= htmlspecialchars($mesa->garcon_nome ?? 'N/A') ?></span>
                                                        </div>
                                                        <?php if (!empty($mesa->ocupacao_tempo)): ?>
                                                        <div class="info-item">
                                                            <span class="info-label"><i class="fa fa-clock-o"></i> Tempo Ocupação:</span>
                                                            <span class="info-value"><?= $mesa->ocupacao_tempo ?></span>
                                                        </div>
                                                        <?php endif; ?>
                                                    <?php elseif ($mesa->mesa_status == 2 && !empty($mesa->reserva_cliente_nome)): ?>
                                                        <div class="info-item">
                                                            <span class="info-label"><i class="fa fa-calendar"></i> Reserva:</span>
                                                            <span class="info-value"><?= htmlspecialchars($mesa->reserva_cliente_nome) ?></span>
                                                        </div>
                                                        <div class="info-item">
                                                            <span class="info-label"><i class="fa fa-clock-o"></i> Horário:</span>
                                                            <span class="info-value"><?= date('H:i', strtotime($mesa->reserva_hora_inicio)) ?></span>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="info-item">
                                                            <span class="info-label"><i class="fa fa-info-circle"></i> Status:</span>
                                                            <span class="info-value">Disponível para uso</span>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <div class="mesa-footer">
                                                    <div class="mesa-actions">
                                                        <a href="<?= $baseUri ?>/mesa/detalhes/<?= $mesa->mesa_id ?>" class="btn btn-custom btn-details">
                                                            <i class="fa fa-eye"></i> Detalhes
                                                        </a>
                                                        <a href="<?= $baseUri ?>/mesa/editar/<?= $mesa->mesa_id ?>" class="btn btn-custom btn-edit">
                                                            <i class="fa fa-edit"></i> Editar
                                                        </a>
                                                        <button class="btn btn-custom btn-remove" onclick="removerMesa(<?= $mesa->mesa_id ?>)">
                                                            <i class="fa fa-trash"></i> Remover
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-no-mesas">
                                    <h3><i class="fa fa-table"></i> Nenhuma mesa cadastrada</h3>
                                    <p>Comece criando sua primeira mesa para gerenciar o atendimento do seu restaurante.</p>
                                    <br>
                                    <a href="<?= $baseUri ?>/mesa/novo" class="btn btn-success btn-lg">
                                        <i class="fa fa-plus"></i> Criar Primeira Mesa
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
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
        
        // Auto-refresh da página a cada 3 minutos
        setInterval(function() {
            atualizarDados();
        }, 180000);
        
        function atualizarDados() {
            $('#refreshTime').show();
            location.reload();
        }
        
        // Remover mesa com confirmação
        function removerMesa(mesaId) {
            if (confirm('ATENÇÃO: Deseja realmente REMOVER esta mesa permanentemente?\n\nEsta ação não pode ser desfeita!')) {
                $.ajax({
                    url: baseUri + '/admin/mesa/remove',
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
                                alert('Mesa removida com sucesso!');
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
        
        // Função de filtro das mesas
        function filtrarMesas() {
            var statusFilter = $('#statusFilter').val();
            var localizacaoFilter = $('#localizacaoFilter').val();
            var searchTerm = $('#searchMesa').val().toLowerCase();
            
            $('.mesa-card').parent().each(function() {
                var $container = $(this);
                var status = $container.data('status');
                var localizacao = $container.data('localizacao');
                var numero = $container.data('numero');
                var cliente = $container.data('cliente');
                
                var showByStatus = (statusFilter === '' || status == statusFilter);
                var showByLocalizacao = (localizacaoFilter === '' || localizacao === localizacaoFilter);
                var showBySearch = (searchTerm === '' || 
                    numero.toString().includes(searchTerm) || 
                    cliente.toLowerCase().includes(searchTerm));
                
                if (showByStatus && showByLocalizacao && showBySearch) {
                    $container.show();
                } else {
                    $container.hide();
                }
            });
        }
        
        // Inicialização
        $(document).ready(function() {
            // Hide refresh indicator after page load
            setTimeout(function() {
                $('#refreshTime').hide();
            }, 1000);
            
            // Add tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // Check for success/error messages in URL
            var urlParams = new URLSearchParams(window.location.search);
            var successParam = urlParams.get('success');
            var errorParam = urlParams.get('error');
            
            if (successParam) {
                // Show success message
                var alertDiv = $('<div class="alert alert-success alert-dismissible" style="margin-bottom: 20px; border-radius: 15px;">' +
                    '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                    '<i class="fa fa-check"></i> ' + decodeURIComponent(successParam) +
                    '</div>');
                $('.content').prepend(alertDiv);
                
                // Auto hide after 5 seconds
                setTimeout(function() {
                    alertDiv.fadeOut();
                }, 5000);
                
            }
            
            if (errorParam) {
                // Show error message
                var alertDiv = $('<div class="alert alert-danger alert-dismissible" style="margin-bottom: 20px; border-radius: 15px;">' +
                    '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                    '<i class="fa fa-exclamation-triangle"></i> ' + decodeURIComponent(errorParam) +
                    '</div>');
                $('.content').prepend(alertDiv);
                
                console.error('[' + new Date().toLocaleString() + '] Error message shown: ' + errorParam);
            }
            
            // Keyboard shortcuts
            $(document).keydown(function(e) {
                // F5 or Ctrl+R: Refresh
                if (e.which == 116 || (e.ctrlKey && e.which == 82)) {
                    e.preventDefault();
                    atualizarDados();
                }
            });
        });
        
    </script>

</body>

</html>