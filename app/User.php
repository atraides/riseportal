<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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

    public function updateToken($token = null) {
        if (!is_null($token) && $token != $this->bnet->access_token) {
            $this->bnet->access_token = $token;
            $this->bnet->save();
        }
    }
}
