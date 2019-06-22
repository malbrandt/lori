<?php

namespace Malbrandt\Lori\Tests\Helpers;


use Malbrandt\Lori\Tests\TestCase;

class StrRemoveTest extends TestCase
{
    const SENTENCE = 'The quick brown fox jumps over the lazy dog.';

    /** @test */
    public function removes_found_occurrences()
    {
        $this->assertEquals(
            'The  brown fox jumps over the lazy dog.',
            str_remove(self::SENTENCE, 'quick')
        );
        $this->assertEquals(
            'The   fox jumps over the lazy dog.',
            str_remove(self::SENTENCE, 'quick', 'brown')
        );
        $this->assertEquals(
            ' quick brown fox jumps over the lazy dog.',
            str_remove(self::SENTENCE, 'The')
        );
        $this->assertEquals(
            'The quick brown fox jumps over  lazy dog.',
            str_remove(self::SENTENCE, 'the')
        );
        $this->assertEquals(
            ' quick brown fox jumps over  lazy dog.',
            str_remove(self::SENTENCE, 'The', 'the')
        );
    }

    /** @test */
    public function returns_original_string_if_no_args_passed()
    {
        $this->assertEquals(
            self::SENTENCE,
            str_remove(self::SENTENCE)
        );
    }

    /** @test */
    public function returns_original_string_when_not_found_any_needles()
    {
        $this->assertEquals(
            self::SENTENCE,
            str_remove(self::SENTENCE, 'foo', 'bar', 'biz')
        );
    }
}
