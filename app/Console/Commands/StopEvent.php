<?php

namespace App\Console\Commands;

use App\Classes\Facades\GameEvents;
use App\EventLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use League\Flysystem\Exception;

class StopEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cn:stopevent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stops the current event';

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
            if (GameEvents::currentEvent() != null) {
                $this->info('Stopping ' . GameEvents::currentEvent()->event->name);
                $eventLog = EventLog::all()->last();
                GameEvents::stopCurrentEvent();
                $eventLog->finished_at = Carbon::now();
                $eventLog->save();
                $this->info('Done. No event active');
            } else $this->info('No event was active to begin with');
        } catch (Exception $ex) {
            $this->error('StopEvent error: ' . $ex->getMessage());
            $this->error($ex->getTraceAsString());
        }
    }
}
