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
        Schema::table('contents', function (Blueprint $table) {
            $table->decimal('readability_score', 8, 2)->nullable()->after('published_at');
            $table->string('focus_keyword')->nullable()->after('readability_score');
            $table->decimal('keyword_density', 5, 2)->nullable()->after('focus_keyword');
            $table->json('seo_meta')->nullable()->after('keyword_density');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn(['readability_score', 'focus_keyword', 'keyword_density', 'seo_meta']);
        });
    }
};
