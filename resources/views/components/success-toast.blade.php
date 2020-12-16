
@push('css')
    <link href="{{ asset('admin/libs/jquery-toast-plugin/jquery.toast.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('js')
    <script src="{{ asset('admin/libs/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
    <script>
        if("{{ session()->has('success') }}") {
            $.toast({
                icon: 'success',
                position: 'top-right',
                heading: 'Well done!',
                text: "{{ session('success') }}"
            })
        }
    </script>
@endpush
