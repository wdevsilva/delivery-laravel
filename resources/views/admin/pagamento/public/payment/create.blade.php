<?php

session_start();

// Conexão com o banco de dados e credenciais do mercado pago
require_once  __DIR__ . '/../../app/config.php';

// Verifica se todos os dados necessários foram recebidos.
$data = checkDataRequest(["nickname", "valueToPay"]);

$empresa    = $data->nickname;
$base       = $_SESSION['base_delivery'];
$prefix     = $_SESSION['prefix_delivery'] ?? '';
$email      = "pediuzap@pediuzap.com.br";
$valueToPay = (float) str_replace(',', '.', '79.90'); //$data->valueToPay

// Verifica se é um apelido válido:
if (!preg_match('/^[a-zA-Z0-9_.\s]{2,}$/', $empresa)) {
    return jsonResponse("error", "Informe o nome da empresa válido");
}

// Verifica se o valor da doação é válida:
if (!filter_var($valueToPay, FILTER_VALIDATE_FLOAT) or $valueToPay <= 0) {
    return jsonResponse("error", "informe um valor válido.");
}

// Responsável por indentificar a doação na hora da atualização do status de pagamento.
$externalReference = password_hash(uniqid(), PASSWORD_DEFAULT);

// Salva os dados da doação no banco de bancos como pagamento pendente:
$sql  = "INSERT INTO pagamento_mensalidade_pix (external_reference, empresa, base,  value, status) VALUES (:external_reference, :empresa, :base, :value, :status)";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(":external_reference", $externalReference);
$stmt->bindValue(":empresa", $empresa);
$stmt->bindValue(":base", $base);
$stmt->bindValue(":value", $valueToPay);
$stmt->bindValue(":status", "pending");
$stmt->execute();

$donationId = $pdo->lastInsertId() ?? null;

//
$db_port = getenv('DB_PORT') ?: 3306;
$mysqli = new mysqli(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), $prefix . $base, $db_port);

$result = $mysqli->query("SELECT * FROM mensalidades ORDER BY id DESC LIMIT 1");

if ($result && $result->num_rows != 0) {

    $row = $result->fetch_assoc();

    $periodo = $row['data_vencimento'];
    $pagamento = date('Y-m-d', strtotime($row['data_vencimento'] . ' +1 month'));

    $result = $mysqli->query("INSERT INTO mensalidades (periodo, data_vencimento, data_pagamento, valor, status) 
    VALUES ('$periodo', '$pagamento', NOW(), $valueToPay, 0)");

} else {    
    $result = $mysqli->query("INSERT INTO mensalidades (periodo, data_vencimento, data_pagamento, valor, status) 
    VALUES (NOW(),NOW(),NOW(), $valueToPay, 0)");
}   

// Verifica se a doação foi salva no banco:
if (!$donationId) {
    return jsonResponse("error", "Ops! Ocorreu um erro ao salvar os dados.");
}

/**
 * Enviando os dados para o Mercado Pago:
 */

// Informações do doador:
$payer = [
    "first_name" => $empresa,
    "email"      => $email
];

// Informações sobre o pagamento:
$informations = [
    "notification_url"   => MERCADO_PAGO_CONFIG['notification_url'],
    "description"        => "Pagamento {$empresa} mensalidade delivery",
    "external_reference" => $externalReference,
    "transaction_amount" => $valueToPay,
    "payment_method_id"  => "pix"
];

$payment = array_merge(["payer" => $payer], $informations);
$payment = json_encode($payment);


// Envia os dados via cURL para a API do Mercado Pago:
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL            => "https://api.mercadopago.com/v1/payments",
    CURLOPT_CUSTOMREQUEST  => 'POST',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS     => $payment,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . MERCADO_PAGO_CONFIG['access_token'],
        'Content-Type: application/json'
    ]
]);

// Resposta do Mercado Pago com os dados de pagamento.
$response = curl_exec($curl);
curl_close($curl);


// Filtra somente os dados que serão necessários para a realização do pagamento via Pix.
$response = json_decode($response, true);
$response = $response['point_of_interaction']['transaction_data'];


return jsonResponse("success", "", [
    "status"             => "success",
    "code"               => $response['qr_code'],          // Código copia e cola.
    "qr_code_base64"     => $response['qr_code_base64'],  // Imagem do QR Code em base64.
    "ticket_url"         => $response['ticket_url'],     // Link de pagamento pelo próprio site do Mercado Pago.
    "external_reference" => $externalReference
]);
