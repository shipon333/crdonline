
<div class="page-main-header">
    <div class="main-header-right row m-0">
        <div class="main-header-left">
            <div class="logo-wrapper">
                <a href="{{ route('dashboard') }}">
                    <img class="img-fluid" src="{{ asset('backend') }}/images/{{ setting('logo') }}" alt="">
                </a>
            </div>
            <div class="dark-logo-wrapper">
                <a href="{{ route('dashboard') }}">
                    <img class="img-fluid" src="{{ asset('backend') }}/images/{{ setting('logo') }}" alt="">
                </a>
            </div>
            <div class="toggle-sidebar">
                <i class="status_toggle middle" data-feather="align-center" id="sidebar-toggle"></i>
            </div>
        </div>
        <div class="nav-right col pull-right right-menu p-0">
            <ul class="nav-menus">
                <li class="onhover-dropdown">
                    <a href="{{route('user.show',auth()->user()->id)}}"><i data-feather="users"></i></a>
                </li>
                <li class="onhover-dropdown">
                    <?php
                        $notifications = auth()->user()->unreadNotifications;
                        $_count = count($notifications);
                    ?>
                    <div class="notification-box">
                        <i data-feather="bell"></i>
                        @if($_count > 0)
                        <span class="dot-animated"></span>
                        @endif
                    </div>
                    <ul class="notification-dropdown onhover-show-div">
                        <li>
                            <p class="f-w-700 mb-0">

                                @if($_count > 0)
                                    <span class="badge badge-primary badge-pill"> {{ $_count }}</span>
                                    new notifications
                                @else
                                    No notification
                                @endif
                                <span class="pull-right">
                                    <a href="{{ route('notification.index') }}" style="text-decoration: underline;">See All</a>
                                </span>
                            </p>
                        </li>
                        @foreach($notifications as $notification)
                            <li class="noti-primary">
                                <a href="{{ route('notification.show',$notification->id) }}">
                                    <div class="media">
                                            <span class="notification-bg bg-light-primary">
                                                <i class="fa fa-bell"></i>
                                            </span>
                                        <div class="media-body">
                                            <p>{{ $notification->data['title'] }} </p>
                                            <span>{{ $notification->created_at->diffForHumans() }} </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <!--<li>-->
                <!--<div class="mode"><i class="fa fa-moon-o"></i></div>-->
                <!--</li>-->
                <li class="onhover-dropdown p-0">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a onclick="event.preventDefault(); this.closest('form').submit();">
                            <i data-feather="log-out"></i>Log out
                        </a>
                    </form>
                </li>
            </ul>
        </div>
        <div class="float-right mobile-device">
            <ul class="nav-menus">
                <li class="onhover-dropdown">
                    <a href="{{route('user.show',auth()->user()->id)}}"><i data-feather="users"></i></a>
                </li>
                <li class="onhover-dropdown">
                    <?php
                        $notifications = auth()->user()->unreadNotifications;
                        $_count = count($notifications);
                    ?>
                    <div class="notification-box">
                        <i data-feather="bell"></i>
                        @if($_count > 0)
                            <span class="dot-animated"></span>
                        @endif
                    </div>
                    <ul class="notification-dropdown onhover-show-div">
                        <li>
                            @if($_count > 0)
                                <span class="badge badge-primary badge-pill"> {{ $_count }}</span>
                                new notifications
                            @else
                                No notification
                            @endif
                            <span class="pull-right">
                                <a href="{{ route('notification.index') }}" style="text-decoration: underline;">See All</a>
                            </span>
                        </li>
                        @foreach($notifications as $notification)
                            <li class="noti-primary">
                                <a href="{{ route('notification.show',$notification->id) }}">
                                    <div class="media">
                                            <span class="notification-bg bg-light-primary">
                                                <i class="fa fa-bell"></i>
                                            </span>
                                        <div class="media-body">
                                            <p>{{ $notification->data['title'] }} </p>
                                            <span>{{ $notification->created_at->diffForHumans() }} </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <!--<li>-->
                <!--<div class="mode"><i class="fa fa-moon-o"></i></div>-->
                <!--</li>-->
                <li class="onhover-dropdown p-0">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a onclick="event.preventDefault(); this.closest('form').submit();">
                            <i data-feather="log-out"></i>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
        <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
    </div>
</div>

