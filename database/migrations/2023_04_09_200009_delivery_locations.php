<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('delivery_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('neighborhood', 255);
            $table->string('reference', 255);
            $table->decimal('value_delivery', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('delivery_locations');
    }
};
