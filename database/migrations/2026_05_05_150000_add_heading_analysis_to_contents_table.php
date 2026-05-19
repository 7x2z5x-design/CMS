<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->json('seo_meta')->nullable()->after('status');
            $table->integer('h1_count')->default(0)->after('seo_meta');
            $table->integer('h2_count')->default(0)->after('h1_count');
            $table->integer('h3_count')->default(0)->after('h2_count');
            $table->integer('h4_count')->default(0)->after('h3_count');
            $table->integer('h5_count')->default(0)->after('h4_count');
            $table->integer('h6_count')->default(0)->after('h5_count');
        });
    }

    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn('seo_meta');
            $table->dropColumn('h1_count');
            $table->dropColumn('h2_count');
            $table->dropColumn('h3_count');
            $table->dropColumn('h4_count');
            $table->dropColumn('h5_count');
        });
    }
};
