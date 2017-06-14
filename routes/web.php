<?php

use Xklusive\BattlenetApi\Services\WowService;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('oauth/{provider}', 'Auth\BattleNetController@redirectToProvider');
Route::get('oauth/{provider}/callback', 'Auth\BattleNetController@handleProviderCallback');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () { return view('welcome'); });

Route::get('/error', 'ErrorsController@show');

Route::get('/guild', 'GuildController@show');
Route::get('/guild/roster', 'GuildController@show');
Route::get('/character', 'CharacterController@index');
Route::get('/character/list', 'CharacterController@list');
Route::patch('/character/{character}/main', 'CharacterController@setMain');
Route::get('/user/{user}/characters', 'CharacterController@list');

Route::get('/rlp', 'DkpController@index');
Route::get('/rlp/upload', function () { 
	echo Form::open(array('url' => '/rlp/upload','files'=>'true'));
         echo 'Select the file to upload.';
         echo Form::file('raidlog');
         echo Form::submit('Upload File');
         echo Form::close();	
});
Route::post('/rlp/upload', 'DkpController@upload');