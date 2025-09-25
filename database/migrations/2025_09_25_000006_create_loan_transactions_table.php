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
        // Loan transactions table: stores issue/return transactions for each loan application
        Schema::create('loan_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_application_id')->comment('FK to loan_applications');
            $table->enum('type', ['issue','return'])->comment('Transaction type');
            $table->date('transaction_date')->comment('Transaction date');
            $table->unsignedBigInteger('issuing_officer_id')->comment('FK to users: issuing officer');
            $table->unsignedBigInteger('receiving_officer_id')->comment('FK to users: receiving officer');
            $table->json('accessories_checklist_on_issue')->nullable()->comment('Accessories checklist on issue');
            $table->text('issue_notes')->nullable()->comment('Notes on issue');
            $table->json('accessories_checklist_on_return')->nullable()->comment('Accessories checklist on return');
            $table->text('return_notes')->nullable()->comment('Notes on return');
            $table->enum('status', ['pending','issued','returned_good','returned_damaged'])->default('pending')->comment('Transaction status');
            $table->unsignedBigInteger('created_by')->nullable()->comment('FK to users: created by');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK to users: updated by');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('FK to users: deleted by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('loan_application_id')->references('id')->on('loan_applications')->cascadeOnDelete();
            $table->foreign('issuing_officer_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('receiving_officer_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();

            $table->index(['loan_application_id', 'type', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_transactions');
    }
};
