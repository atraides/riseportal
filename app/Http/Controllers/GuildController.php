<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Xklusive\BattlenetApi\Services\RiseService;
use App\CharacterUpdates;

class GuildController extends Controller
{
	use CharacterUpdates;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function show(RiseService $wow) {
    	
    	$result = collect($wow->getGuildMembers('Arathor', 'Rise Legacy')->get('members'));
    	$members = $this->characterTransformations(
    		collect(array_chunk($result->sortBy('rank')->toArray(),4))
    	);

    	return view('roster', compact('members'));
    }

    public function update() 
    {
    	
    }
}
