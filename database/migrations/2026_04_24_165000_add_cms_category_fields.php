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
        Schema::table('categories', function (Blueprint $table) {
            // Add missing fields for comprehensive CMS Categories Manager
            if (!Schema::hasColumn('categories', 'seo_title')) {
                $table->string('seo_title')->nullable()->after('color');
            }

            if (!Schema::hasColumn('categories', 'seo_description')) {
                $table->text('seo_description')->nullable()->after('seo_title');
            }

            if (!Schema::hasColumn('categories', 'featured_image')) {
                $table->string('featured_image')->nullable()->after('seo_description');
            }

            if (!Schema::hasColumn('categories', 'display_order')) {
                $table->integer('display_order')->default(0)->after('featured_image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $columnsToDrop = ['seo_title', 'seo_description', 'featured_image', 'display_order'];
            
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('categories', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
