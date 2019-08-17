<?php

namespace Malbrandt\Lori\Tests\Utils;

use Malbrandt\Lori\Tests\TestCase;

class TranslatableEnumTest extends TestCase
{
    /** @test */
    public function creates_select_options_from_enum_constants()
    {
        $this->assertEquals([
            'one' => 'one',
            'two' => 'two',
        ], TestTranslatableEnum::toSelectOptions(false));
    }

    /** @test */
    public function creates_translated_select_options_from_enum_constants()
    {
        $this->assertEquals([
            'one' => 'translated.one',
            'two' => 'translated.two',
        ], TestTranslatableEnum::toSelectOptions(true));
    }
}
