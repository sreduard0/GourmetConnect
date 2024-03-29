<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('request_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('request_id');
            $table->bigInteger('product_id');
            $table->string('waiter', 255)->nullable();
            $table->decimal('value', 10, 2);
            $table->text('observation')->nullable();
            $table->integer('status');
            $table->integer('payment_method')->nullable();
            $table->integer('print')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('request_items');
    }
};
