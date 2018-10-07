<?php

namespace App\Console\Commands;

use App\Classes\Facades\GameInfo;
use App\User;
use Illuminate\Console\Command;
use Psy\Exception\Exception;

class TitheEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cn:tithe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Paladins pay their tithe to the Church';


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
                $income = GameInfo::titheIncomeForUser($user);
                $autobanking = $income * GameInfo::autobanking($user) / 100;
                $user->balance->balance += $autobanking;
                $user->resources->gold += $income - $autobanking;
                $user->push();
            }
            $this->info('Tithe gold given out successfully!');
        } catch (Exception $e) {
            $this->error('Something bad happened!');
            $this->error('Tithe Event: ' . $e->getMessage());
        }
    }
}
