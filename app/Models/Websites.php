<?php

namespace App\Models;

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
    protected $fillable = ['_id', 'user_id', 'url', 'name', 'bu', 'tags', 'shared_with', 'notes', 'icon', 'company', 'color', 'hosts', 'domain_provider',
        'ssl_provider', 'email_provider', 'cms', 'service_type', 'service_name', 'server_type', 'renewal_type', 'cost', 'renewal_date','service_provider', 'software', 'passsword'];

    /**
     * Delete sites
     *
     * @param array $sites
     * @return string success
     */
    public static function deleteSites(array $sites)
    {
        foreach ($sites as $site) {
            $file = Websites::find($site);
            $file->delete();
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
        $site->service_provider = $site['service_provider'];
        $site->software = $site['software'];
        $site->save();
        return 'success';
    }

    /**
     * Add new site
     *
     * @param array $site
     * @return string success
     */
    public static function addSite(array $site)
    {
        $site = Websites::create([
            'user_id' => $site['id'],
            'name' => $site['name'],
            'url' => $site['url'],
            'color' => $site['color'],
            'icon' => $site['icon'],
            'company' => $site['company'],
            'bu' => $site['bu'],
            'tags' => $site['tags'],
            'shared_with' => $site['shared_with'],
            'notes' => $site['notes'],
            'service_provider' => $site['service_provider'],
            'software' => $site['software'],
        ]);

        return 'success';
    }

}
