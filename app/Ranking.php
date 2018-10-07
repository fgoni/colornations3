<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{

    protected $fillable = ['user_id', 'attack_rank', 'defense_rank', 'overall_rank', 'season_id'];

    /**
     * Get the user that owns the ranking.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeTopPlayers($query, $take = 3)
    {
        $query->orderBy('overall_rank')->take($take);
    }
}
