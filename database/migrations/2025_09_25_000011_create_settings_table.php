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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->comment('Setting key, e.g. system.email, notifications.enabled');
            $table->text('value')->nullable()->comment('Setting value (string, JSON, etc)');
            $table->string('type')->default('string')->comment('Value type: string, int, bool, json, etc');
            $table->string('category')->default('general')->comment('Settings category');
            $table->text('description')->nullable()->comment('Description of the setting');
            // Audit fields
            $table->foreignId('created_by')->nullable()->comment('User who created the record')->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->comment('User who last updated the record')->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->comment('User who deleted the record (soft delete)')->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category'], 'settings_category_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
