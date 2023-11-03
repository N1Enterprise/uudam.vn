function initDefault() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			'Accept': 'application/json',
		}
    });
}

function debounce (func, wait, immediate) {
    var timeout;
    return function() {
        var context = this, args = arguments;

        var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
        };

        if (immediate && !timeout) func.apply(context, args);
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

$(document).ready(function() {
	initDefault();
});
