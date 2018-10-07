<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['name', 'description'];

    public function rotation()
    {
        return $this->hasOne('App\EventRotation', 'event_id');
    }
}
