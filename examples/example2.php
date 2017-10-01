<?php

include('../vendor/autoload.php');

/*
 * Generates a 300x232 pixel google map, centred over London at a zoom level of 8. Additionally display all features
 * lightened and dark green.
 */

$styling = new \GoogleStaticMap\Feature\Styling();
$styling->setHue('#006400');
$styling->setLightness(50);

$featureStyling = new \GoogleStaticMap\Feature();
$featureStyling->setFeature('all');
$featureStyling->setElement('all');
$featureStyling->setStyle($styling);

$map = new \GoogleStaticMap\Map();
$map->setCenter('London,UK');
$map->setHeight(300);
$map->setWidth(232);
$map->setZoom(8);
$map->setFormat('jpg');
$map->addFeature($featureStyling);

echo '<img src="' . $map . '" height="' . $map->getHeight() . '" width="' . $map->getWidth() . '" />';
