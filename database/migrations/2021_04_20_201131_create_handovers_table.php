<?php

use App\Models\Banner;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateHandoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('handovers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('team_id');
            $table->bigInteger('banner_id');
            $table->date('received_at');
            $table->timestamps();

            $table->unique(['team_id', 'banner_id']);
            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('banner_id')->references('id')->on('banners');
        });

        $finalHandovers = Banner::pluck('id')->map(function ($banner_id) {
            return [
                'team_id' => 42,
                'banner_id' => $banner_id,
                'received_at' => '2021-09-18',
            ];
        });

        DB::table('handovers')->insert($finalHandovers->toArray());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('handovers');
    }
}
