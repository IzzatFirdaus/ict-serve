<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Positions table: stores job positions and their grade
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('Position name');
            $table->foreignId('grade_id')->comment('FK to grades')->constrained('grades')->cascadeOnDelete();
            $table->text('description')->nullable()->comment('Description of position');
            $table->boolean('is_active')->default(true)->comment('Active status');
            $table->unsignedBigInteger('created_by')->nullable()->comment('FK to users: created by');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK to users: updated by');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('FK to users: deleted by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();

            $table->index(['grade_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
