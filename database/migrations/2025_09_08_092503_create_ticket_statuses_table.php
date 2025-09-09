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
        Schema::create('ticket_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // new, assigned, in_progress, resolved, closed, cancelled
            $table->string('name');
            // Allow nullable for backward compatibility with older seeders/tests that may not provide BM name
            $table->string('name_bm')->nullable();
            $table->text('description')->nullable();
            $table->text('description_bm')->nullable();
            $table->string('color', 7)->default('#6b7280'); // Hex color for UI
            $table->boolean('is_active')->default(true);
            $table->boolean('is_final')->default(false); // Cannot change from this status
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_statuses');
    }
};
