<?php
$baseUri = Http::base();
// Data is passed from the Admin controller
$config = $data['config'] ?? null;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once __DIR__ . '/../site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de Gerenciamento de Garçons - Controle Completo">
    <meta name="author" content="">
    <title>Novo Garçon - <?= $config ? $config->config_nome : 'Sistema' ?></title>

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
    <link href="css/garcon-novo.css" rel="stylesheet" />
</head>

<body class="animated">
    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php require_once __DIR__ . '/../side-menu.php'; ?>
        </div>
        <div class="container-fluid" id="pcont">
            <div class="cl-mcont">
                <div class="block-flat">
                    <div class="content">
                        <!-- Main content -->
                        <main role="main" class="container">
                            <!-- Page Header -->
                            <div class="page-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h1><i class="fa fa-user-plus"></i> Novo Garçon</h1>
                                        <p class="subtitle">Cadastre um novo garçon no sistema de atendimento</p>
                                    </div>
                                    <div>
                                        <a href="<?= $baseUri ?>/admin/garcon/lista/" class="btn btn-back">
                                            <i class="fa fa-arrow-left"></i> Voltar à Lista
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Content Container -->
                            <div class="content-container">

                                <!-- Summary Cards -->
                                <div class="stats-container">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="stat-card info">
                                                <div class="stat-number">1</div>
                                                <div class="stat-label">Novo Cadastro</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="stat-card success">
                                                <div class="stat-number">4</div>
                                                <div class="stat-label">Campos Obrigatórios</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="stat-card warning">
                                                <div class="stat-number">3</div>
                                                <div class="stat-label">Níveis Disponíveis</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="stat-card primary">
                                                <div class="stat-number">1</div>
                                                <div class="stat-label">Status Ativo</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Card -->
                                <div class="form-card">
                                    <h4><i class="fa fa-user"></i> Dados Básicos</h4>

                                    <form id="formNovoGarcon" method="POST" action="<?= $baseUri ?>/admin/garcon/salvar/">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="garcon_nome">
                                                        <i class="fa fa-user"></i> Nome Completo <span class="required">*</span>
                                                    </label>
                                                    <input type="text"
                                                        id="garcon_nome"
                                                        name="garcon_nome"
                                                        class="form-control"
                                                        required
                                                        placeholder="Digite o nome completo do garçon">
                                                    <small class="form-text text-muted">
                                                        Nome que aparecerá no sistema e relatórios
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="garcon_usuario">
                                                        <i class="fa fa-at"></i> Login/Usuário <span class="required">*</span>
                                                    </label>
                                                    <input type="text"
                                                        id="garcon_usuario"
                                                        name="garcon_usuario"
                                                        class="form-control"
                                                        required
                                                        placeholder="Digite o login de acesso">
                                                    <small class="form-text text-muted">
                                                        Login usado para acessar o sistema (deve ser único)
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="garcon_senha">
                                                        <i class="fa fa-key"></i> Senha <span class="required">*</span>
                                                    </label>
                                                    <input type="password"
                                                        id="garcon_senha"
                                                        name="garcon_senha"
                                                        class="form-control"
                                                        required
                                                        placeholder="Digite a senha de acesso">
                                                    <small class="form-text text-muted">
                                                        Mínimo 6 caracteres para segurança
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="garcon_nivel">
                                                        <i class="fa fa-users"></i> Nível de Acesso <span class="required">*</span>
                                                    </label>
                                                    <select id="garcon_nivel" name="garcon_nivel" class="form-control" required>
                                                        <option value="3" selected>Garçon - Acesso Básico</option>
                                                        <option value="2">Supervisor - Supervisão</option>
                                                        <option value="1">Admin - Acesso Total</option>
                                                    </select>
                                                    <small class="form-text text-muted">
                                                        Define as permissões do usuário no sistema
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Dados de Contato -->
                                <div class="form-card">
                                    <h4><i class="fa fa-phone"></i> Dados de Contato <small class="text-muted">(Opcionais)</small></h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="garcon_email">
                                                    <i class="fa fa-envelope"></i> E-mail
                                                </label>
                                                <input type="email"
                                                    id="garcon_email"
                                                    name="garcon_email"
                                                    form="formNovoGarcon"
                                                    class="form-control"
                                                    placeholder="exemplo@email.com">
                                                <small class="form-text text-muted">
                                                    Para comunicação e recuperação de senha
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="garcon_telefone">
                                                    <i class="fa fa-phone"></i> Telefone
                                                </label>
                                                <input type="text"
                                                    id="garcon_telefone"
                                                    name="garcon_telefone"
                                                    form="formNovoGarcon"
                                                    class="form-control"
                                                    placeholder="(00) 00000-0000">
                                                <small class="form-text text-muted">
                                                    Contato para comunicação direta
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <small class="text-muted">
                                                <i class="fa fa-info-circle"></i> Campos marcados com <span class="required">*</span> são obrigatórios
                                            </small>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button type="submit" form="formNovoGarcon" class="btn btn-primary">
                                                <i class="fa fa-save"></i> Cadastrar Garçon
                                            </button>
                                            <a href="<?= $baseUri ?>/admin/garcon/lista/" class="btn btn-secondary">
                                                <i class="fa fa-times"></i> Cancelar
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hidden input for status -->
                                <input type="hidden" name="garcon_ativo" value="1" form="formNovoGarcon">

                            </div>

                            <!-- Loading Overlay -->
                            <div class="loading-overlay" id="loadingOverlay">
                                <div class="loading-spinner"></div>
                            </div>

                        </main>
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
            // Phone mask
            $('#garcon_telefone').mask('(00) 00000-0000');

            // Form submission
            $('#formNovoGarcon').submit(function(e) {
                e.preventDefault();

                if (!validateForm()) {
                    return false;
                }
                
                // Debug: Log form data

                showLoading();

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        hideLoading();
                        if (response.status === 'success') {
                            $.gritter.add({
                                title: 'Sucesso!',
                                text: response.message,
                                class_name: 'gritter-success',
                                time: 3000
                            });
                            setTimeout(function() {
                                window.location.href = baseUri + '/admin/garcon/lista/';
                            }, 1500);
                        } else {
                            $.gritter.add({
                                title: 'Erro!',
                                text: response.message || 'Erro ao cadastrar garçon',
                                class_name: 'gritter-error',
                                time: 5000
                            });
                        }
                    },
                    error: function() {
                        hideLoading();
                        $.gritter.add({
                            title: 'Erro!',
                            text: 'Erro de comunicação com o servidor',
                            class_name: 'gritter-error',
                            time: 5000
                        });
                    }
                });
            });

            // Animate entry
            const cards = $('.form-card');
            const statCards = $('.stat-card');

            statCards.each(function(index) {
                $(this).css({
                    'opacity': '0',
                    'transform': 'translateY(30px)'
                });

                setTimeout(() => {
                    $(this).css({
                        'transition': 'all 0.6s ease',
                        'opacity': '1',
                        'transform': 'translateY(0)'
                    });
                }, index * 100 + 200);
            });

            cards.each(function(index) {
                $(this).css({
                    'opacity': '0',
                    'transform': 'translateY(30px)'
                });

                setTimeout(() => {
                    $(this).css({
                        'transition': 'all 0.6s ease',
                        'opacity': '1',
                        'transform': 'translateY(0)'
                    });
                }, index * 100 + 600);
            });
        });

        function validateForm() {
            if (!$('#garcon_nome').val().trim()) {
                $.gritter.add({
                    title: 'Atenção!',
                    text: 'Por favor, preencha o nome completo',
                    class_name: 'gritter-warning',
                    time: 3000
                });
                $('#garcon_nome').focus();
                return false;
            }

            if (!$('#garcon_usuario').val().trim()) {
                $.gritter.add({
                    title: 'Atenção!',
                    text: 'Por favor, preencha o nome de usuário',
                    class_name: 'gritter-warning',
                    time: 3000
                });
                $('#garcon_usuario').focus();
                return false;
            }

            if (!$('#garcon_senha').val() || $('#garcon_senha').val().length < 6) {
                $.gritter.add({
                    title: 'Atenção!',
                    text: 'A senha deve ter pelo menos 6 caracteres',
                    class_name: 'gritter-warning',
                    time: 3000
                });
                $('#garcon_senha').focus();
                return false;
            }

            return true;
        }

        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }
    </script>
</body>

</html>