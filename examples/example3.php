<?php

include('../vendor/autoload.php');

$marker = new \GoogleStaticMap\Marker([
    'color' => 'blue',
    'size' => 'mid',
    'longitude' => -0.062004,
    'latitude' => 51.462564,
    'label' => 'b'
]);

$oStaticMap = new \GoogleStaticMap\Map();
$oStaticMap->setCenter('London,UK')
        ->setHeight(300)
        ->setWidth(232)
        ->setZoom(8)
        ->setMapType('hybrid')
        ->setFormat('png');

$oStaticMap->addMarker($marker);

echo '<img src="' . $oStaticMap . '" height="' . $oStaticMap->getHeight() . '" width="' . $oStaticMap->getWidth() . '" />';
