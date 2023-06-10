<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('logo_url', 255)->nullable();
            $table->string('establishment_name', 255)->nullable();
            $table->string('establishment_legal_name', 255)->nullable();
            $table->string('cnpj', 14)->nullable();
            $table->string('address', 255)->nullable();
            $table->integer('number')->nullable();
            $table->string('neighborhood', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('state', 3)->nullable();
            $table->string('theme_background', 255)->nullable();
            $table->string('theme_accent', 255)->nullable();
            $table->string('theme_sidebar', 255)->nullable();
            $table->string('mailer_host', 255)->nullable();
            $table->integer('mailer_port')->nullable();
            $table->string('mailer_encryption', 4)->nullable();
            $table->string('mailer_email', 255)->nullable();
            $table->string('mailer_password', 255)->nullable();
            $table->integer('number_tables')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('app_settings');
    }
};
