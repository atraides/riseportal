<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;


use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Xklusive\BattlenetApi\Services\WowService;

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
    public function index()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://eu.api.battle.net/wow/user/characters?access_token='.Auth::user()->bnet->first()->access_token);
        /*$res = $client->request('GET', 'https://eu.api.battle.net/wow/auction/data/arathor?locale=en_GB&apikey=zm995q6pq362g72vt3nm7pk8sfwmsaeq');*/

        if ($res->getStatusCode() == 403) {
            /*Re authenticate*/
        } elseif ($res->getStatusCode() == 200) {
          $characters = json_decode($res->getBody());

          $this->deleteOldCharacters($characters);
          $this->classTransformation($characters);

        return view('home', compact('characters'));
      }
  }

  private function deleteOldCharacters($obj) {
    foreach ( $obj->characters as $id => $character) {
        if ($character->lastModified <= (Carbon::now()->subMonths(2)->timestamp * 1000) ) {
            unset($obj->characters[$id]);
        }
    }
  }

  private function classTransformation($array) {
    foreach ( $array->characters as $character) {
        switch ($character->class) {
            case 1: $character->class = 'warrior'; break;
            case 2: $character->class = 'paladin'; break;
            case 3: $character->class = 'hunter';  break;
            case 4: $character->class = 'rogue'; break;
            case 5: $character->class = 'priest'; break;
            case 6: $character->class = 'deathknight'; break;
            case 7: $character->class = 'shaman'; break;
            case 8: $character->class = 'mage'; break;
            case 9: $character->class = 'warlock'; break;
            case 10: $character->class = 'monk'; break;
            case 11: $character->class = 'druid'; break;
            case 12: $character->class = 'demonhunter'; break;
        }
    }
  }
}
