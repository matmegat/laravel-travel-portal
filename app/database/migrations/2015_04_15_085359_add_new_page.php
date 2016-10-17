<?php

use Illuminate\Database\Migrations\Migration;

class AddNewPage extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $page = new PageContent();
        $page->page_id = 13;
        $page->title = 'Sailing and Snorkelling';
        $page->sub_title = '';
        $page->content = 'Swim amongst the dugongs, reef sharks and sea turtles on a Visits Great Barrier Reef adventure. Travel on board a purpose built catamaran then dive into the depths of this natural wonder. Swimming and snorkelling is available for all. Our professional and friendly staff will show you how it’s done.';
        $page->keywords = 'snorkelling, sailing';
        $page->description = 'Snorkelling & Sailing Tours - Swim amongst the dugongs, reef sharks and sea turtles on a Visits Great Barrier Reef adventure';
        $page->backgroundUrl = null;
        $page->save();

        $page = new PageName();
        $page->name = 'SAILING AND SNORKELLING';
        $page->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        /** @var PageContent $delete */
        $delete = PageContent::find(13);
        $delete->delete();

        /** @var PageContent $delete */
        $delete = PageName::find(13);
        $delete->delete();
    }
}
