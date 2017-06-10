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
        'name', 'realm', 'rank','battlegroup', 'class', 'race', 'gender', 'level', 'achievementPoints', 'thumbnail', 'lastModified'
    ];

    public function user() {
        return $this->benolgsTo(User::class);
    }
}
