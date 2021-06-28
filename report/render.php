<?php
require('graphic.php');

$pizza = GraphicFactory::getGoogleChart();
$pizza->setResolution('900x100');
$pizza->setType(GraphicGoogleCharts::TYPE_PIZZA);
$pizza->setData("t:50,70,15,10");
$pizza->setLegend('Embalagem|Checkout|Separação|PBL');

echo $pizza->getImgTag();

$pizza = GraphicFactory::getFacebookChart();

echo $pizza->getImgTag();

?>