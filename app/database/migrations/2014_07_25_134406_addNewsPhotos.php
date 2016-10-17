<?php

use Illuminate\Database\Migrations\Migration;

class addNewsPhotos extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("
CREATE TABLE IF NOT EXISTS `news_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_primary` tinyint(4) NOT NULL DEFAULT '0',
  `caption` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('
            DROP TABLE news_photos
        ');
    }
}
