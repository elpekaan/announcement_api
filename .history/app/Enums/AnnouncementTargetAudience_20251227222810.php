<?php

namespace App\Enums;

enum AnnouncementTargetAudience: string
{
    case EVERYONE = 'everyone';
    case STUDENTS = 'students';
    case TEACHERS = 'teachers';

    public function label(): string
    {
        return match ($this) {
            self::EVERYONE => 'Herkes',
            self::STUDENTS => 'Öğrenciler',
            self::TEACHERS => 'Öğretmenler',
        };
    }
}
