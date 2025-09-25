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
        // Loan application items table: stores requested equipment for each application
        Schema::create('loan_application_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_application_id')->comment('FK to loan_applications');
            $table->string('equipment_type')->comment('Type of equipment requested');
            $table->integer('quantity_requested')->comment('Requested quantity');
            $table->integer('quantity_approved')->nullable()->comment('Approved quantity');
            $table->integer('quantity_issued')->nullable()->comment('Issued quantity');
            $table->integer('quantity_returned')->nullable()->comment('Returned quantity');
            $table->unsignedBigInteger('created_by')->nullable()->comment('FK to users: created by');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK to users: updated by');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('FK to users: deleted by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('loan_application_id')->references('id')->on('loan_applications')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();

            $table->index(['loan_application_id', 'equipment_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_application_items');
    }
};
