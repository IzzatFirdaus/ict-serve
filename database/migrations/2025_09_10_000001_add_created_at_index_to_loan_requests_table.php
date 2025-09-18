<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loan_requests', function (Blueprint $table) {
            $table->index('created_at', 'loan_requests_created_at_index');
        });
    }

    public function down(): void
    {
        Schema::table('loan_requests', function (Blueprint $table) {
            $table->dropIndex('loan_requests_created_at_index');
        });
    }
};
