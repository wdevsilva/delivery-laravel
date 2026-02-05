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
    <style>
        .editar-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 0;
        }

        .page-header {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px 20px 0 0;
            padding: 30px 40px;
            margin: 30px 30px 0 30px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .page-header h1 {
            color: #2c3e50;
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .page-header h1 i {
            color: #667eea;
            margin-right: 15px;
        }

        .page-header .subtitle {
            color: #6c757d;
            font-size: 1.1rem;
            font-weight: 300;
            margin-bottom: 0;
        }

        .content-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 0 0 20px 20px;
            padding: 40px;
            margin: 0 30px 30px 30px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-top: none;
        }

        .btn-back {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 25px;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(108, 117, 125, 0.3);
        }

        .btn-back:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(108, 117, 125, 0.4);
            color: white;
        }

        .garcon-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 25px 30px;
            margin-bottom: 30px;
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .garcon-header h2 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 300;
        }

        .garcon-header .garcon-info {
            margin-top: 10px;
            opacity: 0.9;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-left: 15px;
        }

        .status-ativo {
            background: rgba(40, 167, 69, 0.9);
            color: white;
        }

        .status-inativo {
            background: rgba(220, 53, 69, 0.9);
            color: white;
        }

        .form-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 249, 250, 0.95) 100%);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin-bottom: 25px;
            border-left: 5px solid #667eea;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .form-card h4 {
            color: #2c3e50;
            font-size: 1.4rem;
            font-weight: 500;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }

        .form-card h4 i {
            color: #667eea;
            margin-right: 10px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 15px 20px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: #fff;
        }

        label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .required {
            color: #e74c3c;
            font-weight: bold;
        }

        .form-text {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 5px;
        }

        .btn {
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(108, 117, 125, 0.3);
            color: white;
        }

        .form-actions {
            background: rgba(248, 249, 250, 0.8);
            border-radius: 15px;
            padding: 25px;
            margin-top: 30px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .page-header,
            .content-container {
                margin: 20px;
                padding: 25px;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .form-card {
                padding: 25px;
            }
        }
    </style>
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
                                                    <select id="garcon_nivel" name="garcon_nivel" class="form-control" required>
                                                        <option value="3" <?= $garcon->garcon_nivel == 3 ? 'selected' : '' ?>>Garçon - Acesso Básico</option>
                                                        <option value="2" <?= $garcon->garcon_nivel == 2 ? 'selected' : '' ?>>Supervisor - Supervisão</option>
                                                        <option value="1" <?= $garcon->garcon_nivel == 1 ? 'selected' : '' ?>>Admin - Acesso Total</option>
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

                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?php echo $baseUri; ?>/assets/vendor/jquery/jquery-2.1.4.min.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.gritter/js/jquery.gritter.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.mask.js"></script>
    
    <?php require_once __DIR__ . '/../switch-color.php'; ?>
    <script src="<?php echo $baseUri; ?>/view/admin/app-js/main.js"></script>

    <script>
        var baseUri = '<?= $baseUri; ?>';
        
        $(document).ready(function() {
            // Phone mask
            $('#garcon_telefone').mask('(00) 00000-0000');
            
            // Form submission
            $('#formEditarGarcon').submit(function(e) {
                e.preventDefault();
                
                if (!validateForm()) {
                    return false;
                }
                
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
                            setTimeout(function() {
                                window.location.href = baseUri + '/admin/garcon/lista/';
                            }, 1500);
                        } else {
                            $.gritter.add({
                                title: 'Erro!',
                                text: response.message || 'Erro ao atualizar garçon',
                                class_name: 'gritter-error',
                                time: 5000
                            });
                        }
                    },
                    error: function() {
                        $.gritter.add({
                            title: 'Erro!',
                            text: 'Erro de comunicação com o servidor',
                            class_name: 'gritter-error',
                            time: 5000
                        });
                    }
                });
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
            
            const senha = $('#garcon_senha').val();
            if (senha && senha.length < 6) {
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
    </script>
</body>

</html>