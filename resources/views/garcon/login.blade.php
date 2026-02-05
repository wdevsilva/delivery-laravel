<!DOCTYPE html>
<?php $baseUri = Http::base(); ?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Garçon - <?= $data['config']->config_nome ?></title>
    <link rel="icon" type="image/png" href="<?php echo $baseUri; ?>/midias/logo/<?= $_SESSION['base_delivery'] ?>/<?php echo $data['config']->config_foto; ?>" />
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/css/main.css?v=<?= filemtime($_SERVER['DOCUMENT_ROOT'] . '/assets/css/main.css') ?>">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= $baseUri ?>/assets/css/garcon-login.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="login-container">
                    <div class="login-header">
                        <h3><i class="fa fa-user"></i> Acesso Garçon</h3>
                        <p><?= $data['config']->config_nome ?></p>
                    </div>
                    <div class="login-body">
                        <div id="alert-container"></div>
                        
                        <?php if (isset($_GET['logout'])): ?>
                            <div class="alert alert-success">
                                <i class="fa fa-check"></i> Logout realizado com sucesso!
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger">
                                <i class="fa fa-exclamation-triangle"></i> <?= htmlspecialchars($_GET['error']) ?>
                            </div>
                        <?php endif; ?>

                        <form id="form-login">
                            <div class="form-group">
                                <input type="text" class="form-control" id="garcon_usuario" name="garcon_usuario" 
                                       placeholder="Usuário" autocomplete="username">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="garcon_senha" name="garcon_senha" 
                                       placeholder="Senha" autocomplete="current-password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-login btn-block">
                                <i class="fa fa-sign-in"></i> Entrar
                            </button>
                        </form>

                        <div class="text-center mt-3">
                            <small>
                                <a href="<?= $baseUri ?>/admin" class="text-muted">
                                    <i class="fa fa-arrow-left"></i> Voltar para Admin
                                </a>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= $baseUri ?>/assets/vendor/jquery/jquery-2.1.4.min.js"></script>
    <script src="<?= $baseUri ?>/assets/vendor/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script>
        // Global function to show alerts
        function showAlert(message, type) {
            // Clear any existing alerts
            $('#alert-container').empty();
            
            // Create alert HTML compatible with Bootstrap 3
            const alertHtml = `
                <div class="alert alert-${type}" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="fa fa-${type === 'success' ? 'check' : 'exclamation-triangle'}"></i> ${message}
                </div>
            `;
            
            // Add alert to container
            $('#alert-container').html(alertHtml);
            
            // Auto-hide success alerts after 3 seconds
            if (type === 'success') {
                setTimeout(function() {
                    $('.alert-success').fadeOut();
                }, 2000);
            }

             if (type === 'danger') {
                setTimeout(function() {
                    $('.alert-danger').fadeOut();
                }, 2000);
            }
            
            // Scroll to top to show the alert
            $('html, body').animate({
                scrollTop: $('#alert-container').offset().top - 20
            }, 300);
        }

        $(document).ready(function() {
            $('#form-login').on('submit', function(e) {
                e.preventDefault();
                
                const usuario = $('#garcon_usuario').val().trim();
                const senha = $('#garcon_senha').val().trim();
                
                if (!usuario || !senha) {
                    showAlert('Por favor, preencha todos os campos!', 'danger');
                    return;
                }
                
                const btn = $(this).find('button[type="submit"]');
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Entrando...');
                
                $.ajax({
                    url: '<?= $baseUri ?>/garcon/entrar/',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        garcon_usuario: usuario,
                        garcon_senha: senha
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showAlert(response.message, 'success');
                            setTimeout(function() {
                                window.location.href = response.redirect || '<?= $baseUri ?>/garcon/';
                            }, 1000);
                        } else {
                            showAlert(response.message, 'danger');
                            btn.prop('disabled', false).html('<i class="fa fa-sign-in"></i> Entrar');
                        }
                    },
                    error: function(xhr, status, error) {
                        showAlert('Erro de conexão. Tente novamente.', 'danger');
                        btn.prop('disabled', false).html('<i class="fa fa-sign-in"></i> Entrar');
                    }
                });
            });
            
            // Add test button for debugging (remove this later)
            if (window.location.hash === '#debug') {
                $('<button class="btn btn-warning btn-sm" style="margin-top: 10px;" onclick="showAlert(\'Teste de alerta!\', \'warning\');">Testar Alert</button>').insertAfter('#form-login');
            }
        });
    </script>
</body>
</html>