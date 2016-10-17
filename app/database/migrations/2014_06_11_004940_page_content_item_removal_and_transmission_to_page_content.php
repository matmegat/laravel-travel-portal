<?php

use Illuminate\Database\Migrations\Migration;

class PageContentItemRemovalAndTransmissionToPageContent extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::drop('page_content_item');

        // Adventures page - id=1
        $page = PageContent::where('page_id', '=', 1)->first();

        $page->title = 'Adventure Park';
        $page->content = 'Swim amongst the dugongs, reef sharks and sea turtles on a Visits Great Barrier Reef adventure. Travel on board a purpose built catamaran then dive into the depths of this natural wonder. Scuba diving and snorkeling is available for all. Our professional and friendly staff will show you how it’s done.';
        $page->keywords = 'adventure, park';
        $page->description = 'Adventure Park - Swim amongst the dugongs, reef sharks and sea turtles on a Visits Great Barrier Reef adventure';
        $page->save();

        // Diving & Sailing Tours page - id=2
        $page = PageContent::where('page_id', '=', 2)->first();

        $page->title = 'Diving & Sailing Tours';
        $page->content = 'Swim amongst the dugongs, reef sharks and sea turtles on a Visits Great Barrier Reef adventure. Travel on board a purpose built catamaran then dive into the depths of this natural wonder. Scuba diving and snorkeling is available for all. Our professional and friendly staff will show you how it’s done.';
        $page->keywords = 'diving, sailing';
        $page->description = 'Diving & Sailing Tours - Swim amongst the dugongs, reef sharks and sea turtles on a Visits Great Barrier Reef adventure';
        $page->save();

        // Australia tours page - id=3
        $page = PageContent::where('page_id', '=', 3)->first();

        $page->title = 'Australia Tours';
        $page->content = 'The incredible natural environment of Australia has always been important to its inhabitants. The Aboriginal people of Australia, whose diverse clans have long lived throughout Australia, whether in mountain ranges, deserts or coastlines, foster a special connection with the Australian landscape.';
        $page->keywords = 'australia, tours';
        $page->description = 'Australia Tours - The incredible natural environment of Australia has always been important to its inhabitants.';
        $page->save();

        // Hotels page - id=4
        $page = PageContent::where('page_id', '=', 4)->first();

        $page->title = 'Hotels';
        $page->content = 'The incredible natural environment of Australia has always been important to its inhabitants. The Aboriginal people of Australia, whose diverse clans have long lived throughout Australia, whether in mountain ranges, deserts or coastlines, foster a special connection with the Australian landscape.';
        $page->keywords = 'hotels, natural';
        $page->description = 'Hotels - The incredible natural environment of Australia has always been important to its inhabitants.';
        $page->save();

        // Flights page - id=5
        $page = PageContent::where('page_id', '=', 5)->first();

        $page->title = 'Flights';
        $page->content = 'Build your own itinerary to suit your travel needs. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aliquam erat volutpat. Suspendisse condimentum nisl nunc, eu mattis mauris lacinia id. Suspendisse vulputate, neque eget hendrerit luctus, nunc odio dictum ipsum, a vestibulum nunc sapien nec odio.';
        $page->keywords = 'flights, travel';
        $page->description = 'Flights - Build your own itinerary to suit your travel needs.';
        $page->save();

        // Visits Holiday Adventures page - id=6
        $page = PageContent::where('page_id', '=', 6)->first();

        $page->title = 'Visits Holiday Adventures';
        $page->content = 'Vestibulum sed elementum nisl, vitae congue dui. Integer interdum nisi eu odio pulvinar aliquam. Aenean ultrices, odio vitae suscipit congue, mi neque elementum neque, vel lobortis elit erat nec turpis. Nam mollis sem nec nulla faucibus consectetur. Nullam molestie sit amet tellus ac scelerisque. Suspendisse in dictum dolor, ut tincidunt ligula. Nulla fringilla vitae erat nec ultrices. Praesent et tellus vitae lacus ullamcorper ultrices eget vel lacus. Vivamus faucibus elit orci, at molestie erat aliquam ac. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Proin eleifend eget risus ac consectetur.';
        $page->keywords = 'Visits, Holiday, Adventures';
        $page->description = 'Visits Holiday Adventures';
        $page->save();

        // Travel Advice page - id=7
        $page = PageContent::where('page_id', '=', 7)->first();

        $page->title = 'Travel Advice';
        $page->content = 'Vestibulum sed elementum nisl, vitae congue dui. Integer interdum nisi eu odio pulvinar aliquam. Aenean ultrices, odio vitae suscipit congue, mi neque elementum neque, vel lobortis elit erat nec turpis. Nam mollis sem nec nulla faucibus consectetur. Nullam molestie sit amet tellus ac scelerisque. Suspendisse in dictum dolor, ut tincidunt ligula. Nulla fringilla vitae erat nec ultrices. Praesent et tellus vitae lacus ullamcorper ultrices eget vel lacus. Vivamus faucibus elit orci, at molestie erat aliquam ac. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Proin eleifend eget risus ac consectetur.';
        $page->keywords = 'Travel Advice';
        $page->description = 'Travel Advice';
        $page->save();

        // Australia tours page - id=8
        $page = PageContent::where('page_id', '=', 8)->first();

        $page->title = 'Contact Visits';
        $page->content = 'Vestibulum sed elementum nisl, vitae congue dui. Integer interdum nisi eu odio pulvinar aliquam. Aenean ultrices, odio vitae suscipit congue, mi neque elementum neque, vel lobortis elit erat nec turpis. Nam mollis sem nec nulla faucibus consectetur. Nullam molestie sit amet tellus ac scelerisque. Suspendisse in dictum dolor, ut tincidunt ligula. Nulla fringilla vitae erat nec ultrices. Praesent et tellus vitae lacus ullamcorper ultrices eget vel lacus. Vivamus faucibus elit orci, at molestie erat aliquam ac. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Proin eleifend eget risus ac consectetur.';
        $page->keywords = 'Contact Visits';
        $page->description = 'Contact Visits';
        $page->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $dump = <<<EOF
            DROP TABLE IF EXISTS `page_content_item`;
            CREATE TABLE `page_content_item` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `page_id` int(11) NOT NULL,
              `tours_id` text COLLATE utf8_unicode_ci NOT NULL,
              `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
              `content` text COLLATE utf8_unicode_ci NOT NULL,
              `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

            LOCK TABLES `page_content_item` WRITE;
            INSERT INTO `page_content_item` VALUES (1,1,'5324,5476','Adventure Park','Swim amongst the dugongs, reef sharks and sea turtles on a Visits Great Barrier Reef adventure. Travel on board a purpose built catamaran then dive into the depths of this natural wonder. Scuba diving and snorkeling is available for all. Our professional and friendly staff will show you how it’s done.','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,2,'4893,4888','Diving & Sailing Tours','Swim amongst the dugongs, reef sharks and sea turtles on a Visits Great Barrier Reef adventure. Travel on board a purpose built catamaran then dive into the depths of this natural wonder. Scuba diving and snorkeling is available for all. Our professional and friendly staff will show you how it’s done.','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,3,'0','Australia Tours','The incredible natural environment of Australia has always been important to its inhabitants. The Aboriginal people of Australia, whose diverse clans have long lived throughout Australia, whether in mountain ranges, deserts or coastlines, foster a special connection with the Australian landscape.','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,4,'0','Hotels','The incredible natural environment of Australia has always been important to its inhabitants. The Aboriginal people of Australia, whose diverse clans have long lived throughout Australia, whether in mountain ranges, deserts or coastlines, foster a special connection with the Australian landscape.','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,5,'0','Flights','Build your own itinerary to suit your travel needs.\r\nClass aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Aliquam erat volutpat. Suspendisse condimentum nisl nunc, eu mattis mauris lacinia id. Suspendisse vulputate, neque eget hendrerit luctus, nunc odio dictum ipsum, a vestibulum nunc sapien nec odio.','0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,6,'0','Visits Holiday Adventures','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,7,'0','Travel Advice','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(8,8,'0','Contact Visits','','0000-00-00 00:00:00','0000-00-00 00:00:00');
            UNLOCK TABLES;
EOF;

        DB::unprepared($dump);
    }
}
