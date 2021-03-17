<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DeleteStufenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('team_user')->truncate();
        Schema::dropIfExists('teams'); // needs to be re-created because of sqlite

        Schema::dropIfExists('stufen');
        Schema::dropIfExists('staemme');
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('image', 255)->default('');
            $table->bigInteger('leader_id');
            $table->bigInteger('troop_id');
            $table->bigInteger('banner_id');
            $table->integer('size');
            $table->json('location');
            $table->integer('radius');
            $table->string('join_code', 255)->unique();
            $table->timestamp('approved_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('leader_id')->references('id')->on('users');
            $table->foreign('troop_id')->references('id')->on('troops');
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
        throw new \Exception("yolo", 1);
    }
}
