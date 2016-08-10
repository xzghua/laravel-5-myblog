<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIphptNavigationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iphpt_navigation', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('nav_name',30)->comment('导航名')->default('叶落山城')->nullable();
            $table->string('links')->comment('链接')->default('http://iphpt.com')->nullable();
            $table->integer('parent_id')->comment('父ID')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('iphpt_navigation');
    }
}
