<?php

namespace App;

use App\Classes\Facades\GameInfo;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'race_id', 'race_changes', 'role', 'social_id', 'provider'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public static function boot()
    {
        parent::boot();
        static::created(function (self $user) {
            $units = new Units([
                'untrained' => GameInfo::startingUnits(),
            ]);
            $techs = new Techs();
            $resources = new Resources([
                'gold'  => GameInfo::startingGold(),
                'turns' => GameInfo::startingTurns(),
            ]);
            $balance = new Bank([
                'user_id' => $user->id,
                'balance' => 0,
            ]);
            $user->units()->save($units);
            $user->techs()->save($techs);
            $user->balance()->save($balance);
            $user->resources()->save($resources);
        });
    }

    /**
     * Get the units record associated with the user.
     */
    public function units()
    {
        return $this->hasOne('App\Units');
    }

    /**
     * Get the techs record associated with the user.
     */
    public function techs()
    {
        return $this->hasOne('App\Techs');
    }

    /**
     * Get the race record associated with the user.
     */
    public function balance()
    {
        return $this->hasOne('App\Bank');
    }

    /**
     * Get the resources record associated with the user.
     */
    public function resources()
    {
        return $this->hasOne('App\Resources');
    }

    public function getRaceNameAttribute()
    {
        return Race::remember(1440)->find($this->race_id)->name;
    }

    /**
     * Get the race record associated with the user.
     */
    public function ranking()
    {
        return $this->hasOne('App\Ranking');
    }

    public function scopeActivated($query)
    {
        return $query->where('activated', true);
    }
}
