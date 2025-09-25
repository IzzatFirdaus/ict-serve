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
        // Equipment table: stores all equipment/assets
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('asset_type')->comment('Type of asset');
            $table->string('brand')->comment('Brand');
            $table->string('model')->comment('Model');
            $table->string('serial_number')->unique()->comment('Serial number');
            $table->string('tag_id')->unique()->comment('Tag/asset ID');
            $table->date('purchase_date')->nullable()->comment('Purchase date');
            $table->date('warranty_expiry_date')->nullable()->comment('Warranty expiry date');
            $table->enum('status', ['available','on_loan','under_maintenance','retired'])->default('available')->comment('Equipment status');
            $table->string('current_location')->nullable()->comment('Current location');
            $table->text('notes')->nullable()->comment('Notes');
            $table->enum('condition_status', ['baru','baik','sederhana','rosak','hilang'])->default('baik')->comment('Condition status');
            $table->unsignedBigInteger('department_id')->nullable()->comment('FK to departments');
            $table->unsignedBigInteger('equipment_category_id')->nullable()->comment('FK to equipment_categories');
            $table->unsignedBigInteger('sub_category_id')->nullable()->comment('FK to sub_categories');
            $table->unsignedBigInteger('location_id')->nullable()->comment('FK to locations');
            $table->string('item_code')->nullable()->comment('Item code');
            $table->text('description')->nullable()->comment('Description');
            $table->decimal('purchase_price', 12, 2)->nullable()->comment('Purchase price');
            $table->enum('acquisition_type', ['pembelian','sumbangan','pemindahan'])->nullable()->comment('Acquisition type');
            $table->string('classification')->nullable()->comment('Classification');
            $table->string('funded_by')->nullable()->comment('Funded by');
            $table->string('supplier_name')->nullable()->comment('Supplier name');
            $table->unsignedBigInteger('created_by')->nullable()->comment('FK to users: created by');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK to users: updated by');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('FK to users: deleted by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('department_id')->references('id')->on('departments')->nullOnDelete();
            $table->foreign('equipment_category_id')->references('id')->on('equipment_categories')->nullOnDelete();
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->nullOnDelete();
            $table->foreign('location_id')->references('id')->on('locations')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();

            $table->index(['equipment_category_id', 'sub_category_id', 'department_id', 'location_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
