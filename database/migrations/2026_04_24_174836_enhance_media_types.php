<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('media', function (Blueprint $table) {
            // Add URL field for external links (video links, resources, etc.)
            if (!Schema::hasColumn('media', 'url')) {
                $table->text('url')->nullable()->after('description');
            }
            
            // Add thumbnail field for videos
            if (!Schema::hasColumn('media', 'thumbnail')) {
                $table->string('thumbnail')->nullable()->after('url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn(['url', 'thumbnail']);
        });
    }
};
