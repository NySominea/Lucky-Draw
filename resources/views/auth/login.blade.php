<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Log In | {{ $settings[SettingKey::SiteName] }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="{{ $settings[SettingKey::SiteDescription] }}" name="description" />
        <meta content="NySominea" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ $settings[SettingKey::SiteLogo] }}">

		<!-- App css -->
		<link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
		<link href="{{ asset('admin/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

		<link href="{{ asset('admin/css/bootstrap-dark.min.css') }}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
		<link href="{{ asset('admin/css/app-dark.min.css') }}" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

		<!-- icons -->
        <link href="{{ asset('admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

        <style>
            body.authentication-bg {
                min-height: 100% !important;
                padding-bottom: 0px !important;
            }
        </style>

    </head>

    <body class="loading authentication-bg authentication-bg-pattern bg-blue">
        <div class="account-pages">
            <div class="container">
                <div class="row justify-content-center align-items-center" style="height: 100vh">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern mb-0">

                            <div class="card-body p-4">

                                <div class="text-center w-75 m-auto">
                                    <div class="auth-logo mb-3">
                                        <a href="#" class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                                <img src="{{ $settings[SettingKey::SiteLogo] }}" alt="{{ $settings[SettingKey::SiteName] }}" height="70">
                                            </span>
                                        </a>

                                        <a href="#" class="logo logo-light text-center">
                                            <span class="logo-lg">
                                                <img src="{{ $settings[SettingKey::SiteLogo] }}" alt="{{ $settings[SettingKey::SiteName] }}" height="50">
                                            </span>
                                        </a>
                                    </div>
                                </div>

                                @if(count($errors->all()))
                                    <div class="alert bg-danger text-white alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                                        @if($errors->failed)
                                            {{ $errors->first() }}
                                        @endif
                                    </div>
                                @endif

                                <form autocomplete="off" action="{{route('auth.login')}}" method="POST" id="login-form">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="name">Username</label>
                                        <input class="form-control" type="text" name="name" id="name" placeholder="Enter your username" autocomplete="off">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" autocomplete="off">
                                            <div class="input-group-append" data-password="false">
                                                <div class="input-group-text">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-success btn-block" type="submit"> Log In </button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer footer-alt text-white-50">
            <script>document.write(new Date().getFullYear())</script> &copy; {{ config('app.name') }}</a>
        </footer>

        <!-- Vendor js -->
        <script src="{{ asset('admin/js/vendor.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('admin/js/app.min.js') }}"></script>

        <script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
        {!! JsValidator::formRequest('App\Http\Requests\User\LoginRequest', '#login-form') !!}

    </body>
</html>
