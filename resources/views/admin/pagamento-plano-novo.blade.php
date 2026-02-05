<?php

require_once 'pagamento/app/config.php';
require __DIR__ . '/../../vendor/autoload.php';

use App\Common\Environment;

$baseUri = Http::base();
$config = (new configModel)->get_config();

Environment::load(__DIR__ . '/../../');

//aqui mostra no site apenas os produtos da loja acessada
$mysqli = new mysqli(getenv('DB_HOST'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_NAME'), getenv('DB_PORT'));

// pega o último pagamento
$result = $mysqli->query("SELECT * FROM planos WHERE status = '1' AND visible = '1' ORDER BY id DESC");

//$config->config_nome
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="<?= $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" /> -->
    <link href="css/style-prusia.css" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="css/style-pagamento.css">

    <link rel="stylesheet" href="http://catalogodigital.test/_core/_cdn/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://catalogodigital.test/_core/_cdn/panel/css/class.css">
    <link rel="stylesheet" href="http://catalogodigital.test/_core/_cdn/panel/css/forms.css">
    <link rel="stylesheet" href="http://catalogodigital.test/_core/_cdn/panel/css/typography.css">
    <link rel="stylesheet" href="http://catalogodigital.test/_core/_cdn/panel/css/template.css">


    <link rel="stylesheet" href="http://catalogodigital.test/_core/_cdn/lineicons/css/LineIcons.min.css">
    <link rel="stylesheet" href="http://catalogodigital.test/_core/_cdn/avatarPreview/css/filepreview.min.css">

    <link rel="stylesheet" href="http://catalogodigital.test/_core/_cdn/spectrum/css/spectrum.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="http://catalogodigital.test/_core/_cdn/sidr/css/jquery.sidr.light.min.css">

    <link rel="stylesheet" href="http://catalogodigital.test/painel/_layout/style.php?id=">
</head>

<body>
    <div class="middle minfit bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-icon ">
                        <i class="fa fa-star"></i>
                        <span>Contratar plano - <?php echo $config->config_nome; ?></span>
                    </div>
                </div>
                <div class="row">
                    <?php
                    while ($data = $result->fetch_assoc()) {
                    ?>
                        <div class="col-md-4">
                            <div class="panel-group panel-filters">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#collapse-atual_">
                                                <span class="desc"><?php echo $data['nome']; ?></span>
                                                <i class="fa fa-star"></i>
                                                <div class="clear"></div>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse-atual" class="panel-collapse collapse in">
                                        <div class="panel-body panel-body-planos">
                                            <div class="plano plano-interna">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="cover">
                                                            <span class="titulo"><?php echo $data['nome']; ?></span>
                                                            <div class="desc">
                                                                <?php echo nl2br($data['descricao']); ?>
                                                            </div>
                                                            <div class="valor">
                                                                <span class="mensal">R$ <?php echo $data['valor_mensal']; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="add-new add-center text-center">
                                                            <a href="/plano/contratar?plano=<?php echo $data['id']; ?>">
                                                                <span>Escolher plano</span>
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>