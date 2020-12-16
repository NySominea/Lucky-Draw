<ol class="breadcrumb m-0">
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" target="_BLANK">{{ config('app.name') }}</a></li>

    @if (isset($breadcrumbs))
        @foreach ($breadcrumbs as $crumb)
            @if (isset($crumb['route']))
            <li class="breadcrumb-item"><a href="{{ $crumb['route'] }}">{{ $crumb['title'] }}</a></li>
            @else
            <li class="breadcrumb-item active">{{ $crumb['title'] }}</li>
            @endif
        @endforeach
    @endif
</ol>
