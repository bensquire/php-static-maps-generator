<?php

/*
 * Generates a 600x600 pixel google map, centered over london
 * connection, 2 custom markers.
 */

 
include('../googlestaticmap.php');
include('../googlestaticmapfeature.php');
include('../googlestaticmapfeaturestyling.php');
include('../googlestaticmapmarker.php');
include('../googlestaticmappath.php');
include('../googlestaticmappathpoint.php');

$oStaticMap = new GoogleStaticMap();
$oStaticMap->setCenter('London,UK')
		->setAPIKey("YOUR GOOGLE STATIC MAPS API KEY GOES HERE")
		->setHeight(600)
		->setWidth(600)
		->setZoom(8)
		->setFormat('png');

$oStaticMap->setMarker(array(
	'icon' => 'https://uploads.knightlab.com/storymapjs/597abbd641064ae8a1c087aeecb50e92/attentats/_images/Map-Marker-PNG-HD.png',
	'longitude' => -0.062004,
	'latitude' => 51.462564,
));

$oMarker = new GoogleStaticMapMarker();
$oMarker->setIconUrl("https://uploads.knightlab.com/storymapjs/597abbd641064ae8a1c087aeecb50e92/attentats/_images/Map-Marker-PNG-HD.png")
		->setLongitude(-0.576904)
		->setLatitude(51.855376);

$oStaticMap->setMarker($oMarker);

echo '<img src="' . $oStaticMap->buildSource() . '" height="' . $oStaticMap->getHeight() . '" width="' . $oStaticMap->getWidth() . '" />';