<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddIntelligenceToTechs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('techs', function (Blueprint $table) {
            $table->integer('intelligence')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('techs', function (Blueprint $table) {
            $table->dropColumn('intelligence');
        });
    }
}
