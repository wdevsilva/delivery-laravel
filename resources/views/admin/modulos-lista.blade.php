<?php require_once 'site-base.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
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
                    <h3 class="text-center">Gerenciamento de Módulos</h3>
                    <div class="header">
                        <h3>Configuração de Módulos do Sistema</h3>
                        <h5>Habilite ou desabilite módulos conforme sua licença e necessidades</h5>
                    </div>
                    
                    <?php if (isset($_GET['success'])): ?>
                        <div class="alert alert-success">
                            <strong>Sucesso!</strong> Configurações de módulos atualizadas com sucesso.
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger">
                            <strong>Erro!</strong> Ocorreu um erro ao atualizar as configurações.
                        </div>
                    <?php endif; ?>

                    <div class="content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <h4><i class="fa fa-info-circle"></i> Informações Importantes</h4>
                                    <ul>
                                        <li><strong>Módulos Core:</strong> Não podem ser desabilitados (Delivery, Clientes, Cupons, Relatórios)</li>
                                        <li><strong>Módulos Premium:</strong> Requerem licença válida (Mesas, Garçons, Caixa, Cozinha)</li>
                                        <li><strong>Dependências:</strong> Alguns módulos dependem de outros para funcionar</li>
                                        <li><strong>Efeito Imediato:</strong> As alterações têm efeito imediato no sistema</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="50"><i class="fa fa-power-off"></i></th>
                                                <th width="60">Ícone</th>
                                                <th>Módulo</th>
                                                <th>Descrição</th>
                                                <th>Tipo</th>
                                                <th>Status</th>
                                                <th width="100">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $modules = ModuleManager::getAllModules();
                                            foreach ($modules as $module_key => $module): 
                                            ?>
                                            <tr class="<?php echo $module['enabled'] ? '' : 'text-muted'; ?>">
                                                <td class="text-center">
                                                    <?php if (isset($module['core']) && $module['core']): ?>
                                                        <i class="fa fa-lock text-info" title="Módulo Core - Não pode ser desabilitado"></i>
                                                    <?php else: ?>
                                                        <label class="switch">
                                                            <input type="checkbox" 
                                                                   data-module="<?php echo $module_key; ?>" 
                                                                   class="module-toggle"
                                                                   <?php echo $module['enabled'] ? 'checked' : ''; ?>>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <i class="fa <?php echo $module['icon']; ?> fa-2x 
                                                       <?php echo $module['enabled'] ? 'text-success' : 'text-muted'; ?>"></i>
                                                </td>
                                                <td>
                                                    <strong><?php echo $module['name']; ?></strong>
                                                    <?php if (isset($module['depends'])): ?>
                                                        <br><small class="text-info">
                                                            <i class="fa fa-link"></i> 
                                                            Depende de: <?php echo implode(', ', array_map(function($dep) use ($modules) {
                                                                return $modules[$dep]['name'];
                                                            }, $module['depends'])); ?>
                                                        </small>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo $module['description']; ?></td>
                                                <td>
                                                    <?php if (isset($module['core']) && $module['core']): ?>
                                                        <span class="label label-info">Core</span>
                                                    <?php elseif (isset($module['premium']) && $module['premium']): ?>
                                                        <span class="label label-warning">Premium</span>
                                                    <?php else: ?>
                                                        <span class="label label-default">Básico</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($module['enabled']): ?>
                                                        <span class="label label-success">Habilitado</span>
                                                    <?php else: ?>
                                                        <span class="label label-danger">Desabilitado</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (!isset($module['core']) || !$module['core']): ?>
                                                        <button class="btn btn-sm <?php echo $module['enabled'] ? 'btn-danger' : 'btn-success'; ?> toggle-module" 
                                                                data-module="<?php echo $module_key; ?>"
                                                                data-action="<?php echo $module['enabled'] ? 'disable' : 'enable'; ?>">
                                                            <i class="fa <?php echo $module['enabled'] ? 'fa-ban' : 'fa-check'; ?>"></i>
                                                            <?php echo $module['enabled'] ? 'Desabilitar' : 'Habilitar'; ?>
                                                        </button>
                                                    <?php else: ?>
                                                        <span class="text-muted">Bloqueado</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4>Informações de Licença</h4>
                                    </div>
                                    <div class="panel-body">
                                        <?php 
                                        $config = (new configModel)->get_config();
                                        $license_type = isset($config->licenca_tipo) ? $config->licenca_tipo : 'basico';
                                        $license_expiry = isset($config->licenca_data_vencimento) ? $config->licenca_data_vencimento : null;
                                        ?>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong>Tipo de Licença:</strong><br>
                                                <span class="label label-<?php echo $license_type == 'completo' ? 'success' : ($license_type == 'premium' ? 'warning' : 'default'); ?>">
                                                    <?php echo strtoupper($license_type); ?>
                                                </span>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Módulos Premium Habilitados:</strong><br>
                                                <?php 
                                                $enabled_premium = ModuleManager::getEnabledPremiumModules();
                                                echo count($enabled_premium) . ' de ' . count(array_filter($modules, function($m) { return isset($m['premium']) && $m['premium']; }));
                                                ?>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Vencimento:</strong><br>
                                                <?php if ($license_expiry): ?>
                                                    <?php echo date('d/m/Y', strtotime($license_expiry)); ?>
                                                <?php else: ?>
                                                    <span class="text-muted">Sem vencimento</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/jquery.cooki/jquery.cooki.js"></script>
    <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script src="js/jquery.alerts/jquery.alerts.js"></script>
    <script src="js/scripts.js"></script>

    <script>
        $(document).ready(function() {
            // Toggle module status
            $('.toggle-module').on('click', function() {
                var button = $(this);
                var module = button.data('module');
                var action = button.data('action');
                
                button.prop('disabled', true);
                
                $.post('<?php echo $baseUri; ?>/admin/modulos/toggle/', {
                    module: module,
                    action: action
                })
                .done(function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Erro: ' + response.message);
                        button.prop('disabled', false);
                    }
                })
                .fail(function() {
                    alert('Erro ao comunicar com o servidor');
                    button.prop('disabled', false);
                });
            });
        });
    </script>

    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 14px;
            width: 14px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:checked + .slider:before {
            transform: translateX(20px);
        }

        .slider.round {
            border-radius: 20px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
</body>
</html>