@extends ('layouts.app')
@section('title','Video List')
@section('content')

    <div class="container-fluid dashboard-default-sec">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header bg-primary">

                        <div class="row">
                            <div class="col-sm-9 col-md-9">
                                <div class="device-title">
                                    <h5>
                                        <i class="fa fa-users"></i>
                                        Video List</h5>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3 col-4">
                                <a href="{{ route('video.create') }}" class="btn btn-secondary add-user-button" style="float: right">Add Video</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-bordered display">
                                <thead class="table-primary">
                                <tr>
                                    <th>Title</th>
                                    <th>File</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($videos as $key =>$video)
                                    <tr class="{{$video->id}}">
                                        <td>{{ $video->title }}</td>
                                        <td>{{ $video->video_files }}</td>
                                        <td>
                                            <a href="{{route('video.edit',$video->id)}}" class="btn btn-sm btn-primary" title="Video Edit"><i class="fa fa-edit"></i></a>
                                            <a href="{{route('video.show',$video->id)}}" class="btn btn-sm btn-success" title="Watch Video"><i class="fa fa-eye"></i></a>
                                            <a href="{{route('video.delete',$video->id)}}" class="btn btn-sm btn-danger" title="Video Delete" ><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{--<div class="pagination">--}}
                        {{--{{ $users->links() }}--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('required_css')
@endsection

@section('custom_css')
    <style>
        .flex.justify-between.flex-1.sm\:hidden {display: none;}

        p.text-sm.text-gray-700.leading-5 {display: none;}

        .pagination {margin: 28px auto 26px 34px;}
        span[aria-current='page'] > span {background: #24695C!important;color: #fff;}

        @media only screen and (min-width: 1200px){

        }

        @media (min-width: 992px) and (max-width: 1199.98px){

        }
        @media (min-width: 768px) and (max-width: 991.98px){

        }

        @media (min-width: 576px) and (max-width: 767.98px) {
            .add-user-button {padding: 6px 14px;}
        }
        @media (min-width: 480px) and (max-width: 575.98px){
            .add-user-button {padding: 6px 14px;}
            .device-title {margin-bottom: 18px;}
            .input-group-append button {padding: 6px 7px;}
        }
        @media (min-width: 420px) and (max-width: 479px){
            .add-user-button {padding: 6px 14px;}
            .device-title {margin-bottom: 18px;}
            .input-group-append button {padding: 6px 7px;}

        }
        @media (min-width: 320px) and (max-width: 419px){
            .add-user-button {padding: 6px 10px;}
            .device-title {margin-bottom: 18px;}
            .input-group-append button {padding: 6px 7px;}
        }

    </style>
@endsection

@section('required_js')
@endsection

@section('custom_js')
    <script>
        $(document).ready(function () {
            $(document).on('click', '#delete', function () {
                var actionTo = $(this).attr('href');
                var token = $(this).attr('data-token');
                var id = $(this).attr('data-id');
                swal({
                        title: "Are you sure?",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonClass: 'btn-danger',
                        confirmButtonText: 'Yes',
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url:actionTo,
                                type: 'post',
                                data: {id:id, _token:token},
                                success: function (data) {
                                    swal({
                                            title: "Deleted!",
                                            type: "success"
                                        },
                                        function (isConfirm) {
                                            if (isConfirm) {
                                                $('.' + id).fadeOut();
                                            }
                                        });
                                }
                            });
                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });
                return false;
            });
        });
    </script>
@endsection
