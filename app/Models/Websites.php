<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Websites extends Eloquent
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $connection = 'mongodb';
    protected $collection = 'websites';
    protected $fillable = ['_id', 'user_id', 'url', 'name', 'business_unit', 'tags', 'shared_with', 'notes', 'icon', 'company', 'color', 'hosts', 'provider', 'software'];

    /**
     * Delete sites
     *
     * @param array $sites
     * @return string success
     */
    public static function deleteSites(array $sites)
    {
        foreach ($sites as $site) {
            $siteEl = Websites::find($site);
            $siteEl->delete();
        }

        return 'success';
    }

    /**
     * Edit site detail
     *
     * @param array $site
     * @return string success
     */
    public static function editSite(array $site)
    {
        $site = Websites::find($site['id']);
        $site->url = $site['url'];
        $site->name = $site['name'];
        $site->color = $site['color'];
        $site->icon = $site['icon'];
        $site->company = $site['company'];
        $site->bu = $site['bu'];
        $site->tags = $site['tags'];
        $site->shared_with = $site['shared_with'];
        $site->notes = $site['notes'];
        $site->service_provider = $site['providers'];
        $site->software = $site['softwares'];
        $site->save();
        return 'success';
    }

    /**
     * Add new site
     *
     * @param array $site
     * @return string success
     */
    public static function addSite($site)
    {
        $uploadfile = '';
        if(isset($_FILES["file"]["name"])) {
            $fileName = time() . "_" . basename($_FILES["file"]["name"][1]);
            $site->file('file')[1]->move(public_path() . '/icon/', $fileName);
            $uploadfile = "/icon/" . $fileName;
        }
         Websites::create([
            'user_id' => Auth::user()->_id,
            'name' => $site->name,
            'url' => $site->url,
            'color' => $site->color,
            'icon' => $uploadfile,
            'company' => $site->company,
            'business_unit' => $site->business_unit,
            'tags' => $site->tags,
            'shared_with' => $site->shared_with,
            'notes' => $site->notes,
            'provider' => isset($site->providers) ? $site->providers : '',
            'software' => isset($site->softwares) ? $site->softwares : '',
        ]);

        return 'success';
    }

}
