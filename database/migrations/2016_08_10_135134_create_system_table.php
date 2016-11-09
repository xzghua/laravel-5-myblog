<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system', function (Blueprint $table) {
            $table->increments('id');
            $table->string('theme')->default('default')->comment('主题');
            $table->string('title')->default('叶落山城秋')->comment('标题')->nullable();
            $table->string('s_title')->default('叶落山城秋')->comment('副标题')->nullable();
            $table->string('description')->default('叶落山城秋的个人博客')->comment('描述')->nullable();
            $table->string('seo_key')->default('叶落山城秋的个人博客')->comment('seo关键词')->nullable();
            $table->string('seo_des')->default('叶落山城秋的个人博客')->comment('seo描述')->nullable();
            $table->string('record_number')->default('叶落山城秋的个人博客')->comment('备案号')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('system');
    }
}
