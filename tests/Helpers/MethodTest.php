<?php

namespace Malbrandt\Lori\Tests\Helpers;


use Malbrandt\Lori\Tests\TestCase;

class MethodTest extends TestCase
{
    /** @test */
    public function returns_caller_in_action_format__instance_calls()
    {
        $this->assertEquals(
            'MethodTest@instanceMethod',
            $this->instanceMethod(METHOD_FORMAT_ACTION)
        );
    }

    /** @test */
    public function returns_caller_in_action_format__static_calls()
    {
        $this->assertEquals(
            'MethodTest@staticMethod',
            self::staticMethod(METHOD_FORMAT_ACTION)
        );
    }

    /** @test */
    public function returns_caller_in_action_fqcn_format__instance_calls()
    {
        $this->assertEquals(
            'Malbrandt\Lori\Tests\Helpers\MethodTest@instanceMethod',
            $this->instanceMethod(METHOD_FORMAT_ACTION_FQCN)
        );
    }

    /** @test */
    public function returns_caller_in_action_fqcn_format__static_calls()
    {
        $this->assertEquals(
            'Malbrandt\Lori\Tests\Helpers\MethodTest@staticMethod',
            self::staticMethod(METHOD_FORMAT_ACTION_FQCN)
        );
    }

    /** @test */
    public function returns_null_when_called_in_closure()
    {
        $closure = static function () {
            return method();
        };

        $result = $closure();
        $this->assertNull($result);
    }

    /** @test */
    public function returns_caller_in_callable_format__instance_calls()
    {
        $callable = $this->instanceMethod(METHOD_FORMAT_CALLABLE);
        $this->assertEquals([$this, 'instanceMethod'], $callable);
        $this->assertIsCallable($callable);
    }

    /** @test */
    public function returns_caller_in_callable_format__static_calls()
    {
        $callable = $this->staticMethod(METHOD_FORMAT_CALLABLE);
        $class = static::class;
        $this->assertEquals("{$class}::staticMethod", $callable);
        $this->assertIsCallable($callable);
    }

    public function instanceMethod($format)
    {
        return method(2, $format);
    }

    public static function staticMethod($format)
    {
        return method(2, $format);
    }
}
