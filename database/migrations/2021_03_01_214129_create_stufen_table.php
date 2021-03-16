<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStufenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stufen', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('color', 255);
        });

        DB::table('stufen')->insert([
            ['name' => 'Wölflinge', 'color' => 'woelfling'],
            ['name' => 'Jungpfadfinder', 'color' => 'jupfi'],
            ['name' => 'Pfadfinder', 'color' => 'pfadi'],
            ['name' => 'Rover', 'color' => 'rover'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stufen');
    }
}
