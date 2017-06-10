<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Xklusive\BattlenetApi\Services\WowService;

class GuildController extends Controller
{
    public function show(WoWService $wow) {
    	return $wow->getGuildMembers('Arathor', 'Rise Legacy');
    }

    public function update() 
    {
    	
    }
}
