<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obter Access Token de Produção – Mercado Pago</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 20px;
            max-width: 900px;
            margin: auto;
        }

        h1 {
            color: #00a650;
        }

        section {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .step {
            margin-bottom: 20px;
        }

        .step img {
            max-width: 100%;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 10px;
        }

        .note {
            background: #e6f4ea;
            padding: 12px;
            border-left: 4px solid #00a650;
            border-radius: 4px;
        }
    </style>
</head>

<body>

    <h1>Como obter o Access Token de Produção do Mercado Pago 💳</h1>

    <section class="note">
        <strong>Obs:</strong> Antes de obter seu token, é necessário criar uma aplicação no painel "Suas integrações".
    </section>

    <section class="step">
        <h2>1. Faça login no portal de desenvolvedores</h2>
        <p>Acesse <a href="https://www.mercadopago.com.br/developers/pt" target="_blank">Mercado Pago Developers</a> e clique em "Entrar" no canto superior, fazendo login com sua conta.</p>
    </section>

    <section class="step">
        <h2>2. Vá em "Suas integrações"</h2>
        <p>Após logar, clique na aba <strong>Suas integrações</strong> para acessar suas integrações existentes ou criar uma nova.</p>
        <img src="<?php echo $baseUri; ?>/view/admin/images/create-application-1-pt-rebranding.png" alt="Painel Suas Integrações">
    </section>

    <section class="step">
        <h2>3. Crie sua aplicação</h2>
        <p>No canto superior direito, clique em <strong>"Criar aplicação"</strong>. Preencha o nome e selecione os produtos (ex.: Checkout Pro).</p>
        <img src="<?php echo $baseUri; ?>/view/admin/images/create-application-2-pt-rebranding.png" alt="Botão Criar Aplicação">
    </section>

    <section class="step">
        <h2>4. Veja os detalhes da aplicação</h2>
        <p>Depois de criada, clique na sua aplicação para abrir a tela com suas credenciais.</p>
        <img src="<?php echo $baseUri; ?>/view/admin/images/applications-pt-rebranding.png" alt="Credenciais de Produção">
    </section>

    <section class="step">
        <h2>5. Copie seu Access Token de Produção</h2>
        <p>Na seção <strong>Credenciais de produção</strong>, copie o <strong>Access Token</strong> e armazene-o com segurança. Ele será usado nas suas chamadas à API.</p>
        <img src="<?php echo $baseUri; ?>/view/admin/images/credentials-prod-panel-pt-rebranding.jpg" alt="Credenciais de Produção">
    </section>
    
    <section class="step">
        <h2>6. Configure uma chave Pix na sua conta</h2>
        <p>Para utilizar a API Pix do Mercado Pago, é <strong>obrigatório</strong> que sua conta tenha pelo menos uma <strong>chave Pix cadastrada e ativa</strong>. Caso não tenha, acesse seu painel do Mercado Pago e cadastre uma chave Pix na seção "Receber com Pix".</p>
    </section>
</body>

</html>