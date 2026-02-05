<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - Delivery Admin</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .reset-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 40px;
            max-width: 500px;
            width: 100%;
        }
        .reset-container h2 {
            color: #3d566d;
            margin-bottom: 10px;
        }
        .reset-container .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .requirement {
            font-size: 12px;
            color: #999;
            margin-top: 5px;
        }
        .requirement.met {
            color: #28a745;
        }
        .btn-primary {
            background: #3d566d;
            border: none;
            padding: 12px;
            font-size: 16px;
        }
        .btn-primary:hover {
            background: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <h2><i class="fa fa-key"></i> Redefinir Senha</h2>
        <p class="subtitle">Olá <strong><?php echo htmlspecialchars($user['usuario_nome']); ?></strong>, crie sua nova senha abaixo.</p>

        <form method="POST" action="/delivery/login/processar-redefinir-senha" id="resetForm">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <input type="hidden" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">

            <div class="form-group">
                <label>Nova Senha</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" name="senha" id="senha" class="form-control" placeholder="Digite sua nova senha" required autofocus>
                </div>
                <div class="requirement" id="reqLength">
                    <i class="fa fa-circle-o"></i> Mínimo 8 caracteres
                </div>
            </div>

            <div class="form-group">
                <label>Confirmar Nova Senha</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" name="senha_confirmacao" id="senha_confirmacao" class="form-control" placeholder="Digite novamente" required>
                </div>
                <div class="requirement" id="reqMatch">
                    <i class="fa fa-circle-o"></i> Senhas devem coincidir
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block" id="btnSubmit" disabled>
                <i class="fa fa-check"></i> Redefinir Senha
            </button>

            <div style="margin-top: 20px; text-align: center;">
                <a href="/delivery/login/" style="color: #666; font-size: 13px;">
                    <i class="fa fa-arrow-left"></i> Voltar para o login
                </a>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var $senha = $('#senha');
            var $senhaConfirmacao = $('#senha_confirmacao');
            var $btnSubmit = $('#btnSubmit');
            var $reqLength = $('#reqLength');
            var $reqMatch = $('#reqMatch');

            function validatePassword() {
                var senha = $senha.val();
                var confirmacao = $senhaConfirmacao.val();
                var isValid = true;

                // Validar comprimento
                if (senha.length >= 8) {
                    $reqLength.addClass('met').find('i').removeClass('fa-circle-o').addClass('fa-check-circle');
                } else {
                    $reqLength.removeClass('met').find('i').removeClass('fa-check-circle').addClass('fa-circle-o');
                    isValid = false;
                }

                // Validar match
                if (senha && confirmacao && senha === confirmacao) {
                    $reqMatch.addClass('met').find('i').removeClass('fa-circle-o').addClass('fa-check-circle');
                } else {
                    $reqMatch.removeClass('met').find('i').removeClass('fa-check-circle').addClass('fa-circle-o');
                    isValid = false;
                }

                $btnSubmit.prop('disabled', !isValid);
            }

            $senha.on('keyup', validatePassword);
            $senhaConfirmacao.on('keyup', validatePassword);
        });
    </script>
</body>
</html>
