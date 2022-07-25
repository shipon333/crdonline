@extends ('layouts.app')
@section('title','Video Upload')
@section('content')

    <div class="container-fluid dashboard-default-sec">
        <div class="row">
            @if(auth()->user()->user_type != 'user')
                <div class="col-lg-4">
                    <div class="card">

                        <div class="card-header bg-primary">
                            <h5>
                                <i class="fa fa-video-camera"></i>
                                Upload Video
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('video.store') }}" method="post" class="needs-validation" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label">Title</label>
                                        <input class="form-control" name="title" type="text" autocomplete="off">
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Video File</label>
                                        <input name="video" class="form-control" type="file">
                                        <span class="text-danger">{{ $errors->first('video') }}</span>
                                    </div>

                                    <button class="btn btn-success" type="submit">Upload</button>
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
