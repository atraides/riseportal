<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\User;
use DebugBar;

use Illuminate\Http\Request;

use Xklusive\BattlenetApi\Services\RiseService;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $attributes = json_encode([ 
            'user_id' => auth()->user()->id,
        ]);

        return view('home', compact('attributes'));
    }
 }
