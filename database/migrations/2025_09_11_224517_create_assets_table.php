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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_number')->unique()->index();
            $table->string('name');
            $table->string('category'); // PC, Laptop, Printer, Scanner, Projektor, iPad
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable()->unique();
            $table->date('purchase_date')->nullable();
            $table->date('warranty_expiry')->nullable();
            $table->enum('status', ['available', 'assigned', 'maintenance', 'damaged', 'disposed'])->default('available');
            $table->string('location')->nullable(); // Physical location
            $table->string('division')->nullable(); // Assigned division
            $table->string('assigned_to')->nullable(); // Staff name or ID
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
