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
            $table->string('serial_number')->nullable()->unique();
            $table->string('category');
            $table->string('brand');
            $table->string('model');
            $table->text('description')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('warranty_expiry')->nullable();
            $table->decimal('purchase_value', 10, 2)->nullable();
            $table->string('status');
            $table->string('condition');
            $table->string('location')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->date('assigned_date')->nullable();
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
