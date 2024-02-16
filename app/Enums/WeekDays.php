<?php

namespace App\Enums;

class WeekDays extends BaseEnum
{
    const MONDAY = "MONDAY";
    const TUESDAY = "TUESDAY";
    const WEDNESDAY = "WEDNESDAY";
    const THURSDAY = "THURSDAY";
    const FRIDAY = "FRIDAY";
    const SATURDAY = "SATURDAY";
    const SUNDAY = "SUNDAY";

    public static function all(): array {
        return [
            ['key' => self::MONDAY, 'title' => __(strtolower(self::MONDAY))],
            ['key' => self::TUESDAY, 'title' => __(strtolower(self::TUESDAY))],
            ['key' => self::WEDNESDAY, 'title' => __(strtolower(self::WEDNESDAY))],
            ['key' => self::THURSDAY, 'title' => __(strtolower(self::THURSDAY))],
            ['key' => self::FRIDAY, 'title' => __(strtolower(self::FRIDAY))],
            ['key' => self::SATURDAY, 'title' => __(strtolower(self::SATURDAY))],
            ['key' => self::SUNDAY, 'title' => __(strtolower(self::SUNDAY))],
        ];
    }
}
