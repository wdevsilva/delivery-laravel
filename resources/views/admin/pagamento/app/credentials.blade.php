<?php

require __DIR__ . '/../../../../vendor/autoload.php';

use App\Common\Environment;

Environment::load(__DIR__ . '/../../../../');

// https://www.mercadopago.com.br/developers/pt/docs/credentials
const MERCADO_PAGO_CONFIG = [
    "access_token"     => "APP_USR-7272559901190722-053113-64bfa03cd5a4a69e99233c751b4b7eb5-177434634",
    "notification_url" => "https://pediuzap.com.br/delivery/view/admin/pagamento/public/payment/notification.php"
];

define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));
define('DB_NAME', getenv('DB_NAME'));

const DATABASE_CONFIG = [
    "drive"  => "mysql",
    "host"   => DB_HOST,
    "user"   => DB_USER,
    "pass"   => DB_PASS,
    "dbname" => DB_NAME
];
