<?php

namespace App\Console\Commands;

use App\User;
use Exception;
use Illuminate\Console\Command;

class MoveGoldToBank extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cn:movegoldtobank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
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
            foreach ($users as $user) {
                $currentGold = $user->resources->gold;
                $user->balance->balance += $currentGold;
                $user->resources->gold -= $currentGold;
                $user->push();
            }
            $this->info('Gold moved to bank successfully!');
        } catch (Exception $e) {
            $this->error('Something bad happened!');
            $this->error('MoveGoldToBank Command: ' . $e->getMessage());
        }
    }
}
