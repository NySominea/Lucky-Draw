@push('css')
    <link href="{{ asset('admin/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@if (isset($edit_route))
<a href="{{ $edit_route }}"
    class="action-icon text-warning"
    data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Edit"
>
    <i class="mdi mdi-square-edit-outline"></i>
</a>
@endif

@if (isset($delete_route))
<a href="javascript:void(0);" class="action-icon delete text-danger"
    data-route="{{ $delete_route }}"
    data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Delete"
>
    <i class="mdi mdi-delete"></i>
</a>
@endif

@push('js')
    <script src="{{ asset('admin/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if($('.delete').length > 0){
                $('.delete').click(function(){
                    deleteRecord($(this).data('route'));
                });
            }

            var deleteRecord = function(route){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    allowOutsideClick: () => !Swal.isLoading(),
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    preConfirm: (value) => {
                        form = createForm(route);
                        form.submit();
                        return new Promise(function(resolve, reject) {
                            setTimeout(function(){
                                resolve()
                            }, 2000)
                        })
                    },
                }).then((result) => {

                });
            }


            var createForm = function(route) {
                var form =
                    $('<form>', {
                        'method': 'POST',
                        'action': route
                    });

                var token =
                    $('<input>', {
                        'name': '_token',
                        'type': 'hidden',
                        'value': $('meta[name="csrf-token"]').attr('content')
                    });

                var hiddenInput =
                    $('<input>', {
                        'name': '_method',
                        'type': 'hidden',
                        'value': 'DELETE'
                    });

                return form.append(token, hiddenInput)
                    .appendTo('body');
            }
        });
    </script>
@endpush
