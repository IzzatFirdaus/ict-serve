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
            $table->dateTime('requested_from');
            $table->dateTime('loan_start_date')->nullable();
            $table->dateTime('expected_return_date');
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
            $table->dateTime('submitted_at')->nullable();
            $table->dateTime('requested_to');
            $table->dateTime('actual_from')->nullable();
            $table->dateTime('actual_to')->nullable();
            $table->text('notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('supervisor_id')->nullable()->constrained('users');
            $table->dateTime('supervisor_approved_at')->nullable();
            $table->text('supervisor_notes')->nullable();
            $table->foreignId('ict_admin_id')->nullable()->constrained('users');
            $table->dateTime('ict_approved_at')->nullable();
            $table->text('ict_notes')->nullable();
            $table->foreignId('issued_by')->nullable()->constrained('users');
            $table->dateTime('issued_at')->nullable();
            $table->string('pickup_signature_path')->nullable();
            $table->foreignId('received_by')->nullable()->constrained('users');
            $table->dateTime('returned_at')->nullable();
            $table->string('return_signature_path')->nullable();
            $table->text('return_condition_notes')->nullable();
            $table->timestamps();

            // Merged from add_created_at_index migration
            $table->index('created_at', 'loan_requests_created_at_index');
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
