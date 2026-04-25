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
        // First, update existing categories to use compatible values
        DB::statement("UPDATE categories SET category_group = 'Blog & Articles' WHERE category_group = 'Content Type'");
        DB::statement("UPDATE categories SET category_group = 'Media & Content' WHERE category_group = 'Media'");
        DB::statement("UPDATE categories SET category_group = 'Custom / Uncategorized' WHERE category_group = 'Topic'");
        
        // Then update the enum
        Schema::table('categories', function (Blueprint $table) {
            // Update the category_group enum to include all comprehensive category groups
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
            ])->default('Blog & Articles')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Revert to original enum values
            $table->enum('category_group', ['Content Type', 'Topic', 'Media'])->default('Topic')->change();
        });
    }
};
