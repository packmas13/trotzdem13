<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChallengeStufe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenge_stufe', function (Blueprint $table) {
            $table->bigInteger('challenge_id');
            $table->bigInteger('stufe_id');
            $table->timestamps();

            $table->primary(['challenge_id', 'stufe_id']);

            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->foreign('stufe_id')->references('id')->on('stufen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('challenge_stufe');
    }
}
