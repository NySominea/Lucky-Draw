$(document).ready(function() {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    
    $('#sortable').sortable({
        placeholder: "ui-state-highlight",
        handle: ".handler",
        axis: 'y',
        containment: "parent",
        cursor: "move",
        tolerance: "pointer",
        update: function (event, ui) {
            $.ajax({
                type:'POST',
                url: $(this).data('url'),
                data: $(this).sortable('serialize'),
                success:function(response){
                    if (response.success) {

                        if ($("tbody#sortable > tr").find('.no').length) {
                            $("tbody#sortable > tr").each(function (index) {
                                $(this).find('td:nth-child(2)').text(index + 1)
                            });
                        }

                        $.toast({
                            icon: 'success',
                            position: 'top-right',
                            heading: 'Well done!',
                            text: response.message
                        })
                    } else {
                        $.toast({
                            icon: 'error',
                            position: 'top-right',
                            heading: 'Oh snaps!',
                            text: response.message
                        })
                    }
                },
                error:function(xhr, status, error){
                    $.toast({
                        icon: 'error',
                        position: 'top-right',
                        heading: 'Oh snaps!',
                        text: err.message
                    })
                }
            });
        }
    });
})
