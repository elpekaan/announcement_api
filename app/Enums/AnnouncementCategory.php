<?php

namespace App\Enums;

enum AnnouncementCategory: string
{
    case ACADEMIC = 'academic';
    case ADMINISTRATIVE = 'administrative';
    case EVENT = 'event';
    case URGENT = 'urgent';

    public function label(): string
    {
        return match ($this) {
            self::ACADEMIC => 'Akademik',
            self::ADMINISTRATIVE => 'İdari',
            self::EVENT => 'Etkinlik',
            self::URGENT => 'Acil',
        };
    }
}
