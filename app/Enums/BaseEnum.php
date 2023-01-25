<?php

namespace App\Enums;

abstract class BaseEnum
{
    public static function all(): array
    {
        return [];
    }

    public static function getData($key = null, $field = 'title', $showAllIfKeyNull = false)
    {
        if ($key) {

            $rows = static::all();
            foreach ($rows as $row ) {
                if ($row['key'] === $key) {
                    if (key_exists($field, $row)) {
                        return $row[$field];
                    }
                    //return $row;
                }
            }
            return $key;
        }
        if ($showAllIfKeyNull) {
            return static::all();
        }
        return '';
    }
}
