<?php error_reporting(0) ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?= (isset($data['config']->config_nome)) ? $data['config']->config_nome : ''; ?></title>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.easypiechart/jquery.easy-pie-chart.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="js/bootstrap.datetimepicker/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />
    <link href="<?php echo $baseUri; ?>/assets/css/x0popup-master/dist/x0popup.min.css" rel="stylesheet">
    <script src="<?php echo $baseUri; ?>/assets/css/x0popup-master/dist/x0popup.min.js"></script>
</head>

<body class="animated">
    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php
            require 'side-menu.php';
            ?>
        </div>
        <div class="container-fluid" id="pcont">
            <?php require 'top-menu.php'; ?>
            <div class="cl-mcont">
                <div class="block-flat">
                    <?php if (isset($data['lista'])) : ?>
                        <div class="header">
                            <h3>
                                Detalhes do Pedido #<?= $data['pedido']->pedido_id ?>
                                <a href="<?php echo $baseUri; ?>/admin/imprimir/<?= $data['pedido']->pedido_id ?>/" target="_blank" title="Imprimir"><i class="fa fa-print"></i></a>
                                <br>
                                <small class="pull-right" style="font-size:13px;font-family: 'Open Sans',arial,verdana;">Data: <?= Timer::parse_date_br($data['pedido']->pedido_data) ?></small>
                                <br>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="itens-cart">
                                <h5><b>ITENS DO PEDIDO</b></h5>
                                <?php
                                $subtotal = 0;
                                foreach ($data['lista'] as $cart) : 
                                    $subtotal += $cart->lista_opcao_preco * $cart->lista_qtde;
                                ?>
                                    <div class="row">
                                        <div class="ol-md-5 col-xs-9">
                                            <p class="text-capitalize">
                                                <?= $cart->lista_qtde ?>x <?= mb_strtolower($cart->categoria_nome) ?>
                                                <?php if (strrpos($cart->lista_item_desc ?? '', '1/2') === false) { ?>
                                                    - <?= mb_strtolower($cart->lista_opcao_nome) ?>
                                                <?php } ?>

                                                <br>
                                                <small class="text-muted">
                                                    <?php
                                                    if (strlen($cart->extra ?? '') >= 0) : ?>
                                                        <?= mb_strtolower($cart->item_obs ?? '') ?>
                                                    <?php endif; ?>
                                                    <?= mb_strtolower($cart->extra ?? '') ?>
                                                </small>
                                            </p>
                                        </div>
                                        <div class="col-md-2 col-xs-5">
                                            R$ <?= Currency::moeda($cart->item_preco * $cart->lista_qtde) ?>
                                                <?php 
                                                if($cart->lista_item_extra){
                                                    $adicionais = explode(',', $cart->lista_item_extra);
                                                    $adicionais_val = explode(',', $cart->lista_item_extra_vals);
                                                ?>
                                                <br>
                                                Adicionais 
                                                <?php for($i=0; $i < count($adicionais); $i++){ ?>
                                                    <div>
                                                        <small class="text-muted"><?= $adicionais[$i] ?> R$ <?= number_format($adicionais_val[$i] * $cart->lista_qtde, 2,',','.') ?></small>
                                                    </div>
                                                <?php } ?>
                                                Total Item R$ <?= number_format(Currency::moeda($cart->lista_opcao_preco) * $cart->lista_qtde, 2,',','.') ?>
                                            <?php }?>
                                            <?php if (($cart->categoria_id >= "12" && $cart->categoria_id <= "15") && $cart->item_desc != "") : ?>
                                                - (<?= $cart->item_desc ?>)
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php                             
                                endforeach;
                                if (isset($data['lista_premio'])) {
                                    foreach ($data['lista_premio'] as $cartPremio) : ?>
                                        <div class="item">
                                            <span class="item-span">
                                                <?= $cartPremio->promocao_qtd ?>x <?= $cartPremio->promocao_produto ?>
                                                <span class="pull-right mar-right-3" data-toggle="tooltip" title="<?= $cart->lista_qtde ?> x <?= Currency::moeda($cart->lista_opcao_preco) ?>">
                                                    GRÁTIS
                                                </span>
                                            </span>
                                        </div>
                                <?php
                                    endforeach;
                                }
                                ?>
                            </div>
                            <?php if ($data['pedido']->pedido_obs != "") : ?>
                                <div>
                                    <br /><br />
                                    <p>
                                        <b>OBSERVAÇÕES:</b><br />
                                        <?= $data['pedido']->pedido_obs ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                            <hr>
                            <div class="text-right">
                                <p>
                                    <b>Subtotal R$ <?= Currency::moeda($subtotal) ?></b>
                                </p>
                                <?php
                                if ($data['pedido']->pedido_taxa_cartao != '' && $data['pedido']->pedido_taxa_cartao != '0.00') {
                                ?>
                                    <p>Taxa Cartão R$ <?= number_format($data['pedido']->pedido_taxa_cartao, 2, ',', '.') ?></p>
                                <?php } ?>
                                <?php if ($data['pedido']->pedido_entrega > 0) : ?>
                                    <p>Taxa de Entrega R$ <?= Currency::moeda($data['pedido']->pedido_entrega) ?></p>
                                <?php endif; ?>
                                <p>
                                    <b>
                                        Total do Pedido R$
                                        <?= ($data['pedido']->pedido_total > 0) ? Currency::moeda($data['pedido']->pedido_total) : '0,00'; ?>
                                    </b>
                                    <?php
                                    if ($data['pedido']->pedido_troco != '' && $data['pedido']->pedido_troco != '0.00' && $data['pedido']->pedido_troco > 0) {
                                    ?>
                                    <p>
                                        Troco R$
                                        <?= Currency::moeda($data['pedido']->pedido_troco) ?>
                                    </p>
                                    <?php } ?>
                                </p>
                                <?php if ($data['pedido']->pedido_entrega_prazo != '') : ?>
                                    <p><small>Tempo de Entrega Estimado: <?= $data['pedido']->pedido_entrega_prazo ?></small></p>
                                <?php endif; ?>
                                <p>
                                    
                                    <div style="width: 100%; height: 70px;">
                                        <h5 class="text-right"><strong>Onde deseja receber seu pedido?</strong></h5>
                                        <input type="hidden" name="localentrega_old" id="localentrega_old" value="<?= $data['pedido']->pedido_local ?>">
                                        <input type="hidden" name="pedidoentrega_old" id="pedidoentrega_old" value="<?= $data['pedido']->pedido_entrega ?>">
                                        <input type="hidden" name="taxa_cartao" id="taxa_cartao" value="<?= $data['pedido']->pedido_taxa_cartao ?>">
                                        <select class="form-control" name="localentrega" id="localentrega"  style="width: 200px; float: right;">
                                            <option value="" data-cep="" data-bairro="" selected>Selecione uma opção...</option>
                                            <?php if ($data['config']->config_retirada == 1) : ?>
                                                <option value="0" data-cep="0" <?= ($data['pedido']->pedido_local == 0) ? 'selected' : '' ?>>Retirar no Local</option>
                                            <?php endif; ?>
                                            <?php foreach ($data['endereco_cliente'] as $end) : ?>
                                                <option value="<?= $end->endereco_id ?>" data-bairro="<?= $end->endereco_bairro_id ?>" data-cep="<?= $end->endereco_cep ?>" data-tempo="<?= $end->bairro_tempo ?>"
                                                <?= ($data['pedido']->pedido_local == $end->endereco_id) ? 'selected' : '' ?>>
                                                    <?= ucfirst($end->endereco_nome) ?> em
                                                    <?= $end->endereco_bairro ?> (<?= $end->endereco_endereco ?>, Nº<?= $end->endereco_numero ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div style="width: 100%; display: flex; flex-direction: column; margin-bottom: 10px;">
                                        <!-- Mensagem de alteração -->
                                        <div style="background-color: #fffae6; padding: 10px; border: 1px solid #ffd700; border-radius: 5px; margin-bottom: 10px;">
                                            <strong style="color: #d18b00;">⚠ Atenção:</strong> <b>Se desejar, você pode alterar as informações do pedido abaixo.</b>
                                        </div>
                                        <!-- Linha de conteúdo -->
                                        <div style="display: flex; flex-direction: column; gap: 20px;">
                                            <!-- Data Compra -->
                                            <div style="display: flex; align-items: center; gap: 10px; justify-content: flex-end;">
                                                <h5><strong>Data da Compra:</strong></h5>
                                                <input type="hidden" name="data-compra-old" id="data-compra-old" value="<?= date('d/m/Y', strtotime($data['pedido']->pedido_data)) ?>">
                                                <input type="text" name="data-compra" id="data-compra" class="form-control data-compra" 
                                                    value="<?= date('d/m/Y', strtotime($data['pedido']->pedido_data)) ?>" 
                                                    style="width: 200px;">
                                            </div>
                                            <!-- Forma de Pagamento -->
                                            <div style="display: flex; align-items: center; gap: 10px; justify-content: flex-end;">
                                                <h5><strong>Forma de pagamento:</strong></h5>
                                                <input type="hidden" name="forma-pagamento-old" id="forma-pagamento-old" value="<?= $data['pedido']->pedido_id_pagto ?>">
                                                <select class="form-control" name="forma_pagamento" id="forma-pagamento" style="width: 200px;">
                                                    <option value="1" <?= ($data['pedido']->pedido_id_pagto == 1) ? 'selected' : '' ?>>Dinheiro</option>
                                                    <option value="2" <?= ($data['pedido']->pedido_id_pagto == 2) ? 'selected' : '' ?>>Cartão de Débito</option>
                                                    <option value="3" <?= ($data['pedido']->pedido_id_pagto == 3) ? 'selected' : '' ?>>Cartão de Crédito</option>
                                                    <option value="4" <?= ($data['pedido']->pedido_id_pagto == 4) ? 'selected' : '' ?>>PIX</option>
                                                </select>
                                                <input class="form-control money" type="text" name="pedido_valor_pagto" id="pedido_valor_pagto" 
                                                    placeholder="digite o valor" style="width: 120px; text-align: right;" 
                                                    value="<?= empty($data['pedido']->pedido_valor_pagto) ? 
                                                    (($data['pedido']->pedido_total > 0) ? Currency::moeda($data['pedido']->pedido_total) : '0,00') : 
                                                    Currency::moeda($data['pedido']->pedido_valor_pagto) ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div style="width: 100%; display: flex; align-items: center; justify-content: space-between; justify-content: flex-end;">
                                        <h5><strong style="margin-right: 10px;">2º Forma de pagamento:</strong></h5>
                                        <div style="display: flex; gap: 10px;">
                                            <select class="form-control" name="forma_pagamento_2" id="forma-pagamento-2" style="width: 200px;">
                                                <option value="0" selected>Selecione...</option>
                                                <option value="1" <?= ($data['pedido']->pedido_id_pagto_2 == 1) ? 'selected' : '' ?>>Dinheiro</option>
                                                <option value="2" <?= ($data['pedido']->pedido_id_pagto_2 == 2) ? 'selected' : '' ?>>Cartão de Débito</option>
                                                <option value="3" <?= ($data['pedido']->pedido_id_pagto_2 == 3) ? 'selected' : '' ?>>Cartão de Crédito</option>
                                                <option value="4" <?= ($data['pedido']->pedido_id_pagto_2 == 4) ? 'selected' : '' ?>>PIX</option>
                                            </select>
                                            <input class="form-control money" type="text" name="pedido_valor_pagto_2" id="pedido_valor_pagto_2" style="width: 120px; text-align: right;" 
                                                placeholder="digite o valor" value="<?= (!empty($data['pedido']->pedido_valor_pagto_2)) ? Currency::moeda($data['pedido']->pedido_valor_pagto_2) : '' ?>">
                                        </div>
                                    </div>
                                </p>
                            </div>
                            <hr>
                            <div>
                                <?php if (isset($data['endereco']) && $data['endereco']->endereco_cidade != "") : ?>
                                    <?php $end = $data['endereco']; ?>
                                    <h4>Endereço de entrega: <b><?= $end->endereco_nome ?></b></h4>

                                    <?= $end->endereco_endereco ?>,
                                    <?= $end->endereco_numero ?>,
                                    <?= ($end->endereco_complemento != "") ? $end->endereco_complemento . " - " : '' ?>
                                    Bairro <?= $end->endereco_bairro ?>,
                                    <?= $end->endereco_cidade ?>,
                                    <?= ($end->endereco_referencia != "") ? " (" . $end->endereco_referencia . ") " : '' ?>
                                <?php else : ?>
                                    <?php if ($data['pedido']->pedido_id_pagto == 0) { ?>
                                        <h4><b>Consumir no local</b></h4>
                                    <?php } else { ?>
                                        <h4><b>Retirada no local</b></h4>
                                    <?php } ?>
                                <?php endif; ?>
                            </div>
                            <hr>
                            <div>
                                <br>
                                <h5>
                                    Cliente: <b><?= $data['pedido']->cliente_nome ?></b>
                                    <br><br>
                                    Contato: <b><?= $data['pedido']->cliente_fone ?>
                                        &nbsp; <?= $data['pedido']->cliente_fone2 ?> </b>
                                </h5>
                            </div>
                            <hr>
                            <br>
                            <div>
                                <?php $status = Status::check($data['pedido']->pedido_status); ?>
                                <h4 class="alert alert-<?= $status->color ?> text-center" id="current-status"><?= $status->icon ?></h4>
                                <br>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select class="form-control input-lg" name="pedido_entregador" id="pedido_entregador" data-entregador="<?= $data['entregador']->entregador_id ?>">
                                                <option value="0">SELECIONE O ENTREGADOR:</option>
                                                <?php foreach ($data['entregador'] as $obj) : ?>
                                                    <option value="<?= $obj->entregador_id ?>"><?= $obj->entregador_nome ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <select class="form-control input-lg" name="pedido_status" id="pedido_status" data-id="<?= $data['pedido']->pedido_id ?>" data-cliente="<?= $data['pedido']->pedido_cliente ?>" required>
                                                <option value="">ALTERAR STATUS DO PEDIDO PARA:</option>
                                                <option value="1">Pendente</option>
                                                <option value="2">Em Produção</option>
                                                <option value="3">Saiu para entrega</option>
                                                <option value="4">Entregue</option>
                                                <option value="5">Cancelado</option>
                                                <option value="7">Aguardando Pagamento do Pix</option>
                                                <option value="8">Pedido Agendado</option>
                                            </select>
                                        </div>
                                        <button class="btn btn-lg btn-success" id="btn-update-status">
                                            <i class="fa fa-refresh"></i> Atualizar
                                        </button>
                                        <button class="btn btn-lg btn-info" onclick="window.location.replace(document.referrer)">
                                            <i class="fa fa-arrow-left"></i> Voltar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <script src="js/jquery.js"></script>
        <script src="js/jquery.cooki/jquery.cooki.js"></script>
        <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
        <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
        <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
        <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
        <script type="text/javascript" src="js/behaviour/core.js"></script>
        <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- CALENDAR JS -->
        <script src="js/cupom-desconto/moment.js"></script>
        <script src="js/cupom-desconto/moment-pt-br.js"></script>
        <script src="js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript" src="js/jquery.mask.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.data-compra').datetimepicker({
                    format: 'DD/MM/YYYY'
                });
            });

            $('.money').mask("#.##0,00", {
                reverse: true
            });

            $('#pedido_status').val(<?= $data['pedido']->pedido_status ?>);
            $('#pedido_entregador').val(<?= $data['pedido']->pedido_entregador ?>);

            var baseUrl = '<?php echo $baseUri; ?>';
            $("#cl-wrapper").removeClass("sb-collapsed");
            $('#menu-pedido').addClass('active');

            function getFormValues() {
                return {
                    status: $('#pedido_status option:selected').val(),
                    entregador: $('#pedido_entregador option:selected').val(),
                    forma_pgto_old: $('#forma-pagamento-old').val(),
                    forma_pgto_new: $('#forma-pagamento').val(),
                    segunda_forma_pgto: $('#forma-pagamento-2').val(),
                    localentrega_old: $('#localentrega_old').val(),
                    localentrega_new: $('#localentrega').val(),
                    pedido_entrega: $('#pedidoentrega_old').val(),
                    pedido_taxa_cartao: $('#taxa_cartao').val(),
                    pedido_valor_pagto: $('#pedido_valor_pagto').val(),
                    pedido_valor_pagto_2: $('#pedido_valor_pagto_2').val(),
                    pedido_total: parseFloat("<?= Currency::moeda($data['pedido']->pedido_total) ?>".replace(",", ".")),
                    data_compra_old: $('#data-compra-old').val(),
                    data_compra_new: $('#data-compra').val(),
                    id: $('#pedido_status').data('id'),
                    cliente: $('#pedido_status').data('cliente'),
                    pedido_obs_pagto_original: "<?= addslashes($data['pedido']->pedido_obs_pagto) ?>"
                };
            }

            function toNumber(value) {
                return Number(value.replace(',', '.').trim()) || 0;
            }

            function validatePaymentForms(values) {
                const toNumber = (val) => {
                    if (val === null || val === undefined) return 0;
                    return Number(String(val).replace(',', '.').trim()) || 0;
                };

                const valor1 = toNumber(values.pedido_valor_pagto);
                const valor2 = toNumber(values.pedido_valor_pagto_2);
                const totalPedido = toNumber(values.pedido_total);
                const taxaCartao = toNumber(values.pedido_taxa_cartao);

                const soma = +(valor1 + valor2).toFixed(2);

                const forma1 = Number(values.forma_pgto_new);
                const forma2 = Number(values.segunda_forma_pgto);

                const precisaTaxa = [2, 3].includes(forma1) || [2, 3].includes(forma2);

                // 🔹 Define o valor esperado
                const valorEsperado = precisaTaxa ? totalPedido : (totalPedido - taxaCartao);

                // 🔹 Regra 1: pagamento deve ser exatamente igual ao valor esperado
                if (soma !== valorEsperado) {
                    alert(`O valor total do pagamento deve ser exatamente R$ ${valorEsperado.toFixed(2)}`);
                    return false;
                }

                // 🔹 Regra 2: 2ª forma não informada mas valor preenchido
                if (forma2 === 0 && valor2 > 0) {
                    alert('Informe a 2ª Forma de pagamento');
                    $('#forma-pagamento-2').focus();
                    return false;
                }

                // 🔹 Regra 3: 2ª forma informada mas sem valor
                if (forma2 !== 0 && valor2 === 0) {
                    alert('Informe o valor da 2ª Forma de pagamento');
                    $('#pedido_valor_pagto_2').focus();
                    return false;
                }

                // 🔹 Regra 4: se a 2ª forma não foi escolhida mas valor digitado, zera o campo
                if (forma2 === 0 && valor2 > 0) {
                    $('#pedido_valor_pagto_2').val('');
                }

                return true;
            }


            function getPaymentMethodDescription(paymentMethod) {
                const descriptions = {
                    1: "Pagto em Dinheiro",
                    2: "Pagto com Cartão de Débito",
                    3: "Pagto com Cartão de Crédito",
                    4: "Pagto via pix"
                };
                return descriptions[paymentMethod] || '';
            }

            /*$('#btn-update-status').on('click', function() {
                var values = getFormValues();
                
                if (values.status != "") {
                    if (values.status == "3" && values.entregador == "0") {
                        alert('Favor selecione o entregador');
                        $('#pedido_entregador').focus();
                        return false;
                    }

                    if (!validatePaymentForms(values)) return false;

                    var forma_pgto = (values.forma_pgto_old != values.forma_pgto_new) ? values.forma_pgto_new : values.forma_pgto_old;
                    var localentrega = (values.localentrega_old != values.localentrega_new) ? values.localentrega_new : values.localentrega_old;

                    var pedido_obs_pagto = getPaymentMethodDescription(forma_pgto);
                    var pedido_obs_pagto_2 = getPaymentMethodDescription(values.segunda_forma_pgto);

                    var pedido_data = (values.data_compra_old != values.data_compra_new) ? values.data_compra_new : null;

                    var dataPost = {
                        pedido_id: values.id,
                        pedido_status: values.status,
                        cliente: values.cliente,
                        pedido_entregador: values.entregador,
                        pedido_id_pagto: forma_pgto,
                        pedido_local: localentrega,
                        pedido_obs_pagto: pedido_obs_pagto,
                        pedido_entrega: values.pedido_entrega
                    };

                    if (pedido_data) {
                        dataPost.pedido_data = pedido_data;
                    }
                    
                    dataPost.pedido_id_pagto_2 = values.segunda_forma_pgto == 0 ? null : values.segunda_forma_pgto;
                    dataPost.pedido_obs_pagto_2 = pedido_obs_pagto_2;
                    dataPost.pedido_valor_pagto = values.pedido_valor_pagto.replace(',', '.');
                    dataPost.pedido_valor_pagto_2 = values.pedido_valor_pagto_2.replace(',', '.');
                    
                    $('#btn-update-status').html(' Atualizando, aguarde....').attr('disabled', 'disabled');
                    
                    $.post(baseUrl + '/admin/atualiza_status/', dataPost, function(data) {
                        window.location.href = baseUrl + "/admin/pedidos/?success";
                    });
                }
            });*/

            $('#btn-update-status').on('click', function() {
                var values = getFormValues();

                if (values.status != "") {
                    if (values.status == "3" && values.entregador == "0") {
                        alert('Favor selecione o entregador');
                        $('#pedido_entregador').focus();
                        return false;
                    }

                    if (!validatePaymentForms(values)) return false;

                    var forma_pgto = (values.forma_pgto_old != values.forma_pgto_new) ? values.forma_pgto_new : values.forma_pgto_old;
                    var localentrega = (values.localentrega_old != values.localentrega_new) ? values.localentrega_new : values.localentrega_old;

                    // 🔒 CORREÇÃO: Preserva a obs original se a forma de pagamento não mudou
                    var pedido_obs_pagto = (values.forma_pgto_old == values.forma_pgto_new) 
                        ? values.pedido_obs_pagto_original 
                        : getPaymentMethodDescription(forma_pgto);
                    var pedido_obs_pagto_2 = getPaymentMethodDescription(values.segunda_forma_pgto);

                    var pedido_data = (values.data_compra_old != values.data_compra_new) ? values.data_compra_new : null;

                    // 🔹 Verifica se alguma forma de pagamento é cartão
                    const forma1 = Number(values.forma_pgto_new);
                    const forma2 = Number(values.segunda_forma_pgto);
                    const precisaTaxa = [2, 3].includes(forma1) || [2, 3].includes(forma2);

                    // 🔹 Define valores corretos para taxa e total
                    const pedido_taxa_cartao = precisaTaxa ? values.pedido_taxa_cartao : null;
                    const pedido_total = precisaTaxa 
                        ? Number(values.pedido_total) 
                        : Number(values.pedido_total) - Number(values.pedido_taxa_cartao);

                    var dataPost = {
                        pedido_id: values.id,
                        pedido_status: values.status,
                        cliente: values.cliente,
                        pedido_entregador: values.entregador,
                        pedido_id_pagto: forma_pgto,
                        pedido_local: localentrega,
                        pedido_obs_pagto: pedido_obs_pagto,
                        pedido_entrega: values.pedido_entrega,
                        pedido_taxa_cartao: pedido_taxa_cartao,
                        pedido_total: pedido_total.toFixed(2) // 🔹 garante 2 casas decimais
                    };

                    if (pedido_data) {
                        dataPost.pedido_data = pedido_data;
                    }

                    dataPost.pedido_id_pagto_2 = values.segunda_forma_pgto == 0 ? null : values.segunda_forma_pgto;
                    dataPost.pedido_obs_pagto_2 = pedido_obs_pagto_2;
                    dataPost.pedido_valor_pagto = values.pedido_valor_pagto.replace(',', '.');
                    dataPost.pedido_valor_pagto_2 = values.pedido_valor_pagto_2.replace(',', '.');

                    $('#btn-update-status').html(' Atualizando, aguarde....').attr('disabled', 'disabled');

                    $.post(baseUrl + '/admin/atualiza_status/', dataPost, function(data) {
                        window.location.href = baseUrl + "/admin/pedidos/?success";
                    });
                }
            });

        </script>
    </div>
</body>

</html>