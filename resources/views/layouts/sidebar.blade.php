@php($auth_user = auth()->user())
<header class="main-nav">
    <nav>
        <div class="main-navbar">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="mainnav">
                @if($auth_user->user_type == 'admin')
                <ul class="nav-menu custom-scrollbar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav" href="{{ route('dashboard') }}">
                            <i data-feather="home"></i><span>Dashboard</span>
                        </a>
                    </li>
                    <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i data-feather="users"></i><span>Users</span></a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="{{ route('user.create') }}">Add User</a></li>
                            <li><a href="{{ route('user.index') }}">User List</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i data-feather="smartphone"></i><span>Devices</span></a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="{{ route('device.index') }}">Device List</a></li>
                            {{--<li><a href="{{ route('assignDevice.create') }}">Assign Device</a></li>--}}
                            {{--<li><a href="{{ route('assignDevice.index') }}">Device List</a></li>--}}
                            <li><a href="{{ route('device.not.updated') }}">Not Updated Devices</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)">
                            <i data-feather="mail"></i><span>Email</span></a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="{{ route('email.create') }}">Compose</a></li>
                            <li><a href="{{ route('email.index') }}">Email List</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title" href="javascript:void(0)">
                            <i data-feather="activity"></i><span>Activity</span></a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="{{ route('activity.create') }}">Add Activity</a></li>
                            <li><a href="{{ route('activity.index') }}">Activity List</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav" href="{{ route('ticket.index') }}">
                            <i data-feather="headphones"></i><span>Support Tickets</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav" href="{{ route('config.index') }}">
                            <i data-feather="aperture"></i><span>Settings</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title" href="javascript:void(0)">
                            <i data-feather="aperture"></i><span>Manuals</span></a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="{{ route('pdf.create')}}">Add Pdf</a></li>
                            <li><a href="{{ route('pdf.index')}}">Pdf List</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title" href="javascript:void(0)">
                            <i data-feather="aperture"></i><span>Video</span></a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="{{ route('video.create')}}">Add Video</a></li>
                            <li><a href="{{ route('video.index')}}">Video List</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav" href="{{ route('notification.index') }}">
                            <i data-feather="bell"></i><span>Notification</span>
                        </a>
                    </li>
                </ul>
                @else
                <ul class="nav-menu custom-scrollbar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav" href="{{ route('dashboard') }}">
                            <i data-feather="home"></i><span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav" href="{{ route('device.create') }}">
                            <i data-feather="smartphone"></i> Device List
                        </a>
                    </li>
                    <li class="dropdown">
                        <a class="nav-link menu-title link-nav" href="{{ route('activity.index') }}">
                            <i data-feather="activity"></i><span>Activity</span>
                        </a>
                    </li>
                    <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)">
                            <i data-feather="headphones"></i><span>Support Ticket</span></a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="{{ route('ticket.create') }}">Create</a></li>
                            <li><a href="{{ route('ticket.index') }}">Ticket List</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav" href="{{ route('pdf.index')}}">
                            <i data-feather="clipboard"></i><span>Manuals</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav" href="{{route('video.index')}}">
                            <i data-feather="clipboard"></i><span>Video</span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link menu-title link-nav" href="{{ route('notification.index') }}">
                            <i data-feather="bell"></i><span>Notification</span>
                        </a>
                    </li>
                </ul>
                @endif
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>
