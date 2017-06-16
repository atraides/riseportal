<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{

    //Executed when loading model
    public static function boot()
    {
         parent::boot();

    /*         Character::updating(function($char){
             $char->value1 = $char->value2 +1;
         });*/
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'user_id', 'name', 'realm', 'rank','battlegroup', 'guild', 'class', 'race', 'gender', 'level', 'achievementPoints', 'thumbnail', 'lastModified'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['rank_name', 'race_name', 'class_name'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getRankNameAttribute() {
        switch ($this->rank) {
            case 0: { return 'officer'; break; }
            case 1: { return 'officer'; break; }
            case 2: { return 'officer alt'; break; }
            case 3: { return 'raidleader'; break; }
            case 4: { return 'raider'; break; }
            case 5: { return 'member'; break; }
            case 6: { return 'recruit'; break; }
            case 7: { return 'alt'; break; }
            case 8: { return 'casual'; break; }
            case 9: { return 'inactive'; break; }
            default: { return null; break; }
        }
    }

    public function getRaceNameAttribute() {
        switch ($this->race) {
            case 1: return 'Human'; break;
            case 2: return 'Orc'; break;
            case 3: return 'Dwarf'; break;
            case 4: return 'Nightelf'; break;
            case 5: return 'Undead'; break;
            case 6: return 'Tauren'; break;
            case 7: return 'Gnome'; break;
            case 8: return 'Troll'; break;
            case 10: return 'Bloodelf'; break;
            case 11: return 'Draenei'; break;
            case 22: return 'Worgen'; break;
            case 25: return 'Pandaren'; break;
            default:  return null; break;
        }
    }

    public function getClassNameAttribute() {
        switch ($this->class) {
            case 1: return 'Warrior'; break;
            case 2: return 'Paladin'; break;
            case 3: return 'Hunter'; break;
            case 4: return 'Rogue'; break;
            case 5: return 'Priest'; break;
            case 6: return 'Death Knight'; break;
            case 7: return 'Shaman'; break;
            case 8: return 'Mage'; break;
            case 9: return 'Warlock'; break;
            case 10: return 'Monk'; break;
            case 11: return 'Druid'; break;
            case 12: return 'Demon Hunter'; break;
        }
    }

}
