<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery.select2/dist/css/select2.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
        <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap.summernote/dist/summernote.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />
    <link href="css/btn-upload.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/bootstrap.datetimepicker/css/bootstrap-datetimepicker.css">
</head>
<style>
    .password-wrapper {
        position: relative;
    }

    .password-wrapper input {
        padding-right: 40px; /* espaço para o ícone */
    }

    .password-wrapper .toggle-password {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #6c757d;
        font-size: 16px;
    }
</style>

<body class="animated">
    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php require_once 'side-menu.php'; ?>
        </div>
        <div class="container-fluid" id="pcont">
            <!-- TOP NAVBAR -->
            <?php require_once 'top-menu.php'; ?>
            <div class="cl-mcont">
                <div class="block-flat">
                    <div class="header">
                        <h3>Informações do Site</h3>
                    </div>
                    <?php if (isset($data['config'])) : ?>
                        <div class="content">
                            <form id="formConfig" action="<?php echo $baseUri; ?>/configuracao/gravar/" method="post" role="form" autocomplete="off" enctype="multipart/form-data" data-parsley-validate="false">
                                <input type="hidden" name="config_taxa_entrega" id="config_taxa_entrega" class="form-control" placeholder="Taxa de entrega" value="<?= Currency::moedaUS($data['config']->config_taxa_entrega) ?>">
                                <input type="hidden" name="config_id" id="config_id" value="<?= $data['config']->config_id ?>">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="config_nome">Nome da empresa <span class="text-danger">*</span></label>
                                            <input type="text" name="config_nome" id="config_nome" class="form-control" placeholder="Informe o nome da empresa" value="<?= $data['config']->config_nome ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="config_endereco">Endereço da empresa <span class="text-danger">*</span></label>
                                            <input type="text" name="config_endereco" id="config_endereco" class="form-control" placeholder="Informe o endereço da empresa" value="<?= $data['config']->config_endereco ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="config_taxa_entrega">CEP da empresa
                                                <small class="pull-right"></small>
                                            </label>
                                            <input type="text" name="config_cep" id="config_cep" class="form-control cep" placeholder="Cep da empresa" value="<?= $data['config']->config_cep ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="config_taxa_entrega">CNPJ da empresa
                                                <small class="pull-right"></small>
                                            </label>
                                            <input type="text" name="config_cnpj" id="config_cnpj" class="form-control config_cnpj" placeholder="CNPJ da empresa" value="<?= $data['config']->config_cnpj ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="config_retirada" data-toggle="tooltip" title="Permitir que o cliente retire o pedido no local">Permitir retirada no local</label>
                                            <select name="config_retirada" id="config_retirada" class="form-control">
                                                <option value="0" <?= ($data['config']->config_retirada == 0) ? 'selected' : '' ?>>INATIVO</option>
                                                <option value="1" <?= ($data['config']->config_retirada == 1) ? 'selected' : '' ?>>ATIVO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="config_entrega_pedido" data-toggle="tooltip" title="Se inativo, não haverá entrega.">Permitir entregas</label>
                                            <select name="config_entrega_pedido" id="config_entrega_pedido" class="form-control">
                                                <option value="0" <?= ($data['config']->config_entrega_pedido == 0) ? 'selected' : '' ?>>INATIVO</option>
                                                <option value="1" <?= ($data['config']->config_entrega_pedido == 1) ? 'selected' : '' ?>>ATIVO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="config_nome">Telefone Whatsapp<span class="text-danger"> *</span></label>
                                            <input type="text" name="config_fone1" id="config_fone1" class="form-control fone" placeholder="Informe um telefone" value="<?= $data['config']->config_fone1 ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="config_nome">Telefone Fixo</label>
                                            <input type="text" name="config_fone2" id="config_fone2" class="form-control fone" placeholder="Informe um telefone" value="<?= $data['config']->config_fone2 ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="config_resumo_whats" data-toggle="tooltip" title="Se ativado, ao término do pedido, irá enviar para a loja e cliente o resumo do pedido no Whatsapp">Pedido no Whatsapp?</label>
                                            <select name="config_resumo_whats" id="config_resumo_whats" class="form-control">
                                                <option value="0" <?= ($data['config']->config_resumo_whats == 0) ? 'selected' : '' ?>>NÃO</option>
                                                <option value="1" <?= ($data['config']->config_resumo_whats == 1) ? 'selected' : '' ?>>SIM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="config_resumo_whats" data-toggle="tooltip" title="Se ativado, divide o valor da pizza ao meio, se desativado mantém o valor da maior">Divisão valor pizza?</label>
                                            <select name="config_divisao_valor_pizza" id="config_divisao_valor_pizza" class="form-control">
                                                <option value="0" <?= ($data['config']->config_divisao_valor_pizza == 0) ? 'selected' : '' ?>>NÃO</option>
                                                <option value="1" <?= ($data['config']->config_divisao_valor_pizza == 1) ? 'selected' : '' ?>>SIM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="config_nome">Alerta / Campainha</label>
                                            <select type="text" name="config_bell" id="config_bell" class="form-control">
                                                <option value="0" <?= ($data['config']->config_bell == 0) ? 'selected' : '' ?>>Desativada</option>
                                                <option value="1" <?= ($data['config']->config_bell == 1) ? 'selected' : '' ?>>Ativada</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="config_nome">Valor Mínimo de Pedido</label>
                                            <input type="text" name="config_pedmin" id="config_pedmin" class="form-control" placeholder="R$ 50,00" value="<?= $data['config']->config_pedmin ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="config_pix">Pagamento via pix</label>
                                            <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Se ativado, ao término do pedido, irá aparecer para o cliente um qrcode e uma chave pix referente ao pedido para pagamento"></i>
                                            <select name="config_pix" id="config_pix" class="form-control">
                                                <option value="0" <?= ($data['config']->config_pix == 0) ? 'selected' : '' ?>>NÃO</option>
                                                <option value="1" <?= ($data['config']->config_pix == 1) ? 'selected' : '' ?>>SIM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="config_pix">PIX AUTOMÁTICO</label>
                                            <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" title="Se selecionar 'Sim', a confirmação do pagamento será feita automaticamente, e o cliente não precisará enviar comprovante. Caso selecione 'Não', será necessário que o cliente envie o comprovante de pagamento. Para pagamentos automáticos, é cobrada uma taxa de 0,99% sobre cada transação realizada"></i>
                                            <select name="config_pix_automatico" id="config_pix_automatico" class="form-control" onchange="pixAutomatico(this)">
                                                <option value="0" <?= ($data['config']->config_pix_automatico == 0) ? 'selected' : '' ?>>NÃO</option>
                                                <option value="1" <?= ($data['config']->config_pix_automatico == 1) ? 'selected' : '' ?>>SIM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="config_token_mercadopago">Token Mercado Pago</label>
                                            <div class="password-wrapper">
                                                <input type="password" name="config_token_mercadopago" id="config_token_mercadopago" class="form-control" value="<?= $data['config']->config_token_mercadopago ?>">
                                                <button type="button" class="toggle-password" id="toggleToken">
                                                    <i class="fa fa-eye" id="eyeIcon"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="config_tipo_chave" data-toggle="tooltip">Tipo de chave pix</label>
                                            <select name="config_tipo_chave" id="config_tipo_chave" class="form-control" onchange="tipoChave(this)">
                                                <option value="" selected>SELECIONE</option>
                                                <option value="1" <?= ($data['config']->config_tipo_chave == 1) ? 'selected' : '' ?>>CPF</option>
                                                <option value="2" <?= ($data['config']->config_tipo_chave == 2) ? 'selected' : '' ?>>CELULAR</option>
                                                <option value="3" <?= ($data['config']->config_tipo_chave == 3) ? 'selected' : '' ?>>E-MAIL</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="config_chave_pix">Chave Pix</label>
                                            <input type="text" name="config_chave_pix" id="config_chave_pix" class="form-control" value="<?= $data['config']->config_chave_pix ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="config_pix">Tipo Taxa Cartão</label>
                                            <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-html="true" 
                                                title="Selecione a forma de como deseja cobrar a taxa de cartão de seus clientes.<br><br>
                                                <b>Taxa por Valor:</b> aplica uma taxa fixa de acordo com a faixa de valores da compra.<br>
                                                <b>Taxa por Item:</b> aplica um valor fixo multiplicado pela quantidade de itens do pedido.<br>
                                                <b>Taxa por Percentual:</b> aplica um percentual sobre o valor total da compra, variando entre débito e crédito.">
                                            </i>
                                            <select name="config_taxa_tipo" id="config_taxa_tipo" class="form-control" onchange="categoriaTaxaCartao(this)">
                                                <option value="" selected>Selecione...</option>
                                                <option value="faixa_valor" <?= ($data['config']->config_taxa_tipo == 'faixa_valor') ? 'selected' : '' ?>>Taxa por Valor</option>
                                                <option value="taxa_por_item" <?= ($data['config']->config_taxa_tipo == 'taxa_por_item') ? 'selected' : '' ?>>Taxa por Item</option>
                                                <option value="taxa_por_categoria" <?= ($data['config']->config_taxa_tipo == 'taxa_por_categoria') ? 'selected' : '' ?>>Taxa por Categoria Individual</option>
                                                <option value="percentual" <?= ($data['config']->config_taxa_tipo == 'percentual') ? 'selected' : '' ?>>Taxa por Pencentual</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="display: none;" id="divTaxaCategorias">
                                        <div class="form-group">
                                            <label for="config_pix">Categorias a cobrar Taxa Cartão</label>
                                            <i class="fa fa-info-circle" aria-hidden="true" data-toggle="tooltip" data-html="true" 
                                                title="Selecione as categorias que terão a taxa de cartão aplicada.">
                                            </i>
                                            <br>
                                            <select multiple="multiple" name="config_taxa_categorias[]" id="config_taxa_categorias" class="form-control">
                                                <?php foreach($data['categorias'] as $categoria){ ?>
                                                    <option value="<?= $categoria->categoria_id ?>" 
                                                        <?= (in_array($categoria->categoria_id, explode(',', $data['config']->config_taxa_categorias))) ? 'selected' : '' ?>>
                                                        <?= $categoria->categoria_nome ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="panel panel-default">
                                            <div style="background-color: #85c99d;color: #ffffff;" class="panel-heading">
                                                <h4 class="panel-title">
                                                    <div class="right-arrow pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
                                                    <center>
                                                        <a style="color: #ffffff; display: block; padding: 10px;" href="<?php echo $baseUri; ?>/configuracao/horarios/">
                                                            <strong>Clique aqui para Configurar Horários de Funcionamento</strong>
                                                        </a>
                                                    </center>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="config_desc">Sobre Nós</label>
                                            <textarea name="config_desc" id="config_desc" name="config_desc" class="form-control"><?= $data['config']->config_desc ?></textarea>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="config_site_keywords">Palavras-Chave (Meta Keywords)</label>
                                            <input type="text" name="config_site_keywords" id="config_site_keywords" class="form-control" placeholder="Palavras-chave" value="<?= strip_tags($data['config']->config_site_keywords) ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="config_site_description">Descrição Breve (Meta Description)</label>
                                            <input type="text" name="config_site_description" id="config_site_description" class="form-control" placeholder="Descrição Breve" value="<?= strip_tags($data['config']->config_site_description) ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="config_site_ga">Google Analytics</label>
                                            <textarea name="config_site_ga" id="config_site_ga" rows="2" placeholder="Informe o código Analytics" class="form-control"><?= $data['config']->config_site_ga ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 hide">
                                    <div class="form-group">
                                        <div class="col-md-8  hide">
                                            <span class="btn btn-primary btn-file btn-block" style="height: 50px; border-radius: 50px;">
                                                <p style="margin: 0; height: 10px;">&nbsp;</p>
                                                <span class="fileinput-exists">
                                                    <i class="fa fa-retweet"></i>
                                                    Trocar Alerta Sonoro
                                                </span>
                                                <input type="file" id="config_alert" name="config_alert" class="form-control">
                                            </span>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <p>Alerta de Novo Pedido</p>
                                                <audio controls>
                                                    <source src="<?php echo $baseUri; ?>/midias/alerta/alert.mp3" type="audio/mpeg">
                                                    Seu browser não suporta o player!
                                                </audio>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="container">
                                        <p class="text-center">
                                            <button class="btn btn-primary btn-lg" type="button" onclick="document.getElementById('formConfig').submit();"><i class="fa fa-check-circle-o"></i> Gravar Dados
                                            </button>
                                        </p>
                                    </div>
                                </div>
                        </div>
                        </form>
                </div>
            <?php endif; ?>
            </div>
        </div>
    </div>
    </div>
    <!-- Right Chat-->
    <?php //require_once 'side-right-chat.php'; 
    ?>
    <script src="js/jquery.js"></script>
    <script src="js/jquery.cooki/jquery.cooki.js"></script>
    <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="js/behaviour/core.js"></script>
    <script type="text/javascript" src="js/jquery.select2/dist/js/select2.js"></script>
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo $baseUri; ?>/assets/vendor/uf-combo/cidades-estados-1.4-utf8.js" charset="utf-8"></script>
    <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery.mask.js"></script>
    <script type="text/javascript" src="js/bootstrap.summernote/dist/summernote.min.js"></script>
    <script src="app-js/main.js"></script>
    <script src="app-js/config.js"></script>
    <!-- CALENDAR JS -->
    <script src="js/cupom-desconto/moment.js"></script>
    <script src="js/cupom-desconto/moment-pt-br.js"></script>
    <script src="js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
    <script type="text/javascript">
        
        $('#menu-config-geral').addClass('active');

        document.getElementById('toggleToken').addEventListener('click', function () {
            var input = document.getElementById('config_token_mercadopago');
            var icon = document.getElementById('eyeIcon');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        function tipoChave(select) {
            var tipo = select.options[select.selectedIndex].value;

            if (tipo == '') {
                $('#config_chave_pix').prop('disabled', true);
            } else {

                if (tipo == 1) {
                    $('#config_chave_pix').mask("999.999.999-99");
                }
                if (tipo == 2) {
                    $('#config_chave_pix').mask("(99)9 9999-9999");
                }
                $('#config_chave_pix').prop('disabled', false);
            }
        }

        function pixAutomatico(select) {
            var valor = select.options[select.selectedIndex].value;
            if (valor == 0) {
                $('#config_token_mercadopago').prop('disabled', true);
            }
            if (valor == 1) {
                $('#config_token_mercadopago').prop('disabled', false);
            }
        }
        
        function categoriaTaxaCartao(select) {
            var valor = select.options[select.selectedIndex].value;
            if (valor == 'taxa_por_item') {
                $('#divTaxaCategorias').show();
            } else {
                $('#divTaxaCategorias').hide();
            }
        }

        function pixAutomatico(select) {
            var valor = select.options[select.selectedIndex].value;
            if (valor == 0) {
                $('#config_token_mercadopago').prop('disabled', true);
            }
            if (valor == 1) {
                $('#config_token_mercadopago').prop('disabled', false);
            }
        }

        $(document).ready(function() {
            var tipoTaxa = "<?= $data['config']->config_taxa_tipo ?>";

            if(tipoTaxa === 'taxa_por_item'){
                $('#divTaxaCategorias').show();
            }

            $('#config_horario_inicio, #config_horario_fim').datetimepicker({
                format: 'H:mm'
            });

            $('#config_taxa_categorias').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true,
                maxHeight: 400,
                dropUp: true
            });
        });


        
        $('#config_pedmin').mask("#.##0,00", {
            reverse: true
        });

        <?php 
        /*if (isset($_GET['success'])) { ?>
            _alert_success();
            
            // Check if taxa_por_categoria was just configured
            <?php if (isset($data['config']->config_taxa_tipo) && $data['config']->config_taxa_tipo === 'faixa_valor'){ ?>
                setTimeout(function() {
                    if (confirm('Configuração salva com sucesso!\n\nDeseja configurar as taxas por valor agora?')) {
                        window.location.href = '<?php echo $baseUri; ?>/configuracao/taxaCard/';
                    }
                }, 1000); // Wait 1 second after success message
                
            <?php } else if (isset($data['config']->config_taxa_tipo) && $data['config']->config_taxa_tipo === 'taxa_por_categoria'){?>
                setTimeout(function() {
                    if (confirm('Configuração salva com sucesso!\n\nDeseja configurar as taxas individuais por categoria agora?')) {
                        window.location.href = '<?php echo $baseUri; ?>/configuracao/taxaPorCategoria/';
                    }
                }, 1000); // Wait 1 second after success message
            <?php } ?>
        <?php } */
        ?>

        $('#config_cep').mask("99999-999");
        $('#config_cnpj').mask("99.999.999/9999-99");
        //$('#config_taxa_entrega').mask("#.##0.00", {reverse: true});
        $('#config_retirada').val(<?= $data['config']->config_retirada ?>);
        $('#config_entrega_pedido').val(<?= $data['config']->config_entrega_pedido ?>);
        $('#config_cep_unico').val(<?= $data['config']->config_cep_unico ?>);
        $('#config_resumo_whats').val(<?= $data['config']->config_resumo_whats ?>);
        $('#config_bell').val(<?= $data['config']->config_bell ?>);
    </script>
    <script src="js/jquery.parsley/dist/parsley.js" type="text/javascript"></script>
    <script src="js/jquery.parsley/dist/pt-br.js" type="text/javascript"></script>
</body>

</html>