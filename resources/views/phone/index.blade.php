@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                @include('components.page-breadcrumb', [
                    'breadcrumbs' => [
                        ['title' => 'Dashboard', 'route' => route('dashboard')],
                        ['title' => __('Phone Number')]
                    ]
                ])
            </div>
            <h4 class="page-title">{{ __('Phone Number') }}</h4>
        </div>
    </div>
</div>

@include('components.success-toast')
@include('components.error-toast')

<div class="row">
    <div class="col-md-5 col-lg-4">
        <div class="card">
            <div class="card-header font-weight-bold">
                <div class="d-flex justify-content-between align-items-center">
                    <div>{{ isset($phone) ? __('Edit Phone') : 'Add New Phone' }}</div>
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#import-modal">
                        <i class="fa fa-file-excel"></i>
                    </button>
                </div>

            </div>
            <div class="card-body">
                @if(isset($phone))
                {{ Form::model($phone,['route' => ['phones.update',$phone], 'method' => 'PUT', 'id' => 'phone-form']) }}
                @else
                {{ Form::open(['route' => 'phones.store', 'method' => 'POST', 'id' => 'phone-form']) }}
                @endif
                @csrf

                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="form-group mb-2 mb-sm-3">
                            <label for="name">Phone Number <span class="text-danger">*</span></label>
                            {{
                                Form::text(
                                    "value",
                                    null,
                                    ["class" => "form-control", "placeholder" => "Phone number", 'id' => 'value']
                                )
                            }}
                        </div>
                        <div class="form-group mb-2 mb-sm-3 justify-content-end">
                            <div class="custom-control custom-checkbox checkbox-success">
                                <input type="hidden" name="status" value="0">
                                {{
                                    Form::checkbox(
                                        'status',
                                        '1',
                                        isset($phone) ? null : true,
                                        ['class' => 'custom-control-input', 'id' => 'status']
                                    )
                                }}
                                <label class="custom-control-label" for="status">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-center">
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-success waves-effect waves-light btn-block">
                                    <i class="mdi mdi-content-save mr-1"></i>@lang('Save')
                                </button>
                            </div>
                            <div class="col">
                                <a id="btn-cancel" href="{{ route('phones.index') }}" class="btn btn-danger waves-effect waves-light btn-block">
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
    <div class="col-md-7 col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-9">
                        @include('phone.partials.filter-form')
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 20px;">#</th>
                                <th>Phone Number</th>
                                <th>Status</th>
                                <th style="width: 125px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($phones->count())
                                @foreach ($phones as $index => $item)
                                <tr>
                                    <td>{{ ($phones->perPage() * ($phones->currentPage() - 1)) + $index + 1 }}</td>
                                    <td>{{ $item->value }}</td>
                                    <td>{!! $item->statusBadge !!}</td>
                                    <td>
                                        @include('components.table-action', [
                                            'edit_route' => route('phones.edit', $item),
                                            'delete_route' => route('phones.destroy', $item)
                                        ])
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                    <tr class="text-center">
                                        <td colspan="4">@lang('No data')</td>
                                    </tr>
                            @endif

                        </tbody>
                    </table>
                </div>

                @include('components.pagination', ['models' => $phones])
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="import-modal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="importModalLabel">Import Phones</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form id="form" method="POST" action="{{ route('phones.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">
                            @lang('Excel file') <span class="text-danger">*</span>
                            (<small for="file">Get sample file <a href="{{ asset('lucky-draw/files/phone.xlsx') }}" download>here</a></small>)
                        </label>
                        <input type="file" name="file" class="form-control-file" id="file" accept=".xlsx,.xls" multiple>
                    </div>
                </form>
                <div class="text-center mt-2 mb-2" id="message"></div>
                <div id="loading-indicator" class="loading-indicator text-center d-none">
                    <div class="spinner-border text-success" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btn-close" type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Cancel')</button>
                <button id="btn-submit" type="button" class="btn btn-primary" form="file-form">Import</button>
            </div>
        </div>
    </div>
</div>

@endsection


@push('js')
    <script src="{{ asset('admin/js/custom/import.js') }}"></script>
    <script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    @if (isset($phone))
        {!! JsValidator::formRequest('App\Http\Requests\Phone\UpdateRequest', '#phone-form') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\Phone\CreateRequest', '#phone-form') !!}
    @endif
@endpush
