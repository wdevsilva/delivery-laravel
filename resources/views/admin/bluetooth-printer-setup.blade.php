<?php 
$baseUri = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalador Impressora Bluetooth</title>
    <link rel="stylesheet" href="<?= $baseUri ?>/delivery/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 30px;
        }
        .card-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .card-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }
        .download-section {
            padding: 30px;
        }
        .download-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 25px;
            transition: all 0.3s ease;
            background: white;
        }
        .download-card:hover {
            border-color: #667eea;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.2);
            transform: translateY(-2px);
        }
        .download-card h3 {
            color: #667eea;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .download-card .icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            flex-shrink: 0;
        }
        .btn-download {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 14px 35px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .step-indicator {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            margin-top: 30px;
        }
        .step {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        .step-number {
            width: 30px;
            height: 30px;
            background: #667eea;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            flex-shrink: 0;
            margin-right: 15px;
        }
        .alert-info {
            background: #e7f3ff;
            border-left: 4px solid #667eea;
            border-radius: 8px;
            padding: 20px;
            margin-top: 25px;
        }
        .alert-info h5 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .alert-info ul {
            margin-bottom: 0;
            padding-left: 20px;
        }
        .alert-info li {
            margin-bottom: 8px;
            line-height: 1.6;
            font-size: 15px;
        }
        p, li, .text-muted {
            font-size: 15px;
            line-height: 1.7;
        }
        .download-card ul li {
            font-size: 15px;
            line-height: 1.8;
            margin-bottom: 10px;
        }
        .step {
            font-size: 15px;
            line-height: 1.7;
        }
        .step strong {
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h1><i class="fas fa-print"></i> Instalador Impressora Bluetooth</h1>
                <p>Configure a impressão térmica via Bluetooth no Windows</p>
            </div>
            
            <div class="download-section">
                <!-- Windows Download -->
                <div class="download-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h3>
                                <div class="icon"><i class="fab fa-windows"></i></div>
                                Windows - Instalador Completo
                            </h3>
                            <p class="text-muted mb-3">
                                Instalador automático para Windows. Detecta Python, instala dependências e configura o serviço.
                            </p>
                            <ul class="mb-3">
                                <li>✅ Instalação automática do Python</li>
                                <li>✅ Configuração automática da porta COM</li>
                                <li>✅ Teste de impressão incluído</li>
                                <li>✅ Inicialização automática com Windows</li>
                            </ul>
                        </div>
                    </div>
                    <a href="<?= $baseUri ?>/delivery/install-windows.bat" download class="btn btn-download">
                        <i class="fas fa-download"></i> Baixar install-windows.bat
                    </a>
                    <a href="<?= $baseUri ?>/delivery/print_service_windows.py" download class="btn btn-download ms-2">
                        <i class="fas fa-download"></i> Baixar print_service_windows.py
                    </a>
                </div>

                <!-- PowerShell Script -->
                <div class="download-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h3>
                                <div class="icon"><i class="fas fa-terminal"></i></div>
                                Script de Inicialização Automática (Opcional)
                            </h3>
                            <p class="text-muted mb-3">
                                Configura o serviço para iniciar automaticamente com o Windows.
                            </p>
                            <ul class="mb-3">
                                <li>✅ Cria tarefa agendada no Windows</li>
                                <li>✅ Inicia automaticamente ao fazer login</li>
                                <li>✅ Configura firewall automaticamente</li>
                            </ul>
                        </div>
                    </div>
                    <a href="<?= $baseUri ?>/delivery/setup-service-windows.ps1" download class="btn btn-download">
                        <i class="fas fa-download"></i> Baixar setup-service-windows.ps1
                    </a>
                </div>

                <!-- Linux Download -->
                <div class="download-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h3>
                                <div class="icon"><i class="fab fa-linux"></i></div>
                                Linux - Serviço Python
                            </h3>
                            <p class="text-muted mb-3">
                                Arquivo Python para instalação manual em sistemas Linux.
                            </p>
                            <ul class="mb-3">
                                <li>✅ Compatível com Debian/Ubuntu</li>
                                <li>✅ Suporta /dev/rfcomm0</li>
                                <li>✅ Configuração via systemd</li>
                            </ul>
                        </div>
                    </div>
                    <a href="<?= $baseUri ?>/delivery/print_service.py" download class="btn btn-download">
                        <i class="fas fa-download"></i> Baixar print_service.py
                    </a>
                </div>

                <!-- Guia de Instalação -->
                <div class="download-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h3>
                                <div class="icon"><i class="fas fa-book"></i></div>
                                Guia Completo de Instalação
                            </h3>
                            <p class="text-muted mb-3">
                                Documentação completa com instruções passo a passo para Windows e Linux.
                            </p>
                        </div>
                    </div>
                    <a href="<?= $baseUri ?>/delivery/GUIA_INSTALACAO_IMPRESSORA_BLUETOOTH.md" download class="btn btn-download">
                        <i class="fas fa-download"></i> Baixar Guia de Instalação
                    </a>
                </div>

                <!-- Passos Rápidos -->
                <div class="step-indicator">
                    <h4 class="mb-4"><i class="fas fa-list-ol"></i> Instalação Rápida - Windows</h4>
                    
                    <div class="step">
                        <div class="step-number">1</div>
                        <div>
                            <strong>Baixar arquivos</strong><br>
                            <span class="text-muted">Baixe <code>install-windows.bat</code> e <code>print_service_windows.py</code></span>
                        </div>
                    </div>

                    <div class="step">
                        <div class="step-number">2</div>
                        <div>
                            <strong>Parear impressora Bluetooth</strong><br>
                            <span class="text-muted">Configurações → Dispositivos → Bluetooth → Adicionar "BlueTooth Printer"</span>
                        </div>
                    </div>

                    <div class="step">
                        <div class="step-number">3</div>
                        <div>
                            <strong>Executar instalador</strong><br>
                            <span class="text-muted">Botão direito em <code>install-windows.bat</code> → Executar como administrador</span>
                        </div>
                    </div>

                    <div class="step">
                        <div class="step-number">4</div>
                        <div>
                            <strong>Seguir instruções</strong><br>
                            <span class="text-muted">O instalador vai detectar tudo automaticamente e configurar o serviço</span>
                        </div>
                    </div>

                    <div class="step mb-0">
                        <div class="step-number">5</div>
                        <div>
                            <strong>Pronto!</strong><br>
                            <span class="text-muted">Acesse o sistema normalmente e clique em "Imprimir" - vai usar Bluetooth automaticamente ✅</span>
                        </div>
                    </div>
                </div>

                <!-- Avisos -->
                <div class="alert alert-info mt-4">
                    <h5><i class="fas fa-info-circle"></i> Importante</h5>
                    <ul class="mb-0">
                        <li>A impressora deve estar <strong>pareada</strong> antes de executar o instalador</li>
                        <li>É necessário executar como <strong>Administrador</strong></li>
                        <li>O serviço ficará rodando em <strong>segundo plano</strong> (porta 9100)</li>
                        <li>Se o Bluetooth falhar, o sistema usa impressora USB automaticamente</li>
                    </ul>
                </div>

                <!-- Suporte -->
                <div class="text-center mt-4">
                    <a href="<?= $baseUri ?>/delivery/admin/pedidos/" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar para Pedidos
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= $baseUri ?>/delivery/assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?= $baseUri ?>/delivery/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
