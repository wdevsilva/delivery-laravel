<?php extract($data); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once __DIR__ . '/../site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Nova Mesa - Sistema de Gerenciamento">
    <meta name="author" content="">
    <title>Nova Mesa - <?php echo $config->config_nome; ?></title>
    
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
    <link href="css/mesa-novo.css" rel="stylesheet" />
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
                            <i class="fa fa-plus"></i> Nova Mesa
                            <small id="refreshTime" class="refresh-indicator">
                                <i class="fa fa-refresh fa-spin"></i> Criando...
                            </small>
                            <span class="pull-right">
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
                        
                        <!-- Header da Nova Mesa -->
                        <div class="create-header">
                            <div class="row">
                                <div class="col-md-8">
                                    <h1 class="create-title">Nova Mesa</h1>
                                    <p class="create-subtitle">
                                        <i class="fa fa-plus"></i> Criando uma nova mesa no sistema
                                    </p>
                                </div>
                                <div class="col-md-4 text-right">
                                    <div class="status-badge status-livre">
                                        <i class="fa fa-plus-circle"></i> Pronta para Criar
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Error Message Area -->
                        <div id="errorMessage" class="error-message">
                            <i class="fa fa-exclamation-triangle"></i>
                            <span id="errorText"></span>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-8">
                                <!-- Formulário de Criação -->
                                <div class="form-card">
                                    <div class="form-card-header">
                                        <i class="fa fa-plus"></i> Dados da Nova Mesa
                                    </div>
                                    <div class="form-card-body">
                                        <form method="POST" action="<?= $baseUri ?>/admin/mesa/gravar" id="createForm">
                                            
                                            <div class="form-group">
                                                <label for="mesa_numero">
                                                    <i class="fa fa-hashtag"></i> Número da Mesa *
                                                </label>
                                                <input type="text" class="form-control" id="mesa_numero" name="mesa_numero" 
                                                       placeholder="Ex: 01, 02, A1, B2..." required>
                                                <div class="help-block">Identificação única da mesa no sistema</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="mesa_capacidade">
                                                    <i class="fa fa-users"></i> Capacidade *
                                                </label>
                                                <input type="number" class="form-control" id="mesa_capacidade" name="mesa_capacidade" 
                                                       min="1" max="20" placeholder="4" required>
                                                <div class="help-block">Número máximo de pessoas (1-20)</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="mesa_localizacao">
                                                    <i class="fa fa-map-marker"></i> Localização *
                                                </label>
                                                <input type="text" class="form-control" id="mesa_localizacao" name="mesa_localizacao" 
                                                       placeholder="Ex: Salão Principal, Varanda, VIP..." required>
                                                <div class="help-block">Área ou setor onde a mesa está localizada</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="mesa_observacao">
                                                    <i class="fa fa-comment"></i> Observações
                                                </label>
                                                <textarea class="form-control" id="mesa_observacao" name="mesa_observacao" 
                                                          rows="3" placeholder="Observações especiais sobre a mesa..."></textarea>
                                                <div class="help-block">Informações adicionais sobre a mesa (opcional)</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="mesa_status">
                                                    <i class="fa fa-toggle-on"></i> Status Inicial
                                                </label>
                                                <select class="form-control" id="mesa_status" name="mesa_status">
                                                    <option value="0" selected>Livre</option>
                                                    <option value="3">Manutenção</option>
                                                </select>
                                                <div class="help-block">Status inicial da mesa após criação</div>
                                            </div>

                                            <div class="checkbox-container">
                                                <input type="checkbox" name="mesa_ativa" value="1" id="mesa_ativa" checked>
                                                <label for="mesa_ativa" style="margin: 0; font-weight: normal;">
                                                    <i class="fa fa-check-circle"></i> Mesa ativa no sistema
                                                </label>
                                            </div>
                                            <div class="help-block" style="margin-top: 5px;">
                                                Desmarque para criar mesa inativa temporariamente
                                            </div>
                                            
                                            <div style="margin-top: 30px;">
                                                <button type="submit" class="btn btn-action btn-create">
                                                    <i class="fa fa-plus"></i> Criar Mesa
                                                </button>
                                                <a href="<?= $baseUri ?>/mesa/lista" class="btn btn-action btn-back">
                                                    <i class="fa fa-arrow-left"></i> Voltar para Lista
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <!-- Dicas Úteis -->
                                <div class="info-card">
                                    <div class="info-card-header">
                                        <i class="fa fa-lightbulb-o"></i> Dicas Úteis
                                    </div>
                                    <div class="info-card-body">
                                        <ul class="tip-list">
                                            <li>
                                                <i class="fa fa-hashtag tip-icon" style="color: #f39c12;"></i>
                                                <div>
                                                    <strong>Numeração:</strong><br>
                                                    Use números sequenciais ou códigos alfanuméricos
                                                </div>
                                            </li>
                                            <li>
                                                <i class="fa fa-users tip-icon" style="color: #3498db;"></i>
                                                <div>
                                                    <strong>Capacidade:</strong><br>
                                                    Considere o espaço real e conforto dos clientes
                                                </div>
                                            </li>
                                            <li>
                                                <i class="fa fa-map-marker tip-icon" style="color: #27ae60;"></i>
                                                <div>
                                                    <strong>Localização:</strong><br>
                                                    Seja específico para facilitar a identificação
                                                </div>
                                            </li>
                                            <li>
                                                <i class="fa fa-wrench tip-icon" style="color: #e67e22;"></i>
                                                <div>
                                                    <strong>Manutenção:</strong><br>
                                                    Crie em manutenção se precisar configurar depois
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Status das Mesas -->
                                <div class="info-card">
                                    <div class="info-card-header">
                                        <i class="fa fa-info-circle"></i> Status das Mesas
                                    </div>
                                    <div class="info-card-body">
                                        <div class="status-badges">
                                            <div class="status-item">
                                                <span class="status-badge status-livre">Livre</span>
                                                <small>Disponível para uso</small>
                                            </div>
                                            <div class="status-item">
                                                <span class="status-badge status-ocupada">Ocupada</span>
                                                <small>Em uso por clientes</small>
                                            </div>
                                            <div class="status-item">
                                                <span class="status-badge status-reservada">Reservada</span>
                                                <small>Reserva confirmada</small>
                                            </div>
                                            <div class="status-item">
                                                <span class="status-badge status-manutencao">Manutenção</span>
                                                <small>Fora de operação</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
        
        // Show error message function
        function showError(message) {
            var errorDiv = $('#errorMessage');
            var errorText = $('#errorText');
            
            console.error('[' + new Date().toLocaleString() + '] Form Error: ' + message);
            
            errorText.text(message);
            errorDiv.show().addClass('success-animation');
            
            // Auto hide after 5 seconds
            setTimeout(function() {
                errorDiv.fadeOut();
            }, 5000);
        }
        
        // Hide error message function
        function hideError() {
            $('#errorMessage').hide();
        }
        
        $(document).ready(function() {
            
            // Form validation
            $('#createForm').on('submit', function(e) {
                hideError();
                
                var numero = $('#mesa_numero').val().trim();
                var capacidade = parseInt($('#mesa_capacidade').val());
                var localizacao = $('#mesa_localizacao').val().trim();
                
                
                // Validate required fields
                if (!numero || !capacidade || !localizacao) {
                    showError('Por favor, preencha todos os campos obrigatórios.');
                    e.preventDefault();
                    return false;
                }
                
                // Validate table number format
                if (numero.length < 1 || numero.length > 10) {
                    showError('O número da mesa deve ter entre 1 e 10 caracteres.');
                    e.preventDefault();
                    return false;
                }
                
                // Validate capacity
                if (isNaN(capacidade) || capacidade < 1 || capacidade > 20) {
                    showError('A capacidade deve ser um número entre 1 e 20 pessoas.');
                    e.preventDefault();
                    return false;
                }
                
                // Validate location
                if (localizacao.length < 2 || localizacao.length > 50) {
                    showError('A localização deve ter entre 2 e 50 caracteres.');
                    e.preventDefault();
                    return false;
                }
                
                // Show loading indicator
                $('#refreshTime').show();
                $('.btn-create').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Criando...');
                
                return true;
            });
            
            // Real-time validation feedback
            $('#mesa_numero').on('input', function() {
                var value = $(this).val().trim();
                var group = $(this).closest('.form-group');
                
                if (value.length > 0 && value.length <= 10) {
                    group.removeClass('has-error').addClass('has-success');
                } else {
                    group.removeClass('has-success').addClass('has-error');
                }
            });
            
            $('#mesa_capacidade').on('input', function() {
                var value = parseInt($(this).val());
                var group = $(this).closest('.form-group');
                
                if (!isNaN(value) && value >= 1 && value <= 20) {
                    group.removeClass('has-error').addClass('has-success');
                } else {
                    group.removeClass('has-success').addClass('has-error');
                }
            });
            
            $('#mesa_localizacao').on('input', function() {
                var value = $(this).val().trim();
                var group = $(this).closest('.form-group');
                
                if (value.length >= 2 && value.length <= 50) {
                    group.removeClass('has-error').addClass('has-success');
                } else {
                    group.removeClass('has-success').addClass('has-error');
                }
            });
            
            // Auto-suggest table numbers based on existing pattern
            $('#mesa_numero').on('focus', function() {
                // Could implement AJAX call to get next available number
            });
            
            // Capacity suggestions
            $('#mesa_capacidade').on('focus', function() {
                if (!$(this).val()) {
                    $(this).attr('placeholder', 'Sugestão: 4 pessoas');
                }
            });
            
            // Location suggestions
            $('#mesa_localizacao').on('focus', function() {
                if (!$(this).val()) {
                    $(this).attr('placeholder', 'Ex: Salão Principal, Varanda, Área VIP...');
                }
            });
            
            // Keyboard shortcuts
            $(document).keydown(function(e) {
                // Ctrl+S: Submit form
                if (e.ctrlKey && e.which == 83) {
                    e.preventDefault();
                    $('#createForm').submit();
                }
                // ESC: Go back to list
                if (e.which == 27) {
                    window.location.href = baseUri + '/admin/mesa/lista';
                }
            });
            
            // Form field animations
            $('.form-control').on('focus', function() {
                $(this).closest('.form-group').addClass('focused');
            }).on('blur', function() {
                $(this).closest('.form-group').removeClass('focused');
            });
            
            // Success message if redirected from successful creation
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('success') === '1') {
                // Could show success message if implemented
            }
            
            // Error message if redirected with error
            var errorParam = urlParams.get('error');
            if (errorParam) {
                showError(decodeURIComponent(errorParam));
                console.error('[' + new Date().toLocaleString() + '] Error from server: ' + errorParam);
            }
            
        });
    </script>

</body>

</html>