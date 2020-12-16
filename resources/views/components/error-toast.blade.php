
@push('css')
    <link href="{{ asset('admin/libs/jquery-toast-plugin/jquery.toast.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js')
    <script src="{{ asset('admin/libs/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
    <script>
        if("{{ session()->has('error') }}") {
            $.toast({
                icon: 'error',
                position: 'top-right',
                heading: 'Oh snaps!',
                text: "{!! session('error') !!}"
            })
        }
    </script>
@endpush
