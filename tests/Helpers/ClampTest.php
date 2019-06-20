<?php

namespace Malbrandt\Lori\Tests\Helpers;


use Malbrandt\Lori\Tests\TestCase;

class ClampTest extends TestCase
{
    /** @test */
    public function returns_min_when_value_lesser()
    {
        $this->assertEquals(0, clamp(-1, 0));
    }

    /** @test */
    public function returns_max_when_value_greater()
    {
        $this->assertEquals(10, clamp(15, 0, 10));
        $this->assertEquals(0, clamp(10, -10, 0));
        $this->assertEquals(-10, clamp(-10, -30, -10));
    }

    /** @test */
    public function returns_value_when_matches_range()
    {
        $this->assertEquals(0, clamp(0, -1, 1));
        $this->assertEquals(0, clamp(0, -1, 1));
    }
}
