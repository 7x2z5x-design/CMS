<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'FullName' => 'Admin User',
            'Email' => 'admin@example.com',
            'PasswordHash' => Hash::make('password'),
            'role' => 'Admin',
            'status' => 'active',
        ]);

        // Create editor user
        User::create([
            'FullName' => 'Sarah Johnson',
            'Email' => 'sarah@example.com',
            'PasswordHash' => Hash::make('password'),
            'role' => 'Editor',
            'status' => 'active',
        ]);

        // Create viewer users
        User::create([
            'FullName' => 'John Doe',
            'Email' => 'john@example.com',
            'PasswordHash' => Hash::make('password'),
            'role' => 'Viewer',
            'status' => 'active',
        ]);

        User::create([
            'FullName' => 'Michael Brown',
            'Email' => 'michael@example.com',
            'PasswordHash' => Hash::make('password'),
            'role' => 'Viewer',
            'status' => 'inactive',
        ]);

        User::create([
            'FullName' => 'Emily Wilson',
            'Email' => 'emily@example.com',
            'PasswordHash' => Hash::make('password'),
            'role' => 'Editor',
            'status' => 'active',
        ]);
    }
}
