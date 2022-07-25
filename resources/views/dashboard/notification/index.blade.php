@extends ('layouts.app')
@section('title','Notification List')
@section('content')

    <div class="container-fluid dashboard-default-sec">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h5 style="display: inline-block;">
                            <i class="fa fa-users"></i>
                            Notification List
                        </h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-bordered display">
                                <thead class="table-primary">
                                <tr>
                                    <th>Time</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($notifications as $notification)
                                <tr>
                                    <td>{{ $notification->created_at->diffForHumans() }}</td>
                                    <td>{{ $notification->data['title'] }}</td>
                                    <td>
                                        <a href="{{ route('notification.show',$notification->id) }}">
                                            <i class="fa fa-eye"></i> Read
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination">
                        {{ $notifications->links() }}
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
