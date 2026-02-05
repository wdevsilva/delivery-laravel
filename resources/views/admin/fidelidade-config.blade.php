<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Programa de Fidelidade</h3>
            </div>
            <form role="form" method="post" action="">
                <div class="box-body">
                    <div class="form-group">
                        <label>Programa Ativo</label>
                        <select name="config_fidelidade_ativo" class="form-control">
                            <option value="0" <?= $data['config']->config_fidelidade_ativo == 0 ? 'selected' : '' ?>>INATIVO</option>
                            <option value="1" <?= $data['config']->config_fidelidade_ativo == 1 ? 'selected' : '' ?>>ATIVO</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tipo de Programa</label>
                        <select name="config_fidelidade_tipo" class="form-control" id="config_fidelidade_tipo">
                            <option value="pontos" <?= $data['config']->config_fidelidade_tipo == 'pontos' ? 'selected' : '' ?>>Apenas Pontos</option>
                            <option value="cashback" <?= $data['config']->config_fidelidade_tipo == 'cashback' ? 'selected' : '' ?>>Apenas Cashback</option>
                            <option value="ambos" <?= $data['config']->config_fidelidade_tipo == 'ambos' ? 'selected' : '' ?>>Pontos + Cashback</option>
                            <option value="frequencia" <?= $data['config']->config_fidelidade_tipo == 'frequencia' ? 'selected' : '' ?>>🎉 Frequência (A cada X pedidos, ganhe Y% OFF)</option>
                        </select>
                    </div>

                    <!-- ========== CAMPOS PARA PONTOS/CASHBACK ========== -->
                    <div id="campos-pontos-cashback">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pontos por R$ 1,00</label>
                                    <input type="number" step="0.01" name="config_pontos_por_real" class="form-control"
                                        value="<?= $data['config']->config_pontos_por_real ?>" required>
                                    <small>Ex: 5 = 5 pontos por R$ 1,00</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>100 pontos = R$</label>
                                    <input type="number" step="0.01" name="config_valor_resgate_pontos" class="form-control"
                                        value="<?= $data['config']->config_valor_resgate_pontos ?>" required>
                                    <small>Valor em R$ que 100 pontos valem</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mínimo para Resgate (pontos)</label>
                                    <input type="number" name="config_pontos_para_resgatar" class="form-control"
                                        value="<?= $data['config']->config_pontos_para_resgatar ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6" id="campo_max_desconto" style="display: none;">
                                <div class="form-group">
                                    <label>Desconto Máximo por Pedido (R$)</label>
                                    <input type="number" step="0.01" name="config_fidelidade_max_desconto" class="form-control"
                                        value="<?= $data['config']->config_fidelidade_max_desconto ?>">
                                    <small class="text-muted">Apenas para Pontos + Cashback</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Validade dos Pontos (dias)</label>
                                    <input type="number" name="config_fidelidade_validade_dias" class="form-control"
                                        value="<?= $data['config']->config_fidelidade_validade_dias ?>" required>
                                    <small>Renova automaticamente com cada compra</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Renovar Validade Automaticamente</label>
                                    <select name="config_fidelidade_renovacao_automatica" class="form-control">
                                        <option value="0" <?= $data['config']->config_fidelidade_renovacao_automatica == 0 ? 'selected' : '' ?>>NÃO</option>
                                        <option value="1" <?= $data['config']->config_fidelidade_renovacao_automatica == 1 ? 'selected' : '' ?>>SIM</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <h4>Bônus Especiais</h4>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Primeira Compra (pontos)</label>
                                    <input type="number" name="config_bonus_primeira_compra" class="form-control"
                                        value="<?= $data['config']->config_bonus_primeira_compra ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Aniversário (pontos)</label>
                                    <input type="number" name="config_bonus_aniversario" class="form-control"
                                        value="<?= $data['config']->config_bonus_aniversario ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Avaliação (pontos)</label>
                                    <input type="number" name="config_bonus_avaliacao" class="form-control"
                                        value="<?= $data['config']->config_bonus_avaliacao ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Indicação (pontos)</label>
                                    <input type="number" name="config_bonus_indicacao" class="form-control"
                                        value="<?= $data['config']->config_bonus_indicacao ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Percentual Cashback (%)</label>
                                    <input type="number" step="0.01" name="config_cashback_percentual" class="form-control"
                                        value="<?= $data['config']->config_cashback_percentual ?>">
                                    <small>Ex: 5 = 5% do valor do pedido em cashback</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mínimo para Cashback (R$)</label>
                                    <input type="number" step="0.01" name="config_cashback_minimo_pedido" class="form-control"
                                        value="<?= $data['config']->config_cashback_minimo_pedido ?>">
                                    <small>Pedido mínimo para ganhar cashback</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- FIM: CAMPOS PARA PONTOS/CASHBACK -->

                    <!-- ========== CAMPOS PARA FREQUÊNCIA ========== -->
                    <div id="campos-frequencia" style="display: none;">
                        <hr>
                        <h4>🎉 Programa "A cada X pedidos, ganhe Y% de desconto"</h4>
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> <strong>Exemplo:</strong> "A cada 3 pedidos, o 4º ganha 10% de desconto"
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>A cada quantos pedidos?</label>
                                    <input type="number" name="config_fidelidade_frequencia_pedidos" class="form-control"
                                        value="<?= isset($data['config']->config_fidelidade_frequencia_pedidos) ? $data['config']->config_fidelidade_frequencia_pedidos : 3 ?>" min="1">
                                    <small class="text-muted">Padrão: 3 (ou seja, o 4º pedido ganha desconto)</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Percentual de Desconto (%)</label>
                                    <input type="number" step="0.01" name="config_fidelidade_frequencia_percentual" class="form-control"
                                        value="<?= isset($data['config']->config_fidelidade_frequencia_percentual) ? $data['config']->config_fidelidade_frequencia_percentual : 10 ?>" min="0" max="100">
                                    <small class="text-muted">Padrão: 10%</small>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fa fa-exclamation-triangle"></i> <strong>Atenção:</strong> O desconto é aplicado automaticamente no checkout quando o cliente atingir a meta de pedidos entregues.
                        </div>
                    </div>
                    <!-- FIM: CAMPOS PARA FREQUÊNCIA -->
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Salvar Configurações</button>
                    <a href="/admin/fidelidade" class="btn btn-default">Voltar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Mostrar/ocultar campos baseado no tipo de programa
    function toggleCamposPorTipo() {
        const tipo = $('#config_fidelidade_tipo').val();
        
        if (tipo === 'frequencia') {
            // Mostrar apenas campos de frequência
            $('#campos-pontos-cashback').hide();
            $('#campos-frequencia').show();
            
            // Desabilitar campos de pontos/cashback para não enviar no POST
            $('#campos-pontos-cashback input, #campos-pontos-cashback select').attr('disabled', true);
            $('#campos-frequencia input, #campos-frequencia select').attr('disabled', false);
        } else {
            // Mostrar campos de pontos/cashback
            $('#campos-pontos-cashback').show();
            $('#campos-frequencia').hide();
            
            // Habilitar campos de pontos/cashback
            $('#campos-pontos-cashback input, #campos-pontos-cashback select').attr('disabled', false);
            $('#campos-frequencia input, #campos-frequencia select').attr('disabled', true);
            
            // Campo de desconto máximo só aparece para "Pontos + Cashback"
            if (tipo === 'ambos') {
                $('#campo_max_desconto').show();
                $('#campo_max_desconto input').attr('required', true).attr('disabled', false);
            } else {
                $('#campo_max_desconto').hide();
                $('#campo_max_desconto input').attr('required', false);
                // Zerar valor quando não é "Pontos + Cashback"
                $('#campo_max_desconto input').val(0);
            }
        }
    }

    $(document).ready(function() {
        // Executar ao carregar
        toggleCamposPorTipo();

        // Executar ao mudar tipo
        $('#config_fidelidade_tipo').on('change', toggleCamposPorTipo);
    });
</script>