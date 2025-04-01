<?php

namespace App\Http\Controllers;

use App\Models\Websites;
use DateTime;
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
        $data = ["access_token" => $user->token, "expires_in" => $user->expiresIn, 'refresh_token' => $user->refreshToken];
        $authUser->google_token =  $data;
        $authUser->google_refresh_token = $user->refreshToken;
        $authUser->save();
        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        $filePath = storage_path('app/google-calendar/'.$authUser->_id.'.json');
        file_put_contents($filePath, $jsonData);
        auth()->login($authUser, true);

        $this->createGoogleCalendarEvent();
        return redirect()->route('profile');

    }
    public function createGoogleCalendarEvent() {

        $authUser = Auth::user();
        config(['google-calendar.token_json' =>  storage_path('app/google-calendar/'.$authUser->_id.'.json.')]);
        $googleClient = new Google_Client();
        $googleClient->setAccessToken( $authUser->google_token);
        if ($googleClient->isAccessTokenExpired()) {
            $googleClient->fetchAccessTokenWithRefreshToken($authUser->google_token);
            $authUser->google_token = $googleClient->getAccessToken();
            $authUser->save();
        }

      try {
          if ($authUser->google_calendar_id && !empty($authUser->google_calendar_id)) {
              $id = $authUser->google_calendar_id;
          } else {
              $googleClient->setAuthConfig(storage_path('app/google-calendar/oauth-credentials.json'));
              $googleClient->addScope(Google_Service_Calendar::CALENDAR);
              $service = new Google_Service_Calendar($googleClient);
              $calendar = new Google_Service_Calendar_Calendar();
              $calendar->setSummary('Hosting Hound');
              $calendar->setTimeZone('America/New_York');
              $createdCalendar = $service->calendars->insert($calendar);
              $id = $createdCalendar->getId();
              $authUser->google_calendar_id = $id;
              $authUser->save();
          }
          config(['google-calendar.calendar_id' => $id]);
          $event = new Event;
          $sites = Websites::all()->where('user_id', '=', Auth::user()->_id);
          $hosts = [];
          foreach ($sites as $site) {
              if (!empty($site->provider)) {
                  foreach ($site->provider as $key => $host) {
                      if (!empty($host['renewal_date'])) {
                          $hosts[] = $host;
                      }
                  }
              }
              if (!empty($site->software)) {
                  foreach ($site->software as $key => $soft) {
                      if (!empty($soft['renewal_date'])) {
                          $hosts[] = $soft;
                      }
                  }
              }
          }
          foreach ($hosts as $host) {
              $event->name = $host['name'];
              $date = DateTime::createFromFormat("d/m/Y" , $host['renewal_date']);
              $show_date = $date->format('Y-m-d');
              $event->startDate = Carbon::createFromFormat('Y-m-d', $show_date);
              $event->endDate = Carbon::createFromFormat('Y-m-d', $show_date);
              $event->save();
          }
      } catch (\Exception $e) {
          return $e->getMessage();
      }
        return redirect()->route('profile',['connected' => 'yes']);
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
