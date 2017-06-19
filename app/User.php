<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\CharacterUpdates;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, CharacterUpdates;

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

    public function providers() {
        return $this->hasMany(OauthProvider::class);
    }

    public function characters() {
        return $this->hasMany(Character::class);
    }

    public function getMain() {
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

    public function votes()
    {
        return $this->hasMany(Vote::class);
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
        $provider = $this->providers()->where('provider',$this->provider)->first();

        if (!is_null($token) && $token != $provider->access_token) {
            $provider->access_token = $token;
            $provider->save();
        }
    }
}
