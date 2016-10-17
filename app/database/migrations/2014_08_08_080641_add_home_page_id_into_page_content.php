<?php

use Illuminate\Database\Migrations\Migration;

class AddHomePageIdIntoPageContent extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $pageContent = new PageContent();
        $pageContent->page_id = 10;
        $pageContent->title = 'Visits Adventures';
        $pageContent->content = 'Visits Adventures';
        $pageContent->sub_title = 'Visits Adventures';
        $pageContent->keywords = 'Visits Adventures';
        $pageContent->description = 'Visits Adventures';
        $pageContent->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        PageContent::where('page_id', 10)->delete();
    }
}
