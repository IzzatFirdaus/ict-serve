<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Departments table: stores organization units (HQ, state, unit)
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('Department name');
            $table->enum('branch_type', ['ibu_pejabat','pejabat_negeri','unit'])->comment('Type of branch: HQ, state, or unit');
            $table->string('code')->unique()->comment('Unique department code');
            $table->text('description')->nullable()->comment('Description of department');
            $table->boolean('is_active')->default(true)->comment('Active status');
            $table->unsignedBigInteger('head_user_id')->nullable()->comment('FK to users: department head');
            $table->unsignedBigInteger('created_by')->nullable()->comment('FK to users: created by');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK to users: updated by');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('FK to users: deleted by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('head_user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();

            $table->index(['branch_type', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
