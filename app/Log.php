<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    /**
     * @property int attacker_losses
     * @property int defender_losses
     * @property float attacker_damage
     * @property float defender_damage
     * @property float|int bank_stolen
     * @property float|int gold_stolen
     */

    protected $fillable = ['attacker_id', 'defender_id', 'result', 'attacker_damage', 'defender_damage', 'attacker_losses', 'defender_losses', 'gold_stolen', 'bank_stolen'];
}


