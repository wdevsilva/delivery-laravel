<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery.select2/dist/css/select2.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap-multiselect.css">
    <style>
        /* Cards de Tipo de Promoção */
        .promo-type-card {
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fff;
            min-height: 180px;
        }
        .promo-type-card:hover {
            border-color: #3498db;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.2);
            transform: translateY(-2px);
        }
        .promo-type-card.active {
            border-color: #27ae60;
            background: linear-gradient(145deg, #f0fff4 0%, #e8f8ed 100%);
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.25);
        }
        .promo-type-card .icon {
            font-size: 2.8em;
            margin-bottom: 12px;
            color: #3498db;
            transition: all 0.3s;
        }
        .promo-type-card:hover .icon { color: #2980b9; }
        .promo-type-card.active .icon { color: #27ae60; }
        .promo-type-card h5 { margin-bottom: 8px; color: #2c3e50; }
        .promo-type-card .text-muted { font-size: 12px; }
        .promo-type-card .badge-example {
            background: #e8f4fc;
            color: #2980b9;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            display: inline-block;
            margin-top: 8px;
        }
        .promo-type-card.active .badge-example {
            background: #d4edda;
            color: #155724;
        }
        
        /* Steps e Seções */
        .step-section {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 20px;
        }
        .step-header {
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .step-header h4 {
            margin: 0;
            color: #2c3e50;
            font-weight: 600;
        }
        .step-header .step-number {
            background: #3498db;
            color: #fff;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: bold;
        }
        
        /* Info Box */
        .info-box {
            background: linear-gradient(135deg, #e8f4fc 0%, #d4e9f7 100%);
            border-left: 4px solid #3498db;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 0 8px 8px 0;
        }
        .info-box i { color: #3498db; margin-right: 8px; }
        .info-box strong { color: #2c3e50; }
        
        /* Campos Condicionais */
        .campo-condicional { display: none; }
        
        /* Lista de Produtos Combo */
        #produtos-combo-list {
            max-height: 250px;
            overflow-y: auto;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px;
            background: #fafafa;
        }
        .produto-combo-item {
            padding: 12px 15px;
            margin: 8px 0;
            background: #fff;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e9ecef;
            transition: all 0.2s;
        }
        .produto-combo-item:hover {
            border-color: #3498db;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .produto-combo-item .badge {
            background: #e8f4fc;
            color: #2980b9;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
        }
        
        /* Botões Toggle Sim/Não - Bootstrap 3 */
        .btn-toggle-group {
            display: inline-flex;
        }
        .btn-toggle-group .btn {
            padding: 8px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
            margin: 0 2px;
        }
        .btn-toggle-group .btn input[type="radio"] {
            display: none;
        }
        .btn-toggle-group .btn-sim {
            background: #fff;
            border: 2px solid #27ae60;
            color: #27ae60;
        }
        .btn-toggle-group .btn-sim.active,
        .btn-toggle-group .btn-sim:hover {
            background: #27ae60;
            color: #fff;
        }
        .btn-toggle-group .btn-nao {
            background: #fff;
            border: 2px solid #e74c3c;
            color: #e74c3c;
        }
        .btn-toggle-group .btn-nao.active,
        .btn-toggle-group .btn-nao:hover {
            background: #e74c3c;
            color: #fff;
        }
        
        /* Botões */
        .btn-submit-lg {
            padding: 15px 40px;
            font-size: 16px;
            border-radius: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        .btn-submit-lg:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        
        /* Form Controls */
        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.15);
        }
        .form-group label { font-weight: 600; color: #34495e; margin-bottom: 8px; }
        .form-group label i { color: #7f8c8d; margin-right: 5px; }
        
        /* Tooltips instantâneos */
        .tooltip-icon {
            cursor: help;
            margin-left: 5px;
        }
        .tooltip.in {
            opacity: 1;
        }
        .tooltip-inner {
            max-width: 300px;
            text-align: left;
            padding: 8px 12px;
        }
        
        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.9);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            flex-direction: column;
        }
        .loading-overlay.show { display: flex; }
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #e9ecef;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        
        /* Alerts animados */
        .alert-float {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            min-width: 300px;
            animation: slideIn 0.3s ease;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
</head>
<body class="animated">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loading">
        <div class="loading-spinner"></div>
        <p class="mt-3 text-muted">Salvando promoção...</p>
    </div>

    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php require_once 'side-menu.php'; ?>
        </div>
        <div class="container-fluid" id="pcont">
            <?php require_once 'top-menu.php'; ?>
            <div class="cl-mcont">
                
                <?php
                $editing = isset($data['editing']) && $data['editing'];
                $promo = $data['promocao'] ?? null;
                $tipo_atual = $promo->promocao_tipo ?? '';
                $diasSemana = isset($promo->promocao_dias_semana) && $promo->promocao_dias_semana !== '' && $promo->promocao_dias_semana !== null 
                    ? explode(',', $promo->promocao_dias_semana) 
                    : [];
                ?>
                
                <!-- Header -->
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-md-12">
                        <div class="block-flat" style="margin-bottom: 0;">
                            <div class="header" style="border-bottom: 0;">
                                <h3>
                                    <i class="fa fa-gift text-success"></i> 
                                    <?= $editing ? 'Editar Promoção' : 'Nova Promoção' ?>
                                    <?php if ($editing && $promo): ?>
                                        <small class="text-muted"> - <?= htmlspecialchars($promo->promocao_titulo) ?></small>
                                    <?php endif; ?>
                                    <a href="<?= $baseUri ?>/promo/" class="btn btn-default pull-right">
                                        <i class="fa fa-arrow-left"></i> Voltar para Lista
                                    </a>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
                
                <form id="form-promocao" autocomplete="off" novalidate>
                    <input type="hidden" name="promocao_id" id="promocao_id" value="<?= $promo->promocao_id ?? '' ?>">
                    <input type="hidden" name="promocao_tipo" id="promocao_tipo" value="<?= $tipo_atual ?>">
                    <input type="hidden" name="promocao_produtos_compra" id="promocao_produtos_compra" value="">
                    
                    <!-- STEP 1: Tipo de Promoção -->
                    <div class="step-section" id="step-tipo">
                        <div class="step-header">
                            <h4><span class="step-number">1</span> Escolha o Tipo de Promoção</h4>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="promo-type-card <?= $tipo_atual == 'quantidade_categoria' ? 'active' : '' ?>" data-tipo="quantidade_categoria">
                                    <div class="text-center">
                                        <div class="icon"><i class="fa fa-th-large"></i></div>
                                        <h5><strong>Por Categoria</strong></h5>
                                        <p class="text-muted">Compre X itens de uma categoria e ganhe</p>
                                        <span class="badge-example"><i class="fa fa-check"></i> Compre 2 pizzas, ganhe refri</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="promo-type-card <?= $tipo_atual == 'valor_minimo' ? 'active' : '' ?>" data-tipo="valor_minimo">
                                    <div class="text-center">
                                        <div class="icon"><i class="fa fa-dollar"></i></div>
                                        <h5><strong>Por Valor Mínimo</strong></h5>
                                        <p class="text-muted">Compras acima de R$ X ganham prêmio</p>
                                        <span class="badge-example"><i class="fa fa-check"></i> Acima de R$50, ganhe sobremesa</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="promo-type-card <?= $tipo_atual == 'produto_especifico' ? 'active' : '' ?>" data-tipo="produto_especifico">
                                    <div class="text-center">
                                        <div class="icon"><i class="fa fa-shopping-basket"></i></div>
                                        <h5><strong>Produto Específico</strong></h5>
                                        <p class="text-muted">Compre produto X e ganhe produto Y</p>
                                        <span class="badge-example"><i class="fa fa-check"></i> Compre hambúrguer, ganhe batata</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="promo-type-card <?= $tipo_atual == 'combo' ? 'active' : '' ?>" data-tipo="combo">
                                    <div class="text-center">
                                        <div class="icon"><i class="fa fa-cubes"></i></div>
                                        <h5><strong>Combo</strong></h5>
                                        <p class="text-muted">Combine produtos específicos para ganhar</p>
                                        <span class="badge-example"><i class="fa fa-check"></i> Pizza + Refri = sobremesa grátis</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- STEP 2: Dados Básicos -->
                    <div class="step-section" id="step-basico" style="display: <?= $editing ? 'block' : 'none' ?>;">
                        <div class="step-header">
                            <h4><span class="step-number">2</span> Dados Básicos</h4>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fa fa-tag"></i> Título da Promoção *</label>
                                    <input type="text" name="promocao_titulo" id="promocao_titulo" class="form-control input-lg" 
                                           placeholder="Ex: PIZZA EM DOBRO" value="<?= htmlspecialchars($promo->promocao_titulo ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>
                                        <i class="fa fa-sort-numeric-asc"></i> Prioridade
                                        <i class="fa fa-info-circle text-info tooltip-icon" 
                                           data-toggle="tooltip" data-placement="top"
                                           title="Define a ordem em que as promoções são verificadas. Quanto MENOR o número, MAIOR a prioridade. Ex: Prioridade 1 é verificada antes da Prioridade 2."></i>
                                    </label>
                                    <input type="number" name="promocao_prioridade" id="promocao_prioridade" class="form-control" 
                                           value="<?= $promo->promocao_prioridade ?? 1 ?>" min="1">
                                    <small class="text-muted">Menor = maior prioridade</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>
                                        <i class="fa fa-clone"></i> Acumula com outras?
                                        <i class="fa fa-info-circle text-info tooltip-icon" 
                                           data-toggle="tooltip" data-placement="top"
                                           title="Se SIM, esta promoção pode ser aplicada junto com outras no mesmo pedido. Se NÃO, apenas uma promoção será aplicada (a de maior prioridade)."></i>
                                    </label><br>
                                    <div class="btn-toggle-group">
                                        <label class="btn btn-sim <?= (!$promo || $promo->promocao_acumulativa == 1) ? 'active' : '' ?>">
                                            <input type="radio" name="promocao_acumulativa" value="1" <?= (!$promo || $promo->promocao_acumulativa == 1) ? 'checked' : '' ?>> Sim
                                        </label>
                                        <label class="btn btn-nao <?= ($promo && $promo->promocao_acumulativa == 0) ? 'active' : '' ?>">
                                            <input type="radio" name="promocao_acumulativa" value="0" <?= ($promo && $promo->promocao_acumulativa == 0) ? 'checked' : '' ?>> Não
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fa fa-comment"></i> Descrição Início *</label>
                                    <input type="text" name="promocao_descricao" id="promocao_descricao" class="form-control" 
                                           placeholder="Ex: NA COMPRA DE" value="<?= htmlspecialchars($promo->promocao_descricao ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fa fa-comment-o"></i> Descrição Fim *</label>
                                    <input type="text" name="promocao_descricao_fim" id="promocao_descricao_fim" class="form-control" 
                                           placeholder="Ex: VOCÊ GANHA" value="<?= htmlspecialchars($promo->promocao_descricao_fim ?? '') ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- STEP 3: Regras da Promoção -->
                    <div class="step-section" id="step-regras" style="display: <?= $editing ? 'block' : 'none' ?>;">
                        <div class="step-header">
                            <h4><span class="step-number">3</span> Regras da Promoção</h4>
                        </div>
                        
                        <!-- Campos: Quantidade por Categoria -->
                        <div class="campo-condicional" id="campos-quantidade_categoria" style="display: <?= $tipo_atual == 'quantidade_categoria' ? 'block' : 'none' ?>;">
                            <div class="info-box">
                                <i class="fa fa-info-circle"></i>
                                <strong>Por Categoria:</strong> O cliente compra X produtos de UMA OU MAIS categorias e ganha um prêmio.
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label><i class="fa fa-folder-open"></i> Categorias * <small class="text-muted">(selecione uma ou mais)</small></label>
                                        <?php 
                                        // Obter categorias selecionadas (string separada por vírgula)
                                        $categorias_sel = [];
                                        if (isset($promo->promocao_categoria) && !empty($promo->promocao_categoria)) {
                                            $categorias_sel = explode(',', $promo->promocao_categoria);
                                            $categorias_sel = array_map('trim', $categorias_sel);
                                        }
                                        ?>
                                        <select class="form-control select2" multiple="multiple" name="promocao_categoria[]" id="promocao_categoria" required style="width: 100%;">
                                            <?php if (isset($data['categoria'])) foreach ($data['categoria'] as $cat): ?>
                                                <?php $selected = in_array((string)$cat->categoria_id, $categorias_sel, true) ? 'selected' : ''; ?>
                                                <option value="<?= $cat->categoria_id ?>" <?= $selected ?>>
                                                    <?= htmlspecialchars($cat->categoria_nome) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-shopping-cart"></i> Quantidade Mínima *</label>
                                        <input type="number" name="promocao_qtd_compra" id="promocao_qtd_compra" class="form-control" 
                                               min="1" value="<?= $promo->promocao_qtd_compra ?? 2 ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Campos: Valor Mínimo -->
                        <div class="campo-condicional" id="campos-valor_minimo" style="display: <?= $tipo_atual == 'valor_minimo' ? 'block' : 'none' ?>;">
                            <div class="info-box">
                                <i class="fa fa-info-circle"></i>
                                <strong>Por Valor:</strong> O cliente faz uma compra acima de determinado valor e ganha um prêmio.
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-money"></i> Valor Mínimo (R$) *</label>
                                        <input type="number" name="promocao_valor_minimo" id="promocao_valor_minimo" class="form-control" 
                                               min="0" step="0.01" placeholder="50.00" value="<?= $promo->promocao_valor_minimo ?? '' ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-clock-o"></i> Horário Início</label>
                                        <input type="time" name="promocao_hora_inicio" id="promocao_hora_inicio" class="form-control" 
                                               value="<?= $promo->promocao_hora_inicio ?? '' ?>">
                                        <small class="text-muted">Deixe vazio = 24h</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-clock-o"></i> Horário Fim</label>
                                        <input type="time" name="promocao_hora_fim" id="promocao_hora_fim" class="form-control" 
                                               value="<?= $promo->promocao_hora_fim ?? '' ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Campos: Produto Específico -->
                        <?php 
                        // Extrair ID do produto específico do JSON salvo
                        $produto_especifico_id = 0;
                        
                        if ($tipo_atual == 'produto_especifico' && !empty($promo->promocao_produtos_compra)) {
                            $json_str = $promo->promocao_produtos_compra;
                            
                            // Tentar json_decode primeiro
                            $arr = json_decode($json_str, true);
                            if (is_array($arr) && isset($arr[0]['id'])) {
                                $produto_especifico_id = (int)$arr[0]['id'];
                            } elseif (is_array($arr) && isset($arr['produtos'][0]['id'])) {
                                $produto_especifico_id = (int)$arr['produtos'][0]['id'];
                            } else {
                                // Fallback: extrair via regex
                                if (preg_match('/"id"\s*:\s*(\d+)/', $json_str, $matches)) {
                                    $produto_especifico_id = (int)$matches[1];
                                }
                            }
                        }
                        ?>
                        <input type="hidden" id="produto_especifico_id_valor" value="<?= $produto_especifico_id ?>">
                        <div class="campo-condicional" id="campos-produto_especifico" style="display: <?= $tipo_atual == 'produto_especifico' ? 'block' : 'none' ?>;">
                            <div class="info-box">
                                <i class="fa fa-info-circle"></i>
                                <strong>Produto Específico:</strong> O cliente compra um produto específico e ganha outro.
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fa fa-cube"></i> Produto que deve ser comprado *</label>
                                        <select name="produto_compra_simples" id="produto_compra_simples" class="form-control select2">
                                            <option value="">Selecione o produto...</option>
                                            <?php if (isset($data['produto'])) foreach ($data['produto'] as $prod): ?>
                                                <option value="<?= $prod->item_id ?>" <?= ((int)$produto_especifico_id === (int)$prod->item_id) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($prod->item_nome) ?> - R$ <?= number_format($prod->item_preco, 2, ',', '.') ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Campos: Combo -->
                        <div class="campo-condicional" id="campos-combo" style="display: <?= $tipo_atual == 'combo' ? 'block' : 'none' ?>;">
                            <div class="info-box">
                                <i class="fa fa-info-circle"></i>
                                <strong>Combo:</strong> O cliente precisa comprar produtos específicos juntos para ganhar o prêmio.
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label><i class="fa fa-plus-circle"></i> Adicionar Produto ao Combo</label>
                                        <select id="produto_combo_select" class="form-control select2">
                                            <option value="">Selecione um produto...</option>
                                            <?php if (isset($data['produto'])) foreach ($data['produto'] as $prod): ?>
                                                <option value="<?= $prod->item_id ?>" data-nome="<?= htmlspecialchars($prod->item_nome) ?>" data-preco="<?= $prod->item_preco ?>">
                                                    <?= htmlspecialchars($prod->item_nome) ?> - R$ <?= number_format($prod->item_preco, 2, ',', '.') ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Quantidade</label>
                                        <input type="number" id="qtd_produto_combo" class="form-control" value="1" min="1">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-success btn-block" id="btn-add-produto-combo">
                                            <i class="fa fa-plus"></i> Adicionar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label><i class="fa fa-list"></i> Produtos do Combo: <span id="combo-count" class="badge badge-info">0</span></label>
                                    <div id="produtos-combo-list">
                                        <div class="text-center text-muted py-3">
                                            <i class="fa fa-info-circle"></i> Adicione pelo menos 2 produtos ao combo
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- STEP 4: Prêmio -->
                    <div class="step-section" id="step-premio" style="display: <?= $editing ? 'block' : 'none' ?>;">
                        <div class="step-header">
                            <h4><span class="step-number">4</span> Configurar Prêmio</h4>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label><i class="fa fa-hashtag"></i> Quantidade *</label>
                                    <input type="number" name="promocao_premio_qtd" id="promocao_premio_qtd" class="form-control" 
                                           min="1" value="<?= $promo->promocao_premio_qtd ?? 1 ?>" required>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label><i class="fa fa-gift"></i> Produto do Prêmio (do estoque)</label>
                                    <select name="promocao_premio_item_id" id="promocao_premio_item_id" class="form-control select2">
                                        <option value="">Ou escreva o nome abaixo...</option>
                                        <?php if (isset($data['produto'])) foreach ($data['produto'] as $prod): ?>
                                            <option value="<?= $prod->item_id ?>" <?= (isset($promo->promocao_premio_item_id) && $promo->promocao_premio_item_id == $prod->item_id) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($prod->item_nome) ?> - R$ <?= number_format($prod->item_preco, 2, ',', '.') ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label><i class="fa fa-text-width"></i> OU Nome do Prêmio (texto livre)</label>
                                    <input type="text" name="promocao_premio_produto" id="promocao_premio_produto" class="form-control" 
                                           placeholder="Ex: REFRIGERANTE 2L GRÁTIS" value="<?= htmlspecialchars($promo->promocao_premio_produto ?? '') ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><i class="fa fa-bullhorn"></i> Mensagem ao Cliente *</label>
                                    <input type="text" name="promocao_premio_mensagem" id="promocao_premio_mensagem" class="form-control" 
                                           placeholder="Ex: PARABÉNS! VOCÊ GANHOU" value="<?= htmlspecialchars($promo->promocao_premio_mensagem ?? 'PARABÉNS! VOCÊ GANHOU') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><i class="fa fa-archive"></i> Descontar do Estoque?</label><br>
                                    <div class="btn-toggle-group">
                                        <label class="btn btn-sim <?= ($promo && $promo->promocao_desconta_estoque == 1) ? 'active' : '' ?>">
                                            <input type="radio" name="promocao_desconta_estoque" value="1" <?= ($promo && $promo->promocao_desconta_estoque == 1) ? 'checked' : '' ?>> Sim
                                        </label>
                                        <label class="btn btn-nao <?= (!$promo || $promo->promocao_desconta_estoque == 0) ? 'active' : '' ?>">
                                            <input type="radio" name="promocao_desconta_estoque" value="0" <?= (!$promo || $promo->promocao_desconta_estoque == 0) ? 'checked' : '' ?>> Não
                                        </label>
                                    </div>
                                    <small class="text-muted" style="display:block;">Requer produto vinculado</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- STEP 5: Período e Limites -->
                    <div class="step-section" id="step-periodo" style="display: <?= $editing ? 'block' : 'none' ?>;">
                        <div class="step-header">
                            <h4><span class="step-number">5</span> Período e Limites</h4>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><i class="fa fa-calendar-check-o"></i> Dias da Semana *</label>
                                    <select class="multiselect" multiple="multiple" name="promocao_dias_semana[]" id="promocao_dias_semana" required>
                                        <?php
                                        $dias_map = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
                                        for ($i = 0; $i <= 6; $i++):
                                            $selected = in_array((string)$i, $diasSemana, true) ? 'selected' : '';
                                        ?>
                                            <option value="<?= $i ?>" <?= $selected ?>><?= $dias_map[$i] ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                               <div class="form-group">
                                    <label>
                                        <i class="fa fa-calendar"></i> Data Início
                                        <i class="fa fa-info-circle" data-toggle="tooltip" title="Data a partir da qual a promoção estará ativa. Deixe vazio para ativar imediatamente" style="cursor:help;opacity:0.7;"></i>
                                    </label>
                                    <input type="date" name="promocao_data_inicio" id="promocao_data_inicio" class="form-control" 
                                           value="<?= $promo->promocao_data_inicio ?? '' ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>
                                        <i class="fa fa-calendar"></i> Data Fim
                                        <i class="fa fa-info-circle" data-toggle="tooltip" title="Data até quando a promoção estará ativa. Deixe vazio para promoção sem data de término" style="cursor:help;opacity:0.7;"></i>
                                    </label>
                                    <input type="date" name="promocao_data_fim" id="promocao_data_fim" class="form-control" 
                                           value="<?= $promo->promocao_data_fim ?? '' ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>
                                        <i class="fa fa-users"></i> Limite Global
                                        <i class="fa fa-info-circle" data-toggle="tooltip" title="Número máximo de vezes que essa promoção pode ser usada no total (por todos os clientes). Deixe vazio para ilimitado" style="cursor:help;opacity:0.7;"></i>
                                    </label>
                                    <input type="number" name="promocao_limite_uso" id="promocao_limite_uso" class="form-control" 
                                           min="0" placeholder="Ilimitado" value="<?= $promo->promocao_limite_uso ?? '' ?>">
                                    <small class="text-muted">Total de usos</small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>
                                        <i class="fa fa-user"></i> Limite/Cliente
                                        <i class="fa fa-info-circle" data-toggle="tooltip" title="Número máximo de vezes que cada cliente pode usar essa promoção. Deixe vazio para ilimitado por cliente" style="cursor:help;opacity:0.7;"></i>
                                    </label>
                                    <input type="number" name="promocao_limite_cliente" id="promocao_limite_cliente" class="form-control" 
                                           min="0" placeholder="Ilimitado" value="<?= $promo->promocao_limite_cliente ?? '' ?>">
                                    <small class="text-muted">Por pessoa</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Botões de Ação -->
                    <div class="step-section text-center" id="btn-submit-container" style="display: <?= $editing ? 'block' : 'none' ?>;">
                        <button type="submit" class="btn btn-success btn-submit-lg" id="btn-salvar">
                            <i class="fa fa-check-circle"></i> <?= $editing ? 'SALVAR ALTERAÇÕES' : 'CRIAR PROMOÇÃO' ?>
                        </button>
                        <a href="<?= $baseUri ?>/promo/" class="btn btn-default btn-submit-lg">
                            <i class="fa fa-times-circle"></i> CANCELAR
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.select2/dist/js/select2.js"></script>
    <script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
    <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
    <script src="js/jquery.cooki/jquery.cooki.js"></script>
    <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
    <script type="text/javascript" src="js/behaviour/core.js"></script>
    
    <script>
    var baseUri = '<?= $baseUri ?>';
    var produtosCombo = [];
    var isEditing = <?= $editing ? 'true' : 'false' ?>;
    
    $(document).ready(function() {
        // Inicializar Select2
        $('.select2').select2({ width: '100%' });
        
        // Inicializar tooltips (instantâneo)
        $('[data-toggle="tooltip"]').tooltip({
            delay: { show: 0, hide: 100 },
            trigger: 'hover'
        });
        
        // Inicializar Multiselect
        $('#promocao_dias_semana').multiselect({
            includeSelectAllOption: true,
            selectAllText: 'Todos os dias',
            nonSelectedText: 'Selecione os dias',
            allSelectedText: 'Todos os dias',
            nSelectedText: ' dias selecionados',
            maxHeight: 300
        });
        
        // Marcar menu ativo
        $('#menu-promocoes').addClass('active');
        
        // ============ BOTÕES TOGGLE SIM/NÃO ============
        $('.btn-toggle-group .btn').on('click', function(e) {
            e.preventDefault();
            var $group = $(this).closest('.btn-toggle-group');
            $group.find('.btn').removeClass('active');
            $(this).addClass('active');
            $(this).find('input[type="radio"]').prop('checked', true);
        });
        
        // Carregar produtos do combo se editando
        <?php if ($editing && !empty($promo->produtos_combo)): 
            // Suportar ambos os formatos: {"produtos":[...]} ou array direto [...]
            $combo_produtos = is_array($promo->produtos_combo) 
                ? (isset($promo->produtos_combo['produtos']) ? $promo->produtos_combo['produtos'] : $promo->produtos_combo)
                : [];
        ?>
        produtosCombo = <?= json_encode($combo_produtos) ?>;
        atualizarListaCombo();
        <?php endif; ?>
        
        // Setar produto específico no Select2 após inicialização
        var produtoEspecificoId = $('#produto_especifico_id_valor').val();
        if (produtoEspecificoId) {
            $('#produto_compra_simples').val(produtoEspecificoId).trigger('change');
        }
        
        // ============ SELEÇÃO DO TIPO DE PROMOÇÃO ============
        $('.promo-type-card').on('click', function() {
            var tipo = $(this).data('tipo');
            
            // Atualizar visual
            $('.promo-type-card').removeClass('active');
            $(this).addClass('active');
            
            // Atualizar campo hidden
            $('#promocao_tipo').val(tipo);
            
            // Mostrar próximas seções
            $('#step-basico, #step-regras, #step-premio, #step-periodo, #btn-submit-container').slideDown(300);
            
            // Esconder todos os campos condicionais
            $('.campo-condicional').hide();
            
            // Mostrar campos do tipo selecionado
            $('#campos-' + tipo).fadeIn(200);
            
            // Preencher placeholders automaticamente
            preencherPlaceholders(tipo);
        });
        
        // ============ ADICIONAR PRODUTO AO COMBO ============
        $('#btn-add-produto-combo').on('click', function() {
            var $select = $('#produto_combo_select');
            var prodId = $select.val();
            var prodNome = $select.find('option:selected').data('nome');
            var qtd = parseInt($('#qtd_produto_combo').val()) || 1;
            
            if (!prodId) {
                showAlert('warning', 'Selecione um produto!');
                return;
            }
            
            // Verificar duplicidade
            var existe = produtosCombo.find(p => p.id == prodId);
            if (existe) {
                showAlert('warning', 'Este produto já está no combo!');
                return;
            }
            
            produtosCombo.push({
                id: parseInt(prodId),
                nome: prodNome,
                qtd: qtd
            });
            
            atualizarListaCombo();
            $select.val('').trigger('change');
            $('#qtd_produto_combo').val(1);
            showAlert('success', 'Produto adicionado ao combo!');
        });
        
        // ============ SUBMIT DO FORMULÁRIO ============
        $('#form-promocao').on('submit', function(e) {
            e.preventDefault();
            
            var tipo = $('#promocao_tipo').val();
            
            // Validação do tipo
            if (!tipo) {
                showAlert('danger', 'Selecione o tipo de promoção!');
                return;
            }
            
            // Validação específica para combo
            if (tipo === 'combo' && produtosCombo.length < 2) {
                showAlert('danger', 'O combo precisa ter pelo menos 2 produtos!');
                return;
            }
            
            // Montar JSON de produtos
            if (tipo === 'produto_especifico') {
                // Para produto específico, pegar do select
                var prodId = $('#produto_compra_simples').val();
                var prodNome = $('#produto_compra_simples option:selected').text();
                if (prodId) {
                    var dados = { produtos: [{id: parseInt(prodId), nome: prodNome, qtd: 1}], qtd_cada: 1 };
                    $('#promocao_produtos_compra').val(JSON.stringify(dados));
                }
            } else if (tipo === 'combo') {
                var dados = { produtos: produtosCombo, qtd_cada: 1 };
                $('#promocao_produtos_compra').val(JSON.stringify(dados));
            }
            
            // Coletar dados do formulário via serialize
            var formData = $(this).serializeArray();
            
            // Tratar categorias múltiplas para quantidade_categoria
            if (tipo === 'quantidade_categoria') {
                var categoriasArray = $('#promocao_categoria').val(); // Retorna array do select2
                
                // Remover TODOS os campos relacionados a promocao_categoria
                formData = formData.filter(function(item) {
                    return item.name !== 'promocao_categoria[]' && item.name !== 'promocao_categoria';
                });
                
                // Adicionar categorias como string separada por vírgula
                if (categoriasArray && categoriasArray.length > 0) {
                    formData.push({ name: 'promocao_categorias_str', value: categoriasArray.join(',') });
                }
            }
            
            // Garantir que campos de divs ocultos sejam incluídos
            formData.push({ name: 'promocao_qtd_compra', value: $('#promocao_qtd_compra').val() || '1' });
            formData.push({ name: 'promocao_valor_minimo', value: $('#promocao_valor_minimo').val() || '' });
            
            // Garantir que o JSON de produtos seja enviado (para combo e produto_especifico)
            var produtosJson = $('#promocao_produtos_compra').val();
            if (produtosJson) {
                formData.push({ name: 'promocao_produtos_compra', value: produtosJson });
            }
            
            // Converter para string URL encoded manualmente (para preservar arrays)
            var formDataString = formData.map(function(item) {
                return encodeURIComponent(item.name) + '=' + encodeURIComponent(item.value);
            }).join('&');
            
            // Mostrar loading
            $('#loading').addClass('show');
            
            // Enviar via AJAX
            $.ajax({
                url: baseUri + '/promo/gravar/',
                type: 'POST',
                data: formDataString,
                dataType: 'json',
                success: function(response) {
                    $('#loading').removeClass('show');
                    
                    if (response.success) {
                        showAlert('success', response.message);
                        setTimeout(function() {
                            window.location.href = response.redirect || baseUri + '/promo/';
                        }, 1500);
                    } else {
                        var erros = response.errors || ['Erro desconhecido'];
                        showAlert('danger', erros.join('<br>'));
                    }
                },
                error: function(xhr, status, error) {
                    $('#loading').removeClass('show');
                    showAlert('danger', 'Erro ao salvar: ' + error);
                }
            });
        });
    });
    
    // ============ FUNÇÕES AUXILIARES ============
    function preencherPlaceholders(tipo) {
        var placeholders = {
            'quantidade_categoria': { inicio: 'NA COMPRA DE', fim: 'VOCÊ GANHA' },
            'valor_minimo': { inicio: 'EM COMPRAS ACIMA DE', fim: 'VOCÊ GANHA' },
            'produto_especifico': { inicio: 'COMPRE', fim: 'E GANHE' },
            'combo': { inicio: 'COMPRE', fim: 'JUNTOS E GANHE' }
        };
        
        if (!isEditing && placeholders[tipo]) {
            $('#promocao_descricao').val(placeholders[tipo].inicio);
            $('#promocao_descricao_fim').val(placeholders[tipo].fim);
        }
    }
    
    function atualizarListaCombo() {
        var $list = $('#produtos-combo-list');
        var html = '';
        
        if (produtosCombo.length === 0) {
            html = '<div class="text-center text-muted py-3"><i class="fa fa-info-circle"></i> Adicione pelo menos 2 produtos ao combo</div>';
        } else {
            produtosCombo.forEach(function(prod, index) {
                html += '<div class="produto-combo-item">';
                html += '  <span><i class="fa fa-cube text-primary"></i> <strong>' + prod.nome + '</strong></span>';
                html += '  <span>';
                html += '    <span class="badge">Qtd: ' + prod.qtd + '</span> ';
                html += '    <button type="button" class="btn btn-danger btn-xs" onclick="removerProdutoCombo(' + index + ')">';
                html += '      <i class="fa fa-trash"></i>';
                html += '    </button>';
                html += '  </span>';
                html += '</div>';
            });
        }
        
        $list.html(html);
        $('#combo-count').text(produtosCombo.length);
    }
    
    function removerProdutoCombo(index) {
        produtosCombo.splice(index, 1);
        atualizarListaCombo();
        showAlert('info', 'Produto removido do combo');
    }
    
    function showAlert(type, message) {
        // Remover alertas anteriores
        $('.alert-float').remove();
        
        var icon = {
            'success': 'check-circle',
            'danger': 'times-circle',
            'warning': 'exclamation-triangle',
            'info': 'info-circle'
        };
        
        var $alert = $('<div class="alert alert-' + type + ' alert-dismissible alert-float">' +
            '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
            '<i class="fa fa-' + (icon[type] || 'info-circle') + '"></i> ' + message +
            '</div>');
        
        $('body').append($alert);
        
        setTimeout(function() {
            $alert.fadeOut(function() { $(this).remove(); });
        }, 5000);
    }
    </script>
</body>
</html>
