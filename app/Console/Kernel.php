<?php

namespace App\Console;

use App\Classes\Facades\GameEvents;
use App\Console\Commands\BlackDeathEvent;
use App\Console\Commands\EndSeason;
use App\Console\Commands\GiveGold;
use App\Console\Commands\GiveTurns;
use App\Console\Commands\GiveUnits;
use App\Console\Commands\GoldRushEvent;
use App\Console\Commands\MoveGoldToBank;
use App\Console\Commands\Reinforcements;
use App\Console\Commands\StartSeason;
use App\Console\Commands\StopEvent;
use App\Console\Commands\SwissTimeEvent;
use App\Console\Commands\TimeWarpEvent;
use App\Console\Commands\TitheEvent;
use App\Console\Commands\TriggerEvent;
use App\Console\Commands\UpdateRankings;
use App\Season;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        GiveGold::class,
        GiveUnits::class,
        StartSeason::class,
        UpdateRankings::class,
        GiveTurns::class,
        StopEvent::class,
        TriggerEvent::class,
        BlackDeathEvent::class,
        EndSeason::class,
        TimeWarpEvent::class,
        TitheEvent::class,
        MoveGoldToBank::class,
        Reinforcements::class,
        SwissTimeEvent::class,
        GoldRushEvent::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $filePath = '/var/www/colornations/storage/logs/schedule.log';

        /**
         * Gold, Turns and Rankings Cron
         */
        $schedule->command('cn:givegold')->everyThirtyMinutes()->appendOutputTo($filePath);
        $schedule->command('cn:updaterankings')->cron('/31 * * * * *')->appendOutputTo($filePath);
        $schedule->command('cn:giveturns')->everyThirtyMinutes()->appendOutputTo($filePath);

        /**
         * Unit Cron
         */
        $schedule->command('cn:giveunits')->twiceDaily(0, 12)->appendOutputTo($filePath);
        $schedule->command('cn:giveunits')->twiceDaily(6, 18)->appendOutputTo($filePath);

        /**
         * Events Cron
         */

        $schedule->command('cn:triggerevent')->hourly()->appendOutputTo($filePath);
        $schedule->command('cn:stopevent')->cron('/30 * * * * *')->appendOutputTo($filePath); //0:30, 1:30, 2:30, etc.

        $schedule->command('cn:blackdeath')->everyFiveMinutes()->when(function () {
            $currentEvent = GameEvents::currentEvent();
            if ($currentEvent != null)
                return $currentEvent->event->code == 'plague';
            else return false;
        })->appendOutputTo($filePath);

        $schedule->command('cn:timewarp')->everyFiveMinutes()->when(function () {
            $currentEvent = GameEvents::currentEvent();
            if ($currentEvent != null)
                return $currentEvent->event->code == 'timewarp';
            else return false;
        })->appendOutputTo($filePath);

        $schedule->command('cn:tithe')->everyFiveMinutes()->when(function () {
            $currentEvent = GameEvents::currentEvent();
            if ($currentEvent != null)
                return $currentEvent->event->code == 'tithe';
            else return false;
        })->appendOutputTo($filePath);

        $schedule->command('cn:reinforcements')->everyFiveMinutes()->when(function () {
            $currentEvent = GameEvents::currentEvent();
            if ($currentEvent != null)
                return $currentEvent->event->code == 'reinforcements';
            else return false;
        })->appendOutputTo($filePath);

        $schedule->command('cn:swisstime')->everyFiveMinutes()->when(function () {
            $currentEvent = GameEvents::currentEvent();
            if ($currentEvent != null)
                return $currentEvent->event->code == 'swisstime';
            else return false;
        })->appendOutputTo($filePath);

        $schedule->command('cn:goldrush')->everyFiveMinutes()->when(function () {
            $currentEvent = GameEvents::currentEvent();
            if ($currentEvent != null)
                return $currentEvent->event->code == 'gold_rush';
            else return false;
        })->appendOutputTo($filePath);

        /**
         * Seasons Cron
         */

        $schedule->command('cn:endseason')->daily()->when(function () {
            $season = Season::all()->last();

            return $season->end->isYesterday();
        })->after(function () {
            $this->call('down');
            $this->call('cn:startseason');
            $this->call('cn:updaterankings');
            $this->call('up');
        })->appendOutputTo($filePath);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
