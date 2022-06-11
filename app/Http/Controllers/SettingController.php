<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class SettingController extends BaseController
{
    public function index()
    {
        if(permission('setting-access')) {
            $this->setPageData('Setting','Setting','fas fa-cogs');
            $zones_array = [];
            $timestamp = time();
            foreach (timezone_identifiers_list() as $key => $zone) {
                date_default_timezone_set($zone);
                $zones_array[$key]['zone'] = $zone;
                $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT '.date('P',$timestamp);
            }
            return view('setting.index',compact('zones_array'));
        }else{
            return $this->unauthorized_access_blocked();
        }
    }
}
