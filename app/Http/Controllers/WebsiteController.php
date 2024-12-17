<?php

namespace App\Http\Controllers;

use App\Models\Websites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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
        $companies = [];
        foreach ($sites as $site) {
            if (!empty($site['company'])) {
                array_push($companies, $site['company']);
            }
            if (!empty($site->provider)) {
                foreach ($site->provider as $host) {
                    if (!empty($host['renewal_type']) && !empty($host['renewal_date'])) {
                        $data = ['id' => $site->_id, 'icon' => $site->icon, 'provider' => $host, 'url' => $site->url, 'color' => $site->color, 'company' => $site->company];
                        $hosts[] = $data;
                    }
                }
            }
            if (!empty($site->software)) {
                foreach ($site->software as $soft) {
                    if (!empty($soft['renewal_type']) && !empty($host['renewal_date'])) {
                        $data = ['id' => $site->_id, 'icon' => $site->icon, 'provider' => $soft, 'url' => $site->url, 'color' => $site->color, 'company' => $site->company];
                        $hosts[] = $data;
                    }
                }
            }
        }

        return Inertia::render('Billing', ['sites' => $hosts, 'companies' => array_unique($companies)]);
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

    public function editSiteView()
    {
        $site = Websites::find(request('id'));
        return Inertia::render('EditSite', ['site' => $site]);
    }

    public function showAddSitePage()
    {
        return Inertia::render('AddSite');
    }

    public function showSiteDetailPage()
    {
        $site = Websites::find(request('id'))->first();
        if (str_contains($site->shared_with, Auth::user()->email)) {
            $site->readonly = true;
        }

        return Inertia::render('DetailSite', ['site' => $site]);
    }

    public function shareSites(Request $request)
    {
        Websites::shareSites($request->sitesList, $request->share);
    }

    public function unShareSites(Request $request)
    {
        Websites::unShareSites($request->sitesList);
    }
}
