<?php

namespace Malbrandt\Lori\Tests\Helpers;

use ReflectionClass;
use Malbrandt\Lori\Tests\TestCase;

class AccessPropTest extends TestCase
{
    /** @test */
    public function reads_accessible_and_not_accessible_properties()
    {
        $obj = new class {
            private $foo = 'foo';
            protected $bar = 'bar';
            public $biz = 'biz';
        };
        $this->assertEquals('foo', access_prop($obj, 'foo'));
        $this->assertEquals('bar', access_prop($obj, 'bar'));
        $this->assertEquals('biz', access_prop($obj, 'biz'));
    }

    /** @test */
    public function modifies_accessible_and_not_accessible_properties()
    {
        $obj = new class {
            private $foo = 'foo';
            protected $bar = 'bar';
            public $biz = 'biz';
        };
        access_prop($obj, 'foo', 'biz');
        access_prop($obj, 'bar', 'biz');
        access_prop($obj, 'biz', 'foo');
        $this->assertEquals('biz', access_prop($obj, 'foo'));
        $this->assertEquals('biz', access_prop($obj, 'bar'));
        $this->assertEquals('foo', access_prop($obj, 'biz'));
    }

    /** @test */
    public function can_set_null_value()
    {
        $obj = new class {
            private $foo = 'foo';
            protected $bar = 'bar';
            public $biz = 'biz';
        };
        access_prop($obj, 'foo', null, true);
        access_prop($obj, 'bar', null, true);
        access_prop($obj, 'biz', null, true);
        $this->assertEquals(null, access_prop($obj, 'foo'));
        $this->assertEquals(null, access_prop($obj, 'bar'));
        $this->assertEquals(null, access_prop($obj, 'biz'));
    }

    /** @test */
    public function retores_previous_access_modifier_after_reading_property_value(
    ) {
        $obj = new class {
            private $foo = 'bar';
        };

        $modifiersBeforeRead = (new ReflectionClass($obj))->getProperty('foo')
                                                           ->getModifiers();

        $this->assertEquals('bar', access_prop($obj, 'foo'));
        $this->assertEquals(
            $modifiersBeforeRead,
            (new ReflectionClass($obj))->getProperty('foo')->getModifiers()
        );
    }

    /** @test */
    public function retores_previous_access_modifier_after_modifying_property_value(
    ) {
        $obj = new class {
            private $foo = 'bar';
        };

        $modifiersBeforeModify = (new ReflectionClass($obj))->getProperty('foo')
                                                             ->getModifiers();

        access_prop($obj, 'foo', 'biz');
        $this->assertEquals(
            $modifiersBeforeModify,
            (new ReflectionClass($obj))->getProperty('foo')->getModifiers()
        );
    }
}
