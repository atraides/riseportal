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
        $main = $this->characters->where('main',true)->first();
        return ($main);
    }

    public function getGuildRank($readable = null)
    {
        $charRank = Member::whereIn('name',array_column($this->characters->toArray(),'name'))->min('rank');
        if (!is_null($readable)) {
            if (is_null($charRank)) { return 'guest'; }

            switch ($charRank) {
                case 0: { return 'officer'; break; }
                case 1: { return 'officer'; break; }
                case 2: { return 'officer'; break; }
                case 3: { return 'raidleader'; break; }
                case 4: { return 'raider'; break; }
                case 5: { return 'member'; break; }
                case 6: { return 'recruit'; break; }
                case 7: { return 'alt'; break; }
                case 8: { return 'casual'; break; }
                case 9: { return 'inactive'; break; }
                default: { return 'guest'; break; }
            }
        } else {
            return $charRank;
        }
    }

    public function updateToken($token = null) {
        if (!is_null($token) && $token != $this->bnet->access_token) {
            $this->bnet->access_token = $token;
            $this->bnet->save();
        }
    }
}
