<?php

use Illuminate\Database\Migrations\Migration;

class PageContentRemoveToursId extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('page_content', function ($table) {
            $table->dropColumn('tours_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('page_content', function ($table) {
            $table->text('tours_id');
        });
    }
}
