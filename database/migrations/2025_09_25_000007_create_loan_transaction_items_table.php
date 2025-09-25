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
        // Loan transaction items table: stores equipment issued/returned in each transaction
        Schema::create('loan_transaction_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_transaction_id')->comment('FK to loan_transactions');
            $table->unsignedBigInteger('equipment_id')->comment('FK to equipment');
            $table->enum('status', ['issued','returned_good','returned_damaged','reported_lost'])->default('issued')->comment('Item status');
            $table->string('condition_on_return')->nullable()->comment('Condition on return');
            $table->unsignedBigInteger('created_by')->nullable()->comment('FK to users: created by');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK to users: updated by');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('FK to users: deleted by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('loan_transaction_id')->references('id')->on('loan_transactions')->cascadeOnDelete();
            $table->foreign('equipment_id')->references('id')->on('equipment')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();

            $table->index(['loan_transaction_id', 'equipment_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_transaction_items');
    }
};
