<script>
    var FORM_PRIMARY_IMAGE_FILE = {
        element: $('[name="primary_image[file]"]'),
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
        element: $('[name="primary_image[path]"]'),
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

    var FORM_COVER_IMAGE_FILE = {
        element: $('[name="cover_image[file]"]'),
        elemen_del: $('[data-image-ref-delete="cover"]'),

        onChange: () => {
            FORM_COVER_IMAGE_FILE.element.on('change', async function() {
                __IMAGE_MANAGER__.reviewFileOn($(this)[0].files[0], 'cover', 0);
            });
        },
        onDelete: () => {
            FORM_COVER_IMAGE_FILE.elemen_del.on('click', function() {
                __IMAGE_MANAGER__.deleteRef('cover', 0);
            });
        },
    };

    var FORM_COVER_IMAGE_PATH = {
        element: $('[name="cover_image[path]"]'),
        onChange: () => {
            FORM_COVER_IMAGE_PATH.element.on('change', function() {
                __IMAGE_MANAGER__.reviewPathOn($(this).val(), 'cover', 0);
            });
        },
        triggerChange: () => {
            $(document).ready(function() {
                FORM_COVER_IMAGE_PATH.element.trigger('change');
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

            FORM_COVER_IMAGE_FILE.onChange();
            FORM_COVER_IMAGE_PATH.onChange();

            FORM_COVER_IMAGE_FILE.onDelete();
            FORM_COVER_IMAGE_PATH.onDelete();
        },
    };

    $(document).ready(function() {
        FORM_MASTER.init();

        FORM_PRIMARY_IMAGE_PATH.triggerChange();
        FORM_COVER_IMAGE_PATH.triggerChange();
    });
</script>
