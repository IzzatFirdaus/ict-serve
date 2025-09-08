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
        Schema::create('ticket_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('name_bm');
            $table->text('description')->nullable();
            $table->text('description_bm')->nullable();
            $table->string('icon')->nullable(); // For UI display
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->integer('default_sla_hours')->default(24); // Default SLA in hours
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_categories');
    }
};
