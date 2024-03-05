<script>
    var FORM_PRIMARY_IMAGE_FILE = {
        element: $('[name="logo[file]"]'),
        elemen_del: $('[data-image-ref-delete="logo"]'),

        onChange: () => {
            FORM_PRIMARY_IMAGE_FILE.element.on('change', async function() {
                __IMAGE_MANAGER__.reviewFileOn($(this)[0].files[0], 'logo', 0);
            });
        },
        onDelete: () => {
            FORM_PRIMARY_IMAGE_FILE.elemen_del.on('click', function() {
                __IMAGE_MANAGER__.deleteRef('logo', 0);
            });
        },
    };

    var FORM_LOGO_IMAGE_PATH = {
        element: $('[name="logo[path]"]'),
        onChange: () => {
            FORM_LOGO_IMAGE_PATH.element.on('change', function() {
                __IMAGE_MANAGER__.reviewPathOn($(this).val(), 'logo', 0);
            });
        },
        triggerChange: () => {
            $(document).ready(function() {
                FORM_LOGO_IMAGE_PATH.element.trigger('change');
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
            FORM_LOGO_IMAGE_PATH.onChange();
            FORM_PRIMARY_IMAGE_FILE.onDelete();
            FORM_LOGO_IMAGE_PATH.onDelete();
        },
    };

    $(document).ready(function() {
        FORM_MASTER.init();
        FORM_LOGO_IMAGE_PATH.triggerChange();
    });
</script>