@push('css')
    <link href="{{ asset('admin/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        #{{ $name }}__dropzone_container.dropzone {
            margin: auto;
            padding: 20px;
            cursor: auto;
            width: calc(@php echo $width.'px' @endphp + 40px) !important;
            @if (isset($height))
            height: calc(@php echo $height.'px' @endphp + 40px) !important;
            @else
            height: auto !important;
            @endif
        }
        .dropzone .dz-preview {
            margin: 0px;
            display: flex;
            align-items: center;
        }
        #{{ $name }}__dropzone_container.dropzone .dz-preview .dz-image {
            border-radius: 5px;
            width: @php echo $width.'px' @endphp !important;
            height: @php echo isset($height) ? $height.'px' : 'auto' @endphp !important;
        }
        .dropzone .dz-preview:hover .dz-image img {
            filter: none !important;
        }
        .dropzone .dz-preview .dz-image img{
            width:100%;
            height: 100%;
            object-fit: cover;
            filter: blur(0px);
        }
        .dropzone .dz-preview .dz-error-message {
            width: calc(100% - 10px);
            left: 5px;
        }
        .dropzone .dz-preview .dz-details .dz-size,
        .dropzone .dz-preview .dz-details .dz-filename{
            display: none;
        }

        #{{ $name }}__dropzone_container #btn-browse-file__{{ $name }} {
            max-width: calc(@php echo $width.'px' @endphp + 40px) !important;
            margin: auto;
        }
    </style>
@endpush

<div class="dropzone"
    id="{{ $name }}__dropzone_container"
    data-width="{{ $width }}"
    data-height="{{ isset($height) ? $height : '' }}"
    action="{{ route('image.single.upload') }}"
    data-image="{{ isset($image) ? $image : '' }}"
>
    @csrf
    <input name="{{ $name }}" id="{{ $name }}" hidden />
</div>
<button type="button" id="btn-browse-file__{{ $name }}" class="btn btn-block btn-danger mt-1">{{ isset($btn_label) ? $btn_label : __('Upload Image') }}</button>


@push('js')
    <script src="{{ asset('admin/libs/dropzone/min/dropzone.min.js') }}" ></script>
    <script>
        Dropzone.autoDiscover = false;

        init($(`#{{ $name }}__dropzone_container`))

        function init(myDropzone){
            myDropzone.dropzone({
                maxFiles: 1,
                maxFilesize: 2,
                uploadMultiple: false,
                acceptedFiles: "image/*",
                clickable: `#btn-browse-file__{{ $name }}`,
                thumbnailWidth: myDropzone.data('width'),
                thumbnailHeight: myDropzone.data('height'),
                init: function(){
                    var thisDropzone = this;

                    var url  = myDropzone.data('image');
                    var mockFile = { accepted: true };

                    thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                    thisDropzone.options.thumbnail.call(thisDropzone, mockFile, url);
                    thisDropzone.files.push(mockFile);
                    thisDropzone.emit("complete", mockFile);
                    thisDropzone.options.maxFiles = thisDropzone.options.maxFiles;
                    thisDropzone._updateMaxFilesReachedClass();

                    this.on('sending', function(file, xhr, formData){
                        formData.append("_token", $("input[name='_token']").val());
                        formData.append("_method", "POST");

                    })

                    this.on("success", function(file, response){
                        $('input#{{ $name }}').val(response.path);
                    }),

                    this.on("addedfile", function(event) {
                        thisDropzone.removeFile(thisDropzone.files[0]);
                    });
                }
            })
        }
    </script>
@endpush
