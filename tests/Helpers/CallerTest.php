<?php

namespace Malbrandt\Lori\Tests\Helpers;

use InvalidArgumentException;
use Malbrandt\Lori\Tests\TestCase;

class CallerTest extends TestCase
{
    /** @test */
    public function returns_null_when_backwards_exceeds_call_stack_size()
    {
        $this->assertNull(caller(999));
    }

    /** @test */
    public function throws_an_exception_when_backwards_is_less_then_0()
    {
        $this->expectException(InvalidArgumentException::class);
        caller(-1);
    }

    /** @test */
    public function returns_full_caller_info_when_no_parts_specified()
    {
        $caller = caller();
        $this->assertIsArray($caller);
        $this->assertStringContainsString($caller['function'], __METHOD__);
        $this->assertEquals(__CLASS__, $caller['class']);
        $this->assertEquals('->', $caller['type']);
        $this->assertEquals($this, $caller['object']);
        $this->assertEmpty($caller['args']);
    }

    /** @test */
    public function returns_caller_part_when_specified()
    {
        $callerFunction = caller(1, 'function');
        $this->assertEquals('returns_caller_part_when_specified',
            $callerFunction);
    }

    /** @test */
    public function returns_caller_parts_when_few_specified()
    {
        $parts = caller(1, ['function', 'class', 'type', 'object']);
        $this->assertEquals('returns_caller_parts_when_few_specified',
            $parts['function']);
        $this->assertEquals(__CLASS__, $parts['class']);
        $this->assertEquals('->', $parts['type']);
        $this->assertEquals($this, $parts['object']);
    }

    /** @test */
    public function unknown_caller_part_should_throw_an_exception()
    {
        $this->expectException(InvalidArgumentException::class);
        caller(1, 'foobar');
    }
}
