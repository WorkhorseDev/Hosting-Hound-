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
     * Show the application dashboard
     */
    public function dashboard()
    {
        $sites = Websites::all()->where('user_id', '=', Auth::user()->_id);
        $data = $sites->toArray();
        $allSite = Websites::all();
        foreach ($allSite as $site) {
            if (str_contains($site->shared_with, Auth::user()->email)) {
                $site->readonly = true;
                array_push($data, $site);
            }
        }
        return Inertia::render('Dashboard', [
            'sites' => $data,
        ]);
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
        return Inertia::render('EditSite', [ 'site' => $site]);
    }

    public function showAddSitePage()
    {
        return Inertia::render('AddSite');
    }

    public function showSiteDetailPage()
    {
        $site = Websites::find(request('id'));
        if (str_contains($site->shared_with, Auth::user()->email)) {
            $site->readonly = true;
        }
        return Inertia::render('DetailSite', [
            'site' => $site,
        ]);
    }

    public function shareSites(Request $request)
    {
       Websites::shareSites($request->sitesList ,$request->share);
    }

    public function unShareSites(Request $request)
    {
        Websites::unShareSites($request->sitesList);
    }
}
