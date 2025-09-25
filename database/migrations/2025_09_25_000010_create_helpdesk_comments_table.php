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
        // Helpdesk comments table: stores comments on helpdesk tickets
        Schema::create('helpdesk_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id')->comment('FK to helpdesk_tickets');
            $table->unsignedBigInteger('user_id')->comment('FK to users: commenter');
            $table->text('comment')->comment('Comment text');
            $table->boolean('is_internal')->default(false)->comment('Internal comment flag');
            $table->unsignedBigInteger('created_by')->nullable()->comment('FK to users: created by');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK to users: updated by');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('FK to users: deleted by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ticket_id')->references('id')->on('helpdesk_tickets')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();

            $table->index(['ticket_id', 'user_id', 'is_internal']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('helpdesk_comments');
    }
};
