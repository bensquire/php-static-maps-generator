<?php

include('../vendor/autoload.php');

/*
 * Generates a 600x600 pixel google map, doubly scaled. Additionally draw a path between 2 points.
 */

$pathPoint = new \GoogleStaticMap\Path\Point();
$pathPoint->setLatitude(51.855376);
$pathPoint->setLongitude(-0.576904);

$pathPoint2 = new \GoogleStaticMap\Path\Point();
$pathPoint2->setLocation('Wembley, UK');

$path = new \GoogleStaticMap\Path();
$path->setColor('red');
$path->setWeight(5);
$path->addPoint($pathPoint);
$path->addPoint($pathPoint2);

$map = new \GoogleStaticMap\Map();
$map->setHeight(600);
$map->setWidth(600);
$map->setMapType('hybrid');
$map->setFormat('jpg');
$map->setScale(2);
$map->setMapPath($path);

echo '<img src="' . $map . '" height="' . $map->getHeight() * 2 . '" width="' . $map->getWidth() * 2 . '" />';
