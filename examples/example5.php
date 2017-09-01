<?php

include('../vendor/autoload.php');

$oStaticMap = new \GoogleStaticMap\Map();
$oStaticMap->setHeight(600)
        ->setWidth(600)
        ->setMapType('hybrid')
        ->setFormat('jpg')
        ->setScale(2);

//Create Path Object and set styling
$oPath = new \GoogleStaticMap\Path();
$oPath->setColor('red')
        ->setWeight(5);

//Create Path Point
$oPathPoint = new \GoogleStaticMap\PathPoint();
$oPathPoint->setLatitude(51.855376)
        ->setLongitude(-0.576904);
$oPath->setPoint($oPathPoint);

//Create Another Path Point
$oPathPoint2 = new \GoogleStaticMap\PathPoint();
$oPathPoint2->setLocation('Wembley, UK');
$oPath->setPoint($oPathPoint2);

//Add Points to Map
$oStaticMap->setMapPath($oPath);

echo '<img src="' . $oStaticMap . '" height="' . $oStaticMap->getHeight() * 2 . '" width="' . $oStaticMap->getWidth() * 2 . '" />';
