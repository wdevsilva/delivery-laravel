<!-- Navbar -->
<nav class="navbar navbar-default navbar-custom navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= $baseUri ?>/garcon/">
                <i class="fa fa-cutlery"></i> <?= $data['config']->config_nome ?>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="<?= $baseUri ?>/garcon/">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                </li>
                <li class="active">
                    <a href="<?= $baseUri ?>/garcon/mesas/">
                        <i class="fa fa-th-large"></i> Minhas Mesas
                    </a>
                </li>
                <li>
                    <a href="<?= $baseUri ?>/garcon/estatisticas/">
                        <i class="fa fa-bar-chart"></i> Estatísticas
                    </a>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"></i> <?= $data['garcon']->garcon_nome ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?= $baseUri ?>/garcon/logout/">
                                <i class="fa fa-sign-out"></i> Sair
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>