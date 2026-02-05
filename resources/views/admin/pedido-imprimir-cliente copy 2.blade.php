<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    text-center {
        text-align: center;
    }

    .ttu {
        text-transform: uppercase;
    }

    .printer-ticket {
        display: table !important;
        width: 80mm;
        max-width: 400px;
        font-weight: light;
        line-height: 1.3em;
    }

    .printer-ticket,
    .printer-ticket * {
        font-family: Tahoma, Geneva, sans-serif;
        font-size: 10px;
    }

    .printer-ticket th:nth-child(2),
    .printer-ticket td:nth-child(2) {
        width: 50px;
    }

    .printer-ticket th:nth-child(3),
    .printer-ticket td:nth-child(3) {
        width: 90px;
        text-align: right;
    }

    .printer-ticket th {
        font-weight: inherit;
        padding: 10px 0;
        text-align: center;
        border-bottom: 1px dashed #900;
    }

    .printer-ticket tbody tr:last-child td {
        padding-bottom: 10px;
    }

    .printer-ticket tfoot .sup td {
        padding: 10px 0;
        border-top: 1px dashed #900;
    }

    .printer-ticket tfoot .sup.p--0 td {
        padding-bottom: 0;
    }

    .printer-ticket .title {
        font-size: 1.5em;
        padding: 0 0;
    }

    .printer-ticket .top td {
        padding-top: 10px;
    }

    .printer-ticket .last td {
        padding-bottom: 10px;
    }

    #divImprimir {
        size: auto;
        margin: 2mm 2mm 2mm 2mm;
        font-family: monospace;
        font-size: 9pt;
        width: 80mm;
    }

    .boxed-md.boxed-padded {
        padding-bottom: 13px;
        padding-left: 20px;
        padding-right: 20px;
    }

    .boxed-md {
        border: 0px solid #ccc;
        margin-bottom: 14px;
        margin-top: 14px;
    }
</style>

<body class="animated">
    <?php
    function tirarAcentos($string)
    {
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $string);
    }
    ?>
    <div style="margin: 0 auto;align-items: center;display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;" class="row justify-content-center ">
        <div id="divImprimir" style="background-color: #fdfbe3;" class="boxed-md boxed-padded">
            <table class="printer-ticket">
                <thead>
                    <tr>
                        <th class="title" colspan="3">
                            <h4><b>CUPOM NÃO FISCAL</b></h4>
                            <b><?= strtoupper($data['config']->config_nome) ?></b><br>
                            <small>
                                <?= strtoupper($data['config']->config_endereco) ?><br>
                                <?= $data['config']->config_fone1 ?><br>
                            </small>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="3" style="font-size: 12px;">
                            <b>DATA PEDIDO</b> <?= date('d/m/Y H:i', strtotime($data['pedido']->pedido_data)) ?><br>
                            <b>PEDIDO #</b><?= $data['pedido']->pedido_id ?> |
                            <b>Nº ENTREGA #</b><?= str_pad($data['pedido']->pedido_numero_entrega, 2, 0, STR_PAD_LEFT) ?>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="3" style="font-size: 12px;">
                            <b>DADOS DO CLIENTE</b><br>
                            <b>NOME:</b> <?= strtoupper(ucfirst($data['pedido']->cliente_nome)) ?><br>
                            <b>TELEFONE:</b> <?= $data['pedido']->cliente_fone2 ?><br>
                            <?php if (isset($data['endereco'])) : ?>
                                <?php $end = $data['endereco']; ?>
                                <b>END. ENTREGA:</b> <?= (strtoupper($end->endereco_endereco)) ?>,<?= $end->endereco_numero ?>,
                                <?php if ($end->endereco_complemento != "") : ?>
                                    <?= (strtoupper($end->endereco_complemento)) ?> -
                                <?php endif; ?>
                                <?= (strtoupper($end->endereco_bairro)) ?> -
                                <?= (strtoupper($end->endereco_cidade)) ?>,
                                <?= (strtoupper($end->endereco_nome)) ?>
                                <?php if ($end->endereco_referencia != "") : ?>
                                    <br>
                                    <b>PONTO DE REF.:</b> <?= (strtoupper($end->endereco_referencia)) ?>
                                <?php endif; ?>
                            <?php else : ?>
                                RETIRAR NO LOCAL
                            <?php endif; ?>
                        </th>
                    </tr>
                    <tr>
                        <th class="ttu" colspan="3">
                            <b>ITENS DO PEDIDO</b>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    $subtotal = 0;
                    foreach ($data['lista'] as $key => $cart) {
                        $subtotal += $cart->lista_opcao_preco * $cart->lista_qtde;
                    ?>
                        <tr>
                            <td style="width: 20px; font-size: 12px;">
                                <?= $cart->lista_qtde ?><small>x</small>
                            </td>
                            <td style="width: 500px; font-size: 12px;">
                                <b><?= $cart->categoria_nome ?>
                                <?php 
                                // Mostra o nome do produto/opção
                                if (strrpos($cart->lista_item_desc ?? '', '1/2') === false) {
                                    echo ' - ' . strtoupper($cart->lista_opcao_nome);
                                }
                                ?></b>
                                <?php
                                // Mostra descrição do item (ingredientes) SEM adicionais
                                $desc = strip_tags($cart->lista_item_desc ?? '');
                                // Remove a parte de adicionais da descrição se existir
                                if (strpos($desc, 'adicionais:') !== false) {
                                    $desc = trim(substr($desc, 0, strpos($desc, 'adicionais:')));
                                }
                                // NÃO mostra ingredientes se tiver adicionais (para evitar repetição)
                                if ($desc != '' && empty($cart->lista_item_extra)) { 
                                ?>
                                    <br><small style="color: #666;"><?= mb_strtolower($desc) ?></small>
                                <?php } ?>
                            </td>
                            <td style="width: 100px; font-size: 12px">
                                <?php 
                                // Calcula o valor do item SEM adicionais (parse seguro dos valores em lista_item_extra)
                                $valor_adicionais = 0;
                                if (!empty($cart->lista_item_extra)) {
                                    $rawExtras = strip_tags($cart->lista_item_extra);
                                    // Captura todos os valores no formato (+R$ 5,00)
                                    if (preg_match_all('/\(\+R\$\s*([\d.,]+)\)/u', $rawExtras, $matches)) {
                                        foreach ($matches[1] as $valStr) {
                                            // Converte "5,00" -> 5.00 e remove milhares
                                            $val = floatval(str_replace(',', '.', preg_replace('/\./', '', trim($valStr))));
                                            $valor_adicionais += $val;
                                        }
                                    }
                                }
                                $valor_sem_adicionais = ($cart->lista_opcao_preco - $valor_adicionais) * $cart->lista_qtde;
                                ?>
                                R$<?= Currency::moeda($valor_sem_adicionais) ?>
                            </td>
                        </tr>
                        <?php 
                        // Se tiver adicionais ou itens grátis, mostra em uma linha separada
                        if (!empty($cart->lista_item_extra)) {
                            $extras_raw = strip_tags($cart->lista_item_extra);
                            
                            // Parse adicionais COM preço
                            $extras_matches = [];
                            preg_match_all('/([^,()]+)\s*\(\+R\$\s*([\d.,]+)\)/u', $extras_raw, $extras_matches, PREG_SET_ORDER);
                            
                            // Verifica se tem "Itens grátis" (sem preço)
                            $itens_gratis = '';
                            if (stripos($extras_raw, 'itens grátis') !== false || stripos($extras_raw, 'itens gratis') !== false) {
                                // Captura "Itens grátis: Garfo" ou similar
                                if (preg_match('/itens\s+gr[aá]tis[:\s]*([^,]+)/iu', $extras_raw, $gratis_match)) {
                                    $itens_gratis = trim($gratis_match[0]);
                                }
                            }
                            
                            // Só mostra a linha se tiver adicionais com preço OU itens grátis
                            if (!empty($extras_matches) || !empty($itens_gratis)) {
                            ?>
                            <tr>
                                <td style="width: 20px; font-size: 12px;">
                                    &nbsp;
                                </td>
                                <td style="width: 500px; font-size: 12px;">
                                    <?php 
                                    // Mostra adicionais com preço
                                    foreach($extras_matches as $m){ 
                                        $name = trim($m[1]);
                                        $valStr = trim($m[2]);
                                    ?>
                                        <small style="padding-left: 10px;">+ <?= $name ?> (+R$ <?= $valStr ?>)</small><br>
                                    <?php } ?>
                                    <?php 
                                    // Mostra itens grátis
                                    if (!empty($itens_gratis)) { ?>
                                        <small style="padding-left: 10px;"><i><?= ucfirst($itens_gratis) ?></i></small>
                                    <?php } ?>
                                </td>
                                <td style="width: 100px; font-size: 12px">
                                    <?php 
                                    if ($valor_adicionais > 0) {
                                        $total_adicionais = $valor_adicionais * $cart->lista_qtde;
                                        echo 'R$' . Currency::moeda($total_adicionais);
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php } 
                        } ?>
                        <?php
                    }
                    //SE HOUVER PROMOÇÃO GRANHA
                    if (isset($data['lista_premio'])) {
                        foreach ($data['lista_premio'] as $key => $cartPremio) { ?>
                            <tr>
                                <td style="width: 20px; font-size: 12px;"><?= $cartPremio->promocao_qtd ?><small>x</small></td>
                                <td style="width: 500px; font-size: 12px;">
                                    <?= (strtoupper($cartPremio->promocao_produto)) ?>
                                </td>
                                <td style="width: 100px; font-size: 12px;">- GRATIS</td>
                            </tr>
                        <?php
                        }
                    }
                    if ($data['pedido']->pedido_obs != "") : ?>
                        <tr>
                            <td style="border-top: 1px dashed #900; font-size: 12px; font-weight: bold; padding: 10px;" colspan="3">OBS: <?= $data['pedido']->pedido_obs ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="sup ttu p--0">
                        <td colspan="3">
                            <b>TOTAIS</b>
                        </td>
                    </tr>
                    <tr class="ttu">
                        <td colspan="2">SUB-TOTAL</td>
                        <td align="right">R$<?= Currency::moeda($subtotal) ?></td>
                    </tr>
                    <?php
                    // ✅ Extrair desconto de fidelidade da observação ou do campo pedido_desconto
                    $desconto_fidelidade = 0;
                    if (isset($data['pedido']->pedido_desconto) && $data['pedido']->pedido_desconto > 0) {
                        $desconto_fidelidade = $data['pedido']->pedido_desconto;
                    } elseif (strpos($data['pedido']->pedido_obs, 'Desconto Fidelidade') !== false) {
                        // Tentar extrair da observação: "*** Desconto Fidelidade (10%) - R$ 1,50"
                        if (preg_match('/Desconto Fidelidade.*?R\$\s*([\d.,]+)/', $data['pedido']->pedido_obs, $matches)) {
                            $desconto_fidelidade = (float)str_replace(',', '.', $matches[1]);
                        }
                    }
                    
                    if ($desconto_fidelidade > 0) :
                        $subtotal_com_desconto = $subtotal - $desconto_fidelidade;
                    ?>
                    <tr class="ttu">
                        <td colspan="2">DESCONTO FIDELIDADE</td>
                        <td align="right">-R$<?= number_format($desconto_fidelidade, 2, ',', '.') ?></td>
                    </tr>
                    <tr class="ttu">
                        <td colspan="2"><b>SUB-TOTAL COM DESCONTO</b></td>
                        <td align="right"><b>R$<?= number_format($subtotal_com_desconto, 2, ',', '.') ?></b></td>
                    </tr>
                    <?php endif; ?>
                    <?php
                    $dadosCupom = (new cupomModel)->get_desconto_cupom($data['pedido']->pedido_id);

                    if (!empty($dadosCupom)) {
                        // Calcular valor do desconto em reais
                        if ($dadosCupom->cupom_tipo == '1') {
                            // Desconto fixo
                            $desconto_valor = (float)$dadosCupom->cupom_valor;
                            $desconto_texto = 'R$' . Currency::moeda($desconto_valor);
                        } else {
                            // Desconto percentual - calcular valor real
                            $desconto_valor = ($subtotal * (float)$dadosCupom->cupom_percent) / 100;
                            $desconto_texto = $dadosCupom->cupom_percent . '% (R$' . Currency::moeda($desconto_valor) . ')';
                        }
                    ?>
                        <tr class="ttu">
                            <td colspan="2">DESCONTO</td>
                            <td align="right"><?= $desconto_texto ?></td>
                        </tr>
                    <?php } ?>
                    <tr class="ttu">
                        <td colspan="2">TAXA DE ENTREGA</td>
                        <td align="right">R$<?= Currency::moeda($data['pedido']->pedido_entrega) ?></td>
                    </tr>
                    <?php                 
                        if ($data['pedido']->pedido_taxa_cartao != '' && $data['pedido']->pedido_taxa_cartao != '0.00' && $data['pedido']->pedido_taxa_cartao > 0) {
                    ?>
                            <tr class="ttu">
                                <td colspan="2">TAXA CARTAO</td>
                                <td align="right">R$ <?=number_format($data['pedido']->pedido_taxa_cartao,2,',','.')?></td>
                            </tr>
                        <?php } ?>
                    <tr class="ttu">
                        <td colspan="2"><b>TOTAL A PAGAR</b></td>
                        <td align="right"><b>R$<?= Currency::moeda($data['pedido']->pedido_total); ?></b></td>
                    </tr>
                    <?php if($data['pedido']->pedido_troco != '' && $data['pedido']->pedido_troco != '0.00' && $data['pedido']->pedido_troco > 0){?>
                    <tr class="ttu">
                        <td colspan="2"><b>TROCO</b></td>
                        <td align="right"><b>R$<?= Currency::moeda($data['pedido']->pedido_troco); ?></b></td>
                    </tr>
                    <?php } ?>
                    <tr class="sup ttu p--0">
                        <td colspan="3">
                            <b>PAGAMENTO</b>
                        </td>
                    </tr>
                    <?php if (!empty($data['pedido']->pedido_obs_pagto_2) && !empty($data['pedido']->pedido_valor_pagto_2)) : ?>
                        <!-- Dual payment methods -->
                        <tr class="ttu">
                            <td colspan="2"><?= ($data['pedido']->pedido_obs_pagto) ?></td>
                            <td align="right">R$<?= Currency::moeda($data['pedido']->pedido_valor_pagto) ?></td>
                        </tr>
                        <tr class="ttu">
                            <td colspan="2"><?= ($data['pedido']->pedido_obs_pagto_2) ?></td>
                            <td align="right">R$<?= Currency::moeda($data['pedido']->pedido_valor_pagto_2) ?></td>
                        </tr>
                    <?php else : ?>
                        <!-- Single payment method -->
                        <tr class="ttu">
                            <td colspan="3"><?= ($data['pedido']->pedido_obs_pagto) ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr class="sup ttu p--0">
                        <td colspan="3" style="text-align: center;">***OBRIGADO E BOM APETITE***</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <script>
        // Solução robusta com múltiplas estratégias
        var impressaoRealizada = false;
        
        // Estratégia 1: Detecta quando o diálogo de impressão é aberto
        window.onbeforeprint = function() {
            console.log('Iniciando impressão...');
            impressaoRealizada = true;
        };
        
        // Estratégia 2: Detecta quando o diálogo de impressão é fechado
        window.onafterprint = function() {
            console.log('Impressão concluída ou cancelada');
            setTimeout(function() {
                window.close();
            }, 500);
        };
        
        // Inicia a impressão automaticamente
        setTimeout(function() {
            window.print();
            
            // Estratégia 3: Fallback - Se o navegador não suportar onafterprint
            setTimeout(function() {
                if (!window.closed) {
                    window.close();
                }
            }, 3000);
        }, 300);
        
        // Estratégia 4: Fecha quando a janela perde o foco (usuário clicou em imprimir/cancelar)
        window.onblur = function() {
            if (impressaoRealizada) {
                setTimeout(function() {
                    window.close();
                }, 1000);
            }
        };
    </script>
</body>

</html>
