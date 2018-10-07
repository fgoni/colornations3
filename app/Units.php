<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    protected $fillable = ['user_id', 'untrained'];

    protected $casts = [
        'untrained'  => 'integer',
        'berserkers' => 'integer',
        'archers'    => 'integer',
        'saboteurs'  => 'integer',
        'spies'      => 'integer',
        'paladins'   => 'integer',
        'merchants'  => 'integer',
    ];

    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
