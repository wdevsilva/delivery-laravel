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
    <link href="<?php echo $baseUri; ?>/view/admin/css/style-prusia.css" rel="stylesheet" />
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
                                <a href="javascript:void(0)" onclick="imprimirPedido(<?= $data['pedido']->pedido_id ?>, false)" title="Imprimir"><i class="fa fa-print"></i></a>
                                <button class="btn btn-warning btn-sm" onclick="abrirModalAdicionarItens()" style="margin-left: 15px;" title="Adicionar mais itens ao pedido">
                                    <i class="fa fa-plus-circle"></i> Adicionar Itens
                                </button>
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
                                    <div class="row" style="margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px dashed #e0e0e0;" data-lista-id="<?= $cart->lista_id ?>">
                                        <div class="col-md-5 col-xs-8">
                                            <p class="text-capitalize" style="margin-bottom: 8px;">
                                                <strong style="font-size: 15px;"><?= $cart->lista_qtde ?>x <?= mb_strtolower($cart->categoria_nome) ?></strong>
                                                <?php if (strrpos($cart->lista_item_desc ?? '', '1/2') === false) { ?>
                                                    - <?= mb_strtolower($cart->lista_opcao_nome) ?>
                                                <?php } ?>
                                            </p>
                                            
                                            <small style="display: block; margin-left: 10px;">
                                                <?php
                                                // 📝 OBSERVAÇÕES
                                                if (strlen($cart->item_obs ?? '') > 0) : ?>
                                                    <span style="color: #666;">
                                                        <i class="fa fa-comment-o" style="color: #999;"></i> 
                                                        <em><?= mb_strtolower($cart->item_obs) ?></em>
                                                    </span><br>
                                                <?php endif; ?>
                                                
                                                <?php 
                                                // 🍕 SABORES / DESCRIÇÃO
                                                if (strlen($cart->lista_item_desc ?? '') > 0) {
                                                    // Adiciona ícones no texto
                                                    $descricao = $cart->lista_item_desc;
                                                    $descricao = str_replace('Bordas:', '<i class="fa fa-circle-o" style="color: #f39c12;"></i> Bordas:', $descricao);
                                                    $descricao = str_replace('Adicionais:', '<i class="fa fa-plus" style="color: #28a745;"></i> Adicionais:', $descricao);
                                                    $descricao = str_replace('Ingredientes:', '<i class="fa fa-cutlery" style="color: #3498db;"></i> Ingredientes:', $descricao);
                                                }
                                                
                                                // 🧀 PROCESSA E EXIBE EXTRAS FORMATADOS
                                                if (!empty($cart->lista_item_extra)) {
                                                    // Remove tags HTML e quebra por <br>
                                                    $extras_lines = preg_split('/<br\s*\/?>/', $cart->lista_item_extra);
                                                    
                                                    foreach ($extras_lines as $line) {
                                                        $line = strip_tags($line);
                                                        $line = trim($line, ', ');
                                                        
                                                        if (empty($line)) continue;
                                                        
                                                        // Detecta o tipo de grupo pelo conteúdo
                                                        if (stripos($line, 'massa:') !== false) {
                                                            $line = preg_replace('/massa:/i', '<strong>Massa:</strong>', $line);
                                                            echo '<span style="color: #666; display: block;">' . $line . '</span>';
                                                        } elseif (stripos($line, 'molho:') !== false) {
                                                            $line = preg_replace('/molho:/i', '<strong>Molho:</strong>', $line);
                                                            echo '<span style="color: #666; display: block;">' . $line . '</span>';
                                                        } elseif (stripos($line, 'borda:') !== false || stripos($line, 'bordas:') !== false) {
                                                            $line = preg_replace('/bordas?:/i', '<strong style="color: #f39c12;"><i class="fa fa-circle-o"></i> Borda:</strong>', $line);
                                                            echo '<span style="color: #666; display: block;">' . $line . '</span>';
                                                        } elseif (stripos($line, 'adicionais:') !== false) {
                                                            // Processa adicionais (apenas os com preço)
                                                            $line = preg_replace('/adicionais:/i', '<strong style="color: #28a745;"><i class="fa fa-plus-circle"></i> Adicionais:</strong>', $line);
                                                            echo '<span style="color: #666; display: block;">' . $line . '</span>';
                                                        } elseif (stripos($line, 'ingredientes:') !== false) {
                                                            $line = preg_replace('/ingredientes:/i', '<strong style="color: #3498db;"><i class="fa fa-cutlery"></i> Ingredientes:</strong>', $line);
                                                            echo '<span style="color: #666; display: block;">' . $line . '</span>';
                                                        } else {
                                                            // Outras linhas
                                                            echo '<span style="color: #666; display: block;">' . $line . '</span>';
                                                        }
                                                    }
                                                }

                                                
                                                ?>
                                            </small>
                                        </div>
                                        <div class="col-md-2 col-xs-3">
                                            <?php
                                            // Calcula o valor base do item subtraindo os adicionais
                                            $valor_adicionais = 0;
                                            if($cart->lista_item_extra_vals){
                                                $adicionais_val = explode(',', $cart->lista_item_extra_vals);
                                                foreach($adicionais_val as $val) {
                                                    $valor_adicionais += floatval($val);
                                                }
                                            }                                           
                                            $valor_base_item = ($cart->lista_opcao_preco - $valor_adicionais) * $cart->lista_qtde;
                                            ?>
                                            <strong style="font-size: 16px; color: #333;">R$ <?= Currency::moeda($valor_base_item) ?></strong>
                                        </div>
                                        <div class="col-md-1 col-xs-1" style="text-align: right;">
                                            <button class="btn btn-danger btn-xs" onclick="removerItemDoPedido(<?= $cart->lista_id ?>, '<?= addslashes($cart->lista_opcao_nome) ?>', <?= $valor_base_item ?>)" title="Remover item do pedido">
                                                <i class="fa fa-trash"></i>
                                            </button>
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
                                <?php 
                                // Extrair desconto de fidelidade da observação se não estiver no pedido_desconto
                                $desconto_fidelidade = 0;
                                if (isset($data['pedido']->pedido_desconto) && $data['pedido']->pedido_desconto > 0) {
                                    $desconto_fidelidade = $data['pedido']->pedido_desconto;
                                } elseif (strpos($data['pedido']->pedido_obs, 'Desconto Fidelidade') !== false) {
                                    // Tentar extrair da observação: "*** Desconto Fidelidade (10%) - R$ 1,50"
                                    if (preg_match('/Desconto Fidelidade.*?R\$\s*([\d.,]+)/', $data['pedido']->pedido_obs, $matches)) {
                                        $desconto_fidelidade = (float)str_replace(',', '.', $matches[1]);
                                    }
                                }
                                ?>
                                <p>
                                    <b>Subtotal R$ <?= Currency::moeda($subtotal) ?></b>
                                </p>
                                <?php if ($desconto_fidelidade > 0) : 
                                    $subtotal_com_desconto = $subtotal - $desconto_fidelidade;
                                ?>
                                <p style="color: #28a745;">
                                    <i class="fa fa-gift"></i> <b>Desconto Fidelidade: -R$ <?= number_format($desconto_fidelidade, 2, ',', '.') ?></b>
                                </p>
                                <p>
                                    <b>Subtotal com Desconto R$ <?= number_format($subtotal_com_desconto, 2, ',', '.') ?></b>
                                </p>
                                <?php endif; ?>
                                <p id="exibir-taxa-cartao" <?php if ($data['pedido']->pedido_taxa_cartao == '' || $data['pedido']->pedido_taxa_cartao == '0.00') echo 'style="display: none;"'; ?>>
                                    Taxa Cartão R$ <span id="valor-taxa-cartao"><?= number_format($data['pedido']->pedido_taxa_cartao, 2, ',', '.') ?></span>
                                </p>
                                <p id="exibir-taxa-entrega" <?php if ($data['pedido']->pedido_entrega <= 0) echo 'style="display: none;"'; ?>>
                                    Taxa de Entrega R$ <span id="valor-taxa-entrega"><?= Currency::moeda($data['pedido']->pedido_entrega) ?></span>
                                </p>
                                <p>
                                    <b>
                                        Total do Pedido R$ <span id="valor-total-pedido"><?= ($data['pedido']->pedido_total > 0) ? Currency::moeda($data['pedido']->pedido_total) : '0,00'; ?></span>
                                    </b>
                                    <p id="exibir-troco" <?php if ($data['pedido']->pedido_troco == '' || $data['pedido']->pedido_troco == '0.00' || $data['pedido']->pedido_troco <= 0) echo 'style="display: none;"'; ?>>
                                        Troco R$ <span id="valor-troco"><?= Currency::moeda($data['pedido']->pedido_troco) ?></span>
                                    </p>
                                </p>
                                <?php if ($data['pedido']->pedido_entrega_prazo != '') : ?>
                                    <p><small>Tempo de Entrega Estimado: <?= $data['pedido']->pedido_entrega_prazo ?></small></p>
                                <?php endif; ?>
                                <p>
                                    
                                    <div style="width: 100%; height: 70px;">
                                        <h5 class="text-right"><strong>Onde deseja receber seu pedido?</strong></h5>
                                        <input type="hidden" name="localentrega_old" id="localentrega_old" value="<?= $data['pedido']->pedido_local ?>">
                                        <input type="hidden" name="pedidoentrega_old" id="pedidoentrega_old" value="<?= $data['pedido']->pedido_entrega ?>">
                                        <input type="hidden" name="pedidoentrega_original" id="pedidoentrega_original" value="<?= $data['pedido']->pedido_entrega ?>">
                                        <input type="hidden" name="pedidototal_original" id="pedidototal_original" value="<?= $data['pedido']->pedido_total ?>">
                                        <input type="hidden" name="pedidotroco_original" id="pedidotroco_original" value="<?= $data['pedido']->pedido_troco ?>">
                                        <input type="hidden" name="subtotal_com_desconto" id="subtotal_com_desconto" value="<?= isset($subtotal_com_desconto) ? $subtotal_com_desconto : $subtotal ?>">
                                        <input type="hidden" name="taxa_cartao" id="taxa_cartao" value="<?= $data['pedido']->pedido_taxa_cartao ?>">
                                        <select class="form-control" name="localentrega" id="localentrega"  style="width: 200px; float: right;">
                                            <option value="" data-cep="" data-bairro="" selected>Selecione uma opção...</option>
                                            <?php //if ($data['config']->config_retirada == 1) : ?>
                                                <option value="0" data-cep="0" <?= ($data['pedido']->pedido_local == 0) ? 'selected' : '' ?>>Retirar no Local</option>
                                            <?php //endif; ?>
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
                                                    value="<?= (!empty($data['pedido']->pedido_valor_pagto) && $data['pedido']->pedido_valor_pagto != '0.00') ? 
                                                    Currency::moeda($data['pedido']->pedido_valor_pagto) : 
                                                    (($data['pedido']->pedido_total > 0) ? Currency::moeda($data['pedido']->pedido_total) : '0,00') ?>">
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
                                    
                                    <?php 
                                    // Mostrar chave PIX se forma de pagamento for PIX (4)
                                    if ($data['pedido']->pedido_id_pagto == 4 || $data['pedido']->pedido_id_pagto_2 == 4) {
                                        // Gerar payload PIX
                                        require_once __DIR__ . '/../../app/Pix/Payload.php';
                                        
                                        // Formatar chave PIX conforme tipo
                                        if ($data['config']->config_tipo_chave == 1) {
                                            $pixKey = str_replace('.', '', str_replace('-', '', $data['config']->config_chave_pix));
                                        } elseif ($data['config']->config_tipo_chave == 2) {
                                            $celular = str_replace('(', '', str_replace(')', '', str_replace(' ', '', str_replace('-', '', $data['config']->config_chave_pix))));
                                            $pixKey = "+55$celular";
                                        } else {
                                            $pixKey = $data['config']->config_chave_pix;
                                        }
                                        
                                        $txid = 'P' . $data['pedido']->pedido_id;
                                        $txid = strtoupper(substr($txid, 0, 20));
                                        
                                        $obPayload = (new \App\Pix\Payload())
                                            ->setPixKey($pixKey)
                                            ->setDescription('Pedido #' . $data['pedido']->pedido_id)
                                            ->setMerchantName(substr(str_replace("'", '', $data['config']->config_nome), 0, 25))
                                            ->setMerchantCity(substr($data['config']->config_cidade ?? 'Brasil', 0, 15))
                                            ->setAmount($data['pedido']->pedido_total)
                                            ->setTxid($txid)
                                            ->setUniquePayment(true);
                                        
                                        $payloadPix = $obPayload->getPayload();
                                    ?>
                                    <div style="margin-top: 15px; padding: 15px; background: #e3f2fd; border-radius: 8px; border: 1px solid #2196f3;">
                                        <h5 style="margin: 0 0 10px 0; color: #1976d2;"><i class="fa fa-qrcode"></i> <strong>Chave PIX Copia e Cola:</strong></h5>
                                        <div style="display: flex; gap: 10px; align-items: center;">
                                            <input type="text" class="form-control" id="pix-key" value="<?= htmlspecialchars($payloadPix) ?>" readonly style="font-size: 11px;">
                                            <button type="button" class="btn btn-info" onclick="copiarChavePix()" title="Copiar chave PIX">
                                                <i class="fa fa-copy"></i> Copiar
                                            </button>
                                        </div>
                                    </div>
                                    <?php } ?>
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
                                                <option value="9">Pronto para Retirada</option>
                                            </select>
                                        </div>
                                        <button class="btn btn-lg btn-success" id="btn-update-status">
                                            <i class="fa fa-refresh"></i> Atualizar
                                        </button>
                                        <button class="btn btn-lg btn-info" onclick="window.location.href='<?= $baseUri ?>/admin/pedidos'">
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

            // Inicializa a taxa de cartão com o valor atual do pedido
            <?php if (isset($data['pedido']->pedido_taxa_cartao) && $data['pedido']->pedido_taxa_cartao > 0) { ?>
                $('#taxa_cartao').val('<?= $data['pedido']->pedido_taxa_cartao ?>');
            <?php } else { ?>
                $('#taxa_cartao').val('0');
            <?php } ?>

            // Adiciona evento para recalcular total quando forma de pagamento muda
            $('#forma-pagamento').on('change', function() {
                recalcularTotalComTaxaCartao();
            });

            // Função para recalcular total com taxa de cartão
            function recalcularTotalComTaxaCartao() {
                const formaPagamento = parseInt($('#forma-pagamento').val());
                const subtotalOriginal = <?= $subtotal ?>;
                const taxaEntrega = <?= $data['pedido']->pedido_entrega ?>;
                let taxaCartao = 0;

                // Calcula taxa de cartão apenas para débito (2) e crédito (3)
                if (formaPagamento === 2 || formaPagamento === 3) {
                    // Usa a mesma lógica do carrinho.js
                    const valorBase = subtotalOriginal + taxaEntrega;
                    
                    // Dados de configuração vindos do PHP
                    const configTaxaCartao = <?= json_encode($data['config']) ?>;
                    const faixasCartao = <?= json_encode($data['faixasCartao'] ?? []) ?>;
                    
                    if (configTaxaCartao.config_taxa_tipo === 'faixa_valor' && faixasCartao.length > 0) {
                        // Taxa por faixa de valor
                        faixasCartao.forEach(faixa => {
                            let de = parseFloat(faixa.valor_de);
                            let ate = parseFloat(faixa.valor_ate);
                            if (valorBase >= de && valorBase <= ate) {
                                taxaCartao = parseFloat(faixa.taxa);
                            }
                        });
                    } else if (configTaxaCartao.config_taxa_tipo === 'percentual') {
                        // Taxa percentual do banco de dados
                        let formasPagamento = typeof configTaxaCartao.config_taxa_formas_pagamento === 'string' 
                            ? JSON.parse(configTaxaCartao.config_taxa_formas_pagamento) 
                            : configTaxaCartao.config_taxa_formas_pagamento;
                        
                        if (formasPagamento) {
                            let percentual = formasPagamento[formaPagamento] || 0;
                            
                            const empresa = '<?= $_SESSION['base_delivery'] ?? '' ?>';
                            
                            if (empresa === 'dgustsalgados') {
                                // Taxa simples: percentual sobre o valor
                                taxaCartao = (parseFloat(subtotalOriginal) + parseFloat(taxaEntrega)) * percentual / 100;
                            } else {
                                // Calcula taxa EMBUTIDA para receber o valor líquido
                                // Fórmula: valorCobrar = valorBase / (1 - taxa/100)
                                let valorCobrar = valorBase / (1 - percentual / 100);
                                taxaCartao = Math.round((valorCobrar - valorBase + Number.EPSILON) * 100) / 100;
                            }
                        }
                    } else if (configTaxaCartao.config_taxa_tipo === 'taxa_por_item') {
                        // Taxa por item - precisa da quantidade de itens
                        let totalItens = 0;
                        <?php 
                        if (isset($data['lista']) && is_array($data['lista'])) {
                            $totalItens = 0;
                            foreach ($data['lista'] as $item) {
                                $totalItens += $item->lista_qtde ?? 0;
                            }
                            echo "totalItens = {$totalItens};";
                        } else {
                            echo "totalItens = 1;"; // fallback
                        }
                        ?>
                        if (configTaxaCartao.config_taxa_valor) {
                            taxaCartao = totalItens * parseFloat(configTaxaCartao.config_taxa_valor);
                            taxaCartao = Math.round((taxaCartao + Number.EPSILON) * 100) / 100;
                        }
                    } else {
                        // Tipo de taxa não configurado ou não reconhecido - usar valor padrão 0
                        taxaCartao = 0;
                    }
                }

                // Atualiza o campo da taxa de cartão
                $('#taxa_cartao').val(taxaCartao.toFixed(2));
                
                // Atualizar exibição da taxa de cartão na tela
                if (taxaCartao > 0) {
                    $('#valor-taxa-cartao').text(taxaCartao.toFixed(2).replace('.', ','));
                    $('#exibir-taxa-cartao').show();
                } else {
                    $('#exibir-taxa-cartao').hide();
                }
                
                // Calcula novo total
                const novoTotal = subtotalOriginal + taxaEntrega + taxaCartao;
                
                // Atualizar exibição do Total do Pedido
                $('#valor-total-pedido').text(novoTotal.toFixed(2).replace('.', ','));
                
                // Atualiza o valor de pagamento para o novo total
                $('#pedido_valor_pagto').val(novoTotal.toFixed(2).replace('.', ','));
                
                // Mostra alerta informativo
                if (formaPagamento === 2 || formaPagamento === 3) {
                    const tipoPagamento = formaPagamento === 2 ? 'Cartão de Débito' : 'Cartão de Crédito';
                    alert(`${tipoPagamento} selecionado.\n\nTaxa aplicada: R$ ${taxaCartao.toFixed(2).replace('.', ',')}\nNovo total: R$ ${novoTotal.toFixed(2).replace('.', ',')}`);
                } else if (taxaCartao > 0) {
                    alert(`Forma de pagamento alterada.\n\nTaxa de cartão removida.\nTotal: R$ ${novoTotal.toFixed(2).replace('.', ',')}`);
                } else {
                    alert(`Forma de pagamento alterada.\n\nTotal: R$ ${novoTotal.toFixed(2).replace('.', ',')}`);
                }
            }
            $('#pedido_entregador').val(<?= $data['pedido']->pedido_entregador ?>);

            var baseUrl = '<?php echo $baseUri; ?>';
            
            // Ao carregar a página, garantir que os campos originais estejam com valores do banco
            // (serão usados para cálculos depois de mudanças)
            const totalOriginalAoCarregar = parseFloat('<?= $data['pedido']->pedido_total ?>') || 0;
            const trocoOriginalAoCarregar = parseFloat('<?= $data['pedido']->pedido_troco ?>') || 0;
            $('#pedidototal_original').val(totalOriginalAoCarregar.toFixed(2));
            $('#pedidotroco_original').val(trocoOriginalAoCarregar.toFixed(2));
            
            // Adiciona evento para recalcular quando local de entrega muda
            $('#localentrega').on('change', function() {
                recalcularTotalComMudancaLocal();
            });
            
            // Função para recalcular total quando local de entrega muda
            function recalcularTotalComMudancaLocal() {
                const localSelecionado = parseInt($('#localentrega').val());
                const subtotalOriginal = parseFloat($('#subtotal_com_desconto').val()) || <?= isset($subtotal_com_desconto) ? $subtotal_com_desconto : $subtotal ?>; // Usar subtotal COM desconto
                let novaTaxaEntrega = 0;
                
                if (localSelecionado === 0) {
                    // Retirar no Local - taxa = 0
                    novaTaxaEntrega = 0;
                    $('#pedidoentrega_old').val(novaTaxaEntrega.toFixed(2));
                    recalcularTotalCompleto(subtotalOriginal, novaTaxaEntrega);
                } else if (localSelecionado > 0) {
                    // Buscar taxa de entrega do endereço selecionado
                    const bairroId = $('#localentrega option:selected').data('bairro');
                    
                    if (bairroId && bairroId > 0) {
                        // Mostrar loading
                        $('#valor-total-pedido').html('<i class="fa fa-spinner fa-spin"></i> Calculando...');
                        
                        $.ajax({
                            url: baseUrl + '/local/get_preco_entrega/',
                            type: 'POST',
                            data: { bairro: bairroId },
                            success: function(response) {
                                novaTaxaEntrega = parseFloat(response) || 0;
                                $('#pedidoentrega_old').val(novaTaxaEntrega.toFixed(2));
                                recalcularTotalCompleto(subtotalOriginal, novaTaxaEntrega);
                            },
                            error: function() {
                                alert('Erro ao buscar taxa de entrega. Por favor, tente novamente.');
                                // Reverter seleção
                                $('#localentrega').val($('#localentrega_old').val());
                            }
                        });
                        return;
                    }
                }
            }
            
            // Função para recalcular TUDO (taxa entrega + taxa cartão + total)
            function recalcularTotalCompleto(subtotal, taxaEntrega) {
                const localSelecionado = parseInt($('#localentrega').val()); // Adicionar aqui
                const formaPagamento = parseInt($('#forma-pagamento').val());
                let taxaCartao = 0;
                
                // Calcula taxa de cartão se necessário
                if (formaPagamento === 2 || formaPagamento === 3) {
                    const valorBase = subtotal + taxaEntrega;
                    
                    const configTaxaCartao = <?= json_encode($data['config']) ?>;
                    const faixasCartao = <?= json_encode($data['faixasCartao'] ?? []) ?>;
                    
                    if (configTaxaCartao.config_taxa_tipo === 'faixa_valor' && faixasCartao.length > 0) {
                        faixasCartao.forEach(faixa => {
                            let de = parseFloat(faixa.valor_de);
                            let ate = parseFloat(faixa.valor_ate);
                            if (valorBase >= de && valorBase <= ate) {
                                taxaCartao = parseFloat(faixa.taxa);
                            }
                        });
                    } else if (configTaxaCartao.config_taxa_tipo === 'percentual') {
                        let formasPagamento = typeof configTaxaCartao.config_taxa_formas_pagamento === 'string' 
                            ? JSON.parse(configTaxaCartao.config_taxa_formas_pagamento) 
                            : configTaxaCartao.config_taxa_formas_pagamento;
                        
                        if (formasPagamento) {
                            let percentual = formasPagamento[formaPagamento] || 0;
                            const empresa = '<?= $_SESSION['base_delivery'] ?? '' ?>';
                            
                            if (empresa === 'dgustsalgados') {
                                taxaCartao = valorBase * percentual / 100;
                            } else {
                                let valorCobrar = valorBase / (1 - percentual / 100);
                                taxaCartao = Math.round((valorCobrar - valorBase + Number.EPSILON) * 100) / 100;
                            }
                        }
                    } else if (configTaxaCartao.config_taxa_tipo === 'taxa_por_item') {
                        let totalItens = <?php 
                        if (isset($data['lista']) && is_array($data['lista'])) {
                            $totalItens = 0;
                            foreach ($data['lista'] as $item) {
                                $totalItens += $item->lista_qtde ?? 0;
                            }
                            echo $totalItens;
                        } else {
                            echo '1';
                        }
                        ?>;
                        if (configTaxaCartao.config_taxa_valor) {
                            taxaCartao = totalItens * parseFloat(configTaxaCartao.config_taxa_valor);
                            taxaCartao = Math.round((taxaCartao + Number.EPSILON) * 100) / 100;
                        }
                    }
                }
                
                // Atualiza campo hidden da taxa de cartão
                $('#taxa_cartao').val(taxaCartao.toFixed(2));
                
                // Atualiza exibição da taxa de cartão
                if (taxaCartao > 0) {
                    $('#valor-taxa-cartao').text(taxaCartao.toFixed(2).replace('.', ','));
                    $('#exibir-taxa-cartao').show();
                } else {
                    $('#exibir-taxa-cartao').hide();
                }
                
                // Calcula novo total
                const novoTotal = subtotal + taxaEntrega + taxaCartao;
                
                // Atualiza exibição do Total do Pedido
                $('#valor-total-pedido').text(novoTotal.toFixed(2).replace('.', ','));
                
                // Atualiza valor de pagamento
                $('#pedido_valor_pagto').val(novoTotal.toFixed(2).replace('.', ','));
                
                // Atualiza exibição da Taxa de Entrega
                if (taxaEntrega > 0) {
                    $('#valor-taxa-entrega').text(taxaEntrega.toFixed(2).replace('.', ','));
                    $('#exibir-taxa-entrega').show();
                } else {
                    $('#exibir-taxa-entrega').hide();
                }
                
                // RECALCULAR TROCO se forma de pagamento for dinheiro
                if (formaPagamento === 1) {
                    const trocoAtual = parseFloat($('#pedidotroco_original').val()) || 0; // Usar campo hidden
                    const totalAtual = parseFloat($('#pedidototal_original').val()) || 0; // Usar campo hidden

                    if (trocoAtual > 0) {
                        // Calcular valor recebido = total_antigo + troco_antigo
                        const valorRecebido = totalAtual + trocoAtual;
                        
                        // Calcular novo troco = valor_recebido - total_novo
                        const novoTroco = valorRecebido - novoTotal;
                        
                        // Atualizar exibição do troco
                        if (novoTroco > 0) {
                            $('#valor-troco').text(novoTroco.toFixed(2).replace('.', ','));
                            $('#exibir-troco').show();
                        } else {
                            $('#exibir-troco').hide();
                        }
                    }
                }
                
                // Mostra alerta
                const localTexto = localSelecionado === 0 ? 'Retirar no Local' : 'Entrega';
                alert(`${localTexto} selecionado.

                    Taxa de Entrega: R$ ${taxaEntrega.toFixed(2).replace('.', ',')}
                    Taxa de Cart\u00e3o: R$ ${taxaCartao.toFixed(2).replace('.', ',')}
                    Novo Total: R$ ${novoTotal.toFixed(2).replace('.', ',')}`);
            }
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
                    pedido_total: function() {
                        // Calcula o total atual baseado nos valores DINÂMICOS atualizados
                        const subtotal = parseFloat($('#subtotal_com_desconto').val()) || <?= isset($subtotal_com_desconto) ? $subtotal_com_desconto : $subtotal ?>; // COM desconto
                        const taxaEntrega = parseFloat($('#pedidoentrega_old').val()) || 0; // Valor dinâmico
                        const taxaCartaoAtual = parseFloat($('#taxa_cartao').val()) || 0;
                        return subtotal + taxaEntrega + taxaCartaoAtual;
                    }(),
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
                // Se tem taxa de cartão (formas 2 ou 3), o valor esperado é o total COM taxa
                // Se não tem taxa (forma 1 ou 4), o valor esperado é total SEM taxa  
                const valorEsperado = precisaTaxa 
                    ? totalPedido // Total já inclui a taxa quando é cartão
                    : (totalPedido - taxaCartao); // Remove taxa quando não é cartão

                // 🔹 Regra 1: pagamento deve ser exatamente igual ao valor esperado
             
                const valorArredondado = Number(valorEsperado.toFixed(2));

                if (soma !== valorArredondado) {
                    alert(`O valor total do pagamento deve ser exatamente R$ ${valorEsperado.toFixed(2).replace('.', ',')}`);
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

            // 🚨 DEBOUNCE GLOBAL - Impede múltiplos cliques em QUALQUER botão de status
            var isUpdatingStatus = false;
            
            $('#btn-update-status').on('click', function() {
                // PREVENIR CLIQUES MÚLTIPLOS (duplo clique)
                if (isUpdatingStatus || $(this).hasClass('processing')) {
                    return false;
                }
                
                // MARCAR COMO PROCESSANDO GLOBALMENTE
                isUpdatingStatus = true;
                
                var values = getFormValues();

                if (values.status != "") {
                    if (values.status == "3" && values.entregador == "0") {
                        alert('Favor selecione o entregador');
                        $('#pedido_entregador').focus();
                        return false;
                    }

                    if (!validatePaymentForms(values)) return false;

                    var forma_pgto = (values.forma_pgto_old != values.forma_pgto_new) ? values.forma_pgto_new : values.forma_pgto_old;
                    var localentrega = $('#localentrega').val() || values.localentrega_old; // Sempre usar valor atual do dropdown

                    // CORREÇÃO: Preserva a obs original se a forma de pagamento não mudou
                    var pedido_obs_pagto = (values.forma_pgto_old == values.forma_pgto_new) 
                        ? values.pedido_obs_pagto_original 
                        : getPaymentMethodDescription(forma_pgto);
                    var pedido_obs_pagto_2 = getPaymentMethodDescription(values.segunda_forma_pgto);

                    var pedido_data = (values.data_compra_old != values.data_compra_new) ? values.data_compra_new : null;

                    // Verifica se alguma forma de pagamento é cartão
                    const forma1 = Number(values.forma_pgto_new);
                    const forma2 = Number(values.segunda_forma_pgto);
                    const precisaTaxa = [2, 3].includes(forma1) || [2, 3].includes(forma2);

                    // Define valores corretos para taxa e total
                    const pedido_taxa_cartao = precisaTaxa ? values.pedido_taxa_cartao : '0.00';
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
                        pedido_entrega: $('#pedidoentrega_original').val(),
                        pedido_taxa_cartao: pedido_taxa_cartao,
                        pedido_total: pedido_total.toFixed(2)
                    };

                    if (pedido_data) {
                        dataPost.pedido_data = pedido_data;
                    }

                    dataPost.pedido_id_pagto_2 = values.segunda_forma_pgto == 0 ? null : values.segunda_forma_pgto;
                    dataPost.pedido_obs_pagto_2 = pedido_obs_pagto_2;
                    dataPost.pedido_valor_pagto = values.pedido_valor_pagto.replace(',', '.');
                    dataPost.pedido_valor_pagto_2 = values.pedido_valor_pagto_2.replace(',', '.');

                    $('#btn-update-status')
                        .html(' Atualizando, aguarde....')
                        .attr('disabled', 'disabled')
                        .addClass('processing');

                    $.post(baseUrl + '/admin/atualizaStatusPedido/', dataPost, function(data) {
                        window.location.href = baseUrl + "/admin/pedidos/?success";
                    }).fail(function(xhr, status, error) {                       
                        $('#btn-update-status')
                            .html('Salvar Alterações')
                            .removeAttr('disabled')
                            .removeClass('processing');
                        alert('Erro ao salvar. Tente novamente.');
                    });
                }
            });

            // Função de impressão
            function imprimirPedido(pedidoId, isPix) {
                isPix = isPix || false;
                var url = isPix ? 
                    '<?= $baseUri ?>/admin/imprimirPix/' + pedidoId + '/' :
                    '<?= $baseUri ?>/admin/imprimir/' + pedidoId + '/';
                window.open(url, '_blank');
            }

            // Função para copiar chave PIX
            function copiarChavePix() {
                var pixKey = document.getElementById('pix-key');
                pixKey.select();
                pixKey.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(pixKey.value).then(function() {
                    alert('✅ Chave PIX copiada!');
                }).catch(function() {
                    document.execCommand('copy');
                    alert('✅ Chave PIX copiada!');
                });
            }

            // ==========================================
            // MODAL ADICIONAR ITENS AO PEDIDO
            // ==========================================
            var produtosDisponiveis = [];
            var categoriasDisponiveis = [];
            var itensSelecionados = [];
            var categoriaAtiva = 'todos';

            function abrirModalAdicionarItens() {
                $('#modalAdicionarItens').modal('show');
                carregarProdutosDisponiveis();
                
                // Marcar que estamos no contexto de adicionar itens ao pedido
                window.adicionandoItensPedido = true;
                
                // Garantir que o evento de busca esteja conectado
                setTimeout(function() {
                    $('#busca-produto-adicionar').off('input').on('input', function() {
                        var busca = $(this).val();
                        aplicarFiltros(busca, categoriaAtiva);
                    });
                }, 500);
            }

            function carregarProdutosDisponiveis() {
                $('#produtos-loading').show();
                $('#produtos-lista').html('');
                $('#produtos-erro').hide();

                $.ajax({
                    url: baseUrl + '/admin/get_produtos_pdv',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#produtos-loading').hide();
                        
                        if (response.success && response.produtos) {
                            produtosDisponiveis = response.produtos;
                            categoriasDisponiveis = response.categorias || [];
                            
                            // Renderizar categorias
                            renderizarCategorias();
                            
                            // Renderizar produtos
                            renderizarProdutos(produtosDisponiveis);
                        } else {
                            $('#produtos-erro').show().text('Erro ao carregar produtos');
                        }
                    },
                    error: function() {
                        $('#produtos-loading').hide();
                        $('#produtos-erro').show().text('Erro de conexão ao carregar produtos');
                    }
                });
            }

            function renderizarCategorias() {
                var html = '<button class="btn btn-sm btn-default categoria-btn ' + (categoriaAtiva === 'todos' ? 'active' : '') + '" data-cat="todos" onclick="filtrarPorCategoria(\'todos\')" style="margin: 5px;">Todos</button>';
                
                categoriasDisponiveis.forEach(function(cat) {
                    html += '<button class="btn btn-sm btn-default categoria-btn ' + (categoriaAtiva === cat.id ? 'active' : '') + '" data-cat="' + cat.id + '" onclick="filtrarPorCategoria(' + cat.id + ')" style="margin: 5px;">' + cat.nome + '</button>';
                });
                
                $('#categorias-filtro').html(html);
            }

            function filtrarPorCategoria(catId) {
                categoriaAtiva = catId;
                $('.categoria-btn').removeClass('active');
                $('.categoria-btn[data-cat="' + catId + '"]').addClass('active');
                
                var busca = $('#busca-produto-adicionar').val();
                aplicarFiltros(busca, catId);
            }

            function aplicarFiltros(busca, catId) {
                busca = (busca || '').toLowerCase();
                catId = catId || categoriaAtiva;
                
                var produtosFiltrados = produtosDisponiveis.filter(function(p) {
                    // Filtro de categoria
                    var matchCategoria = (catId === 'todos' || p.categoria_id == catId);
                    
                    // Filtro de busca
                    var matchBusca = !busca || 
                                    p.nome.toLowerCase().includes(busca) || 
                                    (p.codigo && p.codigo.toLowerCase().includes(busca));
                    
                    return matchCategoria && matchBusca;
                });
                
                renderizarProdutos(produtosFiltrados);
            }

            function renderizarProdutos(produtos) {
                var html = '';
                
                if (produtos.length === 0) {
                    html = '<p class="text-center text-muted" style="padding: 40px;"><i class="fa fa-search fa-3x" style="display:block; margin-bottom: 15px; color: #ddd;"></i>Nenhum produto encontrado</p>';
                } else {
                    // Contador de resultados
                    if (produtos.length < produtosDisponiveis.length) {
                        html += `<div class="alert alert-info" style="margin-bottom: 15px;"><i class="fa fa-info-circle"></i> Encontrados <strong>${produtos.length}</strong> produto(s)</div>`;
                    }
                    
                    html += '<div class="row">';
                    produtos.forEach(function(produto) {
                        var esgotado = produto.estoque <= 0;
                        html += `
                            <div class="col-md-4 col-sm-6" style="margin-bottom: 15px;">
                                <div class="produto-card-item ${esgotado ? 'esgotado' : ''}" style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; background: ${esgotado ? '#f5f5f5' : '#fff'};">
                                    <h5 style="font-size: 14px; font-weight: bold; margin-bottom: 8px; color: ${esgotado ? '#999' : '#333'};">
                                        ${produto.nome}
                                    </h5>
                                    <p style="color: #28a745; font-weight: bold; margin-bottom: 10px;">R$ ${produto.preco}</p>
                                    ${esgotado ? 
                                        '<span class="label label-danger">ESGOTADO</span>' : 
                                        `<button class="btn btn-sm btn-success btn-block" onclick="adicionarItemAoPedidoPorId(${produto.id})">
                                            <i class="fa fa-plus"></i> Adicionar
                                        </button>`
                                    }
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';
                }
                
                $('#produtos-lista').html(html);
            }

            // Função auxiliar para buscar produto por ID e adicionar ao pedido
            function adicionarItemAoPedidoPorId(produtoId) {
                var produto = produtosDisponiveis.find(function(p) { return p.id === produtoId; });
                if (!produto) {
                    alert('Produto não encontrado!');
                    return;
                }
                
                // Adiciona direto - sem modal
                adicionarItemAoPedido(produto.id, produto.nome, produto.preco_num, produto.estoque, produto.categoria_id, produto.categoria_nome, produto.codigo, produto.obs);
            }

            function adicionarItemAoPedido(itemId, itemNome, itemPreco, itemEstoque, categoriaId, categoriaNome, itemCodigo, itemObs) {
                // Verificar se já existe
                var itemExistente = itensSelecionados.find(function(i) { return i.id === itemId; });
                
                if (itemExistente) {
                    if (itemExistente.qtde < itemEstoque) {
                        itemExistente.qtde++;
                    } else {
                        alert('Estoque insuficiente!');
                        return;
                    }
                } else {
                    itensSelecionados.push({
                        id: itemId,
                        nome: itemNome,
                        preco: itemPreco,
                        qtde: 1,
                        estoque: itemEstoque,
                        categoria_id: categoriaId || 0,
                        categoria_nome: categoriaNome || '',
                        codigo: itemCodigo || '',
                        obs: itemObs || ''
                    });
                }
                
                renderizarItensSelecionados();
            }

            function renderizarItensSelecionados() {
                var html = '';
                var total = 0;
                
                if (itensSelecionados.length === 0) {
                    html = '<p class="text-center text-muted">Nenhum item selecionado</p>';
                } else {
                    html += '<table class="table table-condensed">';
                    html += '<thead><tr><th>Item</th><th width="80">Qtd</th><th width="100">Subtotal</th><th width="50"></th></tr></thead>';
                    html += '<tbody>';
                    
                    itensSelecionados.forEach(function(item, index) {
                        var subtotal = item.preco * item.qtde;
                        total += subtotal;
                        
                        html += `
                            <tr>
                                <td>${item.nome}</td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" onclick="alterarQtdeItem(${index}, -1)" type="button"><i class="fa fa-minus"></i></button>
                                        </span>
                                        <input type="text" class="form-control text-center" value="${item.qtde}" readonly style="max-width: 50px;">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" onclick="alterarQtdeItem(${index}, 1)" type="button"><i class="fa fa-plus"></i></button>
                                        </span>
                                    </div>
                                </td>
                                <td><strong>R$ ${subtotal.toFixed(2).replace('.', ',')}</strong></td>
                                <td>
                                    <button class="btn btn-danger btn-xs" onclick="removerItemSelecionado(${index})" title="Remover">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    
                    html += '</tbody>';
                    html += '<tfoot><tr><th colspan="2" class="text-right">Total:</th><th><strong>R$ ' + total.toFixed(2).replace('.', ',') + '</strong></th><th></th></tr></tfoot>';
                    html += '</table>';
                }
                
                $('#itens-selecionados-lista').html(html);
                
                // Habilitar/desabilitar botão confirmar
                $('#btn-confirmar-adicionar-itens').prop('disabled', itensSelecionados.length === 0);
            }

            function alterarQtdeItem(index, delta) {
                if (itensSelecionados[index]) {
                    var novaQtde = itensSelecionados[index].qtde + delta;
                    
                    if (novaQtde <= 0) {
                        removerItemSelecionado(index);
                    } else if (novaQtde <= itensSelecionados[index].estoque) {
                        itensSelecionados[index].qtde = novaQtde;
                        renderizarItensSelecionados();
                    } else {
                        alert('Estoque insuficiente! Disponível: ' + itensSelecionados[index].estoque);
                    }
                }
            }

            function removerItemSelecionado(index) {
                itensSelecionados.splice(index, 1);
                renderizarItensSelecionados();
            }

            function confirmarAdicionarItens() {
                if (itensSelecionados.length === 0) {
                    alert('Selecione ao menos um item!');
                    return;
                }

                if (!confirm(`Deseja adicionar ${itensSelecionados.length} item(ns) ao pedido #<?= $data['pedido']->pedido_id ?>?`)) {
                    return;
                }

                $('#btn-confirmar-adicionar-itens').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Adicionando...');

                $.ajax({
                    url: baseUrl + '/admin/adicionar_itens_pedido',
                    type: 'POST',
                    data: {
                        pedido_id: <?= $data['pedido']->pedido_id ?>,
                        itens: JSON.stringify(itensSelecionados)
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Itens adicionados com sucesso!\n\nNovo total: R$ ' + response.novo_total);
                            window.location.reload();
                        } else {
                            alert('Erro: ' + (response.message || 'Não foi possível adicionar os itens'));
                            $('#btn-confirmar-adicionar-itens').prop('disabled', false).html('<i class="fa fa-check"></i> Confirmar Adição');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro na requisição:', {xhr: xhr, status: status, error: error});
                        console.error('Resposta do servidor:', xhr.responseText);
                        alert('Erro de conexão ao adicionar itens');
                        $('#btn-confirmar-adicionar-itens').prop('disabled', false).html('<i class="fa fa-check"></i> Confirmar Adição');
                    }
                });
            }

            function fecharModalAdicionarItens() {
                itensSelecionados = [];
                categoriaAtiva = 'todos';
                window.adicionandoItensPedido = false; // Limpa a flag
                $('#busca-produto-adicionar').val('').off('input');
                $('#modalAdicionarItens').modal('hide');
                // Renderizar todos os produtos novamente ao fechar
                renderizarProdutos(produtosDisponiveis);
            }

            // ==========================================
            // REMOVER ITEM DO PEDIDO
            // ==========================================
            function removerItemDoPedido(listaId, itemNome, valorItem) {
                if (!confirm('Deseja realmente remover este item do pedido?\n\n' + itemNome + '\nValor: R$ ' + valorItem.toFixed(2).replace('.', ','))) {
                    return;
                }

                // Desabilitar botão para evitar cliques múltiplos
                $('button[onclick*="removerItemDoPedido(' + listaId + '"]').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

                $.ajax({
                    url: baseUrl + '/admin/remover_item_pedido',
                    type: 'POST',
                    data: {
                        pedido_id: <?= $data['pedido']->pedido_id ?>,
                        lista_id: listaId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            alert('Item removido com sucesso!\n\nNovo total: R$ ' + response.novo_total);
                            window.location.reload();
                        } else {
                            alert('Erro: ' + (response.message || 'Não foi possível remover o item'));
                            $('button[onclick*="removerItemDoPedido(' + listaId + '"]').prop('disabled', false).html('<i class="fa fa-trash"></i>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro na requisição:', {xhr: xhr, status: status, error: error});
                        console.error('Resposta do servidor:', xhr.responseText);
                        alert('Erro de conexão ao remover item');
                        $('button[onclick*="removerItemDoPedido(' + listaId + '"]').prop('disabled', false).html('<i class="fa fa-trash"></i>');
                    }
                });
            }

        </script>
    </div>

    <!-- MODAL ADICIONAR ITENS AO PEDIDO -->
    <style>
        .categoria-btn.active {
            background-color: #f39c12 !important;
            color: white !important;
            border-color: #f39c12 !important;
        }
        .categoria-btn {
            transition: all 0.3s ease;
        }
        .categoria-btn:hover {
            background-color: #e08e0b;
            color: white;
        }
    </style>
    <div class="modal fade" id="modalAdicionarItens" tabindex="-1" role="dialog" data-backdrop="static">
        <div class="modal-dialog modal-lg" style="width: 90%; max-width: 1200px;">
            <div class="modal-content">
                <div class="modal-header" style="background: #f39c12; color: white;">
                    <button type="button" class="close" onclick="fecharModalAdicionarItens()" style="color: white;">&times;</button>
                    <h4 class="modal-title">
                        <i class="fa fa-plus-circle"></i> Adicionar Itens ao Pedido #<?= $data['pedido']->pedido_id ?>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- COLUNA ESQUERDA: Lista de Produtos -->
                        <div class="col-md-7">
                            <div class="form-group">
                                <label><i class="fa fa-search"></i> Buscar Produto:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                    <input type="text" id="busca-produto-adicionar" class="form-control" placeholder="Digite o nome ou código do produto..." autofocus>
                                    <span class="input-group-addon" style="cursor: pointer;" onclick="$('#busca-produto-adicionar').val('').trigger('input');" title="Limpar busca">
                                        <i class="fa fa-times"></i>
                                    </span>
                                </div>
                                <small class="text-muted">A busca é feita em tempo real conforme você digita</small>
                            </div>
                            
                            <!-- FILTRO POR CATEGORIAS -->
                            <div class="form-group">
                                <label><i class="fa fa-tags"></i> Filtrar por Categoria:</label>
                                <div id="categorias-filtro" style="margin-top: 5px;"></div>
                            </div>
                            <hr>
                            
                            <div id="produtos-loading" style="text-align: center; padding: 40px; display: none;">
                                <i class="fa fa-spinner fa-spin fa-3x"></i>
                                <p>Carregando produtos...</p>
                            </div>
                            
                            <div id="produtos-erro" class="alert alert-danger" style="display: none;"></div>
                            
                            <div id="produtos-lista" style="max-height: 500px; overflow-y: auto;"></div>
                        </div>
                        
                        <!-- COLUNA DIREITA: Itens Selecionados -->
                        <div class="col-md-5">
                            <h4>Itens Selecionados</h4>
                            <div id="itens-selecionados-lista" style="max-height: 500px; overflow-y: auto;">
                                <p class="text-center text-muted">Nenhum item selecionado</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="fecharModalAdicionarItens()">
                        <i class="fa fa-times"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-success" id="btn-confirmar-adicionar-itens" onclick="confirmarAdicionarItens()" disabled>
                        <i class="fa fa-check"></i> Confirmar Adição
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
