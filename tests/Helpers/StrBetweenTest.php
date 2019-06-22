<?php

namespace Malbrandt\Lori\Tests\Helpers;


use Malbrandt\Lori\Tests\TestCase;

class StrBetweenTest extends TestCase
{
    const SENTENCE = 'The quick brown fox jumps over the lazy dog.';

    /** @test */
    public function returns_string_when_no_bounds_specified()
    {
        $this->assertEquals(self::SENTENCE, str_between(self::SENTENCE));
        $this->assertEquals('Foo', str_between('Foo'));
        $this->assertEquals('bar', str_between('bar'));
        $this->assertEquals(null, str_between(null));
    }

    /** @test */
    public function cuts_from_beginning_when_cannot_find_left_bound()
    {
        $this->assertEquals(
            self::SENTENCE,
            str_between(self::SENTENCE, 'qq')
        );
    }

    /** @test */
    public function cuts_to_end_when_cannot_find_right_bound()
    {
        $this->assertEquals(
            ' jumps over the lazy dog.',
            str_between(self::SENTENCE, 'fox')
        );
    }

    /** @test */
    public function cuts_from_left_bound_if_found()
    {
        $this->assertEquals(
            ' jumps over the lazy dog.',
            str_between(self::SENTENCE, 'fox')
        );
    }

    /** @test */
    public function cuts_from_right_bounds_if_found()
    {
        $this->assertEquals(
            'The quick brown fox ',
            str_between(self::SENTENCE, null, 'jumps')
        );
    }

    /** @test */
    public function returns_an_empty_string_if_left_bound_is_equal_to_right_bound(
    )
    {
        $this->assertEquals(
            '',
            str_between(self::SENTENCE, 'brown', 'brown')
        );
    }

    /** @test */
    public function returns_string_arg_when_empty_value_was_passed()
    {
        $this->assertEquals(null, str_between(null, 'ż', 'q'));
        $this->assertEquals('', str_between('', 'ż', 'q'));
    }
}
