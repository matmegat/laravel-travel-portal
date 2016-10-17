<?php

use Illuminate\Database\Migrations\Migration;

class addBackroundPage extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement('
            ALTER TABLE page_content ADD backgroundUrl VARCHAR (255)
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('
            ALTER TABLE page_content DROP backgroundUrl
        ');
    }
}
