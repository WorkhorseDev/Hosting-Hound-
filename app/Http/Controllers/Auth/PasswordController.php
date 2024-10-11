<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class PasswordController extends Controller
{

    protected $redirectTo = '/login';
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);
        $new_password = Hash::make($validated['password']);
        $hashed_password = $request->user()->password;
        if (Hash::check($new_password, $hashed_password)) {
            return back()->withErrors(['password' => 'New password cannot match current password. Please create a new, unique password.']);
        }

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back();
    }

    public function reSend ()
    {
        return Inertia::render('Auth/ReSend');
    }
}
