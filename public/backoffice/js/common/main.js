
let utcOffsetMenu = {
	init: function() {

		$('#k_header_menu').removeClass('d-none')
        $('.k_selectpicker').selectpicker();

		$('#currentOffsetUTCLabel').text(currentUtcOffset.label())

		let offsetItem = {
			label: 'GMT+00:00',
			offset: '0',
			render: function() {
				let isActive = currentUtcOffset.get() == this.offset;
				let activeClass = isActive ? 'k-menu__item--active': '';
				return `
					<li class="k-menu__item ${activeClass} offset_item${isActive ? '_active': ''}" data-offset="${this.offset}">
						<a href="javascript:;" class="k-menu__link__new">
							<span class="k-menu__link-text">${this.label}</span>
						</a>
					</li>
				`;
			},
			init: function(offset, label) {
				this.offset = offset;
				this.label = label;

				return this;
			}
		}


		let offsetMenuItems = [];
		$.each(APP_CONSTANT.UTC_OFFSETS, function(offset, label) {
			offsetMenuItems.push($(offsetItem.init(offset, label).render()))
		});

		$('#utcOffsets').append(offsetMenuItems)

		$(document).on('click', '.offset_item', function(e) {
			localStorage.clear();
            currentUtcOffset.set($(this).data('offset'));

		})

	}
}

function initDefault() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			'Accept': 'application/json',
		}
	 });

	$( document ).ajaxStart(function( event, jqxhr, settings ) {
		if($('.modal.show').length) {
			fscommon.blockElementUI('.modal.show');
			return;
		}
	});

	$( document ).ajaxComplete(function( event, xhr, settings ) {
		if(! boolVal(settings?.preventRedirectOnComplete) && xhr.status == 278 && xhr.getResponseHeader('X-Redirect-Url')) {
			window.location.href = xhr.getResponseHeader('X-Redirect-Url');

			return;
		}
	});

	$( document ).ajaxStop(function() {
		if($('.modal.show').length) {
			fscommon.unblockUI('.modal.show');
			return;
		}

		$('.modal').one('hidden.bs.modal', function() {
			fscommon.unblockUI($(this));
			return;
		})

		fscommon.unblockUI()
	});

	$( document ).ajaxError(function( event, request, settings ) {
        let response = request?.responseJSON;

        if(request.status === 422) {
            $.each(response?.errors, function(i, v) {
                fstoast.error(v[0]);
            })
        } else if(data_get(response, 'error')) {
			return fstoast.error(data_get(response, 'message', 'Submission is unsuccessful, please try again.'));
        } else if(data_get(response, 'errors')) {
			$.each(data_get(response, 'errors', []), function(i, v) {
                fstoast.error(v[0]);
            })
		}else {
			if(settings.processResults && request.status == 0){
				return;
			}
			fstoast.error('Submission is unsuccessful, please try again.', request.status);
		}
    });
}

$(document).ready(function() {
	utcOffsetMenu.init();
	initDefault();
})
