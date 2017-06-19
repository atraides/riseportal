<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use Carbon\Carbon;
use Nathanmac\Utilities\Parser\Facades\Parser;

class DkpController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {
	    $members = Member::orderBy('member_name', 'asc')->whereIn('member_rank_id', [0,1,5,6,8])->where('member_status',1)->get();

	    $dkp = array();
	    $current_time = Carbon::now()->subMonth()->timestamp;

	    foreach ($members as $member) {

		    if ( $member->member_name == 'bank' or $member->member_name == 'disenchanted' ) { continue; }
		    $earned = 0;
		    $adjust = 0;
		    $spent = 0;
		    $main_id = $member->member_main_id;

		    foreach ($member->raids as $raid) {
			    $earned += $raid->raid_value;
		    }

		    foreach ($member->adjustments as $adj) {
			    $adjust += $adj->adjustment_value;
		    }

		    foreach ($member->items as $item) {
			    $spent += $item->item_value;
		    }

		    if ( array_key_exists($main_id, $dkp) ) {
			    if ( array_key_exists('earned',$dkp[$main_id]) ) {
				    $dkp[$main_id]['earned'] += $earned;
			    } else {
				    $dkp[$main_id]['earned'] = $earned;
			    }
			    if ( array_key_exists('adjustment',$dkp[$main_id]) ) {
				    $dkp[$main_id]['adjustment'] += $adjust;
			    } else {
				    $dkp[$main_id]['adjustment'] = $adjust;
			    }
			    if ( array_key_exists('spent',$dkp[$main_id]) ) {
				    $dkp[$main_id]['spent'] += $spent;
			    } else {
				    $dkp[$main_id]['spent'] = $spent;
			    }
		    } else {
			    $dkp[$main_id]['earned'] = $earned;
			    $dkp[$main_id]['spent'] = $spent;
			    $dkp[$main_id]['adjustment'] = $adjust;
		    }

		    if ( $main_id == $member->member_id ) {
			    $dkp[$main_id]['name'] = $member->member_name;
			    $dkp[$main_id]['class'] = json_decode($member->profiledata)->class;
		    }

		    $dkp[$main_id]['current'] = $dkp[$main_id]['earned'] + $dkp[$main_id]['adjustment'] - $dkp[$main_id]['spent'];
	    }


	usort($dkp, function($a, $b) {
	    return $b['current'] <=> $a['current'];
	});

	return view('dkp.index', compact('dkp'));
    }

    public function upload(Request $request) {
	$file = $request->file('raidlog');	    
	$xml = Parser::xml(file_get_contents($file));
	$return = array();
#	print (Carbon::createFromTimestamp($xml['raiddata']['zones']['zone']['enter'],'Europe/Budapest') . "</br>");
#	print (Carbon::createFromTimestamp($xml['raiddata']['zones']['zone']['leave'],'Europe/Budapest') . "</br>");
	if ( array_key_exists('charactername',$xml['head']['gameinfo'])) {
		$return['uploader'] = $xml['head']['gameinfo']['charactername'];
	}
	return $return;
    }
}
