<?php

/*
 * Generates a 300x232 pixel google map, centered over london, using an HTTPS
 * connection
 */

include('../googlestaticmap.php');
include('../googlestaticmapfeature.php');
include('../googlestaticmapfeaturestyling.php');
include('../googlestaticmapmarker.php');
include('../googlestaticmappath.php');
include('../googlestaticmappathpoint.php');

$oStaticMap = new GoogleStaticMap();
$oStaticMap->setCenter("London,UK")
		->setHeight(300)
		->setWidth(232)
		->setZoom(8)
		->setHttps(true);

echo '<img src="' . $oStaticMap . '" height="' . $oStaticMap->getHeight() . '" width="' . $oStaticMap->getWidth() . '" />';
?>