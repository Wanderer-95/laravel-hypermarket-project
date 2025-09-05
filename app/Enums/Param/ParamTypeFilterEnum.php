<?php

namespace App\Enums\Param;

enum ParamTypeFilterEnum: int
{
    case INTEGER = 1;
    case SELECT = 2;
    case CHECKBOX = 3;

    public static function names(): array
    {
        return array_map('strtolower', array_column(self::cases(), 'name'));
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function valuesAsString(): string
    {
        return implode(',', self::values());
    }

    public static function combine(): array
    {
        return array_combine(self::names(), self::values());
    }

    public static function collection(): array
    {
        $arr = [];

        foreach (self::combine() as $name => $value) {
            $arr[] = [
                'name' => $name,
                'value' => $value
            ];
        }

        return $arr;
    }
}
