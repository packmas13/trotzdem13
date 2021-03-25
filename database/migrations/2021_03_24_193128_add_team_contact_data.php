<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTeamContactData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->string('contact_phone', 255)->default('');
            $table->string('contact_email', 255)->default('');
            $table->string('contact_name', 255)->default('');
            $table->string('contact_street', 255)->default('');
            $table->string('contact_zip', 255)->default('');
            $table->string('contact_city', 255)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('contact_phone');
            $table->dropColumn('contact_email');
            $table->dropColumn('contact_name');
            $table->dropColumn('contact_street');
            $table->dropColumn('contact_zip');
            $table->dropColumn('contact_city');
        });
    }
}
