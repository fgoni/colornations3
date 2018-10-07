<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddArchersSaboteursSpiesToUnits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->integer('archers')->default(0);
            $table->integer('saboteurs')->default(0);
            $table->integer('spies')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->dropColumn('archers');
            $table->dropColumn('saboteurs');
            $table->dropColumn('spies');
        });
    }
}
