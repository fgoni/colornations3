<?php

use App\Race;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('races')->truncate();

        Race::create([
            'name' => 'reds',
        ]);
        Race::create([
            'name' => 'blues',
        ]);
        Race::create([
            'name' => 'greens',
        ]);
        Race::create([
            'name' => 'oranges',
        ]);
    }
}
