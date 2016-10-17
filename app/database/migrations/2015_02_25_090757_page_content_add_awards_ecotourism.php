<?php

use Illuminate\Database\Migrations\Migration;

class PageContentAddAwardsEcotourism extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $pageName = new PageName();
        $pageName->name = 'AWARDS';
        $pageName->save();

        $pageName = new PageName();
        $pageName->name = 'ECO TOURISM';
        $pageName->save();

        $pageContent = new PageContent();
        $pageContent->page_id = 11;
        $pageContent->title = 'Awards';
        $pageContent->content = 'Awards';
        $pageContent->sub_title = 'Awards';
        $pageContent->keywords = 'Awards';
        $pageContent->description = 'Awards';
        $pageContent->save();

        $pageContent = new PageContent();
        $pageContent->page_id = 12;
        $pageContent->title = 'Eco Tourism';
        $pageContent->content = 'Eco Tourism';
        $pageContent->sub_title = 'Eco Tourism';
        $pageContent->keywords = 'Eco Tourism';
        $pageContent->description = 'Eco Tourism';
        $pageContent->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        PageName::where('id', 11)->delete();
        PageName::where('id', 12)->delete();
        PageContent::where('page_id', 11)->delete();
        PageContent::where('page_id', 12)->delete();
    }
}
