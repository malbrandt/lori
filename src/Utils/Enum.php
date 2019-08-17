<?php

namespace Malbrandt\Lori\Utils;

use Illuminate\Support\Arr;

/**
 * Trait that can be used to simulate enumerations in PHP.
 * Allows for key and values validation.
 * Helps with retrieving of constant keys/values.
 * Can render Laravel's validation rule.
 * Can pick random key or value.
 *
 * @since 0.25.0
 */
trait Enum
{
    public static function isValidValue($value, bool $strict = true): bool
    {
        $valid = true;
        $values = Arr::wrap($value);

        foreach ($values as $value) {
            if (! in_array($value, static::getConstantValues(), $strict)) {
                $valid = false;
                break;
            }
        }

        return $valid;
    }

    public static function getConstantValues(): array
    {
        return once(static function () {
            return array_values(static::getConstants());
        });
    }

    public static function getConstants(): array
    {
        return once(static function () {
            return (new \ReflectionClass(static::class))->getConstants();
        });
    }

    public static function isValidKey($value, bool $strict = true): bool
    {
        $valid = true;
        $values = Arr::wrap($value);

        foreach ($values as $value) {
            if (! in_array($value, static::getConstantKeys(), $strict)) {
                $valid = false;
                break;
            }
        }

        return $valid;
    }

    public static function getConstantKeys(): array
    {
        return once(static function () {
            return array_keys(static::getConstants());
        });
    }

    public static function validationRule(): string
    {
        return 'in:'.implode(',', static::getConstantValues());
    }

    public static function getRandomKey(int $number = 1)
    {
        return self::pickRandom($number, static::getConstantKeys());
    }

    private static function pickRandom(int $number, array $values): array
    {
        $random = [];

        $numDraw = clamp($number, 0, count($values));
        $indexes = array_rand($values, $numDraw);
        for ($i = 0; $i < $numDraw; $i++) {
            $drawn = $indexes[$i];
            if (in_array($drawn, $random, true)) {
                $random[] = $drawn;
            }
        }

        return count($random) === 1 ? $random[0] : $random;
    }

    public static function getRandomValue(int $number = 1)
    {
        return self::pickRandom($number, static::getConstantValues());
    }
}
