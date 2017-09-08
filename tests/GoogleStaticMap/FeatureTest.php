<?php
use GoogleStaticMap\Feature;

class FeatureTest extends PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        new Feature([
            'feature' => 'administrative',
            'element'=> 'geometry'
        ]);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Unknown Map Feature
     */
    public function testSetFeature()
    {
        $object = new Feature();
        $this->assertInstanceOf('\GoogleStaticMap\Feature', $object->setFeature('administrative'));
        $object->setFeature('administrative2');
    }

    public function testSetStyle()
    {
        $featureStyling = new \GoogleStaticMap\Feature\Styling();

        $object = new Feature();
        $this->assertInstanceOf('\GoogleStaticMap\Feature', $object->setStyle($featureStyling));
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Unknown Map Element
     */
    public function testSetElement()
    {
        $object = new Feature();
        $this->assertInstanceOf('\GoogleStaticMap\Feature', $object->setElement('geometry'));
        $this->assertInstanceOf('\GoogleStaticMap\Feature', $object->setElement('geometry2'));
    }

    public function testGetFeature()
    {
        $object = new Feature();
        $object->setFeature('administrative');
        $this->assertEquals('administrative', $object->getFeature());
    }

    public function testGetStyle()
    {
        $object = new Feature();
        $this->assertNull($object->getStyle());
    }

    public function testGetElement()
    {
        $object = new Feature();
        $object->setElement('geometry');
        $this->assertEquals('geometry', $object->getElement());
    }

    public function testBuild()
    {
        $object = new \GoogleStaticMap\Feature();
        $this->assertEquals('style=feature:|element:', $object->build());
    }
}
