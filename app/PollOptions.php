<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PollOptions extends Model
{

    public $with = ['votes'];

	/**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['count'];

    public function poll() {
    	return $this->belongsTo(Poll::class);
    }

    public function votes()
    {
    	return $this->hasMany(Vote::class);
    }

    public function getCountAttribute()
    {
    	return $this->votes->count();
    }
}
