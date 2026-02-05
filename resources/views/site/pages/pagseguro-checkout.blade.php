<?php if (isset($data['pagamento']->pagamento_status) && $data['pagamento']->pagamento_status == 1): ?>
    <section id="pagamento-online" class="hide row">
        <form action="<?php echo $baseUri; ?>/pedido/confirmar_pagseguro/" id="form-credito" method="POST">
        <input type="hidden" id="pedido_bairro" name="pedido_bairro" class="pedido_bairro"/>
            <div class="col-md-6 col-xs-12 form-pagseguro">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Número do cartão</label>
                            <input class="form-control "
                                   type="text" maxlength="20" name="fakecartao_num" id="fakecartao_num"
                                   placeholder="informe o número do cartão de crédito" required/>
                        </div>
                    </div>
                    <input type="hidden" name="cartao_num" id="cartao_num">
                </div>
                <div class="hide form-group">
                    <label>Bandeira do Cartão</label>
                    <p id="brand_flag"></p>
                </div>
                <div class="form-group">
                    <label>Nome do Titular
                        <small class="text-muted">(exatamente como está impresso no cartão)</small>
                    </label>
                    <input class="text-uppercase form-control " type="text" name="cartao_nome"
                           id="cartao_nome" placeholder="Preenchimento obrigatório" required/>
                </div>
                <div class="form-group">
                    <label>CPF/CNPJ do Titular do cartão</label>
                    <input class="form-control cpf" type="text" name="cartao_cpf" id="cartao_cpf"
                           placeholder="Preenchimento obrigatório" required/>
                </div>
                <div class="form-group">
                    <label>Data de Nascimento do Titular do cartão</label>
                    <input class="form-control nascimento" type="text" name="cliente_nascimento"
                           id="cliente_nascimento" placeholder="Preenchimento obrigatório" required/>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Mês de validade</label>
                            <select class="form-control " name="cartao_mes" id="cartao_mes" required>
                                <option value="">Mês</option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Ano de validade</label>
                            <select class="form-control" name="cartao_ano" id="cartao_ano" required>
                                <option value="">Ano</option>
                                <?php for ($i = @date('Y'); $i <= @date('Y') + 15; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Código de segurança</label>
                            <input class="form-control only-number"
                                   type="text" pattern="\d*" maxlength="4"
                                   name="cartao_cod" id="cartao_cod" required
                                   placeholder="código do cartão"/>
                        </div>
                    </div>
                </div>
                <div class=" hide form-group" id="parcelamento">
                    <label>Número de parcelas</label>
                    <select name="card_parcela" id="card_parcela" class="form-control"></select>
                </div>
                <div class="hide hide-credito">
                    <input type="hidden" class="form-control" name="session_token" id="session_token"
                           value="<?= $data['url_ssid'] ?>">
                    <input type="hidden" class="form-control" name="card_token" id="card_token">
                    <input type="hidden" class="form-control" name="sender_hash" id="sender_hash">
                    <input type="hidden" name="amount" id="amount" value="">
                    <input type="hidden" name="total_amount" id="total_amount">
                    <input type="hidden" name="pedido_total_parcelado" id="pedido_total_parcelado">
                    <input type="hidden" name="metodo_pagamento" id="metodo-credito" value="credito">
                    <input type="hidden" name="pedido_obs" id="pega-obs">
                    <input type="hidden" name="pedido_local" id="pega-endereco">
                    <input type="hidden" name="pedido_entrega" id="pedido_entrega" value="0.00">
                    <input type="hidden" name="pedido_entrega_prazo" id="pedido_entrega_prazo"
                           value="<?= $data['config']->config_entrega ?>"/>
                </div>
            </div>
            <div class="cartao-modelo col-md-6 hidden-xs-down hidden-xs">
                <div class="card-wrapper"></div>
            </div>
            <div class="text-center btn-pagamento col-md-offset-1 col-md-4" style="margin-top: 15px">
                <button class="hide disabled concluir-pedido btn btn-success btn-lg"
                        data-loading-text="Aguarde..."
                        id="btn-finaliza-credito">
                    <i class="fa fa-check-circle"></i>
                    Concluir Meu Pedido
                </button>
                <div id="resp-pagamento"></div>
            </div>
        </form>
    </section>
<?php endif; ?>