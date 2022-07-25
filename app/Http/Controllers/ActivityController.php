<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Device;
use App\Models\DeviceType;
use App\Models\User;
use App\Notifications\ActivityNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.activity.index');
    }

    public function activityList()
    {

        if (auth()->user()->user_type == 'admin'){
            $activities = Activity::with('user','device_type')->orderBy('status')->get();
        }
        else{
            $activities = Activity::with('device_type')->orderBy('status')->where('user_id',auth()->user()->id)->get();
        }
        return response()->json($activities);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = User::where('user_type','user')->get();
        $devices = DeviceType::all();
        return view('dashboard.activity.create',compact('locations','devices'));
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
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'device_type_id' => 'required',
        ]);


        DB::beginTransaction();
        try {
            $activity = new Activity();
            $activity->title = $request->title;
            $activity->user_id = $request->user_id;
            $activity->device_type_id = $request->device_type_id;
            $activity->description = $request->description;
            $activity->start_date = $request->start_date;
            $activity->end_date = $request->end_date;
            $activity->status = $request->status;
            if ($activity->save()) {
                DB::commit();
                if($request->user_id == ''){
                    $users = User::where('user_type', 'user')->get();
                } else {
                    $users = User::where('id', $request->user_id)->get();
                }

                Notification::send($users, new ActivityNotification($activity));
                Session::flash('message', 'Activity Add Successfully!');
                Session::flash('m-class', 'alert-info');
                return redirect()->route('activity.index');
            } else {
                DB::rollBack();
                Session::flash('message', 'Data Saving Failed!');
                Session::flash('m-class', 'alert-danger');
                return redirect()->back();
            }
        } catch (\Exception $e){
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
        $locations = User::where('user_type','user')->get();
        $activity = Activity::find($id);
        $devices = DeviceType::all();
        return view('dashboard.activity.edit',compact('locations','activity','devices'));
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
            'title' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'device_type_id' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $activity = Activity::find($id);
            $activity->title = $request->title;
            $activity->user_id = $request->user_id;
            $activity->device_type_id = $request->device_type_id;
            $activity->description = $request->description;
            $activity->start_date = $request->start_date;
            $activity->end_date = $request->end_date;
            $activity->status = $request->status;
            if ($activity->save()) {
                DB::commit();
                Session::flash('message', 'Activity Update Successfully!');
                Session::flash('m-class', 'alert-info');
                return redirect()->route('activity.index');
            } else {
                DB::rollBack();
                Session::flash('message', 'Data Saving Failed!');
                Session::flash('m-class', 'alert-danger');
                return redirect()->back();
            }
        } catch (\Exception $e){
            DB::rollBack();
            Session::flash('message', $e->getMessage());
            Session::flash('m-class', 'alert-danger');
            return redirect()->back();
        }
    }

    public function activityStatus(Request $request, $id){
        $activity = Activity::find($id);
        if ($request->status == 'planned'){
            $activity->status = 'in_progress';
        }
        if ($request->status == 'in_progress'){
            $activity->status = 'completed';
        }

        if($activity->save()){
            return response()->json(['status'=>'success','message'=>'Activity updated successfully!'],200);
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
        $delete = Activity::find($id);
        if($delete->delete()){
            return response()->json(['status'=>'success','message'=>'Activity delete successfully!'],200);
        } else{
            return response()->json(['status'=>'error','message'=>'Data delete failed!'],200);
        }
    }
}
