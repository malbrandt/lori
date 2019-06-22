<?php

namespace Malbrandt\Lori\Tests\Helpers;


use InvalidArgumentException;
use Malbrandt\Lori\Tests\TestCase;

class StrCropTest extends TestCase
{
    /** @test */
    public function cuts_off_end_of_too_long_strings()
    {
        $this->assertEquals('FooBar', str_crop('FooBarBizz', 6));
        $this->assertEquals('FooBar', str_crop('FooBarBizzBuzz', 6));
        $this->assertEquals('FooBarBizz', str_crop('FooBarBizzFooBarBizz', 10));
    }

    /** @test */
    public function returns_empty_string_when_empty_string_passed()
    {
        $this->assertEquals('', str_crop('', 1));
        $this->assertEquals('', str_crop('', 10));
    }

    /** @test */
    public function returns_empty_string_when_null_passed()
    {
        $this->assertEquals('', str_crop(null, 1));
        $this->assertEquals('', str_crop(null, 10));
    }

    /** @test */
    public function throws_an_exception_when_negative_length_of_crop_passed()
    {
        $this->expectException(InvalidArgumentException::class);
        str_crop('', -1);
    }
}
