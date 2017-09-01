<?php

include('../vendor/autoload.php');

$oStaticMap = new \GoogleStaticMap\Map();
$oStaticMap->setCenter('London,UK')
        ->setHeight(300)
        ->setWidth(232)
        ->setZoom(8)
        ->setFormat('jpg')
        ->addFeatureStyling([
            'feature' => 'all',
            'element' => 'all',
            'style' => [
                'hue' => '#006400', //Green features
                'lightness' => 50  //Very light...
            ]
        ]);

echo '<img src="' . $oStaticMap . '" height="' . $oStaticMap->getHeight() . '" width="' . $oStaticMap->getWidth() . '" />';
