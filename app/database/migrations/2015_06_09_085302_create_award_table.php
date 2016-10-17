<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAwardTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('awards', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('title');
            $table->string('slug');
            $table->string('short_content');
            $table->string('content');
            $table->boolean('is_draft');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('award_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('award_id');
            $table->boolean('is_primary');
            $table->string('caption');
            $table->timestamps();

            $table->foreign('award_id')->references('id')->on('awards');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('award_photos');
        Schema::drop('awards');
    }
}
