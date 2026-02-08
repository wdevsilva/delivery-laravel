@php
    @session_start();
    $carrinho = $_SESSION['__APP__CART__'] ?? [];
    $isMobile = request()->header('User-Agent') && strpos(request()->header('User-Agent'), 'Mobile') !== false;
@endphp

@if (!empty($carrinho))
    <div class="panel-body" style="margin-top: 0px!important; padding-top: 0px!important">
        <div id="painel-carrinho">
            @foreach ($carrinho as $cart)
                @php
                    $cart = (object) $cart;
                    // Garantir que todas as propriedades existam
                    $cart->item_estoque = $cart->item_estoque ?? 0;
                    $cart->categoria_id = $cart->categoria_id ?? '';
                    $cart->categoria_nome = $cart->categoria_nome ?? '';
                    $cart->item_obs = $cart->item_obs ?? '';
                    $cart->extra = $cart->extra ?? '';
                    $cart->qtde = $cart->qtde ?? 1;
                @endphp
                <div class="item item-carrinho" id="list-item-{{ $cart->item_hash }}" data-categoria-id="{{ $cart->categoria_id }}">
                    <div class="row">
                        <div class="col-md-5 col-xs-7">
                            <div class="row text-left">
                                <a style="padding: 0;" title="-1" class="btn btn-light"
                                    id="controleAddMore{{ $cart->item_id }}" data-toggle="tooltip"
                                    data-estoque="{{ $cart->item_estoque }}" data-id="{{ $cart->item_id }}"
                                    data-hash="{{ $cart->item_hash }}">
                                    <i class="fa fa-minus-circle btn-plus-minus fa-2x text-danger del-more"
                                        data-estoque="{{ $cart->item_estoque }}" data-id="{{ $cart->item_id }}"
                                        data-hash="{{ $cart->item_hash }}"></i>
                                </a>&nbsp;
                                <span id="sp-qt-{{ $cart->item_hash }}" class="item-qtde qtde-item">
                                    {{ $cart->qtde <= 9 ? "0$cart->qtde" : $cart->qtde }}
                                </span>
                                <a style="padding: 0;" title="+1" class="btn btn-light"
                                    id="controleAddDel{{ $cart->item_id }}" data-toggle="tooltip"
                                    data-estoque="{{ $cart->item_estoque }}" data-id="{{ $cart->item_id }}"
                                    data-hash="{{ $cart->item_hash }}">
                                    <i class="fa fa-plus-circle btn-plus-minus fa-2x text-success add-more"
                                        data-estoque="{{ $cart->item_estoque }}" data-id="{{ $cart->item_id }}"
                                        data-hash="{{ $cart->item_hash }}"></i>
                                </a>
                                <span class="item-nome text-capitalize" style="padding-top: 2px">
                                    @if (!empty($cart->categoria_nome))
                                        {{ $cart->categoria_nome }}
                                    @else
                                        {{ $cart->item_nome }}
                                    @endif

                                    @if ($isMobile == 1)
                                        @if (strlen($cart->extra) > 2)
                                            @php
                                                $extraFormatted = substr($cart->extra, 0, -2);
                                                $extraLines = preg_split('/<br\s*\/?>/', $extraFormatted);
                                            @endphp
                                            @foreach ($extraLines as $line)
                                                @php
                                                    $line = trim($line);
                                                @endphp
                                                @if ($line)
                                                    <br><small class="text-muted">{!! $line !!}</small>
                                                @endif
                                            @endforeach
                                        @else
                                            <br>
                                            {{ $cart->item_nome }}
                                            {{ mb_strtolower($cart->item_obs) }}
                                        @endif
                                    @endif
                                    <small class="item-estoque-{{ $cart->item_hash }} text-danger"
                                        style="padding-top: 0px;padding-left: 5px;"></small>
                                </span>
                            </div>
                        </div>
                        @if (strrpos($cart->extra, '1/2') === false)
                            <div class="col-md-5 hidden-xs">
                                <small class="text-muted">{{ $cart->item_nome }}</small>
                            </div>
                        @endif
                        <div class="col-md-5 hidden-xs">
                            @if (strlen($cart->extra) <= 0)
                                <small class="text-muted">{{ mb_strtolower($cart->item_obs) }}</small><br>
                            @else
                                @php
                                    $extraFormatted = substr($cart->extra, 0, -2);
                                    $extraLines = preg_split('/<br\s*\/?>/', $extraFormatted);
                                @endphp
                                @foreach ($extraLines as $line)
                                    @php
                                        $line = trim($line);
                                    @endphp
                                    @if ($line)
                                        <small class="text-muted">{!! $line !!}</small><br>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="col-md-2 col-xs-5">
                            R$ {{ \App\Helpers\Filter::moeda(($cart->item_preco ?? 0) * $cart->qtde) }}
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- 🥤 SUGESTÃO DE BEBIDAS NO MODAL -->
        @php
            // Verificar se há bebida no carrinho
            $tem_bebida_modal = false;
            $categorias_bebida_modal = ['bebida', 'bebidas', 'drinks', 'sucos', 'refrigerante', 'refrigerantes'];

            foreach ($carrinho as $cart_item) {
                $cart_item = (object) $cart_item;
                $categoria_lower = mb_strtolower($cart_item->categoria_nome ?? '');
                foreach ($categorias_bebida_modal as $termo_bebida) {
                    if (strpos($categoria_lower, $termo_bebida) !== false) {
                        $tem_bebida_modal = true;
                        break 2;
                    }
                }
            }

            // Se NÃO tem bebida e ainda não foi dispensado nesta sessão
            $bebida_dispensada = session('__BEBIDA_DISPENSADA__', false);

            if (!$tem_bebida_modal && !$bebida_dispensada) {
                // Desabilitado temporariamente - precisa implementar repositories
                $categoria_bebida_id_modal = null;
                /*

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
                // Desabilitado
            }
            */
            }
        @endphp
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

        <div class="divi-btn-finaliza">
            <div class="row">
                <div class="text-center" style="padding: 15px;">
                    <button class="btn btn-block btn-success text-uppercase no-radius" data-dismiss="modal">
                        <i class="fa fa-plus-circle"></i>
                        escolher mais itens
                    </button>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="text-center" style="padding: 40px 20px;">
        <img src="{{ asset('assets/img/icon-triste.png') }}" alt="Carrinho Vazio"
            style="width: 150px; height: auto; margin: 30px auto 20px; opacity: 0.6; border: none !important;"
            class="img-responsive">
        <h4 style="margin: 20px 0 10px;"><b>Carrinho Vazio</b></h4>
        <p class="text-muted" style="margin-bottom: 30px;">Adicione produtos para começar seu pedido</p>
        <a href="{{ url('/') }}" class="btn btn-warning btn-lg btn-block text-uppercase"
            style="padding: 15px; font-size: 16px;">
            <i class="fa fa-shopping-cart"></i>
            Comece aqui o seu pedido
        </a>
    </div>
@endif
