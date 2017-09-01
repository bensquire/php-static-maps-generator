<?php

include('../vendor/autoload.php');

$oStaticMap = new \GoogleStaticMap\GoogleStaticMap();
$oStaticMap->setCenter('London,UK')
        ->setHeight(300)
        ->setWidth(232)
        ->setZoom(8)
        ->setHttps(true);

echo '<img src="' . $oStaticMap . '" height="' . $oStaticMap->getHeight() . '" width="' . $oStaticMap->getWidth() . '" />';
