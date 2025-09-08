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
        Schema::create('equipment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('equipment_categories');
            $table->string('asset_tag')->unique(); // MOTAC asset tag
            $table->string('serial_number')->nullable();
            $table->string('brand');
            $table->string('model');
            $table->text('specifications')->nullable();
            $table->text('description')->nullable();
            $table->enum('condition', ['excellent', 'good', 'fair', 'poor', 'damaged'])
                ->default('excellent');
            $table->enum('status', ['available', 'on_loan', 'maintenance', 'retired'])
                ->default('available');
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('warranty_expiry')->nullable();
            $table->string('location')->nullable(); // Storage/office location
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['category_id', 'status']);
            $table->index('asset_tag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_items');
    }
};
