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
     * @param $site
     * @return string success
     */
    public static function editSite($data)
    {
        $site = Websites::find($data->id);
        $site->url = $data->url;
        $site->name = $data->name;
        $site->color = $data->color;
        $site->icon = $data->icon;
        $site->company = $data->company;
        $site->business_unit = $data->business_unit;
        $site->tags = $data->tags;
        $site->shared_with = $data->shared_with;
        $site->notes = $data->notes;
        $site->provider = $data->providers;
        $site->software = $data->softwares;
        $site->save();

        return 'success';
    }

    /**
     * Add new site
     *
     * @param  $site
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
