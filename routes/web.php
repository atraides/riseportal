<?php
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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function () { return view('welcome'); });

Route::get('oauth/{provider}', 'Auth\OAuthProvidersController@redirectToProvider');
Route::get('oauth/{provider}/callback', 'Auth\OAuthProvidersController@handleProviderCallback');

Route::get('/error', 'ErrorsController@show');
Route::get('/logout','Auth\OAuthProvidersController@handleLogout')->name('logout');
Route::get('/login','Auth\OAuthProvidersController@handleLogin')->name('login');
Route::delete('/user/{user}','Auth\OAuthProvidersController@deleteAccount');
Route::get('/user/{user}','UsersController@show');
Route::get('/user/{user}/new','UsersController@newUser')->name('newuser');
Route::patch('/user/{user}','UsersController@update');


Route::get('/guild', 'GuildController@show');
Route::get('/guild/roster', 'GuildController@show');
Route::get('/character', 'CharacterController@index');
// Route::get('/character/list', 'CharacterController@list');
Route::patch('/character/{character}', 'CharacterController@update');
// Route::get('/user/{user}/characters', 'CharacterController@list');

// Route::get('/rlp', 'DkpController@index');
// 	echo Form::open(array('url' => '/rlp/upload','files'=>'true'));
//          echo 'Select the file to upload.';
//          echo Form::file('raidlog');
//          echo Form::submit('Upload File');
//          echo Form::close();	
// });
// Route::post('/rlp/upload', 'DkpController@upload');