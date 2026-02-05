<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once __DIR__ . '/../site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />
</head>

<body class="animated">
    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php require_once __DIR__ . '/../side-menu.php'; ?>
        </div>
        <div class="container-fluid" id="pcont">
            <!-- TOP NAVBAR -->
            <?php require_once __DIR__ . '/../top-menu.php'; ?>
            <div class="cl-mcont">
                <div class="block-flat">
                    <div class="header">
                        <h3><i class="fa fa-gift"></i> Configurações do Programa de Fidelidade
                            <span class="pull-right">
                                <a href="<?php echo $baseUri; ?>/fidelidade/" class="btn btn-primary">
                                    <i class="fa fa-chevron-circle-left"></i> Voltar
                                </a>
                            </span>
                        </h3>
                    </div>
                    <div class="content">
                        <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-check"></i> Sucesso!</h4>
                            <?= urldecode($_GET['success']) ?>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Erro!</h4>
                            <?= urldecode($_GET['error']) ?>
                        </div>
                        <?php endif; ?>

                        <form method="post" action="">
                            <div class="row">
                                <!-- ATIVAR/DESATIVAR PROGRAMA -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="config_fidelidade_ativo">
                                            <i class="fa fa-power-off"></i> Status do Programa
                                        </label>
                                        <select name="config_fidelidade_ativo" id="config_fidelidade_ativo" class="form-control" style="font-weight: bold;">
                                            <option value="0" <?= ($data['config']->config_fidelidade_ativo == 0) ? 'selected' : '' ?> style="color: #e74c3c;">Inativo</option>
                                            <option value="1" <?= ($data['config']->config_fidelidade_ativo == 1) ? 'selected' : '' ?> style="color: #27ae60;">Ativo</option>
                                        </select>
                                        <small class="text-muted">Ative para começar a distribuir pontos</small>
                                    </div>
                                </div>
                                
                                <!-- TIPO DE PROGRAMA -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="config_fidelidade_tipo">
                                            <i class="fa fa-star"></i> Tipo de Programa
                                        </label>
                                        <select name="config_fidelidade_tipo" id="config_fidelidade_tipo" class="form-control">
                                            <option value="pontos" <?= ($data['config']->config_fidelidade_tipo == 'pontos') ? 'selected' : '' ?>>Pontos</option>
                                            <option value="cashback" <?= ($data['config']->config_fidelidade_tipo == 'cashback') ? 'selected' : '' ?>>Cashback</option>
                                            <option value="ambos" <?= ($data['config']->config_fidelidade_tipo == 'ambos') ? 'selected' : '' ?>>Pontos + Cashback</option>
                                            <option value="frequencia" <?= ($data['config']->config_fidelidade_tipo == 'frequencia') ? 'selected' : '' ?>>🎉 Frequência (A cada X pedidos, ganhe Y% OFF)</option>
                                        </select>
                                        <small class="text-muted">Escolha como recompensar clientes</small>
                                    </div>
                                </div>
                                
                                <!-- VALIDADE DOS PONTOS -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="config_fidelidade_validade_dias">
                                            <i class="fa fa-calendar"></i> Validade dos Pontos (dias)
                                        </label>
                                        <input type="number" name="config_fidelidade_validade_dias" id="config_fidelidade_validade_dias" 
                                               class="form-control" min="30" max="365" 
                                               value="<?= $data['config']->config_fidelidade_validade_dias ?? 90 ?>">
                                        <small class="text-muted">Renova a cada compra (Recomendado: 90)</small>
                                    </div>
                                </div>
                                
                                <!-- RENOVAÇÃO AUTOMÁTICA -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="config_fidelidade_renovacao_automatica">
                                            <i class="fa fa-refresh"></i> Renovação Automática
                                        </label>
                                        <select name="config_fidelidade_renovacao_automatica" id="config_fidelidade_renovacao_automatica" class="form-control">
                                            <option value="0" <?= ($data['config']->config_fidelidade_renovacao_automatica == 0) ? 'selected' : '' ?>>Não</option>
                                            <option value="1" <?= ($data['config']->config_fidelidade_renovacao_automatica == 1) ? 'selected' : '' ?>>Sim</option>
                                        </select>
                                        <small class="text-muted">Renovar pontos a cada compra</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- PONTOS POR REAL -->
                                <div class="col-md-3 campo-pontos" style="display:none;">
                                    <div class="form-group">
                                        <label for="config_pontos_por_real">
                                            <i class="fa fa-money"></i> Pontos por R$ 1,00
                                        </label>
                                        <input type="number" step="0.01" name="config_pontos_por_real" id="config_pontos_por_real" 
                                               class="form-control" min="1" max="100" 
                                               value="<?= $data['config']->config_pontos_por_real ?? 5.00 ?>">
                                        <small class="text-muted">Ex: 5 pontos = R$ 1,00</small>
                                    </div>
                                </div>
                                
                                <!-- MÍNIMO PARA RESGATAR -->
                                <div class="col-md-3 campo-pontos" style="display:none;">
                                    <div class="form-group">
                                        <label for="config_pontos_para_resgatar">
                                            <i class="fa fa-arrow-down"></i> Mínimo para Resgatar
                                        </label>
                                        <input type="number" name="config_pontos_para_resgatar" id="config_pontos_para_resgatar" 
                                               class="form-control" min="50" max="1000" 
                                               value="<?= $data['config']->config_pontos_para_resgatar ?? 100 ?>">
                                        <small class="text-muted">Pontos mínimos para trocar</small>
                                    </div>
                                </div>
                                
                                <!-- VALOR DO RESGATE -->
                                <div class="col-md-3 campo-pontos" style="display:none;">
                                    <div class="form-group">
                                        <label for="config_valor_resgate_pontos">
                                            <i class="fa fa-dollar"></i> Valor do Resgate (R$)
                                        </label>
                                        <input type="number" step="0.01" name="config_valor_resgate_pontos" id="config_valor_resgate_pontos" 
                                               class="form-control" min="1" max="100" 
                                               value="<?= $data['config']->config_valor_resgate_pontos ?? 5.00 ?>">
                                        <small class="text-muted">100 pontos = R$ X de desconto</small>
                                    </div>
                                </div>
                                
                                <!-- DESCONTO MÁXIMO -->
                                <div class="col-md-3 campo-ambos" style="display:none;">
                                    <div class="form-group">
                                        <label for="config_fidelidade_max_desconto">
                                            <i class="fa fa-percent"></i> Desconto Máximo (R$)
                                        </label>
                                        <input type="number" step="0.01" name="config_fidelidade_max_desconto" id="config_fidelidade_max_desconto" 
                                               class="form-control" min="5" max="100" 
                                               value="<?= $data['config']->config_fidelidade_max_desconto ?? 20.00 ?>">
                                        <small class="text-muted">Máximo por pedido</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- PERCENTUAL CASHBACK -->
                                <div class="col-md-4 campo-cashback" style="display:none;">
                                    <div class="form-group">
                                        <label for="config_cashback_percentual">
                                            <i class="fa fa-percent"></i> Cashback (%)
                                        </label>
                                        <input type="number" step="0.01" name="config_cashback_percentual" id="config_cashback_percentual" 
                                               class="form-control" min="1" max="20" 
                                               value="<?= $data['config']->config_cashback_percentual ?? 5.00 ?>">
                                        <small class="text-muted">% de cashback sobre pedido</small>
                                    </div>
                                </div>
                                
                                <!-- PEDIDO MÍNIMO CASHBACK -->
                                <div class="col-md-4 campo-cashback" style="display:none;">
                                    <div class="form-group">
                                        <label for="config_cashback_minimo_pedido">
                                            <i class="fa fa-shopping-cart"></i> Pedido Mínimo Cashback (R$)
                                        </label>
                                        <input type="number" step="0.01" name="config_cashback_minimo_pedido" id="config_cashback_minimo_pedido" 
                                               class="form-control" min="10" max="200" 
                                               value="<?= $data['config']->config_cashback_minimo_pedido ?? 30.00 ?>">
                                        <small class="text-muted">Valor mínimo para cashback</small>
                                    </div>
                                </div>
                            </div>

                            <!-- SEPARADOR VISUAL -->
                            <div class="row campo-bonus">
                                <div class="col-md-12">
                                    <hr style="border-top: 2px solid #3498db; margin: 20px 0;">
                                    <h4 style="color: #3498db;"><i class="fa fa-gift"></i> Bônus e Recompensas Extras</h4>
                                </div>
                            </div>

                            <div class="row campo-bonus">
                                <!-- BÔNUS PRIMEIRA COMPRA -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="config_bonus_primeira_compra">
                                            <i class="fa fa-star"></i> Bônus 1ª Compra
                                        </label>
                                        <input type="number" name="config_bonus_primeira_compra" id="config_bonus_primeira_compra" 
                                               class="form-control" min="0" max="500" 
                                               value="<?= $data['config']->config_bonus_primeira_compra ?? 100 ?>">
                                        <small class="text-muted">Pontos no 1º pedido</small>
                                    </div>
                                </div>
                                
                                <!-- BÔNUS ANIVERSÁRIO -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="config_bonus_aniversario">
                                            <i class="fa fa-birthday-cake"></i> Bônus Aniversário
                                        </label>
                                        <input type="number" name="config_bonus_aniversario" id="config_bonus_aniversario" 
                                               class="form-control" min="0" max="500" 
                                               value="<?= $data['config']->config_bonus_aniversario ?? 200 ?>">
                                        <small class="text-muted">Pontos no aniversário</small>
                                    </div>
                                </div>
                                
                                <!-- BÔNUS AVALIAÇÃO -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="config_bonus_avaliacao">
                                            <i class="fa fa-thumbs-up"></i> Bônus Avaliação
                                        </label>
                                        <input type="number" name="config_bonus_avaliacao" id="config_bonus_avaliacao" 
                                               class="form-control" min="0" max="200" 
                                               value="<?= $data['config']->config_bonus_avaliacao ?? 50 ?>">
                                        <small class="text-muted">Pontos por avaliar</small>
                                    </div>
                                </div>
                                
                                <!-- BÔNUS INDICAÇÃO -->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="config_bonus_indicacao">
                                            <i class="fa fa-users"></i> Bônus Indicação
                                        </label>
                                        <input type="number" name="config_bonus_indicacao" id="config_bonus_indicacao" 
                                               class="form-control" min="0" max="500" 
                                               value="<?= $data['config']->config_bonus_indicacao ?? 150 ?>">
                                        <small class="text-muted">Pontos por indicar</small>
                                    </div>
                                </div>
                            </div>

                            <!-- ========== CAMPOS PARA FREQUÊNCIA ========== -->
                            <div class="row campo-frequencia" style="display:none;">
                                <div class="col-md-12">
                                    <hr>
                                    <h4 style="color: #11998e;"><i class="fa fa-gift"></i> Programa "A cada X pedidos, ganhe Y% de desconto"</h4>
                                    <div class="alert alert-info">
                                        <i class="fa fa-info-circle"></i> <strong>Exemplo:</strong> "A cada 3 pedidos, o 4º ganha 10% de desconto"
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="config_fidelidade_frequencia_pedidos">
                                            <i class="fa fa-shopping-bag"></i> A cada quantos pedidos?
                                        </label>
                                        <input type="number" name="config_fidelidade_frequencia_pedidos" id="config_fidelidade_frequencia_pedidos" 
                                               class="form-control" min="1" 
                                               value="<?= $data['config']->config_fidelidade_frequencia_pedidos ?? 3 ?>">
                                        <small class="text-muted">Padrão: 3 (ou seja, o 4º pedido ganha desconto)</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="config_fidelidade_frequencia_percentual">
                                            <i class="fa fa-percent"></i> Percentual de Desconto (%)
                                        </label>
                                        <input type="number" step="0.01" name="config_fidelidade_frequencia_percentual" id="config_fidelidade_frequencia_percentual" 
                                               class="form-control" min="0" max="100" 
                                               value="<?= $data['config']->config_fidelidade_frequencia_percentual ?? 10 ?>">
                                        <small class="text-muted">Padrão: 10%</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="alert alert-warning">
                                        <i class="fa fa-exclamation-triangle"></i> <strong>Atenção:</strong> O desconto é aplicado automaticamente no checkout quando o cliente atingir a meta de pedidos entregues.
                                    </div>
                                </div>
                            </div>

                            <br>
                            <p class="text-center">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> Salvar Configurações</button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/jquery.cooki/jquery.cooki.js"></script>
    <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="js/behaviour/core.js"></script>
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="app-js/main.js"></script>
    <script type="text/javascript">
        var baseUri = '<?php echo $baseUri; ?>';
        $('#menu-fidelidade').addClass('active');

        // Controlar visibilidade dos campos conforme tipo de programa
        function toggleCamposPorTipo() {
            const tipo = document.getElementById('config_fidelidade_tipo').value;
            
            // Ocultar todos primeiro
            document.querySelectorAll('.campo-pontos, .campo-cashback, .campo-ambos, .campo-bonus, .campo-frequencia').forEach(el => {
                el.style.display = 'none';
                // Desabilitar inputs para não enviar no POST
                el.querySelectorAll('input, select').forEach(input => {
                    input.disabled = true;
                });
            });
            
            // Mostrar campos baseado no tipo
            if (tipo === 'frequencia') {
                // Mostrar apenas campos de frequência (SEM bônus)
                document.querySelectorAll('.campo-frequencia').forEach(el => {
                    el.style.display = 'block';
                    // Habilitar inputs de frequência
                    el.querySelectorAll('input, select').forEach(input => {
                        input.disabled = false;
                    });
                });
            } else if (tipo === 'pontos') {
                // Mostrar campos de pontos + bônus
                document.querySelectorAll('.campo-pontos, .campo-bonus').forEach(el => {
                    el.style.display = 'block';
                    el.querySelectorAll('input, select').forEach(input => {
                        input.disabled = false;
                    });
                });
            } else if (tipo === 'cashback') {
                // Mostrar campos de cashback + bônus
                document.querySelectorAll('.campo-cashback, .campo-bonus').forEach(el => {
                    el.style.display = 'block';
                    el.querySelectorAll('input, select').forEach(input => {
                        input.disabled = false;
                    });
                });
            } else if (tipo === 'ambos') {
                // Mostrar todos os campos (pontos, cashback, ambos, bônus)
                document.querySelectorAll('.campo-pontos, .campo-cashback, .campo-ambos, .campo-bonus').forEach(el => {
                    el.style.display = 'block';
                    el.querySelectorAll('input, select').forEach(input => {
                        input.disabled = false;
                    });
                });
            }
        }

        // Atualizar ao carregar página
        document.addEventListener('DOMContentLoaded', function() {
            toggleCamposPorTipo();
            
            // Atualizar quando alterar tipo (removido listener do status)
            document.getElementById('config_fidelidade_tipo').addEventListener('change', toggleCamposPorTipo);
            
            // Formatar campo de percentual para remover zeros decimais desnecessários
            const percentualInput = document.getElementById('config_fidelidade_frequencia_percentual');
            if (percentualInput) {
                // Formatar ao carregar
                formatarPercentual(percentualInput);
                
                // Formatar ao perder foco
                percentualInput.addEventListener('blur', function() {
                    formatarPercentual(this);
                });
            }
        });
        
        // Função para formatar percentual
        function formatarPercentual(input) {
            let valor = parseFloat(input.value);
            if (!isNaN(valor)) {
                // Se for número inteiro, remover decimais
                if (Math.floor(valor) === valor) {
                    input.value = Math.floor(valor);
                } else {
                    // Se tiver decimais, manter até 2 casas
                    input.value = valor.toFixed(2).replace(/\.?0+$/, '');
                }
            }
        }
    </script>
</body>

</html>
