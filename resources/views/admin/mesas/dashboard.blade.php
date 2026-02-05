<?php extract($data); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php require_once __DIR__ . '/../site-base.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Mesas - <?php echo $config->config_nome; ?></title>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery.select2/dist/css/select2.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Open Sans', sans-serif;
        }

        .main-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .mesa-stats {
            margin-bottom: 30px;
        }

        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .stats-number {
            font-size: 3em;
            font-weight: 700;
            margin-bottom: 5px;
            line-height: 1;
        }

        .stats-label {
            color: #6c757d;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .stats-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 3em;
            opacity: 0.1;
        }

        .stats-livres {
            color: #28a745;
        }

        .stats-ocupadas {
            color: #dc3545;
        }

        .stats-reservadas {
            color: #ffc107;
        }

        .stats-manutencao {
            color: #6c757d;
        }

        .mesa-card {
            background: white;
            border-radius: 15px;
            margin-bottom: 25px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .mesa-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .mesa-livres {
            border-left: 5px solid #28a745;
        }

        .mesa-ocupadas {
            border-left: 5px solid #dc3545;
        }

        .mesa-reservadas {
            border-left: 5px solid #ffc107;
        }

        .mesa-manutencao {
            border-left: 5px solid #6c757d;
        }

        .mesa-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .mesa-numero {
            font-size: 2.2em;
            font-weight: 700;
            color: #495057;
            margin: 0;
        }

        .mesa-status {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-livre {
            background: #d4edda;
            color: #155724;
        }

        .status-ocupada {
            background: #f8d7da;
            color: #721c24;
        }

        .status-reservada {
            background: #fff3cd;
            color: #856404;
        }

        .status-manutencao {
            background: #e2e3e5;
            color: #383d41;
        }

        .mesa-body {
            padding: 20px;
        }

        .mesa-info {
            margin-bottom: 15px;
        }

        .mesa-info strong {
            color: #495057;
            display: inline-block;
            width: 100px;
        }

        .mesa-actions {
            padding: 15px 20px;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
        }

        .btn-mesa {
            border-radius: 20px;
            padding: 8px 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-right: 8px;
            margin-bottom: 5px;
        }

        .btn-ocupar {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            color: white;
        }

        .btn-reservar {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            border: none;
            color: white;
        }

        .btn-liberar {
            background: linear-gradient(135deg, #dc3545, #e83e8c);
            border: none;
            color: white;
        }

        .btn-manutencao {
            background: linear-gradient(135deg, #6c757d, #495057);
            border: none;
            color: white;
        }

        .reservas-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .section-title {
            font-size: 1.4em;
            font-weight: 700;
            color: #495057;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 10px;
            color: #667eea;
        }

        .filters-section {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .filter-btn {
            border-radius: 25px;
            padding: 10px 20px;
            margin: 5px;
            border: 2px solid #e9ecef;
            background: white;
            color: #495057;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .filter-btn.active,
        .filter-btn:hover {
            border-color: #667eea;
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .action-buttons {
            text-align: right;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 25px;
            padding: 12px 25px;
            font-weight: 600;
            margin-left: 10px;
        }

        .btn-success-custom {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 25px;
            padding: 12px 25px;
            font-weight: 600;
        }

        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }

        .loading-spinner {
            text-align: center;
        }

        .spinner {
            width: 60px;
            height: 60px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 15px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .refresh-indicator {
            color: #667eea;
            margin-left: 10px;
        }

        .mesa-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .mesa-grid {
                grid-template-columns: 1fr;
            }

            .stats-card {
                text-align: center;
            }

            .action-buttons {
                text-align: center;
                margin-top: 15px;
            }
        }

        .no-mesas {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .no-mesas i {
            font-size: 4em;
            margin-bottom: 20px;
            color: #e9ecef;
        }
    </style>
</head>

<body class="animated">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner">
            <div class="spinner"></div>
            <p>Atualizando dados...</p>
        </div>
    </div>

    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php require_once __DIR__ . '/../side-menu.php'; ?>
        </div>

        <div class="container-fluid" id="pcont">
            <div class="cl-mcont">
                <div class="block-flat">
                    <div class="header">
                        <h3>
                            <i class="fa fa-table"></i> Sistema de Mesas
                            <small>Gerenciamento em tempo real</small>
                            <small id="refreshTime" class="refresh-indicator" style="display: none;">
                                <i class="fa fa-refresh fa-spin"></i> Atualizando...
                            </small>
                            <span class="pull-right action-buttons">
                                <button class="btn btn-success-custom btn-sm" onclick="atualizarMesas()">
                                    <i class="fa fa-refresh"></i> Atualizar
                                </button>
                                <a href="<?php echo $baseUri; ?>/mesa/novo" class="btn btn-primary-custom btn-sm">
                                    <i class="fa fa-plus"></i> Nova Mesa
                                </a>
                                <a href="<?php echo $baseUri; ?>/caixa/" class="btn btn-primary-custom btn-sm">
                                    <i class="fa fa-money"></i> Caixa
                                </a>
                            </span>
                        </h3>
                    </div>

                    <div class="content fade-in">
                        <!-- Estatísticas das Mesas -->
                        <div class="row mesa-stats">
                            <div class="col-lg-3 col-md-6">
                                <div class="stats-card">
                                    <div class="stats-number stats-livres" id="mesas-livres"><?php echo $estatisticas->livres ?? 0; ?></div>
                                    <div class="stats-label">Mesas Livres</div>
                                    <i class="fa fa-check-circle stats-icon stats-livres"></i>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="stats-card">
                                    <div class="stats-number stats-ocupadas" id="mesas-ocupadas"><?php echo $estatisticas->ocupadas ?? 0; ?></div>
                                    <div class="stats-label">Mesas Ocupadas</div>
                                    <i class="fa fa-users stats-icon stats-ocupadas"></i>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="stats-card">
                                    <div class="stats-number stats-reservadas" id="mesas-reservadas"><?php echo $estatisticas->reservadas ?? 0; ?></div>
                                    <div class="stats-label">Mesas Reservadas</div>
                                    <i class="fa fa-clock-o stats-icon stats-reservadas"></i>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="stats-card">
                                    <div class="stats-number stats-manutencao" id="mesas-manutencao"><?php echo $estatisticas->manutencao ?? 0; ?></div>
                                    <div class="stats-label">Manutenção</div>
                                    <i class="fa fa-wrench stats-icon stats-manutencao"></i>
                                </div>
                            </div>
                        </div>
                        <!-- Reservas de Hoje -->
                        <div class="reservas-section">
                            <div class="section-title">
                                <i class="fa fa-calendar"></i> Reservas de Hoje
                            </div>
                            <div id="reservas-container">
                                <?php if (!empty($reservas_hoje)): ?>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Mesa</th>
                                                    <th>Cliente</th>
                                                    <th>Telefone</th>
                                                    <th>Pessoas</th>
                                                    <th>Horário</th>
                                                    <th>Status</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($reservas_hoje as $reserva): ?>
                                                    <tr>
                                                        <td><strong>Mesa <?php echo $reserva->mesa_numero; ?></strong></td>
                                                        <td><?php echo $reserva->cliente_nome; ?></td>
                                                        <td><?php echo $reserva->cliente_telefone ?: 'N/A'; ?></td>
                                                        <td><?php echo $reserva->numero_pessoas; ?></td>
                                                        <td><?php echo date('H:i', strtotime($reserva->hora_inicio)); ?></td>
                                                        <td>
                                                            <?php if ($reserva->status == 1): ?>
                                                                <span class="label label-warning">Pendente</span>
                                                            <?php elseif ($reserva->status == 2): ?>
                                                                <span class="label label-success">Confirmada</span>
                                                            <?php else: ?>
                                                                <span class="label label-danger">Cancelada</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($reserva->status == 1): ?>
                                                                <span class="text-muted">
                                                                    <i class="fa fa-info-circle"></i> Aguardando confirmação do garçom
                                                                </span>
                                                                <button class="btn btn-danger btn-xs" onclick="cancelarReserva(<?php echo $reserva->reserva_id; ?>)">
                                                                    <i class="fa fa-times"></i> Cancelar
                                                                </button>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <div class="no-mesas">
                                        <i class="fa fa-calendar-o"></i>
                                        <h4>Nenhuma reserva para hoje</h4>
                                        <p>Não há reservas agendadas para hoje.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Filtros -->
                        <div class="filters-section">
                            <div class="section-title">
                                <i class="fa fa-filter"></i> Filtros
                                <span class="pull-right action-buttons">
                                    <button class="btn btn-success-custom btn-sm" onclick="atualizarMesas()">
                                        <i class="fa fa-refresh"></i> Atualizar
                                    </button>
                                </span>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn filter-btn active" onclick="filtrarMesas('todas')">
                                    <i class="fa fa-table"></i> Todas
                                </button>
                                <button type="button" class="btn filter-btn" onclick="filtrarMesas('livres')">
                                    <i class="fa fa-check-circle"></i> Livres
                                </button>
                                <button type="button" class="btn filter-btn" onclick="filtrarMesas('ocupadas')">
                                    <i class="fa fa-users"></i> Ocupadas
                                </button>
                                <button type="button" class="btn filter-btn" onclick="filtrarMesas('reservadas')">
                                    <i class="fa fa-clock-o"></i> Reservadas
                                </button>
                                <button type="button" class="btn filter-btn" onclick="filtrarMesas('manutencao')">
                                    <i class="fa fa-wrench"></i> Manutenção
                                </button>
                            </div>
                        </div>
                        <!-- Mesas -->
                        <div id="mesas-container">
                            <?php if (!empty($mesas)): ?>
                                <div class="mesa-grid">
                                    <?php foreach ($mesas as $mesa): ?>
                                        <?php
                                        $status_class = '';
                                        $status_label = '';
                                        $status_color = '';

                                        switch ($mesa->mesa_status) {
                                            case 0: // Livre
                                                $status_class = 'livres';
                                                $status_label = 'Livre';
                                                $status_color = 'livre';
                                                break;
                                            case 1: // Ocupada
                                                $status_class = 'ocupadas';
                                                $status_label = 'Ocupada';
                                                $status_color = 'ocupada';
                                                break;
                                            case 2: // Reservada
                                                $status_class = 'reservadas';
                                                $status_label = 'Reservada';
                                                $status_color = 'reservada';
                                                break;
                                            case 3: // Manutenção
                                                $status_class = 'manutencao';
                                                $status_label = 'Manutenção';
                                                $status_color = 'manutencao';
                                                break;
                                        }
                                        ?>
                                        <div class="mesa-item mesa-<?php echo $status_class; ?>" data-status="<?php echo $status_class; ?>">
                                            <div class="mesa-card mesa-<?php echo $status_class; ?>">
                                                <div class="mesa-header">
                                                    <div class="row">
                                                        <div class="col-xs-6">
                                                            <h2 class="mesa-numero">Mesa <?php echo $mesa->mesa_numero; ?></h2>
                                                        </div>
                                                        <div class="col-xs-6 text-right">
                                                            <span class="mesa-status status-<?php echo $status_color; ?>">
                                                                <?php echo $status_label; ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mesa-body">
                                                    <div class="mesa-info">
                                                        <strong>Capacidade:</strong> <?php echo $mesa->mesa_capacidade; ?> pessoas
                                                    </div>
                                                    <div class="mesa-info">
                                                        <strong>Localização:</strong> <?php echo $mesa->mesa_localizacao; ?>
                                                    </div>

                                                    <?php if ($mesa->mesa_status == 1 && !empty($mesa->ocupacao_cliente_nome)): // Ocupada 
                                                    ?>
                                                        <hr>
                                                        <div class="mesa-info">
                                                            <strong>Cliente:</strong> <?php echo $mesa->ocupacao_cliente_nome; ?>
                                                        </div>
                                                        <div class="mesa-info">
                                                            <strong>Garçom:</strong> <?php echo $mesa->garcon_nome ?? 'N/A'; ?>
                                                        </div>
                                                        <div class="mesa-info">
                                                            <strong>Desde:</strong> <?php echo date('H:i', strtotime($mesa->ocupacao_inicio)); ?>
                                                        </div>
                                                        <?php if (!empty($mesa->ocupacao_numero_pessoas)): ?>
                                                            <div class="mesa-info">
                                                                <strong>Pessoas:</strong> <?php echo $mesa->ocupacao_numero_pessoas; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php elseif ($mesa->mesa_status == 2): // Reservada 
                                                    ?>
                                                        <hr>
                                                        <?php if (!empty($mesa->reserva_cliente_nome)): ?>
                                                            <div class="mesa-info">
                                                                <strong>Cliente:</strong> <?php echo $mesa->reserva_cliente_nome; ?>
                                                            </div>
                                                            <div class="mesa-info">
                                                                <strong>Telefone:</strong> <?php echo $mesa->reserva_cliente_telefone ?: 'N/A'; ?>
                                                            </div>
                                                            <div class="mesa-info">
                                                                <strong>Pessoas:</strong> <?php echo $mesa->reserva_numero_pessoas; ?>
                                                            </div>
                                                            <div class="mesa-info">
                                                                <strong>Horário:</strong> <?php echo date('H:i', strtotime($mesa->reserva_hora_inicio)); ?>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="mesa-info text-muted">
                                                                <i class="fa fa-clock-o"></i> Reserva sem detalhes
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php elseif ($mesa->mesa_status == 3): // Manutenção 
                                                    ?>
                                                        <hr>
                                                        <div class="mesa-info text-muted">
                                                            <i class="fa fa-wrench"></i> Mesa em manutenção
                                                        </div>
                                                        <div class="mesa-info">
                                                            <small>Indisponível para uso</small>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="mesa-actions">
                                                    <?php if ($mesa->mesa_status == 0): // Livre 
                                                    ?>
                                                        <button class="btn btn-mesa btn-reservar" onclick="novaReserva(<?php echo $mesa->mesa_id; ?>)">
                                                            <i class="fa fa-clock-o"></i> Reservar
                                                        </button>
                                                        <button class="btn btn-mesa btn-manutencao" onclick="colocarManutencao(<?php echo $mesa->mesa_id; ?>)">
                                                            <i class="fa fa-wrench"></i> Manutenção
                                                        </button>
                                                    <?php elseif ($mesa->mesa_status == 1): // Ocupada 
                                                    ?>
                                                        <a href="<?php echo $baseUri; ?>/garcon/pedidos-mesa/<?php echo $mesa->mesa_id; ?>" class="btn btn-mesa btn-ocupar">
                                                            <i class="fa fa-cutlery"></i> Ver Pedidos
                                                        </a>
                                                        <button class="btn btn-mesa btn-liberar" onclick="liberarMesa(<?php echo $mesa->mesa_id; ?>, <?php echo $mesa->ocupacao_id ?? 0; ?>)">
                                                            <i class="fa fa-check"></i> Liberar
                                                        </button>
                                                    <?php elseif ($mesa->mesa_status == 2): // Reservada 
                                                    ?>
                                                        <button class="btn btn-mesa btn-liberar" onclick="cancelarReservaMesa(<?php echo $mesa->mesa_id; ?>)">
                                                            <i class="fa fa-times"></i> Cancelar
                                                        </button>
                                                    <?php elseif ($mesa->mesa_status == 3): // Manutenção 
                                                    ?>
                                                        <button class="btn btn-mesa btn-ocupar" onclick="liberarManutencao(<?php echo $mesa->mesa_id; ?>)">
                                                            <i class="fa fa-check"></i> Liberar Manutenção
                                                        </button>
                                                    <?php endif; ?>
                                                    <div style="margin-top: 10px;">
                                                        <button class="btn btn-mesa btn-default" onclick="verDetalhes(<?php echo $mesa->mesa_id; ?>)">
                                                            <i class="fa fa-eye"></i> Detalhes
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="no-mesas">
                                    <i class="fa fa-table"></i>
                                    <h4>Nenhuma mesa cadastrada</h4>
                                    <p>Comece criando sua primeira mesa para gerenciar seu restaurante.</p>
                                    <a href="<?php echo $baseUri; ?>/mesa/novo" class="btn btn-primary-custom">
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
    <button class="btn btn-primary btn-lg refresh-btn" onclick="atualizarMesas()" title="Atualizar Mesas">
        <i class="fa fa-refresh"></i>
    </button>

    <!-- Scripts -->
    <script src="<?php echo $baseUri; ?>/assets/vendor/jquery/jquery-2.1.4.min.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.cooki/jquery.cooki.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.ui/jquery-ui.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.gritter/js/jquery.gritter.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/behaviour/core.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.select2/dist/js/select2.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.maskedinput/jquery.maskedinput.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.mask.js"></script>

    <?php require_once __DIR__ . '/../switch-color.php'; ?>
    <script src="<?php echo $baseUri; ?>/view/admin/app-js/main.js"></script>

    <script>
       var baseUri = '<?= $baseUri; ?>';
        
        function atualizarMesas() {
            location.reload();
        }
        
        function filtrarMesas(status) {
            $('.filter-btn').removeClass('active');
            $('button[onclick="filtrarMesas(\'' + status + '\')"]').addClass('active');
            
            if (status === 'todas') {
                $('.mesa-item').fadeIn();
            } else {
                $('.mesa-item').hide();
                $('.mesa-' + status).fadeIn();
            }
        }
        
        function liberarMesa(mesaId) {
            if (confirm('Deseja liberar esta mesa?')) {
                $.post(baseUri + '/admin/mesa/liberar', {
                    mesa_id: mesaId
                }, function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        atualizarMesas();
                    } else {
                        alert('Erro: ' + response.message);
                    }
                }).fail(function() {
                    alert('Erro ao comunicar com o servidor');
                });
            }
        }
        
        function verDetalhes(mesaId) {
            window.location.href = baseUri + '/mesa/detalhes/' + mesaId;
        }
        
        function colocarManutencao(mesaId) {
            if (confirm('Deseja colocar esta mesa em manutenção?')) {
                $.post(baseUri + '/admin/mesa/atualizar-status', {
                    mesa_id: mesaId,
                    status: 3
                }, function(response) {
                    if (response.status === 'success') {
                        alert('Mesa colocada em manutenção!');
                        atualizarMesas();
                    } else {
                        alert('Erro: ' + response.message);
                    }
                }).fail(function() {
                    alert('Erro ao comunicar com o servidor');
                });
            }
        }
        
        function liberarManutencao(mesaId) {
            if (confirm('Deseja liberar esta mesa da manutenção?')) {
                $.post(baseUri + '/admin/mesa/atualizar-status', {
                    mesa_id: mesaId,
                    status: 0
                }, function(response) {
                    if (response.status === 'success') {
                        alert('Mesa liberada da manutenção!');
                        atualizarMesas();
                    } else {
                        alert('Erro: ' + response.message);
                    }
                }).fail(function() {
                    alert('Erro ao comunicar com o servidor');
                });
            }
        }
        
        function confirmarReservaMesa(mesaId) {
            if (confirm('Confirmar chegada do cliente para esta reserva?')) {
                $.post(baseUri + '/garcon/confirmar-reserva-mesa', {
                    mesa_id: mesaId
                }, function(response) {
                    if (response.status === 'success') {
                        alert('Reserva confirmada com sucesso!');
                        atualizarMesas();
                    } else {
                        alert('Erro: ' + response.message);
                    }
                }).fail(function() {
                    alert('Erro ao comunicar com o servidor');
                });
            }
        }
        
        function cancelarReservaMesa(mesaId) {
            if (confirm('Deseja cancelar esta reserva?')) {
                $.post(baseUri + '/garcon/cancelar-reserva-mesa', {
                    mesa_id: mesaId
                }, function(response) {
                    if (response.status === 'success') {
                        alert('Reserva cancelada com sucesso!');
                        atualizarMesas();
                    } else {
                        alert('Erro: ' + response.message);
                    }
                }).fail(function() {
                    alert('Erro ao comunicar com o servidor');
                });
            }
        }
        
        function novaReserva(mesaId) {
            
            if (confirm('Deseja criar uma nova reserva?')) {
                
                var clienteNome = prompt('Nome do cliente:');
                
                if (clienteNome && clienteNome.trim()) {
                    var clienteTelefone = prompt('Telefone do cliente (formato: (85) 99999-9999):') || '';
                    
                    // Apply phone mask if provided
                    if (clienteTelefone) {
                        clienteTelefone = clienteTelefone.replace(/\D/g, '');
                        if (clienteTelefone.length === 11) {
                            clienteTelefone = '(' + clienteTelefone.substr(0, 2) + ') ' + clienteTelefone.substr(2, 5) + '-' + clienteTelefone.substr(7);
                        } else if (clienteTelefone.length === 10) {
                            clienteTelefone = '(' + clienteTelefone.substr(0, 2) + ') ' + clienteTelefone.substr(2, 4) + '-' + clienteTelefone.substr(6);
                        }
                    }
                    
                    var numeroPessoas = prompt('Número de pessoas (1-20):');
                    if (!numeroPessoas || isNaN(numeroPessoas) || numeroPessoas < 1 || numeroPessoas > 20) {
                        alert('Número de pessoas deve ser entre 1 e 20.');
                        return;
                    }
                    
                    // Default to today's date
                    var hoje = new Date().toISOString().substr(0, 10);
                    var dataReserva = prompt('Data da reserva (AAAA-MM-DD):', hoje);
                    if (!dataReserva || !dataReserva.match(/^\d{4}-\d{2}-\d{2}$/)) {
                        alert('Data deve estar no formato AAAA-MM-DD (ex: 2024-01-15)');
                        return;
                    }
                    
                    // Default to current time + 1 hour
                    var agora = new Date();
                    agora.setHours(agora.getHours() + 1);
                    var horaDefault = agora.getHours().toString().padStart(2, '0') + ':' + agora.getMinutes().toString().padStart(2, '0');
                    var horaInicio = prompt('Horário (HH:MM):', horaDefault);
                    if (!horaInicio || !horaInicio.match(/^\d{2}:\d{2}$/)) {
                        alert('Horário deve estar no formato HH:MM (ex: 19:30)');
                        return;
                    }
                    
                    $.post(baseUri + '/admin/mesa/criar-reserva', {
                        cliente_nome: clienteNome.trim(),
                        cliente_telefone: clienteTelefone,
                        numero_pessoas: parseInt(numeroPessoas),
                        data_reserva: dataReserva,
                        hora_inicio: horaInicio,
                        mesa_id: mesaId
                    }, function(response) {
                        
                        try {
                            if (typeof response === 'string') {
                                response = JSON.parse(response);
                            }
                            if (response && response.status === 'success') {
                                alert('Reserva criada com sucesso! Mesa: ' + (response.mesa_id || 'A definir'));
                                atualizarMesas();
                            } else {
                                var errorMsg = response && response.message ? response.message : 'Erro desconhecido ao criar reserva';
                                alert('Erro: ' + errorMsg);
                                console.error('[' + new Date().toLocaleString() + '] Erro na reserva:', response);
                            }
                        } catch (e) {
                            console.error('[' + new Date().toLocaleString() + '] Erro ao processar resposta:', e, response);
                            alert('Erro: Resposta inválida do servidor');
                        }
                    }).fail(function(xhr, status, error) {
                        console.error('[' + new Date().toLocaleString() + '] Falha na requisição:', xhr.responseText, status, error);
                        alert('Erro ao comunicar com o servidor: ' + (xhr.responseText || error));
                    });
                } else {
                    alert('Nome do cliente é obrigatório.');
                }
            }
        }
        
        function cancelarReserva(reservaId) {
            if (!reservaId) {
                alert('ID da reserva não fornecido.');
                return;
            }
            
            if (confirm('Cancelar esta reserva?')) {
                $.post(baseUri + '/admin/mesa/cancelar-reserva', {
                    reserva_id: reservaId
                }, function(response) {
                    try {
                        if (typeof response === 'string') {
                            response = JSON.parse(response);
                        }
                        if (response && response.status === 'success') {
                            alert('Reserva cancelada com sucesso!');
                            atualizarMesas();
                        } else {
                            var errorMsg = response && response.message ? response.message : 'Erro desconhecido ao cancelar reserva';
                            alert('Erro: ' + errorMsg);
                            console.error('[' + new Date().toLocaleString() + '] Erro ao cancelar reserva:', response);
                        }
                    } catch (e) {
                        console.error('[' + new Date().toLocaleString() + '] Erro ao processar resposta:', e, response);
                        alert('Erro: Resposta inválida do servidor');
                    }
                }).fail(function(xhr, status, error) {
                    console.error('[' + new Date().toLocaleString() + '] Falha na requisição:', xhr.responseText, status, error);
                    alert('Erro ao comunicar com o servidor: ' + (xhr.responseText || error));
                });
            }
        }
        
        // Auto-refresh a cada 2 minutos
        setInterval(function() {
            atualizarMesas();
        }, 120000);
    </script>
</body>

</html>