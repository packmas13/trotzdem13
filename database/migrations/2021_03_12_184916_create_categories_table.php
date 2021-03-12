<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('description', 65536);
            $table->timestamps();
        });

        DB::table('categories')->insert([
            [
                'id' => 1,
                'title' => 'Networking & Identität',
                'description' => 'Was ist dir wichtig? Was macht dich aus? Was sind deine Traditionen? Was machen andere Gruppen gleich? Was anders? Lernt euch kennen. Vernetzt euch. Erlebt das Wir und sei dir deiner selbst bewusst.'
            ],
            [
                'id' => 2,
                'title' => 'Für Geist & Seele',
                'description' => 'Was tut dir gut? Was beschäftigt dich? Was brauchst du? Wie siehst du die Welt? Was kann die Kirche für dich tun? Lass deine Bim Bam Seele Baumeln. Atme ruhig durch die Hose. Lass dich auf Spiritualität ein und von Kirche inspirieren.'
            ],
            [
                'id' => 3,
                'title' => '(Pfadfinderisches) Handwerk',
                'description' => 'Können wir das schaffen? Segen, Hämmern, kleben, tippen, programmieren, spielen, knoten, wegweisen, kleben, sporteln, jurten,… Wir packen an! Hand drauf.'
            ],
            [
                'id' => 4,
                'title' => 'Umwelt & Miteinander',
                'description' => 'Gesellschaftliches, politisches, soziales, Fridays for future, Demokratie – Gemeinsam für ein nachhaltiges Miteinander. Es liegt an dir. Mach mit. Sei dabei. Deine Stimme zählt.'
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
