<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users_app', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('login_id');
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('email', 255);
            $table->bigInteger('phone');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_app');
    }
};
