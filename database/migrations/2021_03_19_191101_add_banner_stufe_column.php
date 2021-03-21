<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBannerStufeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('stufe', 255)->default('');
        });

        DB::table('banners')
            ->where('id', 1)
            ->update(['stufe' => 'Wölflinge']);

        DB::table('banners')
            ->where('id', 2)
            ->update(['stufe' => 'Jupfis']);

        DB::table('banners')
            ->where('id', 3)
            ->update(['stufe' => 'Pfadis']);

        DB::table('banners')
            ->where('id', 4)
            ->update(['stufe' => 'Rover']);

        DB::table('banners')
            ->where('id', 5)
            ->update(['stufe' => 'Leiter']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('stufe');
        });
    }
}
