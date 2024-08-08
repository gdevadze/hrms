<?php

namespace App\Enums;

class ContactType extends BaseEnum
{
    const EXAM = 1;
    const YEAR = 2;
    const UNLIMITED = 3;
    const TEMPORARY = 4;

    public static function all(): array {
        return [
            ['key' => self::EXAM, 'title' => 'საგამოცდო'],
            ['key' => self::YEAR, 'title' => '1 წლიანი'],
            ['key' => self::UNLIMITED, 'title' => 'უვადო'],
            ['key' => self::TEMPORARY, 'title' => 'დროებითი'],
        ];
    }
}
