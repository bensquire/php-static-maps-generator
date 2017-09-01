<?php

/*
 * Generates a 300x232 pixel google map, centered over london,
 * with feature styling and a medium marker placed off centre.
 */

include('../googlestaticmap.php');
include('../googlestaticmapfeature.php');
include('../googlestaticmapfeaturestyling.php');
include('../googlestaticmapmarker.php');
include('../googlestaticmappath.php');
include('../googlestaticmappathpoint.php');

$oStaticMap = new GoogleStaticMap();
$oStaticMap->setCenter('London,UK')
        ->setHeight(300)
        ->setWidth(232)
        ->setZoom(8)
        ->setMapType('hybrid')
        ->setFormat('png');

$oStaticMap->setMarker([
    'color' => 'blue',
    'size' => 'mid',
    'longitude' => -0.062004,
    'latitude' => 51.462564,
    'label' => 'b'
]);

echo '<img src="' . $oStaticMap . '" height="' . $oStaticMap->getHeight() . '" width="' . $oStaticMap->getWidth() . '" />';
