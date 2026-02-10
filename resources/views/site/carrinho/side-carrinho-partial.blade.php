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
                <div class="item item-carrinho" id="list-item-{{ $cart->item_hash }}"
                    data-categoria-id="{{ $cart->categoria_id }}">
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
                                            $extraLines = preg_split('/<br\s*\/@endphp/', $extraFormatted);
?>
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
                                $extraLines = preg_split('/<br\s*\/@endphp/', $extraFormatted);
?>
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
                            R$ {{ \App\Helpers\Filter::moeda(((floatval($cart->item_preco ?? 0) + floatval($cart->extra_preco ?? 0)) * $cart->qtde)) }}
                        </div>
                    </div>
                    <div class="row">
                        <hr>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- 🥤 SUGESTÃO DE BEBIDAS --}}
        @php
            // Verificar se há bebida no carrinho
            $tem_bebida = false;
            $categorias_bebida = ['bebida', 'bebidas', 'drinks', 'sucos', 'refrigerante', 'refrigerantes'];

            foreach ($carrinho as $cart_item) {
                $cart_item = (object) $cart_item;
                $categoria_lower = mb_strtolower($cart_item->categoria_nome ?? '');
                foreach ($categorias_bebida as $termo_bebida) {
                    if (strpos($categoria_lower, $termo_bebida) !== false) {
                        $tem_bebida = true;
                        break 2;
                    }
                }
            }

            // Se NÃO tem bebida e ainda não foi dispensado nesta sessão
            @session_start();
            $bebida_dispensada = $_SESSION['__BEBIDA_DISPENSADA__'] ?? false;

            $bebidas_disponiveis = [];
            if (!$tem_bebida && !$bebida_dispensada) {
                // Buscar categoria de bebidas
                $todas_categorias = DB::table('categoria')->orderBy('categoria_pos', 'ASC')->get();
                $categoria_bebida_id = null;

                foreach ($todas_categorias as $cat) {
                    $cat_lower = mb_strtolower($cat->categoria_nome);
                    foreach ($categorias_bebida as $termo) {
                        if (strpos($cat_lower, $termo) !== false) {
                            $categoria_bebida_id = $cat->categoria_id;
                            break 2;
                        }
                    }
                }

                // Se encontrou categoria de bebidas, buscar produtos
                if ($categoria_bebida_id) {
                    $bebidas = DB::table('item')
                        ->where('item_categoria', $categoria_bebida_id)
                        ->where('item_estoque', '>', 0)
                        ->where('item_ativo', 1)
                        ->limit(3)
                        ->get();

                    foreach ($bebidas as $bebida) {
                        $bebidas_disponiveis[] = $bebida;
                    }
                }
            }
        @endphp

        @if(count($bebidas_disponiveis) > 0)
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
                    @foreach($bebidas_disponiveis as $bebida)
                        @php
                            $foto_bebida = !empty($bebida->item_foto)
                                ? asset('assets/item/' . session('base_delivery') . '/' . $bebida->item_foto)
                                : asset('assets/img/no-image.jpg');
                        @endphp
                        <div onclick="adicionarBebidaRapido({{ $bebida->item_id }}, '{{ addslashes($bebida->item_nome) }}', '{{ addslashes($bebida->categoria_nome ?? '') }}', {{ $bebida->item_categoria }}, {{ $bebida->item_preco }}, {{ $bebida->item_estoque }})"
                            style="background: rgba(255,255,255,0.95); border-radius: 8px; padding: 10px; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: transform 0.2s;"
                            onmouseover="this.style.transform='scale(1.02)'"
                            onmouseout="this.style.transform='scale(1)'">
                            <img src="{{ $foto_bebida }}"
                                alt="{{ $bebida->item_nome }}"
                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px; flex-shrink: 0;">
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-weight: bold; font-size: 13px; color: #333; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $bebida->item_nome }}
                                </div>
                                <div style="color: #667eea; font-weight: bold; font-size: 14px;">
                                    R$ {{ \App\Helpers\Filter::moeda($bebida->item_preco) }}
                                </div>
                            </div>
                            <i class="fa fa-plus-circle" style="color: #667eea; font-size: 24px; flex-shrink: 0;"></i>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <script>
        function adicionarBebidaRapido(itemId, itemNome, categoriaNome, categoriaId, itemPreco, itemEstoque) {
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

            $.post(baseUri + "/carrinho/add", dados)
                .done(function(response) {
                    if (response.success) {
                        $('#sugestao-bebidas-modal').fadeOut(300, function() {
                            $(this).remove();
                        });

                        if (typeof rebind_reload === 'function') {
                            rebind_reload();
                        }

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
            $.post(baseUri + '/carrinho/dispensar_bebidas', {}).done(function() {
                $('#sugestao-bebidas-modal').fadeOut(300, function() {
                    $(this).remove();
                });
            });
        }
        </script>
        @endif

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
                @if (isset($dados['config']) && $dados['config']->config_aberto == 1)
                    <br>

                    {{-- Total do Pedido --}}
                    @php
                        $total = 0;
                        foreach ($carrinho as $item) {
                            $item = (object) $item;
                            $total += ((floatval($item->item_preco ?? 0) + floatval($item->extra_preco ?? 0)) * ($item->qtde ?? 1));
                        }
                    @endphp

                    <div class="alert alert-warning text-uppercase no-radius text-center">
                        Total do Pedido: R$ {{ \App\Helpers\Filter::moeda($total) }}
                    </div>

                    {{-- Botão Escolher Mais Itens --}}
                    <div class="text-center" style="padding: 15px;">
                        <button class="btn btn-block btn-success text-uppercase no-radius" data-dismiss="modal">
                            <i class="fa fa-plus-circle"></i>
                            escolher mais itens
                        </button>
                    </div>

                    <br>

                    {{-- Verificar Valor Mínimo --}}
                    @if ($total < ($dados['config']->config_pedmin ?? 0))
                        <div class="text-center" style="padding: 0 15px;">
                            <h4 class="text-danger">
                                O VALOR MÍNIMO DO PEDIDO É DE R$
                                {{ number_format($dados['config']->config_pedmin ?? 0, 2, ',', '.') }}<br>
                                <small>Escolha algo mais para completar seu pedido!</small>
                            </h4>
                        </div>
                    @else
                        {{-- Botão Concluir Pedido --}}
                        <div class="text-center" style="padding: 0 15px 15px;">
                            @php
                                $urlAtual = explode('/', request()->header('referer', ''));
                                $isAdmin = isset($urlAtual[4]) && $urlAtual[4] == 'admin';
                            @endphp
                            @if ($isAdmin)
                                @php
                                    @session_start();
                                    $cartTotal = 0;
                                    if (isset($_SESSION['__APP__CART__'])) {
                                        foreach ($_SESSION['__APP__CART__'] as $item) {
                                            $cartTotal += ((floatval($item->item_preco ?? 0) + floatval($item->extra_preco ?? 0)) * ($item->qtde ?? 1));
                                        }
                                    }
                                @endphp
                                <a href="{{ url('/admin/venda_checkout') }}"
                                    class="btn btn-block btn-primary text-uppercase no-radius {{ $cartTotal <= 0 ? 'disabled' : '' }}">
                                    <i class="fa fa-chevron-right"></i>
                                    <i class="fa fa-chevron-right"></i>
                                    concluir venda
                                </a>
                            @else
                                <a href="{{ url('/pedido') }}"
                                    class="btn btn-block btn-primary text-uppercase no-radius">
                                    <i class="fa fa-chevron-right"></i>
                                    <i class="fa fa-chevron-right"></i>
                                    concluir meu pedido
                                </a>
                            @endif
                        </div>
                    @endif
                @else
                    <button class="btn btn-block btn-danger text-uppercase no-radius" type="button">
                        <i class="fa fa-exclamation-triangle"></i> Estamos fechados!
                        @php
                        // Função para extrair horário de abertura
                        $extrairHorario = function($configDia) {
                            if (empty($configDia)) return null;
                            $partes = explode(' ', $configDia);
                            if (count($partes) < 2 || $partes[0] != 'on') return null;
                            $horarios = explode('-', $partes[1]);
                            return $horarios[0] ?? null;
                        };

                        // Mapa de dias da semana
                        $horarios = [
                            0 => $extrairHorario($dados['config']->config_domingo),
                            1 => $extrairHorario($dados['config']->config_segunda),
                            2 => $extrairHorario($dados['config']->config_terca),
                            3 => $extrairHorario($dados['config']->config_quarta),
                            4 => $extrairHorario($dados['config']->config_quinta),
                            5 => $extrairHorario($dados['config']->config_sexta),
                            6 => $extrairHorario($dados['config']->config_sabado),
                        ];

                        $agora = now();
                        $diaAtual = $agora->dayOfWeek;
                        $mensagemAbertura = null;

                        // Busca próximo dia com horário de abertura
                        for ($i = 0; $i < 7; $i++) {
                            $diaCheck = ($diaAtual + $i) % 7;
                            $horarioAbertura = $horarios[$diaCheck];

                            if ($horarioAbertura) {
                                try {
                                    $abertura = \Carbon\Carbon::parse($horarioAbertura);

                                    // Se for hoje
                                    if ($i == 0) {
                                        if ($abertura->greaterThan($agora)) {
                                            $diff = $agora->diff($abertura);
                                            $mensagemAbertura = 'Abriremos em ' . $diff->h . ' horas, ' . $diff->i . ' minutos';
                                            break;
                                        }
                                    } else {
                                        // Se for outro dia
                                        $diasNomes = ['domingo', 'segunda', 'terça', 'quarta', 'quinta', 'sexta', 'sábado'];
                                        $nomeDia = $diasNomes[$diaCheck];
                                        $mensagemAbertura = 'Abriremos na ' . $nomeDia . ' às ' . $horarioAbertura;
                                        break;
                                    }
                                } catch (\Exception $e) {
                                    continue;
                                }
                            }
                        }
                        @endphp
                        @if($mensagemAbertura)
                            <br><small>{{ $mensagemAbertura }}</small>
                        @endif
                    </button>
                @endif
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
        <a href="{{ url('/') }}" class="btn btn-warning btn-block text-uppercase">
            <i class="fa fa-shopping-cart"></i>
            Comece aqui o seu pedido
        </a>
    </div>
@endif
