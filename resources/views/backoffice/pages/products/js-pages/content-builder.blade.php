<script src="{{ asset('assets/vendors/general/editorjs-parser/build/Parser.browser.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/editorjs/plugins/embed/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/editorjs/plugins/table/dist/table.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/editorjs/plugins/list/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/editorjs/plugins/paragraph/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/editorjs/plugins/warning/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/editorjs/plugins/code/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/editorjs/plugins/link/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/editorjs/plugins/raw/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/editorjs/plugins/header/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/editorjs/plugins/quote/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/editorjs/plugins/marker/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/editorjs/plugins/checklist/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/editorjs/plugins/delimiter/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/editorjs/plugins/inline-code/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/general/editorjs/dist/editorjs.umd.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/custom/bootstrap3-editable/js/bootstrap-editable.js') }}" type="text/javascript"></script>

<script>
    // Modules\Messaging\Enum\MessageContentBuilderType
    const MESSAGE_CONTENT_BUILDER_TYPE = {
        TEXTAREA_EDITOR: 'textarea_editor',
        HTML_EDITOR: 'html_editor',
        BLOCK_EDITOR: 'block_editor',
    }

    const EDITORJS_TOOLS = {
        embed: Embed,
        table: {
            class: Table,
            inlineToolbar: true,
        },
        list: {
            class: List,
            inlineToolbar: true,
        },
        warning: Warning,
        code: CodeTool,
        linkTool: LinkTool,
        image: Image,
        raw: RawTool,
        header: {
            class: Header,
            inlineToolbar: ['marker', 'link'],
            config: {
                placeholder: 'Header'
            },
        },
        quote: {
            class: Quote,
            inlineToolbar: true,
            config: {
                quotePlaceholder: 'Enter a quote',
                captionPlaceholder: 'Quote\'s author',
            },
        },
        marker: Marker,
        checklist: {
            class: Checklist,
            inlineToolbar: true,
        },
        delimiter: Delimiter,
        inlineCode: InlineCode,
    };

    var PLUGIN_BUILDER_EDITORJS = {
        plugin: null,
        make: (builder) => {
            PLUGIN_BUILDER_EDITORJS.plugin = new EditorJS({
                holder: 'form_builder_dom',
                tools: EDITORJS_TOOLS,
                placeholder: 'Message Content',
                config: {},
                onChange: PLUGIN_BUILDER_EDITORJS.onChange,
            });

            return PLUGIN_BUILDER_EDITORJS;
        },
        onChange: (api, event) => {
            if (!api || !event) {
                return;
            }

            api?.saver?.save()?.then((content) => {
                PLUGIN_BUILDER.setValue(content);
                CONTENT_REVIEW.buildHTML(PLUGIN_BUILDER_EDITORJS.toHTML(content));
            });
        },
        setValue: (content) => {
            PLUGIN_BUILDER_EDITORJS.plugin.isReady
                .then(function() {
                    content?.blocks?.length
                        ? PLUGIN_BUILDER_EDITORJS.plugin.render(content)
                        : PLUGIN_BUILDER_EDITORJS.plugin.clear();

                    CONTENT_REVIEW.buildHTML(PLUGIN_BUILDER_EDITORJS.toHTML(content));
                });
        },
        toHTML: (content) => {
            let htmlContent = '';

            if (content) {
                const parser = new edjsParser();
                htmlContent = parser.parse(content);
            }

            return htmlContent;
        },
        toRawContent: (content) => {
            return JSON.stringify(content);
        }
    };

    var PLUGIN_BUILDER = {
        plugin: null,
        value: {},
        builder_type: null,
        language: null,
        build: (builder, plugin) => {
            switch (plugin) {
                case 'editorjs':
                    PLUGIN_BUILDER.plugin = PLUGIN_BUILDER_EDITORJS.make(builder);
                    PLUGIN_BUILDER.builder_type = MESSAGE_CONTENT_BUILDER_TYPE.BLOCK_EDITOR;
                    break;
                default:
                    break;
            }
        },

        setValue: (value) => {
            if (PLUGIN_BUILDER?.language) {
                PLUGIN_BUILDER.values[PLUGIN_BUILDER?.language] = value;
            }
        },

        setValues: (values) => {
            PLUGIN_BUILDER.values = values;
        },

        getValueFormByLanguage: (languageCode) => {
            return PLUGIN_BUILDER?.plugin?.toRawContent(PLUGIN_BUILDER.values?.[languageCode] || '');
        },

        setPlaceholder: (value) => {},

        setLanguage: (languageCode) => {
            PLUGIN_BUILDER.language = languageCode;
        },

        setPluginValueByLanguage: (languageCode, builderType = null) => {
            const pluginContent = builderType && PLUGIN_BUILDER.builder_type && builderType !== PLUGIN_BUILDER.builder_type
                ? ''
                : PLUGIN_BUILDER.values?.[languageCode] || '';

            PLUGIN_BUILDER?.plugin?.setValue(pluginContent);
        },

        getBuilderType: () => {
            return PLUGIN_BUILDER.builder_type;
        },

        setBuilderType: (type) => {
            PLUGIN_BUILDER.builder_type = type;
        },
    }

    PLUGIN_BUILDER.build('block_editor', 'editorjs');
</script>
