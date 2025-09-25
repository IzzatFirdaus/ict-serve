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
        // Equipment categories table: stores equipment category master data
        Schema::create('equipment_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('Category name');
            $table->text('description')->nullable()->comment('Description');
            $table->boolean('is_active')->default(true)->comment('Active status');
            $table->unsignedBigInteger('created_by')->nullable()->comment('FK to users: created by');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK to users: updated by');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('FK to users: deleted by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();

            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_categories');
    }
};
