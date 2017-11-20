<?php

class MarkerTest extends PHPUnit_Framework_TestCase
{
    public function testSetGetLongitude()
    {
        $object = new \GoogleStaticMap\Marker();
        $this->assertEquals($object, $object->setLongitude(1.0));
        $this->assertEquals(1.0, $object->getLongitude());
    }

    public function testSetGetLatitude()
    {
        $object = new \GoogleStaticMap\Marker();
        $this->assertEquals($object, $object->setLatitude(2.0));
        $this->assertEquals(2.0, $object->getLatitude());
    }

    public function testSetGetLabel()
    {
        $object = new \GoogleStaticMap\Marker();
        $this->assertEquals($object, $object->setLabel('fooo'));
        $this->assertEquals('fooo', $object->getLabel());
    }


    public function testSetGetColor()
    {
        $object = new \GoogleStaticMap\Marker();
        $this->assertEquals($object, $object->setColor('red'));
        $this->assertEquals('red', $object->getColor());
    }

    public function testSetSize()
    {
        $object = new \GoogleStaticMap\Marker();
        $this->assertEquals($object, $object->setSize('tiny'));
        $this->assertEquals('tiny', $object->getSize());
    }

    public function testSetIconUrl()
    {
        $object = new \GoogleStaticMap\Marker();
        $this->assertEquals($object, $object->setIconUrl('https://www.foo.com/'));
        $this->assertEquals('https://www.foo.com/', $object->getIconUrl());
    }

    public function testBuild()
    {
        $object = new \GoogleStaticMap\Marker();
        $object->setColor('red');
        $object->setSize('tiny');
        $object->setLabel('foo');
        $object->setLatitude(1.0);
        $object->setLongitude(2.0);
        $object->setIconUrl('https://www.foo.com/');

        $this->assertEquals('markers=icon:https%3A%2F%2Fwww.foo.com%2F%7Ccolor:red%7Clabel:foo%7Csize:tiny%7C1,2', $object->build());
    }
}
