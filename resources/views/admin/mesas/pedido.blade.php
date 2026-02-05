<?php
/*
 * Pedidos da Mesa - Administrativo
 * Gerenciamento de pedidos para mesa específica
 */
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Mesa <?php echo $mesa->mesa_numero ?? 'N/A'; ?></title>
    <link rel="stylesheet" href="<?php echo Helper::assets(); ?>bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo Helper::assets(); ?>font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo Helper::assets(); ?>css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?php echo Helper::assets(); ?>css/skins/skin-blue.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <!-- Header -->
    <header class="main-header">
        <a href="/admin" class="logo">
            <span class="logo-mini"><b>M</b>esa</span>
            <span class="logo-lg"><b><?php echo $config->config_nome; ?></b></span>
        </a>
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li><a href="/admin/mesa"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="/admin/mesa/lista"><i class="fa fa-list"></i> Lista</a></li>
                    <li><a href="/login/logout"><i class="fa fa-sign-out"></i> Sair</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Sidebar -->
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">GERENCIAMENTO DE MESAS</li>
                <li>
                    <a href="/admin/mesa"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                </li>
                <li>
                    <a href="/admin/mesa/lista"><i class="fa fa-list"></i> <span>Lista de Mesas</span></a>
                </li>
                <li>
                    <a href="/admin/mesa/novo"><i class="fa fa-plus"></i> <span>Nova Mesa</span></a>
                </li>
            </ul>
        </section>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <h1>
                Pedidos - Mesa <?php echo $mesa->mesa_numero ?? 'N/A'; ?>
                <small>Gerenciamento de pedidos</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="/admin/mesa">Mesas</a></li>
                <li class="active">Pedidos</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <?php if (!$mesa): ?>
                <div class="alert alert-danger">
                    <h4><i class="icon fa fa-ban"></i> Mesa não encontrada!</h4>
                    A mesa solicitada não foi encontrada no sistema.
                    <br><br>
                    <a href="/admin/mesa/lista" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Voltar para Lista
                    </a>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-md-12">
                        <!-- Informações da Mesa -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Informações da Mesa</h3>
                                <div class="box-tools pull-right">
                                    <a href="/admin/mesa/detalhes/<?php echo $mesa->mesa_id; ?>" class="btn btn-default btn-sm">
                                        <i class="fa fa-eye"></i> Ver Detalhes
                                    </a>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Mesa:</strong> <?php echo $mesa->mesa_numero; ?><br>
                                        <strong>Capacidade:</strong> <?php echo $mesa->mesa_capacidade; ?> pessoas
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Localização:</strong> <?php echo $mesa->mesa_localizacao; ?><br>
                                        <strong>Status:</strong> 
                                        <?php 
                                            $status_map = [
                                                0 => '<span class="label label-success">Livre</span>',
                                                1 => '<span class="label label-danger">Ocupada</span>',
                                                2 => '<span class="label label-warning">Reservada</span>',
                                                3 => '<span class="label label-default">Manutenção</span>'
                                            ];
                                            echo $status_map[$mesa->mesa_status] ?? 'Desconhecido';
                                        ?>
                                    </div>
                                    <?php if ($mesa->mesa_status == 1 && isset($mesa->ocupacao_id)): ?>
                                        <div class="col-md-3">
                                            <strong>Cliente:</strong> <?php echo htmlspecialchars($mesa->ocupacao_cliente_nome ?? 'N/A'); ?><br>
                                            <strong>Garçom:</strong> <?php echo htmlspecialchars($mesa->garcon_nome ?? 'N/A'); ?>
                                        </div>
                                        <div class="col-md-3">
                                            <strong>Início:</strong> <?php echo $mesa->ocupacao_inicio ? date('H:i', strtotime($mesa->ocupacao_inicio)) : 'N/A'; ?><br>
                                            <strong>Pessoas:</strong> <?php echo $mesa->ocupacao_numero_pessoas ?? 'N/A'; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if ($mesa->mesa_status != 1): ?>
                    <div class="alert alert-warning">
                        <h4><i class="icon fa fa-warning"></i> Mesa não está ocupada!</h4>
                        Esta mesa não está ocupada atualmente. Para gerenciar pedidos, a mesa precisa estar ocupada.
                        <br><br>
                        <a href="/admin/mesa" class="btn btn-primary">
                            <i class="fa fa-dashboard"></i> Ir para Dashboard
                        </a>
                        <a href="/admin/mesa/lista" class="btn btn-default">
                            <i class="fa fa-list"></i> Lista de Mesas
                        </a>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Pedidos da Mesa -->
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Pedidos da Mesa</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-success btn-sm" onclick="novoPedido()">
                                            <i class="fa fa-plus"></i> Novo Pedido
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <?php if (!empty($pedidos)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Pedido</th>
                                                        <th>Data/Hora</th>
                                                        <th>Status</th>
                                                        <th>Total</th>
                                                        <th>Ações</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($pedidos as $pedido): ?>
                                                        <tr>
                                                            <td><strong>#<?php echo $pedido->pedido_id; ?></strong></td>
                                                            <td><?php echo date('d/m/Y H:i', strtotime($pedido->pedido_data)); ?></td>
                                                            <td>
                                                                <?php 
                                                                    $status_pedido = [
                                                                        1 => '<span class="label label-warning">Pendente</span>',
                                                                        2 => '<span class="label label-info">Preparando</span>',
                                                                        3 => '<span class="label label-primary">Pronto</span>',
                                                                        4 => '<span class="label label-success">Entregue</span>'
                                                                    ];
                                                                    echo $status_pedido[$pedido->pedido_status] ?? 'Desconhecido';
                                                                ?>
                                                            </td>
                                                            <td>R$ <?php echo number_format($pedido->pedido_total ?? 0, 2, ',', '.'); ?></td>
                                                            <td>
                                                                <a href="/admin/pedido/<?php echo $pedido->pedido_id; ?>" class="btn btn-info btn-xs">
                                                                    <i class="fa fa-eye"></i> Ver
                                                                </a>
                                                                <?php if ($pedido->pedido_status < 4): ?>
                                                                    <button class="btn btn-warning btn-xs" onclick="alterarStatusPedido(<?php echo $pedido->pedido_id; ?>, <?php echo $pedido->pedido_status; ?>)">
                                                                        <i class="fa fa-edit"></i> Status
                                                                    </button>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-info text-center">
                                            <h4><i class="icon fa fa-info"></i> Nenhum pedido registrado</h4>
                                            <p>Esta mesa ainda não possui pedidos.</p>
                                            <button class="btn btn-success" onclick="novoPedido()">
                                                <i class="fa fa-plus"></i> Fazer Primeiro Pedido
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Resumo -->
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Resumo</h3>
                                </div>
                                <div class="box-body">
                                    <?php 
                                        $total_pedidos = count($pedidos ?? []);
                                        $total_valor = 0;
                                        $pedidos_abertos = 0;
                                        
                                        if ($pedidos) {
                                            foreach ($pedidos as $pedido) {
                                                $total_valor += $pedido->pedido_total ?? 0;
                                                if ($pedido->pedido_status < 4) {
                                                    $pedidos_abertos++;
                                                }
                                            }
                                        }
                                    ?>
                                    <table class="table table-bordered">
                                        <tr>
                                            <td><strong>Total de Pedidos:</strong></td>
                                            <td><?php echo $total_pedidos; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pedidos Abertos:</strong></td>
                                            <td><?php echo $pedidos_abertos; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Valor Total:</strong></td>
                                            <td><strong>R$ <?php echo number_format($total_valor, 2, ',', '.'); ?></strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Ações -->
                            <div class="box box-warning">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Ações da Mesa</h3>
                                </div>
                                <div class="box-body">
                                    <button class="btn btn-success btn-block" onclick="novoPedido()">
                                        <i class="fa fa-plus"></i> Novo Pedido
                                    </button>
                                    <button class="btn btn-info btn-block" onclick="imprimirConta()">
                                        <i class="fa fa-print"></i> Imprimir Conta
                                    </button>
                                    <button class="btn btn-warning btn-block" onclick="liberarMesa(<?php echo $mesa->mesa_id; ?>, <?php echo $mesa->ocupacao_id ?? 0; ?>)">
                                        <i class="fa fa-check"></i> Finalizar e Liberar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Sistema de Mesas</b> v1.0.0
        </div>
        <strong>&copy; <?php echo date('Y'); ?> <?php echo $config->config_nome; ?>.</strong>
    </footer>
</div>

<!-- Scripts -->
<script src="<?php echo Helper::assets(); ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?php echo Helper::assets(); ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo Helper::assets(); ?>js/adminlte.min.js"></script>

<script>
// Novo pedido
function novoPedido() {
    // Redireciona para o sistema de fazer pedido do garçom (reutilizando funcionalidade)
    window.location.href = '/garcon/fazer-pedido/<?php echo $mesa->mesa_id; ?>';
}

// Alterar status do pedido
function alterarStatusPedido(pedidoId, statusAtual) {
    var novoStatus = prompt('Novo status:\n1 = Pendente\n2 = Preparando\n3 = Pronto\n4 = Entregue\n\nDigite o número:', statusAtual);
    
    if (novoStatus && novoStatus >= 1 && novoStatus <= 4) {
        $.post('/admin/mesa/processar-pedido', {
            pedido_id: pedidoId,
            status: parseInt(novoStatus)
        }, function(response) {
            if (response.status === 'success') {
                alert('Status alterado com sucesso!');
                location.reload();
            } else {
                alert('Erro: ' + response.message);
            }
        }).fail(function() {
            alert('Erro ao comunicar com o servidor');
        });
    }
}

// Imprimir conta
function imprimirConta() {
    alert('Funcionalidade de impressão será implementada em breve.');
}

// Liberar mesa
function liberarMesa(mesaId, ocupacaoId) {
    if (confirm('Deseja realmente finalizar o atendimento e liberar esta mesa?')) {
        $.post('/admin/mesa/liberar', {
            mesa_id: mesaId,
            ocupacao_id: ocupacaoId
        }, function(response) {
            if (response.status === 'success') {
                alert(response.message);
                window.location.href = '/admin/mesa';
            } else {
                alert('Erro: ' + response.message);
            }
        }).fail(function() {
            alert('Erro ao comunicar com o servidor');
        });
    }
}

</script>

</body>
</html>