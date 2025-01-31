<?php

namespace App\Http\Controllers;

use Google\Service\Calendar;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Calendar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;
use Spatie\GoogleCalendar\Event;
use Spatie\GoogleCalendar\GoogleCalendar;
use Carbon\Carbon;
use App\Models\User;
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

    public function redirectToGoogle()
    {
        $scopes = [
            'https://www.googleapis.com/auth/userinfo.email',
            'https://www.googleapis.com/auth/userinfo.profile',
            'openid',
            'https://www.googleapis.com/auth/calendar',
            'https://www.googleapis.com/auth/calendar.events'
        ];

        return Socialite::driver('google')
            ->scopes($scopes)
            ->with(["access_type" => "offline", "prompt" => "consent"])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        $authUser = Auth::user();
        $authUser->google_email = $user->getEmail();
        $authUser->google_id = $user->getId();
        $authUser->google_token = ["access_token" => $user->token, "expires_in" => $user->expiresIn, 'refresh_token' => $user->refreshToken];
        $authUser->google_refresh_token = $user->refreshToken;
        $authUser->save();
        auth()->login($authUser, true);
        return redirect()->route('profile');

    }
    public function createGoogleCalendarEvent() {

        $authUser = Auth::user();
        $googleClient = new Google_Client();
        $googleClient->setAccessToken( $authUser->google_token);
        if ($googleClient->isAccessTokenExpired()) {
            $googleClient->fetchAccessTokenWithRefreshToken($authUser->google_token);
            $authUser->google_token = $googleClient->getAccessToken();
            $authUser->save();
        }

      try {
          $googleClient->setAuthConfig(storage_path('app/google-calendar/oauth-credentials.json'));
          $googleClient->addScope(Google_Service_Calendar::CALENDAR);
          $service = new Google_Service_Calendar($googleClient);
          $calendar = new Google_Service_Calendar_Calendar();
          $calendar->setSummary('Hosting Hound');
          $calendar->setTimeZone('America/New_York');

          // Insert the calendar
          $createdCalendar = $service->calendars->insert($calendar);
          $id = $createdCalendar->getId();
          config(['google-calendar.calendar_id'=> $id]);
          $event = new Event;
          $event->name = 'Test New';
          $event->startDateTime = Carbon::now();;
          $event->endDateTime = Carbon::now()->addHour();
          $event->save();
          $events = Event::get();
          return response()->json(['message' => 'Event created successfully.', 'event_id' => $event->id,]);
      } catch (\Exception $e) {
          dd($e->getMessage());
      }
        //return redirect()->route('profile');
    }

    /**
     * Update the user's profile information.
     */
    public function editProfile(Request $request)
    {
        if(!empty($request->google_email)){
//            $event = new Event;
//            $event->name = 'A new event';
//            $event->description = 'Event description';
//            $event->startDateTime = Carbon::now();
//            $event->endDateTime = Carbon::now()->addHour();
//            $event->addAttendee([
//                'email' => $request->google_email,
//                'name' => 'John Doe',
//                'comment' => 'Lorum ipsum',
//                'responseStatus' => 'needsAction',
//            ]);
//            $event->addAttendee(['email' => $request->google_email]);
//            $event->save();
//            Event::create([
//                'name' => 'A new event',
//                'startDateTime' => Carbon::now(),
//                'endDateTime' => Carbon::now()->addHour(),
//            ]);
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
