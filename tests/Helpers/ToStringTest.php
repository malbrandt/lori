<?php

namespace Malbrandt\Lori\Tests\Helpers;

use stdClass;
use SimpleXMLElement;
use Malbrandt\Lori\Tests\TestCase;

class ToStringTest extends TestCase
{
    /** @test */
    public function convert_scalar_values()
    {
        $this->assertEquals('FooBarBiz', to_string('FooBarBiz'));
        $this->assertEquals('BizBarFoo', to_string('BizBarFoo'));
        $this->assertEquals(123, to_string('123'));
        $this->assertEquals(123.45, to_string('123.45'));
        $this->assertEquals(0, to_string('0'));
        $this->assertEquals(-1, to_string('-1'));
        $this->assertEquals(1, to_string('1'));
        $this->assertEquals('null', to_string('null'));
        $this->assertEquals('[1,2]', to_string([1, 2]));
        $this->assertEquals('[]', to_string([]));
        $this->assertEquals('true', to_string(true));
        $this->assertEquals('false', to_string(false));
    }

    /** @test */
    public function encodes_objects_as_json()
    {
        $obj = new stdClass();
        $obj->foo = 'bar';
        $obj->bizz = 'buzz';
        $json = json_encode($obj);
        $this->assertEquals($json, to_string($obj));
    }

    /** @test */
    public function encodes_simple_xml_element_as_xml()
    {
        $xml = new SimpleXMLElement('<root />');
        $xml->addChild('foo', 'bar');
        $this->assertEquals(
            "<?xml version=\"1.0\"?>\n<root><foo>bar</foo></root>\n",
            to_string($xml)
        );
    }
}
