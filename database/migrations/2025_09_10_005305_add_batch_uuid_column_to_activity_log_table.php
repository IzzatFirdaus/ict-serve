<?php

use Illuminate\Database\Migrations\Migration;

class AddBatchUuidColumnToActivityLogTable extends Migration
{
    public function up()
    {
        // No-op: batch_uuid column already exists in the original create_activity_log_table migration
        // This migration was redundant after merge - the column is already defined in 2025_09_10_005303_create_activity_log_table.php
    }

    public function down()
    {
        // No-op: batch_uuid column is part of the original table creation, should not be dropped
    }
}
