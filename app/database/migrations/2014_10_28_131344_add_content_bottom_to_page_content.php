<?php

use Illuminate\Database\Migrations\Migration;

class AddContentBottomToPageContent extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement('alter table page_content add content_bottom_title varchar(255) after content');
        DB::statement('alter table page_content add content_bottom text after content_bottom_title');

        $title = 'Award Winning Tours';

        $content = "
<p>Visits Whitsunday Adventures is an Australian owned and operated, multi award winning advanced Eco certified tour operator. Visits is based in Airlie Beach, Queensland. Airlie Beach provides the perfect access point for Whitsunday Island holiday adventures and Whitsunday Hinterland tours maintaining our environment with our advanced economical methods designed to minimise environmental impact. Visits operates sailing, scuba diving tours, and mini 4WD tours around the Whitsundays. Travel to Whitehaven Beach and explore the beautiful white sands, scuba dive amongst the aquatic wildlife, sail across Australia\'s magnificent blue waters, visit the adventure park for native wildlife, scenic trails and loads of fun in the mud.</p>

<p>Stop dreaming about a tropical island getaway and actually get on board a Visits Sailing Adventure. Learn to sail a luxury catamaran with the help of Visits\' friendly crew, or relax on board, enjoying catered meals, hot showers and a surround sound entertainment system. Visits offers sailing adventures to suit different budgets or lengths of holidays. The Emperors Visits sailing tour travels out to the Outer Great Barrier Reef so you can really make the most of your Whitsunday Islands sailing adventure.</p>

<p>Visits Whitsunday Islands adventures offer the best in scuba diving and sailing adventures. Travelling to Bait Reef, you can explore the most magical Great Barrier Reef scuba diving destination. Visiting Whitehaven Beach, you can discover the iconic white sands which have become famous across the world as the epitome of tropical escape.  You can even learn to scuba dive as part of your tropical adventure.</p>

<p>Scuba dive amongst the unique aquatic wildlife of Australia’s natural wonder, the Great Barrier Reef. Visits offers a number of diving adventure tours from overnight holidays to tours traveling out to Bait Reef. Certified divers can enjoy night dives while beginner divers can enjoy Visits learn to scuba dive options. Visits offers PADI diving courses for those with no diving experience or those wishing to improve their diving knowledge. Snorkelling is also available on all tours, so everyone can discover the magic of Great Barrier Reef diving.</p>

<p>The Whitsunday Tourism Awards are the region’s premier tourism event, established to pay tribute to the enormous contribution made by the region’s tourism operators and service providers and to encourage excellence within the Whitsunday tourism industry. Visits Diving Adventures has won awards twice: 2010 Adventure Tourism and 2011 Steve Irwin Ecotourism Award.</p>
";

        DB::statement("
update page_content set
  content_bottom = '".trim($content)."',
  content_bottom_title = '".trim($title)."'
  ");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
    }
}
