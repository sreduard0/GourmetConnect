<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('login_client', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('active');
            $table->string('login', 255);
            $table->string('password', 255);
            $table->integer('verify_error');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('login_client');
    }
};
