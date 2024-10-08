<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\TwoFactorCode;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;

class TwoFactorController extends Controller
{
    public function index(): View
    {
        return view('auth.twoFactor');
    }
    public function store(Request $request): ValidationException|RedirectResponse
    {
        $request->validate([
            'two_factor_code' => ['integer', 'required'],
        ]);
        $user = auth()->user();
        if ($request->input('two_factor_code') !== $user->two_factor_code) {
            throw ValidationException::withMessages([
                'two_factor_code' => __("The code you entered doesn't match our records"),
            ]);
        }
        $user->resetTwoFactorCode();
        return redirect()->to(RouteServiceProvider::HOME);
    }
    public function resend(): RedirectResponse
    {
        $user = auth()->user();
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
        return redirect()->back()->withStatus(__('Code has been sent again'));
    }
}
