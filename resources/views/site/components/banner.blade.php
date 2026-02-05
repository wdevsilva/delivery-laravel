<?php if (isset($data['banner'])): ?>
    <div class="banner hide">
        <?php foreach ($data['banner'] as $ban): ?>
            <img src="<?= $baseUri ?>/midias/banner/<?=$_SESSION[base_delivery]?>/<?= $ban->banner_url ?>" class="img-responsive" alt="banner"/>
        <?php endforeach; ?>
    </div>
<?php endif; ?>