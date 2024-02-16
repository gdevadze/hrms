<?php

namespace App\Enums;

class VacationType extends BaseEnum
{
    const PAID_LEAVE = 1;
//    const TUESDAY = 2;
//    const WEDNESDAY = 3;

    public static function all(): array {
        return [
            ['key' => self::PAID_LEAVE, 'title' => __('paid_leave')],
//            ['key' => self::TUESDAY, 'title' => __(strtolower(self::TUESDAY))],
//            ['key' => self::SUNDAY, 'title' => __(strtolower(self::SUNDAY))],
        ];
    }
}
