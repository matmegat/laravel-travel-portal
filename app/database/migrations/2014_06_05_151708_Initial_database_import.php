<?php

use Illuminate\Database\Migrations\Migration;

class InitialDatabaseImport extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared(File::get(app_path().'/database/db.sql'));
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement('drop database '.Config::get('database.connections.mysql.database'));
        DB::statement('create database '.Config::get('database.connections.mysql.database'));
    }
}
