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
        $newUser = new User;
        $newUser->name = $userSocial->getName();
        $newUser->email = $userSocial->getEmail();
        $newUser->save();

        Auth::login($newUser);
        return redirect()->route('users.show', ['name' => $newUser->name]);
    }

    protected function authenticated($request, $user)
    {
        return redirect(route('users.show', ['name' => Auth::user()->name]));
    }
}
