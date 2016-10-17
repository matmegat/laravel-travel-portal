<?php

use Illuminate\Database\Migrations\Migration;

class CreateTourViews extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("
            CREATE TABLE tours_views (
              `id` int unsigned auto_increment primary key,
              `tour_id` int NOT NULL,
              `ip` int unsigned NOT NULL,
              `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
              `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
              key (tour_id)
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('DROP TABLE tours_views');
    }
}
