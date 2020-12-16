@push('css')
    <link href="{{ asset('admin/libs/summernote/summernote-bs4.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

{!! Form::textarea($name, $value, ['class' => 'summernote', 'data-height' => isset($height) ? $height : '230']) !!}

@push('js')
    <script src="{{ asset('admin/libs/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $('.summernote').summernote({
            placeholder: "Write here...",
            height: $('.summernote').data('height'),
            callbacks: {
                onInit: function(e) {
                    $(e.editor)
                        .find(".custom-control-description")
                        .addClass("custom-control-label")
                        .parent()
                        .removeAttr("for");
                },
                onImageUpload: function(files, editor, welEditable) {
                    var _this = $(this)
                    formData = new FormData();
                    formData.append("file", files[0]);
                    formData.append("_token", $("input[name='_token']").val());
                    $.ajax({
                        data: formData,
                        type: "POST",
                        url: '{{ route("image.summernote.upload") }}',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            _this.summernote('insertImage', response.path);
                        }
                    });
                }
            }
        });
    </script>
@endpush
