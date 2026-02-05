<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Login Entregador - Tracking</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .logo {
            color: #667eea;
            font-size: 3rem;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            color: #555;
            font-weight: 600;
            margin-bottom: 8px;
        }

        input[type="number"],
        input[type="text"] {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e1e1;
            border-radius: 10px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input[type="number"]:focus,
        input[type="text"]:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
        }

        .error-message {
            background: #ff6b6b;
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .info-text {
            color: #777;
            font-size: 14px;
            margin-top: 20px;
            line-height: 1.5;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="logo">
            <i class="fas fa-motorcycle"></i>
        </div>
        <h1>Acesso Entregador</h1>

        <?php if (isset($_GET['erro'])): ?>
            <div class="error-message">
                <?php
                switch ($_GET['erro']) {
                    case 'dados-obrigatorios':
                        echo '✏️ Todos os campos são obrigatórios!';
                        break;
                    case 'entregador-nao-encontrado':
                        echo '❌ Entregador não encontrado! Verifique o ID.';
                        break;
                    case 'telefone-incorreto':
                        echo '📞 Telefone incorreto! Verifique o número cadastrado.';
                        break;
                    case 'entregador-inativo':
                        echo '⚠️ Entregador inativo! Entre em contato com o administrador.';
                        break;
                    case 'sistema-nao-configurado':
                        echo '⚙️ Sistema não configurado! ' . (isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : 'Entre em contato com o administrador.');
                        break;
                    case 'credenciais-invalidas':
                        echo '❌ Credenciais inválidas! Verifique ID e telefone.';
                        break;
                    default:
                        echo '❌ Erro no login. Tente novamente.';
                }
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['sucesso'])): ?>
            <div class="success-message" style="background: #4CAF50; color: white; padding: 15px; border-radius: 10px; margin-bottom: 20px; font-weight: 600;">
                <?php
                switch ($_GET['sucesso']) {
                    case 'logout':
                        echo '✅ Logout realizado com sucesso!';
                        break;
                    default:
                        echo '✅ Operação realizada com sucesso!';
                }
                ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= $baseUri ?>/entrega-tracking/entregador-auth/" id="loginForm">
            <div class="form-group">
                <label for="entregador_id">
                    <i class="fas fa-id-card"></i> Seu ID de Entregador
                </label>
                <input
                    type="number"
                    id="entregador_id"
                    name="entregador_id"
                    placeholder="Digite seu ID"
                    required
                    min="1"
                    value="<?= isset($_GET['id']) ? intval($_GET['id']) : '' ?>">
            </div>

            <div class="form-group">
                <label for="entregador_fone">
                    <i class="fas fa-phone"></i> Seu Telefone
                </label>
                <input
                    type="text"
                    id="entregador_fone"
                    name="entregador_fone"
                    placeholder="(00) 00000-0000"
                    required
                    value="<?= isset($_GET['phone']) ? htmlspecialchars($_GET['phone']) : '' ?>">
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Entrar
            </button>
        </form>

        <div class="info-text">
            <i class="fas fa-info-circle"></i>
            Para acessar o sistema de rastreamento, use seu ID de entregador e telefone cadastrados no sistema.
        </div>
    </div>

    <script>
        // Wait for DOM to be fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Máscara para telefone
            const phoneInput = document.getElementById('entregador_fone');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    try {
                        let value = e.target.value.replace(/\D/g, '');
                        if (value.length >= 11) {
                            value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                        } else if (value.length >= 7) {
                            value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
                        } else if (value.length >= 3) {
                            value = value.replace(/(\d{2})(\d{0,5})/, '($1) $2');
                        }
                        e.target.value = value;
                    } catch (error) {
                        console.warn('Error formatting phone number:', error);
                    }
                });
            }

            // Add form validation
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    
                    const entregadorId = document.getElementById('entregador_id');
                    const entregadorFone = document.getElementById('entregador_fone');
                    
                    if (!entregadorId || !entregadorId.value.trim()) {
                        alert('Por favor, digite seu ID de entregador');
                        e.preventDefault();
                        return false;
                    }

                    if (!entregadorFone || !entregadorFone.value.trim()) {
                        alert('Por favor, digite seu telefone');
                        e.preventDefault();
                        return false;
                    }

                    // Remove formatting from phone before submitting
                    const cleanPhone = entregadorFone.value.replace(/\D/g, '');
                    if (cleanPhone.length < 10) {
                        alert('Por favor, digite um telefone válido');
                        e.preventDefault();
                        return false;
                    }

                    // Let form submit normally
                    return true;
                });
            }
        });

        // Prevent extension conflicts
        window.addEventListener('error', function(e) {
            if (e.message && e.message.includes('message channel closed')) {
                // Suppress extension-related errors
                e.preventDefault();
                return false;
            }
        });
    </script>
</body>

</html>