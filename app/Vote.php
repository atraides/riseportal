<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'poll_id', 'poll_options_id'
    ];

    public function option()
    {
    	return $this->belongsTo(PollOptions::class);
    }

    public function poll()
    {
    	return $this->belongsTo(Poll::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::clasS);
    }
}
