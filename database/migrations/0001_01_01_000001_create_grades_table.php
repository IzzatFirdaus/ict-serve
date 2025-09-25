<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Grades table: stores grade levels and approval hierarchy
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('Grade name');
            $table->integer('level')->comment('Hierarchy level');
            $table->unsignedBigInteger('min_approval_grade_id')->nullable()->comment('FK to grades: minimum approval grade');
            $table->boolean('is_approver_grade')->default(false)->comment('Is this grade an approver?');
            $table->unsignedBigInteger('created_by')->nullable()->comment('FK to users: created by');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK to users: updated by');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('FK to users: deleted by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('min_approval_grade_id')->references('id')->on('grades')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();

            $table->index(['level', 'is_approver_grade']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
