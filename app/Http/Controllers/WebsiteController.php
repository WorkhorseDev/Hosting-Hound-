<?php

namespace App\Http\Controllers;

use App\Models\Websites;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;


class WebsiteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application billing page
     */
    public function billing()
    {
        $sites = Websites::all()->where('user_id', '=', Auth::user()->_id);
        $hosts = [];
        $hostName = [];
        $hostType = [];
        $companies = [];
        $names = [];
        foreach ($sites as $site) {
            if (!empty($site['company'])) {
                array_push($companies, $site['company']);
            }
            if (!empty($site->provider)) {
                foreach ($site->provider as $key=>$host) {
                    $hostType[] = $host['type'];
                    $hostName[$host['type']][] = $host['name'];
                    $names[] = $host['name'];
                    if(!empty($host['renewal_type']) && !empty($host['renewal_date'])) {
                        $data = ['key' => $key, 'id' => $site->_id, 'icon' => $site->icon, 'provider' => $host, 'url' => $site->url, 'color' => $site->color, 'company' => $site->company];
                        $hosts[] = $data;
                    }
                }
            }
            if (!empty($site->software)) {
                foreach ($site->software as $key => $soft) {
                    if(!empty($soft['renewal_type']) && !empty($soft['renewal_date'])) {
                        $data = ['key' => $key, 'id' => $site->_id, 'icon' => $site->icon, 'provider' => $soft, 'url' => $site->url, 'color' => $site->color, 'company' => $site->company];
                        $hosts[] = $data;
                    }
                }
            }
        }

        return Inertia::render('Billing', ['sites' => $hosts, 'companies' => array_unique($companies), 'hosts' => array_unique($hostType), 'hostName' => $hostName, 'namesHost' => $names] );
    }

    /**
     * Show the application dashboard
     */
    public function dashboard()
    {
        $sites = Websites::all()->where('user_id', '=', Auth::user()->_id);
        $data = $sites->toArray();
        $allSite = Websites::all();
        $companies = [];
        $hosts = [];
        $providers = [];
        $sslArr = [];
        $emails = [];
        $cms = [];
        foreach ($allSite as $site) {
            if (str_contains($site->shared_with, Auth::user()->email)) {
                $site->readonly = true;
                array_push($data, $site);
            }
        }
        foreach ($data as $site) {
            if (!empty($site['company'])) {
                array_push($companies, $site['company']);
            }
            if (!empty($site['provider'])) {
                foreach ($site['provider'] as $host) {
                    if (isset($host['type'])) {
                        if ($host['type'] == 'Host')
                            array_push($hosts, $host['name']);
                        if ($host['type'] == 'Domain Register')
                            array_push($providers, $host['name']);
                        if ($host['type'] == 'SSL Provider')
                            array_push($sslArr, $host['name']);
                        if ($host['type'] == 'Email Plan Provider')
                            array_push($emails, $host['name']);
                    }
                }
            }
            if (!empty($site['software'])) {
                foreach ($site['software'] as $host) {
                    if (isset($host['type'])) {
                        if ($host['type'] == 'CMS')
                            array_push($cms, $host['name']);
                    }
                }
            }
        }
        return Inertia::render('Dashboard', ['sites' => $data, 'companies' => array_unique($companies), 'hosts' => array_unique($hosts), 'providers' => array_unique($providers), 'sslArr' => array_unique($sslArr), 'emails' => $emails, 'cms' => $cms]);
    }

    /**
     * Delete sites
     */
    public function deleteSites(Request $request)
    {
        Websites::deleteSites($request->sitesList);
    }

    /**
     * Edit site
     */
    public function editSite(Request $request)
    {
        $result = Websites::editSite($request);
    }

    /**
     * Add site
     */
    public function saveSite(Request $request)
    {
        Websites::addSite($request);

    }

    /**
     * Show edit page for site
     */
    public function editSiteView()
    {
        $site = Websites::find(request('id'));
        return Inertia::render('EditSite', ['site' => $site]);
    }

    /**
     * Show add page for site
     */
    public function showAddSitePage()
    {
        return Inertia::render('AddSite');
    }

    /**
     * Show detail page for site
     */
    public function showSiteDetailPage()
    {
        $site = Websites::find(request('id'));
        if (str_contains($site->shared_with, Auth::user()->email)) {
            $site->readonly = true;
        }

        return Inertia::render('DetailSite', ['site' => $site]);
    }

    /**
     * Show detail page for host
     */
    public function showHostDetailPage()
    {
        $site = Websites::find(request('id'));
        $data = [];
        if($site->provider[request('key')]) {
            $data = $site->provider[request('key')];
        } else {
            $data = $site->software[request('key')];
        }
        return Inertia::render('HostDetailSite', [
            'site' => $site,
            'provider' => $site->provider[request('key')]
        ]);
    }

    /**
     * Share site
     */
    public function shareSites(Request $request)
    {
        Websites::shareSites($request->sitesList, $request->share);
    }

    /**
     * UnShare site
     */
    public function unShareSites(Request $request)
    {
        Websites::unShareSites($request->sitesList);
    }

    /**
     * Verify renewal dates
     */
    public static function verifyRenewalDates()
    {
        $users = User::all()->where('notification', '=', true);
        foreach ($users as $user) {
            $websites  = Websites::all()->where('user_id', '=',$user->_id);
            foreach ($websites as $website) {
                if($website->provider) {
                    foreach ($website->provider as $provider) {
                        if(!empty($provider['renewal_date'])) {
                            self::sendEmails($website->name, $provider['renewal_date'], $provider['name'], $user);
                        }
                    }
                    foreach ($website->software as $software) {
                        if(!empty($software['renewal_date'])) {
                            self::sendEmails($website->name, $software['renewal_date'], $software['name'], $user);
                        }
                    }
                }
            }
        }
    }

    /**
     * Send emails
     */
    public static function sendEmails($websiteName, $renewalDate, $serviceName, $user)
    {
        $send = false;
        $date = date('d/m/Y');
        if ($user->frequency['dayOfDeadline'] && $renewalDate == $date) {
            $send = true;
        }
        if($user->frequency['dayBeforeDeadline']) {
            $day_before = date( 'd/m/Y', strtotime( $renewalDate . ' -1 day' ) );
            if($date == $day_before) {
                $send = true;
            }
        }
        if($user->frequency['oneWeek']) {
            $day_before = date( 'd/m/Y', strtotime( $renewalDate . ' -7 day' ) );
            if($date == $day_before) {
                $send = true;
            }
        }
        if($user->frequency['twoWeek']) {
            $day_before = date( 'd/m/Y', strtotime( $renewalDate . ' -14 day' ) );
            if($date == $day_before) {
                $send = true;
            }
        }
        if($send) {
            $email = $user->email;
            Mail::send('emails.renewal-date', ['serviceName' => $serviceName, 'websiteName' => $websiteName, 'renewalDate'=>$renewalDate], function ($message) use ($email,$serviceName,$renewalDate) {
                $message->from('info@workhorsedev.com');
                $message->subject("Hosting Hound - ". $serviceName. " is Renewing on ". $renewalDate);
                $message->to($email);
            });
        }
    }
}
