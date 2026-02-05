<?php $baseUri = Http::base(); ?>
<base href="<?php echo $baseUri; ?>/view/admin/">
<title><?= (isset($data['config']->config_nome)) ? $data['config']->config_nome : 'Painel Admin'; ?></title>
<link rel="icon" type="image/png" href="<?php echo $baseUri; ?>/midias/logo/<?= isset($_SESSION['base_delivery']) ? $_SESSION['base_delivery'] : 'default' ?>/<?php echo (new configModel)->get_config()->config_foto; ?>" />