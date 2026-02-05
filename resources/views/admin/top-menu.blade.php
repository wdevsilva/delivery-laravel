<ul class="nav navbar-nav navbar-left pedidos-alerta" style="margin-top: 20px; position: relative; z-index: 10;">
    <span class="fa fa-bell fa-4x"></span>
    <?php  if(isset($data['config']) && $data['config']->config_bell == 0): ?>
        <a href="<?php echo $baseUri; ?>/configuracao/"
            sclass="btn btn-xs btn-primary">Alerta sonoro desativado</a>
    <?php endif;?>
</ul>

<ul class="nav navbar-nav navbar-right user-nav">
    <li class="dropdown profile_menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <ul class="dropdown-menu">
            <li><a href="<?php echo $baseUri; ?>/usuario/me/">Minha Conta</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo $baseUri; ?>/login/logout/">Sair</a></li>
        </ul>
    </li>
</ul>	
<!-- variaveis usadas no main.js -->
<script> var baseUri = '<?php echo $baseUri; ?>'; </script>
<script> var baseDir = window.baseUri; </script>