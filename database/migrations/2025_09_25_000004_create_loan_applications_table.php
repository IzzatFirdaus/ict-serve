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
        // Loan applications table: stores ICT equipment loan requests
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('FK to users: applicant');
            $table->unsignedBigInteger('responsible_officer_id')->comment('FK to users: responsible officer');
            $table->unsignedBigInteger('supporting_officer_id')->nullable()->comment('FK to users: supporting officer');
            $table->text('purpose')->comment('Purpose of loan');
            $table->string('location')->comment('Loan location');
            $table->string('return_location')->nullable()->comment('Return location');
            $table->date('loan_start_date')->comment('Start date');
            $table->date('loan_end_date')->comment('End date');
            $table->enum('status', ['draft','pending_support','approved','rejected','issued','returned','completed'])->default('draft')->comment('Application status');
            $table->text('rejection_reason')->nullable()->comment('Rejection reason');
            $table->timestamp('applicant_confirmation_timestamp')->nullable()->comment('Applicant confirmation');
            $table->timestamp('submitted_at')->nullable()->comment('Submission timestamp');
            $table->unsignedBigInteger('approved_by')->nullable()->comment('FK to users: approved by');
            $table->timestamp('approved_at')->nullable()->comment('Approval timestamp');
            $table->unsignedBigInteger('rejected_by')->nullable()->comment('FK to users: rejected by');
            $table->timestamp('rejected_at')->nullable()->comment('Rejection timestamp');
            $table->unsignedBigInteger('cancelled_by')->nullable()->comment('FK to users: cancelled by');
            $table->timestamp('cancelled_at')->nullable()->comment('Cancellation timestamp');
            $table->text('admin_notes')->nullable()->comment('Admin notes');
            $table->unsignedBigInteger('current_approval_officer_id')->nullable()->comment('FK to users: current approval officer');
            $table->string('current_approval_stage')->nullable()->comment('Current approval stage');
            $table->unsignedBigInteger('created_by')->nullable()->comment('FK to users: created by');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK to users: updated by');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('FK to users: deleted by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('responsible_officer_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('supporting_officer_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('rejected_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('cancelled_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('current_approval_officer_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();

            $table->index(['user_id', 'status', 'loan_start_date', 'loan_end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_applications');
    }
};
