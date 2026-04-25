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
        Schema::table('users', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['Admin', 'Editor', 'Viewer'])->default('Viewer');
            }
            
            if (!Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['Active', 'Inactive'])->default('Active');
            }
            
            // Ensure name column exists (rename from FullName if needed)
            if (Schema::hasColumn('users', 'FullName') && !Schema::hasColumn('users', 'name')) {
                $table->renameColumn('FullName', 'name');
            }
            
            // Ensure email column exists (rename from Email if needed)
            if (Schema::hasColumn('users', 'Email') && !Schema::hasColumn('users', 'email')) {
                $table->renameColumn('Email', 'email');
            }
            
            // Ensure password column exists (rename from PasswordHash if needed)
            if (Schema::hasColumn('users', 'PasswordHash') && !Schema::hasColumn('users', 'password')) {
                $table->renameColumn('PasswordHash', 'password');
            }
            
            // Remove unnecessary columns if they exist
            if (Schema::hasColumn('users', 'Username')) {
                $table->dropColumn('Username');
            }
            
            if (Schema::hasColumn('users', 'Bio')) {
                $table->dropColumn('Bio');
            }
            
            if (Schema::hasColumn('users', 'ProfilePicture')) {
                $table->dropColumn('ProfilePicture');
            }
            
            if (Schema::hasColumn('users', 'CreatedDate')) {
                $table->dropColumn('CreatedDate');
            }
            
            // Add timestamps if they don't exist
            if (!Schema::hasColumn('users', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // This would reverse the changes if needed
            // For now, we'll keep the table as is since it's a modification
        });
    }
};
