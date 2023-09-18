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
            $(`[data-image-ref-review-wapper="${ref}"][data-image-ref-review-index="${index}"]`).toggleClass('d-none', !src);
            $(`[data-image-ref-review-img="${ref}"][data-image-ref-review-index="${index}"]`).attr('src', src ? src : '');
        },
        reviewFileOn: async (file, ref, index) => {
            const imageUrl = await __IMAGE_MANAGER__.toUrl(file);

            $(`[data-image-ref-wapper="${ref}"][data-image-ref-index="${index}"]`).toggleClass('d-none', !imageUrl);
            $(`[data-image-ref-img="${ref}"][data-image-ref-index="${index}"]`).attr('src', imageUrl ? imageUrl : '');

            __IMAGE_MANAGER__.reviewImage(imageUrl, ref, index);
        },
        reviewPathOn: (path, ref, index) => {
            __IMAGE_MANAGER__.reviewImage(path, ref, index);
        },
    };

    var FORM_SLUG = {
        element: '',
        onChange: () => {

        },
    };

    var FORM_PRIMARY_IMAGE_FILE = {
        element: $('[name="image_primary_image_file"]'),
        onChange: () => {
            FORM_PRIMARY_IMAGE_FILE.element.on('change', async function() {
                __IMAGE_MANAGER__.reviewFileOn($(this)[0].files[0], 'primary', 0);
            });
        },
    };

    var FORM_PRIMARY_IMAGE_PATH = {
        element: $('[name="image_primary_image_path"]'),
        onChange: () => {
            FORM_PRIMARY_IMAGE_PATH.element.on('change', function() {
                __IMAGE_MANAGER__.reviewPathOn($(this).val(), 'primary', 0);
            });
        },
    };

    var FORM_MEDIA = {
        element_list: '',
        onChange: () => {},
    };

    var FORM_MASTER = {
        init: () => {
            FORM_MASTER.onChange();
        },
        onChange: () => {
            FORM_PRIMARY_IMAGE_FILE.onChange();
            FORM_PRIMARY_IMAGE_PATH.onChange();
        },
    };

    FORM_MASTER.init();
</script>
