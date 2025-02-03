<?php

namespace Alberto\RubricaProject;
class Helper
{

    public static function  AccesToValue(array $values, string $key, string $defaultValue)
    {

        if (is_null($values)) {
            return $defaultValue;
        }


        return array_key_exists($key, $values) ? $values[$key] : $defaultValue;
    }
}
