<form action="<?php echo $baseUri; ?>/busca/" method="post"
      class="navbar-form" role="search"
      style="<?= ($isMobile) ? 'position: fixed; z-index: 1000; background: #fafafa;' : ''; ?>  <?= (!$isMobile) ? 'padding: 0px' : ''; ?> "
      id="form-busca" autocomplete="off">
    <select class="select2 input-lg form-control" id="busca" name="busca" autocomplete="off" >
        <option value=""></option>
        <?php if (isset($data['lista_combo'])) : ?>
            <?php foreach ($data['lista_combo'] as $obj) : ?>
                <optgroup label="<?= $obj['categoria'] ?>"> >
                    <?php foreach ($obj['item'] as $item) : ?>
                        <option value="<?= $item->item_nome ?>"
                                data-desc="<?= strip_tags($item->item_desc) ?>"
                                data-cod="<?= strip_tags($item->item_codigo) ?>"
                                data-obs="<?= strip_tags($item->item_obs) ?>">
                            <?= $obj['categoria'] ?> <?= $item->item_nome ?>
                            <!-- <?= ($item->item_codigo != "") ? " Ref:  $item->item_codigo" : '' ?>-->
                        </option>
                    <?php endforeach; ?>
                </optgroup>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
    <input type="hidden" name="ipt-nome" id="ipt-nome"/>
    <input type="hidden" name="ipt-cod" id="ipt-cod"/>
    <input type="hidden" name="ipt-desc" id="ipt-desc"/>
</form>