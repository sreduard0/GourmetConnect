<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('agenda')->nullable();
            $table->integer('item')->nullable();
            $table->bigInteger('client_id');
            $table->bigInteger('event_id');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
