<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head')
</head>
<body class="loading"
    data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "dark", "size": "default", "showuser": true}, "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": false}'
>

    <div id="wrapper">

        @include('layouts.navbar')

        @include('layouts.left-sidebar-menu')

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>

                @include('layouts.footer')
            </div>
        </div>

    </div>

    @include('layouts.right-sidebar')

    @include('layouts.script')
</body>
</html>
