<?php

include('../vendor/autoload.php');

/*
 * Generates a 600x600 pixel google map, doubly scaled. Additionally draw a path between 3 different locations.
 */

$pathPoint = new \GoogleStaticMap\Path\Point();
$pathPoint->setLatitude(51.855376);
$pathPoint->setLongitude(-0.576904);

$pathPoint2 = new \GoogleStaticMap\Path\Point();
$pathPoint2->setLocation('Wembley, UK');

$pathPoint3 = new \GoogleStaticMap\Path\Point();
$pathPoint3->setLocation('Barnet, UK');

$path = new \GoogleStaticMap\Path();
$path->setColor('0x00000000');
$path->setWeight(5);
$path->setFillColor('0xFFFF0033');
$path->addPoint($pathPoint);
$path->addPoint($pathPoint2);
$path->addPoint($pathPoint3);

$map = new \GoogleStaticMap\Map();
$map->setHeight(600);
$map->setWidth(600);
$map->setMapType('hybrid');
$map->setFormat('png8');
$map->setMapPath($path);

echo '<img src="' . $map . '" height="' . $map->getHeight() . '" width="' . $map->getWidth() . '" />';
