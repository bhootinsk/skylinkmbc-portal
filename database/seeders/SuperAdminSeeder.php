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
        $password = env('SUPERADMIN_PASSWORD');

        if (empty($password)) {
            throw new \RuntimeException('SUPERADMIN_PASSWORD must be set in .env before seeding.');
        }

        User::updateOrCreate(
            ['username' => 'superadmin'],
            [
                'name' => 'Site Manager',
                'email' => 'superadmin@skylinkmbc.biz',
                'role' => UserRole::SuperAdmin,
                'is_suspended' => false,
                'is_protected' => true,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );
    }
}
