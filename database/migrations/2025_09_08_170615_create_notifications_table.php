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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // ticket_update, loan_approval, system_announcement, etc.
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // Additional data for the notification
            $table->string('category')->default('general'); // general, ticket, loan, system
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->string('action_url')->nullable(); // URL to redirect when clicked
            $table->string('icon')->nullable(); // Icon for the notification
            $table->string('color')->default('blue'); // Color theme for the notification
            $table->timestamp('expires_at')->nullable(); // When the notification should expire
            $table->timestamps();

            $table->index(['user_id', 'is_read']);
            $table->index(['type', 'created_at']);
            $table->index(['category', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
