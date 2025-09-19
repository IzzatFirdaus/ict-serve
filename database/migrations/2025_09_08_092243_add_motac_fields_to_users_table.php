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
            // Check if columns exist before adding to avoid duplicate column errors
            if (! Schema::hasColumn('users', 'staff_id')) {
                $table->string('staff_id')->unique()->after('id');
            }

            // These columns likely already exist in the base migration,
            // but let's modify them if needed
            if (Schema::hasColumn('users', 'staff_id') && ! Schema::hasColumn('users', 'staff_id_unique')) {
                // Add unique constraint if not exists
                try {
                    $table->unique('staff_id');
                } catch (\Exception $e) {
                    // Unique constraint may already exist
                }
            }

            // Update role column to use enum if it's currently string
            if (Schema::hasColumn('users', 'role')) {
                // Modify existing role column to enum if needed
                $table->enum('role', ['user', 'supervisor', 'ict_admin', 'helpdesk_staff', 'super_admin'])
                    ->default('user')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Only drop columns that were added by this migration
            // Most fields already exist in base users table

            // Just revert role to string if needed
            if (Schema::hasColumn('users', 'role')) {
                $table->string('role')->nullable()->change();
            }
        });
    }
};
