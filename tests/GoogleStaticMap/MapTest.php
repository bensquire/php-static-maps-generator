<?php

class MapTest extends PHPUnit_Framework_TestCase
{
    public function testAddMarker()
    {
        $marker = new \GoogleStaticMap\Marker();
        $object = new \GoogleStaticMap\Map();
        $this->assertInstanceOf('GoogleStaticMap\Map', $object->addMarker($marker));
        $this->assertEquals([$marker], $object->getMarkers());
    }

    public function testSetHttps()
    {
        $object = new \GoogleStaticMap\Map();
        $this->assertInstanceOf('GoogleStaticMap\Map', $object->setHttps(true));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid API key
     */
    public function testSetAPIKey()
    {
        $object = new \GoogleStaticMap\Map();
        $this->assertInstanceOf('GoogleStaticMap\Map', $object->setAPIKey('1234'));

        $object->setAPIKey('---++++####');
    }

    public function testSetCenter()
    {
        $object = new \GoogleStaticMap\Map();
        $this->assertInstanceOf('GoogleStaticMap\Map', $object->setCenter('my centre'));
        $this->assertEquals('my centre', $object->getCenter());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid map scale value: 8
     */
    public function testSetScale()
    {
        $object = new \GoogleStaticMap\Map();
        $this->assertInstanceOf('GoogleStaticMap\Map', $object->setScale(2));
        $this->assertEquals(2, $object->getScale());

        $object->setScale(8);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Invalid Zoom amount requested, 0 to 22, acceptable.
     */
    public function testSetZoom()
    {
        $object = new \GoogleStaticMap\Map();
        $this->assertInstanceOf('GoogleStaticMap\Map', $object->setZoom(3));
        $this->assertEquals(3, $object->getZoom(3));

        $object->setZoom(23);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Unknown map type requested.
     */
    public function testSetMapType()
    {
        $object = new \GoogleStaticMap\Map();
        $this->assertInstanceOf('GoogleStaticMap\Map', $object->setMapType('satellite'));
        $this->assertEquals('satellite', $object->getMapType());

        $object->setMapType('foo');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Unknown image format requested.
     */
    public function testSetFormat()
    {
        $object = new \GoogleStaticMap\Map();
        $this->assertInstanceOf('GoogleStaticMap\Map', $object->setFormat('png'));
        $this->assertEquals('png', $object->getFormat());

        $object->setFormat('satellite');
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Height cannot be above 640.
     */
    public function testSetHeight()
    {
        $object = new \GoogleStaticMap\Map();
        $this->assertInstanceOf('GoogleStaticMap\Map', $object->setHeight(2));
        $this->assertEquals(2, $object->getHeight());

        $object->setHeight(641);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Width cannot be above 640.
     */
    public function testSetWidth()
    {
        $object = new \GoogleStaticMap\Map();
        $this->assertInstanceOf('GoogleStaticMap\Map', $object->setWidth(2));
        $this->assertEquals(2, $object->getWidth());

        $object->setWidth(641);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Unknown language requested.
     */
    public function testSetLanguage()
    {
        $object = new \GoogleStaticMap\Map();
        $this->assertInstanceOf('GoogleStaticMap\Map', $object->setLanguage('bg'));
        $this->assertEquals('bg', $object->getLanguage());

        $object->setLanguage('bg2');
    }

    public function testAddFeatureStyling()
    {
        $feature = new \GoogleStaticMap\Feature();

        $object = new \GoogleStaticMap\Map();
        $this->assertInstanceOf('GoogleStaticMap\Map', $object->addFeature($feature));
        $this->assertEquals([$feature], $object->getFeature());
    }

    public function testSetMapPath()
    {
        $path = new \GoogleStaticMap\Path();

        $object = new \GoogleStaticMap\Map();
        $this->assertInstanceOf('GoogleStaticMap\Map', $object->setMapPath($path));
        $this->assertEquals($path, $object->getMapPath($path));
    }

    public function testBuildSourceMatchesToString()
    {
        $path = new \GoogleStaticMap\Path([
            'weight' => 2
        ]);

        $object = new \GoogleStaticMap\Map();
        $object->setScale(1)
            ->setAPIKey('foooo')
            ->setMapPath($path)
            ->addMarker(new \GoogleStaticMap\Marker(['color' => 'red']))
            ->addFeature(new \GoogleStaticMap\Feature([
                'feature' => 'all'
            ]))
            ->setLanguage('en')
            ->setMapType('roadmap')
            ->setZoom(2)
            ->setCenter('London,UK')
            ->setHttps(true)
            ->setFormat('png')
            ->setHeight(480)
            ->setWidth(480);

        $result = $object->buildSource();
        $this->assertEquals($result, $object->__toString());
    }
}
