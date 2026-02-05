<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código não encontrado - Rastreamento</title>
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

        .error-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .error-icon {
            color: #dc3545;
            font-size: 4rem;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.8rem;
        }

        .error-message {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
            font-size: 1.1rem;
        }

        .suggestions {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            text-align: left;
        }

        .suggestions h3 {
            color: #333;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .suggestions ul {
            list-style: none;
            padding: 0;
        }

        .suggestions li {
            margin-bottom: 12px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: #666;
            line-height: 1.5;
        }

        .suggestions li i {
            color: #667eea;
            margin-top: 3px;
        }

        .btn {
            padding: 15px 25px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            font-size: 16px;
            margin: 0 5px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .contact-info {
            background: #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
        }

        .contact-info h4 {
            color: #333;
            margin-bottom: 10px;
        }

        .contact-info p {
            color: #666;
            margin: 5px 0;
        }

        @media (max-width: 480px) {
            .error-container {
                padding: 30px 20px;
                margin: 10px;
            }

            h1 {
                font-size: 1.5rem;
            }

            .error-icon {
                font-size: 3rem;
            }

            .btn {
                width: 100%;
                justify-content: center;
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        
        <h1>Código não encontrado</h1>
        
        <div class="error-message">
            <?php if (isset($data['erro'])): ?>
                <?= htmlspecialchars($data['erro']) ?>
            <?php else: ?>
                O código de rastreamento informado não foi encontrado em nossa base de dados.
            <?php endif; ?>
        </div>

        <div class="suggestions">
            <h3>
                <i class="fas fa-lightbulb"></i>
                Possíveis soluções:
            </h3>
            <ul>
                <li>
                    <i class="fas fa-check"></i>
                    <span>Verifique se o código foi digitado corretamente</span>
                </li>
                <li>
                    <i class="fas fa-check"></i>
                    <span>Códigos têm entre 8 e 16 caracteres (letras e números)</span>
                </li>
                <li>
                    <i class="fas fa-check"></i>
                    <span>O rastreamento só fica disponível após o pedido sair para entrega</span>
                </li>
                <li>
                    <i class="fas fa-check"></i>
                    <span>Códigos de rastreamento podem levar alguns minutos para ser ativados</span>
                </li>
            </ul>
        </div>

        <div style="margin-bottom: 20px;">
            <a href="<?= $baseUri ?>/entrega-tracking/track/" class="btn btn-primary">
                <i class="fas fa-search"></i>
                Tentar Novamente
            </a>
            
            <a href="<?= $baseUri ?>/" class="btn btn-secondary">
                <i class="fas fa-home"></i>
                Voltar ao Início
            </a>
        </div>

        <div class="contact-info">
            <h4><i class="fas fa-headset"></i> Precisa de ajuda?</h4>
            <p>Se o problema persistir, entre em contato conosco:</p>
            <p><strong>WhatsApp:</strong> Entre em contato através do nosso site</p>
            <p><strong>Horário:</strong> Segunda a Domingo, 24h</p>
        </div>
    </div>
</body>
</html>