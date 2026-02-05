<?php 
// Include module manager for menu filtering
require_once 'core/ModuleManager.php';
?>
<style>
@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.8;
    }
}
.badge-success {
    background-color: #28a745 !important;
    color: white !important;
    font-size: 9px !important;
    padding: 3px 6px !important;
    border-radius: 10px !important;
    font-weight: bold !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
}
</style>
<div class="cl-toggle"><i class="fa fa-bars"></i></div>
<div class="cl-navblock">
    <div class="menu-space">
        <div class="content">
            <h3 class="text-whites">&nbsp;</h3>
            <div class="sidebar-logo" style="padding-left:0px">
                <h5 style="color:#fff" class="text-center text-uppercase">
                    <?= (new configModel)->get_config()->config_nome; ?>
                </h5>
            </div>
            <div class="side-user">
                <div class="avatar hide"><img src="<?php echo Sessao::get_avatar(); ?>" alt="Avatar" width="50" height="50" /></div>
                <div class="info">
                    <p><b>PAINEL DE CONTROLE</b> <span><a name="dash-ancor"><i class="fa fa-cog"></i></a></span></p>
                    <div class="progress progress-user">
                        <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            <span class="sr-only hide">100%</span>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="cl-vnavigation">
                <li id="menu-home"><a href="<?php echo $baseUri; ?>/admin/"><i class="fa fa-home"></i><span>Home</span></a>
                <?php if (Sessao::get_nivel() == 1) : ?>
                    <id="menu-dashboard"><a href="<?php echo $baseUri; ?>/admin/dashboard/"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
                <?php endif; ?>
                <?php if (Sessao::get_bot_whatsapp() == 1) : ?>
                    <li id="menu-bot-whatsapp"><a href="<?php echo $baseUri; ?>/bot-whatsapp/" target="_blank"><i class="fa fa-whatsapp" style="color: #25D366;"></i><span>Bot WhatsApp <span class="badge badge-success" style="margin-left: 5px; animation: pulse 2s infinite;">NOVO</span></span></a></li>
                    <!-- Bot Instagram temporariamente desabilitado - Aguardando aprovação Meta Business -->
                    <!-- <li id="menu-bot-instagram"><a href="<?php echo $baseUri; ?>/bot_instagram/conectar.php" target="_blank"><i class="fa fa-instagram" style="color: #E1306C;"></i><span>Bot Instagram <span class="badge badge-info" style="margin-left: 5px; animation: pulse 2s infinite;">NOVO</span></span></a></li> -->
                <?php endif; ?>
                <li id="menu-"><a href="<?php echo $baseUri; ?>/" target="_blank"><i class="fa fa-globe"></i><span>Visualizar site</span></a></li>                
                <li id="menu-venda-rapida"><a href="<?php echo $baseUri; ?>/admin/venda_rapida/"><i class="fa fa-shopping-cart"></i><span>Venda Rápida (PDV)</span></a></li>
                <?php if (ModuleManager::isModuleEnabled(ModuleManager::MODULE_MESAS)): ?>
                <li id="menu-mesa"><a href="<?php echo $baseUri; ?>/mesa/"><i class="fa fa-cutlery"></i><span>Gestão de Mesas</span></a></li>
                <li id="menu-garcon"><a href="<?php echo $baseUri; ?>/admin/garcon/"><i class="fa fa-user-md"></i><span>Garçons</span></a></li>
                <li id="menu-cozinha"><a href="<?php echo $baseUri; ?>/cozinha/display/" target="_blank"><i class="fa fa-fire"></i><span>Display Cozinha</span></a></li>
                <li id="menu-caixa"><a href="<?php echo $baseUri; ?>/admin/caixa/"><i class="fa fa-calculator"></i><span>Caixa</span></a></li>
                <?php endif; ?>
                <li id="menu-cliente"><a href="<?php echo $baseUri; ?>/cliente/"><i class="fa fa-street-view"></i><span>Clientes</span></a></li>
                <!-- <li id="menu-reconciliacao"><a href="<?php echo $baseUri; ?>/marketing/"><i class="fa fa-bullhorn" aria-hidden="true"></i><span>Marketing</span></a> -->
                <li id="menu-categoria"><a href="<?php echo $baseUri; ?>/categoria/"><i class="fa fa-tags"></i><span>Categorias</span></a></li>
                <li id="menu-cupom"><a href="<?php echo $baseUri; ?>/cupom/"><i class="fa fa-money"></i><span>Cupons <span class="badge badge-success" style="margin-left: 5px; animation: pulse 2s infinite;">NOVO</span></span></a></li>
                <li id="menu-entregador"><a href="<?php echo $baseUri; ?>/entregador/"><i class="fa fa-motorcycle"></i><span>Entregador</span></a></li>
                <li id="menu-grupo"><a href="<?php echo $baseUri; ?>/grupo/"><i class="fa fa-th"></i><span>Grupos</span></a></li>
                <li id="menu-pedido"><a href="<?php echo $baseUri; ?>/admin/pedidos/"><i class="fa fa-list"></i><span>Pedidos</span></a></li>
                <?php if (Sessao::get_bot_whatsapp() == 1) : ?>
                    <li id="menu-avaliacoes"><a href="<?php echo $baseUri; ?>/avaliacao/" target="_blank"><i class="fa fa-star"></i><span>Avaliações <span class="badge badge-success" style="margin-left: 5px; animation: pulse 2s infinite;">NOVO</span></span></a></li>
                <?php endif; ?>
                <li id="menu-item"><a href="<?php echo $baseUri; ?>/item/"><i class="fa fa-th-list"></i><span>Produtos</span></a></li>
                <?php if (Sessao::get_nivel() == 1) : ?>
                <li id="menu-promocoes"><a href="<?php echo $baseUri; ?>/promo/"><i class="fa fa-th-list"></i><span>Promoções</span> <span class="badge badge-success" style="margin-left: 5px; animation: pulse 2s infinite;">NOVO</span></a></li>
                <?php endif; ?>
                <?php if (Sessao::get_nivel() == 1 && strtolower(Sessao::get_nome()) == "suporte") : ?>
                <li id="menu-fidelidade"><a href="<?php echo $baseUri; ?>/fidelidade/"><i class="fa fa-gift"></i><span>Programa de Fidelidade</span> <span class="badge badge-success" style="margin-left: 5px; animation: pulse 2s infinite;">NOVO</span></a></li>
                <?php endif; ?>
                <!-- <li id="menu-banner"><a href="<?php echo $baseUri; ?>/banner/"><i class="fa fa-picture-o"></i><span>Banner</span></a> -->
                    <?php if (Sessao::get_nivel() == 1) : ?>
                <li id="menu-usuario"><a href="<?php echo $baseUri; ?>/usuario/"><i class="fa fa-users"></i><span>Usuários</span></a></li>
            <?php endif; ?>
            
            <?php if (Sessao::get_nivel() == 1) : ?>
                <li id="menu-mensalidade"><a href="<?php echo $baseUri; ?>/mensalidade/"><i class="fa fa-money"></i><span>Mensalidades</span></a></li>
                <li id="menu-relvendas">
                    <a href="<?php echo $baseUri; ?>/admin/"><i class="fa fa-file-pdf-o" aria-hidden="true"></i><span>Relatórios</span></a>
                    <ul class="sub-menu">
                        <li id="menu-rel-vendas"><a href="<?php echo $baseUri; ?>/relatorio/vendas/"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Vendas</a></li>
                        <li id="menu-rel-produtos"><a href="<?php echo $baseUri; ?>/relatorio/produtos/"><i class="fa fa-barcode" aria-hidden="true"></i> Produtos</a></li>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (Sessao::get_nivel() == 1) : ?>                
                <li id="menu-config">
                    <a href="<?php echo $baseUri; ?>/admin/"><i class="fa fa-cog"></i><span>Configurações</span></a>
                    <ul class="sub-menu">
                        <li id="menu-config-geral"><a href="<?php echo $baseUri; ?>/configuracao/"><i class="fa fa-globe"></i> Configuração Geral</a></li>
                        <li id="menu-config-horarios"><a href="<?php echo $baseUri; ?>/configuracao/horarios/"><i class="fa fa-clock-o"></i> Horários de Funcionamento</a></li>
                        <li id="menu-config-tema"><a href="<?php echo $baseUri; ?>/configuracao/tema/"><i class="fa fa-tint"></i> Aparência do Site</a></li>
                        <li id="menu-config-bairro"><a href="<?php echo $baseUri; ?>/entrega/bairro/"><i class="fa fa-map-marker"></i> Bairros para Entrega</a></li>
                        <li id="menu-config-email"><a href="<?php echo $baseUri; ?>/configuracao-email/"><i class="fa fa-envelope-o"></i> Configurações de email</a></li>
                        <?php if(!empty((new configModel)->get_config()->config_taxa_tipo)){ ?>
                            <li id="menu-config-taxa-card"><a href="<?php echo $baseUri; ?>/configuracao/taxaCard/"><i class="fa fa-money"></i> Configurações taxa de Cartão</a></li>
                            <?php if((new configModel)->get_config()->config_taxa_tipo === 'taxa_por_categoria'){ ?>
                                <li id="menu-config-taxa-categoria"><a href="<?php echo $baseUri; ?>/configuracao/taxaPorCategoria/"><i class="fa fa-tags"></i> Taxa por Categoria Individual</a></li>
                            <?php } ?>
                        <?php } ?>
                        <li id="menu-config-pagseguro"><a href="<?php echo $baseUri; ?>/pagamento/"><i class="fa fa-money"></i> Parâmetros do PagSeguro</a></li>
                        <li id="menu-config-mercadopago"><a href="<?php echo $baseUri; ?>/configuracao/tutorialMercadopago/"><i class="fa fa-info"></i> Tutorial chave Mercado Pago</a></li>
                        <li id="menu-config-modulos"><a href="<?php echo $baseUri; ?>/admin/modulos/"><i class="fa fa-puzzle-piece"></i> Gerenciar Módulos</a></li>
                        <li id="menu-config-bluetooth-printer"><a href="<?php echo $baseUri; ?>/admin/bluetooth-printer-setup/"><i class="fa fa-print"></i> Impressora Bluetooth</a></li>
                    </ul>
                </li>
            <?php endif; ?>
            <li id="menu-"><a href="<?php echo $baseUri; ?>/login/logout/"><i class="fa fa-power-off"></i><span>Sair</span></a></li>
            </ul>
        </div>
        <div class="text-right collapse-button" style="padding:7px 9px;">
            <button id="sidebar-collapse" class="btn btn-default"><i style="color:#fff;" class="fa fa-angle-left"></i></button>
        </div>
    </div>
</div>