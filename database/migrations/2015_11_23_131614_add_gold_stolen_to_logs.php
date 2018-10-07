<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddGoldStolenToLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->integer('gold_stolen');
            $table->renameColumn('attacker_dmg', 'attacker_damage');
            $table->renameColumn('defender_dmg', 'defender_damage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->removeColumn('gold_stolen');
            $table->renameColumn('defender_damage', 'defender_dmg');
            $table->renameColumn('attacker_damage', 'attacker_dmg');
        });
    }
}
