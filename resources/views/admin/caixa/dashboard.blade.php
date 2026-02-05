<?php extract($data); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once __DIR__ . '/../site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de Caixa - Fechamento de Mesas">
    <meta name="author" content="">

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
    <link href="css/caixa-dashboard.css" rel="stylesheet" />
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
                            <i class="fa fa-cash-register"></i> Caixa - Fechamento de Mesas
                            <small id="refreshTime" class="refresh-indicator">
                                <i class="fa fa-refresh fa-spin"></i> Atualizando...
                            </small>
                            <span class="pull-right">
                                <button class="btn btn-primary btn-sm" onclick="atualizarDados()">
                                    <i class="fa fa-refresh"></i> Atualizar
                                </button>
                                <a href="<?php echo $baseUri; ?>/admin/caixa/relatorio-garcon/" class="btn btn-success btn-sm">
                                    <i class="fa fa-user-md"></i> Relatório de Garçons
                                </a>
                                <a href="<?php echo $baseUri; ?>/mesa/" class="btn btn-default btn-sm">
                                    <i class="fa fa-table"></i> Gerenciar Mesas
                                </a>
                            </span>
                            <div class="row hidden-desktop"></div>
                        </h3>
                    </div>
                    <div class="content">
                        
                        <!-- Estatísticas do Caixa -->
                        <div class="row caixa-stats">
                            <div class="col-md-3">
                                <div class="stats-box">
                                    <div class="stats-number" id="mesasAguardando">
                                        <?= $estatisticas ? $estatisticas->mesas_aguardando : 0 ?>
                                    </div>
                                    <div class="stats-label">Mesas Aguardando</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-box">
                                    <div class="stats-number" id="valorTotal" style="color: #28a745;">
                                        R$ <?= ($estatisticas && $estatisticas->valor_total_aguardando !== null) ? number_format(floatval($estatisticas->valor_total_aguardando), 2, ',', '.') : '0,00' ?>
                                    </div>
                                    <div class="stats-label">Valor Total Aguardando</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-box">
                                    <div class="stats-number" id="ticketMedio" style="color: #ffc107;">
                                        R$ <?= ($estatisticas && $estatisticas->ticket_medio !== null) ? number_format(floatval($estatisticas->ticket_medio), 2, ',', '.') : '0,00' ?>
                                    </div>
                                    <div class="stats-label">Ticket Médio</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stats-box">
                                    <div class="stats-number" id="totalPedidos" style="color: #17a2b8;">
                                        <?= ($estatisticas && $estatisticas->total_pedidos_aguardando !== null) ? intval($estatisticas->total_pedidos_aguardando) : 0 ?>
                                    </div>
                                    <div class="stats-label">Total de Pedidos</div>
                                </div>
                            </div>
                        </div>

                        <!-- Lista de Mesas Aguardando Fechamento -->
                        <div id="mesasContainer">
                            <?php if ($mesas_aguardando && count($mesas_aguardando) > 0): ?>
                                <div class="row">
                                    <?php foreach ($mesas_aguardando as $mesa): ?>
                                        <div class="col-md-6">
                                            <div class="mesa-card status-<?= $mesa->status_geral ?>">
                                                <div class="mesa-header">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h4 style="margin: 0;">
                                                                <i class="fa fa-table"></i> Mesa <?= $mesa->mesa_numero ?>
                                                                <?php if ($mesa->status_geral == 'entregue'): ?>
                                                                    <span class="label label-success">Pronta para Fechamento</span>
                                                                <?php elseif ($mesa->status_geral == 'pendente'): ?>
                                                                    <span class="label label-warning">Aguardando Entrega</span>
                                                                <?php else: ?>
                                                                    <span class="label label-danger">Verificar Status</span>
                                                                <?php endif; ?>
                                                            </h4>
                                                        </div>
                                                        <div class="col-md-6 text-right">
                                                            <div class="valor-total">
                                                                R$ <?= number_format(floatval($mesa->valor_total ?? 0), 2, ',', '.') ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="mesa-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <p><strong>Cliente:</strong> <?= htmlspecialchars($mesa->cliente_nome ?? 'N/I') ?></p>
                                                            <p><strong>Garçom:</strong> <?= htmlspecialchars($mesa->garcon_nome ?? 'N/I') ?></p>
                                                            <p><strong>Pessoas:</strong> <?= $mesa->numero_pessoas ?? 'N/I' ?></p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><strong>Localização:</strong> <?= htmlspecialchars($mesa->mesa_localizacao ?? 'N/I') ?></p>
                                                            <p><strong>Tempo de Ocupação:</strong> 
                                                               <span class="tempo-ocupacao"><?= $mesa->tempo_ocupacao ?></span>
                                                            </p>
                                                            <p><strong>Primeiro Pedido:</strong> 
                                                               <?= date('H:i', strtotime($mesa->primeiro_pedido)) ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h5><strong>Resumo dos Pedidos:</strong></h5>
                                                            <div class="table-responsive">
                                                                <table class="table table-sm table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Pedido</th>
                                                                            <th>Horário</th>
                                                                            <th>Status</th>
                                                                            <th>Valor</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php foreach ($mesa->pedidos as $pedido): ?>
                                                                            <tr>
                                                                                <td>#<?= $pedido->pedido_mesa_id ?></td>
                                                                                <td><?= date('H:i', strtotime($pedido->pedido_data)) ?></td>
                                                                                <td>
                                                                                    <?php
                                                                                    $status_colors = [
                                                                                        1 => 'label-warning',
                                                                                        2 => 'label-info', 
                                                                                        3 => 'label-primary',
                                                                                        4 => 'label-success',
                                                                                        5 => 'label-danger'
                                                                                    ];
                                                                                    $status_texts = [
                                                                                        1 => 'Pendente',
                                                                                        2 => 'Em Produção',
                                                                                        3 => 'Pronto',
                                                                                        4 => 'Entregue',
                                                                                        5 => 'Cancelado'
                                                                                    ];
                                                                                    $color = $status_colors[$pedido->pedido_status] ?? 'label-default';
                                                                                    $text = $status_texts[$pedido->pedido_status] ?? 'Indefinido';
                                                                                    ?>
                                                                                    <span class="label <?= $color ?>"><?= $text ?></span>
                                                                                </td>
                                                                                <td>R$ <?= number_format(floatval($pedido->pedido_total ?? 0), 2, ',', '.') ?></td>
                                                                            </tr>
                                                                        <?php endforeach; ?>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr class="active">
                                                                            <th colspan="3">Total da Mesa:</th>
                                                                            <th>R$ <?= number_format(floatval($mesa->valor_total ?? 0), 2, ',', '.') ?></th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                                                
                                                <div class="mesa-footer">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <small class="text-muted">
                                                                <i class="fa fa-clock-o"></i> Último movimento: 
                                                                <?= date('d/m/Y H:i', strtotime($mesa->ultimo_movimento)) ?>
                                                            </small>
                                                        </div>
                                                        <div class="col-md-6 text-right">
                                                            <?php if ($mesa->status_geral == 'entregue'): ?>
                                                                <a href="<?= $baseUri ?>/admin/caixa/fechar-mesa/<?= $mesa->mesa_id ?>/<?= $mesa->ocupacao_id ?>" 
                                                                   class="btn btn-fechar-mesa btn-sm">
                                                                    <i class="fa fa-money"></i> Fechar Mesa
                                                                </a>
                                                            <?php elseif ($mesa->status_geral == 'pendente'): ?>
                                                                <button class="btn btn-warning btn-sm" disabled>
                                                                    <i class="fa fa-clock-o"></i> Aguardando Entrega
                                                                </button>
                                                            <?php else: ?>
                                                                <button class="btn btn-danger btn-sm" disabled>
                                                                    <i class="fa fa-exclamation-triangle"></i> Verificar Mesa
                                                                </button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info alert-no-mesas">
                                    <h4><i class="fa fa-info-circle"></i> Nenhuma mesa aguardando fechamento</h4>
                                    <p>
                                        Não há mesas com pedidos entregues aguardando fechamento no momento.
                                        <br><br>
                                        <strong>Possíveis motivos:</strong>
                                    </p>
                                    <ul style="text-align: left; display: inline-block;">
                                        <li>Todas as mesas já foram fechadas</li>
                                        <li>Há mesas ocupadas mas os pedidos ainda não foram entregues pelos garçons</li>
                                        <li>Não há mesas ocupadas no momento</li>
                                    </ul>
                                    <br><br>
                                    <a href="<?= $baseUri ?>/mesa/" class="btn btn-primary">
                                        <i class="fa fa-table"></i> Ver Status das Mesas
                                    </a>
                                    <a href="<?= $baseUri ?>/garcon/" class="btn btn-info">
                                        <i class="fa fa-user"></i> Área do Garçom
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
        
        // Auto-refresh da página a cada 2 minutos
        setInterval(function() {
            atualizarDados();
        }, 120000);
        
        function atualizarDados() {
            $('#refreshTime').show();
            location.reload();
        }
        
        // Mostrar indicador de refresh se estiver recarregando
        $(document).ready(function() {
            // Hide refresh indicator after page load
            setTimeout(function() {
                $('#refreshTime').hide();
            }, 1000);
            
            // Add tooltips
            $('[data-toggle="tooltip"]').tooltip();
        });
        
        // Keyboard shortcuts
        $(document).keydown(function(e) {
            // F5 or Ctrl+R: Refresh
            if (e.which == 116 || (e.ctrlKey && e.which == 82)) {
                e.preventDefault();
                atualizarDados();
            }
        });
    </script>
</body>

</html>