<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIphptTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iphpt_tags', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('art_id')->unsigned(10);
            $table->integer('tag_id')->unsigned(10);

            $table->foreign('art_id')->references('id')->on('iphpt_article');
            $table->foreign('tag_id')->references('id')->on('iphpt_tag');

            $table->primary(['art_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('iphpt_tags');
    }
}
