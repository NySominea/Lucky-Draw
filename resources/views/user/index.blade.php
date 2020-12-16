@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                @include('components.page-breadcrumb', [
                    'breadcrumbs' => [
                        ['title' => 'Dashboard', 'route' => route('dashboard')],
                        ['title' => __('Administrative Users')]
                    ]
                ])
            </div>
            <h4 class="page-title">{{ __('Administrative Users') }}</h4>
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
                        @include('user.partials.filter-form')
                    </div>
                    <div class="col-md-3">
                        <div class="text-md-right">
                            <a href="{{ route('users.create') }}" class="btn btn-danger waves-effect waves-light">
                                <i class="mdi mdi-plus-circle mr-1"></i> @lang('Add New')
                            </a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 20px;">#</th>
                                <th>Avatar</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th style="width: 125px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users->count())
                                @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ ($users->perPage() * ($users->currentPage() - 1)) + $index + 1 }}</td>
                                    <td>
                                        <img class="avatar-sm rounded-circle img-fit-cover" src="{{ $user->avatar ?: asset('images/avatar.png') }}" alt="{{ $user->name }}">
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->roles->count())
                                            <span class="badge badge-success" style="font-size:12px;">{{ $user->roles[0]->name }}</span></td>
                                        @endif
                                    <td>{!! $user->statusBadge !!}</td>
                                    <td>
                                        @include('components.table-action', [
                                            'edit_route' => route('users.edit', $user),
                                            'delete_route' => route('users.destroy', $user)
                                        ])
                                    </td>
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

                @include('components.pagination', ['models' => $users])
            </div>
        </div>
    </div>
</div>

@endsection
