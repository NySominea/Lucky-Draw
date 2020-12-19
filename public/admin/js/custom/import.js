$('#btn-open-import-modal').click(function() {
    $("#import-modal").modal({
        backdrop: 'static',
        keyboard: false
    });
})

if ($("#import-modal").length) {

    const form = $("#import-modal").find('#form')
    const file = $('#file')
    const memberType = $('#member-type')
    const btnSubmit = $("#import-modal").find('#btn-submit')
    const btnClose = $("#import-modal").find('#btn-close')
    const loadingIndicator = $("#import-modal").find('#loading-indicator')
    const messageSelector = $('#message')

    file.change(function() {
        messageSelector.html('')
    })

    memberType.change(function() {
        messageSelector.html('')
    })

    btnSubmit.click(function() {
        if (!file[0].files.length || (memberType.lenght && !memberType.val())) {
            messageSelector.removeClass('text-warning text-success').addClass('text-danger').html('Please upload the correct file')
            return
        }
        btnClose.addClass('disabled')
        btnSubmit.addClass('disabled')
        file.attr('disabled', 'disabled')
        memberType.attr('disabled', 'disabled')
        loadingIndicator.removeClass('d-none')
        messageSelector.removeClass('text-danger text-success').addClass('text-warning').html('In progress! Please wait')

        const formData = new FormData();
        formData.append("member_type", memberType.val());
        $.each(file[0].files, function(i, file) {
            formData.append("files[]", file);
        });

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.success) {
                    messageSelector.removeClass('text-danger text-warning')
                        .addClass('text-success')
                        .html('Progress Completed!')
                    file.val(null)
                    memberType.val(null)
                    location.reload();
                } else {
                    $msg = 'Progress Failed! Please try again';
                    if (data.file_exists) $msg = 'Progress Completed!';
                    messageSelector.removeClass('text-success text-warning')
                        .addClass('text-danger')
                        .html($msg)
                }
            },
            error: function () {
                messageSelector.removeClass('text-success text-warning')
                    .addClass('text-danger')
                    .html('Progress Failed! Please try again')
            },
            complete: function () {
                btnClose.removeClass('disabled')
                btnSubmit.removeClass('disabled')
                file.removeAttr('disabled')
                memberType.removeAttr('disabled')
                loadingIndicator.addClass('d-none')
            }
        })
    })
}

