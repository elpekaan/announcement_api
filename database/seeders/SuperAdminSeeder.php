<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@ciu.edu.tr'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('12345678'),
                'role' => UserRole::SUPER_ADMIN,
            ]
        );
    }
}
