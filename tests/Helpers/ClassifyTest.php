<?php

namespace Malbrandt\Lori\Tests\Helpers;


use ArrayAccess;
use Malbrandt\Lori\Tests\TestCase;

trait ClassifyTestTrait
{
}

class ClassifyTest extends TestCase
{
    /** @test */
    public function returns_the_name_of_classes_interfaces_and_traits()
    {
        $class = self::class;
        $interface = ArrayAccess::class;
        $trait = ClassifyTestTrait::class;

        $this->assertEquals($class, classify($class));
        $this->assertEquals($interface, classify($interface));
        $this->assertEquals($trait, classify($trait));
    }

    /** @test */
    public function returns_the_class_name_of_object_instance()
    {
        $instance = $this;
        $this->assertEquals(self::class, classify($instance));
    }

    /** @test */
    public function returns_type_name_of_value_type_variables()
    {
        $typeToValue = [
            'string'  => 'foobar',
            'integer' => 123,
            'boolean' => true,
            'array'   => [],
        ];

        foreach ($typeToValue as $type => $value) {
            $this->assertEquals($type, classify($value));
        }

        // Floating point numbers
        $number = 1.23;
        $type = classify($number);
        $this->assertTrue(in_array($type, ['double', 'real', 'float'], true));
    }
}