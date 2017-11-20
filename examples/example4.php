<?php

include('../vendor/autoload.php');

/*
 * Generates a 300x300 pixel google map, centred over London at a zoom level of 8. Additionally display 2 markers
 * with different labels.
 */

$marker = new \GoogleStaticMap\Marker();
$marker->setLongitude(-0.062004);
$marker->setLatitude(51.462564);
$marker->setIconUrl('https://goo.gl/5y3S82');

$marker2 = new \GoogleStaticMap\Marker();
$marker2->setColor('red');
$marker2->setSize('large');
$marker2->setLongitude(-0.576904);
$marker2->setLatitude(51.855376);
$marker2->setLabel('B');

$map = new \GoogleStaticMap\Map();
$map->setCenter('London,UK');
$map->setHeight(300);
$map->setWidth(300);
$map->setZoom(8);
$map->setMapType('hybrid');
$map->setFormat('png');
$map->addMarker($marker);
$map->addMarker($marker2);

echo '<img src="' . $map . '" height="' . $map->getHeight() . '" width="' . $map->getWidth() . '" />';
