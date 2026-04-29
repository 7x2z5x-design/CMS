<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update all lowercase roles to uppercase equivalents
        DB::statement("UPDATE users SET role = 'Admin' WHERE role IN ('admin', 'administrator')");
        DB::statement("UPDATE users SET role = 'Author' WHERE role IN ('author', 'writer', 'contributor')");
        DB::statement("UPDATE users SET role = 'Editor' WHERE role IN ('editor', 'moderator')");
        DB::statement("UPDATE users SET role = 'Viewer' WHERE role IN ('viewer', 'reader', 'member', 'user')");
        
        // Handle any other unexpected values by setting them to Viewer
        DB::statement("UPDATE users SET role = 'Viewer' WHERE role NOT IN ('Admin', 'Editor', 'Author', 'Viewer')");
        
        // Now safely modify the enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Editor', 'Author', 'Viewer') NOT NULL DEFAULT 'Viewer'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // For rollback, convert back to lowercase
        DB::statement("UPDATE users SET role = 'admin' WHERE role = 'Admin'");
        DB::statement("UPDATE users SET role = 'author' WHERE role = 'Author'");
        DB::statement("UPDATE users SET role = 'editor' WHERE role = 'Editor'");
        DB::statement("UPDATE users SET role = 'reader' WHERE role = 'Viewer'");
        
        // Revert enum to include lowercase
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'author', 'reader') NOT NULL DEFAULT 'author'");
    }
};
