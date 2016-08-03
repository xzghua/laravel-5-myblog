<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIphptCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iphpt_category', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('cate_name')->comment('分类名');
            $table->string('as_name')->comment('别名');
            $table->integer('parent_id')->default(0)->comment('分类的父ID');
            $table->string('seo_desc')->nullable()->comment('seo用的描述');
            $table->string('seo_name')->nullable()->comment('seo 用的名字');
            $table->string('seo_title')->nullable()->comment('seo用的标题');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('iphpt_category');
    }
}
