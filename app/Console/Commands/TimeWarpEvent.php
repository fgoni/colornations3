<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Flysystem\Exception;

class TimeWarpEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cn:timewarp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Accelerate time 15 times.';


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
            $this->call('cn:givegold');
            $this->call('cn:giveturns');
            $this->info('Income and turns given out successfully');
        } catch (Exception $ex) {
            $this->error('TimeWarp Event: ' . $ex->getMessage());
        }
    }
}
