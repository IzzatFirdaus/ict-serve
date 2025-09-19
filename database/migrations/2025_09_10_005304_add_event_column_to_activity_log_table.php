<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEventColumnToActivityLogTable extends Migration
{
    public function up()
    {
        // No-op: event column already exists in the original create_activity_log_table migration
        // This migration was redundant after merge - the column is already defined in 2025_09_10_005303_create_activity_log_table.php
    }

    public function down()
    {
        // No-op: event column is part of the original table creation, should not be dropped
    }
}
