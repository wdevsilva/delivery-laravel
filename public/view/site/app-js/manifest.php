<?php
require_once __DIR__ . '/../../../lib/Registry.php';
require_once __DIR__ . '/../../../core/autoload.php';

// Configurar cabeçalhos
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');

// Obter configuração da empresa
require_once __DIR__ . '/../../../model/configModel.php';
$configModel = new configModel();
$config = $configModel->get_config();

// Definir nomes baseados na configuração da empresa
$shortName = !empty($config->config_nome) ? $config->config_nome : 'PediuZap';
$name = $shortName;

// Caminho para a logo da empresa
$logoPath = '';
if (!empty($config->config_foto)) {
    $logoFile = $config->config_foto;
    $logoFullPath = __DIR__ . '/../../../midias/logo/' . $_SESSION['base_delivery'] . '/' . $logoFile;
    if (file_exists($logoFullPath)) {
        $logoPath = '/midias/logo/' . $_SESSION['base_delivery'] . '/' . $logoFile;
    }
}

// Se não tiver logo da empresa, usar logo padrão
if (empty($logoPath)) {
    $logoPath = '/midias/img/favicons/favicon-144x144.png';
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
    "scope" => "/delivery/",
    "start_url" => "/delivery/",
    "display" => "standalone",
    "theme_color" => "#ffffff",
    "background_color" => "#ffffff",
    "icons" => $icons
];

echo json_encode($manifest, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);