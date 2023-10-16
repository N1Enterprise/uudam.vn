function initDefault() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			'Accept': 'application/json',
		}
    });
}

$(document).ready(function() {
	initDefault();
});
