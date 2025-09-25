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
        // Users table: stores user accounts and staff details
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->comment('User title (e.g., Mr, Ms, Dr)');
            $table->string('name')->comment('Full name');
            $table->string('identification_number')->unique()->comment('IC number');
            $table->string('passport_number')->nullable()->comment('Passport number');
            $table->string('profile_photo_path')->nullable()->comment('Profile photo path');
            $table->unsignedBigInteger('position_id')->nullable()->comment('FK to positions');
            $table->unsignedBigInteger('grade_id')->nullable()->comment('FK to grades');
            $table->unsignedBigInteger('department_id')->nullable()->comment('FK to departments');
            $table->string('level')->nullable()->comment('User level');
            $table->string('mobile_number')->nullable()->comment('Mobile number');
            $table->string('email')->unique()->comment('Email address');
            $table->string('password')->comment('Password hash');
            $table->enum('status', ['aktif','tidak_aktif','digantung'])->default('aktif')->comment('Account status');
            $table->timestamp('email_verified_at')->nullable();
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();
            $table->rememberToken();
            $table->unsignedBigInteger('created_by')->nullable()->comment('FK to users: created by');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK to users: updated by');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('FK to users: deleted by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('position_id')->references('id')->on('positions')->nullOnDelete();
            $table->foreign('grade_id')->references('id')->on('grades')->nullOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();

            $table->index(['department_id', 'grade_id', 'position_id', 'status']);
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
