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
        Schema::create('loan_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_number')->unique(); // Auto-generated: LR-YYYY-MMDD-XXX
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('status_id')->constrained('loan_statuses');
            $table->text('purpose'); // Purpose of loan
            $table->date('requested_from');
            $table->date('requested_to');
            $table->date('actual_from')->nullable(); // When actually picked up
            $table->date('actual_to')->nullable(); // When actually returned
            $table->text('notes')->nullable();
            $table->text('rejection_reason')->nullable();

            // Approval workflow fields
            $table->foreignId('supervisor_id')->nullable()->constrained('users');
            $table->timestamp('supervisor_approved_at')->nullable();
            $table->text('supervisor_notes')->nullable();

            $table->foreignId('ict_admin_id')->nullable()->constrained('users');
            $table->timestamp('ict_approved_at')->nullable();
            $table->text('ict_notes')->nullable();

            // Pickup and return tracking
            $table->foreignId('issued_by')->nullable()->constrained('users');
            $table->timestamp('issued_at')->nullable();
            $table->string('pickup_signature_path')->nullable();

            $table->foreignId('received_by')->nullable()->constrained('users');
            $table->timestamp('returned_at')->nullable();
            $table->string('return_signature_path')->nullable();
            $table->text('return_condition_notes')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status_id']);
            $table->index('request_number');
            $table->index(['requested_from', 'requested_to']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_requests');
    }
};
