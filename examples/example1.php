<?php

include('../vendor/autoload.php');

/*
 * Generates a 300x232 pixel google map, centred over London at a zoom level of 8, using HTTPS.
 */

$map = new \GoogleStaticMap\Map();
$map->setCenter('London,UK');
$map->setHeight(300);
$map->setWidth(232);
$map->setZoom(8);
$map->setHttps(true);

echo '<img src="' . $map . '" height="' . $map->getHeight() . '" width="' . $map->getWidth() . '" />';
