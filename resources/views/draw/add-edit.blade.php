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
                        ['title' => __('Drawing Round'), 'route' => route('draws.index')],
                        ['title' => isset($draw) ? __('Edit') : 'Add New'],
                    ]
                ])
            </div>
            <h4 class="page-title">Set Up Drawing Round</h4>
        </div>
    </div>
</div>

@include('components.success-toast')
@include('components.error-toast')

@if(isset($draw))
{{ Form::model($draw,['route' => ['draws.update',$draw->id], 'method' => 'PUT', 'id' => 'draw-form', 'files' => true]) }}
@else
{{ Form::open(['route' => 'draws.store', 'method' => 'POST', 'id' => 'draw-form', 'files' => true]) }}
@endif
@csrf
    <div class="row">
        <div class="col-md-5 col-lg-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    {{ isset($draw) ? 'Edit Drawing Round' : __('Add New Drawing') }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="pb-3">
                                @include('components.single-dropzone', [
                                    'width' => '200',
                                    'height' => '100',
                                    'name' => 'thumbnail',
                                    'btn_label' => __('Upload Thumbnail'),
                                    'image' => isset($draw) ? $draw->mediaUrl('thumb') : asset('images/default/600x400.png'),
                                ])
                            </div>
                            <div class="form-group mb-2 mb-sm-3">
                                <label for="name">Round Number <span class="text-danger">*</span></label>
                                {{
                                    Form::text(
                                        "round_number",
                                        isset($draw) ? null : $roundNumber,
                                        ["class" => "form-control", "placeholder" => "Round #", 'id' => 'round_number', 'readonly']
                                    )
                                }}
                            </div>
                            <div class="form-group justify-content-end text-center">
                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                    <i class="mdi mdi-content-save mr-1"></i> {{ __('Save') }}
                                </button>
                                <a id="btn-cancel" href="{{ route('draws.index') }}" class="btn btn-danger waves-effect waves-light">
                                    <i class="mdi mdi-cancel mr-1"></i>@lang('Cancel')
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-7 col-lg-8">
            @if (isset($draw))
                @if (request()->setup)
                <div class="card">
                    <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                        Set Up Prizes
                    </div>
                    <div class="card-body" style="height: calc(100vh - 360px); overflow: scroll;">
                        <div class="row">
                            <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-centered mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="width: 60%">Prize Name</th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($drawPrizes))
                                            @foreach ($drawPrizes as $i => $prize)
                                                <tr>
                                                    <td>{{ $i + 1 }}</td>
                                                    <td>
                                                        <select name="prizes[{{$i}}][id]" class="form-control form-control-sm">
                                                            <option value="">Choose a prize</option>
                                                            @foreach ($prizes as $item)
                                                                <option value="{{ $item->id }}" {{ $item->id === $prize->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="number" name='prizes[{{$i}}][qty]' class="form-control form-control-sm" value="{{ $prize->pivot->qty }}"></td>
                                                </tr>
                                            @endforeach
                                            @for ($i=count($drawPrizes); $i<10; $i++)
                                                <tr>
                                                    <td>{{ $i + 1 }}</td>
                                                    <td>
                                                        <select name="prizes[{{$i}}][id]" class="form-control form-control-sm">
                                                            <option value="">Choose a prize</option>
                                                            @foreach ($prizes as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="number" name='prizes[{{$i}}][qty]' class="form-control form-control-sm" min="0" value="0"></td>
                                                </tr>
                                            @endfor
                                        @else
                                            @for ($i=0; $i<10; $i++)
                                                <tr>
                                                    <td>{{ $i+1 }}</td>
                                                    <td>
                                                        <select name="prizes[{{$i}}][id]" class="form-control form-control-sm">
                                                            <option value="">Choose a prize</option>
                                                            @foreach ($prizes as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="number" name='prizes[{{$i}}][qty]' class="form-control form-control-sm" min="0" value="0"></td>
                                                </tr>
                                            @endfor
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">
                                        <i class="mdi mdi-content-save mr-1"></i> {{ __('Save') }}
                                    </button>
                                    <a id="btn-cancel" href="{{ route('draws.edit', $draw->id) }}" class="btn btn-danger waves-effect waves-light">
                                        <i class="mdi mdi-cancel mr-1"></i>@lang('Cancel')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="card">
                    <div class="card-header font-weight-bold d-flex justify-content-between align-items-center py-2">
                        Set Up Prizes
                        @if (!$draw->start_at)
                        <a href="{{ route('draws.edit', $draw->id) }}?setup=true" class="btn btn-danger waves-effect waves-light btn-sm">
                            <i class="mdi mdi-wrench mr-1"></i>@lang('Set Up')
                        </a>
                        @endif
                    </div>
                    <div class="card-body" style="height: calc(100vh - 280px); overflow: scroll;">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-centered mb-0">
                                        <thead>
                                            <tr>
                                                <th style="width: 14px"></th>
                                                <th class="text-center">#</th>
                                                <th style="width: 120px">Thumbnail</th>
                                                <th>Prize Name</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">Available Qty</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sortable" data-url="{{ route('draws.prizes.update-order', $draw->id) }}">
                                            @if (isset($drawPrizes))
                                                @foreach ($drawPrizes as $i => $prize)
                                                    <tr id="item_{{ $prize->id }}" style="height: 90px">
                                                        <td>
                                                            @if (!$draw->start_at)
                                                            <span><i class="fa fa-arrows-alt-v handler" style="cursor:pointer"></i></span>
                                                            @endif
                                                        </td>
                                                        <td class="no text-center">{{ $loop->iteration }}</td>
                                                        <td>
                                                            <img style="width:100px" class="img-thumbnail img-fit-cover" src="{{ $prize->mediaUrl('thumb') }}" alt="{{ $prize->name }}">
                                                        </td>
                                                        <td>{{ $prize->name }}</td>
                                                        <td class="text-center">{{ $prize->pivot->qty }}</td>
                                                        <td class="text-center">{{ $prize->pivot->available_qty }}</td>
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
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>
{{ Form::close() }}

@endsection

@push('js')
    <script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    @if (isset($draw))
        {!! JsValidator::formRequest('App\Http\Requests\Draw\UpdateRequest', '#draw-form') !!}
    @else
        {!! JsValidator::formRequest('App\Http\Requests\Draw\CreateRequest', '#draw-form') !!}
    @endif

    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <script src="{{ url('admin/js/custom/sortable.js') }}"></script>
@endpush
