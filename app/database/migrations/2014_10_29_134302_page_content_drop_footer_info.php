<?php

use Illuminate\Database\Migrations\Migration;

class PageContentDropFooterInfo extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement('alter table page_content drop content_bottom_title, drop content_bottom');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
    }
}
