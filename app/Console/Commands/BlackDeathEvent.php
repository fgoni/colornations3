<?php

namespace App\Console\Commands;

use App\Classes\Facades\GameInfo;
use App\User;
use Illuminate\Console\Command;
use Psy\Exception\Exception;

class BlackDeathEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cn:blackdeath';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The Plague kills a percentage of the players population!';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $users = User::whereActivated(true)->get();
            $unitsKilled = 0;
            foreach ($users as $user) {
                //50-50 chance of getting the Plague.
                if (mt_rand(0, 1))
                    continue;

                $units = GameInfo::unitsForUser($user);
                $untrained_ratio = $user->units->untrained / $units;
                $berserker_ratio = $user->units->berserkers / $units;
                $paladin_ratio = $user->units->paladins / $units;
                $archer_ratio = $user->units->archers / $units;
                $saboteur_ratio = $user->units->saboteurs / $units;

                $untrained_killed = round(mt_rand($units / 200, $units / 100) * $untrained_ratio);
                $berserkers_killed = round(mt_rand($units / 200, $units / 100) * $berserker_ratio);
                $paladins_killed = round(mt_rand($units / 200, $units / 100) * $paladin_ratio);
                $archers_killed = round(mt_rand($units / 200, $units / 100) * $archer_ratio);
                $saboteurs_killed = round(mt_rand($units / 200, $units / 100) * $saboteur_ratio);

                $deathsForPlayer = $untrained_killed + $berserkers_killed + $paladins_killed + $saboteurs_killed;

                $user->units->untrained -= $untrained_killed;
                $user->units->berserkers -= $berserkers_killed;
                $user->units->paladins -= $paladins_killed;
                $user->units->archers -= $archers_killed;
                $user->units->saboteurs -= $saboteurs_killed;
                $unitsKilled += $deathsForPlayer;
                $this->info('The Black Death has killed ' . $deathsForPlayer . ' of ' . $user->name . ' units');
                $user->push();
            }
            $this->info('The Black Death has killed ' . $unitsKilled . ' units in total');

        } catch (Exception $e) {
            $this->error('Something bad happened!');
            $this->error('Black Death Event: ' . $e->getMessage());
        }
    }
}
