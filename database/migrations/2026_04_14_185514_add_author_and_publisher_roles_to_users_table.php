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
        // Using raw SQL for enum modification as it's more reliable across different MySQL versions
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Editor', 'Author', 'Publisher', 'Viewer') DEFAULT 'Viewer'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Editor', 'Viewer') DEFAULT 'Viewer'");
    }
};
