<script>
    var FORM_SLUG = {
        element: $('#form_category_group').find('[name="slug"]'),
        onChange: () => {

        },
        fillSlugFromName: (name) => {
            let nameValSlugify = name?.trim()?.toLowerCase()?.replace(/[^\w-]+/g, '-');
            FORM_SLUG.element.val(nameValSlugify);
        },
    };

    var FORM_NAME = {
        element: $('#form_category_group').find('[name="name"]'),
        onChange: () => {
            FORM_NAME.element.on('change', function() {
                const name = $(this).val();

                FORM_SLUG.fillSlugFromName(name);
            });
        },
    };

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

    var FORM_MASTER = {
        init: () => {
            FORM_MASTER.onChange();
        },
        onChange: () => {
            FORM_PRIMARY_IMAGE_FILE.onChange();
            FORM_PRIMARY_IMAGE_PATH.onChange();

            FORM_PRIMARY_IMAGE_FILE.onDelete();
            FORM_PRIMARY_IMAGE_PATH.onDelete();

            FORM_NAME.onChange();
        },
    };

    $(document).ready(function() {
        FORM_MASTER.init();
    });
</script>
