<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\CharacterUpdates;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use CharacterUpdates;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function bnet() {
        return $this->hasOne(BattleNetAuth::class);
    }

    public function characters() {
        return $this->hasMany(Character::class);
    }

    public function getMainCharacter() {
        if($main = $this->characters->where('main',true)->first()) {
            return ($main);
        } else {
            return (null);
        }
    }

    public function activateUser()
    {
        $this->active = true;
        $this->save();
    }

    public function getGuildRank($readable = null)
    {
        $char = $this->characters->sortBy('rank')->first();
        if (!is_null($readable)) {
            if (is_null($char)) { return 'guest'; }

            return snake_case($char->rank_name);
        } else {
            return $char->rank;
        }
    }

    public function updateToken($token = null) {
        if (!is_null($token) && $token != $this->bnet->access_token) {
            $this->bnet->access_token = $token;
            $this->bnet->save();
        }
    }
}
