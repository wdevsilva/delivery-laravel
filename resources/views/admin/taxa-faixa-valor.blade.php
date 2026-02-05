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
                        <h3>Configuração Taxa por valor</h3>
                    </div>
                    <div class="content">
                        <form action="<?php echo $baseUri; ?>/configuracao/gravarTaxaCartao/" method="POST">
                            <table id="tabela-taxas" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>De (R$)</th>
                                        <th>Até (R$)</th>
                                        <th>Taxa (R$)</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data['taxas'] as $taxa): ?>
                                        <tr>
                                            <td>
                                                <input type="hidden" name="id[]" value="<?= $taxa->id ?>">
                                                <input type="text" name="valor_de[]" value="<?= $taxa->valor_de ?>" class="form-control money">
                                            </td>
                                            <td><input type="text" name="valor_ate[]" value="<?= $taxa->valor_ate ?>" class="form-control money"></td>
                                            <td><input type="text" name="taxa[]" value="<?= $taxa->taxa ?>" class="form-control money"></td>
                                            <td style="width: 200px; text-align: center;" ><button type="button" onclick="removerLinha(this)" class="btn btn-danger">Remover</button></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <button type="button" onclick="adicionarLinha()" class="btn btn-primary btn-novo">Adicionar Faixa</button>
                            <button type="submit" class="btn btn-success">Salvar Configuração</button>
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
        $('#menu-config-taxa-card').addClass('active');
        <?php if (isset($_GET['success'])) : ?>
            _alert_success();
        <?php endif; ?>

        

        $(document).on('focus', '.money', function() {
            $(this).mask("#.##0,00", { reverse: true });
        });

        function adicionarLinha() {
            let tbody = document.querySelector("#tabela-taxas tbody");
            let row = document.createElement("tr");

            row.innerHTML = `
                <td>
                    <input type="hidden" name="id[]" value="">
                    <input type="text" name="valor_de[]" value="" class="form-control money">
                </td>
                <td><input type="text" name="valor_ate[]" value="" class="form-control money"></td>
                <td><input type="text" name="taxa[]" value="" class="form-control money"></td>
                <td style="width: 200px; text-align: center;"><button type="button" onclick="removerLinha(this)" class="btn btn-danger">Remover</button></td>
            `;
            tbody.appendChild(row);
        }

        function removerLinha(btn) {
            let row = btn.closest("tr");
            let id = row.querySelector('input[name="id[]"]').value;

            if (id) {
                // cria um input hidden para informar ao controller que esta linha deve ser deletada
                let inputExcluir = document.createElement("input");
                inputExcluir.type = "hidden";
                inputExcluir.name = "excluir[]";
                inputExcluir.value = id;
                document.querySelector("form").appendChild(inputExcluir);
            }

            // remove a linha da tabela
            row.remove();
        }


        function calcularTaxa(totalCompra, taxa) {
            let linhas = document.querySelectorAll("#tabela-taxas tbody tr");
            let valorBase = parseFloat(totalCompra) + parseFloat(taxa);
            let taxaCartao = 0;

            linhas.forEach(linha => {
                let de = parseFloat(linha.querySelector(".valor_de").value) || 0;
                let ate = parseFloat(linha.querySelector(".valor_ate").value) || 0;
                let taxaConfig = parseFloat(linha.querySelector(".taxa").value) || 0;

                if (valorBase >= de && valorBase < ate) {
                    taxaCartao = taxaConfig;
                }
            });

            return taxaCartao;
        }
    </script>
    <script src="js/jquery.parsley/dist/parsley.js" type="text/javascript"></script>
    <script src="js/jquery.parsley/dist/pt-br.js" type="text/javascript"></script>
</body>

</html>