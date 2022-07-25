<?php

namespace App\Http\Controllers;

use App\Models\AssignDevice;
use App\Models\Device;
use App\Models\DeviceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $auth_user = auth()->user();
        $devices = Device::query();

        if($auth_user->user_type == 'user'){
            $devices = $devices->where('user_id',$auth_user->id);
        }

        $device['total'] = $devices->count();
        $device['updated'] = $devices->where('condition',1)->count();

        $_device_types = DeviceType::all();

        $device_types = [];
        foreach ($_device_types as $type){
            $_temp = [];
            $_device = Device::where('device_type_id',$type->id);

            if($auth_user->user_type == 'user'){
                $_device = $_device->where('user_id',$auth_user->id);
            }

            $_temp['id'] = $type->id;
            $_temp['name'] = $type->name;
            $_temp['total'] = $_device->count();
            $_temp['updated'] = $_device->where('condition',1)->count();
            $device_types[] = $_temp;
        }

        return view('dashboard',compact('device','device_types'));
    }
}
