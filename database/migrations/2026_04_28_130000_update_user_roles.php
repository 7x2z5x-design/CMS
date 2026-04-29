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
        // Update existing roles to lowercase
        DB::statement("UPDATE users SET role = 'admin' WHERE role = 'Admin'");
        DB::statement("UPDATE users SET role = 'author' WHERE role = 'Author'");
        DB::statement("UPDATE users SET role = 'reader' WHERE role = 'Viewer'");
        
        // For MySQL, we need to modify the enum column
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'author', 'reader') NOT NULL DEFAULT 'author'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Update roles back to original format
        DB::statement("UPDATE users SET role = 'Admin' WHERE role = 'admin'");
        DB::statement("UPDATE users SET role = 'Author' WHERE role = 'author'");
        DB::statement("UPDATE users SET role = 'Viewer' WHERE role = 'reader'");
        
        // Revert enum to original format
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Editor', 'Viewer') NOT NULL DEFAULT 'Viewer'");
    }
};
