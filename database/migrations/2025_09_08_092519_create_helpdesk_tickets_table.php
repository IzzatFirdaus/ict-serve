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
        Schema::create('helpdesk_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique(); // Auto-generated: HD-YYYY-MMDD-XXX
            $table->foreignId('user_id')->constrained('users'); // Ticket requester
            $table->foreignId('category_id')->constrained('ticket_categories');
            $table->foreignId('status_id')->constrained('ticket_statuses');
            $table->string('title');
            $table->text('description');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->enum('urgency', ['low', 'medium', 'high', 'critical'])->default('medium');

            // Assignment fields
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->timestamp('assigned_at')->nullable();

            // Equipment relation (if ticket is about specific equipment)
            $table->foreignId('equipment_item_id')->nullable()->constrained('equipment_items');

            // Location and contact info
            $table->string('location')->nullable(); // Where the issue is
            $table->string('contact_phone')->nullable();

            // SLA tracking
            $table->timestamp('due_at')->nullable(); // Based on SLA
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();

            // Resolution details
            $table->text('resolution')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users');

            // Feedback
            $table->integer('satisfaction_rating')->nullable(); // 1-5 scale
            $table->text('feedback')->nullable();

            // Attachments
            $table->json('attachments')->nullable(); // File paths

            $table->timestamps();

            $table->index(['user_id', 'status_id']);
            $table->index('ticket_number');
            $table->index(['category_id', 'priority']);
            $table->index('assigned_to');
            $table->index('due_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('helpdesk_tickets');
    }
};
