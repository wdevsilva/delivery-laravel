@php
    $carrinho = session('__APP__CART__', []);
    $isMobile = request()->header('User-Agent') && strpos(request()->header('User-Agent'), 'Mobile') !== false;
@endphp

@if(!empty($carrinho))
    <div class="panel-body" style="margin-top: 0px!important; padding-top: 0px!important">
        <div id="painel-carrinho">
            <?php
            //var_dump(Carrinho::get_all());
            foreach (Carrinho::get_all() as $cart) { ?>
                <div class="item item-carrinho" id="list-item-<?= $cart->item_hash ?>" data-categoria-id="<?= $cart->categoria_id ?>">
                    <div class="row">
                        <div class="col-md-5 col-xs-7">
                            <div class="row text-left">
                                <a style="padding: 0;" title="-1" class="btn btn-light" id="controleAddMore<?= $cart->item_id ?>" data-toggle="tooltip" data-estoque="<?= $cart->item_estoque ?>" data-id="<?= $cart->item_id ?>" data-hash="<?= $cart->item_hash ?>">
                                    <i class="fa fa-minus-circle btn-plus-minus fa-2x text-danger del-more" data-estoque="<?= $cart->item_estoque ?>" data-id="<?= $cart->item_id ?>" data-hash="<?= $cart->item_hash ?>"></i>
                                </a>&nbsp;
                                <span id="sp-qt-<?= $cart->item_hash ?>" class="item-qtde qtde-item"><?= ($cart->qtde <= 9) ? "0$cart->qtde" : $cart->qtde ?></span>
                                <a style="padding: 0;" title="+1" class="btn btn-light" id="controleAddDel<?= $cart->item_id ?>" data-toggle="tooltip" data-estoque="<?= $cart->item_estoque ?>" data-id="<?= $cart->item_id ?>" data-hash="<?= $cart->item_hash ?>">
                                    <i class="fa fa-plus-circle btn-plus-minus fa-2x text-success add-more" data-estoque="<?= $cart->item_estoque ?>" data-id="<?= $cart->item_id ?>" data-hash="<?= $cart->item_hash ?>"></i>
                                </a>
                                <span class="item-nome text-capitalize" style="padding-top: 2px">
                                    <?php if (!empty($cart->categoria_nome ?? '')) : ?>
                                        <?= $cart->categoria_nome ?>
                                    <?php else : ?>
                                        <?= $cart->item_nome ?>
                                    <?php endif; ?>
                                    <?php
                                    // Se for mobile, mostra os extras (sabores, bordas, etc.)
                                    if ($isMobile == 1) {
                                        // Se tiver extras, mostra todos
                                        if (strlen($cart->extra) > 2) {
                                            // Parse e exibe extras formatados (preserva HTML como <b>Borda:</b>)
                                            $extraFormatted = substr($cart->extra, 0, -2);
                                            // Quebra por <br> para exibir cada linha
                                            $extraLines = preg_split('/<br\s*\/?>/', $extraFormatted);
                                            foreach($extraLines as $line) {
                                                $line = trim($line);
                                                if($line) {
                                                    echo '<br><small class="text-muted">' . $line . '</small>';
                                                }
                                            }
                                        } else { ?>
                                            <br>
                                            <?= ($cart->item_nome) ?>
                                            <?= mb_strtolower($cart->item_obs ?? '') ?>
                                    <?php }
                                    } ?>
                                    <small class="item-estoque-<?= $cart->item_hash ?> text-danger" style="padding-top: 0px;padding-left: 5px;"></small>
                                </span>
                            </div>
                        </div>
                        <?php if (strrpos($cart->extra, '1/2') === false) { ?>
                            <div class="col-md-5 hidden-xs">
                                <small class="text-muted"><?= ($cart->item_nome) ?></small>
                            </div>
                        <?php } ?>
                        <div class="col-md-5 hidden-xs">
                            <?php if (strlen($cart->extra) <= 0) : ?>
                                <small class="text-muted"><?= mb_strtolower($cart->item_obs ?? '') ?></small><br>
                            <?php else: ?>
                                <?php
                                    // Parse e exibe extras formatados (preserva HTML como <b>Borda:</b>)
                                    $extraFormatted = substr($cart->extra, 0, -2);
                                    // Quebra por <br> para exibir cada linha
                                    $extraLines = preg_split('/<br\s*\/?>/', $extraFormatted);
                                    foreach($extraLines as $line) {
                                        $line = trim($line);
                                        if($line) {
                                            // Permite HTML básico como <b> mas sanitiza o resto
                                            echo '<small class="text-muted">' . $line . '</small><br>';
                                        }
                                    }
                                ?>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-2 col-xs-5">
                            R$ <?= Currency::moeda($cart->item_preco * $cart->qtde) ?>
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                    </div>
                </div>
            <?php } ?>
            <?php
            Carrinho::check_promocao();
            ?>
        </div>

        <!-- 🥤 SUGESTÃO DE BEBIDAS NO MODAL -->
        <?php
        // Verificar se há bebida no carrinho
        $tem_bebida_modal = false;
        $categorias_bebida_modal = ['bebida', 'bebidas', 'drinks', 'sucos', 'refrigerante', 'refrigerantes'];

        foreach (Carrinho::get_all() as $cart_item) {
            $categoria_lower = mb_strtolower($cart_item->categoria_nome ?? '');
            foreach ($categorias_bebida_modal as $termo_bebida) {
                if (strpos($categoria_lower, $termo_bebida) !== false) {
                    $tem_bebida_modal = true;
                    break 2;
                }
            }
        }

        // Se NÃO tem bebida e ainda não foi dispensado nesta sessão
        $bebida_dispensada = isset($_SESSION['__BEBIDA_DISPENSADA__']) && $_SESSION['__BEBIDA_DISPENSADA__'] === true;

        if (!$tem_bebida_modal && !$bebida_dispensada) {
            // Buscar categoria de bebidas
            $categoriaModel = new categoriaModel();
            $todas_categorias = $categoriaModel->get_all();
            $categoria_bebida_id_modal = null;

            foreach ($todas_categorias as $cat) {
                $cat_lower = mb_strtolower($cat->categoria_nome);
                foreach ($categorias_bebida_modal as $termo) {
                    if (strpos($cat_lower, $termo) !== false) {
                        $categoria_bebida_id_modal = $cat->categoria_id;
                        break 2;
                    }
                }
            }

            // Se encontrou categoria de bebidas, buscar produtos
            if ($categoria_bebida_id_modal) {
                $itemModel = new itemModel();
                $bebidas_modal = $itemModel->get_by_categoria($categoria_bebida_id_modal, 10); // Buscar 10 para filtrar

                // Filtrar apenas bebidas com estoque disponível
                $bebidas_disponiveis = [];
                if ($bebidas_modal) {
                    foreach ($bebidas_modal as $bebida) {
                        if (isset($bebida->item_estoque) && $bebida->item_estoque > 0) {
                            $bebidas_disponiveis[] = $bebida;
                            if (count($bebidas_disponiveis) >= 3) break; // Apenas 3 bebidas
                        }
                    }
                }

                if (count($bebidas_disponiveis) > 0) {
        ?>
        <div id="sugestao-bebidas-modal" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 15px; border-radius: 10px; margin: 15px 0; position: relative;">
            <button onclick="dispensarBebidas()" style="position: absolute; top: 8px; right: 8px; background: rgba(255,255,255,0.3); border: none; color: white; width: 28px; height: 28px; border-radius: 50%; cursor: pointer; font-size: 18px; line-height: 1;" title="Não, obrigado">
                ×
            </button>
            <div style="color: white;">
                <h5 style="color: white; margin-top: 0; margin-bottom: 8px; font-size: 15px;">
                    <i class="fa fa-lightbulb-o"></i> <strong>Que tal uma bebida?</strong>
                </h5>
                <p style="font-size: 12px; margin-bottom: 12px; opacity: 0.9;">Complete seu pedido:</p>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <?php foreach ($bebidas_disponiveis as $bebida): ?>
                        <?php
                        $foto_bebida = !empty($bebida->item_foto)
                            ? "$baseUri/assets/item/$_SESSION[base_delivery]/$bebida->item_foto"
                            : "$baseUri/assets/img/no-image.jpg";
                        ?>
                        <div onclick="adicionarBebidaRapido(<?= $bebida->item_id ?>, '<?= addslashes($bebida->item_nome) ?>', '<?= addslashes($bebida->categoria_nome) ?>', <?= $bebida->categoria_id ?>, <?= $bebida->item_preco ?>, <?= $bebida->item_estoque ?>)"
                             style="background: rgba(255,255,255,0.95); border-radius: 8px; padding: 10px; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: transform 0.2s;"
                             onmouseover="this.style.transform='scale(1.02)'"
                             onmouseout="this.style.transform='scale(1)'">
                            <img src="<?= $foto_bebida ?>"
                                 alt="<?= $bebida->item_nome ?>"
                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; flex-shrink: 0;">
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: bold; font-size: 13px; color: #333; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <?= $bebida->item_nome ?>
                                </div>
                                <div style="color: #667eea; font-weight: bold; font-size: 14px;">
                                    R$ <?= Currency::moeda($bebida->item_preco) ?>
                                </div>
                            </div>
                            <i class="fa fa-plus-circle" style="color: #667eea; font-size: 24px; flex-shrink: 0;"></i>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <script>
        function adicionarBebidaRapido(itemId, itemNome, categoriaNome, categoriaId, itemPreco, itemEstoque) {
            // Dados do item com hash único
            var dados = {
                item_id: itemId,
                item_estoque: itemEstoque,
                item_codigo: '',
                item_nome: itemNome,
                categoria_nome: categoriaNome,
                categoria_id: categoriaId,
                item_obs: '',
                item_preco: itemPreco,
                extra: '',
                desc: '',
                extra_vals: '',
                extra_preco: 0,
                total: itemPreco,
                qtde: 1,
                item_hash: 'bebida_' + itemId + '_' + Date.now()
            };

            // Adicionar ao carrinho via AJAX
            $.post(baseUri + "/carrinho/add/", dados)
                .done(function(response) {
                    if (response.success) {
                        // Remover sugestão após adicionar
                        $('#sugestao-bebidas-modal').fadeOut(300, function() {
                            $(this).remove();
                        });

                        // Recarregar o carrinho
                        rebind_reload();

                        // Tocar som se existir
                        if (typeof sound === 'function') {
                            sound();
                        }
                    } else {
                        alert('Erro: ' + response.error);
                    }
                })
                .fail(function(xhr) {
                    alert('Erro ao adicionar bebida. Tente novamente.');
                });
        }

        function dispensarBebidas() {
            // Marcar como dispensado na sessão
            $.post(baseUri + '/carrinho/dispensar_bebidas/', {}).done(function() {
                // Remover o box visualmente
                $('#sugestao-bebidas-modal').fadeOut(300, function() {
                    $(this).remove();
                });
            });
        }
        </script>
        <?php
                }
            }
        }
        ?>

        <div class="divi-btn-finaliza">
            <div class="row">
                <?php if (isset($data['config']) && $data['config']->config_aberto == 1) : ?>
                    <br>

                    <?php
                    // ✅ VERIFICAR DESCONTO DE FREQUÊNCIA
                    if (isset($_SESSION['__CLIENTE__ID__'])) {
                        $fidelidadeModel = new fidelidadeModel();
                        $config_fidelidade = $fidelidadeModel->get_config();

                        // Verificar se o programa é de frequência
                        if (isset($config_fidelidade->config_fidelidade_tipo) && $config_fidelidade->config_fidelidade_tipo === 'frequencia') {
                            $status_frequencia = $fidelidadeModel->verificar_desconto_frequencia($_SESSION['__CLIENTE__ID__']);

                            // Se tem direito ao desconto, mostrar mensagem
                            if ($status_frequencia['tem_desconto']) {
                                $percentual = $status_frequencia['percentual_desconto'];
                                // Formatar percentual sem decimais se for inteiro
                                $percentual_formatado = (floor($percentual) == $percentual) ? (int)$percentual : number_format($percentual, 1);
                                ?>
                                <div class="alert alert-success text-center" style="margin-bottom: 15px;">
                                    <strong>🎉 Você ganhou <?= $percentual_formatado ?>% de desconto!</strong><br>
                                    <small>O desconto será aplicado automaticamente no checkout</small>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>

                    <div class="alert alert-warning text-uppercase no-radius text-center">
                            Total do Pedido: R$ <?php echo Currency::moeda(Carrinho::get_total(), 'double'); ?>
                    </div>
                    <?php if (isset($_SESSION['busca']) && $_SESSION['busca'] == true) : ?>
                        <a href="<?php echo $baseUri; ?>" class="btn btn-block btn-success text-uppercase no-radius">
                            <i class="fa fa-plus-circle"></i>
                            escolher mais itens
                        </a>
                    <?php else : ?>
                        <button class="btn btn-block btn-success text-uppercase no-radius" data-dismiss="modal">
                            <i class="fa fa-plus-circle"></i>
                            escolher mais itens
                        </button>
                    <?php endif; ?>
                    <br>
                    <?php if (Carrinho::get_total() < $data['config']->config_pedmin) : ?>
                        <h4 class="text-center text-danger">
                            O VALOR MÍNIMO DO PEDIDO É DE R$ <?= $data['config']->config_pedmin ?> <br>
                            <small>Escolha algo mais para completar seu pedido!</small>
                        </h4>
                    <?php else : ?>
                        <?php

                        $urlAtual = explode("/", $_SERVER['HTTP_REFERER']);

                        if ($urlAtual[4] == 'admin') { ?>
                            <a <?php if (Carrinho::get_total() <= 0) : ?> disabled<?php endif; ?> href="<?php echo $baseUri; ?>/admin/venda_checkout" class="btn btn-block btn-primary text-uppercase no-radius">
                                <i class="fa fa-chevron-right"></i>
                                <i class="fa fa-chevron-right"></i>
                                concluir venda
                            </a>
                        <?php } else { ?>
                            <a <?php if (Carrinho::get_total() <= 0) : ?> disabled<?php endif; ?> href="<?php echo $baseUri; ?>/pedido/" class="btn btn-block btn-primary text-uppercase no-radius">
                                <i class="fa fa-chevron-right"></i>
                                <i class="fa fa-chevron-right"></i>
                                concluir meu pedido
                            </a>
                        <?php } ?>
                    <?php endif; ?>
                <?php else : ?>
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
                <?php endif; ?>
            </div>
        </div>
    </div>
@else
    <div class="text-center" style="padding: 40px 20px;">
        <img src="{{ asset('assets/img/icon-triste.png') }}" alt="Carrinho Vazio" style="width: 150px; height: auto; margin: 30px auto 20px; opacity: 0.6; border: none !important;" class="img-responsive">
        <h4 style="margin: 20px 0 10px;"><b>Carrinho Vazio</b></h4>
        <p class="text-muted" style="margin-bottom: 30px;">Adicione produtos para começar seu pedido</p>
        <a href="{{ url('/') }}" class="btn btn-warning btn-lg btn-block text-uppercase" style="padding: 15px; font-size: 16px;">
            <i class="fa fa-shopping-cart"></i>
            Comece aqui o seu pedido
        </a>
    </div>
@endif
