<?php

namespace Malbrandt\Lori\Tests\Utils;

use Malbrandt\Lori\Utils\TranslatableEnum;

class TestTranslatableEnum
{
    use TranslatableEnum;

    const FOO = 'one';
    const BAR = 'two';

    public static function transEnumValue($value): string
    {
        return "translated.{$value}";
    }
}
