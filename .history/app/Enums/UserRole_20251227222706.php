<?php

namespace App\Enums;

enum UserRole: string
{
    case STUDENT = 'student';
    case TEACHER = 'teacher';
    case ADMIN = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::STUDENT => 'Öğrenci',
            self::TEACHER => 'Öğretmen',
            self::ADMIN => 'Admin',
        };
    }
}
