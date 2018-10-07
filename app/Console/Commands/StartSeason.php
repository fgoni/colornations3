<?php

namespace App\Console\Commands;

use App\Classes\Facades\GameInfo;
use App\Season;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

class StartSeason extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cn:startseason {--manual}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts a new Season';

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
        $newId = (Season::all()->last()) ? Season::all()->last()->id + 1 : 1;
        $season = new Season();
        $season->name = 'Season ' . $newId;
        $season->number = $newId;
        $season->start = Carbon::today()->startOfMonth();
        $season->end = Carbon::today()->addMonths(1)->startOfMonth();

        if ($this->option('manual')) {
            if ($this->confirm('Do you wish to continue? [y|N]')) {
                $season->name = $this->ask('Name?');
                $season->number = $this->ask('Number?');
                do {
                    $duration = $this->ask('Duration in months? (1-12)');
                } while ($duration > 12 || $duration < 1);
                $season->end = Carbon::today()->addMonths($duration)->startOfMonth();
                $season->save();
            } else return;
        }
        $season->save();
        try {
            $users = User::with('units', 'resources', 'techs')->get();
            foreach ($users as $user) {
                $user->race_changes = GameInfo::raceChanges();
                $user->activated = false;
                $user->units->untrained = GameInfo::startingUnits();
                $user->units->berserkers = GameInfo::startingBerserkers();
                $user->units->paladins = GameInfo::startingPaladins();
                $user->units->merchants = GameInfo::startingMerchants();
                $user->units->archers = 0;
                $user->units->saboteurs = 0;
                $user->units->spies = 0;
                $user->units->injured = GameInfo::startingInjured();
                $user->resources->gold = GameInfo::startingGold();
                $user->resources->turns = GameInfo::startingTurns();
                $user->techs->fortification = GameInfo::startingFortification();
                $user->techs->siege = GameInfo::startingSiege();
                $user->techs->replication = GameInfo::startingReplication();
                $user->techs->intelligence = 0;
                $user->balance->balance = 0;
                $user->balance->autobanking = 0;
                $user->push();
            }
            $this->info('New Season Succesfully Started!');
        } catch (Exception $e) {
            $this->error('Something bad happened!');
            $this->error('StartSeason Command: ' . $e->getMessage());
        };
    }
}
