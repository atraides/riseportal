<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\User;
use App\Character;
use DebugBar;

use Illuminate\Http\Request;
use Xklusive\BattlenetApi\Services\RiseService;

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
    public function index(RiseService $wow)
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
    public function list(Request $request, RiseService $wow)
    {
        $attributes = [ 
            'user_id' => auth()->user()->id
        ];

        $wow->getProfileCharacters();

        $user = User::with('characters')->find(auth()->user()->id);

        if (!$request->query('showAll')) {
            $characters = $user->characters()
                ->orderBy('main','desc')
                ->orderBy('lastModified','desc')
                // ->where('lastModified', '>=', Carbon::now()->subMonths(2)->timestamp)
                // ->where('guild','Rise Legacy')
                ->take(9)
                ->get();
        } else {
            $characters = $user->characters()->get();
        }

        if (request()->expectsJson()) {
            return $characters;
        }

        return view('home', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setMain(Character $character)
    {
        $oldMain = Character::where('main', true)->where('user_id',auth()->user()->id)->where('id', '!=', $character->id);
        $oldMain->get()->each(function ($om, $id) {
            $om->main = false;
            $om->save();
        });

        if ($character->user_id == auth()->user()->id) {
            $character->main = true;
            $character->save();
        }

        if (request()->expectsJson()) {
            return response(['status' => 'You Character set to Main!']);
        }

        return back();
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
