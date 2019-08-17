<?php

namespace Malbrandt\Lori\Utils;

trait TranslatableEnum
{
    use Enum;

    public static function toSelectOptions(bool $translateValues = false): array
    {
        $options = [];
        $values = static::getConstantValues();

        if ($translateValues) {
            foreach ($values as $value) {
                $options[$value] = static::transEnumValue($value);
            }
        } else {
            foreach ($values as $value) {
                $options[$value] = $value;
            }
        }

        return $options;
    }

    public static function transEnumValue($value): string
    {
        return trans('enums.'.class_basename(static::class).'.'.$value);
    }
}
