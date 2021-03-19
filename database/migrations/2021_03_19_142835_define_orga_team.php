<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DefineOrgaTeam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->insert([
            [
                'id' => 42,
                'name' => 'Administrator',
                'email' => 'trotzdem13@dpsg1300.de',
                'password' => '$2y$10$5sQe9Rp4s7dOan9lxMj2UObERszOMjQxCvjBujPbITmSFQvDykTvu' // Un7K%II+hC9XlCRV
            ],
        ]);

        DB::table('teams')->insert([
            [
                'id' => 42,
                'name' => 'Orga-Team',
                'leader_id' => 42,
                'troop_id' => 130000,
                'banner_id' => 5,
                'size' => 10,
                'location' => '{"lat":"48.13206","lng":"11.60278"}',
                'radius' => 1000,
                'join_code' => 't13orga'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('teams')->delete(42);
        DB::table('users')->delete(42);
    }
}
