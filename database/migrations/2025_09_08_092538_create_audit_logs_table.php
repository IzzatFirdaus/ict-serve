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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            // User who performed the action
            $table->foreignId('user_id')
                ->nullable()
                ->comment('User who performed the action')
                ->constrained('users')
                ->nullOnDelete();
            $table->string('action')
                ->comment('Action performed: created, updated, deleted, approved, rejected, etc.');
            $table->string('auditable_type')
                ->comment('Model class name');
            $table->unsignedBigInteger('auditable_id')
                ->comment('Model ID');
            $table->json('old_values')
                ->nullable()
                ->comment('Previous state');
            $table->json('new_values')
                ->nullable()
                ->comment('New state');
            $table->string('ip_address', 45)
                ->nullable()
                ->comment('IP address of the actor');
            $table->string('user_agent')
                ->nullable()
                ->comment('User agent string');
            $table->text('notes')
                ->nullable()
                ->comment('Optional description or notes');
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

            $table->index(['auditable_type', 'auditable_id'], 'audit_logs_auditable_index');
            $table->index(['user_id', 'created_at'], 'audit_logs_user_created_index');
            $table->index('action', 'audit_logs_action_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
