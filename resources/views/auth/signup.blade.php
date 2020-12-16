<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Sign Up | {{ $settings[SettingKey::SiteName] }}</title>
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
                    <div class="col-md-10 col-lg-8 col-xl-6">
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

                                <form autocomplete="off" action="{{route('auth.signup')}}" method="POST" id="signup-form">
                                    @csrf
                                    <div class="form-group row mb-3">
                                        <label for="email" class="col-3 col-form-label">Email</label>
                                        <div class="col-9">
                                            <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="name" class="col-3 col-form-label">Username</label>
                                        <div class="col-9">
                                            <input type="text" name="name" class="form-control" id="name" placeholder="Username">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="password" class="col-3 col-form-label">Password</label>
                                        <div class="col-9">
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="password_confirmation" class="col-3 col-form-label">Re Password</label>
                                        <div class="col-9">
                                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Retype Password">
                                        </div>
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-success btn-block" type="submit"> Sign Up </button>
                                    </div>

                                </form>

                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-white-50">Already have account? <a href="{{ route('auth.showLoginForm') }}" class="text-white ml-1"><b>Sign In</b></a></p>
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
        {!! JsValidator::formRequest('App\Http\Requests\User\SignupRequest', '#signup-form') !!}

    </body>
</html>
