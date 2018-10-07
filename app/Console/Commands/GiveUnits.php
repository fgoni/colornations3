<?php

namespace App\Console\Commands;

use App\Classes\Facades\GameInfo;
use App\User;
use Illuminate\Console\Command;
use Psy\Exception\Exception;

class GiveUnits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cn:giveunits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a Units Replication Update';

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
            $users = User::whereActivated(true);
            foreach ($users as $user) {
                $user->units->untrained += GameInfo::replication($user->techs->replication);
                $user->units->save();

            }
            $this->info('Units given out successfully!');
        } catch (Exception $e) {
            $this->error('Something bad happened!');
            $this->error('GiveUnits Command: ' . $e->getMessage());
        }
    }
}
