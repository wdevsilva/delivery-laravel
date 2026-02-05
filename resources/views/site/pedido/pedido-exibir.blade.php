<?php
@session_start();
$baseUri = Http::base();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= (isset($data['config']->config_nome)) ? $data['config']->config_nome : ''; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" type="text/css" href="<?php echo $baseUri; ?>/assets/vendor/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/app.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/modal.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/jquery.select2/dist/css/select2.min.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/jquery.select2/dist/css/select2-bootstrap.min.css" />
    <link rel="icon" type="image/png" href="<?php echo $baseUri; ?>/assets/logo/<?= $_SESSION['base_delivery'] ?>/<?php echo (isset($data['config'])) ? $data['config']->config_foto : ''; ?>" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/view/site/app-css/card.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/tema.php?<?php echo $data['config']->config_colors; ?>" type="text/css" />
    <link href="<?php echo $baseUri; ?>/assets/css/main.css?v=<?= filemtime(__DIR__ . '/../../assets/css/main.css') ?>" rel="stylesheet" />
</head>

<body>
    <div class="container" id="home-content">
        <?php require_once 'menu.php'; ?>
        <br>
        <div class="<?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
            <br>
            <?php
            $status = Status::check($data['pedido']->pedido_status); ?>
            <div class="well well-sm">
                <div class="row">
                    <div class="col-xs-6">
                        <span>
                            PEDIDO #<?= $data['pedido']->pedido_id ?><br>
                            Nº ENTREGA #<?= str_pad($data['pedido']->pedido_numero_entrega, 2, 0, STR_PAD_LEFT) ?><br>
                            <br>
                            <?php if ($data['pedido']->pedido_entrega > 0) : ?>
                                TAXA ENTREGA R$ <?= Currency::moeda($data['pedido']->pedido_entrega) ?><br>
                            <?php endif; ?>
                            <?php
                            if ($data['pedido']->pedido_taxa_cartao != '' && floatval($data['pedido']->pedido_taxa_cartao) > 0) {
                            ?>
                                TAXA CARTÃO R$ <?= Currency::moeda($data['pedido']->pedido_taxa_cartao, 2, ',', '.') ?><br>
                            <?php } ?>
                            <span class="text-bold"> TOTAL R$ <?= Currency::moeda($data['pedido']->pedido_total); ?></span>
                            <?php

                            if ($data['pedido']->pedido_troco != '' && $data['pedido']->pedido_troco != '0.00' && $data['pedido']->pedido_troco > 0) { ?>
                                <br>
                                <span class="text-bold"> TROCO R$ <?= Currency::moeda($data['pedido']->pedido_troco); ?></span>
                            <?php } ?>
                        </span>
                    </div>
                    <div class="col-xs-6">
                        <small class="pull-right">
                            <i class="fa fa-clock-o"></i>
                            <?= date('d/m/Y H:i', strtotime($data['pedido']->pedido_data)); ?>
                            <br>
                        </small>
                    </div>
                </div>
            </div>
            <?php
            use \App\Pix\Payload;
            use Mpdf\QrCode\QrCode;
            use Mpdf\QrCode\Output;

            if (isset($data['lista'])) :

                $re_id = $data['pedido']->pedido_id;
                $cliente = $data['cliente'];
                $resumo = "*RESUMO DO PEDIDO*\n";
                $resumo .= "Número do Pedido: $re_id \n";
                $resumo .= "Nome: $cliente->cliente_nome \n";
                $resumo .= "Telefone: $cliente->cliente_fone2 \n";

                foreach ($data['lista'] as $cart) : ?>
                    <div class="row">
                        <div class="ol-md-5 col-xs-7">
                            <p class="text-capitalize">
                                <?= $cart->lista_qtde ?>
                                <small class="text-muted">x</small>
                                <?= mb_strtolower($cart->categoria_nome) ?>
                                <?php if (strrpos($cart->lista_item_desc ?? '', '1/2') === false) { ?>
                                    - <?= mb_strtolower($cart->item_nome) ?>
                                <?php } ?>
                                <br>
                                <small class="text-muted">
                                    <?php
                                    if (strlen($cart->lista_item_desc ?? '') >= 0) : ?>
                                        <?= mb_strtolower($cart->item_obs) ?>
                                    <?php endif; ?>
                                    <?= $cart->lista_item_desc ?? '' ?>
                                </small>
                            </p>
                        </div>
                        <div class="col-md-2 col-xs-5">
                            R$ <?= Currency::moeda($cart->item_preco * $cart->lista_qtde) ?>
                        </div>
                        <?php if (isset($cart->lista_promocao_id) != '') { ?>
                            <div class="text-capitalize well-sm well">
                                <span class="text-bold">
                                    <?= $cart->lista_promocao_premio_produto ?>
                                </span>
                                <small class="text-muted pull-right">
                                    <span style="font-size: 9px">x</span>
                                    <?= $cart->lista_promocao_premio_qtd ?>
                                </small>
                                <br>
                                <p>
                                    <small class="pull-right text-muted text-bold">
                                        GRÁTIS
                                    </small>
                                </p>
                            </div>
                        <?php } ?>
                    </div>
                    <?php
                    $re_preco = Currency::moeda($cart->lista_opcao_preco);
                    $resumo .= "Item: $cart->lista_item_nome x $cart->lista_qtde - R$ $re_preco \n";
                    if (strip_tags($cart->lista_item_desc ?? '') != '') {
                        $resumo .= "($cart->lista_item_desc)\n";
                    }
                    $resumo .= "\n";

                endforeach;

                //EXIBE O PRÊMIO DA COMPRA
                if (isset($data['lista_premio'])) {
                    foreach ($data['lista_premio'] as $cartPremio) : ?>
                        <div class="rows">
                            <div class="text-capitalize well-sm well">
                                <span class="text-bold">
                                    <?= $cartPremio->promocao_produto ?>
                                </span>
                                <small class="text-muted pull-right">
                                    <span style="font-size: 9px">x</span>
                                    <?= $cartPremio->promocao_qtd ?>
                                </small>
                                <br>
                                <p>
                                    <small class="pull-right text-muted text-bold">
                                        GRÁTIS
                                    </small>
                                </p>
                            </div>
                        </div>
                <?php
                    endforeach;
                }

                $re_obs = trim($data['pedido']->pedido_obs);
                $re_obs_pagto = trim($data['pedido']->pedido_obs_pagto);
                $re_total = Currency::moeda($data['pedido']->pedido_total);
                $prazo = $data['pedido']->pedido_entrega_prazo;
                $re_obs = ($re_obs != "") ? "Obs: $re_obs \n" : "";
                $taxa_entrega = Currency::moeda($data['pedido']->pedido_entrega);
                $resumo .= "Taxa de entrega: R$  $taxa_entrega \n";
                if ($prazo != "") {
                    $resumo .= "Tempo estimado: $prazo \n";
                }
                $resumo .= "*Total: R$ $re_total*\n";
                $resumo .= "$re_obs_pagto \n";
                ?>
                <?php if ($data['pedido']->pedido_obs != "") : ?>
                    <h5 class="text-uppercase text-bold">Observações</h5>
                    <small class="text-muted"><?= $data['pedido']->pedido_obs ?></small>
                    <hr>
                <?php endif; ?>
                
                <!-- BOX DE STATUS DO PEDIDO -->
                <div class="alert alert-<?= $status->color ?> text-center" id="status-pedido-box" style="margin: 20px 0; padding: 20px; border-radius: 8px;">
                    <h4 class="text-uppercase" style="margin: 0;">STATUS DO PEDIDO</h4>
                    <h2 id="status-icon" style="margin: 10px 0;"><?= $status->icon ?></h2>
                </div>
                <hr>
                <?php if (isset($data['endereco'])) : ?>
                    <?php $end = $data['endereco']; ?>
                    <?php
                    $compl = ($end->endereco_complemento != "") ? $end->endereco_complemento . " - " : '';
                    $ref = ($end->endereco_referencia != "") ? " (" . $end->endereco_referencia . ") " : '';
                    $endereco_full = ucfirst("$end->endereco_endereco, $end->endereco_numero, $compl  $end->endereco_bairro - $end->endereco_cidade $ref  ");
                    ?>
                    <h5 class="text-uppercase text-bold">Entregar em: <?= strtoupper($end->endereco_nome) ?></h5>
                    <?= $endereco_full ?>
                    <?php $resumo .= "Local de entrega: $endereco_full \n"; ?>
                    <?php $resumo .= "$re_obs \n \n"; ?>
                    <Br><small>Tempo estimado: <?= $prazo ?></small>
                <?php endif; ?>
                <?php if (isset($data['pedido']->retirar_no_local)) : ?>
                    <h5 class="text-uppercase text-bold">Retirar no local</h5>
                    <p><a href="http://maps.google.com/maps?daddr=<?= $data['config']->config_endereco; ?>&amp;ll=" target="__blank" class="maps" role="button" data-toggle="popover" title="Google Maps" data-content="Clique para abrir."><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $data['config']->config_endereco; ?></a></p>
                    <?php $resumo .= "Local de entrega: Irá retirar no local \n"; ?>
                    <?php $resumo .= "$re_obs \n \n"; ?>
                    <hr>
                <?php endif; ?>
                <?php if (isset($_GET['new'])) { ?>
                    <h5 class="text-uppercase alert alert-success text-center">
                        Pedido realizado com sucesso!<br><br>
                        Manteremos você informado(a) sempre que a nossa cozinha alterar o status do seu pedido!
                    </h5>
                <?php } ?>
                <hr>
                <?php

                //1 = dinheiro na entrega, 2 = cartão débito, 3 = cartão crédito, 7 = Cartão de Crédito (Pagamento Online), 4 = pix
                if ($data['pedido']->pedido_id_pagto == 4) {

                    if ($data['config']->config_pix == 1 && $data['config']->config_pix_automatico == 0) {

                        //SE O PEDIDO NÃO FOI CANCELADO OU JÁ TIVER SIDO ENTREGUE NÃO MOSTRA MAIS
                        if ($data['pedido']->pedido_status != 5 && $data['pedido']->pedido_status != 4) {

                            //1 = cpf 2 = celular 3 = e-mail
                            if ($data['config']->config_tipo_chave == 1) {
                                $pixKey = str_replace('.', '', str_replace('-', '', $data['config']->config_chave_pix));
                            }
                            if ($data['config']->config_tipo_chave == 2) {
                                $celular = str_replace('(', '', str_replace(')', '', str_replace(' ', '', str_replace('-', '', $data['config']->config_chave_pix))));
                                $pixKey = "+55$celular";
                            }
                            if ($data['config']->config_tipo_chave == 3) {
                                $pixKey = $data['config']->config_chave_pix;
                            }

                            //instancia principal do payloado pix
                            // TxID único por empresa: BASE_PEDIDO_ID (máx 20 caracteres para compatibilidade)
                            $baseEmpresa = strtoupper(substr(preg_replace('/[^A-Z0-9]/', '', $_SESSION['base_delivery'] ?? 'DEF'), 0, 6));
                            $txid = $baseEmpresa . 'P' . $data['pedido']->pedido_id;
                            $txid = strtoupper(substr($txid, 0, 20)); // Máx 20 caracteres (Nubank, Inter)
                            
                            // DEBUG: Log do valor antes de passar pro setAmount
                            error_log("[PIX DEBUG] Pedido #{$data['pedido']->pedido_id} - Valor original: {$data['pedido']->pedido_total} - Tipo: " . gettype($data['pedido']->pedido_total));
                            
                            $obPayload = (new  Payload)->setPixKey("$pixKey")
                                ->setDescription('Pedido #' . $data['pedido']->pedido_id)
                                ->setMerchantName(substr(str_replace("'", '', $data['config']->config_nome), 0, 25))
                                ->setMerchantCity(substr('Pacajus', 0, 15))
                                ->setAmount($data['pedido']->pedido_total)
                                ->setTxid($txid)
                                ->setUniquePayment(true);

                            try {
                                //código de pagamento do pix
                                $payloadQrcode = $obPayload->getPayload();

                                //qr code
                                $obQrCode = new QrCode($payloadQrcode);

                                //imagem do qr code
                                $image = (new Output\Png)->output($obQrCode, 200);
                                
                                // ✅ Verificar se imagem foi gerada
                                if (!$image || strlen($image) < 100) {
                                    throw new Exception("Imagem QR Code vazia ou inválida");
                                }
                                ?>
                                <div class="alert alert-info">
                                    <label>QrCode:</label>
                                    <center><img src="data:image/png;base64, <?= base64_encode($image) ?>"></center>
                                    <br>
                                    <label>Chave Pix:</label>
                                    <textarea class="form-control" id="pix" rows="4" readonly><?= $payloadQrcode ?></textarea>
                                    <br>
                                    <center><button class="btn btn-info" style="margin: 0 auto;" onclick="copyToClipboradFunc()">Copiar Chave</button></center>
                                </div>
                            <?php
                            } catch (Exception $e) {
                                error_log("[PIX ESTÁTICO] Erro ao gerar QR Code - Pedido #{$data['pedido']->pedido_id}: " . $e->getMessage());
                                ?>
                                <div class="alert alert-danger">
                                    <i class="fa fa-exclamation-triangle"></i> <strong>Erro ao gerar QR Code</strong><br>
                                    Não foi possível gerar o código QR. Use a chave PIX abaixo:
                                    <br><br>
                                    <label>Chave PIX:</label>
                                    <input type="text" class="form-control" value="<?= $data['config']->config_chave_pix ?>" readonly onclick="this.select()" style="font-size: 16px; font-weight: bold;">
                                    <br>
                                    <center><button class="btn btn-warning" onclick="navigator.clipboard.writeText('<?= addslashes($data['config']->config_chave_pix) ?>'); alert('Chave copiada!');">Copiar Chave PIX</button></center>
                                </div>
                            <?php } ?>

                            <?php if ($_SESSION['base_delivery'] == 'sorvanna') { ?>
                                <div class="alert alert-warning">Após o pagamento, favor enviar o comprovante para
                                    <a href="https://api.whatsapp.com/send?phone=5585991973141" target="_blank">
                                        <i class="fa fa-whatsapp" aria-hidden="true"></i> Whatsapp
                                    </a> para iniciarmos o seu pedido
                                    <br><br>
                                    <?php
                                    echo "Caso não consiga realizar o pagamento pelo QrCode ou chave pix a cima, 
                            Você pode estar realizando o pagamento direto para chave: <b>" . $data['config']->config_chave_pix . "</b>";
                                    ?>
                                </div>
                            <?php } else { ?>
                                <div class="alert alert-warning">Após o pagamento, favor enviar o comprovante para
                                    <a href="https://api.whatsapp.com/send?phone=55<?= preg_replace('/\D/', '', $data['config']->config_fone1) ?>" target="_blank">
                                        <i class="fa fa-whatsapp" aria-hidden="true"></i> Whatsapp
                                    </a> para iniciarmos o seu pedido
                                </div>
                            <?php }
                        }
                    } else {

                        //SE O PEDIDO NÃO FOI CANCELADO OU JÁ TIVER SIDO ENTREGUE NÃO MOSTRA MAIS
                        if ($data['pedido']->pedido_status != 5 && $data['pedido']->pedido_status != 4) {

                            //1 = cpf 2 = celular 3 = e-mail
                            if ($data['config']->config_tipo_chave == 1) {
                                $pixKey = str_replace('.', '', str_replace('-', '', $data['config']->config_chave_pix));
                            }
                            if ($data['config']->config_tipo_chave == 2) {
                                $celular = str_replace('(', '', str_replace(')', '', str_replace(' ', '', str_replace('-', '', $data['config']->config_chave_pix))));
                                $pixKey = "+55$celular";
                            }
                            if ($data['config']->config_tipo_chave == 3) {
                                $pixKey = $data['config']->config_chave_pix;
                            }

                            //Gera o QRCode PIX usando a biblioteca local (sem API MercadoPago)
                            // TxID único por empresa: BASE_PEDIDO_ID (máx 20 caracteres para compatibilidade)
                            $baseEmpresa = strtoupper(substr(preg_replace('/[^A-Z0-9]/', '', $_SESSION['base_delivery'] ?? 'DEF'), 0, 6));
                            $txid = $baseEmpresa . 'P' . $data['pedido']->pedido_id;
                            $txid = strtoupper(substr($txid, 0, 20)); // Máx 20 caracteres (Nubank, Inter)
                            
                            $obPayload = (new Payload)
                                ->setPixKey($pixKey)
                                ->setDescription('Pagamento pedido #' . $data['pedido']->pedido_id)
                                ->setMerchantName($data['config']->config_nome)
                                ->setMerchantCity($data['config']->config_cidade ?? 'Pacajus')
                                ->setAmount($data['pedido']->pedido_total)
                                ->setTxid($txid);

                            $payloadQrCode = $obPayload->getPayload();

                            $obQrCode = new QrCode($payloadQrCode);
                            $image = (new Output\Png)->output($obQrCode, 200, [255, 255, 255], [0, 0, 0]);
                            ?>
                            <div class="alert alert-info">
                                <label>QrCode:</label>
                                <center><img src="data:image/png;base64, <?= base64_encode($image) ?>" style="width: 20%;"></center>
                                <br>
                                <label>Chave Pix:</label>
                                <textarea class="form-control" id="pix" rows="4" readonly><?= $payloadQrCode ?></textarea>
                                <br>
                                <center><button class="btn btn-info" style="margin: 0 auto;" onclick="copyToClipboradFunc()">Copiar Chave</button></center>
                            </div>
                        <?php } ?>
                        <?php
                    }
                }
                ?>
            <?php endif; ?>
        </div>
    </div>
    <?php 
    require_once 'footer.php'; 
    require 'side-carrinho.php'; 
    ?>
    <script>
        var currentUri = 'pedido';
    </script>
    <?php require_once 'footer-core-js.php'; ?>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/pedido.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/number.js"></script>
    <script src="<?php echo $baseUri; ?>/view/site/app-js/howler.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/carrinho.js"></script>
    <?php

    //DADOS DO PEDIDO PARA ENVIO PELO WHATSAPP
    // Dados do pedido
    $dataPedido = date('d/m/Y H:i', strtotime($data['pedido']->pedido_data));
    $pedidoId = $data['pedido']->pedido_id;
    $numeroEntrega = str_pad($data['pedido']->pedido_numero_entrega, 2, 0, STR_PAD_LEFT);
    $clienteNome = strtoupper(ucfirst($data['pedido']->cliente_nome));
    $clienteTelefone = $data['pedido']->cliente_fone2;

    // Dados do endereço
    $endereco = isset($data["endereco"]) ? $data["endereco"] : null;
    $enderecoStr = '';
    if ($endereco) {
        $enderecoStr .= strtoupper($endereco->endereco_endereco) . ', ' . $endereco->endereco_numero . ', ';
        if ($endereco->endereco_complemento != "") {
            $enderecoStr .= strtoupper($endereco->endereco_complemento) . ' - ';
        }
        $enderecoStr .= strtoupper($endereco->endereco_bairro) . ' - ' . strtoupper($endereco->endereco_cidade) . ', ' . strtoupper($endereco->endereco_nome);
        if ($endereco->endereco_referencia != "") {
            $enderecoStr .= ' (PONTO DE REF.: ' . strtoupper($endereco->endereco_referencia) . ')';
        }
    } else {
        $enderecoStr = 'RETIRAR NO LOCAL';
    }

    // Itens do pedido
    $subtotal = 0;
    $itensPedido = [];
    if (isset($data["lista"]) && is_array($data["lista"])) {
        foreach ($data["lista"] as $cart) {
        $subtotal += $cart->lista_opcao_preco * $cart->lista_qtde;
        $itemStr = $cart->lista_qtde . 'x ' . strtoupper($cart->categoria_nome);

        if (strrpos($cart->lista_item_desc ?? "", "1/2") === false) {
            $itemStr .= " - " . strtoupper($cart->lista_opcao_nome);
        }

        if (strip_tags($cart->lista_item_desc ?? "") != "") {
            $itemStr .= ' (' . strip_tags(mb_strtolower(($cart->lista_item_desc))) . ')';
        }

        // Preço total do item
        $itemPreco = Currency::moeda($cart->item_preco * $cart->lista_qtde);
        $itemStr .= ' - R$' . $itemPreco;

        // Adicionais
        if ($cart->lista_item_extra) {
            $adicionais = explode(",", $cart->lista_item_extra);
            $adicionais_val = explode(",", $cart->lista_item_extra_vals);
            $itemStr .= "\nAdicionais:\n"; // Adicionais header
            for ($i = 0; $i < count($adicionais); $i++) {
                // Normaliza o valor do adicional antes de multiplicar (pode vir formatado)
                $rawAdjVal = isset($adicionais_val[$i]) ? $adicionais_val[$i] : 0;
                $cleanAdj = preg_replace('/[^0-9\,\.\-]/', '', (string) $rawAdjVal);
                $numericAdj = (float) str_replace(',', '.', $cleanAdj);
                // Calcular o valor total do adicional
                $valorAdicional = number_format($numericAdj * $cart->lista_qtde, 2, ',', '.');
                $itemStr .= "- " . strtoupper(trim($adicionais[$i])) . " - R$ $valorAdicional\n"; // Adicionais list with values
            }
        }

            $itensPedido[] = $itemStr;
        }
    }

    // Total e observações
    $obs = '';
    if ($data["pedido"]->pedido_obs != "") {
        $obs = 'OBS: ' . $data["pedido"]->pedido_obs;
    }

    // Montando o resumo
    $resumoZap = "*RESUMO DO PEDIDO*\n";
    $resumoZap .= "*DATA PEDIDO:* $dataPedido\n";
    $resumoZap .= "*PEDIDO #:* $pedidoId | N° ENTREGA #: $numeroEntrega\n";
    $resumoZap .= "*DADOS DO CLIENTE*\n";
    $resumoZap .= "*NOME:* $clienteNome\n";
    $resumoZap .= "*TELEFONE:* $clienteTelefone\n";
    $resumoZap .= "*END. ENTREGA:* $enderecoStr\n";
    $resumoZap .= "*ITENS DO PEDIDO:*\n";

    // Adicionando itens do pedido
    foreach ($itensPedido as $item) {
        $resumoZap .= "- $item\n";
    }

    $resumoZap .= "$obs\n";
    $resumoZap .= "*TOTAIS*\n";
    $resumoZap .= "*SUB-TOTAL:* R$" . Currency::moeda($subtotal) . "\n";

    // Adicionando desconto e taxas
    $dadosCupom = (new cupomModel)->get_desconto_cupom($data["pedido"]->pedido_id);
    if (!empty($dadosCupom)) {
        $resumoZap .= "*DESCONTO:* ";
        if ($dadosCupom->cupom_tipo == "1") {
            $resumoZap .= 'R$' . Currency::moeda($dadosCupom->cupom_valor) . "\n";
        } else {
            $resumoZap .= $dadosCupom->cupom_percent . "%\n";
        }
    }

    $resumoZap .= "*TAXA DE ENTREGA:* R$" . Currency::moeda($data["pedido"]->pedido_entrega) . "\n";

    if ($data["pedido"]->pedido_taxa_cartao != "0.00") {
        $resumoZap .= "*TAXA CARTÃO:* R$ " . number_format($data["pedido"]->pedido_taxa_cartao, 2, ",", ".") . "\n";
    }

    $resumoZap .= "*TOTAL A PAGAR:* R$" . Currency::moeda($data["pedido"]->pedido_total) . "\n";

    if ($data["pedido"]->pedido_troco != "" && $data["pedido"]->pedido_troco != "0.00" && $data["pedido"]->pedido_troco > 0) {
        $resumoZap .= "*TROCO:* R$" . Currency::moeda($data["pedido"]->pedido_troco) . "\n";
    }

    $resumoZap .= "*PAGAMENTO:* " . ($data["pedido"]->pedido_obs_pagto) . "\n";

    if (isset($resumoZap) && $resumoZap != "" && $isMobile == true && isset($_GET['new'])) : ?>
        <?php if (isset($data['config']->config_resumo_whats) && $data['config']->config_resumo_whats == 1) : ?>
            <script>
                setTimeout(function() {
                    var whats = '55<?= preg_replace('/\D/', '', $data['config']->config_fone1) ?>';
                    var link = 'https://api.whatsapp.com/send?phone=' + whats + '&text=<?= urlencode($resumoZap) ?>';
                    window.location = link;
                }, 500)
            </script>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (isset($data['pedido']->pedido_status) && $data['pedido']->pedido_status < 4) : ?>
        <?php
        $_SESSION['__LAST__PEDIDO__']['ID'] = $data['pedido']->pedido_id;
        $_SESSION['__LAST__PEDIDO__']['STATUS'] = $data['pedido']->pedido_status;
        ?>
    <?php endif; ?>
    <script type="text/javascript">
        var backLinks = document.querySelectorAll('.voltar, .voltarFooter');
        backLinks.forEach(function(backLink) {
            backLink.addEventListener('click', function(event) {
                event.preventDefault();
                window.location.href = '../../index';
            });
        });

        function copyToClipboradFunc() {

            let copiedText = document.getElementById("pix");
            copiedText.select();
            copiedText.setSelectionRange(0, 99999);

            document.execCommand("copy");

            alert('Chave copiada com sucesso');
        }
        $('.maps').popover('hide')

        

        rebind_reload();

        // Auto-refresh do status do pedido a cada 5 segundos
        var pedidoId = <?= $data['pedido']->pedido_id ?>;
        var lastStatus = <?= $data['pedido']->pedido_status ?>;
        var baseUri = '<?= $baseUri ?>';
        
        function checkOrderStatus() {
            $.ajax({
                url: baseUri + '/pedido/status_api?id=' + pedidoId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.status !== lastStatus) {
                        // Status mudou! Atualizar a página ou apenas o box
                        lastStatus = response.status;
                        
                        // Atualiza o box de status
                        $('#status-pedido-box').removeClass('alert-warning alert-info alert-success alert-danger')
                                                .addClass('alert-' + response.color);
                        $('#status-icon').html(response.icon);
                        
                        // Mostra notificação
                        console.log('🔔 Status do pedido atualizado:', response.icon);
                    }
                },
                error: function() {
                    console.log('⚠️ Erro ao verificar status do pedido');
                }
            });
        }
        
        // Verifica o status apenas se o pedido não estiver finalizado (status < 4)
        <?php if ($data['pedido']->pedido_status < 4): ?>
        setInterval(checkOrderStatus, 5000); // Verifica a cada 5 segundos
        <?php endif; ?>
    </script>
</body>

</html>