<div class="content-editor">
    <label for="{{ $id }}">{{ $label }}</label>
    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        cols="{{ $cols }}"
        rows="{{ $rows }}"
        data-disk="{{ $disk }}"
        placeholder="{{ $placeholder }}"
        class="summernote {{ $class }} d-none"
    >{!! nl2br($value) !!}</textarea>
</div>

@push('style_pages')
<style>
.note-editor.note-frame .note-editing-area .note-editable {
    padding: 20px 10px!important;
}
</style>
@endpush

@push('js_pages')
<script>
    const config = @json($config);

    const element = $('.summernote');

    const instance = element.summernote({
        height: 300,
        ...config,
        callbacks: {
            onImageUpload: (files) => {
                uploadFiles(files, function({ index, data }) {
                    const { path, id } = data;
                    const image = $('<img data-image="__image__'+id+'__">').attr('src', path);

                    element.summernote("insertNode", image[0]);
                });
            },
        }
    });

    async function uploadFiles(fields, callback = () => undefined) {
        const formData = new FormData();

        const disk = $("#{{ $id }}").attr('data-disk');

        const requests = [];
        const listPaths = [];

        for (let index = 0; index < fields.length; index++) {
            formData.append('file', fields[index]);
            formData.append('disk', disk);

            $.ajax({
                url: "{{ route('bo.web.file-manager.upload') }}",
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    callback({ index, data: response });
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                },
            });
        }
    }
</script>
@endpush
