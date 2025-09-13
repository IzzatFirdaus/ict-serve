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
        Schema::table('users', function (Blueprint $table) {
            $table->string('staff_id')->unique()->after('id');
            $table->string('division')->after('name');
            $table->string('department')->after('division');
            $table->string('position')->after('department');
            $table->string('phone', 20)->nullable()->after('position');
            $table->enum('role', ['user', 'supervisor', 'ict_admin', 'helpdesk_staff', 'super_admin'])
                ->default('user')->after('phone');
            $table->foreignId('supervisor_id')->nullable()->constrained('users')->after('role');
            $table->boolean('is_active')->default(true)->after('supervisor_id');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['supervisor_id']);
            $table->dropColumn([
                'staff_id',
                'division',
                'department',
                'position',
                'phone',
                'role',
                'supervisor_id',
                'is_active',
                'last_login_at',
            ]);
        });
    }
};
