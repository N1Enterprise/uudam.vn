
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
    toast: () => {
        return {
            options: {
                closeButton: true
            },
            success: function(message, title = '') {
                toastr.options = this.options;
                toastr.success(message, title);
            },

            error: function(message, title = '') {
                toastr.options = this.options;
                toastr.error(message, title);
            },
            info: function(message, title = '') {
                toastr.options = this.options;
                toastr.info(message, title);
            },
            warning: function(message, title = '') {
                toastr.options = this.options;
                toastr.warning(message, title);
            }
        }
    },
    element: (__element) => {
        const element = $(__element);
        const textSaved = {};

        return {
            disable: (textLoading = 'Đang Xử Lí ...', elChild = null) => {
                element.addClass('element-prevent');

                const _element = elChild ? element.find(elChild) : element;

                textSaved[_element] = _element.text();

                _element.text(textLoading);
            },
            enable: (baseText = '') => {
                element.removeClass('element-prevent');

                const _element = elChild ? element.find(elChild) : element;
                const _baseText = textSaved[_element] || baseText;

                _element.text(_baseText);
            },
        };
    },
};

