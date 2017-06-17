<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class OauthProvider extends Authenticatable
{

	protected $fillable = [
        'provider', 'access_token', 'expires', 'scope'
    ];

    public function users() {
    	$this->belongsTo(User::class);
    }
}
