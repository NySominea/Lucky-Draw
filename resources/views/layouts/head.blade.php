<meta charset="utf-8" />
<title>Dashboard | {{ $settings[SettingKey::SiteName] }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="{{ $settings[SettingKey::SiteDescription] }}" name="description" />
<meta content="NySominea" name="author" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<!-- App favicon -->
<link rel="shortcut icon" href="{{ $settings[SettingKey::SiteLogo] }}">

<!-- Plugins css -->
<link href="{{ asset('admin/libs/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />

<!-- App css -->
<link href="{{ asset('admin/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="{{ asset('admin/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

<link href="{{ asset('admin/css/bootstrap-dark.min.css')}}" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
<link href="{{ asset('admin/css/app-dark.min.css')}}" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

<!-- icons -->
<link href="{{ asset('admin/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

<link href="{{ asset('admin/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Custom -->
<link href="{{ asset('admin/css/custom.css')}}" rel="stylesheet" type="text/css" />
@stack('css')
