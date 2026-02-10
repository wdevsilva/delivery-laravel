<?php @session_start(); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= (isset($data['config']->config_nome)) ? $data['config']->config_nome : ''; ?></title>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/style.css"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/modal.css"/>
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/jquery.select2/dist/css/select2.min.css"/>
    <link rel="stylesheet"
          href="<?php echo $baseUri; ?>/assets/vendor/jquery.select2/dist/css/select2-bootstrap.min.css"/>
    <link rel="icon" type="image/png"
          href="<?php echo $baseUri; ?>/assets/logo/<?=$_SESSION['base_delivery']?>/<?php echo $data['config']->config_foto; ?>"/>
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/view/site/app-css/card.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/tema.php?<?php echo $data['config']->config_colors; ?>" type="text/css"/>
</head>
<body style="background: url('<?php echo $baseUri; ?>/assets/img/body-bg.jpg') center center repeat rgb(229, 221, 213);transform: none;overflow: visible;">
<?php require_once 'menu.php'; ?>
<div class="container-fluid" id="home-content">
            <div class="row">
                <div class="cl-mcont">
                    <h3 class="text-center">Cadastrar Cliente</h3>
                    <div class="block-flat">
                        <div class="header">
                            <h3>Dados Cliente
                                <span class="pull-right"><a href="<?php echo $baseUri; ?>/cliente/" class="btn btn-primary"><i class="fa fa-chevron-circle-left"></i> Listar Clientes</a></span>
                            </h3>
                        </div>
                        <div class="content">
                            <form action="<?php echo $baseUri; ?>/cliente/gravar/" method="post" role="form" autocomplete="off">
                                <div class="form-group">
                                    <label>Nome</label> <input type="text"  name="cliente_nome"  id="cliente_nome" class="form-control" placeholder="Informe o nome do contato responsável" required>
                                </div>
                                <!-- <div class="form-group">
                                    <label>CPF</label> <input type="text" data-mask="cpf" name="cliente_cpf"  id="cliente_cpf" class="form-control" placeholder="Informe o número do documento">
                                </div>                                         -->
                                <div class="header">
                                    <h4>Contato</h4>
                                </div>
                                <div class="form-group">
                                    <label>Email</label> <input type="email" name="cliente_email" id="cliente_email" class="form-control" placeholder="informe um email válido"  required>
                                </div>
                                <div class="form-group">
                                    <label>Celular</label> <input type="text" data-mask="phone" placeholder="(99) 99999-9999"  name="cliente_fone2"  id="cliente_fone2" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Fone Fixo</label> <input type="text" data-mask="phone" placeholder="(99) 9999-9999"  name="cliente_fone"  id="cliente_fone" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Fone Personalizado</label> <input type="text" placeholder="(99) 999-999-999 (WhatsApp)"  name="cliente_fone3"  id="cliente_fone3" class="form-control">
                                </div>

                                <p class="text-center hidden-xs">
                                    <button class="btn btn-success btn-lg" type="submit"><i class="fa fa-check-circle-o"></i> Gravar Dados</button>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
    	document.onkeydown = function(e) {
            if (e.ctrlKey && (e.keyCode === 67 || e.keyCode === 86 || e.keyCode === 85 ||    e.keyCode === 117 || e.keycode === 17 || e.keycode === 85)) {
                return false;
            }
        };

    	</script>
    </body>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/jquery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>
</html>
