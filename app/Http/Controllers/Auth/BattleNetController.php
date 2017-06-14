<?php

namespace App\Http\Controllers\Auth;

use Auth;

use App\User;
use App\BattleNetAuth;

use Carbon\Carbon;

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
    protected $redirectTo = '/home';

    public function __construct()
    {
        // $this->middleware('guest')->except(['logout']);
    }

    public function redirectToProvider($provider)
    {
        return Socialite::with($provider)->scopes(['wow.profile', 'sc2.profile'])->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $oauth = Socialite::with($provider)->user();

        // if (Auth::check()) {
        //     $authUser = $this->updateUserToken($oauth, $provider);
        // } else {
           if ($authUser = $this->findOrCreateUser($oauth, $provider)) {
                Auth::login($authUser, true);
            } else {
                return redirect('error')->with('status','Your user is inactive. If you think this is an error please contact an administartor.');
            }
         
        // }
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
        if ($authUser && true === $authUser->active) {
            $authUser->updateToken($oauth->token);
            return $authUser;
        } else if ($authUser && false === $authUser->active) {
            return $authUser->active;
        } else {
            $user = User::create([
                'name'     => $oauth->nickname,
                'email'    => $oauth->email,
                'provider' => $provider,
                'provider_id' => $oauth->id,
                'active'    => true
                ]);

            $user->bnet()->create([
                'access_token'  => $oauth->token,
                'expires'       => Carbon::now()->addSeconds($oauth->expiresIn)->timestamp,
                'scope'         => $oauth->accessTokenResponseBody['scope']
                ]);

            $user->activateUser();

            return $user;
        }
    }
}
