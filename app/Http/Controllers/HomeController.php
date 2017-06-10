<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;


use Illuminate\Http\Request;

use Xklusive\BattlenetApi\Services\WowService;
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
    public function index(WowService $wow) {
        try {
            $res = $wow->getProfileCharacters();

            $characters = json_decode($res);

            $this->deleteOldCharacters($characters);
            $this->classTransformation($characters);
            $this->raceTransformation($characters);

            return view('home', compact('characters'));
        } catch (\Exception $e) {
            if ($e->getResponse()->getStatusCode() == 401) {
                return redirect('/oauth/battlenet');
            }
        }
    }

  private function deleteOldCharacters($obj) {
    foreach ( $obj->characters as $id => $character) {
        if ($character->lastModified <= (Carbon::now()->subMonths(2)->timestamp * 1000) ) {
            unset($obj->characters[$id]);
        }
    }
  }

  private function classTransformation($obj) {
    foreach ( $obj->characters as $character) {
        switch ($character->class) {
            case 1: $character->class = 'Warrior'; $character->cssClass = 'warrior'; break;
            case 2: $character->class = 'Paladin'; $character->cssClass = 'paladin'; break;
            case 3: $character->class = 'Hunter'; $character->cssClass = 'hunter';  break;
            case 4: $character->class = 'Rogue'; $character->cssClass = 'rogue'; break;
            case 5: $character->class = 'Priest'; $character->cssClass = 'priest'; break;
            case 6: $character->class = 'Death Knight'; $character->cssClass = 'deathknight'; break;
            case 7: $character->class = 'Shaman'; $character->cssClass = 'shaman'; break;
            case 8: $character->class = 'Mage'; $character->cssClass = 'mage'; break;
            case 9: $character->class = 'Warlock'; $character->cssClass = 'warlock'; break;
            case 10: $character->class = 'Monk'; $character->cssClass = 'monk'; break;
            case 11: $character->class = 'Druid'; $character->cssClass = 'druid'; break;
            case 12: $character->class = 'Demon Hunter'; $character->cssClass = 'demonhunter'; break;
        }
    }
  }

  private function raceTransformation($obj) {
    foreach ( $obj->characters as $character) {
        switch ($character->race) {
			case 1: $character->race = 'Human'; break;
			case 2: $character->race = 'Orc'; break;
			case 3: $character->race = 'Dwarf'; break;
			case 4: $character->race = 'Nightelf'; break;
			case 5: $character->race = 'Undead'; break;
			case 6: $character->race = 'Tauren'; break;
			case 7: $character->race = 'Gnome'; break;
			case 8: $character->race = 'Troll'; break;
			case 10: $character->race = 'Bloodelf'; break;
			case 11: $character->race = 'Draenei'; break;
        }
    }
  }
}
