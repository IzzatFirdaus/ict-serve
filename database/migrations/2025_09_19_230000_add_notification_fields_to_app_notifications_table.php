<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('app_notifications', function (Blueprint $table) {
            $table->string('category')->default('general')->after('data');
            $table->string('priority')->default('medium')->after('category');
            $table->string('icon')->nullable()->after('priority');
            $table->string('color')->nullable()->after('icon');
            $table->timestamp('expires_at')->nullable()->after('color');
        });
    }

    public function down(): void
    {
        Schema::table('app_notifications', function (Blueprint $table) {
            $table->dropColumn(['category', 'priority', 'icon', 'color', 'expires_at']);
        });
    }
};
