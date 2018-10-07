<?php

namespace App\Console\Commands;

use App\Classes\Facades\GameInfo;
use App\User;
use Exception;
use Illuminate\Console\Command;

class SwissTimeEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cn:swisstime';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Merchants generate income and bank it';

    /**
     * Create a new command instance.
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
            $users = User::with('balance')->whereActivated(true)->get();
            foreach ($users as $user) {
                $income = GameInfo::swissTimeIncomeForUser($user);
                $user->balance->balance += $income;
                $user->push();
            }
            $this->info('Swiss Time!!!');
        } catch (Exception $e) {
            $this->error('Something bad happened!');
            $this->error('Swiss Time Event: ' . $e->getMessage());
        }
    }
}
