
const __HELPER__ = {
    urlParams: (key) => {
        return {
            get: (_default = '') => {
                const href = window.location.href;
                const url = new URL(href);
                return url.searchParams.get(key) || _default;
            },
            set: (value) => {
                let url = new URL(window.location.href);
                url.searchParams.set(key, value);
                window.history.replaceState({}, '', url.toString());
            },
            del: () => {
                let url = new URL(window.location.href);
                url.searchParams.delete(key);
                window.history.replaceState({}, '', url.toString());
            },
        }
    },
    copyClipBoard: (text) => {
        var $temp = $("<input>");

        if ($('.modal.show').length) {
            fscommon.unblockUI('.modal.show');
            $(".modal.show").append($temp);
            $temp.val(text).select();
            document.execCommand("copy");
            $temp.remove();
            return;
        }

        $("body").append($temp);
        $temp.val(text).select();
        document.execCommand("copy");
        $temp.remove();
    },
    formatNumber: function(number, dec_point = ',', thousands_sep = '.', decimals = 2, minDecimals = null) {
		if(!number) number = 0;
        var nstr = number.toString();
        nstr += '';
        x = nstr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? x[1] : '0';
        var rgx = /(\d+)(\d{3})/;

        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

            x2 = x2.toString().replace(/\.?0+$/, '')

            if (decimals > 0) {
                x2 = x2.slice(0, decimals)
            }

            if (minDecimals > 0) {
                x2 = x2.length < minDecimals ? x2.padEnd(minDecimals, '0') : x2;
            }

            return x1 + (! !Object.keys(x2).length ? dec_point + x2 : '');
    },
    appendErrorMessages: ($parent, errorMessages) => {
        $parent.find('.form-errors').removeClass('show');

        Object.keys(errorMessages).forEach(function(name) {
            const element = $parent.find(`.form-errors[data-name="${name}"]`);
            const messages = errorMessages[name];

            if (Array.isArray(messages) && messages.length > 0) {
                element.addClass('show');

                const htmlError = messages.map((message) => {
                    return $('<span>')
                        .addClass('form-errors__message')
                        .text(message);
                });

                element.html(htmlError);
            }
        });
    },
};
