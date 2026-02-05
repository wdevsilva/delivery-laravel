<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Painel Administrativo">
    <title>Login - Painel Admin</title>
    <link href="fonts/inter/inter.css?v=<?= time() ?>" rel="stylesheet">
    <link rel="stylesheet" href="fonts/fontawesome/css/all.min.css?v=<?= time() ?>">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            overflow: hidden;
            position: relative;
        }

        /* Animated Background */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }

        .bg-animation .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
            animation: float 20s ease-in-out infinite;
        }

        .orb-1 {
            width: 600px;
            height: 600px;
            background: linear-gradient(180deg, #7979dc,rgb(131, 189, 131));
            top: -200px;
            left: -200px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 500px;
            height: 500px;
            background: linear-gradient(180deg, #4834d4, #686de0);
            bottom: -150px;
            right: -150px;
            animation-delay: -5s;
        }

        .orb-3 {
            width: 400px;
            height: 400px;
            background: linear-gradient(180deg, #00d2d3, #54a0ff);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -10s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(50px, -50px) scale(1.1); }
            50% { transform: translate(-30px, 30px) scale(0.95); }
            75% { transform: translate(40px, 40px) scale(1.05); }
        }

        /* Main Container */
        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
            padding: 20px;
        }

        /* Glass Card */
        .login-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 48px 40px;
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Logo Section */
        .logo-section {
            text-align: center;
            margin-bottom: 36px;
        }

        .logo-section img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border-radius: 20px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            margin-bottom: 16px;
        }

        .logo-section h1 {
            color: #fff;
            font-size: 24px;
            font-weight: 600;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .logo-section p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            font-weight: 400;
        }

        /* Form */
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .input-group {
            position: relative;
            width: 100%;
        }

        .input-group i.fa-user,
        .input-group i.fa-lock,
        .input-group i.fa-envelope {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.4);
            font-size: 18px;
            transition: all 0.3s ease;
            z-index: 2;
            pointer-events: none;
        }

        .input-group input {
            width: 100%;
            padding: 18px 18px 18px 54px;
            background: rgba(255, 255, 255, 0.06);
            border: 2px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            color: #fff;
            font-size: 15px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            outline: none;
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.35);
        }

        .input-group input:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(99, 102, 241, 0.8);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        }

        .input-group input:focus ~ i.fa-user,
        .input-group input:focus ~ i.fa-lock,
        .input-group input:focus ~ i.fa-envelope {
            color: #818cf8;
        }

        /* Toggle Password Button */
        .toggle-password {
            position: absolute;
            right: 4px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            padding: 10px 12px;
            z-index: 2;
            transition: all 0.3s ease;
            line-height: 1;
            border-radius: 10px;
        }

        .toggle-password:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #818cf8;
        }

        /* Input with eye icon needs extra padding */
        .input-group.has-toggle input {
            padding-right: 56px;
        }

        /* Remember Me */
        .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 4px;
        }

        .remember-me input[type="checkbox"] {
            display: none;
        }

        .remember-me label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .remember-me label:hover {
            color: rgba(255, 255, 255, 0.8);
        }

        .remember-me .checkmark {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.05);
        }

        .remember-me .checkmark i {
            font-size: 11px;
            color: #fff;
            opacity: 0;
            transform: scale(0);
            transition: all 0.2s ease;
        }

        .remember-me input[type="checkbox"]:checked + label .checkmark {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border-color: transparent;
        }

        .remember-me input[type="checkbox"]:checked + label .checkmark i {
            opacity: 1;
            transform: scale(1);
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border: none;
            border-radius: 14px;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 8px;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -6px rgba(99, 102, 241, 0.5);
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Forgot Password */
        .forgot-link {
            text-align: center;
            margin-top: 24px;
        }

        .forgot-link a {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .forgot-link a:hover {
            color: #818cf8;
        }

        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .login-footer p {
            color: rgba(255, 255, 255, 0.4);
            font-size: 12px;
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        .modal-overlay.active {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-card {
            background: rgba(30, 27, 75, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 36px;
            max-width: 420px;
            width: 90%;
            animation: modalSlide 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalSlide {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .modal-header h2 {
            color: #fff;
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-header h2 i {
            color: #818cf8;
        }

        .modal-close {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        .modal-body p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            margin-bottom: 24px;
            line-height: 1.6;
        }

        .modal-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .modal-form label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 6px;
            display: block;
        }

        .modal-footer {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .btn-cancel {
            flex: 1;
            padding: 14px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: rgba(255, 255, 255, 0.12);
        }

        .btn-primary {
            flex: 1;
            padding: 14px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px -4px rgba(99, 102, 241, 0.5);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* Alert */
        .alert {
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 13px;
            display: none;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
        }

        .alert.show {
            display: flex;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #86efac;
        }

        /* Toast Notification */
        .toast {
            position: fixed;
            top: 24px;
            right: 24px;
            padding: 16px 24px;
            background: rgba(30, 27, 75, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 14px;
            display: none;
            align-items: center;
            gap: 12px;
            z-index: 2000;
            animation: toastSlide 0.4s ease;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.5);
        }

        .toast.show {
            display: flex;
        }

        .toast.error {
            border-color: rgba(239, 68, 68, 0.4);
        }

        .toast.error i {
            color: #f87171;
        }

        .toast.success {
            border-color: rgba(34, 197, 94, 0.4);
        }

        .toast.success i {
            color: #4ade80;
        }

        @keyframes toastSlide {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 36px 28px;
            }

            .logo-section h1 {
                font-size: 20px;
            }
        }

        /* Loading spinner */
        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>

<body>
    <!-- Animated Background -->
    <div class="bg-animation">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <i class="fas fa-exclamation-circle"></i>
        <span id="toastMessage"></span>
    </div>

    <!-- Login Card -->
    <div class="login-wrapper">
        <div class="login-card">
            <div class="logo-section">
                <?php
                try {
                    if (class_exists('configModel')) {
                        $config = (new configModel)->get_config();
                        if ($config && $config->config_foto != '') {
                            // Verificar se o arquivo existe
                            $logoPath = __DIR__ . '/../../logo/' . (isset($_SESSION['base_delivery']) ? $_SESSION['base_delivery'] : 'default') . '/' . $config->config_foto;
                            $logoUrl = file_exists($logoPath)
                                ? $baseUri . '/logo/' . (isset($_SESSION['base_delivery']) ? $_SESSION['base_delivery'] : 'default') . '/' . $config->config_foto
                                : $baseUri . '/assets/img/sem_foto.jpg';
                        ?>
                            <img src="<?= $logoUrl ?>" alt="logo" />
                        <?php } else { ?>
                            <div style="width:80px;height:80px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:20px;margin:0 auto 16px;display:flex;align-items:center;justify-content:center;">
                                <i class="fas fa-store" style="font-size:32px;color:#fff;"></i>
                            </div>
                        <?php }
                    }
                } catch (Exception $e) { ?>
                    <div style="width:80px;height:80px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:20px;margin:0 auto 16px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-store" style="font-size:32px;color:#fff;"></i>
                    </div>
                <?php } ?>
                <h1>Painel Administrativo</h1>
                <p>Acesse sua conta para continuar</p>
            </div>

            <form class="login-form" method="post" action="<?php
                echo $baseUri . '/login/';
                $token = $_GET['token'] ?? $_COOKIE['delivery_token'] ?? null;
                if ($token) echo '?token=' . htmlspecialchars($token);
            ?>">
                <div class="input-group">
                    <input type="text" name="usuario_login" id="usuario_login" placeholder="Seu usuário" required autocomplete="username">
                    <i class="fas fa-user"></i>
                </div>

                <div class="input-group has-toggle">
                    <input type="password" name="usuario_senha" id="usuario_senha" placeholder="Sua senha" required autocomplete="current-password">
                    <i class="fas fa-lock"></i>
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </button>
                </div>

                <div class="remember-me">
                    <input type="checkbox" id="lembrar" name="lembrar">
                    <label for="lembrar">
                        <span class="checkmark"><i class="fas fa-check"></i></span>
                        Lembrar de mim
                    </label>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-arrow-right"></i>
                    Entrar
                </button>
            </form>

            <div class="forgot-link">
                <a href="#" onclick="openModal(); return false;">
                    <i class="fas fa-key"></i>
                    Esqueci minha senha
                </a>
            </div>

            <div class="login-footer">
                <p>&copy; PediuZap 2021 - <?php echo date('Y'); ?> - Todos os direitos reservados</p>
            </div>
        </div>
    </div>

    <!-- Modal Recuperar Senha -->
    <div class="modal-overlay" id="modalRecuperar">
        <div class="modal-card">
            <div class="modal-header">
                <h2><i class="fas fa-key"></i> Recuperar Senha</h2>
                <button class="modal-close" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-error" id="alertError">
                    <i class="fas fa-exclamation-circle"></i>
                    <span id="alertErrorMsg"></span>
                </div>
                <div class="alert alert-success" id="alertSuccess">
                    <i class="fas fa-check-circle"></i>
                    <span id="alertSuccessMsg"></span>
                </div>
                <p>Digite seu usuário e e-mail cadastrados. Enviaremos um link para redefinir sua senha.</p>
                <form class="modal-form" id="formRecuperar">
                    <div>
                        <label>Usuário (login)</label>
                        <div class="input-group">
                            <input type="text" id="usuarioRecuperar" placeholder="Digite seu usuário" required>
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <div>
                        <label>E-mail cadastrado</label>
                        <div class="input-group">
                            <input type="email" id="emailRecuperar" placeholder="seu@email.com" required>
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn-cancel" onclick="closeModal()">Cancelar</button>
                <button class="btn-primary" id="btnEnviar" onclick="enviarRecuperacao()">
                    <i class="fas fa-paper-plane"></i>
                    Enviar link
                </button>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        function togglePassword() {
            const input = document.getElementById('usuario_senha');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Remember me - Load saved login
        document.addEventListener('DOMContentLoaded', function() {
            const savedLogin = getCookie('remembered_login');
            const savedPass = getCookie('remembered_pass');
            if (savedLogin) {
                document.getElementById('usuario_login').value = savedLogin;
                document.getElementById('lembrar').checked = true;
            }
            if (savedPass) {
                document.getElementById('usuario_senha').value = atob(savedPass);
            }
        });

        // Save login on form submit
        document.querySelector('.login-form').addEventListener('submit', function() {
            const lembrar = document.getElementById('lembrar').checked;
            const login = document.getElementById('usuario_login').value;
            const senha = document.getElementById('usuario_senha').value;

            if (lembrar && login) {
                setCookie('remembered_login', login, 30);
                setCookie('remembered_pass', btoa(senha), 30);
            } else {
                deleteCookie('remembered_login');
                deleteCookie('remembered_pass');
            }
        });

        // Cookie functions
        function setCookie(name, value, days) {
            const expires = new Date(Date.now() + days * 864e5).toUTCString();
            document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + expires + '; path=/; SameSite=Lax';
        }

        function getCookie(name) {
            const value = '; ' + document.cookie;
            const parts = value.split('; ' + name + '=');
            if (parts.length === 2) return decodeURIComponent(parts.pop().split(';').shift());
            return null;
        }

        function deleteCookie(name) {
            document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
        }

        // Modal functions
        function openModal() {
            document.getElementById('modalRecuperar').classList.add('active');
            document.getElementById('alertError').classList.remove('show');
            document.getElementById('alertSuccess').classList.remove('show');
        }

        function closeModal() {
            document.getElementById('modalRecuperar').classList.remove('active');
        }

        // Toast notification
        function showToast(message, type = 'error') {
            const toast = document.getElementById('toast');
            const toastMsg = document.getElementById('toastMessage');
            const icon = toast.querySelector('i');

            toast.className = 'toast show ' + type;
            toastMsg.textContent = message;
            icon.className = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';

            setTimeout(() => {
                toast.classList.remove('show');
            }, 4000);
        }

        // Enviar recuperação
        function enviarRecuperacao() {
            const usuario = document.getElementById('usuarioRecuperar').value;
            const email = document.getElementById('emailRecuperar').value;
            const btn = document.getElementById('btnEnviar');
            const alertError = document.getElementById('alertError');
            const alertSuccess = document.getElementById('alertSuccess');

            if (!usuario || !email) {
                alertError.querySelector('span').textContent = 'Preencha todos os campos.';
                alertError.classList.add('show');
                alertSuccess.classList.remove('show');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<div class="spinner"></div> Enviando...';
            alertError.classList.remove('show');
            alertSuccess.classList.remove('show');

            fetch('<?php echo $baseUri; ?>/login/solicitar-reset', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'usuario=' + encodeURIComponent(usuario) + '&email=' + encodeURIComponent(email)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alertSuccess.querySelector('span').textContent = data.message;
                    alertSuccess.classList.add('show');
                    document.getElementById('formRecuperar').reset();

                    setTimeout(() => {
                        closeModal();
                        showToast(data.message, 'success');
                    }, 2000);
                } else {
                    alertError.querySelector('span').textContent = data.message;
                    alertError.classList.add('show');
                }
            })
            .catch(error => {
                alertError.querySelector('span').textContent = 'Erro ao processar. Tente novamente.';
                alertError.classList.add('show');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar link';
            });
        }

        // Check for login error
        <?php if (Post::request('incorreto') != '') : ?>
            showToast('Login ou senha incorretos. Verifique seus dados.', 'error');
        <?php endif; ?>

        // Close modal on overlay click
        document.getElementById('modalRecuperar').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    </script>
</body>

</html>
