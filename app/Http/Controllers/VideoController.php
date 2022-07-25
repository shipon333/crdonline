<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::orderBy('id','desc')->get();
        return view('dashboard.video.index',compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.video.create');
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
            'video' => 'mimes:mp4|max:1024|video',

        ]);
        DB::beginTransaction();
        try {
            $video = new Video();
            $video->title = $request->title;
            if($request->file('video'))
            {
                $file = $request->file('video');
                $filename = time() . '.' . $request->file('video')->extension();
                $filePath = 'backend/video/';
                $file->move($filePath, $filename);
                $video->video_files = $filename;
            }
            if ($video->save()){
                DB::commit();
                Session::flash('message', 'Video Upload Successful!');
                Session::flash('m-class', 'alert-info');
                return redirect()->route('video.index');
            }
            else{
                DB::rollBack();
                Session::flash('message', 'Video Upload failed');
                Session::flash('m-class', 'alert-danger');
                return redirect()->route('video.create');
            }

        } catch( \Exception $e){
            DB::rollBack();
            Session::flash('message', 'Video Upload failed '. $e);
            Session::flash('m-class', 'alert-danger');
            return redirect()->route('video.create');
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
        $video = Video::find($id);
        return view('dashboard.video.show', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $video = Video::find($id);
        return view('dashboard.video.edit', compact('video'));
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

        ]);
        DB::beginTransaction();
        try {
            $video = Video::find($id);
            $video->title = $request->title;
            if($request->video != '' && $request->file('video'))
            {
                $unlinkFilePath = 'backend/video/'.$video->video_files;
                if (file_exists($unlinkFilePath) AND !empty($video->video_files)){
                    unlink($unlinkFilePath);
                }
                $file = $request->file('video');
                $filename = time() . '.' . $request->file('video')->extension();
                $filePath = 'backend/video/';
                $file->move($filePath, $filename);
                $video->video_files = $filename;
            }
            if ($video->save()){
                DB::commit();
                Session::flash('message', 'Video Upload Successful!');
                Session::flash('m-class', 'alert-info');
                return redirect()->route('video.index');
            }
            else{
                DB::rollBack();
                Session::flash('message', 'Video Upload failed');
                Session::flash('m-class', 'alert-danger');
                return redirect()->route('video.create');
            }

        } catch( \Exception $e){
            DB::rollBack();
            Session::flash('message', 'Video Upload failed '. $e);
            Session::flash('m-class', 'alert-danger');
            return redirect()->route('video.create');
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
        $video = Video::find($id);
        $unlinkFilePath = 'backend/video/'.$video->video_files;
        if (file_exists($unlinkFilePath) AND !empty($video->video_files)){
            unlink($unlinkFilePath);
        }

        if ($video->delete()){
            DB::commit();
            Session::flash('message', 'Video Delete Successful!');
            Session::flash('m-class', 'alert-info');
            return redirect()->route('video.index');
        }
        else{

            Session::flash('message', 'Video Delete failed');
            Session::flash('m-class', 'alert-danger');
            return redirect()->route('video.index');
        }

    }
}
