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
        Schema::create('damage_types', function (Blueprint $table) {
            $table->id();
            // English display name (legacy key: name)
            $table->string('name');
            // Bahasa Melayu display name
            $table->string('name_bm');
            // Optional longer descriptions
            $table->text('description')->nullable();
            $table->text('description_bm')->nullable();
            // Severity: low, medium, high
            $table->string('severity')->default('medium');
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
        Schema::dropIfExists('damage_types');
    }
};
