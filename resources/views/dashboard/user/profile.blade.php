@extends ('layouts.app')
@section('title','Profile')
@section('content')

    <div class="container-fluid dashboard-default-sec">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card profile-page">
                    <div class="card-header bg-primary">
                        <span>Profile</span>
                        <span>
                            <a href="{{ route('profile.change',auth()->user()->id) }}"><i class="fa fa-edit"></i></a>
                        </span>
                    </div>
                    <div class="card-body post-about">
                        <div class="profile-image">
                            <img src="{{asset('backend')}}/profile/{{auth()->user()->profile}}" alt="" style="width:170px; height: 170px">
                        </div>
                        <table class="table table-sm table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <td>Location Name : </td>
                                    <td>{{$user->location}}</td>
                                </tr>
                                <tr>
                                    <td>E-mail :</td>
                                    <td>{{$user->email}}</td>
                                </tr>
                                <tr>
                                    <td>Contact Person :</td>
                                    <td>{{$user->name}}</td>
                                </tr>
                                @if($user->phone_one)
                                <tr>
                                    <td>Phone Number : </td>
                                    <td>{{$user->phone_one}}</td>
                                </tr>
                                @endif
                                @if($user->person_two)
                                    <tr>
                                        <td>Contact Person 2 : </td>
                                        <td>{{$user->person_two}}</td>
                                    </tr>
                                @endif
                                @if($user->phone_two)
                                    <tr>
                                        <td>Phone Number 2 : </td>
                                        <td>{{$user->phone_two}}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
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
        ul.profile-wapper li div {display: inline-block;}

        ul.profile-wapper li div:first-child {
            margin-right: 20px;
            width: 25%;
        }

        ul.profile-wapper li i {font-size: 29px;}

        ul.profile-wapper li {margin-bottom: 15px;}
        div.profile-image {
            width: 100%;
            text-align: center;
            margin: 0 auto;
        }
        div.profile-image img{
            border-radius: 50%;
            border: 3px solid;
            margin-bottom: 30px;
        }
        @media only screen and (min-width: 1200px){

        }

        @media (min-width: 992px) and (max-width: 1199.98px){

        }
        @media (min-width: 768px) and (max-width: 991.98px){

        }

        @media (min-width: 576px) and (max-width: 767.98px) {

        }
        @media (min-width: 480px) and (max-width: 575.98px){
            .table tbody tr td:first-child {
                width: 53%;
                padding-left: 4px;
                padding-right: 4px;
            }
        }
        @media (min-width: 420px) and (max-width: 479px){
            .table tbody tr td:first-child {
                width: 53%;
                padding-left: 4px;
                padding-right: 4px;
            }

        }
        @media (min-width: 320px) and (max-width: 419px){
            .table tbody tr td:first-child {
                width: 53%;
                padding-left: 4px;
                padding-right: 4px;
            }
        }
    </style>
@endsection

@section('required_js')
@endsection

@section('custom_js')
@endsection
