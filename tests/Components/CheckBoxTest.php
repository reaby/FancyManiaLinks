<?php

use FML\Components\CheckBox;
use FML\Components\CheckBoxDesign;
use FML\Controls\Entry;
use FML\Controls\Quad;
use FML\Script\Features\CheckBoxFeature;
use FML\Script\Features\ControlScript;

class CheckBoxTest extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $quad     = new Quad();
        $checkBox = new CheckBox("test-name", true, $quad);

        $this->assertNotNull($checkBox);
        $this->assertEquals($checkBox->getName(), "test-name");
        $this->assertTrue($checkBox->getDefault());
        $this->assertSame($checkBox->getQuad(), $quad);
    }

    public function testName()
    {
        $checkBox = new CheckBox();

        $this->assertNull($checkBox->getName());

        $this->assertSame($checkBox->setName("some-name"), $checkBox);

        $this->assertEquals($checkBox->getName(), "some-name");
    }

    public function testDefault()
    {
        $checkBox = new CheckBox();

        $this->assertNull($checkBox->getDefault());

        $this->assertSame($checkBox->setDefault(false), $checkBox);

        $this->assertFalse($checkBox->getDefault());
    }

    public function testEnabledDesign()
    {
        $checkBox      = new CheckBox();
        $enabledDesign = new CheckBoxDesign();

        $this->assertTrue($checkBox->getEnabledDesign() instanceof CheckBoxDesign);

        $this->assertSame($checkBox->setEnabledDesign($enabledDesign), $checkBox);

        $this->assertSame($checkBox->getEnabledDesign(), $enabledDesign);
    }

    public function testEnabledDesignWithStyles()
    {
        $checkBox = new CheckBox();

        $this->assertSame($checkBox->setEnabledDesign("design.style", "design.substyle"), $checkBox);

        $enabledDesign = $checkBox->getEnabledDesign();

        $this->assertTrue($enabledDesign instanceof CheckBoxDesign);
        $this->assertEquals($enabledDesign->getStyle(), "design.style");
        $this->assertEquals($enabledDesign->getSubStyle(), "design.substyle");
    }

    public function testDisabledDesign()
    {
        $checkBox       = new CheckBox();
        $disabledDesign = new CheckBoxDesign();

        $this->assertTrue($checkBox->getDisabledDesign() instanceof CheckBoxDesign);

        $this->assertSame($checkBox->setDisabledDesign($disabledDesign), $checkBox);

        $this->assertSame($checkBox->getDisabledDesign(), $disabledDesign);
    }

    public function testDisabledDesignWithStyles()
    {
        $checkBox = new CheckBox();

        $this->assertSame($checkBox->setDisabledDesign("design.style", "design.substyle"), $checkBox);

        $disabledDesign = $checkBox->getDisabledDesign();

        $this->assertTrue($disabledDesign instanceof CheckBoxDesign);
        $this->assertEquals($disabledDesign->getStyle(), "design.style");
        $this->assertEquals($disabledDesign->getSubStyle(), "design.substyle");
    }

    public function testQuad()
    {
        $checkBox = new CheckBox();
        $quad     = new Quad();

        $this->assertTrue($checkBox->getQuad() instanceof Quad);

        $this->assertSame($checkBox->setQuad($quad), $checkBox);

        $this->assertSame($checkBox->getQuad(), $quad);
    }

    public function testEntry()
    {
        $checkBox = new CheckBox();
        $entry    = new Entry();

        $this->assertTrue($checkBox->getEntry() instanceof Entry);

        $this->assertSame($checkBox->setEntry($entry), $checkBox);

        $this->assertSame($checkBox->getEntry(), $entry);
    }

    public function testScriptFeatures()
    {
        $checkBox           = new CheckBox();
        $quad               = $checkBox->getQuad();
        $entry              = $checkBox->getEntry();
        $quadScriptFeature  = new ControlScript($quad);
        $entryScriptFeature = new ControlScript($entry);

        $scriptFeatures = $checkBox->getScriptFeatures();

        $this->assertCount(3, $scriptFeatures);
        $this->assertTrue($scriptFeatures[0] instanceof CheckBoxFeature);
        $this->assertSame($quadScriptFeature, $scriptFeatures[1]);
        $this->assertSame($entryScriptFeature, $scriptFeatures[2]);
    }

    public function testRender()
    {
        $domDocument = new \DOMDocument();
        $checkBox    = new CheckBox();

        $expectedDomElement = $domDocument->createElement("frame");
        $expectedDomElement->appendChild($domDocument->createElement("quad"));
        $expectedDomElement->appendChild($domDocument->createElement("entry"));

        $domElement = $checkBox->render($domDocument);

        $this->assertEqualXMLStructure($expectedDomElement, $domElement);
    }

}
