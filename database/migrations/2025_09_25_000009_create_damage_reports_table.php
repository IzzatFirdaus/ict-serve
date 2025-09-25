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
        // Damage reports table: stores ICT equipment damage complaints
        Schema::create('damage_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('FK to users: reporter');
            $table->unsignedBigInteger('department_id')->comment('FK to departments');
            $table->string('position_grade')->comment('Reporter position/grade');
            $table->string('email')->comment('Reporter email');
            $table->string('phone_number')->comment('Reporter phone');
            $table->unsignedBigInteger('damage_type')->comment('FK to helpdesk_categories');
            $table->text('description')->comment('Damage description');
            $table->boolean('confirmation')->default(false)->comment('Reporter confirmation');
            $table->enum('status', ['new','assigned','in_progress','resolved','closed'])->default('new')->comment('Report status');
            $table->unsignedBigInteger('assigned_to_user_id')->nullable()->comment('FK to users: assigned to');
            $table->text('resolution_notes')->nullable()->comment('Resolution notes');
            $table->timestamp('closed_at')->nullable()->comment('Closed at');
            $table->unsignedBigInteger('created_by')->nullable()->comment('FK to users: created by');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK to users: updated by');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('FK to users: deleted by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->nullOnDelete();
            $table->foreign('damage_type')->references('id')->on('helpdesk_categories')->nullOnDelete();
            $table->foreign('assigned_to_user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();

            $table->index(['user_id', 'department_id', 'damage_type', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damage_reports');
    }
};
