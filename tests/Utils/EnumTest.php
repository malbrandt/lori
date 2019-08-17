<?php

namespace Malbrandt\Lori\Tests\Utils;

use Malbrandt\Lori\Tests\TestCase;

class EnumTest extends TestCase
{
    /** @test */
    public function checks_if_enum_key_is_correct()
    {
        $this->assertTrue(TestEnum::isValidKey('FOO'));
        $this->assertTrue(TestEnum::isValidKey('BAR'));
        $this->assertFalse(TestEnum::isValidKey('test'));
        $this->assertFalse(TestEnum::isValidKey('bar'));
    }

    /** @test */
    public function checks_if_enum_value_is_correct()
    {
        $this->assertTrue(TestEnum::isValidValue(TestEnum::FOO));
        $this->assertTrue(TestEnum::isValidValue(TestEnum::BAR));
        $this->assertFalse(TestEnum::isValidValue('foo'));
        $this->assertFalse(TestEnum::isValidValue('test'));
    }

    /** @test */
    public function returns_constants_values()
    {
        $this->assertEquals(['one', 'two'], TestEnum::getConstantValues());
    }

    /** @test */
    public function returns_constants_keys()
    {
        $this->assertEquals(['FOO', 'BAR'], TestEnum::getConstantKeys());
    }

    /** @test */
    public function returns_constans()
    {
        $this->assertEquals([
            'FOO' => 'one',
            'BAR' => 'two',
        ], TestEnum::getConstants());
    }

    /** @test */
    public function creates_validation_rule_from_enum_values()
    {
        $this->assertEquals('in:one,two', TestEnum::validationRule());
    }

    /** @test */
    public function picks_random_enum_values()
    {
        $this->assertTrue(TestEnum::isValidValue(TestEnum::getRandomValue()));
        $this->assertTrue(TestEnum::isValidValue(TestEnum::getRandomValue()));
        $this->assertTrue(TestEnum::isValidValue(TestEnum::getRandomValue()));
        $this->assertTrue(TestEnum::isValidValue(TestEnum::getRandomValue()));
        $this->assertTrue(TestEnum::isValidValue(TestEnum::getRandomValue(2)));
        $this->assertTrue(TestEnum::isValidValue(TestEnum::getRandomValue(3)));
        $this->assertTrue(TestEnum::isValidValue(TestEnum::getRandomValue(4)));
    }

    /** @test */
    public function picks_random_enum_keys()
    {
        $this->assertTrue(TestEnum::isValidValue(TestEnum::getRandomKey()));
        $this->assertTrue(TestEnum::isValidValue(TestEnum::getRandomKey()));
        $this->assertTrue(TestEnum::isValidValue(TestEnum::getRandomKey()));
        $this->assertTrue(TestEnum::isValidValue(TestEnum::getRandomKey()));
        $this->assertTrue(TestEnum::isValidValue(TestEnum::getRandomKey(2)));
        $this->assertTrue(TestEnum::isValidValue(TestEnum::getRandomKey(3)));
        $this->assertTrue(TestEnum::isValidValue(TestEnum::getRandomKey(4)));
    }
}
