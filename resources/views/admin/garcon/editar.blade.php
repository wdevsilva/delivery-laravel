<?php
$baseUri = Http::base();
// Data is passed from the Admin controller
$garcon = $data['garcon'] ?? null;
$config = $data['config'] ?? null;

if (!$garcon) {
    Http::redirect_to('/admin/garcon/?error=Garçon não encontrado');
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once __DIR__ . '/../site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Editar Garçon - Sistema de Gerenciamento">
    <meta name="author" content="">
    <title>Editar Garçon - <?= $config ? $config->config_nome : 'Sistema' ?></title>

    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />
    <link href="css/garcon-editar.css" rel="stylesheet" />
</head>

<body class="animated editar-container">
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
                                        <h1><i class="fa fa-edit"></i> Editar Garçon</h1>
                                        <p class="subtitle">Atualizar informações do garçon no sistema</p>
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

                                <!-- Garçon Header -->
                                <div class="garcon-header">
                                    <h2><i class="fa fa-user"></i> <?= htmlspecialchars($garcon->garcon_nome) ?></h2>
                                    <div class="garcon-info">
                                        <span class="status-badge <?= $garcon->garcon_ativo ? 'status-ativo' : 'status-inativo' ?>">
                                            <?= $garcon->garcon_ativo ? 'Ativo' : 'Inativo' ?>
                                        </span>
                                        <span class="ml-3">
                                            <i class="fa fa-calendar"></i> Cadastrado em: <?= date('d/m/Y H:i', strtotime($garcon->data_criacao)) ?>
                                        </span>
                                        <span class="ml-3">
                                            <i class="fa fa-sign-in"></i> Login: <?= htmlspecialchars($garcon->garcon_usuario) ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Form Card: Dados Básicos -->
                                <div class="form-card">
                                    <h4><i class="fa fa-user"></i> Dados Básicos</h4>
                                    
                                    <form id="formEditarGarcon" method="POST" action="<?= $baseUri ?>/admin/garcon/salvar/">
                                        <input type="hidden" name="acao" value="editar">
                                        <input type="hidden" name="garcon_id" value="<?= $garcon->garcon_id ?>">
                                        
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
                                                           value="<?= htmlspecialchars($garcon->garcon_nome) ?>"
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
                                                           value="<?= htmlspecialchars($garcon->garcon_usuario) ?>"
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
                                                        <i class="fa fa-key"></i> Nova Senha
                                                    </label>
                                                    <input type="password" 
                                                           id="garcon_senha" 
                                                           name="garcon_senha" 
                                                           class="form-control" 
                                                           placeholder="Digite a nova senha (deixe vazio para manter atual)">
                                                    <small class="form-text text-muted">
                                                        Deixe vazio para manter a senha atual
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="garcon_nivel">
                                                        <i class="fa fa-users"></i> Nível de Acesso <span class="required">*</span>
                                                    </label>
                                                    <select id="garcon_nivel" name="garcon_nivel" class="form-control" required onchange="mostrarInfoNivel()">
                                                        <option value="3" <?= $garcon->garcon_nivel == 3 ? 'selected' : '' ?>>Garçon - Acesso Básico</option>
                                                        <option value="2" <?= $garcon->garcon_nivel == 2 ? 'selected' : '' ?>>Supervisor - Supervisão</option>
                                                        <option value="1" <?= $garcon->garcon_nivel == 1 ? 'selected' : '' ?>>Admin - Acesso Total</option>
                                                    </select>
                                                    <small class="form-text text-muted">
                                                        Define as permissões do usuário no sistema
                                                    </small>
                                                    
                                                    <!-- Info sobre níveis -->
                                                    <div id="nivel-info" class="nivel-info" style="display: none;">
                                                        <div id="info-garcon" style="display: none;">
                                                            <h6><i class="fa fa-user"></i> Garçon (Nível 3)</h6>
                                                            <ul>
                                                                <li>Acesso ao sistema de atendimento</li>
                                                                <li>Pode ocupar e liberar mesas</li>
                                                                <li>Pode fazer pedidos para suas mesas</li>
                                                                <li>Pode ver estatísticas pessoais</li>
                                                            </ul>
                                                        </div>
                                                        <div id="info-supervisor" style="display: none;">
                                                            <h6><i class="fa fa-star"></i> Supervisor (Nível 2)</h6>
                                                            <ul>
                                                                <li>Todos os acessos do garçon</li>
                                                                <li>Pode ver todas as mesas (modo colaborativo)</li>
                                                                <li>Acesso a relatórios ampliados</li>
                                                                <li>Pode supervisionar outros garçons</li>
                                                            </ul>
                                                        </div>
                                                        <div id="info-admin" style="display: none;">
                                                            <h6><i class="fa fa-cog"></i> Admin (Nível 1)</h6>
                                                            <ul>
                                                                <li>Acesso total ao sistema</li>
                                                                <li>Pode gerenciar outros garçons</li>
                                                                <li>Acesso ao painel administrativo</li>
                                                                <li>Pode configurar sistema</li>
                                                            </ul>
                                                        </div>
                                                    </div>
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
                                                       form="formEditarGarcon"
                                                       class="form-control" 
                                                       value="<?= htmlspecialchars($garcon->garcon_email ?? '') ?>"
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
                                                       form="formEditarGarcon"
                                                       class="form-control" 
                                                       value="<?= htmlspecialchars($garcon->garcon_telefone ?? '') ?>"
                                                       placeholder="(00) 00000-0000">
                                                <small class="form-text text-muted">
                                                    Contato para comunicação direta
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status do Garçon -->
                                <div class="form-card">
                                    <h4><i class="fa fa-toggle-on"></i> Status do Garçon</h4>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="garcon_ativo">
                                                    <i class="fa fa-power-off"></i> Status de Atividade
                                                </label>
                                                <select id="garcon_ativo" name="garcon_ativo" form="formEditarGarcon" class="form-control">
                                                    <option value="1" <?= $garcon->garcon_ativo == 1 ? 'selected' : '' ?>>Ativo - Pode fazer login</option>
                                                    <option value="0" <?= $garcon->garcon_ativo == 0 ? 'selected' : '' ?>>Inativo - Não pode fazer login</option>
                                                </select>
                                                <small class="form-text text-muted">
                                                    Define se o garçon pode acessar o sistema
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
                                            <button type="submit" form="formEditarGarcon" class="btn btn-primary">
                                                <i class="fa fa-save"></i> Salvar Alterações
                                            </button>
                                            <a href="<?= $baseUri ?>/admin/garcon/lista/" class="btn btn-secondary">
                                                <i class="fa fa-times"></i> Cancelar
                                            </a>
                                        </div>
                                    </div>
                                </div>

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
        // Mostrar informações sobre níveis de acesso
        function mostrarInfoNivel() {
            const nivel = document.getElementById('garcon_nivel').value;
            const infoContainer = document.getElementById('nivel-info');
            
            // Esconder todas as informações
            document.getElementById('info-garcon').style.display = 'none';
            document.getElementById('info-supervisor').style.display = 'none';
            document.getElementById('info-admin').style.display = 'none';
            
            if (nivel) {
                infoContainer.style.display = 'block';
                
                switch(nivel) {
                    case '3':
                        document.getElementById('info-garcon').style.display = 'block';
                        break;
                    case '2':
                        document.getElementById('info-supervisor').style.display = 'block';
                        break;
                    case '1':
                        document.getElementById('info-admin').style.display = 'block';
                        break;
                }
            } else {
                infoContainer.style.display = 'none';
            }
        }

        // Mostrar info do nível atual ao carregar
        document.addEventListener('DOMContentLoaded', function() {
            mostrarInfoNivel();
        });

        // Validação e envio do formulário
        $('#formEditarGarcon').on('submit', function(e) {
            e.preventDefault();

            // Validações básicas
            const nome = $('#garcon_nome').val().trim();
            const usuario = $('#garcon_usuario').val().trim();
            const nivel = $('#garcon_nivel').val();
            const senha = $('#garcon_senha').val();

            if (!nome || !usuario || !nivel) {
                $.gritter.add({
                    title: 'Erro!',
                    text: 'Por favor, preencha todos os campos obrigatórios.',
                    class_name: 'gritter-error',
                    time: 5000
                });
                return;
            }

            // Validar login (apenas letras, números e alguns caracteres especiais)
            const loginRegex = /^[a-zA-Z0-9._-]+$/;
            if (!loginRegex.test(usuario)) {
                $.gritter.add({
                    title: 'Erro!',
                    text: 'Login deve conter apenas letras, números, pontos, hífens ou underscores.',
                    class_name: 'gritter-error',
                    time: 5000
                });
                return;
            }

            // Validar senha se fornecida (mínimo 4 caracteres)
            if (senha && senha.length < 4) {
                $.gritter.add({
                    title: 'Erro!',
                    text: 'Nova senha deve ter pelo menos 4 caracteres.',
                    class_name: 'gritter-error',
                    time: 5000
                });
                return;
            }

            // Desabilitar botão e mostrar loading
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Salvando...');

            // Enviar dados
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $.gritter.add({
                            title: 'Sucesso!',
                            text: response.message,
                            class_name: 'gritter-success',
                            time: 3000
                        });
                        
                        // Redirecionar para lista após 2 segundos
                        setTimeout(() => {
                            window.location.href = '<?= $baseUri ?>/admin/garcon/';
                        }, 2000);
                    } else {
                        $.gritter.add({
                            title: 'Erro!',
                            text: response.message,
                            class_name: 'gritter-error',
                            time: 5000
                        });
                        
                        // Reabilitar botão
                        submitBtn.prop('disabled', false).html(originalText);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('[GARCON EDITAR ERROR] ' + new Date().toISOString() + ' - AJAX Error:', error);
                    
                    $.gritter.add({
                        title: 'Erro!',
                        text: 'Erro ao processar solicitação. Tente novamente.',
                        class_name: 'gritter-error',
                        time: 5000
                    });
                    
                    // Reabilitar botão
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        });

        // Formatação automática do telefone
        $('#garcon_telefone').on('input', function() {
            let value = this.value.replace(/\D/g, '');
            
            if (value.length >= 11) {
                value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else if (value.length >= 7) {
                value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            } else if (value.length >= 3) {
                value = value.replace(/(\d{2})(\d{0,5})/, '($1) $2');
            }
            
            this.value = value;
        });

    </script>
</body>

</html>