<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DefineOrgaTeam extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $root_id = User::firstOrCreate(['id' => 1], [
            'name' => 'root',
            'email' => 'trotzdem13.web@dpsg1300.de',
            'password' => '',
        ])->id;
        DB::table('teams')->insert([
            [
                'id' => 42,
                'name' => 'Orga-Team',
                'leader_id' => $root_id,
                'troop_id' => 130000,
                'banner_id' => 5,
                'size' => 10,
                'location' => '{"lat":"48.13206","lng":"11.60278"}',
                'radius' => 1000,
                'join_code' => Str::lower(Str::random(18))
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
