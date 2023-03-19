<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('request_additional_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('additional_id');
            $table->bigInteger('item_id');
            $table->decimal('value', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('request_additional_items');
    }
};
