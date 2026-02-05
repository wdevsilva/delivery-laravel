<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// Permitir CORS para PWA
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');

// Obter token da URL
$token = $_GET['token'] ?? '';

if (empty($token)) {
    http_response_code(400);
    echo json_encode(['error' => 'Token obrigatório']);
    exit;
}

// Conectar ao banco principal para buscar base
try {
    // Carregar .env do Laravel
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    $port = $_ENV['DB_PORT'] ?? 3306;
    $host = $_ENV['DB_HOST'] ?? 'localhost';
    if ($host === 'localhost') {
        $host = '127.0.0.1';
    }
    $pdo_main = new PDO(
        'mysql:host=' . $host . ';port=' . $port . ';dbname=sysvon10_sysvon',
        $_ENV['DB_USERNAME'] ?? 'root',
        $_ENV['DB_PASSWORD'] ?? ''
    );
    $pdo_main->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Busca dados da empresa pelo token
    $query_permissao = $pdo_main->prepare("SELECT base FROM bases WHERE ativo = 1 AND token = :token");
    $query_permissao->bindParam(':token', $token);
    $query_permissao->execute();
    $row_permissao = $query_permissao->fetch(PDO::FETCH_ASSOC);

    if (!$row_permissao) {
        http_response_code(404);
        echo json_encode(['error' => 'Token inválido ou base inativa']);
        exit;
    }

    // Configurar sessão temporária para esta requisição
    $base_delivery = $row_permissao['base'];

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao identificar base: ' . $e->getMessage()]);
    exit;
}

// Obter configuração da empresa
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

// Configurar conexão para a base específica
$dbHost = $_ENV['DB_HOST'] ?? 'localhost';
if ($dbHost === 'localhost') {
    $dbHost = '127.0.0.1';
}
\Illuminate\Support\Facades\Config::set('database.connections.tenant', [
    'driver' => 'mysql',
    'host' => $dbHost,
    'port' => $_ENV['DB_PORT'] ?? 3306,
    'database' => 'pediuzap10_' . $base_delivery,
    'username' => $_ENV['DB_USERNAME'] ?? 'root',
    'password' => $_ENV['DB_PASSWORD'] ?? '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
]);

$config = DB::connection('tenant')->table('config')->first();

// Definir nomes baseados na configuração da empresa
$shortName = !empty($config->config_nome) ? $config->config_nome : 'PediuZap';
$name = $shortName;

// Caminho para a logo da empresa
$logoPath = '';
if (!empty($config->config_foto)) {
    $logoFile = $config->config_foto;
    $logoFullPath = __DIR__ . 'logo/' . $base_delivery . '/' . $logoFile;
    if (file_exists($logoFullPath)) {
        $logoPath = 'logo/' . $base_delivery . '/' . $logoFile;
    }
}

// Se não tiver logo da empresa, usar logo padrão
if (empty($logoPath)) {
    $logoPath = 'img/favicons/favicon-144x144.png';
}

// Icones baseados na logo da empresa
$icons = [
    [
        "src" => $logoPath,
        "sizes" => "32x32",
        "type" => "image/png",
        "density" => "0.75"
    ],
    [
        "src" => $logoPath,
        "sizes" => "48x48",
        "type" => "image/png",
        "density" => "1.0"
    ],
    [
        "src" => $logoPath,
        "sizes" => "64x64",
        "type" => "image/png",
        "density" => "2.0"
    ],
    [
        "src" => $logoPath,
        "sizes" => "128x128",
        "type" => "image/png",
        "density" => "2.0"
    ],
    [
        "src" => $logoPath,
        "sizes" => "144x144",
        "type" => "image/png",
        "density" => "3.0"
    ]
];

// Manifesto PWA
$manifest = [
    "short_name" => $shortName,
    "name" => $name,
    "version" => "1.0.2",
    "scope" => "/",
    "start_url" => "/?token=" . urlencode($token),
    "display" => "standalone",
    "theme_color" => "#ffffff",
    "background_color" => "#ffffff",
    "orientation" => "portrait",
    "prefer_related_applications" => false,
    "icons" => $icons
];

echo json_encode($manifest, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
