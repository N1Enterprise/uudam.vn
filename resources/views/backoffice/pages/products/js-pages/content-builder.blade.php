<script src="{{ asset('backoffice/assets/vendors/general/editorjs-parser/build/Parser.browser.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/editorjs/plugins/embed/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/editorjs/plugins/table/dist/table.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/editorjs/plugins/list/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/editorjs/plugins/paragraph/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/editorjs/plugins/warning/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/editorjs/plugins/code/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/editorjs/plugins/link/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/editorjs/plugins/raw/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/editorjs/plugins/header/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/editorjs/plugins/quote/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/editorjs/plugins/marker/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/editorjs/plugins/checklist/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/editorjs/plugins/delimiter/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/editorjs/plugins/inline-code/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/editorjs/plugins/simple-image/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/editorjs/plugins/image/dist/bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/general/editorjs/dist/editorjs.umd.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/assets/vendors/custom/bootstrap3-editable/js/bootstrap-editable.js') }}" type="text/javascript"></script>

<script>
    const MESSAGE_CONTENT_BUILDER_TYPE = {
        BLOCK_EDITOR: 'block_editor',
    }

    const EDITORJS_TOOLS = {
        embed: Embed,
        // image: SimpleImage,
        image: {
            class: SimpleImage,
            config: {
                endpoints: {
                    byFile: 'http://localhost:8008/uploadFile', // Your backend file uploader endpoint
                    byUrl: 'http://localhost:8008/fetchUrl', // Your endpoint that provides uploading by Url
                }
            }
        },
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

    console.log({ EDITORJS_TOOLS });

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
                PLUGIN_BUILDER.appendTo(content);
            });
        },
        setValue: (content) => {
            PLUGIN_BUILDER_EDITORJS.plugin.isReady
                .then(function() {
                    content?.blocks?.length
                        ? PLUGIN_BUILDER_EDITORJS.plugin.render(content)
                        : PLUGIN_BUILDER_EDITORJS.plugin.clear();

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
        },
        appendTo: (content) => {
            $(`[data-builder-ref="form_builder_dom"]`).val(PLUGIN_BUILDER_EDITORJS.toRawContent(content));
        },
    };

    var PLUGIN_BUILDER = {
        plugin: null,
        value: {},
        builder_type: null,
        builder: null,
        build: (builder, plugin) => {
            PLUGIN_BUILDER.builder = builder;
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
            PLUGIN_BUILDER.plugin.setValue(value);
        },

        appendTo: (content) => {
            PLUGIN_BUILDER.plugin.appendTo(content);
        },
    }
</script>
