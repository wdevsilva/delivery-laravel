<?php

require_once 'pagamento/app/config.php';

$baseUri = Http::base();
$config = (new configModel)->get_config();

function getRankingDonations($donations = null)
{
    if (!$donations) {
        return [];
    }

    usort($donations, function ($a, $b) {
        return $b['value'] / $a['value'];
    });

    return array_slice($donations, 0, 5);
}

// pega o último pagamento
$query = "SELECT valor, data_pagamento FROM mensalidades WHERE status = 1 ORDER BY data_pagamento DESC LIMIT 1";
$stmt  = $pdo->prepare($query);
$stmt->execute();

$recentDonations  = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?? null;
$rankingDonations = getRankingDonations($recentDonations);

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
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style-pagamento.css">
</head>

<body>
    <div id="cl-wrapper">
        <div class="container-fluid" id="pcont">
            <div class="cl-mcont">
                <div class="block-flat">
                    <div class="header">
                        <h3>
                            Plano - <?= $config->config_nome ?>
                        </h3>
                    </div>
                    <div class="content">
                        <!-- Hero -->
                        <div class="px-4 py-5">
                            <div class="d-block mx-auto mb-4 col-lg-2">
                                <!-- Ranking -->
                                <?php if ($rankingDonations): ?>
                                    <div class="card" id="ranking-donations">
                                        <div class="card-header text-center">Último Pagamento</div>
                                        <ul class="list-group list-group-flush">
                                            <?php foreach ($rankingDonations as $ranking): ?>
                                                <li class="list-group-item"><?= date('d/m/Y', strtotime($ranking['data_pagamento'])); ?>
                                                    <span class="value-donation">(R$ <?= number_format($ranking['valor'], 2, ',', ' '); ?>)</span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                <!--/ Ranking -->
                            </div>
                            <div class="text-center">
                                <h1 class="display-5 fw-bold text-body-emphasis font-circular-medium">Plano atual</h1>
                                <div class="col-lg-6 mx-auto">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <span class="info">Status:</span>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <?php if( 1 == 1 ) { ?>
                                                <span class="badge badge-concluido pull-right">Ativo</span>
                                            <?php } else { ?>
                                                <span class="badge badge-cancelado pull-right">Inativo</span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <span class="info">Expiração:</span>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <span class="pull-right"><?php if( $_SESSION['estabelecimento']['expiracao'] >= 1 ) { echo $_SESSION['estabelecimento']['expiracao']." dias"; } else { echo "Expirado"; }  ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                                    <a href="<?php echo $baseUri; ?>/pagamento/novoPlano"  class="btn btn-warning btn-lg rounded-4">Contratar novo Plano</a>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!-- Page JS -->
    <script src="js/page-index.js"></script>

</body>

</html>