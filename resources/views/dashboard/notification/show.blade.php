@extends ('layouts.app')
@section('title','Notification Details')
@section('content')

    @if($notification->type == 'App\Notifications\SendEmailNotification')
        <?php
            $email = \App\Models\Email::find($notification->data['email_id']);
        ?>
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
                                                                <h6 class="d-block">Subject: {{ $email->subject }}</h6>
                                                                <p>To: {{ auth()->user()->location }}</p>
                                                                <p>Date: {{ date('d-M-Y',strtotime($email->created_at)) }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="email-wrapper">
                                                {!! $email->body !!}
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
    @elseif($notification->type == 'App\Notifications\TicketNotification' || $notification->type == 'App\Notifications\TicketSolvedNotification')
        <?php
            $ticket = \App\Models\Ticket::find($notification->data['ticket_id']);
        ?>

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
                                                                <p>Location: {{ $ticket->user->location }}</p>
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
    @else
        <?php
            $activity = \App\Models\Activity::find($notification->data['activity_id']);
        ?>

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
                                                                <h6 class="d-block">Title: {{ $activity->title }}</h6>
                                                                <p>Assigned To: {{ $activity->user->location }}</p>
                                                                <p>Date: {{ date('d-M-Y',strtotime($activity->created_at)) }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="email-wrapper">
                                                {!! $activity->description !!}
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
    @endif

@endsection

@section('required_css')
@endsection

@section('custom_css')
@endsection

@section('required_js')
@endsection

@section('custom_js')
@endsection
