<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActiveCode;
use App\Notifications\LoginToWebsite;
use App\Notifications\LoginToWebsite as LoginToWebsiteNotification;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class AuthTokenController extends Controller
{
    public function getToken(Request $request)
    {
        if(!$request->session()->has('auth')){
            return redirect('login');
        }

        $request->session()->reflash();

        return view('auth.token');
    }

    public function postToken(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        if(!$request->session()->has('auth')){
            return redirect(route('login'));
        }

        $user = \App\Models\User::findOrFail($request->session()->get('auth.user_id'));
        $status = ActiveCode::verifyCode($request->token,$user);

        if(!$status){
            alert()->error('کد صحیح نبود','خطا');
            return redirect(route('2fa.token'));
        }

        if(auth()->loginUsingId($user->id,$request->session()->get('auth.remember'))){
            $user->notify(new LoginToWebsiteNotification());
            $user->activeCode()->delete();
            alert()->success('با موفقیت لاگین شدید','کد صحیح است');
            return redirect('/');
        }

        return redirect(route('login'));
    }
}
