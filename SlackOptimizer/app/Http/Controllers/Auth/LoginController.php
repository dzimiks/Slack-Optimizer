<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout', 'redirectToProvider', 'handleProviderCallback');
        $this->middleware('auth')->only('redirectToProvider', 'handleProviderCallback');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::with('slack')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @param Request $request
     * @return Response
     */
    public function handleProviderCallback(Request $request)
    {
        $slackUser = Socialite::driver('slack')->user();
        $user = User::find(Auth::user()->id);

        $user->slack_token = $slackUser->token;
        $user->team_name = $slackUser->team_name;
        $user->save();

        Auth::login($user);

        app('App\Http\Controllers\ChannelController')->get();
        app('App\Http\Controllers\ImController')->get();
        app('App\Http\Controllers\GroupController')->get();

        return redirect('/');
    }
}
