<?php

/*
 * Generates a 600x600 pixel google map, centered over 2 path points, 1 defined
 * using coordinates, the other using a string. Scale set to 2 (double resolution)
 */

include('../googlestaticmap.php');
include('../googlestaticmapfeature.php');
include('../googlestaticmapfeaturestyling.php');
include('../googlestaticmapmarker.php');
include('../googlestaticmappath.php');
include('../googlestaticmappathpoint.php');

$oStaticMap = new GoogleStaticMap();
$oStaticMap->setHeight(600)
		->setWidth(600)
		->setMapType('hybrid')
		->setFormat('jpg')
		->setScale(2);

//Create Path Object and set styling
$oPath = new GoogleStaticMapPath();
$oPath->setColor('red')
		->setWeight(5);

//Create Path Point
$oPathPoint = new GoogleStaticMapPathPoint();
$oPathPoint->setLatitude(51.855376)
		->setLongitude(-0.576904);
$oPath->setPoint($oPathPoint);

//Create Another Path Point
$oPathPoint2 = new GoogleStaticMapPathPoint();
$oPathPoint2->setLocation('Wembley, UK');
$oPath->setPoint($oPathPoint2);

//Add Points to Map
$oStaticMap->setMapPath($oPath);

echo '<img src="' . $oStaticMap . '" height="' . $oStaticMap->getHeight() * 2 . '" width="' . $oStaticMap->getWidth() * 2 . '" />';