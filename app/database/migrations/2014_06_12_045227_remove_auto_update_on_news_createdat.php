<?php

use Illuminate\Database\Migrations\Migration;

class RemoveAutoUpdateOnNewsCreatedat extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement('ALTER TABLE news CHANGE created_at created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('ALTER TABLE news CHANGE created_at created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
    }
}
