<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Pedido - Rastreamento</title>
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

        .search-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .logo {
            color: #667eea;
            font-size: 4rem;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 15px;
            font-size: 2rem;
        }

        .subtitle {
            color: #666;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .search-form {
            margin-bottom: 30px;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 20px 25px;
            border: 2px solid #e1e1e1;
            border-radius: 15px;
            font-size: 18px;
            text-align: center;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: border-color 0.3s;
        }

        .input-group input:focus {
            outline: none;
            border-color: #667eea;
        }

        .input-group i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 1.2rem;
        }

        .btn-search {
            width: 100%;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-search:hover {
            transform: translateY(-2px);
        }

        .info-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin-top: 30px;
        }

        .info-title {
            color: #333;
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-list {
            text-align: left;
            color: #666;
            line-height: 1.8;
        }

        .info-list li {
            margin-bottom: 8px;
        }

        .example-code {
            background: #e9ecef;
            padding: 10px 15px;
            border-radius: 8px;
            font-family: monospace;
            font-size: 16px;
            letter-spacing: 1px;
            margin: 15px 0;
            display: inline-block;
        }

        @media (max-width: 480px) {
            .search-container {
                padding: 30px 20px;
                margin: 10px;
            }

            h1 {
                font-size: 1.8rem;
            }

            .logo {
                font-size: 3rem;
            }
        }
    </style>
</head>
<body>
    <div class="search-container">
        <div class="logo">
            <i class="fas fa-search-location"></i>
        </div>
        
        <h1>Rastrear Pedido</h1>
        <p class="subtitle">
            Digite o código de rastreamento do seu pedido para acompanhar a entrega em tempo real
        </p>

        <form class="search-form" method="GET" action="<?= $baseUri ?>/entrega-tracking/track/">
            <div class="input-group">
                <i class="fas fa-barcode"></i>
                <input 
                    type="text" 
                    name="code" 
                    placeholder="CÓDIGO DO PEDIDO"
                    required
                    pattern="[A-Z0-9]{8,16}"
                    title="Digite um código válido"
                    maxlength="16"
                >
            </div>
            
            <button type="submit" class="btn-search">
                <i class="fas fa-search"></i>
                Rastrear Pedido
            </button>
        </form>

        <div class="info-section">
            <div class="info-title">
                <i class="fas fa-info-circle"></i>
                Como funciona?
            </div>
            <ul class="info-list">
                <li><strong>1.</strong> Digite o código de rastreamento do seu pedido</li>
                <li><strong>2.</strong> Acompanhe a localização do entregador em tempo real</li>
                <li><strong>3.</strong> Receba atualizações sobre o status da entrega</li>
                <li><strong>4.</strong> Veja o tempo estimado de chegada</li>
            </ul>
            
            <div style="margin-top: 20px;">
                <strong>Exemplo de código:</strong>
                <div class="example-code">A1B2C3D4E5F6</div>
            </div>
        </div>
    </div>

    <script>
        // Formatação automática do código
        document.querySelector('input[name="code"]').addEventListener('input', function(e) {
            let value = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            e.target.value = value;
        });

        // Verificar se há código na URL
        const urlParams = new URLSearchParams(window.location.search);
        const codeParam = urlParams.get('code');
        if (codeParam) {
            document.querySelector('input[name="code"]').value = codeParam;
        }
    </script>
</body>
</html>