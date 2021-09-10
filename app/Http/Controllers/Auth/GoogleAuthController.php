<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->email)->first();
            if ($user) {
                auth()->loginUsingId($user->id);
            } else {
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(\Str::random(16))
                ]);
                auth()->loginUsingId($newUser->id);
            }
            return redirect('/');
        } catch (\Exception $e) {
            //TODO show error
            alert()->error('ورود با حساب گوگل امکان پذیر نبود','خطایی رخ داد')->persistent('بسیار خب');
            return redirect('/login');
        }
    }
}
