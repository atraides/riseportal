<?php

namespace App\Http\Controllers;

use App\User;
use App\Character;
use Illuminate\Http\Request;
use Xklusive\BattlenetApi\Services\WowService;

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
    public function index()
    {
        //
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(WoWService $wow)
    {
        // return $wow->getProfileCharacters();

        $users = User::all();

        foreach ($users as $user) {
            print "<br/>".$user->name."<br/>";
            foreach ($wow->getProfileCharacters([], $user->bnet->first()->access_token, $user->id)->first() as $character) {
             print_r($character->name);
            }
            
/*            $m = Character::firstOrNew(array('name' => $member->character->name));
            $m->realm
            $m->battlegroup
            $m->class = $member->character->class;
            $m->race = $member->character->race;
            $m->gender = $member->character->
            $m->level = $member->character->
            $m->achievementPoints = $member->character->
            $m->thumbnail
            $m->lastModified = $member->character->
            $m->save();*/

            // $bar->advance();
        }
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
        //
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
