<?php

namespace App\Http\Controllers\Auth;

use Auth;

use App\User;
use App\BattleNetAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;

class BattleNetController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider($provider)
    {
        return Socialite::with($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $oauth = Socialite::with($provider)->user();
        $authUser = $this->findOrCreateUser($oauth, $provider);
        Auth::login($authUser, true);
        return redirect($this->redirectTo);
    }


    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($oauth, $provider)
    {
        $authUser = User::where('provider_id', $oauth->id)->first();
        if ($authUser) {
            return $authUser;
        }
        $user = User::create([
            'name'     => $oauth->nickname,
            'email'    => $oauth->email,
            'provider' => $provider,
            'provider_id' => $oauth->id,
            ]);

        return $user->bnet()->create([
            'access_token'  => $oauth->token,
            'expires'       => $oauth->expiresIn
            ]);
    }
}
