<?php

use Illuminate\Database\Migrations\Migration;

class addApiTypeToPopularTours extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("alter table tours_views add api enum('j6', 'travel')");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('alter table tours_views drop api');
    }
}
