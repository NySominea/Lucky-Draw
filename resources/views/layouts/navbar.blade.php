<!-- Topbar Start -->
<div class="navbar-custom">
    <div class="container-fluid">
        <ul class="list-unstyled topnav-menu float-right mb-0">

            @php $draw = Draw::currentDrawingRound() @endphp
            @if ($draw)
            <li class="dropdown d-none d-lg-inline-block">
                <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light text-success" target="_BLANK" href="{{ route('draws.lucky-draw') }}">
                    <i class="fe-play noti-icon"></i>
                </a>
            </li>
            @endif

            {{-- <li class="dropdown d-none d-lg-inline-block">
                <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen" href="#">
                    <i class="fe-maximize noti-icon"></i>
                </a>
            </li> --}}

            <li class="dropdown notification-list topbar-dropdown">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ auth()->user()->avatar }}" alt="user-image" class="rounded-circle">
                    <span class="pro-user-name ml-1">
                        {{ auth()->user()->name }} <i class="mdi mdi-chevron-down"></i>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">

                    <a href="{{ route('my-profile.index') }}" class="dropdown-item notify-item">
                        <i class="fe-user"></i>
                        <span>My Profile</span>
                    </a>

                    <div class="dropdown-divider"></div>

                    <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();" class="dropdown-item notify-item">
                        <i class="fe-log-out"></i>
                        <span>Logout</span>
                    </a>
                    <form id="frm-logout" action="{{route('auth.logout')}}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>

        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <a href="{{ route('dashboard') }}" class="logo logo-dark text-center">
                <span class="logo-sm">
                    <img src="{{ $settings[SettingKey::SiteLogo] }}" alt="{{ $settings[SettingKey::SiteName] }}" height="30">
                    <!-- <span class="logo-lg-text-light">UBold</span> -->
                </span>
                <span class="logo-lg">
                    <img src="{{ $settings[SettingKey::SiteLogo] }}" alt="{{ $settings[SettingKey::SiteName] }}" height="40">
                    <!-- <span class="logo-lg-text-light">U</span> -->
                </span>
            </a>

            <a href="{{ route('dashboard') }}" class="logo logo-light text-center">
                <span class="logo-sm">
                    <img src="{{ $settings[SettingKey::SiteLogo] }}" alt="{{ $settings[SettingKey::SiteName] }}" height="30">
                </span>
                <span class="logo-lg">
                    <img src="{{ $settings[SettingKey::SiteLogo] }}" alt="{{ $settings[SettingKey::SiteName] }}" height="40">
                </span>
            </a>
        </div>

        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>
            </li>

            <li>
                <!-- Mobile menu toggle (Horizontal Layout)-->
                <a class="navbar-toggle nav-link" data-toggle="collapse" data-target="#topnav-menu-content">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
</div>
<!-- end Topbar -->
