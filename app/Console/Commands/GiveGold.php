<?php

namespace App\Console\Commands;

use App\Classes\Facades\GameInfo;
use App\User;
use Illuminate\Console\Command;
use Psy\Exception\Exception;

class GiveGold extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cn:givegold';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a Gold Income Update';


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
            foreach ($users as $user) {
                $income = GameInfo::incomeForUser($user);
                $autobanking = $income * GameInfo::autobanking($user) / 100;
                $user->balance->balance += $autobanking;
                $user->resources->gold += $income - $autobanking;
                $user->push();
            }
            $this->info('Gold given out successfully!');
        } catch (Exception $e) {
            $this->error('Something bad happened!');
            $this->error('GiveGold Command: ' . $e->getMessage());
        }
    }
}
