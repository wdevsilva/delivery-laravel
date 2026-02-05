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
                            Pagamento de Mensalidade - <?= $config->config_nome ?>
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
                                <h1 class="display-5 fw-bold text-body-emphasis font-circular-medium">Pagar mensalidade</h1>
                                <div class="col-lg-6 mx-auto">
                                    <p class="lead mb-4">Após o pagamento o sistema o sistema séra liberado automáticamente!</p>
                                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                                        <button data-toggle="modal" data-target="#modal-donation" class="btn btn-warning btn-lg rounded-4">Pagar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal - Doação  -->
                        <div class="modal fade" id="modal-donation" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content rounded-4 shadow">
                                    <div class="modal-header p-5 pb-4 border-bottom-0">
                                        <h1 class="fw-bold mb-0 fs-3" id="modal-title">Pagamento Mensalidade</h1>
                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <!-- Body - Informações do Doador -->
                                    <div id="modal-body-payer" class="modal-body p-5 pt-0">
                                        <form id="form-donation">
                                            <div id="alert-donation" class="alert alert-danger text-center d-none" role="alert"></div>
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control rounded-3" id="nickname" placeholder="Empresa" value="<?= $config->config_nome ?>" required autofocus readonly>
                                                <label for="nickname">Empresa</label>
                                            </div>
                                            <hr />

                                            <label for="value">Valor do Pagamento</label>
                                            <div class="input-group input-group-lg mt-1 mb-3">
                                                <span class="input-group-text">R$</span>
                                                <input type="text" class="form-control" id="value" placeholder="Valor da mensalidade" value="79.90" required readonly>
                                            </div>

                                            <button type="submit" class="w-100 border-none mb-2 btn btn-lg btn-warning text-white fw-bold rounded-3">Continuar</button>
                                        </form>
                                    </div>
                                    <!--// Body - Informações do Doador -->

                                    <!-- Body - Realização da doação via PIX -->
                                    <div id="modal-body-payment" class="modal-body text-center d-none">

                                        <div id="loading" class="text-center mb-4 mt-4">
                                            <div class="spinner-border text-warning" style="width: 5rem; height: 5rem;" role="status"></div>
                                        </div>

                                        <div class="row d-none" id="payment-content">
                                            <div class="col-md-12">
                                                <img src="" id="image-qrcode-pix" style="width: 100%;" />
                                            </div>
                                            <div class="col-md-12">
                                                <textarea class="form-control" id="code-pix" rows="5" cols="80"></textarea>
                                                <button class="w-90 mt-3 rounded-4 btn btn-warning text-white btn-clipboard btn-lg px-4 gap-3" id="copyButton">Copiar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!--// Body - Realização da doação via PIX -->

                                    <!-- Body - Pagamento Aprovado -->
                                    <div id="modal-body-approved" class="modal-body text-center d-none">
                                        <p class="h5"><a href="<?= $baseUri; ?>/admin" class="w-100 border-none mb-2 btn btn-lg btn-success text-white fw-bold rounded-3">Voltar ao sistema</a></p>
                                    </div>
                                    <!--// Body - Pagamento Aprovado -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade colored-header warning md-effect-10" id="modal-remove" tabindex="-1" role="dialog">
            <div class="modal-dialog custom-width">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Remover Registro</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="i-circle warning"><i class="fa fa-warning"></i></div>
                            <h4>Atenção!</h4>
                            <p>Você está prestes à remover um registro e esta ação não pode ser desfeita. <br />
                                Deseja realmente prosseguir?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form name="form-remove" id="form-remove" action="<?= $baseUri; ?>/item/remove/" method="post">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-warning btn-flat btn-confirma-remove">Prosseguir</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade colored-header md-effect-10" id="modal-status" tabindex="-1" role="dialog">
            <div class="modal-dialog custom-width">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Alterar Status do Registro</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="i-circle warning"><i class="fa fa-warning"></i></div>
                            <h4><strong>Atenção!</strong></h4>
                            <p><strong>Você está prestes à <span id="status-exibe-nome"></span> o status de um registro
                                </strong></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form name="form-remove" id="form-status" action="<?= $baseUri; ?>/item/altera_status/" method="post">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary btn-flat btn-confirma-status">Prosseguir</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div>
    <!-- Confetti Effect -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.0/dist/confetti.browser.min.js"></script>

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!-- Page JS -->
    <script src="js/page-index.js"></script>

</body>

</html>