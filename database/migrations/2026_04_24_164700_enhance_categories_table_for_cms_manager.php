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
            if (!Schema::hasColumn('categories', 'category_group')) {
                $table->enum('category_group', [
                    'Blog & Articles',
                    'Media & Content', 
                    'Products & Services',
                    'Events',
                    'Portfolio & Projects',
                    'Knowledge Base / Docs',
                    'Community & Social',
                    'Jobs & Careers',
                    'Courses & Learning',
                    'Custom / Uncategorized'
                ])->default('Blog & Articles')->after('description');
            }

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

            // Update existing category_group column if it exists with different values
            if (Schema::hasColumn('categories', 'category_group')) {
                // Update old enum values to new ones if needed
                try {
                    DB::statement("UPDATE categories SET category_group = 'Blog & Articles' WHERE category_group = 'Content Type'");
                } catch (\Exception $e) {
                    // Ignore if column doesn't have old values
                }
                try {
                    DB::statement("UPDATE categories SET category_group = 'Custom / Uncategorized' WHERE category_group = 'Topic'");
                } catch (\Exception $e) {
                    // Ignore if column doesn't have old values
                }
                try {
                    DB::statement("UPDATE categories SET category_group = 'Media & Content' WHERE category_group = 'Media'");
                } catch (\Exception $e) {
                    // Ignore if column doesn't have old values
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $columnsToDrop = ['category_group', 'seo_title', 'seo_description', 'featured_image', 'display_order'];
            
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('categories', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
