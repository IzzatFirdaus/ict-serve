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
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            // Polymorphic relation to any approvable model (loan, helpdesk, etc)
            $table->morphs('approvable', 'approvals_approvable_index');
            // Approver (user who makes the decision)
            $table->foreignId('approver_id')
                ->nullable()
                ->comment('User who made the approval decision')
                ->constrained('users')
                ->nullOnDelete();
            // Enum for decision: approved, rejected, pending
            $table->enum('decision', ['approved', 'rejected', 'pending'])
                ->default('pending')
                ->comment('Approval decision status');
            $table->timestamp('decided_at')
                ->nullable()
                ->comment('When the decision was made');
            $table->text('comments')
                ->nullable()
                ->comment('Optional comments from approver');
            $table->json('metadata')
                ->nullable()
                ->comment('Additional metadata for audit or workflow');
            // Audit fields
            $table->foreignId('created_by')
                ->nullable()
                ->comment('User who created the record')
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId('updated_by')
                ->nullable()
                ->comment('User who last updated the record')
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId('deleted_by')
                ->nullable()
                ->comment('User who deleted the record (soft delete)')
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['approver_id'], 'approvals_approver_id_index');
            $table->index(['decided_at'], 'approvals_decided_at_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
