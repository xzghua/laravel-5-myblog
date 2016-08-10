<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIphptCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iphpt_comment', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('username',50);
            $table->string('email',50);
            $table->integer('parent_id')->default(0);
            $table->text('content');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('iphpt_comment');
    }
}
