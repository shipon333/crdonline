@extends ('layouts.app')
@section('title','User List')
@section('content')

    <div class="container-fluid dashboard-default-sec">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header bg-primary">

                        <div class="row">
                            <div class="col-sm-3 col-md-3">
                                <div class="device-title">
                                    <h5>
                                        <i class="fa fa-users"></i>
                                        User List</h5>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-8">
                                <form action="">
                                    <div class="input-group">
                                        <input type="text" name="search_text" class="form-control" placeholder="Search with location, person, phone" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-secondary input-group-text" id="basic-addon2">Search</button>
                                        </div>
                                    </div>
                                </form>
                                {{--<input type="text" name="search_text" placeholder="search" class="form-control">--}}
                            </div>
                            <div class="col-sm-3 col-md-3 col-4">
                                <a href="{{ route('user.create') }}" class="btn btn-secondary add-user-button" style="float: right">Add User</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-bordered display">
                                <thead class="table-primary">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->location }}</td>
                                    <td>
                                        <a href="{{ route('user.edit',$user->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <!--<span class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></span>-->
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination">
                            {{ $users->links() }}
                        </div>
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
@endsection
