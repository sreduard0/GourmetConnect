<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('table')->nullable();
            $table->string('client_name', 255);
            $table->integer('client_id')->nullable();
            $table->integer('status');
            $table->integer('payment_method')->nullable();
            $table->integer('delivery')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('requests');
    }
};
