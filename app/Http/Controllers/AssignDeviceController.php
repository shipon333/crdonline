<?php

namespace App\Http\Controllers;

use App\Models\AssignDevice;
use App\Models\Device;
use App\Models\DeviceType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AssignDeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('dashboard.device.index');
    }

    public function deviceList(Request $request)
    {
        $devices = AssignDevice::with(['device.device_type','user']);

        if($request->type != ''){
            $devices = $devices->whereHas('device',function($query) use($request){
                $query->where('device_type_id',$request->type);
            });
        }

        if($request->search_text != ''){
            $devices = $devices->whereHas('device',function($query) use($request){
                $query->where('name','like','%'.$request->search_text.'%');
            })->orWhereHas('user',function($query) use($request){
                $query->where('location','like','%'.$request->search_text.'%');
            });
        }

        if(auth()->user()->user_type != 'admin'){
            $devices = $devices->where('user_id',auth()->user()->id);
        }

        $devices = $devices->get();
        return response()->json($devices);
    }

    public function deviceListByType(Request $request,$id)
    {
        $devices = AssignDevice::with(['device.device_type','user'])
            ->whereHas('device',function($query) use($id){
                $query->where('device_type_id',$id);
            });

        if($request->search_text != ''){
            $devices = $devices->whereHas('device',function($query) use($request){
                $query->where('name','like','%'.$request->search_text.'%');
            })->orWhereHas('user',function($query) use($request){
                $query->where('location','like','%'.$request->search_text.'%');
            });
        }

        if(auth()->user()->user_type != 'admin'){
            $devices = $devices->where('user_id',auth()->user()->id);
        }

        $devices = $devices->get();
        return response()->json($devices);
    }


    public function notUpdatedDeviceList(Request $request)
    {
        $devices = AssignDevice::with(['device.device_type','user'])->where('condition',0);

        if($request->location != ''){
            $devices = $devices->where('user_id',$request->location);
        }

        if($request->search_text != ''){
            $devices = $devices->whereHas('device',function($query) use($request){
                $query->where('name','like','%'.$request->search_text.'%');
            })->orWhereHas('user',function($query) use($request){
                $query->where('location','like','%'.$request->search_text.'%');
            });
        }

        $devices = $devices->get();
        return response()->json($devices);
    }

    public function notUpdatedDeviceView(Request $request)
    {
        return view('dashboard.device.not-updated');
    }

    public function getDeviceByCategory(Request $request,$id)
    {
        $type = DeviceType::find($id);
        return view('dashboard.device.category',compact('type'));
    }

    public function deviceTypes(Request $request)
    {
        $types = DeviceType::all();
        return response()->json($types);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $devices = Device::all();
        $users = User::where('user_type','user')->get();
        return view('dashboard.device.create',compact('devices','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());

        $request->validate([
            'device_id' => 'required',
            'user_id' => 'required',
            'ip_address' => 'nullable|ip',
            'subnet_mask' => 'nullable',
            'gateway' => 'nullable',
            'dns_achtervoegesl' => 'nullable',
            'dns1' => 'nullable',
            'dns2' => 'nullable'
        ]);


        DB::beginTransaction();

        try{
            $device = Device::find($request->device_id);
            $exist = AssignDevice::where('device_id',$request->device_id)->where('user_id',$request->user_id)->first();
//            print_r($exist);die;
            if(!empty($exist)){
                throw new \Exception('This device already assigned to this location');
            }
            if($device->device_type_id == '1' || $device->device_type_id == '2'){
                $device_count = AssignDevice::whereHas('device',function($query){
                    $query->where('device_type_id','1')->orWhere('device_type_id','2');
                })->count();
                if($device_count >= 7) throw new \Exception('Maximum Limit 7 for aanvraagstation');
            } else{
                $device_count = AssignDevice::whereHas('device',function($query){
                    $query->where('device_type_id','3')->orWhere('device_type_id','4');
                })->count();
                if($device_count >= 10) throw new \Exception('Maximum Limit 10 for pinterminal');
            }


            $device = new AssignDevice();
            $device->device_id = $request->device_id;
            $device->user_id = $request->user_id;
            $device->terminal_model = $request->terminal_model;
            $device->serial_number = $request->serial_number;
            $device->sim_card = $request->sim_card;
            $device->sim_serial_number = $request->sim_serial_number;
            $device->ip_address = $request->ip_address;
            $device->subnet_mask = $request->subnet_mask;
            $device->gateway = $request->gateway;
            $device->dns_1 = $request->dns_1;
            $device->dns_2 = $request->dns_2;
            $device->dns_achtervoegesl = $request->dns_achtervoegesl;
            if ($request->check_cable){
                $device->cable_mobile = 1;
            }
            else{
                $device->cable_mobile = 0;
            }

            if($device->save()){
                DB::commit();
                Session::flash('message', 'Data Saved Successfully!');
                Session::flash('m-class', 'alert-success');
                return redirect()->route('assignDevice.index');
            } else{
                DB::rollBack();
                Session::flash('message', 'Data Saving Failed!');
                Session::flash('m-class', 'alert-danger');
                return redirect()->back();
            }
        } catch(\Exception $e){
            DB::rollBack();
            Session::flash('message', $e->getMessage());
            Session::flash('m-class', 'alert-danger');
            return redirect()->back();
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $device = Device::find($id);
        return response()->json($device);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $devices = Device::all();
        $users = User::where('user_type','user')->get();
        $assignes = AssignDevice::findOrFail($id);
        return view('dashboard.device.edit', compact('assignes','devices','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'device_id' => 'required',
            'user_id' => 'required',
            'ip_address' => 'nullable|ip',
            'subnet_mask' => 'nullable',
            'gateway' => 'nullable',
            'dns_achtervoegesl' => 'nullable',
            'dns1' => 'nullable',
            'dns2' => 'nullable'
        ]);
        DB::beginTransaction();
        try{
            $device = Device::findOrFail($id);
            if ($device->id != $request->device_id){
                $exist = Device::where('name',$request->name)->where('user_id',$request->user_id)->first();
//            print_r($exist);die;
                if(!empty($exist)){
                    throw new \Exception('This device already assigned to this location');
                }
            }
            $device->device_id = $request->device_id;
            $device->user_id = $request->user_id;
            $device->terminal_model = $request->terminal_model;
            $device->serial_number = $request->serial_number;
            $device->sim_card = $request->sim_card;
            $device->sim_serial_number = $request->sim_serial_number;
            $device->ip_address = $request->ip_address;
            $device->subnet_mask = $request->subnet_mask;
            $device->gateway = $request->gateway;
            $device->dns_1 = $request->dns_1;
            $device->dns_2 = $request->dns_2;
            $device->dns_achtervoegesl = $request->dns_achtervoegesl;
            if ($request->check_cable){
                $device->cable_mobile = 1;
            }
            else{
                $device->cable_mobile = 0;
            }

            if($device->save()){
                DB::commit();
                Session::flash('message', 'Data Saved Successfully!');
                Session::flash('m-class', 'alert-info');
                return redirect()->route('assignDevice.index');
            } else{
                DB::rollBack();
                Session::flash('message', 'Data Saving Failed!');
                Session::flash('m-class', 'alert-danger');
                return redirect()->back();
            }
        } catch(\Exception $e){
            DB::rollBack();
            Session::flash('message', $e->getMessage());
            Session::flash('m-class', 'alert-danger');
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deviceUpdate(Request $request){
//        dd($request->select);
        $status = Device::whereIn('id',$request->select)->update(['condition'=>$request->status]);

        if($status){
            Session::flash('message', 'Data Saved Successfully!');
            Session::flash('m-class', 'alert-info');
            return redirect()->back();
        }
    }
}
