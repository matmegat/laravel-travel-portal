<?php

use Illuminate\Database\Migrations\Migration;

class addedJ6ToursPull extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("
CREATE TABLE IF NOT EXISTS `j6_tours` (
  `id` int(10) unsigned NOT NULL,
  `country` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB
        ");

        DB::statement("
CREATE TABLE IF NOT EXISTS `tour_pull_queue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_id` int(11) DEFAULT NULL,
  `to_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('DROP TABLE `j6_tours`');
        DB::statement('DROP TABLE `tour_pull_queue`');
    }
}
