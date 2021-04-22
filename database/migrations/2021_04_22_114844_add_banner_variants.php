<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBannerVariants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->integer('variants')->unsigned()->default(1);
        });
        Schema::table('handovers', function (Blueprint $table) {
            $table->integer('variant')->unsigned()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('handovers', function (Blueprint $table) {
            $table->dropColumn('variant');
        });
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn('variants');
        });
    }
}
