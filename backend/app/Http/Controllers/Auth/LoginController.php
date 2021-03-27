<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function redirectTo()
    {
        if (!Auth::user()) {
            return '/';
        }
        return
            route('users.show', ['name' => Auth::user()->name]);
    }

    // ログインボタンからのリンク
    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    // callback処理
    public function handleProviderCallback($provider)
    {
        $userSocial = Socialite::driver($provider)->stateless()->user();
        $user = User::where(['email' => $userSocial->getEmail()])->first();

        if ($user) {
            Auth::login($user);
            return redirect()->route('users.show', ['name' => $user->name]);
        }
        $newuser = new User;
        $newuser->name = $userSocial->getName();
        $newuser->email = $userSocial->getEmail();
        $newuser->save();

        Auth::login($newuser);
        return redirect()->route('users.show', ['name' => $newuser->name]);
    }

    protected function authenticated($request, $user)
    {
        return redirect(route('users.show', ['name' => Auth::user()->name]));
    }
}
