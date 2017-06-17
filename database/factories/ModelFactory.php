<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => null,
        'remember_token' => str_random(10),
        'provider' => 'battlenet',
        'provider_id' => str_random(7)
    ];
});

$factory->define(App\Character::class, function (Faker\Generator $faker) {
    static $password;

    return [
            'user_id' => function () {
            	return factory('App\User')->create()->id;
        	},
            'name' => $faker->userName,
            'realm' => 'Arathor',
            'guild' => $faker->name,
			'battlegroup' => $faker->word,
			'class' => $faker->numberBetween($min = 1, $max = 12),
			'race' => $faker->numberBetween($min = 1, $max = 26),
			'gender' => $faker->numberBetween($min = 0, $max = 1),
			'level' => $faker->numberBetween($min = 1, $max = 110),
			'achievementPoints' => $faker->numberBetween($min = 1000, $max = 20000),
            'rank' => $faker->numberBetween($min = 1, $max = 9),
			'thumbnail' => $faker->slug,
            'main' => false,
            'lastModified' => $faker->unixTime($max = 'now')
    ];
});
