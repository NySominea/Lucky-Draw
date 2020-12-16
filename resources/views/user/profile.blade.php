@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                @include('components.page-breadcrumb', [
                    'breadcrumbs' => [
                        ['title' => 'Dashboard', 'route' => route('dashboard')],
                        ['title' => 'My Profile'],
                    ]
                ])
            </div>
            <h4 class="page-title">{{ __('My Profile') }}</h4>
        </div>
    </div>
</div>

@include('components.success-toast')
@include('components.error-toast')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                {{ Form::model($user,['route' => ['my-profile.update', $user->id], 'method' => 'PUT', 'id' => 'user-form', 'files' => true]) }}
                @csrf

                <ul class="nav nav-tabs nav-bordered">
                    <li class="nav-item">
                        <a href="#profile" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#change-password" data-toggle="tab" aria-expanded="true" class="nav-link">
                            Change Password
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="profile">
                        <div class="row justify-content-center">
                            <div class="px-lg-3 px-md-2 pb-2">
                                @include('components.single-dropzone', [
                                    'width' => '200',
                                    'height' => '200',
                                    'name' => 'avatar',
                                    'btn_label' => __('Upload Avatar'),
                                    'image' => $user->avatar ? $user->avatar : asset('images/avatar.png'),
                                ])
                            </div>
                            <div class="col-12 col-md order-md-first">
                                <div class="form-group row mb-2 mb-sm-3">
                                    <label for="role_id" class="col-sm-3 col-form-label">Role <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        {{
                                            Form::select(
                                                "role_id",
                                                [isset($user->roles[0]) ? $user->roles[0]->name : 'No access role'],
                                                null,
                                                ["class" => "form-control", 'id' => 'role_id', 'disabled']
                                            )
                                        }}
                                    </div>
                                </div>
                                <div class="form-group row mb-2 mb-sm-3">
                                    <label for="name" class="col-sm-3 col-form-label">Name <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        {{
                                            Form::text(
                                                "name",
                                                null,
                                                ["class" => "form-control", "placeholder" => "Name", 'id' => 'name']
                                            )
                                        }}
                                    </div>
                                </div>
                                <div class="form-group row mb-2 mb-sm-3">
                                    <label for="email" class="col-sm-3 col-form-label">Email <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        {{
                                            Form::email(
                                                "email",
                                                null,
                                                ["class" => "form-control", "placeholder" => "Email", 'id' => 'email']
                                            )
                                        }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="change-password">
                        <div class="row justify-content-center">
                            <div class="col">
                                <div class="form-group row mb-2 mb-sm-3">
                                    <label for="password" class="col-sm-3 col-form-label">Old Password <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        {{
                                            Form::password(
                                                "old_password",
                                                ["class" => "form-control", "placeholder" => "Old Password", 'autocomplete' => 'off', 'id' => 'old_password']
                                            )
                                        }}
                                    </div>
                                </div>
                                <div class="form-group row mb-2 mb-sm-3">
                                    <label for="password" class="col-sm-3 col-form-label">Password <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        {{
                                            Form::password(
                                                "password",
                                                ["class" => "form-control", "placeholder" => "Password", 'autocomplete' => 'off', 'id' => 'password']
                                            )
                                        }}
                                    </div>
                                </div>
                                <div class="form-group row mb-2 mb-sm-3">
                                    <label for="password_confirmation" class="col-sm-3 col-form-label">Re Password <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        {{
                                            Form::password(
                                                "password_confirmation",
                                                ["class" => "form-control", "placeholder" => "Password Confirmation", 'autocomplete' => 'off', 'id' => 'password_confirmation']
                                            )
                                        }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-0 justify-content-end row text-center">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-success waves-effect waves-light">
                            <i class="mdi mdi-content-save mr-1"></i>@lang('Save')
                        </button>
                        <a id="btn-cancel" href="{{ route('my-profile.index') }}" class="btn btn-danger waves-effect waves-light">
                            <i class="mdi mdi-cancel mr-1"></i>@lang('Cancel')
                        </a>
                    </div>
                </div>

                {{ Form::close() }}
            </div>

        </div>
    </div>
</div>

@endsection

@push('js')
    <script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\User\ProfileRequest', '#user-form') !!}
@endpush
