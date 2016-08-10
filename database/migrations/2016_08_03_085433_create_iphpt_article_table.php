<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIphptArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iphpt_article', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->softDeletes();
            $table->timestamps();
            $table->string('title')->comment('文章名');
            $table->text('content')->comment('文章内容');//文章内容
            $table->integer('user_id')->comment('作者ID');//作者ID
            $table->integer('password')->comment('阅读密码')->nullable();//阅读密码
            $table->integer('read_status')->default(1)->comment('阅读状态');//阅读状态
            $table->integer('desc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('iphpt_article');
    }
}
