<?php

namespace App\Console\Commands;

use App\Ranking;
use App\Season;
use Illuminate\Console\Command;
use League\Flysystem\Exception;

class EndSeason extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cn:endseason';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ends the current Season';

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
            $podium = Ranking::topPlayers()->get();
            $winner = $podium[0];
            $runner_up = $podium[1];
            $third_place = $podium[2];

            $season = Season::all()->last();
            $season->winner_id = $winner->user_id;
            $season->runner_up_id = $runner_up->user_id;
            $season->third_place_id = $third_place->user_id;

            $season->save();
        } catch (Exception $ex) {
            $this->error('EndSeason command: ' . $ex->getMessage());
        }
    }
}
