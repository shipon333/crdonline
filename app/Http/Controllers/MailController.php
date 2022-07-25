<?php

namespace App\Http\Controllers;

use App\Models\AssignDevice;
use App\Models\Email;
use App\Models\User;
use App\Notifications\SendEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emails = Email::orderBy('id','desc')->paginate(20);
        return view('dashboard.email.index',compact('emails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('user_type','user')->get();
        return view('dashboard.email.create',compact('users'));
    }

    public function store(Request $request){

//        return $request->all();
        $request->validate([
            'subject' => 'required',
            'to' => 'nullable',
            'type' => 'required',
            'message' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $mail = new Email();
            $mail->subject = $request->subject;
            $mail->body = $request->message;
            $mail->type = $request->type;
            if ($request->type == 'general') {
                $users = User::where('user_type', 'user')->get();
            } else if ($request->type == 'aanvraagstation') {
                $devices = AssignDevice::whereHas('device',function($query){
                    $query->where('device_type_id','1')->orWhere('device_type_id','2');
                })->groupBy('user_id')->pluck('user_id')->toArray();
                $users = User::whereIn('id', $devices)->get();
            }  else if ($request->type == 'pinterminal') {
                $devices = AssignDevice::whereHas('device',function($query){
                    $query->where('device_type_id','3')->orWhere('device_type_id','4');
                })->groupBy('user_id')->pluck('user_id')->toArray();
                $users = User::whereIn('id', $devices)->get();
            } else {
                $mail->user_ids = json_encode($request->to);
                $users = User::whereIn('id', $request->to)->get();
            }

            if ($mail->save()) {
                Notification::send($users, new SendEmailNotification($mail));
                DB::commit();

                Session::flash('message', 'Email Send Successfully!');
                Session::flash('m-class', 'alert-info');
                return redirect()->back();
            } else{
                Session::flash('message', 'Email Sending Failed!');
                Session::flash('m-class', 'alert-danger');
                return redirect()->back()->withInput();
            }
        } catch(\Exception $e){
            DB::rollBack();
            Session::flash('message', $e->getMessage());
            Session::flash('m-class', 'alert-danger');
            return redirect()->back()->withInput();
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
        $email = Email::findOrFail($id);
        return view('dashboard.email.show', compact('email'));
    }

    public function notifications()
    {
        $notifications = auth()->user()->unreadNotifications()->get();

        return response()->json($notifications);
    }

}
