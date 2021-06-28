<?php

//namespace RefactoringGuru\FactoryMethod\Conceptual;

class GraphicFactory
{
    public static function getFacebookChart()
    {
        return new FacebookGoogleCharts();
    }
    public function getGoogleChart()
    {
        return new GraphicGoogleCharts();
    }
}

class FacebookGoogleCharts 
{
    public function getImgTag()
    {
        return '<img src="https://chart.googleapis.com/chart?chs=250x100&cht=p3&chd=t:60,40&chl=Hello|World"/>';
    }
}

class GraphicGoogleCharts
{
    const TYPE_PIZZA = 'p';
    const TYPE_PIZZA3D = 'p3';
    const TYPE_COLUMN = 'bvg';
    const TYPE_LINE = 'lc';

    public function setResolution($resolution)
    {
        $this->resolution = $resolution;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function setData($data)
    {
        $this->data = $data;
    }
    public function setLegend($legend)
    {
        $this->legend = $legend;
    }
    public function getImgTag()
    {
        return '<img src="http://chart.apis.google.com/chart?chs=' . $this->resolution .  '&cht=' . $this->type .  '&chd=' . $this->data . '&chl=' . $this->legend . '" />';
    }
}

