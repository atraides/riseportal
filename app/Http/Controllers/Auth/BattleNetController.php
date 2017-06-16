<?php

namespace App\Http\Controllers\Auth;

use Auth;

use App\User;
use App\BattleNetAuth;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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

    public function redirectToProvider(Request $request, $provider)
    {
        if (Auth::check() && $request->query('redirectBack')) {
            Cache::put(implode('.',['battlenet_redirect',Auth::user()->id]),$request->query('redirectBack'),60);
        }

        return Socialite::with($provider)->scopes(['wow.profile', 'sc2.profile'])->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        if ($error = $request->get('error')) {
            return redirect('/')->with('Error the OAuth provider has given an error: '.$error. ' -- '.$request->get('error_description'));
        }

        try {
            $oauth = Socialite::with($provider)->user();   
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return redirect('/')->with('Error the OAuth provider has given an error: '.$error. ' -- '.$e->getResponse()->getBody());
        }

        $authUser = $this->findOrCreateUser($oauth, $provider);

        if ( is_a($authUser,'App\User') ) {
            Auth::login($authUser, true);
        } else if ( is_array($authUser) && (array_key_exists('status', $authUser) && array_key_exists('user', $authUser)) ) {
            if (is_a($authUser['user'],'App\User') && $authUser['status'] == 'newuser') {
                Auth::login($authUser['user'], true);
                return redirect('/user/'.$authUser['user']->id.'?newUser=1');
            }
        } else {
            return redirect('error')->with('status','Your user is inactive. If you think this is an error please contact an administartor.');
        }

        if (Auth::check() && $cacheRedirect = Cache::get(implode('.',['battlenet_redirect',Auth::user()->id]))) {
            return redirect($cacheRedirect);
        } else {
            return redirect($this->redirectTo);    
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handleLogout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout(auth()->user());
            $request->session()->flush();
            $request->session()->regenerate();

            $response = [
                'status' => 200,
                'statusText' => 'OK',
                'details' => [
                    'reasonPhrase' => 'Successfully logged out.'
                ]
            ];
        } else {
            $response = [
                'status' => 200,
                'statusText' => 'OK',
                'details' => [
                    'reasonPhrase' => 'User is not logged it. Nothing to logout.'
                ]
            ];
        }

        if (request()->expectsJson()) {
            return response()->json($response,$response['status'] ? 200 : $response['status']);
        } else {
            return redirect('/');
        }
    }

    /**
     * Delete the user account from the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteAccount(Request $request, User $user)
    {
        if (Auth::check()) {
            if ($user->id == auth()->user()->id) {
                $user->bnet()->delete();
                $user->characters()->where('guild','!=','Rise Legacy')->delete();
                $user->characters()->where('guild', null)->delete();
                $user->characters()->update(['user_id' => 1,'main' => false, 'lastModified' => 0]);
                if ($user->delete()) {
                    $response = [
                        'status' => 200,
                        'statusText' => 'OK',
                        'details' => [
                            'reasonPhrase' => 'User successfully deleted from the database.'
                        ]
                    ];    
                } else { 
                    $response = [
                        'status' => 500,
                        'statusText' => 'Internal Server Error',
                        'details' => [
                            'reasonPhrase' => 'We could not delete the user.'
                        ]
                    ];    
                }
            } else {
                $response = [
                    'status' => 403,
                    'statusText' => 'Not Authorized',
                    'details' => [
                        'reasonPhrase' => 'You are not authorized to delete this user.'
                    ]
                ];
            }
        } else {
            $response = [
                'status' => 200,
                'statusText' => 'OK',
                'details' => [
                    'reasonPhrase' => 'User is not logged it. Nothing to delete.'
                ]
            ];
        }

        if (request()->expectsJson()) {
            return response()->json($response,$response['status'] ? 200 : $response['status']);
        } else {
            if ($response['status'] == 200) {
                return redirect('/logout');
            } else {
                return redirect('/error')->with($response);
            }
        }
    }

    

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handleLogin(Request $request)
    {
        return redirect('/oauth/battlenet');
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

            return (['user' => $user, 'status' => 'newuser']);
        }
    }
}
