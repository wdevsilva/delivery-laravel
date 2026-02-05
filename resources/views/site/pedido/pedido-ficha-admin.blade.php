<?php
function br()
{
    echo "<br> \n";
}

?>
<?php if (isset($data['pedido'])) : ?>
    PEDIDO - <?= $data['pedido']->pedido_id ?><?php br(); ?>
    Data do pedido: <?= date('d/m/Y H:i', strtotime($data['pedido']->pedido_data)); ?><?php br(); ?>
    Cliente: <?= $data['pedido']->cliente_nome ?><?php br(); ?>
    Telefone de Entrega: <?= $data['pedido']->cliente_fone ?><?php br(); ?>
    Taxa de Entrega:  R$ <?= Currency::moeda($data['pedido']->pedido_entrega) ?><?php br(); ?>
    Total do Pedido: R$ <?= ($data['pedido']->pedido_total > 0) ? Currency::moeda($data['pedido']->pedido_total) : '0.00'; ?><?php br(); ?>

    <?php $status = Status::check($data['pedido']->pedido_status); ?>
    Status do Pedido: <?= $status->icon ?><?php br(); ?>
    Observações: <?= strip_tags($data['pedido']->pedido_obs) ?><?php br(); ?>

    <?php $end = $data['endereco']; ?>
    <?php if (isset($end->endereco_nome) && !empty($end->endereco_nome)): ?>
        Local de Entrega: <?= $end->endereco_nome ?><?php br(); ?>
    <? endif; ?>

    <?php if (isset($end->endereco_endereco) && !empty($end->endereco_endereco)): ?>
        Endereço <?= $end->endereco_endereco ?>, <?= $end->endereco_numero ?>, <?php if ($end->endereco_complemento != ""): ?> <?= $end->endereco_complemento ?> - <?php endif; ?> <?= $end->endereco_cidade ?> - <?= $end->endereco_uf ?><?php br(); ?>
    <? endif; ?>
    <?php if (isset($data['lista'])): ?>
        Itens do Pedido: <?php br(); ?>
        <?php foreach ($data['lista'] as $cart): ?>
            <?= $cart->lista_item_codigo ?>|<?= $cart->lista_item_nome ?> <?= ($cart->lista_opcao_nome != "") ? ' - ' . $cart->lista_opcao_nome : '' ?>|<?= $cart->lista_qtde ?>|<?= $cart->lista_opcao_preco ?>|<?= strip_tags($cart->lista_item_desc) ?><?php br(); ?>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>
     