<script>
    var FORM_DESKTOP_IMAGE_FILE = {
        element: $('[name="desktop_image[file]"]'),
        elemen_del: $('[data-image-ref-delete="desktop"]'),

        onChange: () => {
            FORM_DESKTOP_IMAGE_FILE.element.on('change', async function() {
                __IMAGE_MANAGER__.reviewFileOn($(this)[0].files[0], 'desktop', 0);
            });
        },
        onDelete: () => {
            FORM_DESKTOP_IMAGE_FILE.elemen_del.on('click', function() {
                __IMAGE_MANAGER__.deleteRef('desktop', 0);
            });
        },
    };

    var FORM_DESKTOP_IMAGE_PATH = {
        element: $('[name="desktop_image[path]"]'),
        onChange: () => {
            FORM_DESKTOP_IMAGE_PATH.element.on('change', function() {
                __IMAGE_MANAGER__.reviewPathOn($(this).val(), 'desktop', 0);
            });
        },
        triggerChange: () => {
            $(document).ready(function() {
                FORM_DESKTOP_IMAGE_PATH.element.trigger('change');
            });
        },
        onDelete: () => {},
    };

    var FORM_MOBILE_IMAGE_FILE = {
        element: $('[name="mobile_image[file]"]'),
        elemen_del: $('[data-image-ref-delete="mobile"]'),

        onChange: () => {
            FORM_MOBILE_IMAGE_FILE.element.on('change', async function() {
                __IMAGE_MANAGER__.reviewFileOn($(this)[0].files[0], 'mobile', 0);
            });
        },
        onDelete: () => {
            FORM_MOBILE_IMAGE_FILE.elemen_del.on('click', function() {
                __IMAGE_MANAGER__.deleteRef('mobile', 0);
            });
        },
    };

    var FORM_MOBILE_IMAGE_PATH = {
        element: $('[name="mobile_image[path]"]'),
        onChange: () => {
            FORM_MOBILE_IMAGE_PATH.element.on('change', function() {
                __IMAGE_MANAGER__.reviewPathOn($(this).val(), 'mobile', 0);
            });
        },
        triggerChange: () => {
            $(document).ready(function() {
                FORM_MOBILE_IMAGE_PATH.element.trigger('change');
            });
        },
        onDelete: () => {},
    };

    var FORM_MASTER = {
        init: () => {
            FORM_MASTER.onChange();
        },
        onChange: () => {
            FORM_DESKTOP_IMAGE_FILE.onChange();
            FORM_DESKTOP_IMAGE_PATH.onChange();
            FORM_DESKTOP_IMAGE_FILE.onDelete();
            FORM_DESKTOP_IMAGE_PATH.onDelete();

            FORM_MOBILE_IMAGE_FILE.onChange();
            FORM_MOBILE_IMAGE_PATH.onChange();
            FORM_MOBILE_IMAGE_FILE.onDelete();
            FORM_MOBILE_IMAGE_PATH.onDelete();
        },
    };

    $(document).ready(function() {
        FORM_MASTER.init();
    });
</script>
