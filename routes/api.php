<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
	Route::get('/user', function (Request $request) { return $request->user(); });
	Route::get('/uniq/{type}/{value}','Api\ApiController@uniq');
	Route::post('/update/user/{user}/characters','Api\ApiController@updateCharcterData');
	Route::get('/poll/{poll}','Api\ApiController@pollDetails');
	Route::post('/vote','Api\ApiController@vote');
});
