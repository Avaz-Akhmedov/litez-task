<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->firstOrCreate([
            'email' => 'admin@gmail.com',

        ], [
            'name' => 'Admin Adminov',
            'password' => '111_222',
            'role' => UserRole::Admin
        ]);

        User::query()->firstOrCreate([
            'email' => 'manager@gmail.com',
        ], [
            'name' => 'Manager Managerov',
            'password' => '111_222',
            'role' => UserRole::Manager
        ]);
    }
}
