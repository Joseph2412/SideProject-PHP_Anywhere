<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        User::updateOrCreate(
            ['email' => 'admin@prova.com'],
            [
                'name' => 'Utente Admin',
                'password' => Hash::make('prova'),
                'role' => 'admin',
            ]
        );

        // 2. Host One
        User::updateOrCreate(
            ['email' => 'host1@prova.com'],
            [
                'name' => 'Utente Host 1',
                'password' => Hash::make('prova'),
                'role' => 'host',
            ]
        );

        // 3. Host Two
        User::updateOrCreate(
            ['email' => 'host2@prova.com'],
            [
                'name' => 'Utente Host 2',
                'password' => Hash::make('prova'),
                'role' => 'host',
            ]
        );
    }
}
