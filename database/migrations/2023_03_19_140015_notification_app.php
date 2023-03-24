<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notification', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('notify');
            $table->string('type', 100);
            $table->string('title', 255)->nullable();
            $table->text('messege')->nullable();
            $table->string('size', 255)->nullable();
            $table->integer('centervertical')->nullable();
            $table->integer('user_destination')->nullable();
            $table->integer('request_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notification');
    }
};
