
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
    }
};

