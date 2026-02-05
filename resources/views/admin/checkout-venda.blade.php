<?php error_reporting(0); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

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
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/btn-upload.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/produto.css" />
</head>

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
                    <div class="content">
                        <?php $isMobile = ''; ?>
                        <form action="<?php echo $baseUri; ?>/admin/confirmar/" method="post" id="form-pedido" onsubmit="return validaPagamento()">
                            <input type="hidden" name="pedido_local" id="pega-endereco2" /><br>
                            <?php if ($data['config']->config_aberto == 0) : ?>
                                <button class="btn btn-block btn-danger text-uppercase no-radius" type="button">
                                    <i class="fa fa-exclamation-triangle"></i> Estamos fechados!<br>
                                    <?php
                                    $dataInicial = new DateTime();
                                    $config_segunda = $data['config']->config_segunda;
                                    if (!empty($config_segunda)) :
                                        $segunda1 = explode(" ", $config_segunda);
                                        $segunda2 = explode("-", $segunda1[1]);
                                        $segunda  = $segunda2[0];
                                    endif;
                                    $segunda = (!empty($config_segunda) && $segunda1[0] == 'on' ? '' . $segunda . '' : '');

                                    $config_terca = $data['config']->config_terca;
                                    if (!empty($config_terca)) :
                                        $terca1 = explode(" ", $config_terca);
                                        $terca2 = explode("-", $terca1[1]);
                                        $terca  = $terca2[0];
                                    endif;
                                    $terca = (!empty($config_terca) && $terca1[0] == 'on' ? '' . $terca . '' : '');

                                    $config_quarta = $data['config']->config_quarta;
                                    if (!empty($config_quarta)) :
                                        $quarta1 = explode(" ", $config_quarta);
                                        $quarta2 = explode("-", $quarta1[1]);
                                        $quarta  = $quarta2[0] . ':00';
                                    endif;
                                    $quarta = (!empty($config_quarta) && $quarta1[0] == 'on' ? '' . $quarta . '' : '');

                                    $config_quinta = $data['config']->config_quinta;
                                    if (!empty($config_quinta)) :
                                        $quinta1 = explode(" ", $config_quinta);
                                        $quinta2 = explode("-", $quinta1[1]);
                                        $quinta  = $quinta2[0] . ':00';
                                    endif;
                                    $quinta = (!empty($config_quinta) && $quinta1[0] == 'on' ? '' . $quinta . '' : '');

                                    $config_sexta = $data['config']->config_sexta;
                                    if (!empty($config_sexta)) :
                                        $sexta1 = explode(" ", $config_sexta);
                                        $sexta2 = explode("-", $sexta1[1]);
                                        $sexta  = $sexta2[0] . ':00';
                                    endif;
                                    $sexta = (!empty($config_sexta) && $sexta1[0] == 'on' ? '' . $sexta . '' : '');

                                    $config_sabado = $data['config']->config_sabado;
                                    if (!empty($config_sabado)) :
                                        $sabado1 = explode(" ", $config_sabado);
                                        $sabado2 = explode("-", $sabado1[1]);
                                        $sabado  = $sabado2[0] . ':00';
                                    endif;
                                    $sabado = (!empty($config_sabado) && $sabado1[0] == 'on' ? '' . $sabado . '' : '');

                                    $config_domingo = $data['config']->config_domingo;
                                    if (!empty($config_domingo)) :
                                        $domingo1 = explode(" ", $config_domingo);
                                        $domingo2 = explode("-", $domingo1[1]);
                                        $domingo  = $domingo2[0] . ':00';
                                    endif;
                                    $domingo = (!empty($config_domingo) && $domingo1[0] == 'on' ? '' . $domingo . '' : '');

                                    switch (date('w')) {
                                        case '0':
                                            $dataFinal = new DateTime($domingo);
                                            break;
                                        case '1':
                                            $dataFinal = new DateTime($segunda);
                                            break;
                                        case '2':
                                            $dataFinal = new DateTime($terca);
                                            break;
                                        case '3':
                                            $dataFinal = new DateTime($quarta);
                                            break;
                                        case '4':
                                            $dataFinal = new DateTime($quinta);
                                            break;
                                        case '5':
                                            $dataFinal = new DateTime($sexta);
                                            break;
                                        case '6':
                                            $dataFinal = new DateTime($sabado);
                                            break;
                                    };

                                    $diferenca = $dataInicial->diff($dataFinal);

                                    if ($diferenca->h != 0) {
                                        echo sprintf("<br>Abriremos em %d horas, %d minutos", $diferenca->h, $diferenca->i);
                                    }
                                    ?>
                                </button>
                                <h3 class="text-center">
                                    <br>
                                    <?php echo $data['config']->config_horario; ?>
                                </h3>
                            <?php else : ?>
                                <?php $total = Currency::moeda(Carrinho::get_total(), 'double'); ?>
                                <input type="hidden" name="pedido_total" id="pedido_total" value="<?= str_replace(',', '.', $total); ?>" />
                                <?php if (Carrinho::isfull()) : ?>
                                    <section id="pedido-itens">
                                        <h4><strong>Itens do pedido</strong></h4>
                                        <?php
                                        $total_itens = 0;
                                        foreach (Carrinho::get_all() as $cart) :
                                            if (in_array($cart->categoria_id, explode(',', $data['config']->config_taxa_categorias))) {
                                                $total_itens += $cart->qtde;
                                            }
                                        ?>
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <p class="text-capitalize">
                                                        <span id="sp-qt-<?= $cart->item_hash ?>"><?= ($cart->qtde <= 9) ? "0$cart->qtde" : $cart->qtde ?></span>
                                                        <small class="text-muted">x</small>
                                                        <?= strtolower($cart->categoria_nome) ?>
                                                        <?php if (strrpos($cart->extra, '1/2') === false) { ?>
                                                            - <?= strtolower($cart->item_nome) ?>
                                                        <?php } ?>
                                                        <span class="pull-right">
                                                            R$ <?= Currency::moeda($cart->total * $cart->qtde) ?>
                                                            <?= ($cart->extra_preco) ? '<br>adicionais R$' . Currency::moeda($cart->extra_preco) : '' ?>
                                                        </span>
                                                        <br>
                                                        <small class="text-muted">
                                                            <?php if (strlen($cart->extra) <= 0) : ?>
                                                                <?= strtolower($cart->item_obs) ?>
                                                            <?php endif; ?>
                                                            <?= strtolower($cart->extra) ?>
                                                        </small>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php endforeach;
                                        Carrinho::check_promocao();
                                        ?>
                                        <hr>
                                        <input type="hidden" name="total_itens" id="total_itens" value="<?= $total_itens ?>" />
                                    </section>
                                    <section id="pedido-obs">
                                        <div class="form-group">
                                            <h5><b>Alguma observação?</b></h5>
                                            <textarea class="form-control" name="pedido_obs" id="pedido_obs" placeholder="Ex: tirar cebola, maionese à parte, etc..." rows="2"><?= (isset($_SESSION['__OBS__'])) ? $_SESSION['__OBS__'] : ''; ?></textarea>
                                        </div>
                                        <hr>
                                    </section>
                                    <section id="pedido-enderecos">
                                        <h5><strong>Onde deseja receber seu pedido?</strong></h5>
                                        <select class="form-control" name="pedido_local" id="pedido_local">
                                            <option value="" data-cep="" data-bairro="" selected>Selecione uma opção...</option>
                                            <?php if ($data['config']->config_retirada == 1) : ?>
                                                <option value="0" data-cep="0">Retirar no Local</option>                                                
                                            <?php endif; ?>
                                            <?php foreach ($data['endereco'] as $end) : ?>
                                                <option value="<?= $end->endereco_id ?>" data-bairro="<?= $end->endereco_bairro_id ?>" data-cep="<?= $end->endereco_cep ?>" data-tempo="<?= $end->bairro_tempo ?>">
                                                    <?= ucfirst($end->endereco_nome) ?> em
                                                    <?= $end->endereco_bairro ?> (<?= $end->bairro_tempo ?>)
                                                </option>
                                            <?php endforeach; ?>
                                            <option value="-1" data-cep="0">Cadastrar novo endereço</option>
                                        </select>
                                        <hr>
                                    </section>
                                    <section id="pedido-cupom">
                                        <?php if (!isset($_SESSION['__CUPOM__'])) : ?>
                                            <div class="row">
                                                <div class="col-xs-8">
                                                    <input type="text" class="form-control text-uppercase" id="cupom_nome" placeholder="Cupom de desconto">
                                                </div>
                                                <div class="col-xs-4">
                                                    <div>
                                                        <button type="button" onclick="aplica_cupom()" class="btn btn-primary btn-block text-left">
                                                            <i class="fa fa-ticket text-white"></i> Aplicar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else : ?>
                                            <p class="text-center text-success">
                                                <i class="fa fa-check-circle-o"></i> CUPOM: <?= $_SESSION['__CUPOM__']->cupom_nome ?>
                                                <br>
                                                <br>
                                                <button type="button" onclick="remove_cupom()" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash-o"></i>
                                                    Remover Cupom
                                                </button>
                                            </p>
                                        <?php endif; ?>
                                        <hr>
                                    </section>
                                    <div class="form-group">
                                        <h5 class="text-left"><strong>Forma de pagamento</strong></h5>
                                        <select disabled class="form-control" name="forma_pagamento" id="forma-pagamento" required>
                                            <option value="">Selecione uma opção...</option>
                                            <?php if ($data['pagamento']->pagamento_status == 1) : ?>
                                                <option value="7">Cartão de Crédito (Pagamento Online)</option>
                                            <?php endif; ?>
                                            <option value="1">Dinheiro (na entrega)</option>
                                            <option value="2">Cartão de Débito (na entrega)</option>
                                            <option value="3">Cartão de Crédito (na entrega)</option>
                                            <?php if ($data['config']->config_pix == 1) { ?>
                                                <option value="4">PIX</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <section id="pedido-valores">
                                        <?php if (isset($_SESSION['__CUPOM__'])) : ?>
                                            <p class="text-right">
                                                <span id="cupomrm_resposta">
                                                    Descontos
                                                    <span style="display:inline-block;width: 65px;">
                                                        <?php if ($_SESSION['__CUPOM__']->cupom_tipo == 1) : ?>
                                                            R$ <?= number_format($_SESSION['__CUPOM__']->cupom_valor, 2, ',', '') ?>
                                                        <?php else : ?>
                                                            <?= $_SESSION['__CUPOM__']->cupom_percent ?>%
                                                        <?php endif; ?>
                                                    </span>
                                                </span>
                                            </p>
                                        <?php endif; ?>
                                        <h3 class="text-right">
                                            <?php if ($_SESSION['base_delivery'] == 'paulistalanches' || $_SESSION['base_delivery'] == 'dgustsalgados') { ?>
                                                <small>Taxa cartão <span id="taxa-cartao">R$ 0,00</span></small><br>
                                            <?php } ?>
                                            <small>Taxa de entrega <span id="taxa-faixa">R$ 0,00</span></small><br>
                                            Total
                                            <span id="pedido-total">R$ <?= $total; ?></span>
                                        </h3>
                                        <div class="hidden-xs row"></div>
                                        <hr>
                                    </section>
                                    <hr>
                                    <div class="form-group hide" id="forma-pagamento-troco-bandeira">
                                        <label id="troco-bandeira-label">Troco para quanto?</label>
                                        <input type="text" id="troco-bandeira" name="troco-bandeira" class="form-control" />
                                    </div>
                                    <input type="hidden" id="pedido_id_pagto" name="pedido_id_pagto" />
                                    <input type="hidden" id="pedido_obs_pagto" name="pedido_obs_pagto" />
                                    <input type="hidden" id="pedido_bairro" name="pedido_bairro" class="pedido_bairro" />
                                    <input type="hidden" id="pedido_taxa_cartao" name="pedido_taxa_cartao" />
                                    <p class="visible-xs">
                                        <br><br><br><br><br><br>
                                    </p>
                                    <input type="hidden" id="pedido_entrega_prazo" name="pedido_entrega_prazo" />
                                    <br>
                                    <div class="divi-btn-finaliza">
                                        <button type="submit" disabled class="btn btn-block btn-success text-uppercase" id="btn-pedido-concluir" <?php if (Carrinho::get_total() <= 0) : ?> disabled<?php endif; ?>>
                                            <i class="fa fa-check-circle-o"></i>
                                            Finalizar venda
                                        </button>
                                        <br><br>
                                    </div>
                                <?php else : ?>
                                    <div class="text-center">
                                        <br><br><br>
                                        <img src="<?php echo $baseUri; ?>/assets/thumb.php?zcx=3&w=218&h=178&src=img/icon-triste.png" alt="...">
                                    </div>
                                    <div class="text-center">
                                        <h4><b>Sacola Vazia</b></h4>
                                        <p class="text-center">
                                            <br><br><br>
                                            <a href="<?php echo $baseUri; ?>/" class="btn btn-warning btn-block text-uppercase">
                                                <i class="fa fa-shopping-cart"></i>
                                                Comece aqui o seu pedido
                                            </a>
                                        </p>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </form>
                        <?php include __DIR__ . '/../site/side-carrinho.php'; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var currentUri = '';
    </script>
    <script>
        var baseUri = '<?= $baseUri; ?>';
    </script>
    <script type="text/javascript">
        var isMobile = '<?= ($isMobile) ? true : false; ?>';
    </script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/jquery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript">
        var totalCompra = '<?= Currency::moedaUS(Carrinho::get_total()) ?>';
        var empresa = "<?= $_SESSION['base_delivery'] ?>";
        var pedido_entrega_prazo = $('#pedido_entrega_prazo').val();
        <?php if (isset($_SESSION['__LOCAL__'])) : ?>
            <?php $local = intval($_SESSION['__LOCAL__']); ?>
            $('#pedido_local').val('<?= $local; ?>');
            setTimeout(function() {
                $('#pedido_local').trigger('change');
            }, 300);
        <?php endif; ?>
        $('#pedido_obs').focus();

        <?php if (Carrinho::get_total() < $data['config']->config_pedmin) : ?>
            var url = baseUri + "/carrinho/reload/";
            $.post(url, {}, function(data) {
                $("#carrinho-lista").html(data);
                rebind_add();
                rebind_del();
                rebind_get_count();
                rebind_get_count_bag();
                $('[data-toggle="tooltip"]').tooltip();
                $('#modal-carrinho').modal('show');
                setTimeout(function() {
                    window.location = baseUri;
                }, 4000)
            });
        <?php endif; ?>
    </script>
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
    <script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/jquery.maskedinput/jquery.mask.js"></script>
    <?php require_once 'switch-color.php'; ?>
    <script src="app-js/main.js"></script>
    <script src="js/jquery.parsley/dist/parsley.js" type="text/javascript"></script>
    <script src="js/jquery.parsley/dist/pt-br.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/carrinho.js"></script>
    <script>
        rebind_reload();

        
    </script>
</body>

</html>