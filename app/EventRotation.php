<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

class EventRotation extends Model
{
    use Rememberable;

    protected $fillable = ['event_id', 'passed', 'current'];

    public function event()
    {
        return $this->belongsTo('App\Event', 'event_id');
    }
}
