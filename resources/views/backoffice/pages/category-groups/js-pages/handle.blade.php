<script>
    var FORM_SLUG = {
        element: $('#form_pages').find('[name="slug"]'),
        onChange: () => {

        },
        fillSlugFromName: (name) => {
            let nameValSlugify = name?.trim()?.toLowerCase()?.replace(/[^\w-]+/g, '-');
            FORM_SLUG.element.val(nameValSlugify);
        },
    };

    var FORM_NAME = {
        element: $('#form_pages').find('[name="name"]'),
        onChange: () => {
            FORM_NAME.element.on('change', function() {
                const name = $(this).val();

                FORM_SLUG.fillSlugFromName(name);
            });
        },
    };

    var FORM_DESCRIPTION = {
        element: $('#form_pages').find('[name="description"]'),
        setup: () => {
            FORM_DESCRIPTION.onChange();
            FORM_DESCRIPTION.pluginBuilderSetup();
        },
        onChange: () => {
            PLUGIN_BUILDER.build('block_editor', 'editorjs');
        },

        pluginBuilderSetup: () => {
            const content = JSON.parse(FORM_DESCRIPTION.element.val() || '{}');

            PLUGIN_BUILDER.setValue(content);
        },
    };

    var FORM_MASTER = {
        init: () => {
            FORM_MASTER.onChange();
            FORM_DESCRIPTION.setup();
        },
        onChange: () => {
            FORM_NAME.onChange();
        },
    };

    $(document).ready(function() {
        FORM_MASTER.init();
    });
</script>
