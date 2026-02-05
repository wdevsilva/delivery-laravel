<?php

//var_dump($data['pedido']);

function parseToXML($htmlStr)
{
    $xmlStr = str_replace('<', '&lt;', $htmlStr);
    $xmlStr = str_replace('>', '&gt;', $xmlStr);
    $xmlStr = str_replace('"', '&quot;', $xmlStr);
    $xmlStr = str_replace("'", '&#39;', $xmlStr);
    $xmlStr = str_replace("&", '&amp;', $xmlStr);
    return $xmlStr;
}

header("Content-type: text/xml");

echo '<markers>';

for ($i = 0; $i < count($data['pedido']); $i++) {
    echo '<marker ';
    echo 'name="Pedido nº' . $data['pedido'][$i]->pedido_id . ' | ' . parseToXML($data['pedido'][$i]->endereco_nome) . '" ';
    echo 'address="' . parseToXML($data['pedido'][$i]->endereco_endereco . ',' . $data['pedido'][$i]->endereco_numero) . '" ';
    echo 'lat="' . $data['pedido'][$i]->endereco_lat . '" ';
    echo 'lng="' . $data['pedido'][$i]->endereco_lng . '" ';
    echo 'type="" ';
    echo '/>';
}
echo '</markers>';