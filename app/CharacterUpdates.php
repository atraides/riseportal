<?php

namespace App;

use DebugBar;

trait CharacterUpdates {

	public function updateCharacters(User $user, $response)
	{
        $characters = Character::with('user')->get();
        if (!is_a($response, 'GuzzleHttp\Exception\ClientException') && !$response->isEmpty()) { 
            foreach ($response->get('characters') as $character) {
                $character->lastModified = (int) $character->lastModified / 1000;
                $character->user_id = ($user->id);

                $chardata = $characters->where('name', $character->name)->where('realm', $character->realm);
                if (!$chardata->isEmpty()) {
                    $chardata = $chardata->first();

                    if ($chardata->lastModified < $character->lastModified){
                        // DebugBar::warning($character->name.' is older in the Database. Trying to update it. (' .$chardata->lastModified.' < '.$character->lastModified.')');
                        $chardata->update((array) $character);
                    } 
                    if ( $chardata->user->id != $user->id) {
                        // DebugBar::warning($character->name.'\'s user_id is different in the DB ('. $chardata->user->id .') then the currently logged in one ('. $user->id .'). 'Trying to update it.');
                        $chardata->update((array) $character);
                    }
                } else {
                    $q = $user->characters()->create((array) $character); 
                }


            }
        }

        return $response;
    }
}