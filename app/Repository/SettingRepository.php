<?php

namespace App\Repository;

use Illuminate\Support\Facades\Auth;
use App\Traits\AuthTait;
use App\Models\Setting;
class SettingRepository
{
    use AuthTait;
    public function  __construct()
    {

    }
    public function getAll()
    {
       return Setting::all();
    }
    public function  exitsByKey($key)
    {
        $setting=Setting::where('key',$key)->first();
        return $setting ?true :false;
    }
    public function  saveSetting($setting)
    {
        return Setting::firstOrCreate($setting);
    }


}
