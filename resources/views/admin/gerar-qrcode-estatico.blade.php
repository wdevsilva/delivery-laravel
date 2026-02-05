<?php

require __DIR__ . '../../../vendor/autoload.php';

use \App\Pix\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

//instancia principal do payloado pix
$obPayload = (new  Payload)->setPixKey('+5585991415641')
    ->setDescription('Pagamento mensalidade delivery Julho')
    ->setMerchantName('Washington Mendes')
    ->setMerchantCity('Pacajus')
    ->setAmount('150.00')
    ->setTxid('wdev150');

//código de pagamento do pix
$payloadQrcode = $obPayload->getPayload();

//qr code
$obQrCode = new QrCode($payloadQrcode);

//iamgem do qr code
$image = (new Output\Png)->output($obQrCode, 400);
?>
<h1>QR CODE ESTÁTICO</h1>
<br>
<img src="data:image/png;base64, <?=base64_encode($image)?>">
<br>
Código PIX:<br>
<strong><?=$payloadQrcode?></strong>