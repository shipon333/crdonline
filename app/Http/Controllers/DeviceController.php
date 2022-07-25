<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\DeviceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $device_types = DeviceType::all();
        return view('dashboard.device.index',compact('device_types'));
    }
    public function deviceTypes()
    {
        $types = DeviceType::all();
        return response()->json($types);
    }
    public function allDeviceList(Request $request){
        $devices = Device::with('device_type','user')->orderBy('id','desc');
        if($request->type != ''){
            $devices = $devices->where('device_type_id',$request->type);
        }
        if($request->search_text != ''){
            $device = $devices->where('name','like','%'.$request->search_text.'%')
                ->orWhereHas('user',function($query) use($request){
                    $query->where('location','like','%'.$request->search_text.'%');
                });
        }

        if(auth()->user()->user_type != 'admin'){
            $devices = $devices->where('user_id',auth()->user()->id);
        }
        $devices = $devices->get();
        return response()->json($devices);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $device_types = DeviceType::all();
        return view('dashboard.device.addDevice',compact('device_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'device_type_id' => 'required',
            'user_id' => 'required',
            'ip_address' => 'nullable|ip',
            'subnet_mask' => 'nullable',
            'gateway' => 'nullable',
            'dns_achtervoegesl' => 'nullable',
            'dns1' => 'nullable',
            'dns2' => 'nullable',
            'desk' => 'nullable',
            'terminal_model' => 'nullable',
            'serial_number' => 'nullable',
            'software_version' => 'nullable',
            'sim_card' => 'nullable',
            'sim_serial_number' => 'nullable',
        ]);




        DB::beginTransaction();

        try{

            $exist = Device::where('name',$request->name)->where('user_id',$request->user_id)->first();
//            print_r($exist);die;
            if(!empty($exist)){

                throw new \Exception('This device already assigned to this location');
            }
            if($request->device_type_id == '1' || $request->device_type_id == '2'){

                $device_count = Device::where('device_type_id','1')->orWhere('device_type_id','2')->count();
                if($device_count >= 7) throw new \Exception('Maximum Limit 7 for aanvraagstation');

            } else{

                $device_count = Device::where('device_type_id','3')->orWhere('device_type_id','4')->count();
                if($device_count >= 10) throw new \Exception('Maximum Limit 10 for pinterminal');
            }


            $device = new Device();
            $device->name = $request->name;
            $device->device_type_id = $request->device_type_id;
            $device->user_id = $request->user_id;
            $device->desk = $request->desk;
            $device->terminal_model = $request->terminal_model;
            $device->software_version = $request->software_version;
            $device->serial_number = $request->serial_number;
            $device->sim_card = $request->sim_card;
            $device->sim_serial_number = $request->sim_serial_number;
            $device->ip_address = $request->ip_address;
            $device->subnet_mask = $request->subnet_mask;
            $device->gateway = $request->gateway;
            $device->dns_1 = $request->dns_1;
            $device->dns_2 = $request->dns_2;
            $device->dns_achtervoegesl = $request->dns_achtervoegesl;

            if($device->save()){
                DB::commit();
                return response()->json(['status'=>'success','message'=>'Device added successfully!'],200);
            } else{
                DB::rollBack();
                return response()->json(['status'=>'error','message'=>'Data Saving failed!'],200);
            }
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status'=>'error','message'=>'Data Saving failed!'],200);
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
        return view('dashboard.device.device-view',compact('device'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            'name' => 'required',
            'device_type_id' => 'required',
            'user_id' => 'required',
            'ip_address' => 'nullable|ip',
            'subnet_mask' => 'nullable',
            'gateway' => 'nullable',
            'dns_achtervoegesl' => 'nullable',
            'dns1' => 'nullable',
            'dns2' => 'nullable',
            'desk' => 'nullable',
            'terminal_model' => 'nullable',
            'serial_number' => 'nullable',
            'software_version' => 'nullable',
            'sim_card' => 'nullable',
            'sim_serial_number' => 'nullable',
        ]);

        DB::beginTransaction();
        try{

            $device = Device::findOrFail($id);
            if ($device->id != $request->id){
                $exist = Device::where('name',$request->name)->where('user_id',$request->user_id)->first();
//            print_r($exist);die;
                if(!empty($exist)){
                    throw new \Exception('This device already assigned to this location');
                }
            }

            $device->name = $request->name;
            $device->device_type_id = $request->device_type_id;
            $device->user_id = $request->user_id;
            $device->desk = $request->desk;
            $device->terminal_model = $request->terminal_model;
            $device->software_version = $request->software_version;
            $device->serial_number = $request->serial_number;
            $device->sim_card = $request->sim_card;
            $device->sim_serial_number = $request->sim_serial_number;
            $device->ip_address = $request->ip_address;
            $device->subnet_mask = $request->subnet_mask;
            $device->gateway = $request->gateway;
            $device->dns_1 = $request->dns_1;
            $device->dns_2 = $request->dns_2;
            $device->dns_achtervoegesl = $request->dns_achtervoegesl;
            if($device->save()){
                DB::commit();
                return response()->json(['status'=>'success','message'=>'Device Update successfully!'],200);
            } else{
                DB::rollBack();
                return response()->json(['status'=>'error','message'=>'Data Saving failed!'],200);
            }
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status'=>'error','message'=>'Data Saving failed!'],200);
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
        $device = Device::find($id);
        $device->delete();
    }

    public function deviceUpdate(Request $request){
        $sl = 0;
        foreach ($request->data as $id){
            $update =  Device::find($id);
            $update->condition = 1;
            $update->last_updated = date('Y-m-d');
            $update->save();
            $sl++;
        }
        return response()->json(['status'=>'success','message'=>'Device Update successfully!'],200);
    }
    public function deviceNotUpdate(Request $request){
        $sl = 0;
        foreach ($request->data as $id){
            $update =  Device::find($id);
            $update->condition = 0;
            $update->save();
            $sl++;
        }
        return response()->json(['status'=>'success','message'=>'Device Not Update successfully!'],200);
    }

    public function getDeviceByCategory(Request $request,$id)
    {
        $type = DeviceType::find($id);
        return view('dashboard.device.category',compact('type'));
    }



    public function deviceListByType(Request $request,$id)
    {
        $devices = Device::with(['device_type','user'])->where('device_type_id',$id);

        if($request->search_text != ''){
            $devices = $devices->where('name','like','%'.$request->search_text.'%')
                ->orWhereHas('user',function($query) use($request){
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
        $devices = Device::with(['device_type','user'])->where('condition',0);

        if($request->location != ''){
            $devices = $devices->where('user_id',$request->location);
        }

        if($request->search_text != ''){
            $devices = $devices->where('name','like','%'.$request->search_text.'%')
                ->orWhereHas('user',function($query) use($request){
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
}
