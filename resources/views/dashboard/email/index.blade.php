@extends ('layouts.app')
@section('title','Email List')
@section('content')

    <div class="container-fluid dashboard-default-sec">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h5 style="display: inline-block;">
                            <i class="fa fa-users"></i>
                            Email List
                        </h5>
                        <a href="{{ route('email.create') }}" class="btn btn-secondary" style="float: right">Compose</a>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-bordered display">
                                <thead class="table-primary">
                                <tr>
                                    <th>Date</th>
                                    <th>Subject</th>
                                    <th>Mailed to</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($emails as $email)
                                <tr>
                                    <td>{{ date('d-M-Y',strtotime($email->created_at)) }}</td>
                                    <td>{{ $email->subject }}</td>
                                    <td>
                                        @if(!empty($email->users))
                                            @foreach($email->users as $user)
                                                <a href="{{ route('user.show',$user->id) }}">{{ $user->location }}</a>,
                                            @endforeach
                                        @else
                                            All
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('email.show',$email->id) }}">
                                            <i class="fa fa-eye"></i> Read
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination">
                        {{ $emails->links() }}
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
@endsection

@section('required_js')
@endsection

@section('custom_js')
@endsection
