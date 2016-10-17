<?php

use Illuminate\Database\Migrations\Migration;

class UpdatedToursManage extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement('alter table page_tour change tour_id tour_id varchar(16) not null');
        DB::statement('alter table page_tour add account varchar(16) not null');
        DB::statement("insert into page_name set id = 10, name = 'HOME'");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
    }
}
