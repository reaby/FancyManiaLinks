<?php

use FML\Controls\Quads\Quad_Icons128x128_1;

class Quad_Icons128x128_1Test extends \PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $quad = new Quad_Icons128x128_1();

        $this->assertNotNull($quad);
        $this->assertEquals($quad::STYLE, $quad->getStyle());
    }

}
