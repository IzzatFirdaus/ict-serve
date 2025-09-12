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
        Schema::create('damage_complaints', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('division');
            $table->string('position_grade')->nullable();
            $table->string('email');
            $table->string('phone_number');
            $table->string('damage_type');
            $table->string('asset_number')->nullable();
            $table->text('damage_info');
            $table->enum('status', ['submitted', 'in_progress', 'resolved', 'closed'])->default('submitted');
            $table->timestamp('resolved_at')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->string('assigned_technician')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('division');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('damage_complaints');
    }
};
