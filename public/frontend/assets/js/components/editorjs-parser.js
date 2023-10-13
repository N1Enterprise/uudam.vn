const EDITORJS_PARSER = {
    elements: $('.editorjs-parser'),

    init: () => {
        $.each(EDITORJS_PARSER.elements, function(_, element) {
            const content = JSON.parse($(element).attr('data-editorjs-content') || '{}');

            const parser = new edjsParser();

            const htmlContent = parser.parse(content);

            $(this).html(htmlContent);
        });
    },

    parse: () => {},
};

EDITORJS_PARSER.init();
