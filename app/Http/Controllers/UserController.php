<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::where('user_type','user');
        if($request->search_text != ''){
            $users = $users->where('name','like','%'.$request->search_text.'%')
                ->orWhere('location','like','%'.$request->search_text.'%')
                ->orWhere('phone_one','like','%'.$request->search_text.'%')
                ->orWhere('person_two','like','%'.$request->search_text.'%')
                ->orWhere('phone_two','like','%'.$request->search_text.'%');
        }
        $users = $users->paginate(20);
        return view('dashboard.user.index',compact('users'));
    }

    public function userList()
    {
        $users = User::where('user_type','user')->get();
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.user.create');
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
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
            'name' => 'required',
            'location' => 'required',
            'phone_one' => 'nullable|numeric',
            'phone_two' => 'nullable|numeric',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = 'user';
        $user->password = bcrypt($request->password);
        $user->location = $request->location;
        $user->phone_one = $request->phone_one;
        $user->person_two = $request->person_two;
        $user->phone_two = $request->phone_two;
        if($request->profile != ''){
            $imageName = time().'.'.$request->profile->extension();
            $user->profile = $imageName;
        }

        if($user->save()){
            if($request->profile != '') {
                $request->profile->move('backend/profile/', $imageName);
            }
            Session::flash('message', 'Data Saved Successfully!');
            Session::flash('m-class', 'alert-info');
            return redirect()->route('user.index');
        } else{
            Session::flash('message', 'Data Saving Failed!');
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
        $user = User::find($id);
        return view('dashboard.user.profile', compact('user'));
    }

    public function profileChange($id){
        $user = User::find($id);
        return view('dashboard.user.profile-edit', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.user.edit', compact('user'));
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
        $user = User::findOrFail($id);
        $request->validate([
            'email' => 'required|unique:users,email,'.$user->id,
            'password' => 'nullable|min:6',
            'name' => 'required',
            'location' => 'required',
            'phone_one' => 'nullable|numeric',
            'phone_two' => 'nullable|numeric',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != ''){
            $user->password = bcrypt($request->password);
        }
        if ($request->profile){
            $old = $user->profile;
            $path = 'backend/profile/'.$old;
            if (file_exists($path) AND !empty($path)){
                unlink($path);
            }
            $imageName = time().'.'.$request->profile->extension();
            $user->profile = $imageName;
        }
        $user->location = $request->location;
        $user->phone_one = $request->phone_one;
        $user->person_two = $request->person_two;
        $user->phone_two = $request->phone_two;

        if($user->save()){
            if ($request->profile){
                $request->profile->move('backend/profile/', $imageName);
            }
            Session::flash('message', 'Data updated Successfully!');
            Session::flash('m-class', 'alert-info');
            return redirect()->route('user.index');
        } else{
            Session::flash('message', 'Data Saving Failed!');
            Session::flash('m-class', 'alert-danger');
            return redirect()->back();
        }
    }
    public function profileImage(Request $request, $id){
        $user = User::findOrFail($id);
        $request->validate([
            'email' => 'required|unique:users,email,'.$user->id,
            'password' => 'nullable|min:6',
            'name' => 'required',
            'location' => 'required',
            'person_two' => 'nullable',
            'phone_one' => 'nullable|numeric',
            'phone_two' => 'nullable|numeric',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->location = $request->location;
        $user->phone_one = $request->phone_one;
        $user->person_two = $request->person_two;
        $user->phone_two = $request->phone_two;
        if ($request->profile){
            $old = $user->profile;
            $path = 'backend/profile/'.$old;
            if (file_exists($path) AND !empty($old)){
                unlink($path);
            }
            $imageName = time().'.'.$request->profile->extension();
            $user->profile = $imageName;
        }
        if($user->save()){
            if ($request->profile){
                $request->profile->move('backend/profile/', $imageName);
            }
            Session::flash('message', 'Data updated Successfully!');
            Session::flash('m-class', 'alert-info');
            return redirect()->route('user.show',$user->id);
        } else{
            Session::flash('message', 'Data Saving Failed!');
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

    public function profileUpdate(Request $request,$id){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,
            'password' => 'nullable|min:6',
            'location' => 'required',
        ]);
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != ''){
            $user->password = bcrypt($request->password);
        }
        $user->location = $request->location;
        $user->save();
    }

}
