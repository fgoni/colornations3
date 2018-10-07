<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 17/12/2015
 * Time: 11:43 AM
 */

namespace App\Classes;

use App\Event;
use App\EventRotation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class GameEvents
{
    public function currentRotation()
    {
        return EventRotation::wherePassed(false)->whereCurrent(false)->get();
    }

    public function newRotation()
    {
        Cache::forget('current_event');
        DB::transaction(function () {
            DB::table('event_rotations')->truncate();
            $shuffledEvents = Event::all()->shuffle();

            foreach ($shuffledEvents as $event) {
                EventRotation::create([
                    'event_id' => $event->id,
                ]);
            }
            $this->triggerNextEvent();
        });
    }

    public function triggerNextEvent()
    {
        $nextEvent = $this->nextEvent();

        //If there's no more events, rotation is finished, create a new one.
        if ($nextEvent == null) {
            $this->newRotation();

            return true;
        }

        //Mark the current event as passed.
        $currentEvent = $this->currentEvent();
        if ($currentEvent != null) {
            $currentEvent->current = false;
            $currentEvent->passed = true;
            $currentEvent->save();
        }

        $nextEvent->current = true;
        $nextEvent->save();

        return false;
    }

    public function nextEvent()
    {
        return EventRotation::with('event')->wherePassed(false)->whereCurrent(false)->first();
    }

    public function currentEvent()
    {
        return EventRotation::with('event')->whereCurrent(true)->first();
    }

    public function stopCurrentEvent()
    {
        $currentEvent = $this->currentEvent();
        if ($currentEvent != null) {
            $currentEvent->current = false;
            $currentEvent->passed = true;
            $currentEvent->save();
        }
    }

    public function passedEvents()
    {
        return EventRotation::wherePassed(true)->get();
    }
}