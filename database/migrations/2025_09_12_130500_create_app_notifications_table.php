<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('app_notifications', function (Blueprint $table) {
            $table->id();
            // User who receives the notification
            $table->foreignId('user_id')
                ->comment('User who receives the notification')
                ->constrained('users')
                ->nullOnDelete();
            $table->string('type')
                ->nullable()
                ->comment('Notification type (system, workflow, etc)');
            $table->string('title')
                ->nullable()
                ->comment('Notification title');
            $table->text('message')
                ->nullable()
                ->comment('Notification message body');
            $table->string('action_url')
                ->nullable()
                ->comment('URL for notification action');
            $table->json('data')
                ->nullable()
                ->comment('Additional data for notification');
            $table->enum('category', ['general', 'system', 'workflow', 'reminder', 'alert'])
                ->default('general')
                ->comment('Notification category');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])
                ->default('medium')
                ->comment('Notification priority');
            $table->string('icon')
                ->nullable()
                ->comment('Icon name for notification');
            $table->string('color')
                ->nullable()
                ->comment('Color token for notification');
            $table->timestamp('expires_at')
                ->nullable()
                ->comment('When the notification expires');
            $table->timestamp('read_at')
                ->nullable()
                ->comment('When the notification was read');
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

            $table->index(['user_id'], 'app_notifications_user_id_index');
            $table->index(['read_at'], 'app_notifications_read_at_index');
            $table->index(['expires_at'], 'app_notifications_expires_at_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('app_notifications');
    }
};
