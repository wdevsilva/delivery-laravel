<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once 'site-base.php'; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet'
        type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="js/jquery.gritter/css/jquery.gritter.css" />
    <link rel="stylesheet"
        href="<?php echo $baseUri; ?>/assets/vendor/fonts/font-awesome-4.4.0/css/font-awesome.min.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/html5.js"></script>
          <script src="<?php echo $baseUri; ?>/assets/vendor/html5/respond.min.js"></script>
        <![endif]-->
    <link rel="stylesheet" type="text/css" href="js/jquery.nanoscroller/nanoscroller.css" />
    <link rel="stylesheet" type="text/css" href="js/jquery.datatables/bootstrap-adapter/css/datatables.css" />
    <link href="css/style-prusia.css" rel="stylesheet" />
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
                        <h3>Clientes
                            <span class="pull-right">
                                <!--<button type="button" class="btn btn-primary btn-novo"><i class="fa fa-plus-circle"></i> Cadastrar Novo</button>-->
                                <a href="<?php echo $baseUri; ?>/cliente/novo/" class="btn btn-primary btn-novo"><i
                                        class="fa fa-plus-circle"></i> Cadastrar Novo</a>
                            </span>
                        </h3>
                    </div>
                    <div class="content">
                        <div class="table-responsives">
                            <table class="datatable display nowrap table table-hover table-striped table-bordered" width="100%" id="tbl_cliente">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Fone</th>
                                        <th width="350" class="d-print-none" style="text-align: center;">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($data[0])): ?>
                                        <?php foreach ($data as $obj): ?>
                                            <tr class="gradeA" id="tr-<?= $obj->cliente_id ?>">
                                                <td id="td-id"><?= $obj->cliente_id ?></td>
                                                <td id="td-nome"><?= $obj->cliente_nome ?></td>
                                                <td id="td-email"><?= $obj->cliente_email ?></td>
                                                <td id="td-fone"
                                                    class="center"><?= ($obj->cliente_fone != '') ? $obj->cliente_fone : $obj->cliente_fone2; ?></td>
                                                <td class="center d-print-none">
                                                    <button data-id="<?= $obj->cliente_id ?>" data-nome="<?= htmlspecialchars($obj->cliente_nome) ?>"
                                                        title="Histórico de Compras" data-toggle="tooltip"
                                                        class="btn btn-sm btn-success btn-historico">
                                                        <i class="fa fa-shopping-cart"></i>
                                                    </button>
                                                    <?php if ($obj->tem_desconto_fidelidade == 1): ?>
                                                    <button data-id="<?= $obj->cliente_id ?>" data-nome="<?= htmlspecialchars($obj->cliente_nome) ?>" data-fone="<?= $obj->cliente_fone2 ?>"
                                                        title="Notificar Desconto de Fidelidade (10% OFF)" data-toggle="tooltip"
                                                        class="btn btn-sm btn-purple btn-notificar-fidelidade">
                                                        <i class="fa fa-gift"></i>
                                                    </button>
                                                    <?php endif; ?>
                                                    <button data-id="<?= $obj->cliente_id ?>"
                                                        title="Logar como Cliente" data-toggle="tooltip"
                                                        class="btn btn-sm btn-warning btn-logar-cliente">
                                                        <i class="fa fa-sign-in"></i>
                                                    </button>
                                                    <a href="<?php echo $baseUri; ?>/endereco/lista/<?= $obj->cliente_id ?>/"
                                                        title="Endereços" data-toggle="tooltip"
                                                        class="btn btn-sm btn-info"><i class="fa fa-map-marker"></i>
                                                    </a>
                                                    <a href="<?php echo $baseUri; ?>/cliente/editar/<?= $obj->cliente_id ?>/"
                                                        title="Editar" data-toggle="tooltip"
                                                        class="btn btn-sm btn-primary"><i class="fa fa-edit"></i>
                                                    </a>
                                                    <button data-id="<?= $obj->cliente_id ?>" title="Remover"
                                                        data-toggle="tooltip"
                                                        class="btn btn-sm btn-danger btn-remover"><i
                                                            class="fa fa-trash-o"></i></button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Histórico de Compras -->
        <div class="modal fade" id="modal-historico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Histórico de Compras - <span id="cliente-nome"></span></h4>
                    </div>
                    <div class="modal-body">
                        <div id="historico-loading" class="text-center">
                            <i class="fa fa-spinner fa-spin fa-2x"></i>
                            <p>Carregando histórico...</p>
                        </div>
                        <div id="historico-content" style="display: none;">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Pedido #</th>
                                            <th>Data</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody id="historico-tbody">
                                        <!-- Conteúdo carregado via AJAX -->
                                    </tbody>
                                </table>
                            </div>
                            <div id="historico-summary" class="well well-sm" style="margin-top: 15px;">
                                <strong>Total de Pedidos:</strong> <span id="total-pedidos">0</span> |
                                <strong>Valor Total:</strong> R$ <span id="valor-total">0,00</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade colored-header warning md-effect-10" id="modal-remove" tabindex="-1" role="dialog">
            <div class="modal-dialog custom-width">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Remover Registro</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class="i-circle warning"><i class="fa fa-warning"></i></div>
                            <h4>Atenção!</h4>
                            <p>Você está prestes à remover um registro e esta ação não pode ser desfeita. <br />
                                Deseja realmente prosseguir?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form name="form-remove" id="form-remove" action="<?php echo $baseUri; ?>/cliente/remove/"
                            method="post">
                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-warning btn-flat btn-confirma-remove">Prosseguir</button>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <script src="js/jquery.js"></script>
        <script src="js/jquery.cooki/jquery.cooki.js"></script>
        <script src="js/jquery.pushmenu/js/jPushMenu.js"></script>
        <script type="text/javascript" src="js/jquery.nanoscroller/jquery.nanoscroller.js"></script>
        <script type="text/javascript" src="js/jquery.sparkline/jquery.sparkline.min.js"></script>
        <script type="text/javascript" src="js/jquery.ui/jquery-ui.js"></script>
        <script type="text/javascript" src="js/jquery.gritter/js/jquery.gritter.js"></script>
        <script type="text/javascript" src="js/behaviour/core.js"></script>
        <script src="js/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="js/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="js/datatables-button/dataTables.buttons.min.js"></script>
        <script src="js/datatables-button/buttons.flash.min.js"></script>
        <script src="js/datatables-button/jszip.min.js"></script>
        <script src="js/datatables-button/pdfmake.min.js"></script>
        <script src="js/datatables-button/vfs_fonts.js"></script>
        <script src="js/datatables-button/buttons.html5.min.js"></script>
        <script src="js/datatables-button/buttons.print.min.js"></script>
        <script src="js/jquery.maskedinput/jquery.maskedinput.js" type="text/javascript"></script>
        <script src="app-js/main.js"></script>
        <script src="app-js/datatables.js"></script>
        <script src="app-js/cliente.js?v=<?= time() ?>"></script>
        <style>
            .btn-purple {
                background-color: #9b59b6;
                border-color: #8e44ad;
                color: #fff;
            }
            .btn-purple:hover {
                background-color: #8e44ad;
                border-color: #7d3c98;
                color: #fff;
            }
        </style>
        <script type="text/javascript">
            $('#menu-cliente').addClass('active');
            <?php if (isset($_GET['success'])): ?>
                _alert_success();
            <?php endif; ?>

            // Abrir modal de histórico de compras
            $(document).on('click', '.btn-historico', function() {
                var clienteId = $(this).data('id');
                var clienteNome = $(this).data('nome');

                $('#cliente-nome').text(clienteNome);
                $('#historico-content').hide();
                $('#historico-loading').show();
                $('#modal-historico').modal('show');

                // Carregar histórico via AJAX
                $.ajax({
                    url: '<?php echo $baseUri; ?>/cliente/historico/' + clienteId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#historico-loading').hide();
                        $('#historico-content').show();

                        var tbody = $('#historico-tbody');
                        tbody.empty();

                        if (response.pedidos && response.pedidos.length > 0) {
                            var totalPedidos = 0;
                            var valorTotal = 0;

                            $.each(response.pedidos, function(index, pedido) {
                                totalPedidos++;
                                valorTotal += parseFloat(pedido.total);

                                var statusClass = '';
                                var statusText = '';

                                switch (pedido.status) {
                                    case 1:
                                        statusClass = 'warning';
                                        statusText = 'Pendente';
                                        break;
                                    case 2:
                                        statusClass = 'info';
                                        statusText = 'Preparando';
                                        break;
                                    case 3:
                                        statusClass = 'primary';
                                        statusText = 'Saiu para Entrega';
                                        break;
                                    case 4:
                                        statusClass = 'success';
                                        statusText = 'Entregue';
                                        break;
                                    case 5:
                                        statusClass = 'danger';
                                        statusText = 'Cancelado';
                                        break;
                                    default:
                                        statusClass = 'default';
                                        statusText = 'Desconhecido';
                                }

                                var row = `
                                <tr>
                                    <td>${pedido.id}</td>
                                    <td>${pedido.data}</td>
                                    <td>R$ ${pedido.total.replace('.', ',')}</td>
                                    <td><span class="label label-${statusClass}">${statusText}</span></td>
                                    <td>
                                        <a href="<?php echo $baseUri; ?>/admin/pedido/${pedido.id}/" class="btn btn-xs btn-primary" target="_blank">
                                            <i class="fa fa-search"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            `;
                                tbody.append(row);
                            });

                            $('#total-pedidos').text(totalPedidos);
                            $('#valor-total').text(valorTotal.toFixed(2).replace('.', ','));
                        } else {
                            tbody.append('<tr><td colspan="5" class="text-center">Nenhum pedido encontrado</td></tr>');
                            $('#total-pedidos').text('0');
                            $('#valor-total').text('0,00');
                        }
                    },
                    error: function() {
                        $('#historico-loading').hide();
                        $('#historico-content').show();
                        $('#historico-tbody').html('<tr><td colspan="5" class="text-center text-danger">Erro ao carregar histórico</td></tr>');
                    }
                });
            });

            // Logar como cliente
            $(document).on('click', '.btn-logar-cliente', function() {
                var clienteId = $(this).data('id');

                if (confirm('Deseja entrar como este cliente? Você será redirecionado para a área do cliente.')) {
                    // Mostrar loading
                    $(this).html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);

                    $.ajax({
                        url: '<?php echo $baseUri; ?>/cliente/logar_como_cliente',
                        method: 'POST',
                        data: {
                            cliente_id: clienteId
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Redirecionar para o site do cliente
                                window.open('<?php echo $baseUri; ?>/', '_blank');
                                location.reload();
                            } else {
                                alert('Erro: ' + (response.message || 'Não foi possível fazer login como cliente'));
                                location.reload();
                            }
                        },
                        error: function() {
                            alert('Erro ao fazer login como cliente');
                            location.reload();
                        }
                    });
                }
            });

            // Notificar desconto de fidelidade
            $(document).on('click', '.btn-notificar-fidelidade', function() {
                var clienteId = $(this).data('id');
                var clienteNome = $(this).data('nome');
                var clienteFone = $(this).data('fone');
                var btn = $(this);

                if (!clienteFone) {
                    alert('Cliente não possui telefone cadastrado!');
                    return;
                }

                if (confirm('🎁 Enviar notificação de fidelidade para ' + clienteNome + '?\n\nInformar que ganhou 10% OFF no próximo pedido!')) {
                    // Mostrar loading
                    btn.html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);

                    $.ajax({
                        url: '<?php echo $baseUri; ?>/cliente/notificar_fidelidade',
                        method: 'POST',
                        data: {
                            cliente_id: clienteId,
                            telefone: clienteFone,
                            nome: clienteNome
                        },
                        dataType: 'json',
                        success: function(response) {
                            btn.html('<i class="fa fa-gift"></i>').prop('disabled', false);
                            if (response.success) {
                                alert('✅ Notificação enviada com sucesso para ' + clienteNome + '!');
                            } else {
                                alert('❌ Erro ao enviar notificação: ' + (response.message || 'Erro desconhecido'));
                            }
                        },
                        error: function(xhr) {
                            btn.html('<i class="fa fa-gift"></i>').prop('disabled', false);
                            var errorMsg = 'Erro ao enviar notificação';
                            try {
                                var resp = JSON.parse(xhr.responseText);
                                errorMsg = resp.message || errorMsg;
                            } catch(e) {}
                            alert('❌ ' + errorMsg);
                        }
                    });
                }
            });
        </script>
</body>

</html>