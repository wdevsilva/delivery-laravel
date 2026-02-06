$(function() {
    // Configurar CSRF token para AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }); 

    sabores = 1;
    categoria = '';
    valorAcrescimento = 0;

    // Variável GLOBAL para armazenar bordas
    window.selectedBordas = window.selectedBordas || [];

    // Monitora TODAS as mudanças em inputs para capturar bordas IMEDIATAMENTE (GLOBAL, fora do ready)
    $(document).on('change', 'input[data-nome]', function() {
        var $input = $(this);
        var nome = $input.data('nome');
        var isChecked = $input.is(':checked');


        // Detecta se é uma borda (não está em .lista-sabores)
        var isBorda = $input.closest('.lista-sabores').length === 0;


        if (isBorda) {
            if (isChecked) {
                // Adiciona à lista se marcado
                var exists = window.selectedBordas.some(function(b) { return b.nome === nome; });
                if (!exists) {
                    window.selectedBordas.push({
                        nome: nome,
                        preco: $input.data('preco_real') || 0,
                        grupo: $input.data('grupo')
                    });
                }
            } else {
                // NÃO REMOVE DA MEMÓRIA! O scroll pode estar desmarcando automaticamente
                // A memória só será limpa quando adicionar ao carrinho ou fechar o modal
            }
        } else {
        }
    });

    $(document).ready(function() {

        $(".sabores").on("change", function () {

            var sab_id = $(this).data("id");
            var item_id = $(this).data("item");
            var item_nome = $(this).data("nome");

            var item = $(this).data("item-id");
            var categoria = $(this).data("categoria-nome");
            var sabores = $("#sabores-" + item).val();

            var container = $(".lista-sab-" + item);
            var totalSelecionados = container.find("input:checked").length;
            var clicadoEstaMarcado = $(this).prop("checked");
            var selecionados = clicadoEstaMarcado ? totalSelecionados : totalSelecionados - 1;

            if (sab_id == item_id) {
                resetView(container);
                return true; // já selecionado
            }

            if (selecionados >= sabores) {
                // Esconde os não selecionados com animação suave
                container.find("input:not(:checked)").closest(".lista-sabores").slideUp(300);
                // Se existir .form-check (código antigo), também esconde
                container.find("input:not(:checked)").closest(".form-check").slideUp(300);
                $("input:radio").prop("checked", false);
                $('.acrescimoMédia').html('');
            } else {
                // Mostra todos novamente
                resetView(container);
            }

            // se precisar executar algo com o sabor selecionado
            var resp = sab_id.split("-");
        });

        $(".tamanho").on("click", function() {

            var item = $(this).data("nome");

            if (item == 'Pequena' && sabores == 2) {
                alert('Permitido apenas um sabor de pizza para opção pequena.');
                return false;
            }

            //aqui quando seleciona prieiro pizza doce, então não precisa do acrescimo, pois o mesmo já esta no cadastro da categoria
            if (item == 'Média' && (sabores <= 2)) {
                acrescimento = " +R$ 3,00";
                valorAcrescimento = "3";
                $('.acrescimoMédia').html(acrescimento);
            } else if (item == 'Pequena' || item == 'Grande') {
                $('.acrescimoMédia').html('');
            }

            if ($(".lista-sab-" + item).find("input:checked").length >= sabores) {
                $(".lista-sab-" + item).find("input:not(:checked)").attr("disabled", "disabled");
            } else {
                $(".lista-sab-" + item).find("input").removeAttr("disabled");
            }
        });

        // Event delegation para suportar elementos dinâmicos (como Pedir Novamente)
        $(document).on("click", ".add-item", function(e) {
            // Previne execução múltipla
            e.preventDefault();
            e.stopPropagation();

            var $btn = $(this);

            // Se já está processando, ignora
            if ($btn.data('processing')) {
                return false;
            }

            // Processa imediatamente
            processarAdicaoCarrinho($btn);

            return false;
        });
    });
});

function processarAdicaoCarrinho($btn) {
    var item_id = $btn.data("id");
    var $modal = $("#item-" + item_id);

    // ============ INTERCEPTOR PARA ADICIONAR ITENS AO PEDIDO (Admin) ============
    if (window.adicionandoItensPedido === true && typeof adicionarItemAoPedido === 'function') {
        // Estamos no contexto do modal de adicionar itens ao pedido
        var item_nome = $btn.data("nome");
        var item_preco = parseFloat($btn.data("preco"));
        var item_estoque = parseInt($btn.data("estoque"));
        var categoria_id = $btn.data("categoria");
        var categoria_nome = $btn.data("categoria-nome");
        var item_codigo = $btn.data("cod") || '';
        var item_obs = $btn.data("obs") || '';

        // Adiciona à lista de itens selecionados
        adicionarItemAoPedido(item_id, item_nome, item_preco, item_estoque, categoria_id, categoria_nome, item_codigo, item_obs);

        // Fecha o modal de produto
        $modal.modal('hide');

        return; // Para aqui, não adiciona ao carrinho
    }
    // ============================================================================

        // NOVA ABORDAGEM: Usa selectedItems do modal-produto.js ao invés de buscar inputs:checked
        // Porque os adicionais estão em selectedItems mas os checkboxes podem não estar marcados
        var capturedOptions = [];

        // Itera sobre selectedItems para capturar os adicionais
        if (window.selectedItems && typeof window.selectedItems === 'object') {
            $.each(window.selectedItems, function(key, item) {
                // Ignora o produto principal e sabores
                if (key === 'produto-principal' || key.startsWith('sab-')) {
                    return; // continue
                }

                // Este é um adicional!
                capturedOptions.push({
                    input: item.element,
                    nome: item.name,
                    preco: parseFloat(item.price) || 0,
                    grupo: item.grupo || '',
                    tipo: 'checkbox'
                });
            });
        }

        // FALLBACK: Se não tiver nada em selectedItems, busca inputs checked diretamente
        if (capturedOptions.length === 0) {
            $modal.find('input[type="checkbox"]:checked, input[type="radio"]:checked').each(function() {
                var $input = $(this);
                // Ignora sabores
                if ($input.closest('.lista-sabores').length > 0) {
                    return;
                }

                capturedOptions.push({
                    input: this,
                    nome: $input.data('nome') || '',
                    preco: parseFloat($input.data('preco_real')) || 0,
                    grupo: $input.data('grupo') || '',
                    tipo: $input.attr('type')
                });
            });
        }

        // ================================================================

        var item_hash = $btn.data("hash");
        var item_nome = $btn.data("nome");
        var grupo = $btn.data("nome");
        var item_categoria = $btn.data("categoria");
        var categoria_nome = $btn.data("categoria-nome");
        var item_obs = $btn.data("obs");
        var item_cod = $btn.data("cod");
        var item_estoque = parseInt($btn.data("estoque"));

        var url = baseUri + "/carrinho/add_more/";
        $.post(url, { id: item_id, hash: item_hash, estoque: item_estoque }, function(rs) {
            if (rs == '-1') {
                $("#modal-carrinho").modal("show");
                $('.item-estoque-' + item_hash).html('Quantidade indisponível!');
                return false;
            }
        });

        var item_preco = parseFloat($btn.data("preco"));
        var optExtraValTotal = 0;
        var optExtraNames = "";
        var optExtraVals = "";

        // ===== USA OS DADOS CAPTURADOS (capturedOptions) =====

        var optElm = capturedOptions; // Usa array capturado em vez de buscar novamente

        // ===== VALIDAÇÃO DE GRUPOS OBRIGATÓRIOS =====
        // SÓ VALIDA SE O MODAL EXISTIR E ESTIVER VISÍVEL
        var $modal = $("#item-" + item_id);

        // Se o modal não existe ou não está visível, pula a validação (ex: Mais Vendidos sem opções)
        if ($modal.length === 0 || (!$modal.hasClass('in') && !$modal.is(':visible'))) {
            // Não há modal ou não está aberto, continua sem validação
        } else {
            // Modal existe e está aberto, verifica se há grupos obrigatórios
            var gruposObrigatorios = [];

            // Identifica os grupos obrigatórios pelos inputs com required
            $modal.find('input[required]').each(function() {
                var grupoId = $(this).data('grupo');
                var grupoName = $(this).attr('name');

                // Adiciona apenas uma vez cada grupo
                if (grupoId && !gruposObrigatorios.some(g => g.id === grupoId)) {
                    var $grupoSection = $(this).closest('.opcoes-section');
                    var grupoNome = $grupoSection.find('.opcoes-section-title span').first().text().trim();

                    gruposObrigatorios.push({
                        id: grupoId,
                        nome: grupoNome,
                        name: grupoName.split('-')[0] + '-' + grupoName.split('-')[1] // opt-{grupo_id}
                    });
                }
            });

            // SÓ FAZ VALIDAÇÃO SE HOUVER GRUPOS OBRIGATÓRIOS
            if (gruposObrigatorios.length > 0) {
                // Valida se cada grupo obrigatório tem pelo menos uma opção selecionada
                var gruposNaoSelecionados = [];

                for (var i = 0; i < gruposObrigatorios.length; i++) {
                    var grupo = gruposObrigatorios[i];

                    // Busca inputs do grupo usando o padrão name="opt-{grupo_id}-{item_id}"
                    // name="opt-123-456" onde 123 é o grupo_id e 456 é o item_id
                    var selectorName = 'input[name="opt-' + grupo.id + '-' + item_id + '"]';

                    // Aguarda 10ms para garantir que o DOM está atualizado
                    var inputsSelecionados = $modal.find(selectorName).filter(function() {
                        return $(this).is(':checked') || $(this).prop('checked');
                    });

                    var selecionado = inputsSelecionados.length > 0;

                    // Verifica também se o card está com classe 'selected'
                    if (!selecionado) {
                        var $grupoCards = $modal.find('.grupo-' + grupo.id);
                        var hasSelected = $grupoCards.filter('.selected').length > 0;
                        if (hasSelected) {
                            selecionado = true;
                        }
                    }

                    if (!selecionado) {
                        gruposNaoSelecionados.push(grupo.nome);
                    }
                }

                // Se houver grupos obrigatórios não selecionados, exibe mensagem e bloqueia
                if (gruposNaoSelecionados.length > 0) {
                    // Destaca visualmente os grupos não selecionados
                    gruposNaoSelecionados.forEach(function(nomeGrupo) {
                        $modal.find('.opcoes-section').each(function() {
                            var titulo = $(this).find('.opcoes-section-title span').first().text().trim();
                            if (titulo === nomeGrupo) {
                                var $section = $(this);

                                // Adiciona classe de erro
                                $section.addClass('opcoes-section-error');

                                // Faz scroll suave até a primeira seção com erro
                                if ($modal.find('.opcoes-section-error').first().is($section)) {
                                    $modal.find('.modal-body').animate({
                                        scrollTop: $section.position().top - 20
                                    }, 400);
                                }

                                // Remove destaque após 2 segundos
                                setTimeout(function() {
                                    $section.removeClass('opcoes-section-error');
                                }, 2000);
                            }
                        });
                    });

                    // Vibra o botão para feedback tátil visual
                    var $btnAdd = $("#btn-add-" + item_id);
                    $btnAdd.addClass('btn-shake');
                    setTimeout(function() {
                        $btnAdd.removeClass('btn-shake');
                    }, 500);

                    return false;
                }
            } // Fecha o if (gruposObrigatorios.length > 0)
        } // Fecha o else da validação

        var sabElm = $(".lista-sab-" + item_id).filter(':visible').find("input:checked");

        // Processa sabores se houver pelo menos 1 selecionado
        if (sabElm.length >= 1) {

            var valMinMax = 0;
            var valMinMaxQtde = 0;
            maior_valor = [];

            sabElm.each(function() {
                var preco = parseFloat($(this).data("preco"));
                var nome = $(this).data("nome");
                valMinMax += preco;
                valMinMaxQtde++;
                item_preco = preco;

                // Para 1 sabor, substitui o item_nome pelo nome do sabor
                if (sabElm.length === 1) {
                    item_nome = nome;
                } else {
                    // Para múltiplos sabores, adiciona à descrição
                    optExtraNames += " <b>1/2</b> " + nome + ", ";
                }

                maior_valor.push(preco);
            });

            // Para múltiplos sabores, fecha a lista de sabores com quebra de linha
            if (sabElm.length > 1) {
                optExtraNames = optExtraNames.replace(/,\s*$/, '') + '<br>';
            }

            var divisao_valor_pizza = document.getElementById('divisao_valor_pizza').value;

            if (divisao_valor_pizza == 1) {
                item_preco = parseFloat(valMinMax / valMinMaxQtde);
            } else {
                item_preco = parseFloat(Math.max.apply(null, maior_valor));
            }

        }
        $("#btn-add-" + item_id).removeAttr("disabled");

        // Group options by grupo_nome
        if (optElm.length >= 1) {
            var grupos = {};

            // Itera sobre o array de opções capturadas
            for (var i = 0; i < optElm.length; i++) {
                var opt = optElm[i];
                var $input = $(opt.input);
                var grupoNome = '';

                // Tenta encontrar o nome do grupo
                // 1. Primeiro procura em .opcao-card (layout novo com cards)
                var $opcaoCard = $input.closest('.opcao-card');
                if ($opcaoCard.length) {
                    // O título está na seção pai (.opcoes-section)
                    var $section = $opcaoCard.closest('.opcoes-section');
                    grupoNome = $section.find('.opcoes-section-title span').first().text().trim();
                }

                // 2. Se não encontrou, procura em .form-check (layout antigo)
                if (!grupoNome) {
                    var $formCheck = $input.closest('.form-check');
                    if ($formCheck.length) {
                        grupoNome = $formCheck.parent().find('b').first().text().trim();
                    }
                }

                // 3. Se ainda não encontrou, usa o data-grupo ou 'OUTROS'
                if (!grupoNome) {
                    grupoNome = opt.grupo || 'OUTROS';
                }


                if (!grupos[grupoNome]) {
                    grupos[grupoNome] = [];
                }

                grupos[grupoNome].push({
                    nome: opt.nome,
                    preco: parseFloat(opt.preco) || 0
                });

                var precoParseado = parseFloat(opt.preco) || 0;

                optExtraVals += precoParseado + ", ";
                optExtraValTotal += precoParseado;
            }

            // Format output with group labels and line breaks
            var groupLines = [];

            for (var grupo in grupos) {
                if (grupos.hasOwnProperty(grupo)) {
                    var line = '';
                    var itensComPreco = [];
                    var itensSemPreco = [];

                    // Separa itens com e sem preço
                    grupos[grupo].forEach(function(item) {
                        var preco = parseFloat(item.preco) || 0;
                        if (preco > 0) {
                            itensComPreco.push(item.nome + ' (+R$ ' + preco.toFixed(2).replace('.', ',') + ')');
                        } else {
                            itensSemPreco.push(item.nome);
                        }
                    });

                    // Apenas mostra grupos que tenham itens COM preço OU que não sejam ADICIONAIS
                    var mostrarGrupo = false;

                    if (grupo === 'ADICIONAL' || grupo === 'ADICIONAIS') {
                        // Para ADICIONAIS, só mostra se tiver itens com preço
                        if (itensComPreco.length > 0) {
                            line = "<b>Adicionais:</b> " + itensComPreco.join(", ");
                            mostrarGrupo = true;
                        }
                    } else {
                        // Para outros grupos (MASSA, MOLHO, etc.), mostra normalmente
                        if (grupo === 'BORDA' || grupo === 'BORDAS') {
                            line = "<b>Borda:</b> ";
                        } else if (grupo === 'INGREDIENTE' || grupo === 'INGREDIENTES') {
                            line = "<b>Ingredientes:</b> ";
                        } else {
                            line = "<b>" + grupo + ":</b> ";
                        }

                        var todosItens = itensComPreco.concat(itensSemPreco);
                        line += todosItens.join(", ");
                        mostrarGrupo = true;
                    }

                    if (mostrarGrupo) {
                        groupLines.push(line);
                    }
                }
            }

            // Join with <br> for line breaks
            if (groupLines.length > 0) {
                optExtraNames += groupLines.join('<br>') + ', ';
            }
        }


        var itemOptItemPreco = parseFloat(item_preco) + parseFloat(optExtraValTotal) + parseFloat(valorAcrescimento);

        var dados = {
            item_id: item_id,
            item_estoque: item_estoque,
            item_codigo: item_cod,
            item_nome: item_nome,
            categoria_nome: categoria_nome,
            categoria_id: item_categoria,
            item_obs: item_obs,
            item_preco: item_preco,
            extra: optExtraNames,
            desc: optExtraNames, // Store formatted description for database
            extra_vals: optExtraVals,
            extra_preco: optExtraValTotal,
            total: itemOptItemPreco,
            remove_temp: 1 // Remove itens temporários do mesmo produto
        };

        // NOVO: Para sabor único (meia = 1), envia flag para remover item anterior da mesma categoria
        var $modal = $("#item-" + item_id);
        var maxSabores = parseInt($('#sabores-' + item_id).val()) || 1;

        if (maxSabores === 1 && sabElm.length === 1) {
            dados.is_single_flavor = 1;
        }

        var url = baseUri + "/carrinho/add/";

        // Aguarda o POST concluir ANTES de fechar o modal e limpar seleções
        $.post(url, dados, function() {}).done(function() {
            // Sucesso - agora pode fechar o modal
            $("#item-" + item_id).modal("hide");
            saboresSelect = 1;
            $(".lista-sabores").find("input").removeAttr("disabled");
            $(".lista-sabores").find("input:checked").removeAttr("checked");
            $(".form-check").find("input:checked").removeAttr("checked");
            $(".pre-checked").parent().trigger("click");

            // Limpa memória de bordas
            window.selectedBordas = [];

            // Recarrega o carrinho
            rebind_reload();

            // Mostra o carrinho e toca som
            setTimeout(function() {
                $("#modal-carrinho").modal("show");
                sound();
            }, 500);
            $("#busca").val("");
        }).fail(function() {
            // Erro ao adicionar
            alert('Erro ao adicionar item ao carrinho. Tente novamente.');
        });
}

$(document).ready(function() {
    $(".form-check input[type=checkbox]").on("click", function() {
        var limite = $(this).data("limite");
        var item = $(this).data("grupo");
        var optSet = parseInt(
            $(".opt-" + item).find("input[type=checkbox]:checked").length
        );
        if (optSet > limite) {
            //BLOQUEIA PARA NÃO SELECIONAR MAIS NADA QUE O PERMITIDO

            //this.checked = false;
            $(this).prop('checked', '');
            $(this).addClass("tremer");
            $('.grupoIngredientes').addClass("tremer");
            setTimeout(function() {
                $('input[type=checkbox]').removeClass("tremer");
                $('.grupoIngredientes').removeClass("tremer");
            }, 1000);

            $(".opt-" + item).find("input[type=checkbox]").not(":checked").attr("disabled", "disabled");
        } else {
            $(".opt-" + item).find("input[type=checkbox]").not(":checked").removeAttr("disabled");
        }
    });

    $(".modal-itens").on("hide.bs.modal", function() {
        saboresSelect = 1;

        // Limpa sabores
        $(".lista-sabores").find("input").removeAttr("disabled");
        $(".lista-sabores").find("input").prop("checked", false);
        $(".lista-sabores").slideDown(300); // Mostra todos os sabores novamente

        // Limpa opções (adicionais, bordas, etc.)
        $(".form-check").find("input").removeAttr("disabled");
        $(".form-check").find("input").prop("checked", false);
        $(".opcao-card input").prop("checked", false);
        $(".opcao-card").removeClass("selected");

        // Limpa classes visuais
        $(".lista-sabores label").removeClass("selected");

        // Reseta acréscimo
        $('.acrescimoMédia').html('');
    });
    rebind_add();
    rebind_del();
    rebind_scroll();
    rebind_get_count();
    rebind_get_count_bag();
});

function resetView(container) {
    // Mostra todos os sabores novamente (suporta .form-check e .lista-sabores)
    container.find("input").closest(".form-check").slideDown(300);
    container.find("input").closest(".lista-sabores").slideDown(300);
    $("input:radio").prop("checked", false);
    $('.acrescimoMédia').html('');
}

function sound() {
    var sound = new Howl({
        src: [baseUri + '/midias/alerta/addcarrinho.mp3'],
        volume: 1.0,
        autoplay: true,
    });
    sound.play();
}

function aplica_cupom() {
    var url = baseUri + "/pedido/aplica_cupom/";
    var cupom = $("#cupom_nome").val();
    var local = $("#pedido_local").val();
    var obs = $("#pedido_obs").val();
    $.post(url, { cupom: cupom, local: local, obs: obs }).then(function(rs) {
        if (parseInt(rs) == 1) {
            var html = '<strong class="text-success"> Cupom aplicado</strong>';
            setTimeout(function() {
                window.location.reload();
            }, 350);
        } else if (parseInt(rs) == 2) {
            var html = '<strong class="text-danger">  Cupom Utilizado</strong>';
            var bor = $('#cupom_nome').css('border');
            $('#cupom_nome').css('border', '1px solid red');
            $('#cupom_nome').val('Desculpe, você já utilizou este cupom :(');
            setTimeout(function() {
                $('#cupom_nome').val('');
                $('#cupom_nome').css('border', bor);
            }, 3000)
        } else {
            var html = '<strong class="text-danger"> Cupom inválido</strong>';
            var bor = $('#cupom_nome').css('border');
            $('#cupom_nome').css('border', '1px solid red');
            $('#cupom_nome').val('Cupom inválido ou expirado!');
            setTimeout(function() {
                $('#cupom_nome').val('');
                $('#cupom_nome').css('border', bor);
            }, 2000)
        }
        $("#cupom_resposta").html(html);
    });
}

function remove_cupom() {
    var url = baseUri + "/pedido/remove_cupom/";
    $.post(url).then(function(rs) {
        var html = '<strong class="text-success"> Cupom removido</strong>';
        setTimeout(function() {
            window.location.reload();
        }, 350);
        $("#cupomrm_resposta").html(html);
    });
}

$("#pedido_obs").on("change", function() {
    var valor_obs = $(this).val();
    $("#pega-obs").val(valor_obs);
});

$("#pedido_local").on("change", function() {

    $(".pedido_bairro").val("");
    $("#btn-pedido-concluir").attr("disabled", "disabled");

    var ori_total = totalCompra;
    var local = parseInt($(this).val());
    var total = parseFloat(totalCompra);
    taxa = 0;
    $("#pedido_entrega").val(0);
    $("#taxa-faixa").html("R$ 0,00");

    if (local == -1) {
        window.location.href = baseUri + "/novo-endereco/?return=pedido";
    }

    // ✅ RETIRAR NO LOCAL: pode ser -2 ou 0 dependendo do contexto
    if (local == -2 || local == 0) {
        // ✅ RECALCULAR TAXA DO CARTÃO quando selecionar "Retirar no Local" (taxa de entrega = 0)
        taxa = 0;
        $("#pedido_entrega").val(0);
        $("#taxa-faixa").html("R$ 0,00");

        // ✅ Calcular desconto de fidelidade
        var descontoFidelidade = 0;
        if (typeof temDescontoFidelidade !== 'undefined' && temDescontoFidelidade === true) {
            descontoFidelidade = parseFloat(totalCompra) * (percentualDescontoFidelidade / 100);
            descontoFidelidade = Math.round((descontoFidelidade + Number.EPSILON) * 100) / 100;
        }

        // Verificar forma de pagamento
        var formaPagamento = $("#forma-pagamento").val();
        console.log('[DEBUG RETIRAR LOCAL] Forma pagamento:', formaPagamento, 'Taxa atual:', taxa);

        // Se tinha cartão selecionado, recalcular com taxa de entrega = 0
        if (formaPagamento == 2 || formaPagamento == 3) {
            console.log('[DEBUG] Recalculando com atualizarTotal...');
            atualizarTotal(totalCompra);

            // Atualizar o total geral COM taxa de cartão E desconto de fidelidade
            var taxaCartaoAtualizada = parseFloat($("#taxa-cartao").val()) || 0;
            console.log('[DEBUG] Taxa cartão após atualizarTotal:', taxaCartaoAtualizada);
            var novoTotal = parseFloat(totalCompra) - descontoFidelidade + taxaCartaoAtualizada;
            $("#pedido_total").val(novoTotal.toFixed(2));
            $("#pedido-total").html(novoTotal.formatMoney());
            console.log('[DEBUG] Novo total:', novoTotal);
        } else {
            console.log('[DEBUG] Sem cartão, aplicando desconto fidelidade');
            // Se não é cartão, aplicar desconto de fidelidade: subtotal - desconto
            var novoTotal = parseFloat(totalCompra) - descontoFidelidade;
            $("#pedido_total").val(novoTotal.toFixed(2));
            $("#pedido-total").html(novoTotal.formatMoney());
        }

        if (local == -2) {
            $("#forma-pagamento-troco-bandeira").addClass("hide").hide();
            $("#btn-pedido-concluir").removeAttr("disabled");
            $("#troco-bandeira").val('');
        }
    } else {
        console.log('[DEBUG] Local não é retirar (local:', local, ')');
        // ✅ Calcular desconto de fidelidade para casos vazios/default
        var descontoFidelidade = 0;
        if (typeof temDescontoFidelidade !== 'undefined' && temDescontoFidelidade === true) {
            descontoFidelidade = parseFloat(totalCompra) * (percentualDescontoFidelidade / 100);
            descontoFidelidade = Math.round((descontoFidelidade + Number.EPSILON) * 100) / 100;

            // Atualizar display do desconto
            if ($('#desconto-fidelidade-valor').length) {
                $('#desconto-fidelidade-valor').html('- R$ ' + descontoFidelidade.toFixed(2).replace('.', ','));
                $('.desconto-fidelidade-linha').show();
            }
            if ($('#pedido_desconto_fidelidade').length) {
                $('#pedido_desconto_fidelidade').val(descontoFidelidade.toFixed(2));
            }
        }

        // Para outros casos (novo endereço, voltar para "Selecione uma opção..."), aplicar desconto ao total
        var novoTotal = parseFloat(totalCompra) - descontoFidelidade;
        $("#pedido_total").val(novoTotal.toFixed(2));
        $("#pedido-total").html(novoTotal.formatMoney());
    }

    if (local >= 0) {
        var bairro = $("#pedido_local option:selected").data("bairro");
        var prazo = $("#pedido_local option:selected").data("tempo");
        $("#pedido_entrega_prazo").val(prazo);
        if (bairro > 0) {
            $(".pedido_bairro").val(bairro);
            var url = baseUri + "/local/get_preco_entrega/";
            $.post(url, { bairro: bairro }).done(function(rs) {
                if (rs == "-1") {
                    $("#pedido_local").val("");
                    $("#btn-pedido-concluir").attr("disabled", "disabled");
                    return false;
                } else {
                    taxa = parseFloat(rs);
                    $("#pedido_entrega").val(taxa);
                }

                // ✅ Calcular desconto de fidelidade SEMPRE sobre o totalCompra original
                var descontoFidelidade = 0;
                if (typeof temDescontoFidelidade !== 'undefined' && temDescontoFidelidade === true) {
                    // Usar totalCompra (que é o subtotal dos produtos, sem taxa de entrega)
                    descontoFidelidade = parseFloat(totalCompra) * (percentualDescontoFidelidade / 100);
                    descontoFidelidade = Math.round((descontoFidelidade + Number.EPSILON) * 100) / 100;

                    // Atualizar display do desconto
                    if ($('#desconto-fidelidade-valor').length) {
                        $('#desconto-fidelidade-valor').html('- R$ ' + descontoFidelidade.toFixed(2).replace('.', ','));
                        $('.desconto-fidelidade-linha').show();
                    }
                    if ($('#pedido_desconto_fidelidade').length) {
                        $('#pedido_desconto_fidelidade').val(descontoFidelidade.toFixed(2));
                    }
                }

                // ✅ RECALCULAR TAXA DO CARTÃO quando mudar o endereço (e consequentemente a taxa de entrega)
                var formaPagamento = $("#forma-pagamento").val();
                if (formaPagamento == 2 || formaPagamento == 3) {
                    // Se já tem forma de pagamento de cartão selecionada, recalcular
                    atualizarTotal(totalCompra);

                    // Atualizar o total geral após recalcular a taxa do cartão
                    var taxaCartaoAtualizada = parseFloat($("#taxa-cartao").val()) || 0;
                    var novoTotal = parseFloat(totalCompra) - descontoFidelidade + parseFloat(taxa) + taxaCartaoAtualizada;
                    $("#pedido_total").val(novoTotal.toFixed(2));
                    $("#pedido-total").html(novoTotal.formatMoney());
                } else {
                    // Se não tem cartão, calcular: subtotal - desconto + taxa de entrega
                    total = parseFloat(totalCompra) - descontoFidelidade + parseFloat(taxa);
                    $("#pedido_total").val(total.toFixed(2));
                    $("#pedido_entrega").val(taxa);
                    $("#pedido-total").html(total.formatMoney());
                }

                $("#taxa-faixa").html(taxa.formatMoney());
            });
        }

        $("#pega-endereco").val(local);
        $("#pega-endereco2").val(local);
        $("#forma-pagamento").removeAttr("disabled");
        window.scroll_to = { start: function() {} };
        //scroll_to("forma-pagamento");

        $(window).load(function() {
            window.scroll_to.start("forma-pagamento");
        });
    } else {
        if (local != -2) {
            $("#forma-pagamento-troco-bandeira").addClass("hide").hide();
            $("#btn-pedido-concluir").attr("disabled", "disabled");
        }
        $("#forma-pagamento").attr("disabled", "disabled");
        $("#taxa-faixa").html("R$ 0,00");

        // ✅ Calcular desconto de fidelidade mesmo quando nenhum local está selecionado
        var descontoFidelidade = 0;
        if (typeof temDescontoFidelidade !== 'undefined' && temDescontoFidelidade === true) {
            descontoFidelidade = parseFloat(totalCompra) * (percentualDescontoFidelidade / 100);
            descontoFidelidade = Math.round((descontoFidelidade + Number.EPSILON) * 100) / 100;
        }

        var totalComDesconto = parseFloat(totalCompra) - descontoFidelidade;
        $("#pedido_total").val(totalComDesconto.toFixed(2));
        $("#pedido-total").html(totalComDesconto.formatMoney());

    }
});

$("#forma-pagamento").on("change", function() {

    window.scroll_to = { start: function() {} };
    //scroll_to("forma-pagamento");

    $(window).load(function() {
        window.scroll_to.start("tn-pedido-concluir");
    });

    // 1 Dinheiro (na entrega)
    // 2 Cartão de Débito (na entrega)
    // 3 Cartão de Crédito (na entrega)
    // 4 PIX
    // 7 Cartão de Crédito (Pagamento Online)

    //scroll_to("btn-pedido-concluir");
    var forma = $("#forma-pagamento").val();
    $("#troco-bandeira").attr('required', 'required');
    $("#troco-bandeira").attr("type", "text");
    $("#troco-bandeira").val("");
    $("#troco-bandeira").unmask();

    if (forma == 7) {
        $("#btn-pedido-concluir").addClass("hide");
        $("#btn-pedido-concluir").hide();
        $("#pagamento-online").removeClass("hide");
        $("#pagamento-online").show();
        $("#forma-pagamento-troco-bandeira").addClass("hide").hide();
        $("#taxa-cartao").html("R$ 0,00");
    }
    if (forma == 2 || forma == 3) {

        var cartao = $("#forma-pagamento option:selected").text();
        $("#troco-bandeira-label").html(
            "Informe a bandeira: (ex: Visa, Master, Elo...)"
        );
        $("#troco-bandeira").attr(
            "placeholder",
            "Informe a bandeira: Visa, Master, Elo..."
        );

        // NÃO mostrar automaticamente - deixar atualizarTotal() decidir
        // $(".cartaotx").show();

        atualizarTotal(totalCompra, faixasCartao);

        // ✅ RECALCULAR TOTAL GERAL após calcular taxa do cartão
        var taxaCartaoAtualizada = parseFloat($("#taxa-cartao").val()) || 0;
        var descontoFidelidade = 0;
        if (typeof temDescontoFidelidade !== 'undefined' && temDescontoFidelidade === true) {
            descontoFidelidade = parseFloat(totalCompra) * (percentualDescontoFidelidade / 100);
            descontoFidelidade = Math.round((descontoFidelidade + Number.EPSILON) * 100) / 100;
        }
        var novoTotal = parseFloat(totalCompra) - descontoFidelidade + parseFloat(taxa) + taxaCartaoAtualizada;
        $("#pedido_total").val(novoTotal.toFixed(2));
        $("#pedido-total").html(novoTotal.formatMoney());

        $("#forma-pagamento-troco-bandeira").removeClass("hide").show();
        $("#pagamento-online").hide();
        $("#btn-pedido-concluir").removeClass("hide");
        $("#btn-pedido-concluir").show();
    }

    if (forma == 4) {

        if ($("#taxa-cartao").val() != 0) {
            document.getElementById('pedido_taxa_cartao').value = '';
            $("#taxa-cartao").html("R$ 0,00");

            // ✅ Calcular desconto de fidelidade
            var descontoFidelidade = 0;
            if (typeof temDescontoFidelidade !== 'undefined' && temDescontoFidelidade === true) {
                descontoFidelidade = parseFloat(totalCompra) * (percentualDescontoFidelidade / 100);
                descontoFidelidade = Math.round((descontoFidelidade + Number.EPSILON) * 100) / 100;
            }

            total = parseFloat(totalCompra) - descontoFidelidade + parseFloat(taxa);
            $("#pedido_total").val(total);
            $("#pedido-total").html(total.formatMoney());
        }
        $(".cartaotx").hide();

        document.getElementById('pedido_taxa_cartao').value = '';
        $("#troco-pedido_taxa_cartao").val("0");
        $("#forma-pagamento-troco-bandeira").addClass("hide").hide();
        $("#troco-bandeira").removeAttr('required');
        $("#troco-bandeira").val("0");
        $("#pagamento-online").hide();
        $("#btn-pedido-concluir").removeClass("hide");
        $("#btn-pedido-concluir").show();
    }

    if (forma == 1) {

        // ✅ REMOVER TAXA DE CARTÃO PARA TODAS AS EMPRESAS
        atualizarTotal(totalCompra);

        // ✅ RECALCULAR TOTAL GERAL sem taxa de cartão
        var descontoFidelidade = 0;
        if (typeof temDescontoFidelidade !== 'undefined' && temDescontoFidelidade === true) {
            descontoFidelidade = parseFloat(totalCompra) * (percentualDescontoFidelidade / 100);
            descontoFidelidade = Math.round((descontoFidelidade + Number.EPSILON) * 100) / 100;
        }
        var novoTotal = parseFloat(totalCompra) - descontoFidelidade + parseFloat(taxa);
        $("#pedido_total").val(novoTotal.toFixed(2));
        $("#pedido-total").html(novoTotal.formatMoney());

        $(".cartaotx").hide();

        $("#troco-bandeira").attr("type", "tel");
        $("#troco-bandeira-label").html(
            'Troco para quanto? <button type="button" class="btn btn-link" id="sem-troco">Não preciso de troco</button>'
        );
        $("#troco-bandeira").attr("placeholder", "Troco para quanto?");
        $("#forma-pagamento-troco-bandeira").removeClass("hide").show();
        $("#pagamento-online").hide();
        $("#btn-pedido-concluir").removeClass("hide");
        $("#btn-pedido-concluir").show();
        $("#troco-bandeira").mask("#.##0,00", { reverse: true });
        $("#sem-troco").on("click", function() {
            $("#troco-bandeira").removeAttr('required');
            $("#troco-bandeira").val("0");
            $("#forma-pagamento-troco-bandeira").addClass("hide").hide();
        });
    }
    if (forma != "") {
        $("#btn-pedido-concluir").removeAttr("disabled");
        $("#troco-bandeira").focus();
    } else {
        // Verifica se local existe e não é -2 (delivery)
        if (typeof local !== 'undefined' && local != -2) {
            $("#btn-pedido-concluir").attr("disabled", "disabled");
            return false;
        }
    }
});

function calcularTaxa(totalCompra) {
    let valorBase = parseFloat(totalCompra);
    let taxaCartao = 0;

    faixasCartao.forEach(faixa => {

        let de = parseFloat(faixa.valor_de);
        let ate = parseFloat(faixa.valor_ate);
        if (valorBase >= de && valorBase <= ate) {
            taxaCartao = parseFloat(faixa.taxa);
        }
    });

    return taxaCartao;
}

function atualizarTotal(totalCompra) {

    let taxaCartao = 0;
    var forma = $("#forma-pagamento").val();

    // ✅ SÓ CALCULA TAXA SE FOR CARTÃO (forma 2 = débito, forma 3 = crédito)
    if (forma == 2 || forma == 3) {
        if (configTaxaCartao.config_taxa_tipo === 'taxa_por_item') {
            let total_itens = parseFloat(document.getElementById('total_itens').value) || 0;
            if(configTaxaCartao.config_taxa_valor){
                taxaCartao = total_itens * parseFloat(configTaxaCartao.config_taxa_valor);
                // força arredondamento em 2 casas
                taxaCartao = Math.round((taxaCartao + Number.EPSILON) * 100) / 100;
            }

        } else if (configTaxaCartao.config_taxa_tipo === 'taxa_por_categoria') {
            // Nova lógica para taxa por categoria
            if (typeof taxasPorCategoria !== 'undefined' && taxasPorCategoria && typeof carrinhoCategoria !== 'undefined') {
                // Usar dados diretos do carrinho PHP quando disponíveis
                let itensPorCategoria = carrinhoCategoria;

                // Calcular taxa para cada categoria
                for (let categoriaId in itensPorCategoria) {
                    if (taxasPorCategoria[categoriaId]) {
                        const taxaCategoria = parseFloat(taxasPorCategoria[categoriaId].taxa_valor) || 0;
                        const quantidadeCategoria = itensPorCategoria[categoriaId];
                        taxaCartao += taxaCategoria * quantidadeCategoria;
                    }
                }

                // força arredondamento em 2 casas
                taxaCartao = Math.round((taxaCartao + Number.EPSILON) * 100) / 100;
            }

        } else if (configTaxaCartao.config_taxa_tipo === 'faixa_valor') {
            taxaCartao = calcularTaxa(totalCompra, taxa);
        } else if (configTaxaCartao.config_taxa_tipo === 'percentual') {
            // converte JSON string para objeto
            let formasPagamento = typeof configTaxaCartao.config_taxa_formas_pagamento === 'string'
                ? JSON.parse(configTaxaCartao.config_taxa_formas_pagamento)
                : configTaxaCartao.config_taxa_formas_pagamento;

            if(formasPagamento){
                let percentual = formasPagamento[forma] || 0;

                if (empresa == 'dgustsalgados') {
                    // Taxa simples: percentual sobre o valor
                    taxaCartao = (parseFloat(totalCompra) + parseFloat(taxa)) * percentual / 100;
                } else {

                    let valorLiquido = parseFloat(totalCompra); // quanto você quer receber (ex: 22.99)
                    let taxaFixa = parseFloat(taxa);            // taxa fixa, se houver (ex: 0)
                    //let percentual = parseFloat(percentual);    // ex: 4.98

                    // Valor base que você precisa garantir
                    let valorBase = valorLiquido + taxaFixa;

                    // Calcula quanto o cliente deve pagar
                    let valorCobrar = valorBase / (1 - percentual / 100);

                    // Taxa do cartão
                    taxaCartao = valorCobrar - valorBase;

                    // Arredondamento para 2 casas
                    valorCobrar = Math.round((valorCobrar + Number.EPSILON) * 100) / 100;
                    taxaCartao  = Math.round((taxaCartao  + Number.EPSILON) * 100) / 100;
                }
            }
        }
    }

    $("#taxa-cartao").html("R$ " + taxaCartao.toFixed(2));
    $("#taxa-cartao").val(taxaCartao);
    document.getElementById('pedido_taxa_cartao').value = taxaCartao;

    // Mostrar/esconder taxa de cartão baseado no valor
    if (taxaCartao > 0) {
        $(".cartaotx").show();
    } else {
        $(".cartaotx").hide();
    }

    // ===== DESCONTO DE FIDELIDADE: A cada X pedidos, ganhe Y% de desconto =====
    let descontoFidelidade = 0;
    if (typeof temDescontoFidelidade !== 'undefined' && temDescontoFidelidade === true) {
        // Buscar percentual configurado (se não existir, usar 10% como padrão)
        let percentualDesconto = typeof percentualDescontoFidelidade !== 'undefined' ? percentualDescontoFidelidade : 10;

        // Aplicar desconto no subtotal (antes da taxa de entrega e cartão)
        descontoFidelidade = parseFloat(totalCompra) * (percentualDesconto / 100);
        descontoFidelidade = Math.round((descontoFidelidade + Number.EPSILON) * 100) / 100;

        // Atualizar display do desconto
        if ($('#desconto-fidelidade-valor').length) {
            $('#desconto-fidelidade-valor').html('- R$ ' + descontoFidelidade.toFixed(2).replace('.', ','));
            $('.desconto-fidelidade-linha').show();
        }

        // Guardar valor do desconto
        if ($('#pedido_desconto_fidelidade').length) {
            document.getElementById('pedido_desconto_fidelidade').value = descontoFidelidade;
        }
    } else {
        // Esconder linha de desconto se não tiver
        if ($('.desconto-fidelidade-linha').length) {
            $('.desconto-fidelidade-linha').hide();
        }
    }

    // Calcular total final: subtotal - desconto fidelidade + taxa entrega + taxa cartão
    let total = parseFloat(totalCompra) - descontoFidelidade + parseFloat(taxa) + taxaCartao;
    $("#pedido_total").val(total);
    $("#pedido-total").html(total.formatMoney());
}

function validaPagamento() {
    var start = performance.now();

    var forma = $("#forma-pagamento").val();
    var troco_bandeira = $("#troco-bandeira").val();
    var pagto = "";

    if (forma == "") {
        if (typeof local !== 'undefined' && local != -2) {
            $("#troco-bandeira").focus();
            return false;
        }
    } else {
        if (forma == 1) {
            var troco_bandeira = parseFloat(
                $("#troco-bandeira").val().replace(",", ".")
            );
            var pedido_total = parseFloat(
                $("#pedido_total").val().replace(",", ".")
            );
            if (troco_bandeira > 0 && troco_bandeira < pedido_total) {
                alert("Valor informado inferior ao valor total!");
                $("#troco-bandeira").focus();
                return false;
            }
            pagto = "Pagto em Dinheiro";
            if (troco_bandeira > 0) {
                pagto += " - Troco para " + parseFloat(troco_bandeira).formatMoney();
                // Calcula o troco a devolver (valor pago - total)
                var trocoDevolver = troco_bandeira - pedido_total;
                if (trocoDevolver > 0) {
                    $("#pedido_troco").val(trocoDevolver.toFixed(2));
                }
            }
        }
        if (forma == 2) {
            pagto = "Pagto com Cartão de Débito: ";
        }
        if (forma == 3) {
            pagto = "Pagto com Cartão de Crédito: ";
        }
        if (forma == 4) {
            pagto = "Pagto via pix";
        }
    }
    $("#pedido_obs_pagto").val(pagto);

    // Desabilita o botão SUBMIT corretamente
    var $btn = $("#form-pedido").find('button[type="submit"], input[type="submit"]');
    $btn.text("Aguarde...").prop("disabled", true);

    return true;
}

// ===== FUNÇÕES GLOBAIS (fora do document.ready) =====
function rebind_reload() {
    var url = baseUri + "/carrinho/reload/";
    $.post(url, {}, function(data) {
        $("#carrinho-lista").html(data);
    }).then(function() {
        setTimeout(function() {
            rebind_add();
            rebind_del();
            rebind_get_count();
            rebind_get_count_bag();
            $('[data-toggle="tooltip"]').tooltip();
        }, 500)
    });
}

function rebind_add() {
    $(".add-more").on("click", function() {
        var id = parseInt($(this).data("id"));
        var hash = $(this).data("hash");
        var estoque = parseInt($(this).data("estoque"));
        var url = baseUri + "/carrinho/add_more/";

        $("#controleAddDel" + id).addClass("disabled");

        $.post(url, { id: id, estoque: estoque, hash: hash }, function(rs) {
            if (rs == '-1') {
                $('.item-estoque-' + hash).html('Quantidade indisponível!');
            } else {
                rebind_reload();
            }
        });
    });
}

function rebind_del() {
    $(".del-more").on("click", function() {
        var id = parseInt($(this).data("id"));
        var hash = $(this).data("hash");
        var url = baseUri + "/carrinho/del_more/";

        $("#controleAddMore" + id).addClass("disabled");

        $.post(url, { id: id, hash: hash }, function() {
            rebind_reload();
        });
    });
}

function rebind_scroll() {
    $(".scroll-to-up").on("click", function() {
        scroll_to("topo");
    });
}

function rebind_get_count() {
    var url = baseUri + "/carrinho/get_count_js/";
    $.post(url, {}, function(rs) {
        $("#cart-count").html(rs);
    });
}

function rebind_get_count_bag() {
    var url = baseUri + "/carrinho/get_count_bag/";
    $.post(url, {}, function(rs) {
        $("#count_bag").html(rs);
    });
}

Number.prototype.formatMoney = function(places, symbol, thousand, decimal) {
    places = !isNaN((places = Math.abs(places))) ? places : 2;
    symbol = symbol !== undefined ? symbol : "R$ ";
    thousand = thousand || ".";
    decimal = decimal || ",";
    var number = this,
        negative = number < 0 ? "-" : "",
        i =
        parseInt((number = Math.abs(+number || 0).toFixed(places)), 10) +
        "",
        j = (j = i.length) > 3 ? j % 3 : 0;
    return (
        symbol +
        negative +
        (j ? i.substr(0, j) + thousand : "") +
        i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) +
        (places ?
            decimal +
            Math.abs(number - i)
            .toFixed(places)
            .slice(2) :
            "")
    );
};

/**
 * Add "Pedir Novamente" item directly to cart with exact configuration
 * Fetches the last order configuration from server and replicates it
 */
function addPedirNovamenteToCart(itemId, listaId) {
    if (!listaId) {
        alert('Erro: Configuração do pedido não encontrada.');
        return;
    }

    try {
        // Fetch the exact configuration from the last order
        const url = baseUri + `/index/get_lista_item_config?lista_id=${listaId}`;

        $.get(url, function(config) {
            if (config.error) {
                alert('Erro ao buscar configuração do pedido.');
                return;
            }

            // Prepare cart data using the exact configuration from server
            // Use item_preco (base price) instead of lista_opcao_preco (which is total)
            const basePreco = parseFloat(config.item_preco) || 0;

            // Calculate extras total from lista_opcao_vals
            let extrasTotal = 0;
            if (config.lista_opcao_vals) {
                const vals = config.lista_opcao_vals.split(',').filter(v => v.trim());
                vals.forEach(val => {
                    const v = parseFloat(val.trim());
                    if (!isNaN(v)) {
                        extrasTotal += v;
                    }
                });
            }

            const itemPreco = basePreco;
            const totalPreco = basePreco + extrasTotal;

            const dados = {
                item_id: config.lista_item,
                item_estoque: 999, // High number to bypass stock check
                item_codigo: config.item_codigo || '',
                item_nome: config.item_nome,
                categoria_nome: config.categoria_nome,
                categoria_id: config.categoria_id,
                item_obs: config.lista_item_obs || '',
                item_preco: itemPreco,
                extra: config.lista_opcao || '',
                extra_vals: config.lista_opcao_vals || '',
                extra_preco: extrasTotal,
                total: totalPreco,
            };

            // Add to cart via AJAX
            const addUrl = baseUri + "/carrinho/add/";
            $.post(addUrl, dados, function(response) {
                // Success
            }).done(function() {
                // Reload cart display
                rebind_reload();

                // Show cart modal
                setTimeout(function() {
                    $("#modal-carrinho").modal("show");
                    sound();
                }, 500);
            }).fail(function(xhr, status, error) {
                alert('Erro ao adicionar item ao carrinho.');
            });

        }).fail(function(xhr, status, error) {
            alert('Erro ao buscar configuração do pedido.');
        });

    } catch (e) {
        alert('Erro ao processar pedido: ' + e.message);
    }
}

// Expose function globally for use in pedir-novamente.php
window.addPedirNovamenteToCart = addPedirNovamenteToCart;
