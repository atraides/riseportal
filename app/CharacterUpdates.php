<?php

namespace App;

use DebugBar;
use DB;

trait CharacterUpdates {

	public function updateCharacters(User $user, $response)
	{
        $characters = Character::with('user')->get();
        foreach ($response->get('characters') as $character) {
            $character->lastModified = (int) $character->lastModified / 1000;
            $character->user_id = ($user->id);

            $chardata = $characters->where('name', $character->name)->where('realm', $character->realm);
            if (!$chardata->isEmpty()) {
                $chardata = $chardata->first();
                if ($chardata->lastModified < $character->lastModified) {
                    DebugBar::warning($character->name.' is older in the Database. Trying to update it. (' .$chardata->lastModified.' < '.$character->lastModified.')');
                    // $searchArray = collect($chardata->toArray())->only('name','realm');
                    $chardata->update((array) $character);
                }
            } else {
                $q = $user->characters()->create((array) $character);
            // $this->saveCharacterData($user,$character);  
            }
        }
    }
}