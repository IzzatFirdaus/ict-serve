<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // No-op: index already exists in create_helpdesk_tickets_table.php migration
        // This migration was attempting to add helpdesk_tickets_created_at_index but it already exists
    }

    public function down(): void
    {
        // No-op: index is part of the main table creation and should not be dropped here
    }
};
