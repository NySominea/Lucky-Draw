@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                @include('components.page-breadcrumb', [
                    'breadcrumbs' => [
                        ['title' => 'Dashboard', 'route' => route('dashboard')],
                        ['title' => __('Drawing Round')]
                    ]
                ])
            </div>
            <h4 class="page-title">{{ __('Drawing Round') }}</h4>
        </div>
    </div>
</div>

@include('components.success-toast')
@include('components.error-toast')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header font-weight-bold">
                <div class="row">
                    <div class="col-md-9">
                        <h4 class="text-success">Active Drawing Round</h4>
                    </div>
                    <div class="col-md-3">
                        <div class="text-md-right">
                            <a href="{{ route('draws.create') }}" class="btn btn-danger waves-effect waves-light">
                                <i class="mdi mdi-plus-circle mr-1"></i> @lang('Add New')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 20px;">#</th>
                                <th>Round #</th>
                                <th>Prizes Qty</th>
                                <th>Start At</th>
                                <th>Created At</th>
                                <th style="width: 125px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($activeDraws->count())
                                @foreach ($activeDraws as $index => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('draws.edit', $item) }}">{{ $item->round_number }}</a>
                                        @if (isset($draw) && $item->round_number === $draw->round_number)
                                            <span class="badge badge-success">Current Round</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->prizes->sum('pivot.qty') }}</td>
                                    <td>{{ $item->start_at }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        @if (!$item->start_at)
                                        @include('components.table-action', [
                                            'edit_route' => route('draws.edit', $item),
                                            'delete_route' => route('draws.destroy', $item)
                                        ])
                                        @else
                                        <span class="badge badge-warning">In Progress</span>
                                        @endif
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
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header font-weight-bold">
                <div class="row">
                    <div class="col-md-9">
                        <h4 class="text-danger">History Drawing Round</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 20px;">#</th>
                                <th>Round #</th>
                                <th>Prizes Qty</th>
                                <th>Start At</th>
                                <th>End At</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($historyDraws->count())
                                @foreach ($historyDraws as $index => $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->round_number }}</td>
                                    <td>{{ $item->prizes->sum('pivot.qty') }}</td>
                                    <td>{{ $item->start_at }}</td>
                                    <td>{{ $item->end_at }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td></td>
                                </tr>
                                @endforeach
                            @else
                                    <tr class="text-center">
                                        <td colspan="7">@lang('No data')</td>
                                    </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
