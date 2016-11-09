<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIphptViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iphpt_view', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('art_id')->comment('文章ID');
            $table->integer('view_num')->default(0)->comment('浏览次数');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('iphpt_views', function (Blueprint $table) {
            //
        });
    }
}
