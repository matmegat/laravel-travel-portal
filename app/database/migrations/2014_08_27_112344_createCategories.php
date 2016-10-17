<?php

use Illuminate\Database\Migrations\Migration;

class createCategories extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("
CREATE TABLE IF NOT EXISTS `travel_countries` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB
        ");

        DB::statement("
CREATE TABLE IF NOT EXISTS `travel_states` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `country_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;
        ");

        DB::statement("
CREATE TABLE IF NOT EXISTS `travel_regions` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `state_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
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
        DB::statement('DROP TABLE IF EXISTS `travel_countries`');
        DB::statement('DROP TABLE IF EXISTS `travel_states`');
        DB::statement('DROP TABLE IF EXISTS `travel_regions`');
    }
}
