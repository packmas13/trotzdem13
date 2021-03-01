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
            ['name' => 'Wölflinge', 'color' => '#ff6400'],
            ['name' => 'Jungpfadfinder', 'color' => '#2f53a7'],
            ['name' => 'Pfadfinder', 'color' => '#00823c'],
            ['name' => 'Rover', 'color' => '#cc1f2f'],
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
