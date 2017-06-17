<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function newUser(User $user)
    {
        if (!$user->name or !$user->email) {
            $attributes = json_encode([ 
                'user_id' => $user->id,
                'no_modal' => false,
                'new_user' => true
            ]);
            return view('newuser', compact('attributes'));
        } else {
            return redirect('/home');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $response = 'OK';
        // if ($user->id == Auth::user()->id) { // Need to be an API...
        if (validator($request->all())) {
            $user->update($request->all());
            if ($request->input('name') && $user->name == $request->input('name') && $response == 'OK') {
                $response = 'OK';
            } else {
                $response = 'ERROR';
            }
            if ($request->input('email') && $user->email ==$request->input('email') && $response == 'OK') {
                $response = 'OK';
            } else {
                $response = 'ERROR';
            }

            if ($response = 'OK') {
                return response()->json(['status' => 200, 'statusText' => 'OK' ,'reasonPhrase' => 'User successfully updated.']);
            } else { 
                return response()->json(['status' => 500, 'statusText' => 'NOK' ,'reasonPhrase' => 'We could not update the requested user.']);
            }
        // } else {
            return response()->json(['status' => 403, 'statusText' => 'Not Authorized' ,'reasonPhrase' => 'Your are not authorize to update this user.']);
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
