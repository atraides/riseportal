<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'realm', 'rank','battlegroup', 'guild', 'class', 'race', 'gender', 'level', 'achievementPoints', 'thumbnail', 'lastModified'
    ];

    public function user() {
        return $this->benolgsTo(User::class);
    }

    public function getGuildRank($readable = null)
    {
        if ($member = Member::where('name',$this->name)->first()) {
            $charRank = $member->rank;
        } else {
            $charRank = 999;
        }

        if (!is_null($readable)) {
            if (is_null($charRank)) { return 'guest'; }

            switch ($charRank) {
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
                default: { return 'guest'; break; }
            }
        } else {
            return $charRank;
        }
    }

}
