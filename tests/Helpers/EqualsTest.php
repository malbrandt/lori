<?php

namespace Malbrandt\Lori\Tests\Helpers;


use Malbrandt\Lori\Tests\TestCase;

class EqualsTest extends TestCase
{
    /** @test */
    public function compares_properly()
    {
        $this->assertTrue(equals(0.1 + 0.1 + 0.1 + 0.1 + 0.1 + 0.1 + 0.1 + 0.1 + 0.1 + 0.1,
            1.0));
        $this->assertTrue(equals(1.0, 1.0));
        $this->assertFalse(equals(2.0, 1.0));
    }
}
