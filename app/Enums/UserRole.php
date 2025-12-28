<?php

namespace App\Enums;

enum UserRole: string
{
    case STUDENT = 'student';
    case TEACHER = 'teacher';
    case ADMIN = 'admin';
    case SUPER_ADMIN = 'super_admin';

    public function label(): string
    {
        return match($this) {
            self::STUDENT => 'Öğrenci',
            self::TEACHER => 'Öğretmen',
            self::ADMIN => 'Admin',
            self::SUPER_ADMIN => 'Super Admin',
        };
    }

    public static function registerableRoles(): array
    {
        return [self::STUDENT, self::TEACHER];
    }

    public static function adminCreatableRoles(): array
    {
        return [self::STUDENT, self::TEACHER];
    }

    public static function superAdminCreatableRoles(): array
    {
        return [self::STUDENT, self::TEACHER, self::ADMIN, self::SUPER_ADMIN];
    }
}
