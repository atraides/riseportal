<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class BattleNetAuth extends Authenticatable
{

	protected $fillable = [
        'access_token', 'expires',
    ];

    public function users() {
    	$this->belongsTo(User::class);
    }
}
