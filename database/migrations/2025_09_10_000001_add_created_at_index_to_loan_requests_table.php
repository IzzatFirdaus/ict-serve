<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Index already exists in create_loan_requests_table.php migration
        // No operation needed
    }

    public function down(): void
    {
        // No operation needed
    }
};
