<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTroopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('troops', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
        });

        DB::table('troops')->insert([
            ['id' => 130000, 'name' => 'Diözesanverband München und Freising '],

            ['id' => 131200, 'name' => 'Bezirk München-Isar'],
            ['id' => 131202, 'name' => 'Hl. Engel'],
            ['id' => 131203, 'name' => 'St. Severin'],
            ['id' => 131204, 'name' => 'Mariahilf'],
            ['id' => 131206, 'name' => 'Pater Rupert Mayer'],
            ['id' => 131207, 'name' => 'Maximilian Kolbe'],
            ['id' => 131208, 'name' => 'St. Ansgar'],
            ['id' => 131209, 'name' => 'Frieden Christi'],
            ['id' => 131210, 'name' => 'Swapingo'],
            ['id' => 131212, 'name' => 'St. Anna'],
            ['id' => 131213, 'name' => 'St. Canisius'],
            ['id' => 131214, 'name' => 'Hl. Kreuz'],

            ['id' => 131300, 'name' => 'Bezirk München-Ost'],
            ['id' => 131302, 'name' => 'Ottobrunn'],
            ['id' => 131304, 'name' => 'Camilo Torres'],
            ['id' => 131305, 'name' => 'Galileo Galilei'],
            ['id' => 131306, 'name' => 'Unterhaching 1'],
            ['id' => 131307, 'name' => 'Columbus'],
            ['id' => 131308, 'name' => 'Condor'],
            ['id' => 131309, 'name' => 'Arche Noah'],
            ['id' => 131312, 'name' => 'St. Michael Perlach'],

            ['id' => 131400, 'name' => 'Bezirk Würm - Amper'],
            ['id' => 131401, 'name' => 'St. Peter und Paul'],
            ['id' => 131402, 'name' => 'St. Magdalena'],
            ['id' => 131403, 'name' => 'St. Hildegard und Maria'],
            ['id' => 131404, 'name' => 'Parsberg'],
            ['id' => 131405, 'name' => 'St. Johann Baptist'],
            ['id' => 131406, 'name' => 'Bison'],
            ['id' => 131408, 'name' => 'Anjo II'],
            ['id' => 131409, 'name' => 'Oscar A. Romero'],
            ['id' => 131413, 'name' => 'St. Willibald'],
            ['id' => 131414, 'name' => 'St. Rupert'],
            // ['id' => 131415, 'name' => 'St. Marold'],

            ['id' => 131500, 'name' => 'Bezirk Freising'],
            ['id' => 131501, 'name' => 'Freising'],
            ['id' => 131503, 'name' => 'St. Kastulus'],
            ['id' => 131506, 'name' => 'Wolfsspur'],

            ['id' => 131600, 'name' => 'Bezirk Ruperti-Mühldorf'],
            ['id' => 131601, 'name' => 'St. Rupert'],
            ['id' => 131602, 'name' => 'Tilly'],
            ['id' => 131604, 'name' => 'St. Christopherus'],
            ['id' => 131605, 'name' => 'Mariä Himmelfahrt'],
            ['id' => 131606, 'name' => 'Don Bosco'],
            ['id' => 131608, 'name' => 'Stoabock'],
            ['id' => 131611, 'name' => 'Steinadler'],

            ['id' => 131700, 'name' => 'Bezirk Ebersberg'],
            ['id' => 131701, 'name' => 'Marinus'],
            ['id' => 131703, 'name' => 'St. Joseph'],
            ['id' => 131705, 'name' => 'Windrose'],
            ['id' => 131708, 'name' => 'St. Sebastian'],
            ['id' => 131709, 'name' => 'Impeesa'],

            ['id' => 131900, 'name' => 'Bezirk Rosenheim'],
            ['id' => 131901, 'name' => 'Adler'],
            ['id' => 131902, 'name' => 'Prutting'],
            ['id' => 131903, 'name' => 'St. Michael'],
            ['id' => 131904, 'name' => 'Mountain Scouts'],
            ['id' => 131906, 'name' => 'Christkönig'],
            ['id' => 131908, 'name' => 'St. Josef der Arbeiter'],
            ['id' => 131910, 'name' => 'Bad Aibling, St. Franziskus'],
            ['id' => 131911, 'name' => 'Kolbermoor, St. Franziskus'],
            ['id' => 131912, 'name' => 'Phoenix'],
            ['id' => 131913, 'name' => 'St. Christophorus'],
            ['id' => 131915, 'name' => 'St. Quirinus'],

            ['id' => 132000, 'name' => 'Bezirk Oberland'],
            ['id' => 132001, 'name' => 'St. Laurentius'],
            ['id' => 132003, 'name' => 'Ägypten'],
            ['id' => 132005, 'name' => 'St. Sixtus'],
            ['id' => 132006, 'name' => 'St. Vitus'],
            ['id' => 132008, 'name' => 'Dominikus Savio'],
            ['id' => 132010, 'name' => 'Bad Tölz'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('troops');
    }
}
