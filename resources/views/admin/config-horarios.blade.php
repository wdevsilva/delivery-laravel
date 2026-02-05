<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
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
    <style>
        .dia-semana {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            background: #f9f9f9;
            transition: all 0.3s;
        }
        .dia-semana.ativo {
            background: #e8f5e9;
            border-color: #4caf50;
        }
        .dia-semana label {
            font-size: 14px;
            font-weight: bold;
            color: #4caf50;
        }
        .dia-semana input[type="checkbox"] {
            transform: scale(1.3);
            margin-right: 10px;
        }
    </style>
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
                    <div class="header">
                        <h3><i class="fa fa-clock-o"></i> Horários de Funcionamento
                            <span class="pull-right">
                                <a href="<?php echo $baseUri; ?>/configuracao/" class="btn btn-primary">
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
                            Horários atualizados com sucesso!
                        </div>
                        <?php endif; ?>

                        <form action="<?php echo $baseUri; ?>/configuracao/gravar_horarios/" method="post" role="form">
                            <div class="row">
                                <?php
                                // Segunda-feira
                                $config_segunda = $data['config']->config_segunda;
                                $primeiroDia = !empty($config_segunda) ? explode(" ", $config_segunda) : ['', '00:00-00:00'];
                                $primeiroDiaHorarios = explode("-", $primeiroDia[1]);
                                ?>
                                <div class="col-md-6">
                                    <div class="dia-semana" id="dia-segunda">
                                        <input id="seg-check" name="seg-check" type="checkbox" 
                                               <?= (!empty($config_segunda) && $primeiroDia[0] == 'on' ? 'checked' : ''); ?> 
                                               onchange="toggleDia('segunda')" /> 
                                        <label for="seg-check">SEGUNDA-FEIRA</label>
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-sm-6">
                                                <label>Abertura:</label>
                                                <input type="time" name="config_segunda_de" class="form-control" 
                                                       value="<?= $primeiroDiaHorarios[0] ?? '18:00'; ?>" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Fechamento:</label>
                                                <input type="time" name="config_segunda_ate" class="form-control" 
                                                       value="<?= $primeiroDiaHorarios[1] ?? '22:00'; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                // Terça-feira
                                $config_terca = $data['config']->config_terca;
                                $segundoDia = !empty($config_terca) ? explode(" ", $config_terca) : ['', '00:00-00:00'];
                                $segundoDiaHorarios = explode("-", $segundoDia[1]);
                                ?>
                                <div class="col-md-6">
                                    <div class="dia-semana" id="dia-terca">
                                        <input id="ter-check" name="ter-check" type="checkbox"
                                               <?= (!empty($config_terca) && $segundoDia[0] == 'on' ? 'checked' : ''); ?>
                                               onchange="toggleDia('terca')" />
                                        <label for="ter-check">TERÇA-FEIRA</label>
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-sm-6">
                                                <label>Abertura:</label>
                                                <input type="time" name="config_terca_de" class="form-control"
                                                       value="<?= $segundoDiaHorarios[0] ?? '18:00'; ?>" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Fechamento:</label>
                                                <input type="time" name="config_terca_ate" class="form-control"
                                                       value="<?= $segundoDiaHorarios[1] ?? '22:00'; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                // Quarta-feira
                                $config_quarta = $data['config']->config_quarta;
                                $terceiroDia = !empty($config_quarta) ? explode(" ", $config_quarta) : ['', '00:00-00:00'];
                                $terceiroDiaHorarios = explode("-", $terceiroDia[1]);
                                ?>
                                <div class="col-md-6">
                                    <div class="dia-semana" id="dia-quarta">
                                        <input id="qua-check" name="qua-check" type="checkbox"
                                               <?= (!empty($config_quarta) && $terceiroDia[0] == 'on' ? 'checked' : ''); ?>
                                               onchange="toggleDia('quarta')" />
                                        <label for="qua-check">QUARTA-FEIRA</label>
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-sm-6">
                                                <label>Abertura:</label>
                                                <input type="time" name="config_quarta_de" class="form-control"
                                                       value="<?= $terceiroDiaHorarios[0] ?? '18:00'; ?>" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Fechamento:</label>
                                                <input type="time" name="config_quarta_ate" class="form-control"
                                                       value="<?= $terceiroDiaHorarios[1] ?? '22:00'; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                // Quinta-feira
                                $config_quinta = $data['config']->config_quinta;
                                $quartoDia = !empty($config_quinta) ? explode(" ", $config_quinta) : ['', '00:00-00:00'];
                                $quartoDiaHorarios = explode("-", $quartoDia[1]);
                                ?>
                                <div class="col-md-6">
                                    <div class="dia-semana" id="dia-quinta">
                                        <input id="qui-check" name="qui-check" type="checkbox"
                                               <?= (!empty($config_quinta) && $quartoDia[0] == 'on' ? 'checked' : ''); ?>
                                               onchange="toggleDia('quinta')" />
                                        <label for="qui-check">QUINTA-FEIRA</label>
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-sm-6">
                                                <label>Abertura:</label>
                                                <input type="time" name="config_quinta_de" class="form-control"
                                                       value="<?= $quartoDiaHorarios[0] ?? '18:00'; ?>" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Fechamento:</label>
                                                <input type="time" name="config_quinta_ate" class="form-control"
                                                       value="<?= $quartoDiaHorarios[1] ?? '22:00'; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                // Sexta-feira
                                $config_sexta = $data['config']->config_sexta;
                                $quintoDia = !empty($config_sexta) ? explode(" ", $config_sexta) : ['', '00:00-00:00'];
                                $quintoDiaHorarios = explode("-", $quintoDia[1]);
                                ?>
                                <div class="col-md-6">
                                    <div class="dia-semana" id="dia-sexta">
                                        <input id="sex-check" name="sex-check" type="checkbox"
                                               <?= (!empty($config_sexta) && $quintoDia[0] == 'on' ? 'checked' : ''); ?>
                                               onchange="toggleDia('sexta')" />
                                        <label for="sex-check">SEXTA-FEIRA</label>
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-sm-6">
                                                <label>Abertura:</label>
                                                <input type="time" name="config_sexta_de" class="form-control"
                                                       value="<?= $quintoDiaHorarios[0] ?? '18:00'; ?>" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Fechamento:</label>
                                                <input type="time" name="config_sexta_ate" class="form-control"
                                                       value="<?= $quintoDiaHorarios[1] ?? '22:00'; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                // Sábado
                                $config_sabado = $data['config']->config_sabado;
                                $sextoDia = !empty($config_sabado) ? explode(" ", $config_sabado) : ['', '00:00-00:00'];
                                $sextoDiaHorarios = explode("-", $sextoDia[1]);
                                ?>
                                <div class="col-md-6">
                                    <div class="dia-semana" id="dia-sabado">
                                        <input id="sab-check" name="sab-check" type="checkbox"
                                               <?= (!empty($config_sabado) && $sextoDia[0] == 'on' ? 'checked' : ''); ?>
                                               onchange="toggleDia('sabado')" />
                                        <label for="sab-check">SÁBADO</label>
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-sm-6">
                                                <label>Abertura:</label>
                                                <input type="time" name="config_sabado_de" class="form-control"
                                                       value="<?= $sextoDiaHorarios[0] ?? '18:00'; ?>" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Fechamento:</label>
                                                <input type="time" name="config_sabado_ate" class="form-control"
                                                       value="<?= $sextoDiaHorarios[1] ?? '22:00'; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                // Domingo
                                $config_domingo = $data['config']->config_domingo;
                                $setimoDia = !empty($config_domingo) ? explode(" ", $config_domingo) : ['', '00:00-00:00'];
                                $setimoDiaHorarios = explode("-", $setimoDia[1]);
                                ?>
                                <div class="col-md-6">
                                    <div class="dia-semana" id="dia-domingo">
                                        <input id="dom-check" name="dom-check" type="checkbox"
                                               <?= (!empty($config_domingo) && $setimoDia[0] == 'on' ? 'checked' : ''); ?>
                                               onchange="toggleDia('domingo')" />
                                        <label for="dom-check">DOMINGO</label>
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-sm-6">
                                                <label>Abertura:</label>
                                                <input type="time" name="config_domingo_de" class="form-control"
                                                       value="<?= $setimoDiaHorarios[0] ?? '18:00'; ?>" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Fechamento:</label>
                                                <input type="time" name="config_domingo_ate" class="form-control"
                                                       value="<?= $setimoDiaHorarios[1] ?? '22:00'; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="text-center">
                                <button class="btn btn-primary btn-lg" type="submit">
                                    <i class="fa fa-save"></i> Salvar Horários
                                </button>
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
    <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="app-js/main.js"></script>
    <script type="text/javascript">
        var baseUri = '<?php echo $baseUri; ?>';
        $('#menu-config').addClass('active');
        $('#menu-config-horarios').addClass('active');

        // Toggle visual do card quando checkbox é marcado/desmarcado
        function toggleDia(dia) {
            const card = document.getElementById('dia-' + dia);
            const checkbox = card.querySelector('input[type="checkbox"]');
            
            if (checkbox.checked) {
                card.classList.add('ativo');
            } else {
                card.classList.remove('ativo');
            }
        }

        // Inicializar estado visual dos cards ao carregar página
        document.addEventListener('DOMContentLoaded', function() {
            const dias = ['segunda', 'terca', 'quarta', 'quinta', 'sexta', 'sabado', 'domingo'];
            dias.forEach(dia => {
                const card = document.getElementById('dia-' + dia);
                const checkbox = card.querySelector('input[type="checkbox"]');
                if (checkbox.checked) {
                    card.classList.add('ativo');
                }
            });
        });
    </script>
</body>

</html>
