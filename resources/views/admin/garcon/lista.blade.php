<?php
$baseUri = Http::base();
// Data is now properly passed from the Admin controller
$garcons = $data['garcons'] ?? [];
$config = $data['config'] ?? null;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once __DIR__ . '/../site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de Gerenciamento de Garçons - Controle Completo">
    <meta name="author" content="">
    <title>Gerenciar Garçons - <?= $config ? $config->config_nome : 'Sistema' ?></title>

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
    <link href="css/style-prusia.css" rel="stylesheet" />
    <link href="css/garcon-lista.css" rel="stylesheet" />
</head>

<body class="animated">
    <div id="cl-wrapper">
        <div class="cl-sidebar">
            <?php require_once __DIR__ . '/../side-menu.php'; ?>
        </div>
        <div class="container-fluid" id="pcont">
            <div class="content">
                <!-- Main content -->
                <main role="main" class="container">
                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1><i class="fa fa-user-md"></i> Gerenciar Garçons</h1>
                                <p class="subtitle">Sistema completo de gestão de atendentes</p>
                            </div>
                            <div>
                                <a href="<?= $baseUri ?>/admin/garcon/novo/" class="btn btn-new">
                                    <i class="fa fa-plus"></i> Novo Garçon
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Content Container -->
                    <div class="content-container">

                        <!-- Summary Cards -->
                        <div class="stats-container">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="stat-card primary">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="numbers">
                                                    <p class="card-category">Total Garçons</p>
                                                    <h4 class="card-title"><?= count($garcons) ?></h4>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="icon-big">
                                                    <i class="fa fa-users"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-card success">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="numbers">
                                                    <p class="card-category">Ativos</p>
                                                    <h4 class="card-title"><?= count(array_filter($garcons, function ($g) {
                                                                                return $g->garcon_ativo == 1;
                                                                            })) ?></h4>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="icon-big">
                                                    <i class="fa fa-check-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-card warning">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="numbers">
                                                    <p class="card-category">Supervisores</p>
                                                    <h4 class="card-title"><?= count(array_filter($garcons, function ($g) {
                                                                                return $g->garcon_nivel == 2;
                                                                            })) ?></h4>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="icon-big">
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="stat-card danger">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="numbers">
                                                    <p class="card-category">Inativos</p>
                                                    <h4 class="card-title"><?= count(array_filter($garcons, function ($g) {
                                                                                return $g->garcon_ativo == 0;
                                                                            })) ?></h4>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="icon-big">
                                                    <i class="fa fa-times-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Search -->
                        <div class="search-container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="search-input-wrapper">
                                        <i class="fa fa-search search-icon"></i>
                                        <input type="text" id="searchGarcons" class="form-control" placeholder="Buscar garçons por nome, usuário ou email..." oninput="buscarGarcons()">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-outline-secondary" onclick="limparFiltros()" style="border-radius: 25px; margin-left: 10px;">
                                        <i class="fa fa-times"></i> Limpar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Filters -->
                        <div class="filters-container">
                            <h5><i class="fa fa-filter"></i> Filtros</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="filtroStatus">Filtrar por Status:</label>
                                        <select id="filtroStatus" class="form-control" onchange="filtrarGarcons()">
                                            <option value="">Todos os Status</option>
                                            <option value="1">Ativos</option>
                                            <option value="0">Inativos</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="filtroNivel">Filtrar por Nível:</label>
                                        <select id="filtroNivel" class="form-control" onchange="filtrarGarcons()">
                                            <option value="">Todos os Níveis</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Supervisor</option>
                                            <option value="3">Garçon</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Ações em Lote:</label><br>
                                        <div class="btn-group d-block">
                                            <button type="button" class="btn btn-success btn-sm" onclick="ativarSelecionados()" title="Ativar selecionados">
                                                <i class="fa fa-check"></i> Ativar
                                            </button>
                                            <button type="button" class="btn btn-warning btn-sm" onclick="desativarSelecionados()" title="Desativar selecionados">
                                                <i class="fa fa-pause"></i> Desativar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Garçons List -->
                        <div id="garconsContainer">
                            <?php if (empty($garcons)): ?>
                                <div class="empty-state">
                                    <i class="fa fa-user-plus"></i>
                                    <h3>Nenhum garçon cadastrado</h3>
                                    <p>Comece cadastrando o primeiro garçon do seu sistema de atendimento</p>
                                    <a href="<?= $baseUri ?>/admin/garcon/novo/" class="btn btn-new">
                                        <i class="fa fa-plus"></i> Cadastrar Primeiro Garçon
                                    </a>
                                </div>
                            <?php else: ?>
                                <?php foreach ($garcons as $garcon): ?>
                                    <div class="garcon-card <?= $garcon->garcon_ativo ? '' : 'inativo' ?>"
                                        data-status="<?= $garcon->garcon_ativo ?>"
                                        data-nivel="<?= $garcon->garcon_nivel ?>"
                                        data-garcon-id="<?= $garcon->garcon_id ?>"
                                        data-search-text="<?= strtolower(htmlspecialchars($garcon->garcon_nome . ' ' . $garcon->garcon_usuario . ' ' . ($garcon->garcon_email ?? ''))) ?>">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input garcon-checkbox" id="check<?= $garcon->garcon_id ?>" value="<?= $garcon->garcon_id ?>">
                                                        <label class="custom-control-label" for="check<?= $garcon->garcon_id ?>"></label>
                                                    </div>
                                                </div>
                                                <h5>
                                                    <i class="fa fa-user"></i> <?= htmlspecialchars($garcon->garcon_nome) ?>
                                                    <span class="status-badge <?= $garcon->garcon_ativo ? 'status-ativo' : 'status-inativo' ?>">
                                                        <?= $garcon->garcon_ativo ? 'Ativo' : 'Inativo' ?>
                                                    </span>
                                                    <span class="nivel-badge nivel-<?= $garcon->garcon_nivel ?>">
                                                        <?= $garcon->garcon_nivel == 1 ? 'Admin' : ($garcon->garcon_nivel == 2 ? 'Supervisor' : 'Garçon') ?>
                                                    </span>
                                                </h5>
                                                <div class="garcon-info">
                                                    <strong><i class="fa fa-sign-in"></i> Login:</strong> <?= htmlspecialchars($garcon->garcon_usuario) ?>
                                                </div>
                                                <?php if (!empty($garcon->garcon_email)): ?>
                                                    <div class="garcon-info">
                                                        <strong><i class="fa fa-envelope"></i> Email:</strong> <?= htmlspecialchars($garcon->garcon_email) ?>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (!empty($garcon->garcon_telefone)): ?>
                                                    <div class="garcon-info">
                                                        <strong><i class="fa fa-phone"></i> Telefone:</strong> <?= htmlspecialchars($garcon->garcon_telefone) ?>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="garcon-info">
                                                    <strong><i class="fa fa-calendar"></i> Cadastrado em:</strong>
                                                    <?= date('d/m/Y H:i', strtotime($garcon->data_criacao)) ?>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="garcon-actions">
                                                    <a href="<?= $baseUri ?>/admin/garcon/editar/<?= $garcon->garcon_id ?>/"
                                                        class="btn btn-info btn-sm btn-grupo" title="Editar Garçon">
                                                        <i class="fa fa-edit"></i> Editar
                                                    </a>
                                                    <?php if ($garcon->garcon_ativo): ?>
                                                        <button type="button" class="btn btn-warning btn-sm btn-grupo"
                                                            onclick="toggleStatus(<?= $garcon->garcon_id ?>, 0, '<?= htmlspecialchars($garcon->garcon_nome, ENT_QUOTES) ?>')"
                                                            title="Desativar Garçon">
                                                            <i class="fa fa-pause"></i> Desativar
                                                        </button>
                                                    <?php else: ?>
                                                        <button type="button" class="btn btn-success btn-sm btn-grupo"
                                                            onclick="toggleStatus(<?= $garcon->garcon_id ?>, 1, '<?= htmlspecialchars($garcon->garcon_nome, ENT_QUOTES) ?>')"
                                                            title="Ativar Garçon">
                                                            <i class="fa fa-play"></i> Ativar
                                                        </button>
                                                    <?php endif; ?>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="excluirGarcon(<?= $garcon->garcon_id ?>, '<?= htmlspecialchars($garcon->garcon_nome, ENT_QUOTES) ?>')"
                                                        title="Excluir Garçon">
                                                        <i class="fa fa-trash"></i> Excluir
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Loading Overlay -->
                        <div class="loading-overlay" id="loadingOverlay">
                            <div class="loading-spinner"></div>
                        </div>

                </main>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?php echo $baseUri; ?>/assets/vendor/jquery/jquery-2.1.4.min.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.cooki/jquery.cooki.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.ui/jquery-ui.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.gritter/js/jquery.gritter.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/behaviour/core.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.select2/dist/js/select2.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.maskedinput/jquery.maskedinput.js"></script>
    <script src="<?php echo $baseUri; ?>/view/admin/js/jquery.mask.js"></script>

    <?php require_once __DIR__ . '/../switch-color.php'; ?>
    <script src="<?php echo $baseUri; ?>/view/admin/app-js/main.js"></script>

    <script>
        // Search functionality
        function buscarGarcons() {
            const searchTerm = document.getElementById('searchGarcons').value.toLowerCase();
            const cards = document.querySelectorAll('.garcon-card');
            let visibleCount = 0;

            cards.forEach((card, index) => {
                const searchText = card.dataset.searchText || '';
                const shouldShow = searchText.includes(searchTerm);

                if (shouldShow) {
                    setTimeout(() => {
                        card.style.display = 'block';
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';

                        setTimeout(() => {
                            card.style.transition = 'all 0.3s ease';
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, index * 30);
                    }, 0);
                    visibleCount++;
                } else {
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(-20px)';

                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });

            // Show no results message if needed
            updateNoResultsMessage(visibleCount, cards.length);
        }

        // Clear all filters
        function limparFiltros() {
            document.getElementById('searchGarcons').value = '';
            document.getElementById('filtroStatus').value = '';
            document.getElementById('filtroNivel').value = '';

            // Uncheck all checkboxes
            document.querySelectorAll('.garcon-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });

            // Show all cards
            const cards = document.querySelectorAll('.garcon-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.display = 'block';
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';

                    setTimeout(() => {
                        card.style.transition = 'all 0.3s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, index * 30);
                }, 0);
            });

            // Remove no results message
            const noResultsMsg = document.querySelector('.no-results-message');
            if (noResultsMsg) {
                noResultsMsg.style.display = 'none';
            }
        }

        // Batch operations
        function ativarSelecionados() {
            const selecionados = getGarconsSelecionados();
            if (selecionados.length === 0) {
                alert('Selecione pelo menos um garçon para ativar.');
                return;
            }

            if (confirm(`Tem certeza que deseja ativar ${selecionados.length} garçon(s) selecionado(s)?`)) {
                processarLote(selecionados, 1, 'ativar');
            }
        }

        function desativarSelecionados() {
            const selecionados = getGarconsSelecionados();
            if (selecionados.length === 0) {
                alert('Selecione pelo menos um garçon para desativar.');
                return;
            }

            if (confirm(`Tem certeza que deseja desativar ${selecionados.length} garçon(s) selecionado(s)?\n\nEles não poderão mais fazer login no sistema.`)) {
                processarLote(selecionados, 0, 'desativar');
            }
        }

        function getGarconsSelecionados() {
            const checkboxes = document.querySelectorAll('.garcon-checkbox:checked');
            return Array.from(checkboxes).map(cb => cb.value);
        }

        function processarLote(ids, status, acao) {
            showLoading();
            let processados = 0;
            let erros = 0;

            ids.forEach((id, index) => {
                setTimeout(() => {
                    $.ajax({
                        url: '<?= $baseUri ?>/admin/garcon/toggle-status/',
                        method: 'POST',
                        data: {
                            garcon_id: id,
                            ativo: status
                        },
                        dataType: 'json',
                        success: function(response) {
                            processados++;

                            if (response.status !== 'success') {
                                erros++;
                            }

                            // If this is the last request
                            if (processados === ids.length) {
                                hideLoading();

                                if (erros === 0) {
                                    $.gritter.add({
                                        title: 'Sucesso!',
                                        text: `${processados} garçon(s) ${acao === 'ativar' ? 'ativado(s)' : 'desativado(s)'} com sucesso!`,
                                        class_name: 'gritter-success',
                                        time: 3000
                                    });
                                } else {
                                    $.gritter.add({
                                        title: 'Parcialmente concluído',
                                        text: `${processados - erros} sucesso(s), ${erros} erro(s)`,
                                        class_name: 'gritter-warning',
                                        time: 5000
                                    });
                                }

                                setTimeout(() => location.reload(), 1500);
                            }
                        },
                        error: function() {
                            processados++;
                            erros++;

                            if (processados === ids.length) {
                                hideLoading();
                                $.gritter.add({
                                    title: 'Erro!',
                                    text: `Erro ao processar operação em lote. ${processados - erros} sucesso(s), ${erros} erro(s)`,
                                    class_name: 'gritter-error',
                                    time: 5000
                                });
                            }
                        }
                    });
                }, index * 200); // Delay between requests
            });
        }

        // Update no results message
        function updateNoResultsMessage(visibleCount, totalCount) {
            setTimeout(() => {
                const container = document.getElementById('garconsContainer');
                let noResultsMsg = container.querySelector('.no-results-message');

                if (visibleCount === 0 && totalCount > 0) {
                    if (!noResultsMsg) {
                        noResultsMsg = document.createElement('div');
                        noResultsMsg.className = 'empty-state no-results-message';
                        noResultsMsg.innerHTML = `
                            <i class="fa fa-search"></i>
                            <h3>Nenhum garçon encontrado</h3>
                            <p>Tente ajustar os filtros ou termos de busca para encontrar garçons</p>
                            <button type="button" class="btn btn-outline-primary" onclick="limparFiltros()">
                                <i class="fa fa-times"></i> Limpar Filtros
                            </button>
                        `;
                        container.appendChild(noResultsMsg);
                    }
                    noResultsMsg.style.display = 'block';
                } else if (noResultsMsg) {
                    noResultsMsg.style.display = 'none';
                }
            }, 400);
        }

        // Enhanced filter function with search integration
        function filtrarGarcons() {
            const filtroStatus = document.getElementById('filtroStatus').value;
            const filtroNivel = document.getElementById('filtroNivel').value;
            const searchTerm = document.getElementById('searchGarcons').value.toLowerCase();
            const cards = document.querySelectorAll('.garcon-card');

            let visibleCount = 0;

            cards.forEach((card, index) => {
                let mostrar = true;
                const searchText = card.dataset.searchText || '';

                // Apply search filter
                if (searchTerm && !searchText.includes(searchTerm)) {
                    mostrar = false;
                }

                // Apply status filter
                if (filtroStatus !== '' && card.dataset.status !== filtroStatus) {
                    mostrar = false;
                }

                // Apply level filter
                if (filtroNivel !== '' && card.dataset.nivel !== filtroNivel) {
                    mostrar = false;
                }

                // Animation
                if (mostrar) {
                    setTimeout(() => {
                        card.style.display = 'block';
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';

                        setTimeout(() => {
                            card.style.transition = 'all 0.3s ease';
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, index * 50);
                    }, 0);
                    visibleCount++;
                } else {
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(-20px)';

                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });

            updateNoResultsMessage(visibleCount, cards.length);
        }

        // Toggle status (ativar/desativar) com loading
        function toggleStatus(id, status, nome) {
            const acao = status ? 'ativar' : 'desativar';
            const confirmMsg = status ?
                `Tem certeza que deseja ativar o garçon "${nome}"?` :
                `Tem certeza que deseja desativar o garçon "${nome}"?\n\nEle não poderá mais fazer login no sistema.`;

            if (confirm(confirmMsg)) {
                // Mostrar loading
                showLoading();

                $.ajax({
                    url: '<?= $baseUri ?>/admin/garcon/toggle-status/',
                    method: 'POST',
                    data: {
                        garcon_id: id,
                        ativo: status
                    },
                    dataType: 'json',
                    success: function(response) {
                        hideLoading();

                        if (response.status === 'success') {
                            $.gritter.add({
                                title: 'Sucesso!',
                                text: response.message,
                                class_name: 'gritter-success',
                                time: 3000
                            });

                            // Animar recarregamento
                            setTimeout(() => {
                                const cards = document.querySelectorAll('.garcon-card');
                                cards.forEach((card, index) => {
                                    setTimeout(() => {
                                        card.style.transform = 'translateY(-20px)';
                                        card.style.opacity = '0';
                                    }, index * 50);
                                });

                                setTimeout(() => location.reload(), cards.length * 50 + 200);
                            }, 1000);
                        } else {
                            $.gritter.add({
                                title: 'Erro!',
                                text: response.message,
                                class_name: 'gritter-error',
                                time: 5000
                            });
                        }
                    },
                    error: function() {
                        hideLoading();
                        $.gritter.add({
                            title: 'Erro!',
                            text: 'Erro ao alterar status. Tente novamente.',
                            class_name: 'gritter-error',
                            time: 5000
                        });
                    }
                });
            }
        }

        // Excluir garçon com loading
        function excluirGarcon(id, nome) {
            if (confirm(`ATENÇÃO: Tem certeza que deseja EXCLUIR o garçon "${nome}"?\n\nEsta ação é IRREVERSÍVEL e removerá todos os dados associados.`)) {
                showLoading();

                $.ajax({
                    url: '<?= $baseUri ?>/admin/garcon/excluir/',
                    method: 'POST',
                    data: {
                        garcon_id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        hideLoading();

                        if (response.status === 'success') {
                            $.gritter.add({
                                title: 'Sucesso!',
                                text: response.message,
                                class_name: 'gritter-success',
                                time: 3000
                            });

                            // Animar saída do card antes de recarregar
                            const card = document.querySelector(`[data-garcon-id="${id}"]`);
                            if (card) {
                                card.style.transition = 'all 0.5s ease';
                                card.style.transform = 'translateX(-100%)';
                                card.style.opacity = '0';
                            }

                            setTimeout(() => location.reload(), 1500);
                        } else {
                            $.gritter.add({
                                title: 'Erro!',
                                text: response.message,
                                class_name: 'gritter-error',
                                time: 5000
                            });
                        }
                    },
                    error: function() {
                        hideLoading();
                        $.gritter.add({
                            title: 'Erro!',
                            text: 'Erro ao excluir garçon. Tente novamente.',
                            class_name: 'gritter-error',
                            time: 5000
                        });
                    }
                });
            }
        }

        // Funções de loading
        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }

        function hideLoading() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }

        // Enhanced entry animation with staggered effect
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.garcon-card');
            const statCards = document.querySelectorAll('.stat-card');

            // Animate stat cards first
            statCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';

                setTimeout(() => {
                    card.style.transition = 'all 0.6s cubic-bezier(0.4, 0.0, 0.2, 1)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100 + 200);
            });

            // Animate search and filters
            const searchContainer = document.querySelector('.search-container');
            const filtersContainer = document.querySelector('.filters-container');

            if (searchContainer) {
                searchContainer.style.opacity = '0';
                searchContainer.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    searchContainer.style.transition = 'all 0.6s ease';
                    searchContainer.style.opacity = '1';
                    searchContainer.style.transform = 'translateY(0)';
                }, 500);
            }

            if (filtersContainer) {
                filtersContainer.style.opacity = '0';
                filtersContainer.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    filtersContainer.style.transition = 'all 0.6s ease';
                    filtersContainer.style.opacity = '1';
                    filtersContainer.style.transform = 'translateY(0)';
                }, 600);
            }

            // Animate waiter cards
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';

                setTimeout(() => {
                    card.style.transition = 'all 0.6s cubic-bezier(0.4, 0.0, 0.2, 1)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100 + 800);
            });

            // Auto-focus search on page load (optional)
            setTimeout(() => {
                const searchInput = document.getElementById('searchGarcons');
                if (searchInput && window.innerWidth > 768) { // Only on desktop
                    searchInput.focus();
                }
            }, 1200);
        });
    </script>
</body>

</html>