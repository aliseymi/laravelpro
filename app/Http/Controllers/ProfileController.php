<?php

namespace App\Http\Controllers;

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

        if($data['type'] === 'sms'){
            // validation phone number
        }

        if($data['type'] === 'off'){
            $request->user()->update([
                'two_factor_type' => 'off'
            ]);
        }

        return back();
    }
}
