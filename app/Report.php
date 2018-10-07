<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * @property float attacker_damage
     * @property float defender_damage
     */
    protected $fillable = ['attacker_id', 'defender_id', 'result', 'attacker_damage', 'defender_damage', 'url'];
}
