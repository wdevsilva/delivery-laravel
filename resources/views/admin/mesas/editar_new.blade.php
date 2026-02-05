<?php extract($data); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once __DIR__ . '/../site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Editar Mesa - Sistema de Gerenciamento">
    <meta name="author" content="">
    <title>Editar Mesa <?php echo $mesa->mesa_numero ?? 'N/A'; ?> - <?php echo $config->config_nome; ?></title>
    
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
    <link href="css/btn-upload.css" rel="stylesheet" />
    <style>
        .edit-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }
        
        .edit-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20px;
            width: 100px;
            height: 200%;
            background: rgba(255,255,255,0.1);
            transform: rotate(15deg);
        }
        
        .edit-title {
            font-size: 3em;
            font-weight: 300;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .edit-subtitle {
            font-size: 1.2em;
            opacity: 0.9;
            margin-top: 10px;
        }
        
        .form-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 25px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .form-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .form-card-header {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
            font-weight: 600;
            font-size: 1.1em;
        }
        
        .form-card-body {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
            font-size: 1em;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            transform: translateY(-2px);
        }
        
        .help-block {
            color: #6c757d;
            font-size: 0.9em;
            margin-top: 5px;
        }
        
        .info-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 25px;
            overflow: hidden;
        }
        
        .info-card-header {
            background: linear-gradient(45deg, #f093fb, #f5576c);
            color: white;
            padding: 20px;
            font-weight: 600;
            font-size: 1.1em;
        }
        
        .info-card-body {
            padding: 25px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #495057;
        }
        
        .info-value {
            color: #6c757d;
        }
        
        .btn-action {
            border-radius: 25px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-right: 10px;
            margin-bottom: 10px;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .btn-save {
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            border: none;
            color: white;
        }
        
        .btn-back {
            background: linear-gradient(45deg, #ffecd2, #fcb69f);
            border: none;
            color: #333;
        }
        
        .btn-details {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            color: white;
        }
        
        .warning-card {
            background: linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            color: #2d3436;
        }
        
        .warning-list {
            list-style: none;
            padding: 0;
            margin: 15px 0 0 0;
        }
        
        .warning-list li {
            padding: 8px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 600;
        }
        
        .status-livre {
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            color: white;
        }
        
        .status-ocupada {
            background: linear-gradient(45deg, #fa709a, #fee140);
            color: white;
        }
        
        .status-reservada {
            background: linear-gradient(45deg, #a8edea, #fed6e3);
            color: #333;
        }
        
        .status-manutencao {
            background: linear-gradient(45deg, #d299c2, #fef9d7);
            color: #333;
        }
        
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-top: 10px;
        }
        
        .refresh-indicator {
            display: none;
            color: rgba(255,255,255,0.8);
        }
        
        .alert-error {
            background: linear-gradient(135deg, #ff7675 0%, #fd79a8 100%);
            color: white;
            border: none;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
        }
    </style>
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
                            <i class="fa fa-edit"></i> Editar Mesa
                            <small id="refreshTime" class="refresh-indicator">
                                <i class="fa fa-refresh fa-spin"></i> Atualizando...
                            </small>
                            <span class="pull-right">
                                <a href="<?php echo $baseUri; ?>/admin/mesa/lista" class="btn btn-default btn-sm">
                                    <i class="fa fa-list"></i> Lista
                                </a>
                                <a href="<?php echo $baseUri; ?>/admin/mesa/" class="btn btn-info btn-sm">
                                    <i class="fa fa-dashboard"></i> Dashboard
                                </a>
                            </span>
                            <div class="row hidden-desktop"></div>
                        </h3>
                    </div>
                    <div class="content">
                        
                        <?php if (!$mesa): ?>
                            <div class="alert alert-error">
                                <h3><i class="fa fa-exclamation-triangle"></i> Mesa não encontrada!</h3>
                                <p>A mesa solicitada não foi encontrada no sistema.</p>
                                <br>
                                <a href="<?= $baseUri ?>/admin/mesa/lista" class="btn btn-back btn-lg">
                                    <i class="fa fa-arrow-left"></i> Voltar para Lista
                                </a>
                            </div>
                        <?php else: ?>
                            <!-- Header da Mesa -->
                            <div class="edit-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h1 class="edit-title">Mesa <?= $mesa->mesa_numero ?></h1>
                                        <p class="edit-subtitle">
                                            <i class="fa fa-edit"></i> Editando configurações da mesa
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <?php
                                        $status_info = '';
                                        $status_class = '';
                                        switch ($mesa->mesa_status) {
                                            case 0: $status_info = 'Livre'; $status_class = 'status-livre'; break;
                                            case 1: $status_info = 'Ocupada'; $status_class = 'status-ocupada'; break;
                                            case 2: $status_info = 'Reservada'; $status_class = 'status-reservada'; break;
                                            case 3: $status_info = 'Manutenção'; $status_class = 'status-manutencao'; break;
                                        }
                                        ?>
                                        <div class="status-badge <?= $status_class ?>">
                                            <i class="fa fa-circle"></i> <?= $status_info ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <!-- Formulário de Edição -->
                                    <div class="form-card">
                                        <div class="form-card-header">
                                            <i class="fa fa-edit"></i> Dados da Mesa
                                        </div>
                                        <div class="form-card-body">
                                            <form method="POST" action="<?= $baseUri ?>/admin/mesa/gravar" id="editForm">
                                                <input type="hidden" name="mesa_id" value="<?= $mesa->mesa_id ?>">
                                                
                                                <div class="form-group">
                                                    <label for="mesa_numero">
                                                        <i class="fa fa-hashtag"></i> Número da Mesa *
                                                    </label>
                                                    <input type="text" class="form-control" id="mesa_numero" name="mesa_numero" 
                                                           value="<?= htmlspecialchars($mesa->mesa_numero) ?>" required>
                                                    <div class="help-block">Identificação única da mesa</div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="mesa_capacidade">
                                                        <i class="fa fa-users"></i> Capacidade *
                                                    </label>
                                                    <input type="number" class="form-control" id="mesa_capacidade" name="mesa_capacidade" 
                                                           min="1" max="20" value="<?= $mesa->mesa_capacidade ?>" required>
                                                    <div class="help-block">Número máximo de pessoas (1-20)</div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="mesa_localizacao">
                                                        <i class="fa fa-map-marker"></i> Localização *
                                                    </label>
                                                    <input type="text" class="form-control" id="mesa_localizacao" name="mesa_localizacao" 
                                                           value="<?= htmlspecialchars($mesa->mesa_localizacao) ?>" required>
                                                    <div class="help-block">Área ou setor onde a mesa está localizada</div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="mesa_observacao">
                                                        <i class="fa fa-comment"></i> Observações
                                                    </label>
                                                    <textarea class="form-control" id="mesa_observacao" name="mesa_observacao" 
                                                              rows="3" placeholder="Observações adicionais sobre a mesa..."><?= htmlspecialchars($mesa->mesa_observacao ?? '') ?></textarea>
                                                    <div class="help-block">Informações adicionais (opcional)</div>
                                                </div>

                                                <div class="form-group">
                                                    <label for="mesa_status">
                                                        <i class="fa fa-toggle-on"></i> Status
                                                    </label>
                                                    <select class="form-control" id="mesa_status" name="mesa_status">
                                                        <option value="0" <?= $mesa->mesa_status == 0 ? 'selected' : '' ?>>Livre</option>
                                                        <option value="1" <?= $mesa->mesa_status == 1 ? 'selected' : '' ?>>Ocupada</option>
                                                        <option value="2" <?= $mesa->mesa_status == 2 ? 'selected' : '' ?>>Reservada</option>
                                                        <option value="3" <?= $mesa->mesa_status == 3 ? 'selected' : '' ?>>Manutenção</option>
                                                    </select>
                                                    <div class="help-block">Altere com cuidado se a mesa estiver em uso</div>
                                                </div>

                                                <div class="checkbox-container">
                                                    <input type="checkbox" name="mesa_ativa" value="1" id="mesa_ativa"
                                                           <?= $mesa->mesa_ativa ? 'checked' : '' ?>>
                                                    <label for="mesa_ativa" style="margin: 0; font-weight: normal;">
                                                        <i class="fa fa-check-circle"></i> Mesa ativa no sistema
                                                    </label>
                                                </div>
                                                <div class="help-block" style="margin-top: 5px;">
                                                    Desmarque para inativar a mesa temporariamente
                                                </div>
                                                
                                                <div style="margin-top: 30px;">
                                                    <button type="submit" class="btn btn-action btn-save">
                                                        <i class="fa fa-save"></i> Salvar Alterações
                                                    </button>
                                                    <a href="<?= $baseUri ?>/admin/mesa/lista" class="btn btn-action btn-back">
                                                        <i class="fa fa-arrow-left"></i> Voltar
                                                    </a>
                                                    <a href="<?= $baseUri ?>/admin/mesa/detalhes/<?= $mesa->mesa_id ?>" class="btn btn-action btn-details">
                                                        <i class="fa fa-eye"></i> Ver Detalhes
                                                    </a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <!-- Informações Atuais -->
                                    <div class="info-card">
                                        <div class="info-card-header">
                                            <i class="fa fa-info-circle"></i> Informações Atuais
                                        </div>
                                        <div class="info-card-body">
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="fa fa-key"></i> ID da Mesa
                                                </span>
                                                <span class="info-value"><?= $mesa->mesa_id ?></span>
                                            </div>
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
                                                    <span class="status-badge <?= $status_class ?>"><?= $status_info ?></span>
                                                </span>
                                            </div>
                                            <div class="info-row">
                                                <span class="info-label">
                                                    <i class="fa fa-check-circle"></i> Ativa
                                                </span>
                                                <span class="info-value">
                                                    <?= $mesa->mesa_ativa ? '<span style="color: #28a745;">Sim</span>' : '<span style="color: #dc3545;">Não</span>' ?>
                                                </span>
                                            </div>
                                            
                                            <?php if (isset($mesa->ocupacao_id) && $mesa->ocupacao_id): ?>
                                                <div class="info-row">
                                                    <span class="info-label">
                                                        <i class="fa fa-user"></i> Cliente
                                                    </span>
                                                    <span class="info-value"><?= htmlspecialchars($mesa->ocupacao_cliente_nome ?? 'N/A') ?></span>
                                                </div>
                                                <div class="info-row">
                                                    <span class="info-label">
                                                        <i class="fa fa-user-md"></i> Garçom
                                                    </span>
                                                    <span class="info-value"><?= htmlspecialchars($mesa->garcon_nome ?? 'N/A') ?></span>
                                                </div>
                                            <?php elseif (isset($mesa->reserva_id) && $mesa->reserva_id): ?>
                                                <div class="info-row">
                                                    <span class="info-label">
                                                        <i class="fa fa-calendar"></i> Reserva
                                                    </span>
                                                    <span class="info-value"><?= htmlspecialchars($mesa->reserva_cliente_nome ?? 'N/A') ?></span>
                                                </div>
                                                <div class="info-row">
                                                    <span class="info-label">
                                                        <i class="fa fa-clock-o"></i> Horário
                                                    </span>
                                                    <span class="info-value"><?= $mesa->reserva_hora_inicio ? date('H:i', strtotime($mesa->reserva_hora_inicio)) : 'N/A' ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Avisos Importantes -->
                                    <div class="warning-card">
                                        <h4 style="margin-top: 0;">
                                            <i class="fa fa-exclamation-triangle"></i> Atenção
                                        </h4>
                                        <p>Tenha cuidado ao fazer alterações nesta mesa:</p>
                                        <ul class="warning-list">
                                            <li>
                                                <i class="fa fa-warning" style="color: #e17055;"></i>
                                                Alterar o número pode causar confusão
                                            </li>
                                            <li>
                                                <i class="fa fa-users" style="color: #0984e3;"></i>
                                                Reduza a capacidade com cuidado
                                            </li>
                                            <li>
                                                <i class="fa fa-ban" style="color: #d63031;"></i>
                                                Inativar remove a mesa do sistema
                                            </li>
                                            <li>
                                                <i class="fa fa-info" style="color: #00b894;"></i>
                                                Mudanças são aplicadas imediatamente
                                            </li>
                                            <?php if ($mesa->mesa_status == 1): ?>
                                            <li>
                                                <i class="fa fa-exclamation-circle" style="color: #fd79a8;"></i>
                                                Mesa está ocupada - cuidado especial!
                                            </li>
                                            <?php endif; ?>
                                        </ul>
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
        
        $(document).ready(function() {
            $('#editForm').on('submit', function(e) {
                var numero = $('#mesa_numero').val().trim();
                var capacidade = parseInt($('#mesa_capacidade').val());
                var localizacao = $('#mesa_localizacao').val().trim();
                
                
                if (!numero || !capacidade || !localizacao) {
                    console.error('[' + new Date().toLocaleString() + '] Validation failed: Missing required fields');
                    alert('Por favor, preencha todos os campos obrigatórios.');
                    e.preventDefault();
                    return false;
                }
                
                if (capacidade < 1 || capacidade > 20) {
                    console.error('[' + new Date().toLocaleString() + '] Validation failed: Invalid capacity');
                    alert('A capacidade deve ser entre 1 e 20 pessoas.');
                    e.preventDefault();
                    return false;
                }
                
                var statusOriginal = <?= $mesa->mesa_status ?? 0 ?>;
                var statusNovo = parseInt($('#mesa_status').val());
                
                if (statusOriginal !== statusNovo && (statusOriginal === 1 || statusNovo === 1)) {
                    if (!confirm('Você está alterando o status de uma mesa ocupada. Confirma?')) {
                        e.preventDefault();
                        return false;
                    }
                }
                
                return true;
            });
            
            // Keyboard shortcuts
            $(document).keydown(function(e) {
                // Ctrl+S: Save form
                if (e.ctrlKey && e.which == 83) {
                    e.preventDefault();
                    $('#editForm').submit();
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