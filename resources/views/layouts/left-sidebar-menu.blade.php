<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">
            <img src="{{ auth()->user()->avatar }}" alt="user-img" title="Mat Helme"
                class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                    data-toggle="dropdown">{{ auth()->user()->name }}</a>
                <div class="dropdown-menu user-pro-dropdown">

                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user mr-1"></i>
                        <span>My Profile</span>
                    </a>
                    <a href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();" class="dropdown-item notify-item">
                        <i class="fe-log-out mr-1"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </div>
            <p class="text-muted">{{ auth()->user()->role_name }}</p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li>
                    <a href="{{ route('dashboard') }}">
                        <i data-feather="airplay"></i>
                        <span> @lang('Dashboard') </span>
                    </a>
                </li>

                <!-- ========== APPLICATION MODULES ========== -->
                @canany(['Phone Read', 'Prize Read', 'Draw Read'])
                <li class="menu-title mt-2">Application Modules</li>
                @can('Draw Read')
                <li>
                    <a href="{{ route('draws.index') }}">
                        <i data-feather="codesandbox"></i>
                        <span> @lang('Draws') </span>
                    </a>
                </li>
                @endcan
                @can('Draw Read')
                <li>
                    <a href="{{ route('prizes.index') }}">
                        <i data-feather="gift"></i>
                        <span> @lang('Prizes') </span>
                    </a>
                </li>
                @endcan
                @can('Phone Read')
                <li>
                    <a href="{{ route('phones.index') }}">
                        <i data-feather="phone"></i>
                        <span> @lang('Phones') </span>
                    </a>
                </li>
                @endcan
                @endcanany


                <!-- ========== APPLICATION SETTING ========== -->
                @canany(['Setting Read', 'Administration Read'])
                <li class="menu-title mt-2">Application Setting</li>
                @can('Setting Read')
                <li>
                    <a href="{{ route('settings.index') }}">
                        <i data-feather="settings"></i>
                        <span> @lang('Settings') </span>
                    </a>
                </li>
                @endcan

                @can('Administration Read')
                <li>
                    <a href="#administrators" data-toggle="collapse">
                        <i data-feather="users"></i>
                        <span> Administrators </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="administrators">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('users.index') }}">@lang('Users')</a>
                            </li>
                            <li>
                                <a href="{{ route('roles.index') }}">@lang('Roles & Permissions')</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endcan
                @endcanany
            </ul>

        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
