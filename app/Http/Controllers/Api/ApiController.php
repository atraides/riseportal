<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;

class ApiController extends Controller
{
    /**
     * Checks if the given value is uniq within the given type.
     *
     * @param  string  $type
     * @param  string  $value
     * @return \Illuminate\Http\Response
     */
    public function uniq($type, $value)
    {
    	if (in_array($type,['name', 'email'])) {
        	$user = User::where($type, $value)->get();

	        if ($user->isEmpty()) {
	            return response()->json(['status' => '200','statusText' => 'OK', 'message' => "$value is uniq within ${type}s.", 'uniq' => true],200);
	        } else {
	            return response()->json(['status' => '200','statusText' => 'OK', 'message' => "$value is already exists within ${type}s.", 'uniq' => false],200);
        	}
        } else {
        	return response()->json(['status' => '501','statusText' => 'Not Implemented', 'message' => "This type ($type) cannot be checked for uniqness with the API."],503);
        }
    }
}
