<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Auth/ResetPassword', [
            //'email' => $request->email,
            'token' => $request->route('token'),
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $link  = $_SERVER['HTTP_REFERER'];
        $arrayEmail = explode('email=',$_SERVER['HTTP_REFERER']);
        $email  = urldecode($arrayEmail[1]);
//        $request->validate([
//            'token' => 'required',
//            //'email' => 'required|email',
//            'password' => ['required', 'confirmed', Rules\Password::defaults()],
//        ]);
        $user = User::where('email',$email)->first();
        $request->validate([
            'token' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (Hash::check($value, $user->password)) {
                    return $fail(__('New password cannot match current password. Please create a new, unique password.'));
                }
            }],
        ]);
        $request->email = $email;
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            //$request->only('password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        //if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login');
        //}

//        throw ValidationException::withMessages([
//            'email' => [trans($status)],
//        ]);
    }
}
