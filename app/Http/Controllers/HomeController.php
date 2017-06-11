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
    public function index(RiseService $wow) {
      $wow->getProfileCharacters();

      $user = User::with('characters')->find(auth()->user()->id);
      $characters = $this->characterTransformations(
        $user->characters
             ->where('lastModified', '>=', Carbon::now()->subMonths(2)->timestamp)
             ->where('guild','Rise Legacy')
      );

      return view('home', compact('characters'));
    }

    private function characterTransformations($obj) {
      foreach ( $obj as $character ) {
        switch ($character->class) {
          case 1: $character->class = 'Warrior'; break;
          case 2: $character->class = 'Paladin'; break;
          case 3: $character->class = 'Hunter'; break;
          case 4: $character->class = 'Rogue'; break;
          case 5: $character->class = 'Priest'; break;
          case 6: $character->class = 'Death Knight'; break;
          case 7: $character->class = 'Shaman'; break;
          case 8: $character->class = 'Mage'; break;
          case 9: $character->class = 'Warlock'; break;
          case 10: $character->class = 'Monk'; break;
          case 11: $character->class = 'Druid'; break;
          case 12: $character->class = 'Demon Hunter'; break;
        }
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
          case 22: $character->race = 'Worgen'; break;
          case 25: $character->race = 'Pandaren'; break;
        }

        $character->rank = $character->getGuildRank();
        $character->rank_name = $character->getGuildRank(1);
      }

      return $obj->sortByDesc('lastModified')->toArray();
    }
 }
