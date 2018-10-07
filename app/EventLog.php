<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventLog extends Model
{
    protected $dates = ['started_at', 'finished_at'];

    public function event()
    {
        return $this->belongsTo('App\Event');
    }
}
