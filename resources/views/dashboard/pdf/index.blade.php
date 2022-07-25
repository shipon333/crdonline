@extends ('layouts.app')
@section('title','Pdf List')
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
                                        Pdf List</h5>
                                </div>
                            </div>
                            {{--<div class="col-sm-6 col-md-6 col-8">--}}
                                {{--<form action="">--}}
                                    {{--<div class="input-group">--}}
                                        {{--<input type="text" name="search_text" class="form-control" placeholder="Search with location, person, phone" aria-label="Recipient's username" aria-describedby="basic-addon2">--}}
                                        {{--<div class="input-group-append">--}}
                                            {{--<button type="submit" class="btn btn-secondary input-group-text" id="basic-addon2">Search</button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</form>--}}
                            {{--</div>--}}
                            <div class="col-sm-3 col-md-3 col-4">
                                <a href="{{ route('pdf.create') }}" class="btn btn-secondary add-user-button" style="float: right">Add Pdf</a>
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
                                @foreach($pdfs as $key =>$pdf)
                                    <tr class="{{$pdf->id}}">
                                        <td>{{ $pdf->title }}</td>
                                        <td>{{ $pdf->pdf_files }}</td>
                                        <td>
                                            <a href="{{route('pdf.edit',$pdf->id)}}" class="btn btn-sm btn-primary" title="Pdf Edit"><i class="fa fa-edit"></i></a>
                                            <a href="{{route('pdf.show',$pdf->id)}}" class="btn btn-sm btn-success" title="Pdf View"><i class="fa fa-eye"></i></a>
                                            <a href="{{route('pdf.delete',$pdf->id)}}" class="btn btn-sm btn-danger" title="Video Delete" ><i class="fa fa-trash"></i></a>
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
                Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url:actionTo,
                                type: 'post',
                                data: {id:id, _token:token},
                                success: function (data) {
                                    Swal.fire({
                                            title: "Deleted!",
                                            type: "success"
                                        },
                                        function (isConfirm) {
                                            if (isConfirm) {
                                                $('.' + id).fadeOut();
                                            }
                                        });
                                    Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )
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
