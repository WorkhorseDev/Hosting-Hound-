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
        return Inertia::render('Dashboard', [
            'sites' => $sites,
        ]);
    }

    /**
     * Delete sites
     */
    public function deleteSites(Request $request)
    {
        $result = Websites::deleteSites($request->sites);
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
    public function addSite(Request $request)
    {
        $result = Websites::addSite($request);
    }

    public function showAddSitePage()
    {
        return Inertia::render('AddSite');
    }
}
