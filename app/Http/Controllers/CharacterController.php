<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\User;
use App\Character;
use DebugBar;

use Xklusive\BattlenetApi\Services\WowService;

use Illuminate\Http\Request;

class CharacterController extends Controller
{    
    protected $characters = array();
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, WoWService $wow)
    {
        $user = User::with('characters')->find(auth()->user()->id);

        $attributes = json_encode([ 
            'user_id' => auth()->user()->id,
            'no_modal' => true
        ]);

        if (request()->expectsJson()) {
            if (array_key_exists('showAll', $request->all())) {
                $characters = $user->characters()->get();
            } else { 
                $characters = $user->characters()
                    ->orderBy('main','desc')
                    ->orderBy('lastModified','desc')
                    // ->where('lastModified', '>=', Carbon::now()->subMonths(2)->timestamp)
                    // ->where('guild','Rise Legacy')
                    ->take(9)
                    ->get();
            }

            return $characters;
        }

            // return $user->characters()->get();
        return view('character', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function show(Character $character)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function edit(Character $character)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Character $character)
    {
        if (array_key_exists('main',$request->all())) {
            $oldMain = Character::where('main', true)->where('user_id',auth()->user()->id)->where('id', '!=', $character->id);
            $oldMain->get()->each(function ($om, $id) {
                $om->main = false;
                $om->save();
            });

            if ($character->user_id == auth()->user()->id) {
                $character->main = true;
                if ($character->save()) {
                    return response(['status' => 200, 'statusText' => 'OK', 'message' => 'You Character set to Main.'],200);
                } else {
                    return response(['status' => 500, 'statusText' => 'Internal Server Error', 'message' => 'We cannot change you character.'],500);
                }
            } else {
                return response(['status' => 403, 'statusText' => 'Unauthorized', 'message' => 'You are not authorized to update this character.'],403);
            }
        } else {
            return response(['status' => 406, 'statusText' => 'Not Acceptable', 'message' => 'You can only update the character main status'],406);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Character  $character
     * @return \Illuminate\Http\Response
     */
    public function destroy(Character $character)
    {
        //
    }
}
