<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a default admin user for the CMS
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'CMS Admin',
                'password' => bcrypt('password'),
                'role' => 'Admin',
                'status' => 'Active',
            ]
        );
    }
}
