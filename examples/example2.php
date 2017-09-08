<?php

include('../vendor/autoload.php');

$featureStyling = new \GoogleStaticMap\Feature([
    'feature' => 'all',
    'element' => 'all',
    'style' => new \GoogleStaticMap\Feature\Styling([
        'hue' => '#006400', //Green features
        'lightness' => 50  //Very light...
    ])
]);

$oStaticMap = new \GoogleStaticMap\Map();
$oStaticMap->setCenter('London,UK')
        ->setHeight(300)
        ->setWidth(232)
        ->setZoom(8)
        ->setFormat('jpg')
        ->addFeature($featureStyling);

echo '<img src="' . $oStaticMap . '" height="' . $oStaticMap->getHeight() . '" width="' . $oStaticMap->getWidth() . '" />';
