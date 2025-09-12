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
            $table->string('reference_number')->nullable();
            $table->string('request_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('applicant_name');
            $table->string('applicant_position');
            $table->string('applicant_department');
            $table->string('applicant_phone');
            $table->foreignId('status_id')->nullable()->constrained('loan_statuses');
            $table->text('purpose');
            $table->string('location');
            $table->datetime('requested_from');
            $table->datetime('loan_start_date')->nullable();
            $table->datetime('expected_return_date');
            $table->string('responsible_officer_name');
            $table->string('responsible_officer_position');
            $table->string('responsible_officer_phone');
            $table->boolean('same_as_applicant')->default(false);
            $table->json('equipment_requests')->nullable();
            $table->string('endorsing_officer_name')->nullable();
            $table->string('endorsing_officer_position')->nullable();
            $table->string('endorsement_status')->nullable();
            $table->text('endorsement_comments')->nullable();
            $table->string('status')->default('pending_supervisor');
            $table->datetime('submitted_at')->nullable();
            $table->datetime('requested_to');
            $table->datetime('actual_from')->nullable();
            $table->datetime('actual_to')->nullable();
            $table->text('notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('supervisor_id')->nullable()->constrained('users');
            $table->datetime('supervisor_approved_at')->nullable();
            $table->text('supervisor_notes')->nullable();
            $table->foreignId('ict_admin_id')->nullable()->constrained('users');
            $table->datetime('ict_approved_at')->nullable();
            $table->text('ict_notes')->nullable();
            $table->foreignId('issued_by')->nullable()->constrained('users');
            $table->datetime('issued_at')->nullable();
            $table->string('pickup_signature_path')->nullable();
            $table->foreignId('received_by')->nullable()->constrained('users');
            $table->datetime('returned_at')->nullable();
            $table->string('return_signature_path')->nullable();
            $table->text('return_condition_notes')->nullable();
            $table->timestamps();
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
