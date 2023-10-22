<script>
    var FORM_DESCRIPTION = {
        element: $('#form_faqs').find('[name="answer"]'),
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
        },
    };

    $(document).ready(function() {
        FORM_MASTER.init();
    });
</script>
