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
