@extends('layouts.app')

@section('css')
    <link href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css" rel="stylesheet">
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                @include('components.page-breadcrumb', [
                    'breadcrumbs' => [
                        ['title' => 'Dashboard', 'route' => route('dashboard')],
                        ['title' => __('Drawing Prize')]
                    ]
                ])
            </div>
            <h4 class="page-title">{{ __('Drawing Prize') }}</h4>
        </div>
    </div>
</div>

@include('components.success-toast')
@include('components.error-toast')

<div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
        <div class="card">
            <div class="card-header font-weight-bold">
                {{ isset($prize) ? __('Edit Prize') : 'Add New Prize' }}
            </div>
            <div class="card-body">
                @if(isset($prize))
                {{ Form::model($prize,['route' => ['prizes.update',$prize], 'method' => 'PUT', 'id' => 'prize-form']) }}
                @else
                {{ Form::open(['route' => 'prizes.store', 'method' => 'POST', 'id' => 'prize-form']) }}
                @endif
                @csrf

                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="pb-3">
                            @include('components.single-dropzone', [
                                'width' => '210',
                                'height' => '140',
                                'name' => 'thumbnail',
                                'btn_label' => __('Upload Thumbnail'),
                                'image' => isset($prize) ? $prize->mediaUrl('thumb') : asset('images/default/600x400.png'),
                            ])
                        </div>
                        <div class="form-group mb-2 mb-sm-3">
                            <label for="name">Prize Name <span class="text-danger">*</span></label>
                            {{
                                Form::text(
                                    "name",
                                    null,
                                    ["class" => "form-control", "placeholder" => "Prize name", 'id' => 'value']
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
                                        isset($prize) ? null : true,
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
                                <a id="btn-cancel" href="{{ route('prizes.index') }}" class="btn btn-danger waves-effect waves-light btn-block">
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
                        @include('prize.partials.filter-form')
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 14px;"></th>
                                <th style="width: 20px;">#</th>
                                <th style="width: 120px">Thumbnail</th>
                                <th>Prize Name</th>
                                <th>Status</th>
                                <th style="width: 125px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="sortable" data-url="{{ route('prizes.update-order') }}">
                            @if ($prizes->count())
                                @foreach ($prizes as $index => $item)
                                <tr id="item_{{ $item->id }}" style="height: 90px">
                                    <td><span><i class="fa fa-arrows-alt-v handler" style="cursor:pointer"></i></span></td>
                                    <td class="no">{{ $loop->iteration }}</td>
                                    <td>
                                        <img style="width:100px" class="img-thumbnail img-fit-cover" src="{{ $item->mediaUrl('thumb') }}" alt="{{ $item->name }}">
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{!! $item->statusBadge !!}</td>
                                    <td>
                                        @include('components.table-action', [
                                            'edit_route' => route('prizes.edit', $item),
                                            'delete_route' => route('prizes.destroy', $item)
                                        ])
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr class="text-center">
                                    <td colspan="5">@lang('No data')</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>

                @include('components.pagination', ['models' => $prizes])
            </div>
        </div>
    </div>
</div>

@endsection


@push('js')
    <script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    @if (isset($prize))
        {!! JsValidator::formRequest('App\Http\Requests\Prize\UpdateRequest', '#prize-form') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\Prize\CreateRequest', '#prize-form') !!}
    @endif

    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <script src="{{ url('admin/js/custom/sortable.js') }}"></script>
@endpush
