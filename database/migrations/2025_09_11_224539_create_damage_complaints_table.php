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
            $table->string('asset_number')->nullable();
            $table->string('complainant_name');
            $table->string('complainant_division');
            $table->string('complainant_position')->nullable();
            $table->string('contact_number');
            $table->string('email');
            $table->string('damage_type');
            $table->text('damage_description');
            $table->date('incident_date')->nullable();
            $table->string('incident_time')->nullable();
            $table->string('location')->nullable();
            $table->string('priority')->default('medium');
            $table->string('status')->default('submitted');
            $table->foreignId('technician_assigned')->nullable()->constrained('users');
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->decimal('estimated_cost', 10, 2)->nullable();
            $table->decimal('actual_cost', 10, 2)->nullable();
            $table->json('photos')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('complainant_division');
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
