<?php

namespace App\Console\Commands;

use App\Classes\Facades\GameInfo;
use App\User;
use Illuminate\Console\Command;
use Psy\Exception\Exception;

class GiveTurns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cn:giveturns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


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
            foreach ($users as $user) {
                $user->resources->turns += GameInfo::turnsForUser($user);
                $user->resources->turns = min($user->resources->turns, GameInfo::maxTurns());
                $user->resources->save();
            }
            $this->info('Turns given out successfully!');
        } catch (Exception $e) {
            $this->error('Something bad happened!');
            $this->error('GiveTurns Command: ' . $e->getMessage());
        }
    }
}
