@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                @include('components.page-breadcrumb', [
                    'breadcrumbs' => [
                        ['title' => 'Dashboard', 'route' => route('dashboard')],
                        ['title' => __('Administrative Users'), 'route' => route('users.index')],
                        ['title' => isset($user) ? __('Edit') : 'Add New'],
                    ]
                ])
            </div>
            <h4 class="page-title">{{ isset($user) ? 'Edit Administrator'.' ('.$user->name.')' : __('Add New Administrator') }}</h4>
        </div>
    </div>
</div>

@include('components.success-toast')
@include('components.error-toast')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                @if(isset($user))
                {{ Form::model($user,['route' => ['users.update',$user->id], 'method' => 'PUT', 'id' => 'user-form', 'files' => true]) }}
                @else
                {{ Form::open(['route' => 'users.store', 'method' => 'POST', 'id' => 'user-form', 'files' => true]) }}
                @endif
                @csrf

                <div class="row justify-content-center">
                    <div class="px-lg-3 px-md-2 pb-2">
                        @include('components.single-dropzone', [
                            'width' => '200',
                            'height' => '200',
                            'name' => 'avatar',
                            'btn_label' => __('Upload Avatar'),
                            'image' => isset($user) && $user->avatar ? $user->avatar : asset('images/avatar.png'),
                        ])
                    </div>
                    <div class="col-12 col-md order-md-first">
                        <div class="form-group row mb-2 mb-sm-3">
                            <label for="role_id" class="col-sm-3 col-form-label">Role <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                {{
                                    Form::select(
                                        "role_id",
                                        ['' => 'Choose Role'] + $roles,
                                        isset($user,$user->roles[0]) ? $user->roles[0]->id : null,
                                        ["class" => "form-control", 'id' => 'role_id']
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
                        <div class="form-group row mb-2 mb-sm-3 justify-content-end">
                            <div class="col-sm-9">
                                <div class="custom-control custom-checkbox checkbox-success">
                                    <input type="hidden" name="status" value="0">
                                    {{
                                        Form::checkbox(
                                            'status',
                                            '1',
                                            isset($user) ? null : true,
                                            ['class' => 'custom-control-input', 'id' => 'status']
                                        )
                                    }}
                                    <label class="custom-control-label" for="status">Active</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-sm-9">
                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                    <i class="mdi mdi-content-save mr-1"></i>@lang('Save')
                                </button>
                            <a id="btn-cancel" href="{{ route('users.index') }}" class="btn btn-danger waves-effect waves-light">
                                    <i class="mdi mdi-cancel mr-1"></i>@lang('Cancel')
                                </a>
                            </div>
                        </div>
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
    @if (isset($user))
        {!! JsValidator::formRequest('App\Http\Requests\User\UpdateRequest', '#user-form') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\User\CreateRequest', '#user-form') !!}
    @endif
@endpush
