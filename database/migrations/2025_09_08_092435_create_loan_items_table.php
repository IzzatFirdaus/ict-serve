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
        Schema::create('loan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_request_id')->constrained('loan_requests');
            $table->foreignId('equipment_item_id')->constrained('equipment_items');
            $table->integer('quantity')->default(1);
            $table->enum('condition_out', ['excellent', 'good', 'fair', 'poor', 'damaged'])
                ->nullable(); // Condition when loaned out
            $table->enum('condition_in', ['excellent', 'good', 'fair', 'poor', 'damaged'])
                ->nullable(); // Condition when returned
            $table->text('notes_out')->nullable(); // Notes when issuing
            $table->text('notes_in')->nullable(); // Notes when returning
            $table->boolean('damage_reported')->default(false);
            $table->timestamps();

            $table->unique(['loan_request_id', 'equipment_item_id']);
            $table->index('equipment_item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_items');
    }
};
