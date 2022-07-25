<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketNotification;
use App\Notifications\TicketSolvedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->user_type == 'admin'){
            $tickets = Ticket::orderBy('id','desc')->paginate(20);
        } else {
            $tickets = Ticket::where('user_id',auth()->user()->id)->orderBy('id','desc')->paginate(20);
        }
        return view('dashboard.ticket.index',compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.ticket.create');
    }
    public function store(Request $request){

        $request->validate([
            'subject' => 'required',
            'description' => 'required',
            'file' => 'mimes:jpeg,jpg,png,pdf,csv,xlsx|max:1024|file',
        ]);



        DB::beginTransaction();
        try {
            $ticket = new Ticket();
            $ticket->subject = $request->subject;
            $ticket->description = $request->description;

            if (request()->hasFile('file')) {
                $file = request()->file('file');
                $fileName = auth()->user()->name."_".$file->getClientOriginalName() . time() . "." . $file->getClientOriginalExtension();
                $path = ('backend/images/support/');
                $file->move($path, $fileName);
                $ticket->file = $fileName;
            }

            $ticket->user_id = auth()->user()->id;

            if ($ticket->save()) {
                $admin = User::where('user_type', 'admin')->get();
                Notification::send($admin, new TicketNotification($ticket));
                DB::commit();

                Session::flash('message', 'Ticket Submitted Successfully!');
                Session::flash('m-class', 'alert-info');
                return redirect()->back();
            } else {
                DB::rollBack();
                Session::flash('message', 'Ticket Submission Failed!');
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

    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('dashboard.ticket.show', compact('ticket'));
    }

    public function solveTicket($id){
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 1;

        if($ticket->save()){

            $user = User::where('id', $ticket->user_id)->get();
            Notification::send($user, new TicketSolvedNotification($ticket));

        }

        return redirect()->back();
    }
    public function unsolveTicket($id){
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 0;
        $ticket->save();
        return redirect()->back();
    }
}
