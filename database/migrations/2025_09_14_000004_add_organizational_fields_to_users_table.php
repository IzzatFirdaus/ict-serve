<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('identification_number')->nullable()->after('id');
            $table->string('mobile_number')->nullable()->after('email');
            $table->string('status')->default('active')->after('mobile_number');
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete()->after('status');
            $table->foreignId('grade_id')->nullable()->constrained('grades')->nullOnDelete()->after('department_id');
            $table->foreignId('position_id')->nullable()->constrained('positions')->nullOnDelete()->after('grade_id');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->after('position_id');
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete()->after('created_by');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete()->after('updated_by');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'identification_number',
                'mobile_number',
                'status',
                'department_id',
                'grade_id',
                'position_id',
                'created_by',
                'updated_by',
                'deleted_by',
                'deleted_at',
            ]);
        });
    }
};
