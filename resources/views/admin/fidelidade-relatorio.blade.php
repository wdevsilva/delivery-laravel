<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Relatório de Fidelidade</h3>
            </div>
            <div class="box-body">
                <?php if ($data['stats']): ?>
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-aqua">
                            <span class="info-box-icon"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Clientes</span>
                                <span class="info-box-number"><?= $data['stats']->total_clientes ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-green">
                            <span class="info-box-icon"><i class="fa fa-star"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Pontos</span>
                                <span class="info-box-number"><?= $data['stats']->total_pontos ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-yellow">
                            <span class="info-box-icon"><i class="fa fa-money"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Cashback Disponível</span>
                                <span class="info-box-number">R$ <?= number_format($data['stats']->total_cashback, 2, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-red">
                            <span class="info-box-icon"><i class="fa fa-shopping-cart"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Ticket Médio</span>
                                <span class="info-box-number">R$ <?= number_format($data['stats']->ticket_medio, 2, ',', '.') ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Top Clientes</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Pontos</th>
                                            <th>Cashback</th>
                                            <th>Total Gasto</th>
                                            <th>Nível</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($data['top_clientes']): ?>
                                        <?php foreach ($data['top_clientes'] as $cliente): ?>
                                        <tr>
                                            <td><?= $cliente->cliente_nome ?></td>
                                            <td><?= $cliente->pontos_acumulados ?></td>
                                            <td>R$ <?= number_format($cliente->cashback_disponivel, 2, ',', '.') ?></td>
                                            <td>R$ <?= number_format($cliente->total_gasto, 2, ',', '.') ?></td>
                                            <td>
                                                <span class="label label-<?= $cliente->nivel == 'diamante' ? 'warning' : ($cliente->nivel == 'ouro' ? 'success' : ($cliente->nivel == 'prata' ? 'default' : 'info')) ?>">
                                                    <?= ucfirst($cliente->nivel) ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="5">Nenhum cliente encontrado</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Configurações Ativas</h3>
                            </div>
                            <div class="box-body">
                                <table class="table">
                                    <tr>
                                        <td>Status:</td>
                                        <td>
                                            <span class="label label-<?= $data['config']->config_fidelidade_ativo == 1 ? 'success' : 'danger' ?>">
                                                <?= $data['config']->config_fidelidade_ativo == 1 ? 'ATIVO' : 'INATIVO' ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tipo:</td>
                                        <td><?= $data['config']->config_fidelidade_tipo ?></td>
                                    </tr>
                                    <tr>
                                        <td>Pontos por R$ 1:</td>
                                        <td><?= $data['config']->config_pontos_por_real ?></td>
                                    </tr>
                                    <tr>
                                        <td>Resgate (100 pts):</td>
                                        <td>R$ <?= $data['config']->config_valor_resgate_pontos ?></td>
                                    </tr>
                                    <tr>
                                        <td>Validade:</td>
                                        <td><?= $data['config']->config_fidelidade_validade_dias ?> dias</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Ações</h3>
                            </div>
                            <div class="box-body">
                                <a href="/admin/fidelidade/configuracoes" class="btn btn-primary btn-block">Configurações</a>
                                <a href="/admin/fidelidade/historico" class="btn btn-info btn-block">Histórico</a>
                                <a href="/admin/fidelidade/ajustar" class="btn btn-warning btn-block">Ajuste Manual</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
