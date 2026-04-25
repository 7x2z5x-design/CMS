<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'Username' => 'admin',
            'Email' => 'admin@example.com',
            'PasswordHash' => \Illuminate\Support\Facades\Hash::make('password'),
            'FullName' => 'Administrator',
            'role' => 'Admin',
            'status' => 'active',
            'CreatedDate' => now(),
        ]);
    }
}
