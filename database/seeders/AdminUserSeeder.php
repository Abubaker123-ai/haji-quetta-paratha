<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@haji.com'],
            [
                'name' => 'Haji Quetta Admin',
                'password' => Hash::make('haji-admin-2024'),
                'email_verified_at' => now(),
            ]
        );
    }
}
