@extends ('layouts.app')
@section('title','Ticket Details')
@section('content')

    <div class="container-fluid dashboard-default-sec">
        <div class="email-wrap">
            <div class="row">
                <div class="email-right-aside">
                    <div class="card email-body">
                        <div class="email-profile">
                            <div class="email-right-aside">
                                <div class="email-body">
                                    <div class="email-content">
                                        <div class="email-top">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="media">
                                                        <i class="fa fa-envelope fa-2x"></i>
                                                        <div class="media-body" style="margin-left: 10px;">
                                                            <h6 class="d-block">Ticket Title: {{ $ticket->subject }}</h6>
                                                            <p>User: {{ $ticket->user->location }}</p>
                                                            <p>Email: {{ $ticket->user->email }}</p>
                                                            <p>Date: {{ date('d-M-Y',strtotime($ticket->created_at)) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="email-wrapper">
                                            {!! $ticket->description !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
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
