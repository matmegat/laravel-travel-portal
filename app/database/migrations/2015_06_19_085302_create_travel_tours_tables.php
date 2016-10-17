<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelToursTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('travel_tour_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('from');
            $table->unsignedInteger('to');
            $table->longText('result');
            $table->double('time');
            $table->timestamps();
        });

        Schema::create('travel_tour_queue', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('from');
            $table->unsignedInteger('to');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('travel_tour_queue');
        Schema::drop('travel_tour_logs');
    }
}
