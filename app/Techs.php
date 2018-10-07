<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Techs extends Model
{
    protected $fillable = ['user_id'];

    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
