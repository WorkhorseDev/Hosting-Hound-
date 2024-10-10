<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\TwoFactorCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Inertia\Inertia;

class TwoFactorController extends Controller
{
    public function index()
    {
        return Inertia::render('TwoFactor', ['email' =>  Auth::user()->email]);
    }
    public function store(Request $request): ValidationException|RedirectResponse
    {
        $request->validate([
            'code' => 'integer|required',
        ]);

        $user = auth()->user();

        if($request->input('code') == $user->two_factor_code)
        {
            $user->resetTwoFactorCode();

            return redirect()->intended('/dashboard');
        }

        return redirect()->back()->withErrors(['two_factor_code' => 'The two factor code you have entered does not match']);

    }
    public function resend()
    {
        $user = auth()->user();
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());

        return Inertia::render('TwoFactor', ['reSend' => true]);
    }
}
