<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIphptCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iphpt_comments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('art_id')->unsigned(10);
            $table->integer('comment_id')->unsigned(10);

            $table->foreign('art_id')->references('id')->on('iphpt_article');
            $table->foreign('comment_id')->references('id')->on('iphpt_comment');

            $table->primary(['art_id', 'comment_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('iphpt_comments');
    }
}
