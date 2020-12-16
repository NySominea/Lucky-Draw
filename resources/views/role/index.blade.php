@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                @include('components.page-breadcrumb', [
                    'breadcrumbs' => [
                        ['title' => 'Dashboard', 'route' => route('dashboard')],
                        ['title' => __('Administrative Roles')]
                    ]
                ])
            </div>
            <h4 class="page-title">{{ __('Administrative Roles') }}</h4>
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
                    <div class="col-md-9">
                        @include('role.partials.filter-form')
                    </div>
                    <div class="col-md-3">
                        <div class="text-md-right">
                            <a href="{{ route('roles.create') }}" class="btn btn-danger waves-effect waves-light">
                                <i class="mdi mdi-plus-circle mr-1"></i> @lang('Add New')
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 20px;">#</th>
                                <th>Name</th>
                                <th style="min-width:400px; width: 60%">Permissions</th>
                                <th style="width: 125px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($roles->count())
                                @foreach ($roles as $index => $role)
                                <tr>
                                    <td>{{ ($roles->perPage() * ($roles->currentPage() - 1)) + $index + 1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @foreach ($role->permissions->pluck('name') as $name)
                                            <span class="badge badge-success" style="font-size: 12px;"> {{ $name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @include('components.table-action', [
                                            'edit_route' => route('roles.edit', $role),
                                            'delete_route' => route('roles.destroy', $role)
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

                @include('components.pagination', ['models' => $roles])
            </div>
        </div>
    </div>
</div>

@endsection
