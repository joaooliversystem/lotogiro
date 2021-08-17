<?php

namespace App\Helper;

class Money
{
    public static function toDatabase($value)
    {
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);

        return $value;
    }

    public static function toReal($value)
    {
        $value = number_format($value, 2, ',', '.');

        return $value;
    }
}
