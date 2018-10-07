<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'bank';
    protected $fillable = ['user_id', 'balance'];

    /**
     * Get the user that owns the balance.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
