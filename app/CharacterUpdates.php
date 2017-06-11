<?php

namespace App;

use DebugBar;

trait CharacterUpdates {

	public function updateCharacters(User $user, $response)
	{
                foreach ($response->get('characters') as $character) {
                        $character->lastModified = (int) $character->lastModified / 1000;
                        if ($user->characters->contains('name',$character->name)) {
                                $dbChar = $user->characters->where('name',$character->name)->where('realm',$character->realm)->first();
                                if ($dbChar->lastModified < $character->lastModified) {
                                      DebugBar::warning($character->name.' is older in the Database. Trying to update it. (' .$dbChar->lastModified.' < '.$character->lastModified.')');
                                      $this->saveCharacterData($user,$character);  
                                }
                        } else {
                                $this->saveCharacterData($user,$character);  
                        }
                }

                // foreach ( $response->get('characters') as $character ) {

                // }
        }

        public function saveCharacterData(User $user, $data) {
                $data = collect($data);

                $user->characters()->updateOrCreate($data->only('name','realm')->toArray(), $data->toArray());
                $user->save();
        }
}