
let utcOffsetMenu = {
	init: function() {

		$('#k_header_menu').removeClass('d-none')
        $('.k_selectpicker').selectpicker();

		// $('#currentOffsetUTCLabel').text(currentUtcOffset.label())

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

	$( document ).ajaxStart(function( event, xhr, settings ) {
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

$( document ).ready(function() {
	utcOffsetMenu.init();
	initDefault();
});

const changeToSlug = (str) => {
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "A");
    str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "E");
    str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "I");
    str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "O");
    str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "U");
    str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "Y");
    str = str.replace(/Đ/g, "D");
    str = str.toLowerCase();
    str = str
        .replace(/[&]/g, "-and-")
        .replace(/[^a-zA-Z0-9._-]/g, "-")
        .replace(/[-]+/g, "-")
        .replace(/[.]/g, "-")
        .replace(/-$/, "");

    return str;
}

$('[data-reference-slug]').on('change', function() {
    const value = $(this).val();
    const name = $(this).attr('data-reference-slug');

    const nameValSlugify = changeToSlug(value?.trim());

    $(`[name="${name}"]`).val(nameValSlugify);
});

var __IMAGE_MANAGER__ = {
    toUrl: async (file) => {
        return file ? await __IMAGE_MANAGER__.toBase64(file) : '';
    },
    toBase64: (file) => {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = reject;
        });
    },
    reviewImage: (src, ref, index) => {
        $(`[data-image-ref-review-wrapper="${ref}"][data-image-ref-index="${index}"]`).toggleClass('d-none', !src);
        $(`[data-image-ref-review-img="${ref}"][data-image-ref-index="${index}"]`).attr('src', src ? src : '');
    },
    reviewFileOn: async (file, ref, index) => {
        const imageUrl = await __IMAGE_MANAGER__.toUrl(file);

        $(`[data-image-ref-wrapper="${ref}"][data-image-ref-index="${index}"]`).toggleClass('d-none', !imageUrl);
        $(`[data-image-ref-img="${ref}"][data-image-ref-index="${index}"]`).attr('src', imageUrl ? imageUrl : '');
        $(`[data-image-ref-path="${ref}"][data-image-ref-index="${index}"]`).val('');

        __IMAGE_MANAGER__.reviewImage(imageUrl, ref, index);
    },
    reviewPathOn: (path, ref, index) => {
        __IMAGE_MANAGER__.reviewImage(path, ref, index);
        $(`[data-image-ref-file="${ref}"][data-image-ref-index="${index}"]`).val('');
    },

    deleteRef: (ref, index) => {
        __IMAGE_MANAGER__.reviewFileOn(null, ref, index);
    },
};

$('[data-generate]').each(function(_, element) {
    $(element).on('click', function() {
        const isUppercase = $(element).attr('data-generate-uppercase') == 'true';
        const isLowercase = $(element).attr('data-generate-lowercase') == 'true';
        const length = $(element).attr('data-generate-length') || 6;
        const prefix = $(element).attr('data-generate-prefix');
        const $ref = $(element).attr('data-generate-ref');

        let generatedString = makeid(length);

        if (prefix) {
            generatedString = prefix + generatedString;
        }

        if (isUppercase) {
            generatedString = (generatedString).toUpperCase();
        }

        if (isLowercase) {
            generatedString = (generatedString).toLowerCase();
        }

        $($ref).val(generatedString);
    });
});


function makeid(length) {
    let result = '';

    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    const charactersLength = characters.length;

    let counter = 0;

    while (counter < length) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
      counter += 1;
    }

    return result;
}
