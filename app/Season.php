<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string name
 * @property string number
 * @property string start
 * @property string end
 */
class Season extends Model
{
    protected $fillable = ['name', 'number', 'start', 'end'];
    protected $dates = ['start', 'end'];

    public function winner()
    {
        return $this->hasOne('App\User', 'id', 'winner_id');
    }

    public function runnerUp()
    {
        return $this->hasOne('App\User', 'id', 'runner_up_id');
    }

    public function thirdPlace()
    {
        return $this->hasOne('App\User', 'id', 'third_place_id');
    }

    public function scopePenultimate($query)
    {
        $lastSeason = Season::all()->last();
        if ($lastSeason != null)
            return $query->whereId($lastSeason->id - 1);
        else return null;
    }
}
