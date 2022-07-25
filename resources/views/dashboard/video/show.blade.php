@extends ('layouts.app')
@section('title','Watch Video')
@section('content')

    <div class="container-fluid dashboard-default-sec">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h5>
                            <i class="fa fa-file-pdf-o"></i> Watch Video
                        </h5>
                    </div>

                    <div class="card-body">
                        <video width="100%" controls>
                            <source src="/backend/video/{{ $video->video_files }}" type="video/mp4">
                            Your browser does not support HTML video.
                        </video>
                    </div>
                    {{--<div class="card-body">--}}
                        {{--<iframe src="/backend/video/{{ $video->video_files }}" frameborder="0" style="width:100%;min-height:640px;"></iframe>--}}
                    {{--</div>--}}
                </div>
            </div>
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
