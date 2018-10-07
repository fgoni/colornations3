<?php

namespace App\Console\Commands;

use App\Classes\Facades\GameInfo;
use App\User;
use Exception;
use Illuminate\Console\Command;

class Reinforcements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cn:reinforcements';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gives a fixed amount of units to players';

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
            $users = User::with('units')->whereActivated(true)->get();
            $totalUnits = 0;
            foreach ($users as $user) {
                $totalUnits += GameInfo::unitsForUser($user);
            }
            $bonusUnits = round($totalUnits / $users->count() / 6 / 10);
            foreach ($users as $user) {
                $user->units->untrained += $bonusUnits;
                $user->push();
            }
            $this->info($bonusUnits . ' given out to each player.');
        } catch (Exception $e) {
            $this->error('Something bad happened!');
            $this->error('Reinforcements Command: ' . $e->getMessage());
        }
    }
}
