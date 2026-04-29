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
        // First update existing data to map old values to new ones
        DB::statement("UPDATE contents SET content_type = 'standard' WHERE content_type = 'post'");
        DB::statement("UPDATE contents SET content_type = 'document' WHERE content_type = 'audio'");
        
        // Then modify the enum
        Schema::table('contents', function (Blueprint $table) {
            $table->enum('content_type', ['standard', 'image', 'video', 'resource', 'document'])->default('standard')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->enum('content_type', ['post', 'image', 'video', 'audio'])->default('post')->change();
        });
    }
};
