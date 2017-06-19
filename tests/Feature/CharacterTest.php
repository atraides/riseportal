<?php

namespace Tests\Feature;

use Tests\TestCase;
// use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Character;

class CharacterTest extends TestCase
{
  use DatabaseMigrations;
    
    /** @test */
    function user_can_choose_a_main_character() {
      $user = create('App\User');
      $character = create('App\Character',['user_id' => $user->id]);

      $this->signIn($user);

      $this->json('PATCH', "/character/{$character->id}", ['main' => true])
         ->assertStatus(200);
      $this->assertDatabaseHas('characters', ['id' =>  $character->id, 'main' => true]);
    }

    /** @test */
    function a_user_can_list_its_characters() {
      $numCharacters = 50;
      $user = create('App\User');
      factory('App\Character',$numCharacters)->create(['user_id' => $user->id]);

      $this->signIn($user);

      $result = $this->json('GET', "/character", ['showAll' => 1]);
      $result->assertStatus(200);
      $this->assertCount($numCharacters, json_decode($result->content()));
    }

    /** @test */
    function user_cannot_change_character_details_other_than_main() {
      $user = create('App\User');
      $character = create('App\Character',['user_id' => $user->id]);

      $this->signIn($user);

      $this->json('PATCH', "/character/{$character->id}", ['name' => 'Marineni'])
        ->assertStatus(406);
      $this->assertDatabaseHas('characters', ['name' =>  $character->name]);
    }

    /** @test */
    function user_can_have_only_one_main_character() {
      $user = create('App\User');
      factory('App\Character',10)->create(['user_id' => $user->id, 'main' => true]);

      $this->signIn($user);

      $this->json('PATCH', "/character/{$user->characters->first()->id}", ['main' => true])
        ->assertStatus(200);

      $mains = $user->fresh()->characters->where('main',true)->toArray();
      $this->assertCount(1, $mains);
    }
}
