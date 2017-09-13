<?php

class PathTest extends PHPUnit_Framework_TestCase
{
    public function testSetGetWeight()
    {
        $object = new \GoogleStaticMap\Path();
        $this->assertEquals($object, $object->setWeight(1));
        $this->assertEquals(1, $object->getWeight());
    }

    public function testSetGetColor()
    {
        $object = new \GoogleStaticMap\Path();
        $this->assertEquals($object, $object->setColor('green'));
        $this->assertEquals('green', $object->getColor());
    }

    public function testSetGetFillColor()
    {
        $object = new \GoogleStaticMap\Path();
        $this->assertEquals($object, $object->setFillColor('0x00000000'));
        $this->assertEquals('0x00000000', $object->getFillColor());
    }

    public function testAddPoint()
    {
        $point = new \GoogleStaticMap\Path\Point();
        $object = new \GoogleStaticMap\Path();
        $this->assertEquals($object, $object->addPoint($point));
    }

    public function testBuild()
    {
        $point = new \GoogleStaticMap\Path\Point();
        $point->setLongitude(1.0);
        $point->setLatitude(2.0);
        $point->setLocation('london,uk');

        $object = new \GoogleStaticMap\Path();
        $object->setFillColor('0x00000000');
        $object->setColor('red');
        $object->setWeight(1);
        $object->addPoint($point);

        $this->assertEquals('path=weight:1|color:red|fillcolor:0x00000000|2,1', $object->build());
    }
}