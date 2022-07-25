<!DOCTYPE html>
<html lang="en">
<head>
    <!-- PWA  -->
    <link rel="apple-touch-icon" href="{{ asset('backend') }}/images/{{ setting('favicon') }}">
    <meta name="theme-color" content="#6777ef"/>
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('backend') }}/images/{{ setting('favicon') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('backend') }}/images/{{ setting('favicon') }}" type="image/x-icon">
    <title>@yield('title') - {{ config('app.name', 'CRD Online') }}</title>
    @yield('required_css')

    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/fontawesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/feather-icon.css">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/animate.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/chartist.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/date-picker.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/vector-map.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/select2.css">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/style.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/custom.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/sweetalert/sweetalert.css">
    <link id="color" rel="stylesheet" href="{{ asset('backend') }}/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend') }}/css/responsive.css">
    {{--<link rel="stylesheet" href="{{ asset('css/app.css') }}">--}}

    @yield('custom_css')
    <style>
        .mobile-device{
            display: none;
        }

        .card.profile-page .card-header span:first-child {float: left;}

        .card.profile-page .card-header span:last-child {float: right;}

        .card.profile-page .card-header span:last-child a i {color: #fff;}
        .float-right.mobile-device ul li {margin-right: 10px;}

        .float-right.mobile-device ul li a i {font-size: 18px;/* margin-right: 10px; */}

        .float-right.mobile-device ul li:last-child a i {margin-right: 10px;}

        .float-right.mobile-device ul li:nth-child(2) i {font-size: 17px;}

        .float-right.mobile-device {text-align: right;}
        .card-body.text-center.welcome-back {padding: 139px 0px;}
        .card.total-device {padding: 13px 0px;}
        .card.total-device h6 strong {margin-right: 12px;}
        .card.total-device h6:first-child strong {color: #000087;}
        .card.total-device h6:last-child strong {color: #008140;}
        .card.income-card.card-secondary.four-device p strong {margin-right: 5px;}
        .card.income-card.card-secondary.four-device p.total-device strong {color: #000087;}
        .card.income-card.card-secondary.four-device p {font-size: 13px;}
        .card.income-card.card-secondary.four-device p.update-device strong {color: #008140;}
        @media only screen and (max-width: 767px) {
            .mobile-device{
                display: block;
                width: 49%;
            }
            .page-wrapper .page-main-header .main-header-right .main-header-left {
                width: 50%;
            }
            .mobile-toggle {
                display: none!important;
            }
            .profile-greeting {
                margin-top: 40px;
            }
            .card-body.text-center.welcome-back {
                padding: 40px 0px;
            }
            .onhover-show-div {
                left: -200px;
                top: 54px;
                width: 271px;
            }
            .onhover-dropdown:hover .onhover-show-div:before,
            .onhover-dropdown:hover .onhover-show-div:after{
                left: 76%;
            }
            ul.notification-dropdown.onhover-show-div > li > p span {
                margin-left: 10px;
            }
            .onhover-dropdown:hover .onhover-show-div li.noti-primary {width: 100%;text-align: left;padding: 10px 20px;}

            .page-main-header .main-header-right .nav-right .notification-dropdown li .media .notification-bg {background-color: rgba(36, 105, 92, 0.1);
                color: #24695c;width: 40px;
                height: 40px;
                border-radius: 100%;
                margin-right: 15px;}

            .onhover-dropdown:hover .onhover-show-div li.noti-primary > div > span {background-color: rgba(36, 105, 92, 0.1);
                color: #24695c;width: 40px;
                height: 40px;
                border-radius: 100%;
                margin-right: 15px;text-align: center;line-height: 40px;}

            .onhover-dropdown:hover .onhover-show-div li.noti-primary .media-body p {font-weight: 700;color: #24695c;margin-bottom: 0;}

            .onhover-dropdown:hover .onhover-show-div li.noti-primary:hover {background-color: rgba(36, 105, 92, 0.1);}

            .onhover-dropdown:hover .onhover-show-div li.noti-primary:hover > div > span {background-color: #24695c;
                color: #fff;}

        }

        @media only screen and (max-width: 600px) {
           .mobile-device{
               display: block;
               width: 49%;
           }
            .page-wrapper .page-main-header .main-header-right .main-header-left {
                width: 50%;
            }
            .mobile-toggle {
                display: none!important;
            }
            .profile-greeting {
                margin-top: 10px;
            }
            .card-body.text-center.welcome-back {
                padding: 40px 0px;
            }
            .onhover-show-div {
                left: -200px;
                top: 54px;
                width: 271px;
            }
            .onhover-dropdown:hover .onhover-show-div:before,
            .onhover-dropdown:hover .onhover-show-div:after{
                left: 76%;
            }
            ul.notification-dropdown.onhover-show-div > li > p span {
                margin-left: 10px;
            }
            .onhover-dropdown:hover .onhover-show-div li.noti-primary {width: 100%;text-align: left;padding: 10px 20px;}

            .page-main-header .main-header-right .nav-right .notification-dropdown li .media .notification-bg {background-color: rgba(36, 105, 92, 0.1);
                color: #24695c;width: 40px;
                height: 40px;
                border-radius: 100%;
                margin-right: 15px;}

            .onhover-dropdown:hover .onhover-show-div li.noti-primary > div > span {background-color: rgba(36, 105, 92, 0.1);
                color: #24695c;width: 40px;
                height: 40px;
                border-radius: 100%;
                margin-right: 15px;text-align: center;line-height: 40px;}

            .onhover-dropdown:hover .onhover-show-div li.noti-primary .media-body p {font-weight: 700;color: #24695c;margin-bottom: 0;}

            .onhover-dropdown:hover .onhover-show-div li.noti-primary:hover {background-color: rgba(36, 105, 92, 0.1);}

            .onhover-dropdown:hover .onhover-show-div li.noti-primary:hover > div > span {background-color: #24695c;
                color: #fff;}

        }
        @media only screen and (max-width: 575px) {
            .mobile-device{
                display: block;
                width: 49%;
            }
            .page-wrapper .page-main-header .main-header-right .main-header-left {
                width: 50%;
            }
            .mobile-toggle {
                display: none!important;
            }
            .profile-greeting {
                margin-top: 10px;
            }
            .card-body.text-center.welcome-back {
                padding: 40px 0px;
            }
            .onhover-show-div {
                left: -200px;
                top: 54px;
                width: 271px;
            }
            .onhover-dropdown:hover .onhover-show-div:before,
            .onhover-dropdown:hover .onhover-show-div:after{
                left: 76%;
            }
            ul.notification-dropdown.onhover-show-div > li > p span {
                margin-left: 10px;
            }
            .onhover-dropdown:hover .onhover-show-div li.noti-primary {width: 100%;text-align: left;padding: 10px 20px;}

            .page-main-header .main-header-right .nav-right .notification-dropdown li .media .notification-bg {background-color: rgba(36, 105, 92, 0.1);
                color: #24695c;width: 40px;
                height: 40px;
                border-radius: 100%;
                margin-right: 15px;}

            .onhover-dropdown:hover .onhover-show-div li.noti-primary > div > span {background-color: rgba(36, 105, 92, 0.1);
                color: #24695c;width: 40px;
                height: 40px;
                border-radius: 100%;
                margin-right: 15px;text-align: center;line-height: 40px;}

            .onhover-dropdown:hover .onhover-show-div li.noti-primary .media-body p {font-weight: 700;color: #24695c;margin-bottom: 0;}

            .onhover-dropdown:hover .onhover-show-div li.noti-primary:hover {background-color: rgba(36, 105, 92, 0.1);}

            .onhover-dropdown:hover .onhover-show-div li.noti-primary:hover > div > span {background-color: #24695c;
                color: #fff;}

        }
    </style>
</head>
<body>
<!-- Loader starts-->
<div class="loader-wrapper">
    <div class="theme-loader">
        <div class="loader-p"></div>
    </div>
</div>

<!-- page-wrapper Start-->
<div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        @include('layouts.header')
        <!-- Page Header Ends -->

        <!-- Page Body Start-->
        <div class="page-body-wrapper sidebar-icon">

            <!-- Page Sidebar Start-->
            @include('layouts.sidebar')
            <!-- Page Sidebar Ends-->


            <div class="page-body">

                <section id="content-message" style="clear: both;">
                    <div>
                        <div class="col-md-12">
                            <div class="script-message"></div>
                            @if(Session::has('message'))
                                <div class="alert {{ Session::get('m-class') }} alert-dismissible"
                                     style="margin-top: 10px;">
                                    {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>--}}
                                    <!--<h4><i class="icon fa fa-check"></i> Alert!</h4>-->
                                    {!! Session::get('message') !!}
                                </div>
                            @endif

                        </div>
                    </div>
                </section>

                @yield('content')
            </div>
            <!-- Page Footer Start-->
            @include('layouts.footer')
            <!-- Page Footer Ends-->
        </div>
</div>

{{--<script src="{{ asset('/sw.js') }}"></script>--}}
{{--<script>--}}
    {{--if (!navigator.serviceWorker.controller) {--}}
        {{--navigator.serviceWorker.register("/sw.js").then(function (reg) {--}}
            {{--console.log("Service worker has been registered for scope: " + reg.scope);--}}
        {{--});--}}
    {{--}--}}
{{--</script>--}}
<script src="{{ asset('js/app.js') }}"></script>
<!-- latest jquery-->
<script src="{{ asset('backend') }}/js/jquery-3.5.1.min.js"></script>
<script src="{{ asset('backend') }}/js/bootstrap/popper.min.js"></script>
<script src="{{ asset('backend') }}/js/bootstrap/bootstrap.min.js"></script>

@yield('required_js')

<!-- feather icon js-->
<script src="{{ asset('backend') }}/js/datatable/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('backend') }}/js/datatable/datatables/datatable.custom.js"></script>
<script src="{{ asset('backend') }}/js/icons/feather-icon/feather.min.js"></script>
<script src="{{ asset('backend') }}/js/icons/feather-icon/feather-icon.js"></script>
<!-- Sidebar jquery-->
<script src="{{ asset('backend') }}/js/sidebar-menu.js"></script>
<script src="{{ asset('backend') }}/js/config.js"></script>
<!-- Bootstrap js-->

<!-- Plugins JS start-->
<script src="{{ asset('backend') }}/js/chart/chartist/chartist.js"></script>
<script src="{{ asset('backend') }}/js/chart/chartist/chartist-plugin-tooltip.js"></script>
{{--<script src="{{ asset('backend') }}/js/chart/knob/knob-chart.js"></script>--}}
<script src="{{ asset('backend') }}/js/chart/apex-chart/apex-chart.js"></script>
<script src="{{ asset('backend') }}/js/chart/apex-chart/stock-prices.js"></script>
<script src="{{ asset('backend') }}/js/prism/prism.min.js"></script>
<script src="{{ asset('backend') }}/js/clipboard/clipboard.min.js"></script>
<script src="{{ asset('backend') }}/js/counter/jquery.waypoints.min.js"></script>
<script src="{{ asset('backend') }}/js/counter/jquery.counterup.min.js"></script>
<script src="{{ asset('backend') }}/js/counter/counter-custom.js"></script>
<script src="{{ asset('backend') }}/js/custom-card/custom-card.js"></script>
<script src="{{ asset('backend') }}/js/notify/bootstrap-notify.min.js"></script>
<script src="{{ asset('backend') }}/js/vector-map/jquery-jvectormap-2.0.2.min.js"></script>
<script src="{{ asset('backend') }}/js/vector-map/map/jquery-jvectormap-world-mill-en.js"></script>
<script src="{{ asset('backend') }}/js/vector-map/map/jquery-jvectormap-us-aea-en.js"></script>
<script src="{{ asset('backend') }}/js/vector-map/map/jquery-jvectormap-uk-mill-en.js"></script>
<script src="{{ asset('backend') }}/js/vector-map/map/jquery-jvectormap-au-mill.js"></script>
<script src="{{ asset('backend') }}/js/vector-map/map/jquery-jvectormap-chicago-mill-en.js"></script>
<script src="{{ asset('backend') }}/js/vector-map/map/jquery-jvectormap-in-mill.js"></script>
<script src="{{ asset('backend') }}/js/vector-map/map/jquery-jvectormap-asia-mill.js"></script>
<script src="{{ asset('backend') }}/js/dashboard/default.js"></script>
<!--<script src="{{ asset('backend') }}/js/notify/index.js"></script>-->
<script src="{{ asset('backend') }}/js/datepicker/date-picker/datepicker.js"></script>
<script src="{{ asset('backend') }}/js/datepicker/date-picker/datepicker.en.js"></script>
<script src="{{ asset('backend') }}/js/datepicker/date-picker/datepicker.custom.js"></script>
<script src="{{ asset('backend') }}/js/select2/select2.full.min.js"></script>
<script src="{{ asset('backend') }}/sweetalert/sweetalert.js"></script>

<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('backend') }}/js/script.js"></script>
<!--<script src="{{ asset('backend') }}/js/theme-customizer/customizer.js"></script>-->
<!-- login js-->
<!-- Plugin used-->

@yield('custom_js')
</body>
</html>
