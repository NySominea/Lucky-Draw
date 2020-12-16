@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                @include('components.page-breadcrumb', [
                    'breadcrumbs' => [
                        ['title' => 'Dashboard', 'route' => route('dashboard')],
                        ['title' => __('Settings')]
                    ]
                ])
            </div>
            <h4 class="page-title">{{ __('Settings') }}</h4>
        </div>
    </div>
</div>

@include('components.success-toast')
@include('components.error-toast')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="text-right">
                            <button form="setting-form" type="submit" form="localization-form" class="btn btn-success waves-effect waves-light">
                                <i class="mdi mdi-content-save mr-1"></i>@lang('Save')
                            </button>
                        </div>
                    </div>
                </div>
                {{ Form::open(['route' => ['settings.store'], 'method' => 'POST', 'id' => 'setting-form']) }}
                    <ul class="nav nav-tabs nav-bordered nav-justified">
                        <li class="nav-item">
                            <a href="#general" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                General
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="#contact" data-toggle="tab" aria-expanded="false" class="nav-link">
                                Contact
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#social-link" data-toggle="tab" aria-expanded="false" class="nav-link">
                                Social Links
                            </a>
                        </li> --}}
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="general">
                            @include('setting.partials.general')
                        </div>
                        {{-- <div class="tab-pane" id="contact">
                            @include('setting.partials.contact')
                        </div>
                        <div class="tab-pane" id="social-link">
                            @include('setting.partials.social-link')
                        </div> --}}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

@endsection
