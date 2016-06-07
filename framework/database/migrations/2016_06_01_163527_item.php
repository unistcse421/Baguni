<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Item extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image_ext');
            $table->integer('uploader');
            $table->integer('buyer_id');
            $table->integer('seller_id');
            $table->integer('price');
            $table->string('status');
            $table->string('title');
            $table->string('contents');
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('reg_time');
            $table->timestamp('zim_time');
            $table->timestamp('inpro_time');
            $table->timestamp('baguni_time');
            $table->timestamp('done_time');
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
        Schema::drop('item');
    }
}
