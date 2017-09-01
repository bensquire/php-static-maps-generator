<?php

include('../vendor/autoload.php');

$oStaticMap = new \GoogleStaticMap\Map();
$oStaticMap->setCenter('London,UK')
        ->setHeight(300)
        ->setWidth(300)
        ->setZoom(8)
        ->setMapType('hybrid')
        ->setFormat('png');

$oStaticMap->addMarker([
    'color' => 'blue',
    'size' => 'mid',
    'longitude' => -0.062004,
    'latitude' => 51.462564,
    'label' => 'C'
]);

$oMarker = new \GoogleStaticMap\Marker();
$oMarker->setColor('red')
        ->setSize('large')
        ->setLongitude(-0.576904)
        ->setLatitude(51.855376)
        ->setLabel('B');

$oStaticMap->addMarker($oMarker);

echo '<img src="' . $oStaticMap . '" height="' . $oStaticMap->getHeight() . '" width="' . $oStaticMap->getWidth() . '" />';
