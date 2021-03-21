<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BannerChallenge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_challenge', function (Blueprint $table) {
            $table->bigInteger('challenge_id');
            $table->bigInteger('banner_id');

            $table->primary(['challenge_id', 'banner_id']);

            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->foreign('banner_id')->references('id')->on('banners');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banner_challenge');
    }
}
