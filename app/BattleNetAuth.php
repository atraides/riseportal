<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BattleNetAuth extends Model
{

	protected $fillable = [
        'access_token', 'expires',
    ];

    public function users() {
    	$this->belongsTo(User::class);
    }
}
