<?php

namespace App\Http\Controllers;

use App\Models\AssignDevice;
use App\Models\User;
use App\Models\Version;
use App\Models\VersionInstall;
use App\Notifications\VersionUpdateNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;

class VersionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $version = Version::with('device')->where('device_id',$request->device_id)->orderBy('id','desc')->get();
        return response()->json($version);
    }
    public function allVersion(Request $request,$id){
        $installed_versions = VersionInstall::where('user_id',$request->user_id)
            ->where('device_id',$id)
            ->pluck('version_id')->toArray();
        $all_version = Version::where('device_id',$id)->whereNotIn('id',$installed_versions)->get();
        return response()->json($all_version);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'device_id' => 'required',
        ]);

        $version = new Version();
        $version->name = $request->name;
        $version->device_id = $request->device_id;

        if($version->save()){
            AssignDevice::where('device_id',$request->device_id)->update(['condition'=>0]);

            $assignd_device_users = AssignDevice::where('device_id',$request->device_id)->pluck('user_id')->toArray();
            $users = User::whereIn('id',$assignd_device_users)->get();
            Notification::send($users, new VersionUpdateNotification($version));

            return response()->json(['status'=>'success','message'=>'Version added successfully!'],200);
        } else{
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
        //
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
            'device_id' => 'required',
        ]);

        $version = Version::find($id);
        $version->name = $request->name;
        $version->device_id = $request->device_id;
        if($version->save()){
            return response()->json(['status'=>'success','message'=>'Version update successfully!'],200);
        } else{
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
        $version = VersionInstall::orderBy('id','desc')->where('device_id',$id)->first();
        $count = $version->count();
        if ($count > 0){
            $version->delete();
            $assignDevice = AssignDevice::where('device_id',$id)->first();
            $assignDevice->condition = 0;
            $assignDevice->save();
        }


    }

    public function updateVersion(Request $request){
        $request->validate([
            'user_id' => 'required',
            'device_id' => 'required',
            'version_id' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $have_version = VersionInstall::where('device_id',$request->device_id)->where('user_id',$request->user_id)->where('version_id',$request->version_id)->first();

            if(!empty($have_version)){
                throw new \Exception('This device already Update');
            }
            $verInstall = new VersionInstall();
            $verInstall->user_id = $request->user_id;
            $verInstall->device_id = $request->device_id;
            $verInstall->version_id = $request->version_id;
            if ($verInstall->save()) {
                AssignDevice::where('user_id',$request->user_id)
                    ->where('device_id',$request->device_id)
                    ->update(['condition'=>1,'last_updated'=>date('Y-m-d')]);
                DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Version Update successfully!'], 200);
            } else {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Data Saving failed!'], 200);
            }
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 200);
        }

    }
}
