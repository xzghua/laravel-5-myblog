<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIphptUserBehavior extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iphpt_user_behavior', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('ip')->comment('ip地址')->nullable();
            $table->integer('port')->comment('端口')->nullable();
            $table->string('browser')->comment('浏览器信息')->nullable();
            $table->text('cookie')->comment('cookie信息')->nullable();
            $table->string('url')->comment('访问的页面地址');
            $table->integer('mobile')->comment('手机号码')->nullable();
            $table->integer('x')->comment('经度')->nullable();
            $table->integer('y')->comment('纬度')->nullable();

            $table->string('address')->comment('地址')->nullable();
            $table->string('province')->comment('省')->nullable();
            $table->string('city')->comment('市')->nullable();
            $table->string('district')->comment('区')->nullable();
            $table->string('street')->comment('街道')->nullable();
            $table->string('street_number')->comment('街道号')->nullable();

            $table->string('system')->comment('系统')->nullable();
            $table->string('take_place')->comment('占位字段')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('iphpt_user_behavior');
    }
}
