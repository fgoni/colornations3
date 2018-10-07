<?php

namespace App\Console\Commands;

use App\Classes\Facades\GameInfo;
use App\User;
use Exception;
use Illuminate\Console\Command;

class GoldRushEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cn:goldrush';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Give a random player a large sum of gold';

    /**
     * Create a new command instance.
     *
     */
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
            $users = User::with('balance', 'resources')->whereActivated(true)->get();
            $receiver = $users->shuffle()->first();
            $incomeGiver = $users->shuffle()->first();
            $income = GameInfo::incomeForUser($incomeGiver) * mt_rand(5, 10);
            $autobanking = $income * GameInfo::autobanking($receiver) / 100;
            $receiver->balance->balance += $autobanking;
            $receiver->resources->gold += $income - $autobanking;
            $receiver->push();
            $this->info('Gold Rush gold given out successfully!');
            echo($receiver->name);
            echo($incomeGiver->name);
            echo($income);
        } catch (Exception $e) {
            $this->error('Something bad happened!');
            $this->error('Gold Rush Event: ' . $e->getMessage());
        }
    }
}
