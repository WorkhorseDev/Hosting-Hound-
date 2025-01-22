<?php

namespace App\Models;

use App\Mail\ShareMail;
use Illuminate\Support\Facades\Auth;
use MongoDB\Laravel\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Mail;
class Websites extends Eloquent
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $connection = 'mongodb';
    protected $collection = 'websites';
    protected $fillable = ['_id', 'user_id', 'url', 'host', 'name', 'business_unit', 'tags', 'shared_with', 'notes', 'icon', 'company', 'color', 'hosts', 'provider', 'software'];

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
        if(!empty($data->shared_with)) {
            $usersNew = explode(",", $data->shared_with);
            $useOld =  explode(",", $site->shared_with);
            $res = array_diff($usersNew, $useOld);
            if(!empty($res)) {
                Websites::share(implode(",",$res));
            }
        }
        $uploadfile = '';
        if(isset($_FILES["file"]["name"])) {
            $fileName = time() . "_" . basename($_FILES["file"]["name"][1]);
            $data->file('file')[1]->move(public_path() . '/icon/', $fileName);
            $uploadfile = "/icon/" . $fileName;
        }
        $providers = [];
        $software = [];
        if (!empty($data->providers)) {
            $providers = $data->providers;
            foreach ($data->providers as $key => $host) {
                $providers[$key]['show'] = false;
                if(!empty($host['renewal_date'])) {
                    $providers[$key]['renewal_date'] = date("d/m/Y", strtotime($host['renewal_date']));
                }
            }
        }
        if (!empty($data->softwares)) {
            $software = $data->softwares;
            foreach ($data->softwares as $key => $host) {
                $software[$key]['showSoft'] = false;
                if(!empty($host['renewal_date'])) {
                    $software[$key]['renewal_date'] = date("d/m/Y", strtotime($host['renewal_date']));
                }
            }
        }
        $site->url = $data->url;
        $site->name = $data->name;
        $site->color = $data->color;
        $site->icon = $uploadfile != '' ? $uploadfile : $data->icon;
        $site->company = $data->company;
        $site->business_unit = $data->business_unit;
        $site->tags = $data->tags;
        $site->shared_with = $data->shared_with;
        $site->notes = $data->notes;
        $site->provider = $providers;
        $site->software = $software;
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
        $providers = [];
        $software = [];
        if (!empty($site->providers)) {
            $providers = $site->providers;
            foreach ($site->providers as $key => $host) {
                $providers[$key]['show'] = false;
                if(!empty($host['renewal_date'])) {
                    $providers[$key]['renewal_date'] = date("d/m/Y", strtotime($host['renewal_date']));
                }
            }
        }
        if (!empty($site->softwares)) {
            $software = $site->softwares;
            foreach ($site->softwares as $key => $host) {
                $software[$key]['showSoft'] = false;
                if(!empty($host['renewal_date'])) {
                    $software[$key]['renewal_date'] = date("d/m/Y", strtotime($host['renewal_date']));
                }
            }
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
            'provider' => $providers,
            'software' =>$software,
        ]);

        if(!empty($site->shared_with)) {
           Websites::share($site->shared_with);
        }

        return 'success';
    }

    public static function share($share_arr)
    {
        $users = explode(",", $share_arr);
        $email = "";
        foreach ($users as $user) {
            if(strpos($user, '@')) {
                $email = $user;
            } else {
                $user = User::get()->where('name', Auth::user()->name);
                $email = $user->email;
            }
            if (!empty($email)) {
                Mail::send('emails.share', ['name' => Auth::user()->name], function ($message) use ($user) {
                    $message->from('info@workhorsedev.com');
                    $message->subject("Shared site from HostingHound");
                    $message->to($user);
                });
            }
        }
    }
    public static function shareSites($data, $share)
    {
        foreach ($data as $site) {
            $siteEl = Websites::find($site);
            $siteEl->shared_with = $share;
            $siteEl->save();
        }
        Websites::share($share);
    }

    public static function unShareSites($data)
    {
        foreach ($data as $site) {
            $siteEl = Websites::find($site);
            $siteEl->shared_with = '';
            $siteEl->save();
        }
    }

}
