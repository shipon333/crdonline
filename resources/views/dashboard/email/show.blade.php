@extends ('layouts.app')
@section('title','Email Details')
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
                                                            <h6 class="d-block">Subject: {{ $email->subject }}</h6>
                                                            <p>To:
                                                                @if(!empty($email->users))
                                                                    @foreach($email->users as $user)
                                                                        <a href="{{ route('user.show',$user->id) }}">{{ $user->location }}</a>,
                                                                    @endforeach
                                                                @else
                                                                    All
                                                                @endif
                                                            </p>
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

@endsection

@section('required_css')
@endsection

@section('custom_css')
@endsection

@section('required_js')
@endsection

@section('custom_js')
@endsection
