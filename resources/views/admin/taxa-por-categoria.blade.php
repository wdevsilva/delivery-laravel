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
    <link rel="stylesheet" type="text/css" href="js/jquery.select2/dist/css/select2.css" />
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
    <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link rel="stylesheet" type="text/css" href="js/bootstrap.summernote/dist/summernote.css" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/btn-upload.css" rel="stylesheet" />
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
                <div class="block-flat">
                    <h3 class="text-center">Configurações De Pagamento Taxa de Cartão de Crédito</h3>
                    <div class="header">
                        <h3>Configuração de Taxa por Categoria Individual</h3>
                        <h5>Defina um valor de taxa específico para cada categoria. O valor total da taxa será calculado multiplicando a taxa da categoria pela quantidade de itens daquela categoria no pedido.</h5>
                    </div>
                    <div class="content">
                        <form action="<?php echo $baseUri; ?>/configuracao/gravarTaxaCartaoCategoria/" method="POST">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr style="background-color: #f5f5f5;">
                                                    <th width="5%">
                                                        <input type="checkbox" id="select-all" title="Selecionar todas as categorias">
                                                    </th>
                                                    <th width="45%">Categoria</th>
                                                    <th width="25%">Taxa por Item (R$)</th>
                                                    <th width="15%">Status</th>
                                                    <th width="10%">Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody id="taxas-tbody">
                                                <?php if (!empty($data['categorias'])): ?>
                                                    <?php foreach($data['categorias'] as $categoria): ?>
                                                        <?php
                                                        $taxa_categoria = null;
                                                        if (!empty($data['taxas_categoria'])) {
                                                            foreach($data['taxas_categoria'] as $taxa) {
                                                                if ($taxa->categoria_id == $categoria->categoria_id) {
                                                                    $taxa_categoria = $taxa;
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                        $tem_taxa = !empty($taxa_categoria);
                                                        $valor_taxa = $tem_taxa ? number_format($taxa_categoria->taxa_valor, 2, ',', '.') : '0,75';
                                                        $ativo = $tem_taxa ? $taxa_categoria->ativo : 1;
                                                        ?>
                                                        <tr data-categoria-id="<?= $categoria->categoria_id ?>">
                                                            <td>
                                                                <input type="checkbox" 
                                                                       name="categorias_selecionadas[]" 
                                                                       value="<?= $categoria->categoria_id ?>"
                                                                       <?= $tem_taxa ? 'checked' : '' ?>
                                                                       class="categoria-checkbox">
                                                            </td>
                                                            <td>
                                                                <strong><?= htmlspecialchars($categoria->categoria_nome) ?></strong>
                                                                <input type="hidden" name="categoria_id[]" value="<?= $categoria->categoria_id ?>">
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">R$</span>
                                                                    <input type="text" 
                                                                           name="taxa_valor[<?= $categoria->categoria_id ?>]" 
                                                                           class="form-control money taxa-input" 
                                                                           placeholder="0,00" 
                                                                           value="<?= $valor_taxa ?>"
                                                                           <?= !$tem_taxa ? 'disabled' : '' ?>>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <select name="ativo[<?= $categoria->categoria_id ?>]" 
                                                                        class="form-control status-select"
                                                                        <?= !$tem_taxa ? 'disabled' : '' ?>>
                                                                    <option value="1" <?= $ativo == 1 ? 'selected' : '' ?>>Ativo</option>
                                                                    <option value="0" <?= $ativo == 0 ? 'selected' : '' ?>>Inativo</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <button type="button" 
                                                                        class="btn btn-xs btn-danger remove-taxa" 
                                                                        data-categoria-id="<?= $categoria->categoria_id ?>"
                                                                        <?= !$tem_taxa ? 'style="display:none;"' : '' ?>>
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="5" class="text-center">
                                                            <em>Nenhuma categoria encontrada. <a href="<?= $baseUri ?>/categoria/">Cadastre categorias primeiro</a>.</em>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-md-12">
                                    <div class="well">
                                        <h4><i class="fa fa-info-circle"></i> Instruções:</h4>
                                        <ul>
                                            <li><strong>Marque as categorias</strong> que terão taxa de cartão aplicada</li>
                                            <li><strong>Defina o valor da taxa</strong> para cada categoria selecionada</li>
                                            <li><strong>Taxa por item:</strong> O valor será multiplicado pela quantidade de itens daquela categoria no pedido</li>
                                            <li><strong>Status:</strong> Permite ativar/desativar temporariamente a taxa de uma categoria</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fa fa-save"></i> Salvar Configurações de Taxa
                                    </button>
                                    <a href="<?php echo $baseUri; ?>/configuracao/taxaCard/" class="btn btn-default btn-lg">
                                        <i class="fa fa-arrow-left"></i> Voltar
                                    </a>
                                </div>
                            </div>
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
    <script type="text/javascript" src="js/jquery.select2/dist/js/select2.js"></script>
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo $baseUri; ?>/assets/vendor/uf-combo/cidades-estados-1.4-utf8.js" charset="utf-8"></script>
    <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery.mask.js"></script>
    <script type="text/javascript" src="js/bootstrap.summernote/dist/summernote.min.js"></script>
    <?php require_once 'switch-color.php'; ?>
    <script src="app-js/main.js"></script>
    <script src="app-js/config.js"></script>
    
    <script type="text/javascript">
        $('#menu-config-taxa-categoria').addClass('active');
        
        // Aplicar máscara de dinheiro
        $(document).on('focus', '.money', function() {
            $(this).mask("#.##0,00", {reverse: true});
        });
        
        // Selecionar todas as categorias
        $('#select-all').change(function() {
            var checked = $(this).prop('checked');
            $('.categoria-checkbox').prop('checked', checked).trigger('change');
        });
        
        // Quando checkbox da categoria é alterado
        $('.categoria-checkbox').change(function() {
            var checked = $(this).prop('checked');
            var row = $(this).closest('tr');
            var taxaInput = row.find('.taxa-input');
            var statusSelect = row.find('.status-select');
            var removeBtn = row.find('.remove-taxa');
            
            if (checked) {
                // Habilitar campos
                taxaInput.prop('disabled', false).focus();
                statusSelect.prop('disabled', false);
                removeBtn.show();
            } else {
                // Desabilitar campos
                taxaInput.prop('disabled', true);
                statusSelect.prop('disabled', true);
                removeBtn.hide();
            }
        });
        
        // Remover taxa da categoria
        $('.remove-taxa').click(function() {
            var categoriaId = $(this).data('categoria-id');
            var row = $(this).closest('tr');
            
            if (confirm('Tem certeza que deseja remover a taxa desta categoria?')) {
                row.find('.categoria-checkbox').prop('checked', false).trigger('change');
                row.find('.taxa-input').val('0,75');
                row.find('.status-select').val('1');
            }
        });
        
        // Atualizar estado do "Selecionar todos"
        $('.categoria-checkbox').change(function() {
            var total = $('.categoria-checkbox').length;
            var checked = $('.categoria-checkbox:checked').length;
            
            $('#select-all').prop('indeterminate', checked > 0 && checked < total);
            $('#select-all').prop('checked', checked === total);
        });
        
        // Validação do formulário
        $('form').submit(function(e) {
            var categoriasComTaxa = $('.categoria-checkbox:checked').length;
            
            if (categoriasComTaxa === 0) {
                alert('Selecione pelo menos uma categoria para aplicar taxa.');
                e.preventDefault();
                return false;
            }
            
            // Validar valores das taxas
            var valido = true;
            $('.categoria-checkbox:checked').each(function() {
                var row = $(this).closest('tr');
                var taxaInput = row.find('.taxa-input');
                var valor = taxaInput.val().replace(/[^\d,]/g, '').replace(',', '.');
                
                if (!valor || parseFloat(valor) < 0) {
                    alert('Por favor, informe um valor válido para a taxa da categoria: ' + row.find('strong').text());
                    taxaInput.focus();
                    valido = false;
                    return false;
                }
            });
            
            if (!valido) {
                e.preventDefault();
                return false;
            }
        });
        
        <?php if (isset($_GET['success'])): ?>
        // Mostrar mensagem de sucesso
        _alert_success();
        <?php endif; ?>
        
        
    </script>
    <script src="js/jquery.parsley/dist/parsley.js" type="text/javascript"></script>
    <script src="js/jquery.parsley/dist/pt-br.js" type="text/javascript"></script>
</body>
</html>