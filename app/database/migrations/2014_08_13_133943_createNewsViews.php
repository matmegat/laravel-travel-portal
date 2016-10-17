<?php

use Illuminate\Database\Migrations\Migration;

class createNewsViews extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("
CREATE TABLE IF NOT EXISTS `news_views` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `ip` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=InnoDB
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('DROP TABLE IF EXISTS `news_views`');
    }
}
