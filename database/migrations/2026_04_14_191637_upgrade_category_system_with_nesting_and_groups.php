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
        // 1. Upgrade categories table
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'slug')) {
                $table->string('slug')->unique()->after('name');
            }
            if (!Schema::hasColumn('categories', 'category_group')) {
                $table->enum('category_group', ['Content Type', 'Topic', 'Media'])->default('Topic')->after('description');
            }
            if (!Schema::hasColumn('categories', 'parent_id')) {
                $table->foreignId('parent_id')->nullable()->after('category_group')->constrained('categories')->onDelete('cascade');
            }
        });

        // 2. Create category_content pivot table
        Schema::create('category_content', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('content_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // 3. Migrate existing data from contents.category_id to pivot table
        $contents = DB::table('contents')->whereNotNull('category_id')->get();
        foreach ($contents as $content) {
            DB::table('category_content')->insert([
                'category_id' => $content->category_id,
                'content_id' => $content->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Remove category_id from contents
        Schema::table('contents', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
        });

        Schema::dropIfExists('category_content');

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['slug', 'category_group', 'parent_id']);
        });
    }
};
