@extends('layouts.app')

@push('css')
    <link href="{{ asset('admin/libs/mohithg-switchery/switchery.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                @include('components.page-breadcrumb', [
                    'breadcrumbs' => [
                        ['title' => 'Dashboard', 'route' => route('dashboard')],
                        ['title' => __('Administrative Roles'), 'route' => route('roles.index')],
                        ['title' => isset($role) ? __('Edit') : 'Add New'],
                    ]
                ])
            </div>
            <h4 class="page-title">{{ isset($role) ? 'Edit Role'.' ('.$role->name.')' : __('Add New Role') }}</h4>
        </div>
    </div>
</div>

@include('components.success-toast')
@include('components.error-toast')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                @if(isset($role))
                {{ Form::model($role,['route' => ['roles.update',$role], 'method' => 'PUT', 'id' => 'role-form']) }}
                @else
                {{ Form::open(['route' => 'roles.store', 'method' => 'POST', 'id' => 'role-form']) }}
                @endif
                @csrf

                <div class="row justify-content-center">
                    <div class="col-md-6">
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
                    </div>
                    <div class="col-md-6"></div>
                    <div class="col-12">

                        <div class="mb-2 mb-sm-3">
                            <label for="permissions" class="col-form-label">Permissions <span class="text-danger">*</span></label>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>@lang('Modules / ActionType')</td>
                                            @foreach(permission_actions() as $action)
                                            <th class="text-center">{{ $action['label'] }}</td>
                                            @endforeach
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach (permission_modules() as $module)
                                        <tr>
                                            <td><strong>{{ $module['label'] }}</strong></td>
                                            @php
                                                $permissions = [];
                                                if (isset($role)) $permissions = $role->permissions->pluck('name')->all()
                                            @endphp
                                            @foreach(permission_actions() as $action)
                                            <td class="text-center">
                                                <input name="permissions[]" type="checkbox"
                                                    value="{{ $module['key'].' '.$action['label'] }}"
                                                    {{ in_array($module['key'].' '.$action['label'], $permissions) ? 'checked' : '' }}
                                                    class="switchery" data-plugin="switchery" data-color="#1bb99a" data-size="small"/>
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-success waves-effect waves-light">
                            <i class="mdi mdi-content-save mr-1"></i>@lang('Save')
                        </button>
                        <a id="btn-cancel" href="{{ route('roles.index') }}" class="btn btn-danger waves-effect waves-light">
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
    @if (isset($role))
        {!! JsValidator::formRequest('App\Http\Requests\Role\UpdateRequest', '#role-form') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\Role\CreateRequest', '#role-form') !!}
    @endif

    <script src="{{ url('admin/libs/mohithg-switchery/switchery.min.js') }}"></script>
    <script>
        $('.switchery').each(function () {
            new Switchery($(this)[0],$(this).data())
        })
    </script>
@endpush
