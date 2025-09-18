<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_requests', function ($table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('loan_status_id')->constrained('loan_statuses');
            $table->date('request_date');
            $table->date('loan_start_date');
            $table->date('loan_end_date');
            $table->text('purpose')->nullable();
            $table->string('division')->nullable();
            $table->string('department')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
    Schema::dropIfExists('loan_requests');
    }
};
