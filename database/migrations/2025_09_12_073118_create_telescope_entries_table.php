<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Get the migration connection name.
     */
    public function getConnection(): ?string
    {
        return config('telescope.storage.database.connection');
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // No-op: telescope_entries tables already exist in the original create_telescope_entries_table migration (2025_09_09_163558)
        // This migration was generated during the larastan branch merge and would create duplicate tables.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op: telescope_entries tables managed by the original create_telescope_entries_table migration (2025_09_09_163558)
    }
};
