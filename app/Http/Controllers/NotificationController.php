<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(20);
        return view('dashboard.notification.index',compact('notifications'));
    }

    public function unreadNotifications()
    {
        $notifications = auth()->user()->unreadNotifications()->get();

        return response()->json($notifications);
    }


    public function show($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
        }
        if($notification->type == "App\Notifications\VersionUpdateNotification"){
            Session::flash('message', 'Contact with admin to update version information!');
            Session::flash('m-class', 'alert-info');
            return redirect()->back();
        }

        return view('dashboard.notification.show', compact('notification'));
    }
}
