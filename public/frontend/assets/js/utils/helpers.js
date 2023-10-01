
const __HELPER__ = {
    getURLParam: (key, _default = '') => {
        const href = window.location.href;
        const url = new URL(href);
        return url.searchParams.get(key) || _default;
    },
    setURLParam: (param, value) => {
        // Get the current URL
        let url = new URL(window.location.href);

        // Update the parameter
        url.searchParams.set(param, value);

        // Replace the current URL with the updated one
        window.history.replaceState({}, '', url.toString());
    },
};

