<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSlugToNewsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('slug')->after('title');
        });

        $newses = News::withTrashed()->get();
        foreach ($newses as $news) {
            $news->slug = Str::slug($news->title);
            $news->save();
        }

        Schema::table('news', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
