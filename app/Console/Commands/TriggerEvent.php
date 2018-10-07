<?php

namespace App\Console\Commands;

use App\Classes\Facades\GameEvents;
use App\EventLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

class TriggerEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cn:triggerevent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trigger the next event in the rotation';

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
            $this->info('The next event is going to be run');
            $newRotation = GameEvents::triggerNextEvent();
            if ($newRotation)
                $this->info('A new rotation has been crafted');
            $this->info('The new event is: ' . GameEvents::currentEvent()->event->description);
            $eventLog = new EventLog();
            $eventLog->event_id = GameEvents::currentEvent()->event->id;
            $eventLog->finished_at = Carbon::now();
            $eventLog->started_at = Carbon::now();
            $eventLog->save();
        } catch (Exception $ex) {
            $this->error('Trigger Event: ' . $ex->getMessage());
        }
    }
}
