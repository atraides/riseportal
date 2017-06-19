<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Xklusive\BattlenetApi\Services\WowService;

use App\CharacterUpdates;

use App\User;
use App\Character;
use App\Poll;

class ApiController extends Controller
{
	use CharacterUpdates;
    /**
     * Checks if the given value is uniq within the given type.
     *
     * @param  string  $type
     * @param  string  $value
     * @return \Illuminate\Http\Response
     */
    public function uniq($type, $value)
    {
    	if (in_array($type,['name', 'email'])) {
        	$user = User::where($type, $value)->get();

	        if ($user->isEmpty()) {
	            return response()->json(['status' => '200','statusText' => 'OK', 'message' => "$value is uniq within ${type}s.", 'uniq' => true],200);
	        } else {
	            return response()->json(['status' => '200','statusText' => 'OK', 'message' => "$value is already exists within ${type}s.", 'uniq' => false],200);
        	}
        } else {
        	return response()->json(['status' => '501','statusText' => 'Not Implemented', 'message' => "This type ($type) cannot be checked for uniqness with the API."],503);
        }
    }

    public function updateCharcterData(User $user, WoWService $wow) {
    	$provider = $user->providers()->where('provider','battlenet')->first();

        if (!empty($provider) && $provider->access_token) {
            $response = $this->updateCharacters($user, $wow->getProfileCharacters([
                'access_token' => $provider->access_token,
                'access_scope' => $provider->scope
            ]));

            if (is_a($response, 'GuzzleHttp\Exception\ClientException')) { return ($response); }

            return response()->json(['status' => '200','statusText' => 'OK', 'message' => "The characters for {$user->name} has been updated."],200);
        } else {
        	return response()->json(['status' => '403','statusText' => 'Unathorized', 'message' => "You have not authorized to update the characters for this user"],403);
        }
    }

    public function vote(Request $request) {
    	$user = User::with('votes')->find(auth()->user()->id);
    	$data = $request->get('data');

        if ($user->getGuildRank() >=6) {
            // Fuck all.
        } else {
            $votes = $user->votes->where('poll_id',$data['poll_id']);
            if ($votes->isEmpty()) {
                $user->votes()->create([
                    'poll_id' => $data['poll_id'],
                    'poll_options_id' => $data['id']
                ]);
            } else {
                $votes->first()->update([
                    'poll_options_id' => $data['id']
                ]);
            }
        }
    }

    public function pollDetails(Poll $poll) {
        $allowedToVote = Character::whereIn('rank',[1,5])->count();
        return response()->json([
            'status' => 200, 
            'statusText' => 'OK',
            'data' => [
                'options' => $poll->options,
                'allowedToVote' => $allowedToVote,
                'message' => $poll->body,
                'infourl' => $poll->infourl,
                'name' => $poll->name
            ]
        ],200);
    }
}
