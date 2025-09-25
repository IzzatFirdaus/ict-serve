<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Helpdesk tickets table: stores support/helpdesk tickets
        Schema::create('helpdesk_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('FK to users: ticket creator');
            $table->unsignedBigInteger('assigned_to_user_id')->nullable()->comment('FK to users: assigned to');
            $table->unsignedBigInteger('category_id')->comment('FK to helpdesk_categories');
            $table->string('subject')->comment('Ticket subject');
            $table->text('description')->comment('Ticket description');
            $table->enum('status', ['open','in_progress','pending_user_feedback','resolved','closed','reopened'])->default('open')->comment('Ticket status');
            $table->enum('priority', ['low','medium','high','critical'])->default('medium')->comment('Priority');
            $table->date('due_date')->nullable()->comment('Due date');
            $table->text('resolution_notes')->nullable()->comment('Resolution notes');
            $table->timestamp('closed_at')->nullable()->comment('Closed at');
            $table->unsignedBigInteger('created_by')->nullable()->comment('FK to users: created by');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK to users: updated by');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('FK to users: deleted by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('assigned_to_user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('category_id')->references('id')->on('helpdesk_categories')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();

            $table->index(['user_id', 'assigned_to_user_id', 'category_id', 'status', 'priority']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('helpdesk_tickets');
    }
};
