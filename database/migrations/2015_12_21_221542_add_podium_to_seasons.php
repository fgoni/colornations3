<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPodiumToSeasons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seasons', function (Blueprint $table) {
            $table->integer('winner_id')->default(0);
            $table->integer('runner_up_id')->default(0);
            $table->integer('third_place_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seasons', function (Blueprint $table) {
            $table->dropColumn('winner_id');
            $table->dropColumn('runner_up_id');
            $table->dropColumn('third_place_id')->default(0);
        });
    }
}
