<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('color', 255);
        });

        DB::table('banners')->insert([
            ['name' => 'Wölflingsbanner', 'color' => 'woelfling'],
            ['name' => 'Jupfibanner', 'color' => 'jupfi'],
            ['name' => 'Pfadibanner', 'color' => 'pfadi'],
            ['name' => 'Roverbanner', 'color' => 'rover'],
            ['name' => 'Lilienbanner', 'color' => 'lilie'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
