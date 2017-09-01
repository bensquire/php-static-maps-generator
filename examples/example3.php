<?php

include('../vendor/autoload.php');

$oStaticMap = new \GoogleStaticMap\GoogleStaticMap();
$oStaticMap->setCenter('London,UK')
        ->setHeight(300)
        ->setWidth(232)
        ->setZoom(8)
        ->setMapType('hybrid')
        ->setFormat('png');

$oStaticMap->setMarker([
    'color' => 'blue',
    'size' => 'mid',
    'longitude' => -0.062004,
    'latitude' => 51.462564,
    'label' => 'b'
]);

echo '<img src="' . $oStaticMap . '" height="' . $oStaticMap->getHeight() . '" width="' . $oStaticMap->getWidth() . '" />';
