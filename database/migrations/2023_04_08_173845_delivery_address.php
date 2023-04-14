<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('delivery_address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('delivered')->default(0);
            $table->integer('request_id');
            $table->integer('location_id');
            $table->string('recipient_name', 255);
            $table->string('street_address', 255);
            $table->string('neighborhood', 255);
            $table->string('reference', 255);
            $table->integer('number');
            $table->decimal('delivery_value', 10, 2);
            $table->bigInteger('phone');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_address');
    }
};
