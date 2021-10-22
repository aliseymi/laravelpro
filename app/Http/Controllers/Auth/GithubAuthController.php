<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GithubAuthController extends Controller
{
    use TwoFactorAuthentication;
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $githubUser = Socialite::driver('github')->user();
            $user = User::where('email',$githubUser->email)->first();

            if(!$user){
                $user = User::create([
                    'name' => $githubUser->name,
                    'email' => $githubUser->email,
                    'password' => \Str::random(16),
                    'two_factor_type' => 'off'
                ]);
            }

            if(! $user->hasVerifiedEmail()){
                $user->markEmailAsVerified();
            }
            auth()->loginUsingId($user->id);
            return $this->loggedIn($request,$user) ? : redirect('/');
        }catch(\Exception $e){
            alert()->error('ورود با گیت هاب امکان پذیر نبود','خطایی رخ داد')->persistent('بسیار خب');
            return redirect('/login');
        }

    }
}
