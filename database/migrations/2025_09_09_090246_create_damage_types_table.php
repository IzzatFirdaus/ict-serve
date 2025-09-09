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
            $table->string('name'); // English name
            $table->string('name_bm'); // Bahasa Malaysia name
            $table->text('description')->nullable(); // English description
            $table->text('description_bm')->nullable(); // Bahasa Malaysia description
            $table->string('icon')->nullable(); // Icon for UI display
            $table->enum('severity', ['low', 'medium', 'high', 'critical'])->default('medium'); // Damage severity level
            $table->boolean('is_active')->default(true); // Active status
            $table->integer('sort_order')->default(0); // For ordering in dropdown
            $table->string('color_code', 7)->nullable(); // Hex color code for UI display
            $table->json('metadata')->nullable(); // Additional flexible data
            $table->timestamps();

            // Indexes for performance
            $table->index(['is_active', 'sort_order']);
            $table->index('severity');
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
