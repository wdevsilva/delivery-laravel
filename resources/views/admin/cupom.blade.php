<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="js/bootstrap.datetimepicker/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link href="css/style.css" rel="stylesheet" />
    <!-- CSS Moderno -->
    <link href="<?php echo $baseUri; ?>/assets/css/cupom-moderno.css" rel="stylesheet" />
</head>

<body class="animated">
    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php require_once 'side-menu.php'; ?>
        </div>
        <div class="container-fluid" id="pcont">
            <!-- TOP NAVBAR -->
            <?php require_once 'top-menu.php'; ?>
            <div class="cl-mcont">
                <div class="cupom-container">
                    
                    <!-- Estatísticas -->
                    <?php if (isset($data['estatisticas'])) : 
                        $stats = $data['estatisticas'];
                    ?>
                    <div class="cupom-stats-header">
                        <div class="stat-card">
                            <div class="stat-card-icon"><i class="fa fa-ticket"></i></div>
                            <div class="stat-card-value stat-total"><?= $stats->total_cupons ?? 0 ?></div>
                            <div class="stat-card-label">Total de Cupons</div>
                        </div>
                        <div class="stat-card success">
                            <div class="stat-card-icon"><i class="fa fa-check-circle"></i></div>
                            <div class="stat-card-value stat-ativos"><?= $stats->ativos ?? 0 ?></div>
                            <div class="stat-card-label">Cupons Ativos</div>
                        </div>
                        <div class="stat-card warning">
                            <div class="stat-card-icon"><i class="fa fa-clock-o"></i></div>
                            <div class="stat-card-value"><?= $stats->expirados ?? 0 ?></div>
                            <div class="stat-card-label">Expirados</div>
                        </div>
                        <div class="stat-card info">
                            <div class="stat-card-icon"><i class="fa fa-line-chart"></i></div>
                            <div class="stat-card-value stat-usos"><?= $stats->total_usos ?? 0 ?></div>
                            <div class="stat-card-label">Total de Usos</div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Botão Novo Cupom -->
                    <?php if (!isset($data['cupom_edit'])) : ?>
                    <div style="text-align: right; margin-bottom: 20px;" id="novo-cupom-btn">
                        <button type="button" class="btn-modern btn-primary-modern" onclick="toggleFormulario()" style="<?= empty($data['cupom']) ? 'font-size: 1.1rem; padding: 16px 32px;' : '' ?>">
                            <i class="fa fa-plus-circle"></i> Novo Cupom
                        </button>
                    </div>
                    <?php endif; ?>

                    <!-- Formulário de Cupom -->
                    <div class="cupom-form-modern fade-in" id="cupom-form-container" style="display: <?= isset($data['cupom_edit']) ? 'block' : 'none' ?>;">
                        <div class="form-header">
                            <h3>
                                <i class="fa fa-<?= isset($data['cupom_edit']) ? 'pencil' : 'plus-circle' ?>"></i>
                                <?php if (isset($data['cupom_edit'])) : ?>
                                    Editar Cupom
                                <?php else : ?>
                                    Novo Cupom
                                <?php endif; ?>
                            </h3>
                            <button type="button" class="btn-modern btn-outline-modern" onclick="<?= isset($data['cupom_edit']) ? 'window.location.href=\'' . $baseUri . '/cupom/\'' : 'toggleFormulario()' ?>">
                                <i class="fa fa-<?= isset($data['cupom_edit']) ? 'arrow-left' : 'times' ?>"></i> <?= isset($data['cupom_edit']) ? 'Voltar' : 'Cancelar' ?>
                            </button>
                        </div>

                        <form action="<?php echo $baseUri; ?>/cupom/gravar/" method="post" id="cupom-form" autocomplete="off">
                            <?php 
                            $cupom = $data['cupom_edit'] ?? null;
                            if ($cupom) {
                                echo '<input type="hidden" name="cupom_id" value="' . $cupom->cupom_id . '">';
                            }
                            ?>
                            
                            <!-- Informações Básicas -->
                            <div class="form-grid">
                                <div class="form-group-modern">
                                    <label for="cupom_nome">Nome do Cupom <span class="required">*</span></label>
                                    <input type="text" class="form-control-modern" name="cupom_nome" id="cupom_nome" 
                                           value="<?= $cupom->cupom_nome ?? '' ?>" required 
                                           placeholder="Ex: Cupom de Boas-Vindas">
                                </div>

                                <div class="form-group-modern">
                                    <label for="cupom_codigo">Código <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-tag"></i>
                                        <input type="text" class="form-control-modern" name="cupom_codigo" id="cupom_codigo" 
                                               value="<?= $cupom->cupom_codigo ?? '' ?>" required 
                                               placeholder="BEMVINDO10" maxlength="20">
                                    </div>
                                    <small style="color: #6b7280; font-size: 0.75rem;">Deixe em branco para gerar automaticamente</small>
                                </div>

                                <div class="form-group-modern">
                                    <label for="cupom_validade">Data de Validade <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-calendar"></i>
                                        <input type="text" name="cupom_validade" id="cupom_validade" 
                                               class="form-control-modern date-picker date-mask" 
                                               value="<?= isset($cupom->cupom_validade) ? date('d/m/Y', strtotime($cupom->cupom_validade)) : '' ?>" 
                                               required placeholder="DD/MM/AAAA">
                                    </div>
                                </div>

                                <div class="form-group-modern">
                                    <label for="cupom_quantidade">Quantidade Total <span class="required">*</span></label>
                                    <input type="number" min="1" name="cupom_quantidade" id="cupom_quantidade" 
                                           class="form-control-modern" value="<?= $cupom->cupom_quantidade ?? '' ?>" 
                                           required placeholder="100">
                                </div>
                            </div>

                            <!-- Desconto -->
                            <div class="form-grid" style="margin-top: 20px;">
                                <div class="form-group-modern">
                                    <label for="cupom_tipo">Tipo de Desconto <span class="required">*</span></label>
                                    <select name="cupom_tipo" id="cupom_tipo" class="form-control-modern" required>
                                        <option value="1" <?= (isset($cupom) && $cupom->cupom_tipo == 1) ? 'selected' : '' ?>>Valor Fixo (R$)</option>
                                        <option value="2" <?= (isset($cupom) && $cupom->cupom_tipo == 2) ? 'selected' : '' ?>>Porcentagem (%)</option>
                                    </select>
                                </div>

                                <div class="form-group-modern" id="group-valor" style="display: <?= (!isset($cupom) || $cupom->cupom_tipo == 1) ? 'block' : 'none' ?>;">
                                    <label for="cupom_valor">Valor do Desconto (R$)</label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-dollar"></i>
                                        <input type="text" name="cupom_valor" id="cupom_valor" 
                                               class="form-control-modern money-mask" 
                                               value="<?= isset($cupom->cupom_valor) ? number_format($cupom->cupom_valor, 2, ',', '.') : '' ?>" 
                                               placeholder="0,00">
                                    </div>
                                </div>

                                <div class="form-group-modern" id="group-percent" style="display: <?= (isset($cupom) && $cupom->cupom_tipo == 2) ? 'block' : 'none' ?>;">
                                    <label for="cupom_percent">Porcentagem (%)</label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-percent"></i>
                                        <input type="text" name="cupom_percent" id="cupom_percent" 
                                               class="form-control-modern percent-mask" maxlength="3"
                                               value="<?= $cupom->cupom_percent ?? '' ?>" 
                                               placeholder="10">
                                    </div>
                                </div>

                                <div class="form-group-modern" id="group-desconto-max" style="display: <?= (isset($cupom) && $cupom->cupom_tipo == 2) ? 'block' : 'none' ?>;">
                                    <label for="cupom_desconto_maximo">Desconto Máximo (R$)</label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-dollar"></i>
                                        <input type="text" name="cupom_desconto_maximo" id="cupom_desconto_maximo" 
                                               class="form-control-modern money-mask"
                                               value="<?= isset($cupom->cupom_desconto_maximo) ? number_format($cupom->cupom_desconto_maximo, 2, ',', '.') : '' ?>" 
                                               placeholder="0,00">
                                    </div>
                                    <small style="color: #6b7280; font-size: 0.75rem;">Opcional: Valor máximo que o desconto pode atingir</small>
                                </div>
                            </div>

                            <!-- Restrições -->
                            <div class="form-grid" style="margin-top: 20px;">
                                <div class="form-group-modern">
                                    <label for="cupom_valor_minimo">Valor Mínimo do Pedido (R$)</label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-shopping-cart"></i>
                                        <input type="text" name="cupom_valor_minimo" id="cupom_valor_minimo" 
                                               class="form-control-modern money-mask"
                                               value="<?= isset($cupom->cupom_valor_minimo) ? number_format($cupom->cupom_valor_minimo, 2, ',', '.') : '' ?>" 
                                               placeholder="0,00">
                                    </div>
                                </div>

                                <div class="form-group-modern">
                                    <label for="cupom_limite_cliente">Limite por Cliente</label>
                                    <input type="number" min="1" name="cupom_limite_cliente" id="cupom_limite_cliente" 
                                           class="form-control-modern" value="<?= $cupom->cupom_limite_cliente ?? 1 ?>" 
                                           placeholder="1">
                                    <small style="color: #6b7280; font-size: 0.75rem;">Quantas vezes cada cliente pode usar</small>
                                </div>

                                <div class="form-group-modern">
                                    <label for="cupom_cor">Cor do Cupom</label>
                                    <div class="color-picker-wrapper">
                                        <input type="color" name="cupom_cor" id="cupom_cor" 
                                               value="<?= $cupom->cupom_cor ?? '#4CAF50' ?>">
                                        <span style="color: #6b7280; font-size: 0.875rem;">Escolha uma cor</span>
                                    </div>
                                </div>

                                <div class="form-group-modern">
                                    <label>&nbsp;</label>
                                    <div class="checkbox-modern">
                                        <input type="checkbox" name="cupom_primeira_compra" id="cupom_primeira_compra" 
                                               <?= (isset($cupom) && $cupom->cupom_primeira_compra == 1) ? 'checked' : '' ?>>
                                        <label for="cupom_primeira_compra" style="margin: 0; text-transform: none; letter-spacing: 0;">Apenas primeira compra</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Opções Avançadas (Accordion) -->
                            <div class="accordion-modern" style="margin-top: 30px;">
                                <div class="accordion-header">
                                    <span><i class="fa fa-cog"></i> Opções Avançadas</span>
                                    <i class="fa fa-chevron-down accordion-icon"></i>
                                </div>
                                <div class="accordion-content">
                                    <!-- Dias da Semana -->
                                    <div class="form-group-modern" style="margin-bottom: 20px;">
                                        <label>Dias da Semana</label>
                                        <div class="dias-semana-selector">
                                            <?php 
                                            $dias = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
                                            $dias_selecionados = isset($cupom->cupom_dias_semana) ? explode(',', $cupom->cupom_dias_semana) : ['0','1','2','3','4','5','6'];
                                            for ($i = 0; $i < 7; $i++) :
                                                $checked = in_array((string)$i, $dias_selecionados) ? 'active' : '';
                                            ?>
                                            <div class="dia-btn <?= $checked ?>">
                                                <input type="checkbox" name="cupom_dias_semana[]" value="<?= $i ?>" id="dia_<?= $i ?>" <?= in_array((string)$i, $dias_selecionados) ? 'checked' : '' ?>>
                                                <label for="dia_<?= $i ?>" style="cursor: pointer; margin: 0;"><?= $dias[$i] ?></label>
                                            </div>
                                            <?php endfor; ?>
                                        </div>
                                    </div>

                                    <!-- Horários -->
                                    <div class="form-grid">
                                        <div class="form-group-modern">
                                            <label for="cupom_hora_inicio">Horário Início</label>
                                            <div class="input-with-icon">
                                                <i class="fa fa-clock-o"></i>
                                                <input type="time" name="cupom_hora_inicio" id="cupom_hora_inicio" 
                                                       class="form-control-modern"
                                                       value="<?= isset($cupom->cupom_hora_inicio) ? substr($cupom->cupom_hora_inicio, 0, 5) : '' ?>">
                                            </div>
                                        </div>

                                        <div class="form-group-modern">
                                            <label for="cupom_hora_fim">Horário Fim</label>
                                            <div class="input-with-icon">
                                                <i class="fa fa-clock-o"></i>
                                                <input type="time" name="cupom_hora_fim" id="cupom_hora_fim" 
                                                       class="form-control-modern"
                                                       value="<?= isset($cupom->cupom_hora_fim) ? substr($cupom->cupom_hora_fim, 0, 5) : '' ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Descrição e Mensagem -->
                                    <div class="form-group-modern" style="margin-top: 20px;">
                                        <label for="cupom_descricao">Descrição</label>
                                        <textarea name="cupom_descricao" id="cupom_descricao" class="form-control-modern" 
                                                  rows="3" placeholder="Descrição detalhada do cupom..."><?= $cupom->cupom_descricao ?? '' ?></textarea>
                                    </div>

                                    <div class="form-group-modern" style="margin-top: 15px;">
                                        <label for="cupom_mensagem">Mensagem de Sucesso</label>
                                        <input type="text" name="cupom_mensagem" id="cupom_mensagem" 
                                               class="form-control-modern"
                                               value="<?= $cupom->cupom_mensagem ?? '' ?>" 
                                               placeholder="Parabéns! Você ganhou desconto!">
                                        <small style="color: #6b7280; font-size: 0.75rem;">Mensagem exibida quando o cupom for aplicado</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Botões -->
                            <div style="display: flex; gap: 15px; justify-content: center; margin-top: 30px;">
                                <button type="button" class="btn-modern btn-outline-modern" onclick="<?= isset($data['cupom_edit']) ? 'window.location.href=\'' . $baseUri . '/cupom/\'' : 'toggleFormulario()' ?>">
                                    <i class="fa fa-times"></i> Cancelar
                                </button>
                                <button type="submit" class="btn-modern btn-primary-modern">
                                    <i class="fa fa-save"></i> Salvar Cupom
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Tabela de Cupons -->
                    <?php if (isset($data['cupom']) && count($data['cupom']) > 0) : ?>
                    <div class="cupons-table-wrapper fade-in" style="margin-top: 30px;">
                        <table class="cupons-table">
                            <thead>
                                <tr>
                                    <th>Cupom</th>
                                    <th style="text-align: center;">Desconto</th>
                                    <th style="text-align: center;">Uso</th>
                                    <th style="text-align: center;">Validade</th>
                                    <th style="text-align: center;">Status</th>
                                    <th style="text-align: center;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['cupom'] as $cp) : ?>
                                <tr>
                                    <td>
                                        <div class="cupom-card">
                                            <div style="width: 6px; height: 50px; border-radius: 3px; background: <?= $cp->cupom_cor ?? '#4CAF50' ?>;"></div>
                                            <div>
                                                <div class="cupom-name"><?= $cp->nome ?></div>
                                                <div class="cupom-code-badge"><?= $cp->cupom_codigo ?? $cp->nome ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        <strong style="font-size: 1.1rem; color: #10b981;"><?= $cp->valor ?></strong>
                                        <?php if ($cp->cupom_valor_minimo > 0) : ?>
                                        <br><small style="color: #6b7280;">Pedido mín: R$ <?= number_format($cp->cupom_valor_minimo, 2, ',', '.') ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="usage-progress">
                                            <div class="progress-bar">
                                                <div class="progress-fill" style="width: <?= ($cp->cupom_usado / $cp->cupom_quantidade) * 100 ?>%"></div>
                                            </div>
                                            <div class="progress-text"><?= $cp->cupom_usado ?>/<?= $cp->cupom_quantidade ?></div>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        <div style="font-weight: 600;"><?= $cp->validade ?></div>
                                        <?php
                                        $dias_restantes = ceil((strtotime($cp->validade_raw) - time()) / 86400);
                                        if ($dias_restantes > 0) :
                                        ?>
                                        <small style="color: #6b7280;"><?= $dias_restantes ?> dias</small>
                                        <?php endif; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <span class="status-badge <?= strtolower($cp->situacao) ?>"><?= $cp->situacao ?></span>
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="table-actions">
                                            <button class="action-btn view tooltip-modern" data-tooltip="Visualizar" 
                                                    onclick="visualizar(<?= $cp->id ?>)">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <button class="action-btn edit tooltip-modern btn-edit" data-tooltip="Editar" 
                                                    data-id="<?= $cp->id ?>">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button class="action-btn duplicate tooltip-modern btn-duplicate" data-tooltip="Duplicar" 
                                                    data-id="<?= $cp->id ?>">
                                                <i class="fa fa-copy"></i>
                                            </button>
                                            <button class="action-btn <?= $cp->status == 1 ? 'view' : 'delete' ?> tooltip-modern btn-toggle-status" 
                                                    data-tooltip="<?= $cp->status == 1 ? 'Desativar' : 'Ativar' ?>" 
                                                    data-id="<?= $cp->id ?>" data-status="<?= $cp->status ?>">
                                                <i class="fa fa-<?= $cp->status == 1 ? 'check' : 'ban' ?>"></i>
                                            </button>
                                            <button class="action-btn delete tooltip-modern btn-delete" data-tooltip="Excluir" 
                                                    data-id="<?= $cp->id ?>">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else : ?>
                    <div class="empty-state">
                        <i class="fa fa-ticket"></i>
                        <h3>Nenhum cupom cadastrado</h3>
                        <p>Crie seu primeiro cupom clicando no botão "Novo Cupom" acima</p>
                        <button type="button" class="btn-modern btn-primary-modern" onclick="toggleFormulario()" style="margin-top: 20px;">
                            <i class="fa fa-plus-circle"></i> Criar Primeiro Cupom
                        </button>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/jquery.js"></script>
    <script src="js/jquery.cooki/jquery.cooki.js"></script>
    <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="js/behaviour/core.js"></script>
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery.mask.js"></script>
    <!-- CALENDAR JS -->
    <script src="js/cupom-desconto/moment.js"></script>
    <script src="js/cupom-desconto/moment-pt-br.js"></script>
    <script src="js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <?php require_once 'switch-color.php'; ?>
    <script src="app-js/main.js"></script>
    <!-- JS Moderno -->
    <script src="<?php echo $baseUri; ?>/assets/js/cupom-moderno.js?v=<?= time() ?>"></script>
    
    <script>
        $('#menu-cupom').addClass('active');

        // Toggle formulário
        function toggleFormulario() {
            const formContainer = document.getElementById('cupom-form-container');
            const btnContainer = document.getElementById('novo-cupom-btn');
            
            if (formContainer.style.display === 'none') {
                formContainer.style.display = 'block';
                if (btnContainer) btnContainer.style.display = 'none';
                
                // Scroll suave até o formulário
                setTimeout(() => {
                    formContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
            } else {
                formContainer.style.display = 'none';
                if (btnContainer) btnContainer.style.display = 'block';
                
                // Limpar campos do formulário
                const form = document.getElementById('cupom-form');
                if (form) {
                    form.reset();
                    // Resetar displays dos campos condicionais
                    document.getElementById('group-valor').style.display = 'block';
                    document.getElementById('group-percent').style.display = 'none';
                    document.getElementById('group-desconto-max').style.display = 'none';
                }
                
                // Scroll suave até o topo
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }

        function visualizar(id) {
            $.ajax({
                url: '<?php echo $baseUri; ?>/cupom/getCupom?id=' + id,
                dataType: 'JSON',
                success: function(data) {
                    var desconto = data.cupom_tipo == 1 
                        ? 'R$ ' + parseFloat(data.cupom_valor).toFixed(2).replace('.', ',')
                        : data.cupom_percent + '%';

                    var modal = `
                        <div class="modal-modern show" id="modal-visualizar">
                            <div class="modal-content-modern">
                                <div class="modal-header-modern">
                                    <h4>Cupom: ${data.cupom_nome}</h4>
                                    <button class="modal-close" onclick="document.getElementById('modal-visualizar').remove()">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div style="text-align: center; padding: 30px;">
                                        <div style="width: 100%; padding: 40px; background: linear-gradient(135deg, ${data.cupom_cor || '#4CAF50'}, ${data.cupom_cor || '#4CAF50'}99); border-radius: 16px; color: white; margin-bottom: 20px;">
                                            <div style="font-size: 3rem; margin-bottom: 10px;">${desconto}</div>
                                            <div style="font-size: 1.5rem; font-weight: 600; margin-bottom: 10px;">${data.cupom_codigo || data.cupom_nome}</div>
                                            <div style="font-size: 0.9rem; opacity: 0.9;">${data.cupom_descricao || 'Cupom de desconto'}</div>
                                        </div>
                                        <p style="color: #6b7280; margin-top: 15px;">
                                            <strong>Validade:</strong> ${new Date(data.cupom_validade).toLocaleDateString('pt-BR')}<br>
                                            <strong>Disponível:</strong> ${data.cupom_quantidade - (data.cupom_usado || 0)} de ${data.cupom_quantidade}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    $('body').append(modal);
                }
            });
        }
    </script>
</body>
</html>
