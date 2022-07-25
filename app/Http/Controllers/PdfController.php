<?php

namespace App\Http\Controllers;

use App\Models\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class PdfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pdfs = Pdf::orderBy('id','desc')->get();
        return view('dashboard.pdf.index',compact('pdfs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.pdf.create');
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
            'file' => 'mimes:pdf|max:1024|file',
        ]);
        DB::beginTransaction();
        try {
            $pdf = new Pdf();
            $pdf->title = $request->title;
            if($request->file('pdf'))
            {
                $file = $request->file('pdf');
                $filename = time() . '.' . $request->file('pdf')->extension();
                $filePath = 'backend/pdf/';
                $file->move($filePath, $filename);
                $pdf->pdf_files = $filename;
            }
            if ($pdf->save()){
                DB::commit();
                Session::flash('message', 'Pdf Upload Successful!');
                Session::flash('m-class', 'alert-info');
                return redirect()->route('pdf.index');
            }
            else{
                DB::rollBack();
                Session::flash('message', 'Pdf Upload failed');
                Session::flash('m-class', 'alert-danger');
                return redirect()->route('pdf.create');
            }

        } catch( \Exception $e){
            DB::rollBack();
            Session::flash('message', 'Pdf Upload failed '. $e);
            Session::flash('m-class', 'alert-danger');
            return redirect()->route('pdf.create');
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
        $pdf = Pdf::find($id);
        return view('dashboard.pdf.show', compact('pdf'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pdf = Pdf::findOrFail($id);
        return view('dashboard.pdf.edit', compact('pdf'));
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
            'file' => 'mimes:pdf|max:1024|file',
        ]);
        DB::beginTransaction();
        try {
            $pdf = Pdf::find($id);
            $pdf->title = $request->title;
            if($request->pdf !='' && $request->file('pdf'))
            {
                $unlinkFilePath = 'backend/pdf/'.$pdf->pdf_files;
                if (file_exists($unlinkFilePath) AND !empty($pdf->pdf_files)){
                    unlink($unlinkFilePath);
                }
                $filePath = 'backend/pdf/';
                $file = $request->file('pdf');
                $filename = time() . '.' . $request->file('pdf')->extension();

                $file->move($filePath, $filename);
                $pdf->pdf_files = $filename;
            }
            if ($pdf->save()){
                DB::commit();
                Session::flash('message', 'Pdf Update Successful!');
                Session::flash('m-class', 'alert-info');
                return redirect()->route('pdf.index');
            }
            else{
                DB::rollBack();
                Session::flash('message', 'Pdf Update failed');
                Session::flash('m-class', 'alert-danger');
                return redirect()->route('pdf.create');
            }

        } catch( \Exception $e){
            DB::rollBack();
            Session::flash('message', 'Pdf Upload failed '. $e);
            Session::flash('m-class', 'alert-danger');
            return redirect()->route('pdf.create');
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
        $pdf = Pdf::find($id);
        if ($pdf){
            $filePath = 'backend/pdf/'.$pdf->pdf_files;
            if (file_exists($filePath) AND !empty($pdf->pdf_files)){
                unlink($filePath);
            }
        }
        if ($pdf->delete()){
            DB::commit();
            Session::flash('message', 'Pdf Delete Successful!');
            Session::flash('m-class', 'alert-info');
            return redirect()->route('pdf.index');
        }
        else{
            DB::rollBack();
            Session::flash('message', 'Pdf Delete failed');
            Session::flash('m-class', 'alert-danger');
            return redirect()->route('pdf.index');
        }
    }
}
