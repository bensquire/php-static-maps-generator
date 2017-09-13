<?php

class StylingTest extends PHPUnit_Framework_TestCase
{
    public function testSetGetGamma()
    {
        $object = new \GoogleStaticMap\Feature\Styling();
        $this->assertEquals($object, $object->setGamma(1.0));
        $this->assertEquals(1.0, $object->getGamma());
    }


    public function testSetGetLightness()
    {
        $object = new \GoogleStaticMap\Feature\Styling();
        $this->assertEquals($object, $object->setLightness(1));
        $this->assertEquals(1, $object->getLightness());
    }

    public function testSetSaturation()
    {
        $object = new \GoogleStaticMap\Feature\Styling();
        $this->assertEquals($object, $object->setSaturation(1));
        $this->assertEquals(1, $object->getSaturation());
    }

    public function testSetGetHue()
    {
        $object = new \GoogleStaticMap\Feature\Styling();
        $this->assertEquals($object, $object->setHue('255,255,0'));
        $this->assertEquals('255,255,0', $object->getHue());
    }


    public function testGetInvertLightness()
    {
        $object = new \GoogleStaticMap\Feature\Styling();
        $this->assertEquals($object, $object->setInvertLightness(false));
        $this->assertFalse($object->getInvertLightness());
    }


    public function testSetGetVisibility()
    {
        $object = new \GoogleStaticMap\Feature\Styling();
        $this->assertEquals($object, $object->setVisibility('simplified'));
        $this->assertEquals('simplified', $object->getVisible());
    }


    public function testBuild()
    {
        $object = new \GoogleStaticMap\Feature\Styling();
        $object->setGamma(1.0);
        $object->setHue('255,255,0');
        $object->setLightness(1);
        $object->setInvertLightness(true);
        $object->setSaturation(2);
        $object->setVisibility('on');

        $this->assertEquals(
            'gamma:1|lightness:1|saturation:2|hue:0x255,255,0|visibility:on|invert_lightness:true',
            $object->build()
        );
    }
}