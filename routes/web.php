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

Auth::routes();
Route::get('oauth/{provider}', 'Auth\BattleNetController@redirectToProvider');
Route::get('oauth/{provider}/callback', 'Auth\BattleNetController@handleProviderCallback');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () { return view('welcome'); });

Route::get('/rlp', 'DkpController@index');
Route::get('/rlp/upload', function () { 
	echo Form::open(array('url' => '/rlp/upload','files'=>'true'));
         echo 'Select the file to upload.';
         echo Form::file('raidlog');
         echo Form::submit('Upload File');
         echo Form::close();	
});
Route::post('/rlp/upload', 'DkpController@upload');