<?php @session_start(); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= (isset($data['config']->config_nome)) ? $data['config']->config_nome : ''; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUri; ?>/assets/vendor/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/modal.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/jquery.select2/dist/css/select2.min.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/jquery.select2/dist/css/select2-bootstrap.min.css" />
    <link rel="icon" type="image/png" href="<?php echo $baseUri; ?>/assets/logo/<?= $_SESSION['base_delivery'] ?>/<?php echo (isset($data['config'])) ? $data['config']->config_foto : ''; ?>" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/view/site/app-css/card.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/tema.php?<?php echo $data['config']->config_colors; ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/app.css" />
    <link href="<?php echo $baseUri; ?>/assets/css/main.css?v=<?= filemtime(__DIR__ . '/../../assets/css/main.css') ?>" rel="stylesheet" />
</head>

<body>
    <div class="container" id="home-content">
        <?php require_once 'menu.php'; ?>
            <div class="content <?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
                <form action="<?php echo $baseUri; ?>/cadastro/gravar/" method="post" role="form" autocomplete="off" enctype="multipart/form-data">
                    <br>
                    <?php if (isset($_GET['error']) && $_GET['error'] == 'cpf-email') : ?>
                        <div class="alert alert-danger">
                            CPF ou E-mail já está sendo utilizado por outro cliente.
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_GET['error']) && $_GET['error'] == 'email-pix') : ?>
                        <div class="alert alert-danger">
                            Para pagamentos via PIX, é obrigatório informar o e-mail
                        </div>
                    <?php endif; ?>
                    <h5 class="text-uppercase">Dados Pessoais
                        <span class="pull-right">
                            <a class="btn btn-primary btn-sm text-uppercase" href="<?php echo $baseUri; ?>/meus-enderecos/">
                                <i class="fa fa-map-marker"></i>
                                Ver meus endereços
                            </a>
                        </span>
                    </h5>
                    <div class="form-group">
                        <label for="cliente_nome" class="text-muted">Nome</label>
                        <input type="hidden" name="cliente_id" value="<?= $data['cliente']->cliente_id ?>" />
                        <input disabled type="text" name="cliente_nome" id="cliente_nome" class="form-control" value="<?= $data['cliente']->cliente_nome ?>" placeholder="Informe seu nome completo" required>
                    </div>
                    <div class="form-group">
                        <label for="cliente_nasc" class="text-muted">Data de Nascimento</label>
                        <input disabled type="text" data-mask="date" name="cliente_nasc" id="cliente_nasc" value="<?= $data['cliente']->cliente_nasc ?>" class="form-control" placeholder="Informe sua data de nascimento">
                    </div>
                    <div class="form-group">
                        <label for="cliente_cpf" class="text-muted">CPF</label>
                        <input type="text" data-mask="cpf" name="cliente_cpf" id="cliente_cpf" value="<?= $data['cliente']->cliente_cpf ?>" class="form-control" placeholder="Informe o número do documento">
                    </div>
                    <div class="form-group">
                        <label for="cliente_email" class="text-muted">E-mail</label>
                        <input type="email" name="cliente_email" id="cliente_email" value="<?= $data['cliente']->cliente_email ?>" class="form-control" placeholder="Informe o e-mail" required>
                    </div>
                    <h5 class="text-uppercase" style="margin-top: 25px">Dados de Contato</h5>

                    <div class="form-group">
                        <label for="cliente_fone2" class="text-muted">Celular</label>
                        <input disabled type="tel" data-mask="cell" placeholder="(99) 99999-9999" name="cliente_fone2" id="cliente_fone2" value="<?= $data['cliente']->cliente_fone2 ?>" required class="form-control">
                    </div>
                    <br />
                    <div class="form-group">
                        <label for="cliente_marketing_whatssapp" class="text-muted">Receber mensagens de marketing no Whatsapp?</label>
                        <select name="cliente_marketing_whatssapp" class="form-control">
                            <option value="1" <?= ($data['cliente']->cliente_marketing_whatssapp == '1') ?  'selected' : '' ?>>Sim</option>
                            <option value="0" <?= ($data['cliente']->cliente_marketing_whatssapp == '0') ?  'selected' : '' ?>>Não</option>
                        </select>
                    </div>
                    <br />
                    <div class="form-group">
                        <button class="btn btn-success btn-block text-uppercase" type="submit">
                            <i class="fa fa-refresh"></i>
                            Atualizar Cadastro
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <br>
    </div>
    <?php
    require_once 'footer.php';
    require 'side-carrinho.php';
    ?>
    <script type="text/javascript">
        var currentUri = 'index';
    </script>
    <?php require_once 'footer-core-js.php'; ?>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/main.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/cliente.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/number.js"></script>
    <script src="<?php echo $baseUri; ?>/view/site/app-js/howler.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/carrinho.js"></script>
    <?php if (isset($_GET['success'])) : ?>
        <script type="text/javascript">
            __alert__success()
        </script>
    <?php endif; ?>
    <?php if (isset($_GET['error']) && $_GET['error'] == 'cpf-email') : ?>
        <script type="text/javascript">
            __alert__error('CPF ou E-mail já está sendo utilizado por outro cliente.')
        </script>
    <?php endif; ?>
    <?php if (isset($_GET['error']) && $_GET['error'] == 'email-pix') : ?>
        <script type="text/javascript">
            __alert__error('Para pagamentos via PIX, é necessário informar o e-mail.')
        </script>
    <?php endif; ?>
    <script>
        
        
        rebind_reload();
    </script>
</body>

</html>