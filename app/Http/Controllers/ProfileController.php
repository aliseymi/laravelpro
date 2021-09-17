<?php

namespace App\Http\Controllers;

use App\Models\ActiveCode;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function manageTwoFactor()
    {
        return view('profile/twofactor');
    }

    public function postMangeTwoFactor(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:off,sms',
            'phone' => 'required_unless:type,off'
        ]);

        if ($data['type'] === 'sms') {
            if ($request->user()->phone_number !== $data['phone']) {
                // create a new code
                $code = ActiveCode::generateCode($request->user());
                $request->session()->flash('phone',$data['phone']);
                // send the code to user phone number\
                // TODO send SMS

                return redirect(route('profile.2fa.phone'));
            } else {
                $request->user()->update([
                    'two_factor_type' => 'sms'
                ]);
            }
        }

        if ($data['type'] === 'off') {
            $request->user()->update([
                'two_factor_type' => 'off'
            ]);
        }

        return back();
    }

    public function getPhoneVerify(Request $request)
    {
        if(!$request->session()->has('phone')){
            return redirect(route('profile.2fa.manage'));
        }
        $request->session()->reflash();
        return view('profile.phone-verify');
    }

    public function postPhoneVerify(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        if(!$request->session()->has('phone')){
            return redirect(route('profile.2fa.manage'));
        }

        $status = ActiveCode::verifyCode($request->token,$request->user());
        if ($status) {
            $request->user()->activeCode()->delete();
            $request->user()->update([
                'phone_number' => $request->session()->get('phone'),
                'two_factor_type' => 'sms'
            ]);

            alert()->success('شماره موبایل و احراز هویت دومرحله ای شما تایید شد','عملیات با موفقیت انجام شد');
        }else{
            alert()->error('شماره موبایل و احراز هویت دومرحله ای شما تایید نشد','عملیات با خطا مواجه شد');
        }
        return redirect(route('profile.2fa.manage'));
    }
}
