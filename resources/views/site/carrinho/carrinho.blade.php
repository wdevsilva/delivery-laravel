<?php @session_start(); ?>
<?php $baseUri = Http::base(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= (isset($data['config']->config_nome)) ? $data['config']->config_nome : ''; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/app.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/bootstrap/3.3.5/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/modal.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/jquery.select2/dist/css/select2.min.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/jquery.select2/dist/css/select2-bootstrap.min.css" />
    <link rel="icon" type="image/png" href="<?php echo $baseUri; ?>/assets/logo/<?= $_SESSION['base_delivery'] ?>/<?php echo (isset($data['config'])) ? $data['config']->config_foto : ''; ?>" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/view/site/app-css/card.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/css/tema.php?<?php echo $data['config']->config_colors; ?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/view/site/app-css/card.css" />
    <link href="<?php echo $baseUri; ?>/assets/css/main.css?v=<?= filemtime(__DIR__ . '/../../assets/css/main.css') ?>" rel="stylesheet" />
    <link href="<?php echo $baseUri; ?>/assets/css/x0popup-master/dist/x0popup.min.css" rel="stylesheet">
    <script src="<?php echo $baseUri; ?>/assets/css/x0popup-master/dist/x0popup.min.js"></script>
</head>
<body>
    <div class="container" id="home-content">
        <?php require_once 'menu.php'; ?>
        <div class="<?= (!$isMobile) ? 'col-md-offset-2 col-md-8' : ''; ?>">
            <form action="<?php echo $baseUri; ?>/pedido/confirmar/" method="post" id="form-pedido" onsubmit="return validaPagamento()">
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
                        <?php echo isset($data['config']->config_horario) ? $data['config']->config_horario : ''; ?>
                    </h3>
                <?php else : ?>
                    <?php
                    // IMPORTANTE: Carrinho::get_total() JÁ retorna valor COM desconto do cupom aplicado
                    // Não devemos aplicar desconto novamente aqui
                    $total_com_desconto = Currency::moeda(Carrinho::get_total(), 'double');

                    // Garantir que é numérico
                    if (!is_numeric($total_com_desconto)) {
                        $total_com_desconto = (float)str_replace(',', '.', str_replace('.', '', $total_com_desconto));
                    }
                    $total_com_desconto = (float)$total_com_desconto;

                    // Para exibição do desconto, calcular sobre o total ORIGINAL (sem desconto)
                    $total_original = 0;
                    foreach (Carrinho::get_all() as $cart) {
                        $total_original += (float)$cart->total * $cart->qtde;
                    }

                    // Calcular descontos PARA EXIBIÇÃO (não para cálculo, pois já foi aplicado)
                    $desconto_cupom_inicial = 0;
                    $desconto_pontos_inicial = 0;

                    if (isset($_SESSION['__CUPOM__'])) {
                        // ⚠️ VALIDAR VALOR MÍNIMO DO CUPOM
                        $cupom = $_SESSION['__CUPOM__'];
                        $valor_minimo_cupom = isset($cupom->cupom_valor_minimo) ? (float)$cupom->cupom_valor_minimo : 0;

                        if ($valor_minimo_cupom > 0 && $total_original < $valor_minimo_cupom) {
                            // Valor do carrinho caiu abaixo do mínimo - REMOVER CUPOM
                            unset($_SESSION['__CUPOM__']);
                            echo '<script>
                                if (typeof x0p === "function") {
                                    x0p("Atenção!", "Cupom removido! O valor do carrinho está abaixo do mínimo de R$ ' . number_format($valor_minimo_cupom, 2, ',', '.') . '", "warning", false);
                                } else {
                                    alert("Cupom removido! Valor mínimo: R$ ' . number_format($valor_minimo_cupom, 2, ',', '.') . '");
                                }
                                setTimeout(() => window.location.reload(), 2000);
                            </script>';
                            // Recalcular total sem cupom
                            $total_com_desconto = $total_original;
                        } else {
                            // Cupom válido, calcular desconto APENAS PARA EXIBIÇÃO
                            if ($cupom->cupom_tipo == 1) {
                                $desconto_cupom_inicial = (float)$cupom->cupom_valor;
                            } else {
                                $desconto_cupom_inicial = ((float)$total_original * (float)$cupom->cupom_percent) / 100;
                                // Verificar desconto máximo
                                if (isset($cupom->cupom_desconto_maximo) && $cupom->cupom_desconto_maximo > 0) {
                                    if ($desconto_cupom_inicial > $cupom->cupom_desconto_maximo) {
                                        $desconto_cupom_inicial = (float)$cupom->cupom_desconto_maximo;
                                    }
                                }
                            }
                        }
                    }

                    if (isset($_SESSION['__DESCONTO_PONTOS__'])) {
                        $desconto_pontos_inicial = (float)$_SESSION['__DESCONTO_PONTOS__'];
                    }

                    // Usar o total original para exibição na seção de cupom
                    $total = $total_original;

                    // ⚠️ VERIFICAR DESCONTO DE FREQUÊNCIA
                    if (isset($_SESSION['__CLIENTE__ID__'])) {
                        $fidelidadeModel = new fidelidadeModel();
                        $config_fidelidade = $fidelidadeModel->get_config();

                        // Verificar se o programa é de frequência
                        if (isset($config_fidelidade->config_fidelidade_tipo) && $config_fidelidade->config_fidelidade_tipo === 'frequencia') {
                            $status_frequencia = $fidelidadeModel->verificar_desconto_frequencia($_SESSION['__CLIENTE__ID__']);

                            // Armazenar na sessão para usar no carrinho e no checkout
                            $_SESSION['__FIDELIDADE__STATUS__'] = $status_frequencia;
                        }
                    }
                    ?>
                    <input type="hidden" name="pedido_total" id="pedido_total" value="<?= number_format($total_com_desconto, 2, '.', ''); ?>" />
                    <?php
                    if (Carrinho::isfull()) : ?>
                        <section id="pedido-itens">
                            <h4><strong>Itens do pedido</strong></h4>
                            <?php
                            $total_itens = 0;
                            foreach (Carrinho::get_all() as $cart) :
                                // Verifica se config_taxa_categorias não é nulo antes de fazer explode
                                $taxa_categorias = !empty($data['config']->config_taxa_categorias) ? explode(',', $data['config']->config_taxa_categorias) : [];
                                if (in_array($cart->categoria_id ?? 0, $taxa_categorias)) {
                                    $total_itens += $cart->qtde;
                                }
                            ?>
                                <div class="row">
                                    <div class="ol-md-5 col-xs-7">
                                        <p class="text-capitalize">
                                            <span id="sp-qt-<?= $cart->item_hash ?>"><?= ($cart->qtde <= 9) ? "0$cart->qtde" : $cart->qtde ?></span>
                                            <small class="text-muted">x</small>
                                            <?= mb_strtolower($cart->categoria_nome ?? '') ?>
                                            <?php if (strrpos($cart->extra, '1/2') === false) { ?>
                                                - <?= mb_strtolower($cart->item_nome) ?>
                                            <?php } ?>
                                            <br>
                                            <small class="text-muted">
                                                <?php
                                                if (strlen($cart->extra) >= 0) : ?>
                                                    <?= mb_strtolower($cart->item_obs ?? '') ?>
                                                <?php endif; ?>
                                                <?= mb_strtolower($cart->extra) ?>
                                            </small>
                                        </p>
                                    </div>
                                    <div class="col-md-2 col-xs-5">
                                        R$ <?= Currency::moeda($cart->item_preco * $cart->qtde) ?>
                                        <?php if($cart->extra_preco){ ?>
                                            <br>
                                            Total Item R$ <?= number_format(floatval($cart->total) * $cart->qtde, 2,',','.') ?>
                                        <?php }?>
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
                                <?php if ($_SESSION['base_delivery'] == 'dgustsalgados') { ?>
                                    <h5><b>Horário desejado?</b></h5>
                                    <textarea class="form-control" name="pedido_obs" id="pedido_obs" placeholder="Ex: entregar as 19h ou vour retiar as 18h etc..." rows="2"><?= (isset($_SESSION['__OBS__'])) ? $_SESSION['__OBS__'] : ''; ?></textarea>
                                <?php } else { ?>
                                    <h5><b>Alguma observação?</b></h5>
                                    <textarea class="form-control" name="pedido_obs" id="pedido_obs" placeholder="Ex: tirar cebola, maionese à parte, etc..." rows="2"><?= (isset($_SESSION['__OBS__'])) ? $_SESSION['__OBS__'] : ''; ?></textarea>
                                <?php } ?>
                            </div>
                            <hr>
                        </section>
                        <section id="pedido-enderecos">
                            <h5><strong>Onde deseja receber seu pedido?</strong></h5>
                            <select class="form-control" name="pedido_local" id="pedido_local">
                                <option value="" data-cep="" data-bairro="" selected>Selecione uma opção...</option>
                                <?php if ($data['config']->config_retirada == 1) : ?>
                                    <option value="0" data-cep="0">Retirar no Local</option>
                                <?php endif;
                                if($data['config']->config_entrega_pedido == 1){
                                ?>
                                    <?php foreach ($data['endereco'] as $end) : ?>
                                        <option value="<?= $end->endereco_id ?>" data-bairro="<?= $end->endereco_bairro_id ?>" data-cep="<?= $end->endereco_cep ?>" data-tempo="<?= $end->bairro_tempo ?>">
                                            <?= ucfirst($end->endereco_nome) ?> em
                                            <?= $end->endereco_bairro ?> (<?= $end->bairro_tempo ?>)
                                        </option>
                                    <?php endforeach; ?>
                                    <option value="-1" data-cep="0">Cadastrar novo endereço</option>
                                <?php } ?>
                            </select>
                            <hr>
                        </section>
                        <section id="pedido-cupom">
                            <?php
                            if (!isset($_SESSION['__CUPOM__'])) :
                            ?>
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
                            <?php else :

                                $dadosCupom = (new cupomModel)->get_by_numero_cupom($_SESSION['__CUPOM__']->cupom_id, $_SESSION['__CLIENTE__ID__']);

                                if (!empty($dadosCupom)) {
                                    unset($_SESSION['__CUPOM__']);
                                    header("Refresh:0");
                                    exit;
                                }

                                // Calcular desconto visual
                                $cupom_obj = $_SESSION['__CUPOM__'];
                                $desconto_visual = 0;
                                if ($cupom_obj->cupom_tipo == 1) {
                                    $desconto_visual = (float)$cupom_obj->cupom_valor;
                                    $desconto_texto = 'R$ ' . number_format($desconto_visual, 2, ',', '.');
                                } else {
                                    // Calcular percentual sobre o total
                                    $total_para_desconto = $total; // Já calculado no início
                                    $desconto_visual = ($total_para_desconto * (float)$cupom_obj->cupom_percent) / 100;

                                    // Verificar desconto máximo
                                    if (isset($cupom_obj->cupom_desconto_maximo) && $cupom_obj->cupom_desconto_maximo > 0) {
                                        if ($desconto_visual > $cupom_obj->cupom_desconto_maximo) {
                                            $desconto_visual = (float)$cupom_obj->cupom_desconto_maximo;
                                        }
                                    }

                                    $desconto_texto = $cupom_obj->cupom_percent . '% (R$ ' . number_format($desconto_visual, 2, ',', '.') . ')';
                                }
                            ?>
                                <div style="background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%); padding: 15px; border-radius: 8px; color: white; text-align: center; margin-bottom: 10px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <div style="flex: 1;">
                                            <i class="fa fa-ticket" style="font-size: 24px;"></i>
                                        </div>
                                        <div style="flex: 3; text-align: left;">
                                            <strong style="font-size: 16px;">CUPOM: <?= $cupom_obj->cupom_nome ?></strong><br>
                                            <small style="opacity: 0.9;">Desconto: <?= $desconto_texto ?></small>
                                        </div>
                                        <div style="flex: 1;">
                                            <button type="button" onclick="remove_cupom()" class="btn btn-sm" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid white; padding: 5px 10px; font-size: 12px;">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <hr>
                        </section>

                        <!-- 🎁 SEÇÃO DE PONTOS DE FIDELIDADE -->
                        <?php
                        // Verificar se programa de fidelidade está ativo
                        $fidelidade_ativo = isset($data['config']->config_fidelidade_ativo) && $data['config']->config_fidelidade_ativo == 1;

                        if ($fidelidade_ativo && isset($_SESSION['__CLIENTE__ID__'])) {
                            // Buscar saldo de pontos do cliente
                            $fidelidadeModel = new fidelidadeModel();
                            $saldo_data = $fidelidadeModel->get_saldo_cliente($_SESSION['__CLIENTE__ID__']);
                            $pontos_disponiveis = isset($saldo_data['saldo_atual']) ? (int)$saldo_data['saldo_atual'] : 0;

                            // Buscar configurações de resgate
                            $pontos_minimo = isset($data['config']->config_pontos_para_resgatar) ? (int)$data['config']->config_pontos_para_resgatar : 100;
                            $valor_resgate = isset($data['config']->config_valor_resgate_pontos) ? (float)$data['config']->config_valor_resgate_pontos : 10.00;
                            $max_desconto = isset($data['config']->config_fidelidade_max_desconto) ? (float)$data['config']->config_fidelidade_max_desconto : 0.00;
                            $tipo_programa = isset($data['config']->config_fidelidade_tipo) ? $data['config']->config_fidelidade_tipo : 'pontos';

                            // Verificar se já está usando pontos
                            $usando_pontos = isset($_SESSION['__PONTOS_USADOS__']) && $_SESSION['__PONTOS_USADOS__'] > 0;

                            if ($pontos_disponiveis >= $pontos_minimo) {
                        ?>
                        <section id="pedido-pontos">
                            <?php if (!$usando_pontos) : ?>
                                <div class="alert alert-info" style="margin-bottom: 15px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <div>
                                            <strong>🎁 Você tem <?= $pontos_disponiveis ?> pontos!</strong><br>
                                            <small>💵 <?= $pontos_minimo ?> pontos = R$ <?= number_format($valor_resgate, 2, ',', '.') ?> de desconto</small>
                                        </div>
                                        <button type="button" onclick="abrirModalPontos()" class="btn btn-success btn-sm">
                                            <i class="fa fa-star"></i> Usar Pontos
                                        </button>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="alert alert-success" style="margin-bottom: 15px;">
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <div>
                                            <strong><i class="fa fa-check-circle"></i> Usando <?= $_SESSION['__PONTOS_USADOS__'] ?> pontos</strong><br>
                                            <small>Desconto: R$ <?= number_format($_SESSION['__DESCONTO_PONTOS__'], 2, ',', '.') ?></small>
                                        </div>
                                        <button type="button" onclick="removerPontos()" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> Remover
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <hr>
                        </section>
                        <?php
                            }
                        }
                        ?>

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
                            <?php
                            // Usar as mesmas variáveis calculadas no início
                            // $desconto_cupom_inicial e $desconto_pontos_inicial já foram calculados
                            $desconto_total = $desconto_cupom_inicial + $desconto_pontos_inicial;
                            ?>

                            <?php if ($desconto_total > 0) : ?>
                                <p class="text-right">
                                    <strong>Descontos:</strong><br>
                                    <?php if ($desconto_cupom_inicial > 0) : ?>
                                        <small>Cupom: - R$ <?= number_format($desconto_cupom_inicial, 2, ',', '.') ?></small><br>
                                    <?php endif; ?>
                                    <?php if ($desconto_pontos_inicial > 0) : ?>
                                        <small>🎁 Pontos: - R$ <?= number_format($desconto_pontos_inicial, 2, ',', '.') ?></small><br>
                                    <?php endif; ?>
                                </p>
                            <?php endif; ?>

                            <!-- Desconto de Fidelidade: A cada X pedidos, ganhe Y% de desconto -->
                            <?php if (isset($_SESSION['__FIDELIDADE__STATUS__']) && $_SESSION['__FIDELIDADE__STATUS__']['tem_desconto']): ?>
                                <?php
                                    $percentual_fidelidade = isset($_SESSION['__FIDELIDADE__STATUS__']['percentual_desconto']) ? $_SESSION['__FIDELIDADE__STATUS__']['percentual_desconto'] : 10;
                                ?>
                                <p class="text-right desconto-fidelidade-linha" style="color: #11998e; animation: pulse 1.5s ease-in-out infinite;">
                                    <strong>🎉 Desconto Fidelidade (<?= $percentual_fidelidade ?>%):</strong><br>
                                    <small id="desconto-fidelidade-valor" style="font-size: 16px; font-weight: bold;">- R$ 0,00</small>
                                </p>
                                <input type="hidden" id="pedido_desconto_fidelidade" name="pedido_desconto_fidelidade" value="0" />

                                <style>
                                @keyframes pulse {
                                    0%, 100% { transform: scale(1); }
                                    50% { transform: scale(1.05); }
                                }
                                .desconto-fidelidade-linha {
                                    background: linear-gradient(90deg, rgba(17,153,142,0.1) 0%, rgba(17,153,142,0.05) 100%);
                                    padding: 10px;
                                    border-radius: 5px;
                                    margin: 10px 0;
                                    border-left: 4px solid #11998e;
                                }
                                </style>
                            <?php endif; ?>

                            <h3 class="text-right">
                                <small class="cartaotx" style="display: none;">Taxa cartão <span id="taxa-cartao">R$ 0,00</span></small><br>
                                <small>Taxa de entrega <span id="taxa-faixa">R$ 0,00</span></small><br>
                                <?php
                                // Usar total já calculado no início
                                $total_final = $total_com_desconto;
                                ?>
                                Total
                                <span id="pedido-total">R$ <?= number_format($total_final, 2, ',', '.'); ?></span>
                            </h3>
                            <div class="hidden-xs row"></div>
                        </section>
                        <hr>
                        <div class="form-group hide" id="forma-pagamento-troco-bandeira">
                            <label id="troco-bandeira-label">Troco para quanto?</label>
                            <input type="text" id="troco-bandeira" name="troco-bandeira" class="form-control" />
                        </div>
                        <input type="hidden" id="pedido_id_pagto" name="pedido_id_pagto" />
                        <input type="hidden" id="pedido_obs_pagto" name="pedido_obs_pagto" />
                        <input type="hidden" id="pedido_troco" name="pedido_troco" />
                        <input type="hidden" id="pedido_bairro" name="pedido_bairro" class="pedido_bairro" />
                        <input type="hidden" id="pedido_taxa_cartao" name="pedido_taxa_cartao" />
                        <input type="hidden" id="pedido_entrega_prazo" name="pedido_entrega_prazo" />
                        <br>
                        <div class="divi-btn-finaliza">
                            <button type="submit" disabled class="btn btn-block btn-success text-uppercase" id="btn-pedido-concluir" <?php if (Carrinho::get_total() <= 0) : ?> disabled<?php endif; ?>>
                                <i class="fa fa-check-circle-o"></i>
                                Confirmar pedido
                            </button>
                            <br><br>
                        </div>
                    <?php else : ?>
                        <div class="text-center">
                            <br><br><br>
                            <img src="<?php echo $baseUri; ?>/midias/assets/thumb.php?zcx=3&w=218&h=178&src=img/icon-triste.png" alt="...">
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
            <?php if (isset($data['pagamento']) && is_object($data['pagamento']) && $data['pagamento']->pagamento_status == 1 && isset($data['url_js'])) : ?>
                <?php require_once 'pagseguro-checkout.php'; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="container"><a id="link-footer" name="link-footer"></a></div>
    <?php require_once 'footer.php'; ?>
    <?php require 'side-carrinho.php'; ?>
    <?php require_once 'footer-core-js.php'; ?>
    <?php if (isset($data['pagamento']) && is_object($data['pagamento']) && $data['pagamento']->pagamento_status == 1 && isset($data['url_js'])) : ?>
        <script type="text/javascript" src="<?= $data['url_js'] ?>"></script>
        <script>
            var pagseguro_id = "<?= $data['url_ssid'] ?>";
        </script>
    <?php endif; ?>
    <script type="text/javascript">
        var baseUri = '<?php echo $baseUri; ?>';
        var BASE_URI = '<?php echo $baseUri; ?>'; // Para compatibilidade com cupom-auto-monitor.js
        // Usar total com descontos aplicados
        var totalCompra = '<?= number_format($total_com_desconto, 2, '.', '') ?>';
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
    <script type="text/javascript" src="<?php echo $baseUri; ?>/assets/vendor/jquery.maskedinput/jquery.mask.js"></script>
    <script>
        // Converte o JSON gerado no PHP para uma variável JS
        const faixasCartao = <?php echo json_encode($data['faixasCartao']); ?>;
        const configTaxaCartao = <?php echo json_encode($data['config']); ?>;

        // Taxa por categoria - disponibilizar para o JavaScript
        <?php if (isset($data['config']->config_taxa_tipo) && $data['config']->config_taxa_tipo === 'taxa_por_categoria'): ?>
            var taxasPorCategoria = <?php
                $taxaCategoriaModel = new taxaCategoriaModel();
                echo json_encode($taxaCategoriaModel->get_taxas_para_js());
            ?>;

            // Dados do carrinho por categoria para cálculo de taxa
            var carrinhoCategoria = <?php
                $categorias_carrinho = [];
                foreach (Carrinho::get_all() as $cart) {
                    if (!isset($categorias_carrinho[$cart->categoria_id])) {
                        $categorias_carrinho[$cart->categoria_id] = 0;
                    }
                    $categorias_carrinho[$cart->categoria_id] += $cart->qtde;
                }
                echo json_encode($categorias_carrinho);
            ?>;
        <?php else: ?>
            var taxasPorCategoria = {};
            var carrinhoCategoria = {};
        <?php endif; ?>

        empresa = "<?= $_SESSION['base_delivery'] ?>";

        // ===== DESCONTO DE FIDELIDADE: A cada X pedidos, ganhe Y% de desconto =====
        <?php if (isset($_SESSION['__FIDELIDADE__STATUS__']) && $_SESSION['__FIDELIDADE__STATUS__']['tem_desconto']): ?>
        var temDescontoFidelidade = true;
        var percentualDescontoFidelidade = <?= $_SESSION['__FIDELIDADE__STATUS__']['percentual_desconto'] ?? 10 ?>;

        // ✅ CALCULAR E APLICAR DESCONTO IMEDIATAMENTE
        $(document).ready(function() {
            setTimeout(function() {
                if (typeof temDescontoFidelidade !== 'undefined' && temDescontoFidelidade === true) {
                    let totalCompraAtual = parseFloat($('#pedido_total').val()) || parseFloat(totalCompra) || 0;

                    let descontoFidelidade = totalCompraAtual * (percentualDescontoFidelidade / 100);
                    descontoFidelidade = Math.round((descontoFidelidade + Number.EPSILON) * 100) / 100;

                    // Atualizar display do desconto
                    if ($('#desconto-fidelidade-valor').length) {
                        $('#desconto-fidelidade-valor').html('- R$ ' + descontoFidelidade.toFixed(2).replace('.', ','));
                        $('.desconto-fidelidade-linha').show();
                    }

                    // Guardar valor do desconto
                    if ($('#pedido_desconto_fidelidade').length) {
                        $('#pedido_desconto_fidelidade').val(descontoFidelidade.toFixed(2));
                    }

                    // ✅ RECALCULAR O TOTAL SUBTRAINDO O DESCONTO
                    let totalAtual = parseFloat($('#pedido_total').val()) || 0;
                    let novoTotal = totalAtual - descontoFidelidade;

                    // Atualizar campo hidden
                    $('#pedido_total').val(novoTotal.toFixed(2));

                    // Atualizar exibição do total
                    $('#pedido-total').html('R$ ' + novoTotal.toFixed(2).replace('.', ','));
                }
            }, 1000);
        });
        <?php else: ?>
        var temDescontoFidelidade = false;
        var percentualDescontoFidelidade = 0;
        <?php endif; ?>
    </script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/carrinho.js"></script>
    <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/cupom-auto-monitor.js"></script>
    <script type="text/javascript">
        // Call rebind_reload after carrinho.js is loaded
        rebind_reload();

        // 🎁 FUNÇÕES DE PONTOS DE FIDELIDADE
        function abrirModalPontos() {
            // Dados do PHP
            const pontosDisponiveis = <?= isset($pontos_disponiveis) ? $pontos_disponiveis : 0 ?>;
            const pontosMinimo = <?= isset($pontos_minimo) ? $pontos_minimo : 100 ?>;
            const valorResgate = <?= isset($valor_resgate) ? $valor_resgate : 10.00 ?>;
            const maxDesconto = <?= isset($max_desconto) ? $max_desconto : 0.00 ?>;
            const tipoPrograma = '<?= isset($tipo_programa) ? $tipo_programa : "pontos" ?>';
            const totalPedido = parseFloat($('#pedido_total').val());

            // Calcular quantos pontos pode usar
            let maxPontosDisponiveis;
            if (tipoPrograma === 'ambos' && maxDesconto > 0) {
                // Apenas para "Pontos + Cashback" tem limite
                const maxPontosPorDesconto = Math.floor((maxDesconto / valorResgate) * pontosMinimo);
                maxPontosDisponiveis = Math.min(pontosDisponiveis, maxPontosPorDesconto);
            } else {
                // "Apenas Pontos" pode usar todos os pontos disponíveis
                maxPontosDisponiveis = pontosDisponiveis;
            }

            // Criar modal
            const modalHtml = `
                <div class="modal fade" id="modalPontos" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                <h4 class="modal-title"><i class="fa fa-star"></i> Resgatar Pontos</h4>
                            </div>
                            <div class="modal-body">
                                <p><strong>Seus pontos:</strong> ${pontosDisponiveis} pontos</p>
                                <p><small>💵 ${pontosMinimo} pontos = R$ ${valorResgate.toFixed(2).replace('.', ',')}</small></p>
                                ${tipoPrograma === 'ambos' && maxDesconto > 0 ? `<p><small>⚠️ Desconto máximo: R$ ${maxDesconto.toFixed(2).replace('.', ',')}</small></p>` : ''}
                                <hr>
                                <div class="form-group">
                                    <label>Quantos pontos deseja usar?</label>
                                    <input type="number"
                                           id="pontosResgatar"
                                           class="form-control"
                                           min="${pontosMinimo}"
                                           max="${maxPontosDisponiveis}"
                                           step="${pontosMinimo}"
                                           value="${pontosMinimo}"
                                           oninput="calcularDescontoPontos()">
                                    <small class="text-muted">
                                        ⚠️ Mínimo: ${pontosMinimo} | Máximo: ${maxPontosDisponiveis}<br>
                                        💡 Use múltiplos de ${pontosMinimo} (ex: ${pontosMinimo}, ${pontosMinimo*2}, etc)
                                    </small>
                                    <div id="alertaPontos" class="alert alert-danger" style="display:none; margin-top:10px;"></div>
                                </div>
                                <div class="alert alert-success">
                                    <strong>Desconto:</strong> <span id="descontoCalculado">R$ ${valorResgate.toFixed(2).replace('.', ',')}</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-success" onclick="aplicarPontos()">Aplicar Pontos</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            // Remover modal antigo se existir
            $('#modalPontos').remove();

            // Adicionar e abrir modal
            $('body').append(modalHtml);
            $('#modalPontos').modal('show');
        }

        function calcularDescontoPontos() {
            const pontos = parseInt($('#pontosResgatar').val()) || 0;
            const pontosMinimo = <?= isset($pontos_minimo) ? $pontos_minimo : 100 ?>;
            const valorResgate = <?= isset($valor_resgate) ? $valor_resgate : 10.00 ?>;
            const maxDesconto = <?= isset($max_desconto) ? $max_desconto : 0.00 ?>;
            const tipoPrograma = '<?= isset($tipo_programa) ? $tipo_programa : "pontos" ?>';
            const pontosDisponiveis = <?= isset($pontos_disponiveis) ? $pontos_disponiveis : 0 ?>;

            // Calcular máximo de pontos baseado no tipo
            let maxPontosDisponiveis;
            if (tipoPrograma === 'ambos' && maxDesconto > 0) {
                const maxPontosPorDesconto = Math.floor((maxDesconto / valorResgate) * pontosMinimo);
                maxPontosDisponiveis = Math.min(pontosDisponiveis, maxPontosPorDesconto);
            } else {
                maxPontosDisponiveis = pontosDisponiveis;
            }

            const desconto = (pontos / pontosMinimo) * valorResgate;
            $('#descontoCalculado').text('R$ ' + desconto.toFixed(2).replace('.', ','));

            // Validar e mostrar alertas
            const $alerta = $('#alertaPontos');

            if (pontos < pontosMinimo) {
                $alerta.html(`⚠️ Mínimo de ${pontosMinimo} pontos!`).show();
            } else if (pontos > maxPontosDisponiveis) {
                $alerta.html(`⚠️ Máximo de ${maxPontosDisponiveis} pontos!`).show();
            } else if (pontos % pontosMinimo !== 0) {
                $alerta.html(`⚠️ Use múltiplos de ${pontosMinimo} pontos!`).show();
            } else {
                $alerta.hide();
            }
        }

        function aplicarPontos() {
            const pontos = parseInt($('#pontosResgatar').val());
            const pontosMinimo = <?= isset($pontos_minimo) ? $pontos_minimo : 100 ?>;
            const maxDesconto = <?= isset($max_desconto) ? $max_desconto : 0.00 ?>;
            const valorResgate = <?= isset($valor_resgate) ? $valor_resgate : 10.00 ?>;
            const tipoPrograma = '<?= isset($tipo_programa) ? $tipo_programa : "pontos" ?>';
            const pontosDisponiveis = <?= isset($pontos_disponiveis) ? $pontos_disponiveis : 0 ?>;

            // Calcular máximo baseado no tipo
            let maxPontosDisponiveis;
            if (tipoPrograma === 'ambos' && maxDesconto > 0) {
                const maxPontosPorDesconto = Math.floor((maxDesconto / valorResgate) * pontosMinimo);
                maxPontosDisponiveis = Math.min(pontosDisponiveis, maxPontosPorDesconto);
            } else {
                maxPontosDisponiveis = pontosDisponiveis;
            }

            // Validar pontos
            if (pontos < pontosMinimo) {
                alert(`Mínimo de ${pontosMinimo} pontos!`);
                return;
            }

            if (pontos > maxPontosDisponiveis) {
                alert(`Máximo de ${maxPontosDisponiveis} pontos!`);
                return;
            }

            // Validar se é múltiplo do mínimo
            if (pontos % pontosMinimo !== 0) {
                alert(`Use múltiplos de ${pontosMinimo} pontos!`);
                return;
            }

            $.post(baseUri + '/carrinho/aplicar_pontos/', {
                pontos: pontos
            }, function(response) {
                if (response.success) {
                    $('#modalPontos').modal('hide');
                    location.reload();
                } else {
                    alert(response.message || 'Erro ao aplicar pontos');
                }
            }, 'json').fail(function(xhr, status, error) {
                console.error('Erro AJAX:', xhr.responseText);
                alert('Erro ao processar solicitação: ' + (xhr.responseJSON?.message || error));
            });
        }

        function removerPontos() {
            if (confirm('Deseja remover os pontos do pedido?')) {
                $.post(baseUri + '/carrinho/remover_pontos/', {}, function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.message || 'Erro ao remover pontos');
                    }
                }, 'json').fail(function() {
                    alert('Erro ao processar solicitação');
                });
            }
        }
    </script>
    <?php if (isset($data['pagamento']) && is_object($data['pagamento']) && $data['pagamento']->pagamento_status == 1) : ?>
        <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/card.js"></script>
        <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/pagseguro-checkout.js"></script>
        <script type="text/javascript" src="<?php echo $baseUri; ?>/view/site/app-js/pagseguro.js"></script>
    <?php endif; ?>
</body>

</html>
