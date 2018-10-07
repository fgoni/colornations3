<?php

use App\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->truncate();

        Event::create([
            'code'        => 'take_no_prisioners_comrade',
            'name'        => 'Take no prisioners comrade!',
            'description' => 'Successful attacks kill enemy soldiers instead of just injuring them',
        ]);
        Event::create([
            'code'        => 'gold_rush',
            'name'        => 'Gold Rush',
            'description' => 'Every 5 minutes, a random player gets a ton of gold',
        ]);
        Event::create([
            'code'        => 'blood_rage',
            'name'        => 'Blood Rage',
            'description' => '25% more Attack',
        ]);
        Event::create([
            'code'        => 'sandstorm',
            'name'        => ' Sandstorm',
            'description' => '25% more Defense',
        ]);
        Event::create([
            'code'        => 'swisstime',
            'name'        => 'Swiss Time',
            'description' => 'Every 5 minutes, Merchants generate income and bank it',
        ]);
        Event::create([
            'code'        => 'plague',
            'name'        => 'The Black Death',
            'description' => 'Every 5 minutes, the plague takes the lives of your soldiers',
        ]);
        Event::create([
            'code'        => 'timewarp',
            'name'        => 'Time Warp',
            'description' => 'Every 5 minutes, you get income and turns',
        ]);
        Event::create([
            'code'        => 'berserkers',
            'name'        => 'Drums of War',
            'description' => 'Berserkers attack is doubled and steal twice the gold',
        ]);
        Event::create([
            'code'        => 'tithe',
            'name'        => 'Tithe',
            'description' => 'Every 5 minutes, your Paladins give twice their income',
        ]);
        Event::create([
            'code'        => 'archers',
            'name'        => 'Flaming Arrows',
            'description' => 'Archers attack is equal to their defense',
        ]);
        Event::create([
            'code'        => 'saboteurs',
            'name'        => 'Pillaging',
            'description' => 'Saboteurs steal banked gold',
        ]);
        Event::create([
            'code'        => 'reinforcements',
            'name'        => 'Reinforcements',
            'description' => 'Every 5 minutes, you get a handful of soldiers',
        ]);
    }
}
