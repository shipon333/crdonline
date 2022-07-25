@extends ('layouts.app')
@section('title','Ticket List')
@section('content')

    <div class="container-fluid dashboard-default-sec">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h5 style="display: inline-block;">
                            <i class="fa fa-headphones"></i>
                            Ticket List
                        </h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-bordered display">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Date</th>
                                        <th>Title</th>
                                        @if(auth()->user()->user_type == 'admin')
                                        <th>User</th>
                                        @endif
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tickets as $ticket)
                                    <tr>
                                        <td>{{ date('d-M-Y',strtotime($ticket->created_at)) }}</td>
                                        <td>{{ $ticket->subject }}</td>
                                        @if(auth()->user()->user_type == 'admin')
                                        <td>{{ $ticket->user->location }}</td>
                                        @endif
                                        <td>
                                            @if($ticket->status !=1)
                                                <span class="text-danger">Not Complete</span>
                                                @else
                                                <span class="text-success">Complete</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-success" href="{{ route('ticket.show',$ticket->id) }}">
                                                <i class="fa fa-eye"></i> Read
                                            </a>
                                            @if(auth()->user()->user_type == 'admin')
                                                @if($ticket->status !=1)
                                                <a class="btn btn-sm btn-success" href="{{ route('ticket.solved',$ticket->id) }}">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                                @else
                                                    <a class="btn btn-sm btn-danger" href="{{ route('ticket.unsolved',$ticket->id) }}">
                                                        <i class="fa fa-close"></i>
                                                    </a>
                                                @endif
                                                @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination">
                        {{ $tickets->links() }}
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
