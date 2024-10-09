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
        return Inertia::render('TwoFactor', ['email' =>  auth()->user()->email]);
    }
    public function store(Request $request): ValidationException|RedirectResponse
    {
        $request->validate([
            'two_factor_code' => 'integer|required',
        ]);

        $user = auth()->user();

        if($request->input('two_factor_code') == $user->two_factor_code)
        {
            $user->resetTwoFactorCode();

            return redirect()->intended('/dashboard');
        }

        return redirect()->back()->withErrors(['two_factor_code' => 'The two factor code you have entered does not match']);

    }
    public function resend(): RedirectResponse
    {
        $user = auth()->user();
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
        return redirect()->back()->withStatus(__('Code has been sent again'));
    }
}
