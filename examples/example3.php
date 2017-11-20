<?php

include('../vendor/autoload.php');

/*
 * Generates a 300x232 pixel google map, centred over London at a zoom level of 8. Additionally display a marker
 * which is medium sized and blue, with a label 'b'.
 */

$marker = new \GoogleStaticMap\Marker();
$marker->setColor('blue');
$marker->setSize('mid');
$marker->setLongitude(-0.062004);
$marker->setLatitude(51.462564);
$marker->setLabel('D');

$map = new \GoogleStaticMap\Map();
$map->setCenter('London,UK');
$map->setHeight(300);
$map->setWidth(232);
$map->setZoom(8);
$map->setMapType('hybrid');
$map->setFormat('png');
$map->addMarker($marker);

echo '<img src="' . $map . '" height="' . $map->getHeight() . '" width="' . $map->getWidth() . '" />';
