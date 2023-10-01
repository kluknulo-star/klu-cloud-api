<?php

namespace App\Common\Traits;

trait EnumWithValues
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
