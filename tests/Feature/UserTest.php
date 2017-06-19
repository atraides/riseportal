<?php

namespace Tests\Feature;

use Tests\TestCase;
// use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
// use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
	use DatabaseMigrations;
    
    /** @test */
    function user_can_update_email() {
    	$user = create('App\User');
    	$this->signIn($user);

    	$updatedEmail = 'test@belaba.hu';

    	$this->patch("/user/{$user->id}", ['name' => $user->name, 'email' => $updatedEmail])
   			->assertStatus(200);
    	$this->assertDatabaseHas('users', ['email' => $updatedEmail]);
    }

    /** @test */
    function user_cannot_update_invalid_email() {
    	$user = create('App\User');
    	$this->signIn($user);

    	$updatedEmail = 'Almale';

    	$this->patch("/user/{$user->id}", ['name' => $user->name, 'email' => $updatedEmail])
   			->assertStatus(406);
   		$this->assertDatabaseMissing('users', ['email' => $updatedEmail]);

   		$this->patch("/user/{$user->id}", ['name' => $user->name, 'email' => $user->email])
   			->assertStatus(406);
    }
}
