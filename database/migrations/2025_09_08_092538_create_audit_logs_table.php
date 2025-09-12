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
            $table->foreignId('user_id')->nullable()->constrained('users'); // Who performed the action
            $table->string('action'); // created, updated, deleted, approved, rejected, etc.
            $table->string('auditable_type'); // Model class name
            $table->unsignedBigInteger('auditable_id'); // Model ID
            $table->json('old_values')->nullable(); // Previous state
            $table->json('new_values')->nullable(); // New state
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->text('notes')->nullable(); // Optional description
            $table->timestamps();

            $table->index(['auditable_type', 'auditable_id']);
            $table->index(['user_id', 'created_at']);
            $table->index('action');
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
