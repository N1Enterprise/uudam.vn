<script>
    var __IMAGE_MANAGER__ = {
        toUrl: async (file) => {
            return file ? await __IMAGE_MANAGER__.toBase64(file) : '';
        },
        toBase64: (file) => {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = () => resolve(reader.result);
                reader.onerror = reject;
            });
        },
        reviewImage: (src, ref, index) => {
            $(`[data-image-ref-review-wapper="${ref}"][data-image-ref-index="${index}"]`).toggleClass('d-none', !src);
            $(`[data-image-ref-review-img="${ref}"][data-image-ref-index="${index}"]`).attr('src', src ? src : '');
        },
        reviewFileOn: async (file, ref, index) => {
            const imageUrl = await __IMAGE_MANAGER__.toUrl(file);

            $(`[data-image-ref-wapper="${ref}"][data-image-ref-index="${index}"]`).toggleClass('d-none', !imageUrl);
            $(`[data-image-ref-img="${ref}"][data-image-ref-index="${index}"]`).attr('src', imageUrl ? imageUrl : '');
            $(`[data-image-ref-path="${ref}"][data-image-ref-index="${index}"]`).val('');

            __IMAGE_MANAGER__.reviewImage(imageUrl, ref, index);
        },
        reviewPathOn: (path, ref, index) => {
            __IMAGE_MANAGER__.reviewImage(path, ref, index);
            $(`[data-image-ref-file="${ref}"][data-image-ref-index="${index}"]`).val('');
        },

        deleteRef: (ref, index) => {
            __IMAGE_MANAGER__.reviewFileOn(null, ref, index);
        },
    };

    var FORM_PRIMARY_IMAGE_FILE = {
        element: $('[name="image[file]"]'),
        elemen_del: $('[data-image-ref-delete="primary"]'),

        onChange: () => {
            FORM_PRIMARY_IMAGE_FILE.element.on('change', async function() {
                __IMAGE_MANAGER__.reviewFileOn($(this)[0].files[0], 'primary', 0);
            });
        },
        onDelete: () => {
            FORM_PRIMARY_IMAGE_FILE.elemen_del.on('click', function() {
                __IMAGE_MANAGER__.deleteRef('primary', 0);
            });
        },
    };

    var FORM_PRIMARY_IMAGE_PATH = {
        element: $('[name="image[path]"]'),
        onChange: () => {
            FORM_PRIMARY_IMAGE_PATH.element.on('change', function() {
                __IMAGE_MANAGER__.reviewPathOn($(this).val(), 'primary', 0);
            });
        },
        triggerChange: () => {
            $(document).ready(function() {
                FORM_PRIMARY_IMAGE_PATH.element.trigger('change');
            });
        },
        onDelete: () => {},
    };

    var FORM_MASTER = {
        init: () => {
            FORM_MASTER.onChange();
        },
        onChange: () => {
            FORM_PRIMARY_IMAGE_FILE.onChange();
            FORM_PRIMARY_IMAGE_PATH.onChange();

            FORM_PRIMARY_IMAGE_FILE.onDelete();
            FORM_PRIMARY_IMAGE_PATH.onDelete();
        },
    };

    $(document).ready(function() {
        FORM_MASTER.init();
    });
</script>
