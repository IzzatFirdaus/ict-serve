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
        Schema::create('equipment_loans', function (Blueprint $table) {
            $table->id();

            // Applicant Information
            $table->string('applicant_name');
            $table->string('division');
            $table->string('position_grade')->nullable();
            $table->string('email');
            $table->string('phone_number');

            // Equipment Request
            $table->json('equipment_requested'); // Array of equipment items
            $table->date('loan_start_date');
            $table->date('loan_end_date');
            $table->text('purpose');
            $table->string('event_location')->nullable();

            // Responsible Officer
            $table->string('responsible_officer_name')->nullable();
            $table->string('responsible_officer_position')->nullable();
            $table->string('responsible_officer_phone')->nullable();

            // Status and Approval
            $table->enum('status', ['submitted', 'pending_approval', 'approved', 'rejected', 'collected', 'returned'])->default('submitted');
            $table->string('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->text('approval_notes')->nullable();
            $table->text('rejection_reason')->nullable();

            // Collection and Return
            $table->timestamp('collected_at')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->text('return_condition_notes')->nullable();

            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('division');
            $table->index(['loan_start_date', 'loan_end_date']);
        });
            // Merge: add_equipment_loan_fields
            // Already present: applicant_name, division, position_grade, email, phone_number, equipment_requested, loan_start_date, loan_end_date, purpose, event_location, responsible_officer_name, responsible_officer_position, responsible_officer_phone, status, approved_by, approved_at, approval_notes, rejection_reason, collected_at, returned_at, return_condition_notes
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_loans');
    }
};
