<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venda Rápida - PDV</title>

    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet'>
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery.select2/dist/css/select2.css" />

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Open Sans', sans-serif; background: #f5f5f5; overflow: hidden; }

        /* LAYOUT PRINCIPAL - Tela dividida */
        .pdv-container { display: flex; height: 100vh; }
        .pdv-left { flex: 1; display: flex; flex-direction: column; background: #fff; border-right: 2px solid #e0e0e0; }
        .pdv-right { width: 420px; background: #fafafa; display: flex; flex-direction: column; box-shadow: -3px 0 10px rgba(0,0,0,0.05); }

        /* HEADER */
        .pdv-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .pdv-header h1 { font-size: 20px; font-weight: 600; margin: 0; }
        .pdv-header .btn { background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 13px; transition: all .2s; }
        .pdv-header .btn:hover { background: rgba(255,255,255,0.3); transform: translateY(-1px); }

        /* BUSCA + FILTROS */
        .pdv-toolbar { padding: 16px 20px; background: #fff; border-bottom: 1px solid #e0e0e0; }
        .search-box { position: relative; margin-bottom: 12px; }
        .search-box input { width: 100%; padding: 12px 45px 12px 16px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 15px; transition: all .2s; }
        .search-box input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.1); }
        .search-box .search-icon { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); color: #999; font-size: 18px; }
        .category-pills { display: flex; gap: 8px; flex-wrap: wrap; }
        .category-pill { padding: 8px 16px; background: #f5f5f5; border: 2px solid #e0e0e0; border-radius: 20px; font-size: 13px; font-weight: 600; color: #666; cursor: pointer; transition: all .2s; white-space: nowrap; }
        .category-pill:hover { background: #e8eaf6; border-color: #667eea; color: #667eea; }
        .category-pill.active { background: #667eea; border-color: #667eea; color: #fff; }

        /* GRID DE PRODUTOS */
        .produtos-grid { flex: 1; overflow-y: auto; padding: 20px; display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 16px; align-content: start; }
        .produto-card { background: #fff; border: 2px solid #e0e0e0; border-radius: 12px; padding: 12px; cursor: pointer; transition: all .2s; position: relative; text-align: center; }
        .produto-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.1); border-color: #667eea; }
        .produto-card.esgotado { opacity: 0.5; cursor: not-allowed; }
        .produto-card .produto-img { width: 100%; height: 120px; object-fit: cover; border-radius: 8px; margin-bottom: 10px; background: #f5f5f5; }
        .produto-card .produto-nome { font-size: 13px; font-weight: 600; color: #333; margin-bottom: 6px; line-height: 1.3; min-height: 34px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .produto-card .produto-preco { font-size: 16px; font-weight: 700; color: #28a745; }
        .produto-card .badge-esgotado { position: absolute; top: 8px; right: 8px; background: #dc3545; color: #fff; font-size: 10px; padding: 4px 8px; border-radius: 4px; font-weight: 600; }
        .produto-card .btn-add-rapido { position: absolute; bottom: 8px; right: 8px; width: 32px; height: 32px; background: #28a745; color: #fff; border: none; border-radius: 50%; font-size: 16px; opacity: 0; transition: all .2s; display: flex; align-items: center; justify-content: center; }
        .produto-card:hover .btn-add-rapido { opacity: 1; }

        /* CARRINHO LATERAL */
        .carrinho-header { background: #fff; padding: 20px; border-bottom: 2px solid #e0e0e0; }
        .carrinho-header h2 { font-size: 18px; font-weight: 700; color: #333; margin: 0 0 8px 0; display: flex; align-items: center; gap: 10px; }
        .carrinho-header .badge-itens { background: #667eea; color: #fff; font-size: 12px; padding: 4px 10px; border-radius: 12px; }
        .cliente-info { background: #f8f9fa; padding: 12px; border-radius: 8px; font-size: 13px; margin-top: 12px; }
        .cliente-info strong { color: #667eea; }
        .btn-trocar-cliente { font-size: 11px; color: #667eea; cursor: pointer; text-decoration: underline; margin-left: 8px; }

        .carrinho-itens { flex: 1; overflow-y: auto; padding: 16px; }
        .carrinho-vazio { text-align: center; padding: 60px 20px; color: #999; }
        .carrinho-vazio i { font-size: 64px; margin-bottom: 16px; opacity: 0.3; }
        .carrinho-item { background: #fff; border: 2px solid #e0e0e0; border-radius: 10px; padding: 12px; margin-bottom: 12px; position: relative; }
        .carrinho-item .item-nome { font-size: 13px; font-weight: 600; color: #333; margin-bottom: 4px; }
        .carrinho-item .item-extras { font-size: 11px; color: #666; margin-bottom: 8px; line-height: 1.4; }
        .carrinho-item .item-footer { display: flex; justify-content: space-between; align-items: center; }
        .carrinho-item .item-preco { font-size: 15px; font-weight: 700; color: #28a745; }
        .carrinho-item .item-qtd { display: flex; align-items: center; gap: 8px; }
        .carrinho-item .btn-qtd { width: 28px; height: 28px; border: 2px solid #e0e0e0; background: #fff; border-radius: 6px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all .2s; display: flex; align-items: center; justify-content: center; }
        .carrinho-item .btn-qtd:hover { background: #667eea; color: #fff; border-color: #667eea; }
        .carrinho-item .qtd-num { font-size: 14px; font-weight: 600; min-width: 24px; text-align: center; }
        .carrinho-item .btn-remover { position: absolute; top: 8px; right: 8px; color: #dc3545; cursor: pointer; font-size: 16px; }

        .carrinho-footer { background: #fff; padding: 20px; border-top: 2px solid #e0e0e0; }
        .total-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; font-size: 14px; }
        .total-row.total-final { font-size: 20px; font-weight: 700; color: #333; padding-top: 12px; border-top: 2px solid #e0e0e0; }
        .total-row.total-final .valor { color: #28a745; }
        .btn-finalizar { width: 100%; padding: 16px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: #fff; border: none; border-radius: 10px; font-size: 16px; font-weight: 700; cursor: pointer; transition: all .2s; box-shadow: 0 4px 12px rgba(40,167,69,0.3); }
        .btn-finalizar:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(40,167,69,0.4); }
        .btn-finalizar:disabled { opacity: 0.5; cursor: not-allowed; }
        .btn-limpar { width: 100%; padding: 12px; background: #fff; color: #dc3545; border: 2px solid #dc3545; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; margin-top: 10px; transition: all .2s; }
        .btn-limpar:hover { background: #dc3545; color: #fff; }

        /* MODAL CLIENTE */
        .modal-cliente { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); display: none; align-items: center; justify-content: center; z-index: 9999; padding: 20px; }
        .modal-cliente.show { display: flex; }
        .modal-cliente-content { background: #fff; border-radius: 16px; padding: 32px; width: 90%; max-width: 500px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); margin: auto; position: relative; }
        .modal-cliente h3 { margin: 0 0 24px 0; font-size: 22px; color: #333; text-align: center !important; }
        .modal-cliente h3 i { margin-right: 8px; }
        .modal-cliente .form-group { margin-bottom: 20px; text-align: center; }
        .modal-cliente label { display: block; margin: 0 auto 8px auto; font-weight: 600; color: #555; font-size: 13px; text-align: center !important; }
        .modal-cliente select, .modal-cliente input { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; margin: 0 auto; display: block; }
        .modal-cliente .btn-group { display: flex; gap: 12px; margin-top: 24px; justify-content: center; }
        .modal-cliente .btn { flex: 1; padding: 14px; border: none; border-radius: 8px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all .2s; }
        .modal-cliente .btn-primary { background: #667eea; color: #fff; }
        .modal-cliente .btn-secondary { background: #e0e0e0; color: #666; }
        .modal-cliente .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .modal-cliente a { text-align: center !important; display: block; margin: 0 auto 16px auto; color: #667eea; font-size: 13px; text-decoration: none; }
        .modal-cliente a i { margin-right: 5px; }
        .modal-cliente a:hover { text-decoration: underline; }
        /* Força centralização e posicionamento correto do Select2 */
        .modal-cliente .select2-container { margin: 0 auto; display: block; width: 100% !important; }
        .modal-cliente .select2-selection { text-align: left; }
        .select2-container--open { z-index: 99999 !important; }
        .select2-dropdown { z-index: 99999 !important; }

        /* MODAL CHECKOUT */
        .modal-checkout {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            padding: 20px;
        }
        .modal-checkout.show { display: flex !important; }
        .modal-checkout-content {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
            position: relative;
            margin: auto;
        }
        .modal-checkout h3 { margin: 0 0 30px 0; font-size: 24px; color: #333; text-align: center; }
        .modal-checkout h3 i { margin-right: 10px; color: #667eea; }
        .btn-fechar-modal { position: absolute; top: 15px; right: 15px; width: 36px; height: 36px; border: none; background: #f5f5f5; color: #666; border-radius: 50%; font-size: 18px; cursor: pointer; transition: all .2s; }
        .btn-fechar-modal:hover { background: #dc3545; color: #fff; transform: rotate(90deg); }
        .checkout-section { margin-bottom: 24px; }
        .checkout-section h4 { font-size: 15px; font-weight: 600; color: #555; margin-bottom: 10px; }
        .checkout-section h4 i { margin-right: 8px; color: #667eea; }
        .checkout-section .form-control { border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px; transition: all .2s; color: #333; background: #fff; }
        .checkout-section .form-control:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.1); }
        .checkout-section select.form-control { color: #999 !important; background: #fff !important; }
        .checkout-section select.form-control option { color: #333 !important; background: #fff !important; }
        .checkout-section select.form-control:focus { color: #333 !important; }
        .checkout-section select.form-control:valid { color: #333 !important; }
        .checkout-section input[type="number"] { color: #333 !important; background: #fff !important; padding: 10px; font-size: 16px; }
        .checkout-section input[type="number"]:focus { border-color: #28a745 !important; box-shadow: 0 0 0 3px rgba(40,167,69,0.15); }
        .checkout-section label { font-weight: 600; color: #555; margin-bottom: 6px; display: block; }
        #semTroco { padding: 5px 10px; font-size: 12px; color: #667eea; background: none; border: 1px solid #667eea; border-radius: 6px; margin-top: 8px; cursor: pointer; transition: all .2s; }
        #semTroco:hover { background: #667eea; color: #fff; }
        .checkout-resumo { background: #f8f9fa; padding: 20px; border-radius: 12px; margin-bottom: 20px; }
        .resumo-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; color: #666; }
        .resumo-row.resumo-total { font-size: 20px; font-weight: 700; color: #333; padding-top: 12px; border-top: 2px solid #e0e0e0; margin-top: 12px; }
        .resumo-row.resumo-total span:last-child { color: #28a745; }
        .btn-confirmar-venda { width: 100%; padding: 16px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: #fff; border: none; border-radius: 10px; font-size: 16px; font-weight: 700; cursor: pointer; transition: all .2s; box-shadow: 0 4px 12px rgba(40,167,69,0.3); }
        .btn-confirmar-venda:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(40,167,69,0.4); }
        .btn-confirmar-venda:disabled { opacity: 0.5; cursor: not-allowed; }

        /* SCROLLBAR */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #999; }

        /* RESPONSIVO */
        @media (max-width: 1200px) {
            .produtos-grid { grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); }
            .pdv-right { width: 360px; }
        }
    </style>
</head>
<body>
    <!-- MODAL NOVO ENDEREÇO -->
    <div class="modal-cliente" id="modalNovoEndereco">
        <div class="modal-cliente-content" style="max-width: 700px;">
            <h3><i class="fa fa-map-marker"></i> Cadastrar Novo Endereço</h3>
            <form id="formNovoEndereco" autocomplete="off">
                <input type="hidden" name="endereco_cliente" id="endereco_cliente" value="">
                <input type="hidden" name="endereco_cidade" id="novo_endereco_cidade" value="">
                <input type="hidden" name="endereco_bairro_id" id="novo_endereco_bairro_id" value="">
                <input type="hidden" name="endereco_lat" id="novo_endereco_lat" value="">
                <input type="hidden" name="endereco_lng" id="novo_endereco_lng" value="">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Local / Apelido
                                <small style="float: right; color: #999;">
                                    <i class="fa fa-info-circle"></i> Ex: Casa da Praia, Escritório...
                                </small>
                            </label>
                            <input type="text" name="endereco_nome" id="novo_endereco_nome" class="form-control" placeholder="ex: Casa, Escritório, Praia" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Bairro <span class="pull-right text-danger" style="font-size: 11px;">* obrigatório</span></label>
                            <select name="endereco_bairro" id="novo_endereco_bairro" class="form-control" required>
                                <option value="">Bairros atendidos ...</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Endereço <span class="pull-right text-danger" style="font-size: 11px;">* obrigatório</span></label>
                            <input type="text" name="endereco_endereco" id="novo_endereco_endereco" class="form-control" placeholder="Ex: Avenida Souza" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Número <span class="pull-right text-danger" style="font-size: 11px;">* obrigatório</span></label>
                            <input type="number" name="endereco_numero" id="novo_endereco_numero" class="form-control" placeholder="Ex: 600" min="1" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Complemento</label>
                            <input type="text" name="endereco_complemento" id="novo_endereco_complemento" class="form-control" placeholder="Ex: Bloco 5 - Apto 33">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Referência</label>
                            <input type="text" name="endereco_referencia" id="novo_endereco_referencia" class="form-control" placeholder="Ex: Hospital Central">
                        </div>
                    </div>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-secondary" onclick="fecharModalNovoEndereco()">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnSalvarEndereco">
                        <i class="fa fa-check"></i> Cadastrar Endereço
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL NOVO CLIENTE -->
    <div class="modal-cliente" id="modalNovoCliente">
        <div class="modal-cliente-content" style="max-width: 500px;">
            <h3><i class="fa fa-user-plus"></i> Cadastrar Novo Cliente</h3>
            <form id="formNovoCliente" autocomplete="off">
                <div class="form-group">
                    <label>Nome <span class="pull-right text-muted" style="font-size: 11px;">* obrigatório</span></label>
                    <input type="text" name="cliente_nome" id="novo_cliente_nome" class="form-control" placeholder="Informe seu nome" required>
                </div>

                <div class="form-group">
                    <label>Celular <span class="pull-right text-muted" style="font-size: 11px;">* obrigatório</span></label>
                    <input type="text" name="cliente_fone2" id="novo_cliente_fone2" class="form-control" placeholder="(99) 99999-9999" required>
                    <small class="text-danger" id="fone_existe" style="display: none;">Telefone já cadastrado!</small>
                </div>

                <!-- Senha padrão será gerada automaticamente pelo sistema -->
                <input type="hidden" name="cliente_senha" id="novo_cliente_senha" value="123456">

                <div class="btn-group">
                    <button type="button" class="btn btn-secondary" onclick="fecharModalNovoCliente()">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnSalvarCliente">
                        <i class="fa fa-check"></i> Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL SELECIONAR CLIENTE -->
    <div class="modal-cliente" id="modalCliente">
        <div class="modal-cliente-content">
            <h3><i class="fa fa-user"></i> Selecionar Cliente</h3>
            <div class="form-group">
                <label>Cliente</label>
                <select class="form-control" id="selectCliente">
                    <option value="">Digite para buscar...</option>
                    <?php if (isset($data['cliente'][0])) : ?>
                        <?php foreach ($data['cliente'] as $r) : ?>
                            <option value="<?= $r->cliente_id ?>" data-nome="<?= $r->cliente_nome ?>" data-fone="<?= $r->cliente_fone2 ?>">
                                <?= $r->cliente_nome ?> | <?= $r->cliente_fone2 ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <a href="#" onclick="abrirModalNovoCliente(); return false;">
                <i class="fa fa-plus-circle"></i> Cadastrar novo cliente
            </a>
            <div class="btn-group">
                <button class="btn btn-secondary" onclick="fecharModalCliente()">Cancelar</button>
                <button class="btn btn-primary" onclick="selecionarCliente()">Confirmar</button>
            </div>
        </div>
    </div>

    <!-- MODAL FINALIZAR VENDA -->
    <div class="modal-checkout" id="modalCheckout">
        <div class="modal-checkout-content">
            <button class="btn-fechar-modal" onclick="fecharModalCheckout()">
                <i class="fa fa-times"></i>
            </button>

            <h3><i class="fa fa-check-circle"></i> Finalizar Venda</h3>

            <div class="checkout-section">
                <h4><i class="fa fa-map-marker"></i> Onde deseja receber seu pedido?</h4>
                <select class="form-control" name="pedido_local" id="checkoutLocal" required>
                    <option value="" data-cep="" data-bairro="" selected>Selecione uma opção...</option>
                    <!-- Opções serão carregadas via AJAX após selecionar o cliente -->
                </select>
            </div>

            <div class="checkout-section">
                <h4><i class="fa fa-credit-card"></i> Forma de pagamento</h4>
                <select class="form-control" id="checkoutPagamento" disabled required>
                    <option value="">Selecione uma opção...</option>
                    <option value="1">Dinheiro (na entrega)</option>
                    <option value="2">Cartão de Débito (na entrega)</option>
                    <option value="3">Cartão de Crédito (na entrega)</option>
                    <?php if (isset($data['config']->config_pix) && $data['config']->config_pix == 1) : ?>
                        <option value="4">PIX</option>
                    <?php endif; ?>
                </select>
            </div>

            <!-- Campo de troco/bandeira (aparece dinamicamente) -->
            <div class="checkout-section" id="trocoBandeiraSection" style="display: none;">
                <label id="trocoBandeiraLabel">Troco para quanto?</label>
                <input type="text" id="trocoBandeira" class="form-control" placeholder="Ex: R$ 50,00">
                <button type="button" id="semTroco" class="btn btn-link" style="padding: 5px 0; display: none;">
                    Não preciso de troco
                </button>
            </div>

            <div class="checkout-section">
                <h4><i class="fa fa-comment"></i> Observações</h4>


                <?php if ($_SESSION['base_delivery'] == 'dgustsalgados') { ?>
                    <h5><b>Horário desejado?</b></h5>
                    <textarea class="form-control" id="checkoutObs" rows="3" placeholder="Ex: entregar as 19h ou vour retiar as 18h etc..."></textarea>
                <?php } else { ?>
                    <h5><b>Alguma observação?</b></h5>
                    <textarea class="form-control" id="checkoutObs" rows="3" placeholder="Ex: tirar cebola, maionese à parte..."></textarea>
                <?php } ?>
            </div>

            <div class="checkout-resumo">
                <div class="resumo-row">
                    <span>Subtotal:</span>
                    <span id="resumoSubtotal">R$ 0,00</span>
                </div>
                <div class="resumo-row" id="resumoEntregaRow" style="display: none;">
                    <span>Taxa de entrega:</span>
                    <span id="resumoEntrega">R$ 0,00</span>
                </div>
                <div class="resumo-row" id="resumoTaxaCartaoRow" style="display: none;">
                    <span>Taxa cartão:</span>
                    <span id="resumoTaxaCartao">R$ 0,00</span>
                </div>
                <div class="resumo-row resumo-total">
                    <span>TOTAL:</span>
                    <span id="resumoTotal">R$ 0,00</span>
                </div>
            </div>

            <button class="btn-confirmar-venda" id="btnConfirmarVenda" onclick="confirmarVenda()" disabled>
                <i class="fa fa-check"></i> Confirmar Venda
            </button>
        </div>
    </div>

    <div class="pdv-container">
        <!-- LADO ESQUERDO: PRODUTOS -->
        <div class="pdv-left">
            <div class="pdv-header">
                <h1><i class="fa fa-shopping-cart"></i> Venda Rápida - PDV</h1>
                <a href="<?php echo $baseUri; ?>/admin/pedidos" class="btn">
                    <i class="fa fa-list"></i> Ver Pedidos
                </a>
            </div>

            <div class="pdv-toolbar">
                <div class="search-box">
                    <input type="text" id="searchProduto" placeholder="Buscar produto... (digite o nome ou código)">
                    <i class="fa fa-search search-icon"></i>
                </div>
                <div class="category-pills" id="categoryPills">
                    <div class="category-pill active" data-cat="todos">Todos</div>
                    <!-- Categorias serão inseridas via PHP/JS -->
                </div>
            </div>

            <div class="produtos-grid" id="produtosGrid">
                <!-- Produtos serão inseridos aqui -->
            </div>
        </div>

        <!-- LADO DIREITO: CARRINHO -->
        <div class="pdv-right">
            <div class="carrinho-header">
                <h2>
                    <i class="fa fa-shopping-bag"></i> Carrinho
                    <span class="badge-itens" id="badgeItens">0</span>
                </h2>
                <div class="cliente-info" id="clienteInfo">
                    <i class="fa fa-user"></i>
                    <strong>Nenhum cliente selecionado</strong>
                    <span class="btn-trocar-cliente" onclick="abrirModalCliente()">selecionar</span>
                </div>
            </div>

            <div class="carrinho-itens" id="carrinhoItens">
                <div class="carrinho-vazio">
                    <i class="fa fa-shopping-cart"></i>
                    <p>Carrinho vazio<br><small>Adicione produtos para começar</small></p>
                </div>
            </div>

            <div class="carrinho-footer">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span id="subtotal">R$ 0,00</span>
                </div>
                <div class="total-row total-final">
                    <span>TOTAL:</span>
                    <span class="valor" id="total">R$ 0,00</span>
                </div>
                <button class="btn-finalizar" id="btnFinalizar" disabled>
                    <i class="fa fa-check-circle"></i> Finalizar Venda
                </button>
                <button class="btn-limpar" id="btnLimpar" onclick="limparCarrinho()">
                    <i class="fa fa-trash"></i> Limpar Carrinho
                </button>
            </div>
        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="js/jquery.select2/dist/js/select2.js"></script>
    <script src="js/jquery.gritter/js/jquery.gritter.js"></script>
    <script src="js/jquery.maskedinput/jquery.maskedinput.js"></script>

    <script>
        const baseUri = '<?= $baseUri ?>';
        let clienteSelecionado = null;
        let carrinho = [];
        let produtos = [];
        let categorias = [];
        let taxaCartao = 0; // Variável global para taxa de cartão

        // Configuração de taxas de cartão (passadas do PHP)
        const faixasCartao = <?php echo json_encode($data['faixasCartao'] ?? []); ?>;
        const configTaxaCartao = <?php echo json_encode($data['config']); ?>;

        // Inicializar Select2
        $(document).ready(function() {
            $('#selectCliente').select2({
                width: '100%',
                placeholder: 'Digite para buscar...',
                dropdownParent: $('#modalCliente')
            });

            // Inicializar máscara do celular
            $('#novo_cliente_fone2').mask('(99) 99999-9999');

            // Validar telefone já cadastrado
            $('#novo_cliente_fone2').on('blur', function() {
                const fone = $(this).val();
                if (fone.length >= 14) {
                    // Validar se não é número inválido (repetidos ou sequenciais)
                    const apenasNumeros = fone.replace(/\D/g, '');

                    // Verificar se tem todos dígitos iguais (ex: 11111111111, 85999999999)
                    const todosIguais = /^(\d)\1+$/.test(apenasNumeros);

                    // Verificar se os últimos 8 ou 9 dígitos são iguais (ex: 85999999999, 8599999999)
                    const ultimosIguais = /\d(\d)\1{7,}$/.test(apenasNumeros);

                    // Padrões inválidos conhecidos
                    const padrõesInvalidos = [
                        '00000000000', '11111111111', '22222222222', '33333333333',
                        '44444444444', '55555555555', '66666666666', '77777777777',
                        '88888888888', '99999999999', '12345678901', '01234567890'
                    ];

                    // Verificar se DDD + números repetidos (ex: 85999999999, 11888888888)
                    const dddComRepetidos = /^\d{2}(\d)\1{8,}$/.test(apenasNumeros);

                    if (todosIguais || ultimosIguais || dddComRepetidos || padrõesInvalidos.includes(apenasNumeros)) {
                        $('#fone_existe').text('Número de telefone inválido!').show();
                        $('#btnSalvarCliente').prop('disabled', true);
                        return;
                    }

                    // Verificar se já existe no banco
                    $.post(baseUri + '/cadastro/exists/', { fone: fone }, function(response) {
                        if (response == '1') {
                            $('#fone_existe').text('Telefone já cadastrado!').show();
                            $('#btnSalvarCliente').prop('disabled', true);
                        } else {
                            $('#fone_existe').hide();
                            $('#btnSalvarCliente').prop('disabled', false);
                        }
                    });
                }
            });

            // Submeter formulário de novo cliente
            $('#formNovoCliente').on('submit', function(e) {
                e.preventDefault();
                salvarNovoCliente();
            });

            // Submeter formulário de novo endereço
            $('#formNovoEndereco').on('submit', function(e) {
                e.preventDefault();
                salvarNovoEndereco();
            });

            // Detectar mudança de bairro para pegar cidade e ID
            $('#novo_endereco_bairro').on('change', function() {
                const option = $(this).find('option:selected');
                $('#novo_endereco_cidade').val(option.data('cidade') || '');
                $('#novo_endereco_bairro_id').val(option.data('bairro') || '');
            });

            // Mostrar modal de cliente ao carregar
            abrirModalCliente();

            // Carregar dados
            carregarProdutos();
            carregarCarrinho();
        });

        function abrirModalCliente() {
            $('#modalCliente').addClass('show');
        }

        function fecharModalCliente() {
            if (!clienteSelecionado) {
                if (!confirm('Deseja sair do PDV?')) return;
                window.location.href = baseUri + '/admin';
            }
            $('#modalCliente').removeClass('show');
        }

        //===============================================
        // FUNÇÕES DO MODAL NOVO ENDEREÇO
        //===============================================

        function abrirModalNovoEndereco() {
            if (!clienteSelecionado) {
                alert('Selecione um cliente primeiro');
                return;
            }

            // Limpar formulário
            $('#formNovoEndereco')[0].reset();
            $('#endereco_cliente').val(clienteSelecionado.id);

            // Carregar bairros
            carregarBairros();

            // Fechar modal de checkout e abrir modal de endereço
            $('#modalCheckout').removeClass('show');
            $('#modalNovoEndereco').addClass('show');

            // Foco no primeiro campo
            setTimeout(function() {
                $('#novo_endereco_nome').focus();
            }, 100);
        }

        function fecharModalNovoEndereco() {
            $('#modalNovoEndereco').removeClass('show');
            // Reabrir modal de checkout
            $('#modalCheckout').addClass('show');
        }

        function carregarBairros() {
            $.ajax({
                url: baseUri + '/admin/get_bairros_json',
                type: 'GET',
                dataType: 'json',
                success: function(bairros) {
                    $('#novo_endereco_bairro').html('<option value="">Bairros atendidos ...</option>');

                    if (bairros && bairros.length > 0) {
                        bairros.forEach(function(bairro) {
                            const option = $('<option></option>')
                                .val(bairro.bairro_nome)
                                .attr('data-cidade', bairro.bairro_cidade)
                                .attr('data-bairro', bairro.bairro_id)
                                .text(bairro.bairro_nome + ' - ' + bairro.bairro_cidade);
                            $('#novo_endereco_bairro').append(option);
                        });
                    }
                },
                error: function() {
                    console.error('Erro ao carregar bairros');
                }
            });
        }

        function salvarNovoEndereco() {
            // Validações
            const nome = $('#novo_endereco_nome').val().trim();
            const bairro = $('#novo_endereco_bairro').val().trim();
            const endereco = $('#novo_endereco_endereco').val().trim();
            const numero = $('#novo_endereco_numero').val().trim();

            if (!nome) {
                $.gritter.add({
                    title: 'Atenção',
                    text: 'Informe o local/apelido do endereço',
                    class_name: 'warning',
                    time: 2000
                });
                $('#novo_endereco_nome').focus();
                return;
            }

            if (!bairro) {
                $.gritter.add({
                    title: 'Atenção',
                    text: 'Selecione o bairro',
                    class_name: 'warning',
                    time: 2000
                });
                $('#novo_endereco_bairro').focus();
                return;
            }

            if (!endereco) {
                $.gritter.add({
                    title: 'Atenção',
                    text: 'Informe o endereço',
                    class_name: 'warning',
                    time: 2000
                });
                $('#novo_endereco_endereco').focus();
                return;
            }

            if (!numero) {
                $.gritter.add({
                    title: 'Atenção',
                    text: 'Informe o número',
                    class_name: 'warning',
                    time: 2000
                });
                $('#novo_endereco_numero').focus();
                return;
            }

            // Desabilitar botão
            $('#btnSalvarEndereco').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Salvando...');

            // Enviar dados
            $.ajax({
                url: baseUri + '/local/gravar/',
                type: 'POST',
                data: $('#formNovoEndereco').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $.gritter.add({
                            title: 'Sucesso!',
                            text: 'Endereço cadastrado com sucesso',
                            class_name: 'success',
                            time: 2000
                        });

                        // Recarregar endereços do cliente e selecionar o novo
                        setTimeout(function() {
                            carregarEnderecosCliente();

                            // Fechar modal e voltar para checkout
                            $('#modalNovoEndereco').removeClass('show');
                            $('#modalCheckout').addClass('show');

                            // Reabilitar botão
                            $('#btnSalvarEndereco').prop('disabled', false).html('<i class="fa fa-check"></i> Cadastrar Endereço');
                        }, 500);
                    } else {
                        $.gritter.add({
                            title: 'Erro',
                            text: 'Não foi possível cadastrar o endereço',
                            class_name: 'danger',
                            time: 3000
                        });
                        $('#btnSalvarEndereco').prop('disabled', false).html('<i class="fa fa-check"></i> Cadastrar Endereço');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao salvar endereço:', error);
                    $.gritter.add({
                        title: 'Erro',
                        text: 'Não foi possível cadastrar o endereço',
                        class_name: 'danger',
                        time: 3000
                    });
                    $('#btnSalvarEndereco').prop('disabled', false).html('<i class="fa fa-check"></i> Cadastrar Endereço');
                }
            });
        }

        //===============================================
        // FUNÇÕES DO MODAL NOVO CLIENTE
        //===============================================

        function abrirModalNovoCliente() {
            // Limpar formulário
            $('#formNovoCliente')[0].reset();
            $('#fone_existe').hide();
            $('#btnSalvarCliente').prop('disabled', false);

            // Fechar modal de seleção e abrir modal de cadastro
            $('#modalCliente').removeClass('show');
            $('#modalNovoCliente').addClass('show');

            // Foco no primeiro campo
            setTimeout(function() {
                $('#novo_cliente_nome').focus();
            }, 100);
        }

        function fecharModalNovoCliente() {
            $('#modalNovoCliente').removeClass('show');
            // Reabrir modal de seleção
            $('#modalCliente').addClass('show');
        }

        function salvarNovoCliente() {
            // Validações - apenas Nome e Celular
            const nome = $('#novo_cliente_nome').val().trim();
            const fone = $('#novo_cliente_fone2').val().trim();

            if (!nome) {
                $.gritter.add({
                    title: 'Atenção',
                    text: 'Informe o nome do cliente',
                    class_name: 'warning',
                    time: 2000
                });
                $('#novo_cliente_nome').focus();
                return;
            }

            if (!fone || fone.length < 14) {
                $.gritter.add({
                    title: 'Atenção',
                    text: 'Informe um telefone válido',
                    class_name: 'warning',
                    time: 2000
                });
                $('#novo_cliente_fone2').focus();
                return;
            }

            // Validação adicional de número válido
            const apenasNumeros = fone.replace(/\D/g, '');

            // Verificar se tem todos os dígitos iguais (ex: 11111111111)
            const todosIguais = /^(\d)\1+$/.test(apenasNumeros);

            // Verificar se os últimos 8 ou 9 dígitos são iguais (ex: 85999999999)
            const ultimosIguais = /\d(\d)\1{7,}$/.test(apenasNumeros);

            // Verificar se DDD + números repetidos (ex: 85999999999, 11888888888)
            const dddComRepetidos = /^\d{2}(\d)\1{8,}$/.test(apenasNumeros);

            // Verificar padrões inválidos
            const padrõesInvalidos = [
                '00000000000', '11111111111', '22222222222', '33333333333',
                '44444444444', '55555555555', '66666666666', '77777777777',
                '88888888888', '99999999999', '12345678901', '01234567890'
            ];

            if (todosIguais || ultimosIguais || dddComRepetidos || padrõesInvalidos.includes(apenasNumeros)) {
                $.gritter.add({
                    title: 'Telefone Inválido',
                    text: 'Por favor, informe um número de telefone válido. Números com dígitos repetidos não são aceitos.',
                    class_name: 'danger',
                    time: 4000
                });
                $('#novo_cliente_fone2').focus().select();
                return;
            }

            // Desabilitar botão
            $('#btnSalvarCliente').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Salvando...');

            // Enviar dados
            $.ajax({
                url: baseUri + '/cliente/gravar/',
                type: 'POST',
                data: $('#formNovoCliente').serialize(),
                success: function(response) {
                    $.gritter.add({
                        title: 'Sucesso!',
                        text: 'Cliente cadastrado com sucesso',
                        class_name: 'success',
                        time: 2000
                    });

                    // Recarregar select de clientes
                    recarregarListaClientes(fone);
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao salvar cliente:', error);
                    $.gritter.add({
                        title: 'Erro',
                        text: 'Não foi possível cadastrar o cliente',
                        class_name: 'danger',
                        time: 3000
                    });
                    $('#btnSalvarCliente').prop('disabled', false).html('<i class="fa fa-check"></i> Cadastrar');
                }
            });
        }

        function recarregarListaClientes(foneParaSelecionar) {
            // Buscar lista atualizada de clientes
            $.ajax({
                url: baseUri + '/admin/get_clientes_json',
                type: 'GET',
                dataType: 'json',
                success: function(clientes) {
                    // Limpar select mantendo placeholder
                    $('#selectCliente').html('<option value="">Digite para buscar...</option>');

                    // Adicionar clientes
                    if (clientes && clientes.length > 0) {
                        clientes.forEach(function(cliente) {
                            const option = $('<option></option>')
                                .val(cliente.cliente_id)
                                .attr('data-nome', cliente.cliente_nome)
                                .attr('data-fone', cliente.cliente_fone2)
                                .text(cliente.cliente_nome + ' | ' + cliente.cliente_fone2);
                            $('#selectCliente').append(option);

                            // Se for o cliente recém cadastrado, selecionar automaticamente
                            if (cliente.cliente_fone2 === foneParaSelecionar) {
                                $('#selectCliente').val(cliente.cliente_id).trigger('change');

                                // Auto-selecionar o cliente
                                clienteSelecionado = {
                                    id: cliente.cliente_id,
                                    nome: cliente.cliente_nome,
                                    fone: cliente.cliente_fone2
                                };

                                // Definir na sessão
                                $.post(baseUri + '/admin/set_cliente_venda', { cliente_id: cliente.cliente_id }, function() {
                                    $('#clienteInfo').html(`
                                        <i class="fa fa-user"></i>
                                        <strong>${clienteSelecionado.nome}</strong>
                                        <br><small>${clienteSelecionado.fone}</small>
                                        <span class="btn-trocar-cliente" onclick="abrirModalCliente()">trocar</span>
                                    `);

                                    // Carregar endereços do cliente
                                    carregarEnderecosCliente();
                                });
                            }
                        });
                    }

                    // Fechar modal de cadastro e abrir modal de seleção
                    $('#modalNovoCliente').removeClass('show');
                    $('#modalCliente').removeClass('show');

                    // Reabilitar botão
                    $('#btnSalvarCliente').prop('disabled', false).html('<i class="fa fa-check"></i> Cadastrar');
                },
                error: function() {
                    // Mesmo com erro, fechar modal e tentar continuar
                    $('#modalNovoCliente').removeClass('show');
                    $('#modalCliente').removeClass('show');
                    $('#btnSalvarCliente').prop('disabled', false).html('<i class="fa fa-check"></i> Cadastrar');
                }
            });
        }

        function selecionarCliente() {
            const clienteId = $('#selectCliente').val();
            if (!clienteId) {
                alert('Selecione um cliente');
                return;
            }

            const option = $('#selectCliente option:selected');
            clienteSelecionado = {
                id: clienteId,
                nome: option.data('nome'),
                fone: option.data('fone')
            };

            // Definir o cliente na sessão
            $.post(baseUri + '/admin/set_cliente_venda', { cliente_id: clienteId }, function() {
                $('#clienteInfo').html(`
                    <i class="fa fa-user"></i>
                    <strong>${clienteSelecionado.nome}</strong>
                    <br><small>${clienteSelecionado.fone}</small>
                    <span class="btn-trocar-cliente" onclick="abrirModalCliente()">trocar</span>
                `);

                // Carregar endereços do cliente
                carregarEnderecosCliente();

                fecharModalCliente();
            });
        }

        function carregarProdutos() {

            $.post(baseUri + '/admin/get_produtos_pdv', {}, function(data) {

                if (data.success) {
                    produtos = data.produtos || [];
                    categorias = data.categorias || [];

                    renderizarCategorias();
                    renderizarProdutos();
                } else {
                    console.error('Erro na resposta:', data);
                    $.gritter.add({
                        title: 'Erro',
                        text: 'Não foi possível carregar os produtos',
                        class_name: 'danger',
                        time: 3000
                    });
                }
            }).fail(function(xhr, status, error) {
                console.error('Erro na chamada AJAX:', status, error);
                console.error('Resposta:', xhr.responseText);

                $.gritter.add({
                    title: 'Erro',
                    text: 'Não foi possível conectar ao servidor. Verifique o console.',
                    class_name: 'danger',
                    time: 3000
                });
            });
        }

        function renderizarCategorias() {
            let html = '<div class="category-pill active" data-cat="todos" onclick="filtrarCategoria(\'todos\')">Todos</div>';
            categorias.forEach(cat => {
                html += `<div class="category-pill" data-cat="${cat.id}" onclick="filtrarCategoria('${cat.id}')">${cat.nome}</div>`;
            });
            $('#categoryPills').html(html);
        }

        function renderizarProdutos(filtroCategoria = 'todos', filtroBusca = '') {
            let produtosFiltrados = produtos;

            if (filtroCategoria !== 'todos') {
                produtosFiltrados = produtosFiltrados.filter(p => p.categoria_id == filtroCategoria);
            }

            if (filtroBusca) {
                const busca = filtroBusca.toLowerCase();
                produtosFiltrados = produtosFiltrados.filter(p =>
                    p.nome.toLowerCase().includes(busca) ||
                    (p.codigo && p.codigo.toLowerCase().includes(busca))
                );
            }

            let html = '';
            produtosFiltrados.forEach(produto => {
                const esgotado = produto.estoque <= 0;
                const fotoSrc = produto.foto || `${baseUri}/assets/thumb.php?zc=3&w=120&h=120&src=img/sem_foto.jpg`;
                html += `
                    <div class="produto-card ${esgotado ? 'esgotado' : ''}" onclick="${esgotado ? '' : `adicionarAoCarrinho(${produto.id})`}">
                        ${esgotado ? '<span class="badge-esgotado">ESGOTADO</span>' : ''}
                        <img src="${fotoSrc}" alt="${produto.nome}" class="produto-img" onerror="this.onerror=null; this.src='${baseUri}/assets/thumb.php?zc=3&w=120&h=120&src=img/sem_foto.jpg';">
                        <div class="produto-nome">${produto.nome}</div>
                        <div class="produto-preco">R$ ${produto.preco}</div>
                        ${!esgotado ? '<button class="btn-add-rapido" onclick="event.stopPropagation(); adicionarAoCarrinho(' + produto.id + ')"><i class="fa fa-plus"></i></button>' : ''}
                    </div>
                `;
            });

            $('#produtosGrid').html(html || '<p style="grid-column: 1/-1; text-align: center; color: #999; padding: 40px;">Nenhum produto encontrado</p>');
        }

        function filtrarCategoria(catId) {
            $('.category-pill').removeClass('active');
            $(`.category-pill[data-cat="${catId}"]`).addClass('active');
            const busca = $('#searchProduto').val();
            renderizarProdutos(catId, busca);
        }

        $('#searchProduto').on('input', function() {
            const busca = $(this).val();
            const catAtiva = $('.category-pill.active').data('cat');
            renderizarProdutos(catAtiva, busca);
        });

        function adicionarAoCarrinho(produtoId) {
            const produto = produtos.find(p => p.id == produtoId);
            if (!produto) return;

            // Adicionar ao carrinho via AJAX usando o sistema existente
            $.ajax({
                url: baseUri + '/carrinho/add',
                type: 'POST',
                data: {
                    item_id: produto.id,
                    item_nome: produto.nome,
                    categoria_id: produto.categoria_id,
                    categoria_nome: produto.categoria_nome,
                    item_preco: produto.preco_num,
                    item_codigo: produto.codigo,
                    item_obs: produto.obs,
                    qtde: 1,
                    extra: '',
                    extra_preco: 0
                },
                dataType: 'json',
                success: function(response) {

                    if (response.success) {
                        // Recarregar o carrinho
                        carregarCarrinho();

                        // Feedback visual
                        $.gritter.add({
                            title: 'Produto adicionado',
                            text: produto.nome,
                            class_name: 'success',
                            time: 1500
                        });
                    } else {
                        $.gritter.add({
                            title: 'Erro',
                            text: response.error || 'Não foi possível adicionar o produto',
                            class_name: 'danger',
                            time: 2000
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro na requisição:', status, error);
                    console.error('Resposta:', xhr.responseText);

                    $.gritter.add({
                        title: 'Erro',
                        text: 'Não foi possível adicionar o produto',
                        class_name: 'danger',
                        time: 2000
                    });
                }
            });
        }

        function alterarQtd(hash, delta) {

            // Encontrar o item no carrinho para pegar o ID e estoque
            const item = carrinho.find(i => i.item_hash === hash);
            if (!item) {
                console.error('Item não encontrado no carrinho:', hash);
                return;
            }

            if (delta > 0) {

                // Buscar o estoque real do produto
                const produto = produtos.find(p => p.id == item.item_id);
                if (!produto) {
                    $.gritter.add({
                        title: 'Erro',
                        text: 'Produto não encontrado',
                        class_name: 'danger',
                        time: 2000
                    });
                    return;
                }

                // Calcular quantidade total que ficaria no carrinho
                const qtdeAtual = parseInt(item.qtde);
                const novaQtde = qtdeAtual + 1;
                const estoqueDisponivel = parseInt(produto.estoque);

                // Verificar se a nova quantidade não excede o estoque
                if (novaQtde > estoqueDisponivel) {
                    $.gritter.add({
                        title: 'Estoque insuficiente',
                        text: `Apenas ${estoqueDisponivel} unidade(s) disponível(is)`,
                        class_name: 'warning',
                        time: 3000
                    });
                    return;
                }

                // Se passou na verificação, pode adicionar
                $.post(baseUri + '/carrinho/add_more', {
                    hash: hash,
                    id: item.item_id,
                    estoque: estoqueDisponivel
                }, function(response) {

                    if (response !== '-1') {
                        carregarCarrinho();
                    } else {
                        $.gritter.add({
                            title: 'Estoque insuficiente',
                            text: 'Não há estoque disponível',
                            class_name: 'warning',
                            time: 2000
                        });
                    }
                }).fail(function() {
                    $.gritter.add({
                        title: 'Erro',
                        text: 'Não foi possível atualizar a quantidade',
                        class_name: 'danger',
                        time: 2000
                    });
                });
            } else {
                // Diminuir quantidade
                $.post(baseUri + '/carrinho/del_more', {
                    hash: hash,
                    id: item.item_id
                }, function(response) {
                    carregarCarrinho();
                }).fail(function() {
                    $.gritter.add({
                        title: 'Erro',
                        text: 'Não foi possível atualizar a quantidade',
                        class_name: 'danger',
                        time: 2000
                    });
                });
            }
        }

        function removerItem(hash) {
            if (!confirm('Remover este item?')) return;

            $.post(baseUri + '/carrinho/del', {
                hash: hash
            }, function(response) {

                carregarCarrinho();
                $.gritter.add({
                    title: 'Item removido',
                    text: 'Produto removido do carrinho',
                    class_name: 'warning',
                    time: 1500
                });
            }).fail(function() {
                $.gritter.add({
                    title: 'Erro',
                    text: 'Não foi possível remover o item',
                    class_name: 'danger',
                    time: 2000
                });
            });
        }

        function carregarCarrinho() {

            $.ajax({
                url: baseUri + '/carrinho/get_json',
                type: 'POST',
                dataType: 'json',
                success: function(data) {

                    if (data.success && data.itens && data.itens.length > 0) {
                        carrinho = data.itens;
                        const total = parseFloat(data.total);
                        const qtdItens = data.itens.reduce((sum, item) => sum + parseInt(item.qtde), 0);

                        $('#badgeItens').text(qtdItens);
                        $('#subtotal').text('R$ ' + total.toFixed(2).replace('.', ','));
                        $('#total').text('R$ ' + total.toFixed(2).replace('.', ','));

                        let html = '';
                        data.itens.forEach((item) => {
                            const subtotal = parseFloat(item.total) * parseInt(item.qtde);
                            html += `
                                <div class="carrinho-item">
                                    <i class="fa fa-times btn-remover" onclick="removerItem('${item.item_hash}')"></i>
                                    <div class="item-nome">${item.item_nome}</div>
                                    ${item.extra ? `<div class="item-extras">${item.extra}</div>` : ''}
                                    <div class="item-footer">
                                        <div class="item-preco">R$ ${subtotal.toFixed(2).replace('.', ',')}</div>
                                        <div class="item-qtd">
                                            <button class="btn-qtd" onclick="alterarQtd('${item.item_hash}', -1)">-</button>
                                            <span class="qtd-num">${item.qtde}</span>
                                            <button class="btn-qtd" onclick="alterarQtd('${item.item_hash}', 1)">+</button>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        $('#carrinhoItens').html(html);
                        $('#btnFinalizar').prop('disabled', !clienteSelecionado);
                    } else {
                        carrinho = [];
                        $('#badgeItens').text('0');
                        $('#subtotal').text('R$ 0,00');
                        $('#total').text('R$ 0,00');
                        $('#carrinhoItens').html(`
                            <div class="carrinho-vazio">
                                <i class="fa fa-shopping-cart"></i>
                                <p>Carrinho vazio<br><small>Adicione produtos para começar</small></p>
                            </div>
                        `);
                        $('#btnFinalizar').prop('disabled', true);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro ao carregar carrinho:', status, error);
                    console.error('Resposta:', xhr.responseText);
                }
            });
        }

        function limparCarrinho() {
            if (!confirm('Deseja limpar todo o carrinho?')) return;

            $.post(baseUri + '/carrinho/clear', {}, function() {
                carregarCarrinho();
                $.gritter.add({
                    title: 'Carrinho limpo',
                    text: 'Todos os itens foram removidos',
                    class_name: 'info',
                    time: 1500
                });
            });
        }

        $('#btnFinalizar').on('click', function() {
            if (!clienteSelecionado) {
                alert('Selecione um cliente primeiro');
                abrirModalCliente();
                return;
            }

            if (carrinho.length === 0) {
                alert('Adicione produtos ao carrinho');
                return;
            }

            // Abrir modal de checkout
            abrirModalCheckout();
        });

        //===============================================
        // FUNÇÕES DO MODAL DE CHECKOUT
        //===============================================

        function abrirModalCheckout() {
            // Calcular total
            const total = carrinho.reduce((sum, item) => sum + (parseFloat(item.total) * parseInt(item.qtde)), 0);

            $('#resumoSubtotal').text('R$ ' + total.toFixed(2).replace('.', ','));
            $('#resumoTotal').text('R$ ' + total.toFixed(2).replace('.', ','));

            // Resetar campos
            $('#checkoutLocal').val('');
            $('#checkoutPagamento').val('');
            $('#checkoutObs').val('');
            $('#enderecoInfoSection').hide();
            $('#resumoEntregaRow').hide();
            $('#resumoTaxaRow').hide();

            // Carregar endereços do cliente se ainda não carregou
            if (clienteSelecionado) {
                carregarEnderecosCliente();
            }

            $('#modalCheckout').addClass('show');
        }

        function fecharModalCheckout() {
            $('#modalCheckout').removeClass('show');
        }

        // Carregar endereços do cliente
        function carregarEnderecosCliente() {
            if (!clienteSelecionado) {
                console.error('Nenhum cliente selecionado!');
                return;
            }

            $.ajax({
                url: baseUri + '/admin/get_enderecos_cliente/' + clienteSelecionado.id,
                type: 'GET',
                dataType: 'json',
                success: function(enderecos) {

                    // Limpar todo o select e reconstruir do zero
                    $('#checkoutLocal').html('<option value="" selected>Selecione uma opção...</option>');

                    // Adicionar opção "Retirar no Local" se estiver habilitado (via AJAX)
                    $.ajax({
                        url: baseUri + '/admin/get_config_retirada',
                        type: 'GET',
                        dataType: 'json',
                        async: false, // Aguarda para manter a ordem
                        success: function(config) {
                            if (config.retirada == 1) {
                                const optionRetirada = $('<option></option>')
                                    .val('0')
                                    .attr('data-cep', '0')
                                    .attr('data-taxa', 0)
                                    .text('Retirar no Local');
                                $('#checkoutLocal').append(optionRetirada);
                            }
                        }
                    });

                    if (enderecos && Array.isArray(enderecos) && enderecos.length > 0) {
                        enderecos.forEach((end, index) => {

                            const nome = end.endereco_nome || 'Endereço';
                            const bairro = end.endereco_bairro || end.bairro_nome || '';
                            const tempo = end.bairro_tempo || '';
                            const taxa = parseFloat(end.bairro_preco || 0);

                            // Texto da opção: "[Nome] em [Bairro] ([Tempo])"
                            let textoOpcao = nome + ' em ' + bairro;
                            if (tempo) {
                                textoOpcao += ' (' + tempo + ')';
                            }

                            const option = $('<option></option>')
                                .val(end.endereco_id)
                                .attr('data-bairro', end.endereco_bairro_id || end.bairro_id)
                                .attr('data-cep', end.endereco_cep || '')
                                .attr('data-tempo', tempo)
                                .attr('data-taxa', taxa)
                                .text(textoOpcao);

                            $('#checkoutLocal').append(option);
                        });
                    } else {
                        console.warn('Nenhum endereço válido encontrado');
                    }

                    // Adicionar opção de cadastrar novo endereço
                    const optionNovo = $('<option></option>')
                        .val('-1')
                        .attr('data-taxa', 0)
                        .text('Cadastrar novo endereço');
                    $('#checkoutLocal').append(optionNovo);
                },
                error: function(xhr, status, error) {
                    console.error('=== ERRO AO CARREGAR ENDEREÇOS ===');
                    console.error('Status:', status);
                    console.error('Erro:', error);
                    console.error('Response:', xhr.responseText);
                    console.error('Status Code:', xhr.status);
                }
            });
        }

        // Quando selecionar local
        $('#checkoutLocal').on('change', function() {
            const valor = $(this).val();
            const option = $(this).find('option:selected');

            // Forçar atualização visual do select
            this.style.color = valor ? '#333' : '#999';

            if (valor === '-1') {
                // Cadastrar novo endereço - ABRIR MODAL
                abrirModalNovoEndereco();
                $('#checkoutLocal').val('');
                this.style.color = '#999';
                return;
            }

            // Habilita forma de pagamento após selecionar local (igual ao /pedido)
            if (valor) {
                $('#checkoutPagamento').removeAttr('disabled');
                $('#checkoutPagamento').css('color', '#999'); // Reset cor do select de pagamento
            } else {
                $('#checkoutPagamento').attr('disabled', 'disabled');
                $('#btnConfirmarVenda').attr('disabled', 'disabled');
            }

            // Atualiza taxa de entrega
            const taxa = parseFloat(option.data('taxa')) || 0;

            if (taxa > 0) {
                $('#resumoEntrega').text('R$ ' + taxa.toFixed(2).replace('.', ','));
                $('#resumoEntregaRow').show();
            } else {
                $('#resumoEntregaRow').hide();
            }

            recalcularTotal();
        });

        // Quando selecionar forma de pagamento
        $('#checkoutPagamento').on('change', function() {
            const forma = $(this).val();
            const textoForma = $(this).find('option:selected').text();

            // Forçar atualização visual do select
            this.style.color = forma ? '#333' : '#999';

            // Limpar campo troco/bandeira
            $('#trocoBandeira').val('');
            $('#trocoBandeira').unmask();
            $('#trocoBandeiraSection').hide();

            // 1 = Dinheiro
            if (forma == '1') {
                $('#trocoBandeiraLabel').text('Troco para quanto?');
                $('#trocoBandeira').attr('placeholder', 'Ex: 50.00');
                $('#trocoBandeira').attr('type', 'number');
                $('#trocoBandeira').attr('step', '0.01');
                $('#trocoBandeira').attr('min', '0');
                $('#trocoBandeira').val('');
                $('#semTroco').show();
                $('#trocoBandeiraSection').show();

                // Remover qualquer máscara
                $('#trocoBandeira').unmask();

                // Focar no campo após aparecer
                setTimeout(function() {
                    $('#trocoBandeira').focus();
                }, 150);
            }
            // 2 = Débito, 3 = Crédito
            else if (forma == '2' || forma == '3') {
                $('#trocoBandeiraLabel').text('Informe a bandeira: (ex: Visa, Master, Elo...)');
                $('#trocoBandeira').attr('placeholder', 'Ex: Visa, Master, Elo...');
                $('#trocoBandeira').attr('type', 'text');
                $('#trocoBandeira').attr('required', 'required');
                $('#semTroco').hide();
                $('#trocoBandeiraSection').show();

                // Remover máscara se houver
                $('#trocoBandeira').unmask();
            }
            // 4 = PIX
            else if (forma == '4') {
                $('#trocoBandeiraSection').hide();
                $('#trocoBandeira').val('0');
            }

            // Habilita botão se tudo preenchido
            if (forma) {
                $('#btnConfirmarVenda').removeAttr('disabled');
            } else {
                $('#btnConfirmarVenda').attr('disabled', 'disabled');
            }

            recalcularTotal();
        });

        // Botão "Não preciso de troco"
        $('#semTroco').on('click', function() {
            $('#trocoBandeira').val('0');
            $('#trocoBandeiraSection').hide();
        });

        // Recalcular total com taxas
        function recalcularTotal() {
            const subtotal = carrinho.reduce((sum, item) => sum + (parseFloat(item.total) * parseInt(item.qtde)), 0);
            const taxaEntrega = parseFloat($('#checkoutLocal option:selected').data('taxa')) || 0;

            // Calcular taxa de cartão (se aplicável) - usar variável global
            taxaCartao = 0; // Reset da variável global
            const forma = $('#checkoutPagamento').val();

            // Se for cartão de crédito ou débito, calcular taxa
            if (forma == '2' || forma == '3') {
                // Usar a mesma lógica do carrinho.js
                if (configTaxaCartao && configTaxaCartao.config_taxa_tipo) {
                    if (configTaxaCartao.config_taxa_tipo === 'faixa_valor' && faixasCartao && faixasCartao.length > 0) {
                        // Calcular taxa por faixa de valor
                        const valorBase = subtotal + taxaEntrega;
                        faixasCartao.forEach(faixa => {
                            const de = parseFloat(faixa.valor_de);
                            const ate = parseFloat(faixa.valor_ate);
                            if (valorBase >= de && valorBase <= ate) {
                                taxaCartao = parseFloat(faixa.taxa) || 0;
                            }
                        });
                    } else if (configTaxaCartao.config_taxa_tipo === 'taxa_por_item') {
                        // Taxa por item
                        const totalItens = carrinho.reduce((sum, item) => sum + parseInt(item.qtde), 0);
                        if (configTaxaCartao.config_taxa_valor) {
                            taxaCartao = totalItens * parseFloat(configTaxaCartao.config_taxa_valor);
                            taxaCartao = Math.round((taxaCartao + Number.EPSILON) * 100) / 100;
                        }
                    } else if (configTaxaCartao.config_taxa_tipo === 'percentual') {
                        // Taxa percentual
                        let formasPagamento = {};
                        try {
                            formasPagamento = typeof configTaxaCartao.config_taxa_formas_pagamento === 'string'
                                ? JSON.parse(configTaxaCartao.config_taxa_formas_pagamento)
                                : configTaxaCartao.config_taxa_formas_pagamento;
                        } catch (e) {
                            formasPagamento = {};
                        }

                        if (formasPagamento) {
                            const percentual = formasPagamento[forma] || 0;
                            // Calcula taxa EMBUTIDA para receber o valor líquido
                            // Fórmula: valorCobrar = valorBase / (1 - taxa/100)
                            const valorBase = subtotal + taxaEntrega;
                            const valorCobrar = valorBase / (1 - percentual / 100);
                            taxaCartao = Math.round((valorCobrar - valorBase + Number.EPSILON) * 100) / 100;
                        }
                    }
                }
            }

            const total = subtotal + taxaEntrega + taxaCartao;

            // Atualizar exibição
            $('#resumoSubtotal').text('R$ ' + subtotal.toFixed(2).replace('.', ','));

            if (taxaEntrega > 0) {
                $('#resumoEntrega').text('R$ ' + taxaEntrega.toFixed(2).replace('.', ','));
                $('#resumoEntregaRow').show();
            } else {
                $('#resumoEntregaRow').hide();
            }

            if (taxaCartao > 0) {
                $('#resumoTaxaCartao').text('R$ ' + taxaCartao.toFixed(2).replace('.', ','));
                $('#resumoTaxaCartaoRow').show();
            } else {
                $('#resumoTaxaCartaoRow').hide();
            }

            $('#resumoTotal').text('R$ ' + total.toFixed(2).replace('.', ','));
        }

        // Confirmar venda
        function confirmarVenda() {
            // Validações (igual ao /pedido)
            if (!$('#checkoutLocal').val()) {
                alert('Selecione onde deseja receber o pedido');
                $('#checkoutLocal').focus();
                return;
            }

            if (!$('#checkoutPagamento').val()) {
                alert('Selecione a forma de pagamento');
                $('#checkoutPagamento').focus();
                return;
            }

            const forma = $('#checkoutPagamento').val();
            const trocoBandeira = $('#trocoBandeira').val();
            const total = parseFloat($('#resumoTotal').text().replace('R$ ', '').replace('.', '').replace(',', '.'));

            // Validação de troco (se for dinheiro)
            if (forma == '1' && trocoBandeira) {
                const valorTroco = parseFloat(trocoBandeira);
                if (isNaN(valorTroco)) {
                    alert('Valor de troco inválido!');
                    $('#trocoBandeira').focus();
                    return;
                }
                if (valorTroco > 0 && valorTroco < total) {
                    alert('Valor informado inferior ao valor total!');
                    $('#trocoBandeira').focus();
                    return;
                }
            }

            // Validação de bandeira (se for cartão)
            if ((forma == '2' || forma == '3') && !trocoBandeira) {
                alert('Informe a bandeira do cartão');
                $('#trocoBandeira').focus();
                return;
            }

            // Preparar dados
            const localValue = $('#checkoutLocal').val();
            const option = $('#checkoutLocal option:selected');

            // Se for retirar no local: pedido_local = 0
            // Se for delivery (endereço): pedido_local = endereco_id
            const pedido_local = localValue === '0' ? 0 : parseInt(localValue);
            const pedido_bairro = option.data('bairro') || 0;
            const pedido_entrega = parseFloat(option.data('taxa')) || 0;

            // Montar observação de pagamento
            let pedido_obs_pagto = '';
            if (forma == '1') {
                pedido_obs_pagto = 'Pagto em Dinheiro';
                if (trocoBandeira && parseFloat(trocoBandeira) > 0) {
                    const valorFormatado = parseFloat(trocoBandeira).toFixed(2).replace('.', ',');
                    pedido_obs_pagto += ' - Troco para R$ ' + valorFormatado;
                }
            } else if (forma == '2') {
                pedido_obs_pagto = 'Pagto com Cartão de Débito: ' + trocoBandeira;
            } else if (forma == '3') {
                pedido_obs_pagto = 'Pagto com Cartão de Crédito: ' + trocoBandeira;
            } else if (forma == '4') {
                pedido_obs_pagto = 'Pagto via PIX';
            }

            // Calcular troco
            let pedido_troco = 0;
            if (forma == '1' && trocoBandeira) {
                const valorTroco = parseFloat(trocoBandeira);
                if (!isNaN(valorTroco) && valorTroco > total) {
                    pedido_troco = valorTroco - total;
                }
            }

            // Combinar observações
            const obs = $('#checkoutObs').val().trim();
            let pedido_obs = obs;

            // Desabilitar botão
            $('#btnConfirmarVenda').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Processando...');

            // PASSO 1: Definir cliente na sessão antes de confirmar
            $.post(baseUri + '/admin/set_cliente_sessao', {
                cliente_id: clienteSelecionado.id
            }, function() {
                // PASSO 2: Enviar para o servidor após cliente estar na sessão
                $.post(baseUri + '/admin/confirmar', {
                    pedido_local: pedido_local,
                    pedido_bairro: pedido_bairro,
                    forma_pagamento: forma,
                    pedido_obs: pedido_obs,
                    pedido_obs_pagto: pedido_obs_pagto,
                    pedido_total: total.toFixed(2),
                    pedido_troco: pedido_troco.toFixed(2),
                    pedido_entrega: pedido_entrega.toFixed(2),
                    pedido_entrega_prazo: option.data('tempo') || '30-40 min',
                    pedido_taxa_cartao: taxaCartao.toFixed(2),
                    pedido_id_pagto: forma
                }, function(response) {
                    $.gritter.add({
                        title: 'Venda finalizada!',
                        text: 'Pedido criado com sucesso',
                        class_name: 'success',
                        time: 2000
                    });

                    // Limpar carrinho
                    limparCarrinho();

                    // Fechar modal
                    fecharModalCheckout();

                    // Aguardar e redirecionar
                    setTimeout(function() {
                        window.location.href = baseUri + '/admin/pedidos';
                    }, 2000);

                }).fail(function(xhr, status, error) {
                    console.error('Erro ao finalizar venda:', error);
                    alert('Erro ao finalizar venda. Verifique o console.');

                    // Reabilitar botão
                    $('#btnConfirmarVenda').prop('disabled', false).html('<i class="fa fa-check"></i> Confirmar Venda');
                });
            }).fail(function(xhr, status, error) {
                console.error('Erro ao definir cliente na sessão:', error);
                alert('Erro ao processar venda. Tente novamente.');

                // Reabilitar botão
                $('#btnConfirmarVenda').prop('disabled', false).html('<i class="fa fa-check"></i> Confirmar Venda');
            });
        }
    </script>
</body>
</html>
