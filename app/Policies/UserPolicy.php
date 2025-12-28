<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return !$user->isStudent();
    }

    public function view(User $user, User $target): bool
    {
        return $this->canManage($user, $target);
    }

    public function create(User $user): bool
    {
        return !$user->isStudent();
    }

    public function update(User $user, User $target): bool
    {
        return $this->canManage($user, $target);
    }

    public function delete(User $user, User $target): bool
    {
        if ($user->id === $target->id) {
            return false;
        }
        return $this->canManage($user, $target);
    }

    private function canManage(User $manager, User $target): bool
    {
        if ($manager->isSuperAdmin()) {
            return true;
        }

        if ($manager->isAdmin()) {
            return in_array($target->role, [UserRole::TEACHER, UserRole::STUDENT]);
        }

        if ($manager->isTeacher()) {
            return $target->role === UserRole::STUDENT;
        }

        return false;
    }

    public function getManageableRoles(User $user): array
    {
        if ($user->isSuperAdmin()) {
            return [UserRole::SUPER_ADMIN, UserRole::ADMIN, UserRole::TEACHER, UserRole::STUDENT];
        }

        if ($user->isAdmin()) {
            return [UserRole::TEACHER, UserRole::STUDENT];
        }

        if ($user->isTeacher()) {
            return [UserRole::STUDENT];
        }

        return [];
    }
}
