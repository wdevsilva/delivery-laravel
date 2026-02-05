<?php require_once 'site-base.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link href="css/style.css" rel="stylesheet" />
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
                    <div class="content">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="panel panel-warning">
                                    <div class="panel-heading text-center">
                                        <h3><i class="fa fa-ban"></i> Módulo Não Disponível</h3>
                                    </div>
                                    <div class="panel-body text-center" style="padding: 40px;">
                                        <?php if (isset($data['module_info'])): ?>
                                            <div class="module-icon" style="margin-bottom: 20px;">
                                                <i class="fa <?php echo $data['module_info']['icon']; ?> fa-5x text-muted"></i>
                                            </div>
                                            <h4><?php echo $data['module_info']['name']; ?></h4>
                                            <p class="text-muted"><?php echo $data['module_info']['description']; ?></p>
                                        <?php endif; ?>
                                        
                                        <div class="alert alert-warning" style="margin: 20px 0;">
                                            <h4><i class="fa fa-exclamation-triangle"></i> Acesso Restrito</h4>
                                            <p><?php echo $data['message']; ?></p>
                                        </div>

                                        <?php if (isset($data['module_info']['premium']) && $data['module_info']['premium']): ?>
                                            <div class="well">
                                                <h5><i class="fa fa-star text-warning"></i> Módulo Premium</h5>
                                                <p>Este é um módulo premium que oferece funcionalidades avançadas para estabelecimentos.</p>
                                                
                                                <h6><strong>Benefícios deste módulo:</strong></h6>
                                                <ul class="list-unstyled text-left" style="max-width: 400px; margin: 0 auto;">
                                                    <?php if ($data['module'] === 'mesa'): ?>
                                                        <li><i class="fa fa-check text-success"></i> Controle completo de mesas</li>
                                                        <li><i class="fa fa-check text-success"></i> Sistema de reservas</li>
                                                        <li><i class="fa fa-check text-success"></i> Gestão de ocupação</li>
                                                        <li><i class="fa fa-check text-success"></i> Relatórios de ocupação</li>
                                                    <?php elseif ($data['module'] === 'garcon'): ?>
                                                        <li><i class="fa fa-check text-success"></i> Interface específica para garçons</li>
                                                        <li><i class="fa fa-check text-success"></i> Gestão de pedidos por mesa</li>
                                                        <li><i class="fa fa-check text-success"></i> Controle de performance</li>
                                                        <li><i class="fa fa-check text-success"></i> Sistema de estatísticas</li>
                                                    <?php elseif ($data['module'] === 'caixa'): ?>
                                                        <li><i class="fa fa-check text-success"></i> Fechamento automático de mesas</li>
                                                        <li><i class="fa fa-check text-success"></i> Controle financeiro avançado</li>
                                                        <li><i class="fa fa-check text-success"></i> Relatórios de caixa</li>
                                                        <li><i class="fa fa-check text-success"></i> Gestão de recebimentos</li>
                                                    <?php elseif ($data['module'] === 'cozinha'): ?>
                                                        <li><i class="fa fa-check text-success"></i> Display dedicado para cozinha</li>
                                                        <li><i class="fa fa-check text-success"></i> Controle de status dos pedidos</li>
                                                        <li><i class="fa fa-check text-success"></i> Tempo de preparo automático</li>
                                                        <li><i class="fa fa-check text-success"></i> Interface otimizada</li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>

                                        <div class="action-buttons" style="margin-top: 30px;">
                                            <a href="<?php echo $baseUri; ?>/admin/" class="btn btn-primary btn-lg">
                                                <i class="fa fa-home"></i> Voltar ao Dashboard
                                            </a>
                                            
                                            <?php if (Sessao::get_nivel() == 1): ?>
                                                <a href="<?php echo $baseUri; ?>/admin/modulos/" class="btn btn-warning btn-lg">
                                                    <i class="fa fa-puzzle-piece"></i> Gerenciar Módulos
                                                </a>
                                            <?php endif; ?>
                                        </div>

                                        <?php if (Sessao::get_nivel() == 1): ?>
                                            <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee;">
                                                <h6 class="text-muted">Para Administradores</h6>
                                                <p class="small text-muted">
                                                    Você pode habilitar este módulo na seção "Gerenciar Módulos" se possuir uma licença válida.
                                                    Entre em contato com o suporte para obter informações sobre upgrade de licença.
                                                </p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($data['enabled_modules'])): ?>
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4><i class="fa fa-puzzle-piece"></i> Módulos Premium Habilitados</h4>
                                        </div>
                                        <div class="panel-body">
                                            <p>Você possui os seguintes módulos premium habilitados:</p>
                                            <div class="row">
                                                <?php 
                                                $all_modules = ModuleManager::getAllModules();
                                                foreach ($data['enabled_modules'] as $enabled_module):
                                                    if (isset($all_modules[$enabled_module])):
                                                        $module_info = $all_modules[$enabled_module];
                                                ?>
                                                    <div class="col-md-6">
                                                        <div class="media">
                                                            <div class="media-left">
                                                                <i class="fa <?php echo $module_info['icon']; ?> fa-2x text-success"></i>
                                                            </div>
                                                            <div class="media-body">
                                                                <h6 class="media-heading"><?php echo $module_info['name']; ?></h6>
                                                                <small class="text-muted"><?php echo $module_info['description']; ?></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php 
                                                    endif;
                                                endforeach; 
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/jquery.cooki/jquery.cooki.js"></script>
    <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
    <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>