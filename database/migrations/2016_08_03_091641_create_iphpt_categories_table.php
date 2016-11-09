<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIphptCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iphpt_categories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('art_id')->unsigned(10);
            $table->integer('cate_id')->unsigned(10);

            $table->foreign('art_id')->references('id')->on('iphpt_article');
            $table->foreign('cate_id')->references('id')->on('iphpt_category');

            $table->primary(['art_id', 'cate_id']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('iphpt_categories');
    }
}
