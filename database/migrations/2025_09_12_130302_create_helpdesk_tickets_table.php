<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('helpdesk_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('category_id')->constrained('ticket_categories');
            $table->foreignId('status_id')->constrained('ticket_statuses');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('damage_type')->nullable();
            $table->string('priority')->default('medium');
            $table->string('urgency')->default('medium');
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->timestamp('assigned_at')->nullable();
            $table->foreignId('equipment_item_id')->nullable()->constrained('assets');
            $table->string('location')->nullable();
            $table->string('contact_phone')->nullable();
            $table->timestamp('due_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->text('resolution')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users');
            $table->integer('satisfaction_rating')->nullable();
            $table->text('feedback')->nullable();
            $table->json('attachments')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('helpdesk_tickets');
    }
};
