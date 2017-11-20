<?php

class PointTest extends PHPUnit_Framework_TestCase
{
    public function testSetLongitude()
    {
        $object = new \GoogleStaticMap\Path\Point();
        $this->assertEquals($object, $object->setLongitude(1.0));
        $this->assertEquals(1.0, $object->getLongitude());
    }

    public function testSetLatitude()
    {
        $object = new \GoogleStaticMap\Path\Point();
        $this->assertEquals($object, $object->setLatitude(1.0));
        $this->assertEquals(1.0, $object->getLatitude());
    }

    public function testSetLocation()
    {
        $object = new \GoogleStaticMap\Path\Point();
        $this->assertEquals($object, $object->setLocation('London,UK'));
        $this->assertEquals('London,UK', $object->getLocation());
    }

    public function testBuild()
    {
        $object = new \GoogleStaticMap\Path\Point();
        $object->setLatitude(1.0);
        $object->setLongitude(2.0);
        $this->assertEquals('1,2', $object->build());

        $object = new \GoogleStaticMap\Path\Point();
        $object->setLocation('london,uk');
        $this->assertEquals('london%2Cuk', $object->build());
    }
}
