<?php

namespace Malbrandt\Lori\Tests\Helpers;


use Malbrandt\Lori\Tests\TestCase;
use ReflectionClass;
use ReflectionMethod;

class CallMethodTest extends TestCase
{
    /** @test */
    public function can_call_private_instance_methods()
    {
        $obj = new class
        {
            private function privateMethod()
            {
                return 'private';
            }
        };
        $this->assertEquals('private', call_method('privateMethod', $obj));
    }

    /** @test */
    public function can_call_protected_instance_methods()
    {
        $obj = new class
        {
            protected function protectedMethod()
            {
                return 'protected';
            }
        };
        $this->assertEquals('protected', call_method('protectedMethod', $obj));
    }

    /** @test */
    public function can_call_public_instance_methods()
    {
        $obj = new class
        {
            public function publicMethod()
            {
                return 'public';
            }
        };
        $this->assertEquals('public', call_method('publicMethod', $obj));
    }

    /** @test */
    public function can_pass_array_as_an_argument()
    {
        $obj = new class
        {
            private function returnArg($arg)
            {
                return $arg;
            }
        };
        $this->assertEquals([], call_method('returnArg', $obj, []));
        $this->assertEquals([1, 2, 3], call_method('returnArg', $obj, [1, 2, 3]));
        $this->assertEquals([[], []], call_method('returnArg', $obj, [[], []]));
    }

    /** @test */
    public function can_pass_callable_that_resolves_args()
    {
        $obj = new class
        {
            private function returnArg($arg)
            {
                return $arg;
            }
        };
        $this->assertEquals(1, call_method('returnArg', $obj, function () {
            return 1;
        }));
        $this->assertEquals([1, 2, 3], call_method('returnArg', $obj, function () {
            return [1, 2, 3];
        }));
    }

    /** @test */
    public function can_pass_single_scalar_as_an_argument()
    {
        $obj = new class
        {
            private function returnArg($arg)
            {
                return $arg;
            }
        };
        $this->assertEquals(1, call_method('returnArg', $obj, 1));
    }

    /** @test */
    public function can_pass_several_scalars_as_an_arguments()
    {
        $obj = new class
        {
            private function sum($a, $b)
            {
                return $a + $b;
            }
        };
        $this->assertEquals(3, call_method('sum', $obj, 1, 2));
        $this->assertEquals(-3, call_method('sum', $obj, -1, -2));
    }

    /** @test */
    public function restores_private_modifier_after_call()
    {
        $obj = new class
        {
            private function sum($a, $b)
            {
                return $a + $b;
            }
        };
        $previous = (new ReflectionClass($obj))->getMethod('sum')
                                                ->getModifiers();
        $this->assertTrue(($previous & ReflectionMethod::IS_PRIVATE) !== 0);

        $this->assertEquals(3, call_method('sum', $obj, 1, 2));

        $current = (new ReflectionClass($obj))->getMethod('sum')
                                               ->getModifiers();
        $this->assertTrue(($current & ReflectionMethod::IS_PRIVATE) !== 0);
    }

    /** @test */
    public function can_call_private_static_method()
    {
        $class = new class
        {
            public static function staticMethod()
            {
                return 'static';
            }
        };
        $this->assertEquals('static', call_method('staticMethod', $class));
    }
}
