<?php

/*
 * Generates a 300x232 pixel google map, centered over london, 
 * with light green features.
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
		->setFormat("jpg")
		->setFeatureStyling(array(
			"feature" => "all",
			"element" => "all",
			"style" => array(
				"hue" => "#006400", //Green features
				"lightness" => 50  //Very light...
			)
		));

echo '<img src="' . $oStaticMap . '" height="' . $oStaticMap->getHeight() . '" width="' . $oStaticMap->getWidth() . '" />';
?>