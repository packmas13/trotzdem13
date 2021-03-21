<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TeamChallenge extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_challenge', function (Blueprint $table) {
            $table->bigInteger('challenge_id');
            $table->bigInteger('team_id');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->primary(['team_id', 'challenge_id']);

            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->foreign('team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_challenge');
    }
}
