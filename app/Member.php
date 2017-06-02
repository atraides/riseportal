<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
	protected $primaryKey = 'member_id';
	protected $table = 'newdkp_members';

	public function adjustments() {
		return $this->hasMany('App\Adjustment', 'member_id');
	}

	public function items() {
		return $this->hasMany('App\Item', 'member_id');
	}

	public function raids() {
		return $this->belongsToMany('App\Raid', 'newdkp_raid_attendees', 'member_id', 'raid_id');
	}

}
