<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('verify_code', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 255);
            $table->bigInteger('user_id');
            $table->string('device');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
