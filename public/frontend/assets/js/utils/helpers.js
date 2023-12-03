
const utils_helper = {
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
    debounce: (func, within = 300, timerId = null) => {
        window.callOnceTimers = window.callOnceTimers || {};

        if (timerId == null)
            timerId = func;

        var timer = window.callOnceTimers[timerId];
        clearTimeout(timer);

        return function () {
            var context = this;
            var args = arguments;

            timer = setTimeout(() => {
                func.apply(context, args);
            }, within);

            window.callOnceTimers[timerId] = timer;
        };
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
    formatNumber: function(number, dec_point = '.', thousands_sep = ',', decimals = 2, minDecimals = null) {
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
    formatPrice: (money, symbol = 'VND') => {
        return utils_helper.formatNumber(money) + ' ' + symbol;
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
    number: (number) => {
        const _number = parseFloat(number);

        return {
            multiply: (by) => {
                return _number * parseFloat(by);
            },
            toFloat: () => {
                return parseFloat(_number);
            },
        };
    },
    swal: (options) => {
        const confirmButtonText = options?.okText || 'Xác nhận';
        const confirmButtonClass = options?.okClass || 'swal-button button-primary';
        const cancelButtonText = options?.cancelText || 'Huỷ';
        const cancelButtonClass = options?.cancelClass || 'swal-button button-secondary';
        const title = options?.title || '';
        const showConfirmButton = options?.showConfirmButton || true;

        return swal({
            confirmButtonText,
            confirmButtonClass,
            cancelButtonText,
            cancelButtonClass,
            showConfirmButton,
            showCancelButton: true,
            reverseButtons: true,
            ...options,
            title: `<span style="font-weight: 400; font-size: 16px">${title}</span>`,
        });
    },
    reload: () => {
        window.location.reload();
    }
};

const utils_quantity = (selector, config = {}) => {
    let FINAL_CONFIG = {
        msg_quantity_max: 'Số lượng vượt quá số lượng trong kho.',
        msg_quantity_min: 'Số lượng không hợp lệ.',
        ...config,
        callbacks: {
            onChange: () => {},
            onIncrease: () => {},
            onDecrease: () => {},
            ...config.callbacks
        },
    };

    const ELEMENT_INCREASE = $(`[data-quantity-increase="${selector}"]`);
    const ELEMENT_DECREASE = $(`[data-quantity-decrease="${selector}"]`);
    const ELEMENT_INPUT = $(`[data-quantity-input="${selector}"]`);

    function changeValue(value) {
        ELEMENT_INPUT.val(value);
        FINAL_CONFIG.callbacks.onChange(value);
    }

    ELEMENT_INCREASE.on('click', function() {
        const value    = +ELEMENT_INPUT.val();
        const maxValue = +ELEMENT_INPUT.attr('max');

        if (value < maxValue) {
            changeValue(value + 1);
            FINAL_CONFIG.callbacks.onIncrease(value + 1);
        }
    });

    ELEMENT_DECREASE.on('click', function() {
        const value    = +ELEMENT_INPUT.val();
        const minValue = +ELEMENT_INPUT.attr('min');

        if (value > minValue) {
            changeValue(value - 1);
            FINAL_CONFIG.callbacks.onIncrease(value - 1);
        }
    });

    ELEMENT_INPUT.on('change', function() {
        const value    = +ELEMENT_INPUT.val();
        const minValue = +ELEMENT_INPUT.attr('min');
        const maxValue = +ELEMENT_INPUT.attr('max');

        if (value > maxValue) {
            toastr.warning(FINAL_CONFIG.msg_quantity_max);
            changeValue(maxValue);
            return;
        }

        if (value < minValue) {
            toastr.warning(FINAL_CONFIG.msg_quantity_min);
            changeValue(minValue);
            return;
        }

        changeValue(value);
    });
};
