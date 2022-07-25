@extends ('layouts.app')
@section('title','Edit Pdf')
@section('content')

    <div class="container-fluid dashboard-default-sec">
        <div class="row">
            @if(auth()->user()->user_type != 'user')
                <div class="col-lg-4">
                    <div class="card">

                        <div class="card-header bg-primary">
                            <h5>
                                <i class="fa fa-file-pdf-o"></i>
                                Upload PDF
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('pdf.update',$pdf->id) }}" method="post" class="needs-validation" enctype="multipart/form-data">
                                @csrf @method('put')
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label">Title</label>
                                        <input class="form-control" name="title" type="text" value="{{ $pdf->title }}" autocomplete="off">
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Pdf File</label>
                                        <input name="pdf" class="form-control" type="file">
                                        <span class="text-danger">{{ $errors->first('pdf') }}</span>
                                    </div>

                                    <button class="btn btn-success" type="submit">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

@endsection

@section('required_css')
@endsection

@section('custom_css')
@endsection

@section('required_js')
@endsection

@section('custom_js')
@endsection
