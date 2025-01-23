<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        $user = Auth::user();
        $user->pass = base64_decode(Auth::user()->pass);
        return Inertia::render('Profile/Edit',['user'=> $user]);
    }

    /**
     * Update the user's profile information.
     */
    public function editProfile(Request $request)
    {
        if(!empty($request->google_email)){
            $event = new Event;
            $event->name = 'A new event';
            $event->description = 'Event description';
            $event->startDateTime = Carbon::now();
            $event->endDateTime = Carbon::now()->addHour();
            $event->addAttendee([
                'email' => $request->google_email,
                'name' => 'John Doe',
                'comment' => 'Lorum ipsum',
                'responseStatus' => 'needsAction',
            ]);
            $event->addAttendee(['email' => $request->google_email]);
            dd($event->save());
        }
        $user = Auth::user();
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        if($user->pass != base64_encode($request->password)) {
            $user->password = Hash::make($request->password);
            $user->pass = base64_encode($request->password);
        }
        $user->notification = $request->notification;
        $user->frequency = $request->frequency;
        $user->google_email = $request->google_email;
        $user->save();
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function showTermsAndCondition()
    {
        return Inertia::render('TermsAndCondition');
    }
}
