<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->bigInteger('leader_id');
            $table->bigInteger('stamm_id');
            $table->bigInteger('stufe_id');
            $table->integer('size');
            $table->json('location');
            $table->integer('radius');
            $table->string('join_code', 255)->unique();
            $table->timestamp('approved_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('leader_id')->references('id')->on('users');
            $table->foreign('stamm_id')->references('id')->on('staemme');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
