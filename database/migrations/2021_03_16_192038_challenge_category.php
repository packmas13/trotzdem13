<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChallengeCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenge_category', function (Blueprint $table) {
            $table->bigInteger('challenge_id');
            $table->bigInteger('category_id');
            $table->timestamps();

            $table->primary(['challenge_id', 'category_id']);

            $table->foreign('challenge_id')->references('id')->on('challenges');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
