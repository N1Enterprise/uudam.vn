var fscommon = {
	disableButton: function(obj){
		obj.addClass("k-spinner k-spinner--right k-spinner--sm k-spinner--light disabled");
	},

	enableButton: function(obj) {
		obj.removeClass("k-spinner k-spinner--right k-spinner--sm k-spinner--light disabled");
	},

	isButtonDisabled: function(obj) {
		return obj.hasClass("disabled");
	},
	initDatetimePicker: function(obj, config = {}) {
		const mergedConfig = {
			...{
				todayHighlight: true,
				autoclose: true,
				format: 'yyyy-mm-dd hh:ii'
			},
			... config
		}

		obj.datetimepicker(mergedConfig);
	},
	blockPageUI: function(state = 'primary', message = 'Processing...', overlayColor = '#7b7c7d') {
		KApp.blockPage({
			overlayColor: overlayColor,
			type: 'v2',
			state: state,
			message: message,
			opacity: 0.3,
		});
	},
	blockElementUI: function(selector = '.modal.show', state = 'primary', message = 'Processing...', overlayColor = '#7b7c7d') {
		KApp.block(selector, {
			overlayColor: overlayColor,
			type: 'v2',
			state: state,
			message: message,
			opacity: 0.3,
		});
	},
	unblockUI: function(target) {
		if (target && target != 'body') {
			$(target).unblock();
		} else {
			$.unblockUI();
		}
	},
    swal: (options) => {
        const confirmButtonText = options?.okText || 'Confirm';
        const confirmButtonClass = options?.okClass || 'btn btn-primary k-btn k-btn--pill k-btn--icon';
        const cancelButtonText = options?.cancelText || 'Cancel';
        const cancelButtonClass = options?.cancelClass || 'btn btn-secondary k-btn k-btn--pill k-btn--icon';
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

	initDatePicker: function(obj, config = {}) {
		let mergedConfig = {
			...{
				todayHighlight: true,
				autoclose: true,
				format: 'yyyy-mm-dd'
			},
			...config
		};

		obj.datepicker(mergedConfig);
	},
	initDateRangePickerDefault:function(element){
		let format = $(element).attr('date-format') ?? 'YYYY-MM-DD HH:mm:ss';
		let separator = $(element).attr('date-range-separator') ?? ' ~ ';
		let predefined = $(element).attr('date-predefined');
		let timePicker = $(element).attr('date-range-time') == false ? null : true;
		let timePicker24Hour = timePicker ? true : null;
		let startDate = $(element).attr('start');
		let endDate = $(element).attr('end');
		let minDate = $(element).attr('min');
		let maxDate = $(element).attr('max');
		let storeFormat = $(element).attr('date-store-format');
		let timePickerIncrement = $(element).attr('date-range-time-increment') ?? 1;
		let timePickerSeconds = boolVal($(element).attr('time-picker-seconds') ?? true);
		let hideClearButton = boolVal($(element).attr('hide-clear-button'));

		let config = fscommon.cleanObject({
			cancelClass: hideClearButton ? 'd-none' : 'btn-secondary',
			startDate,
			endDate,
			minDate,
			maxDate,
			timePicker,
			timePicker24Hour,
			timePickerIncrement,
			timePickerSeconds,
			storeFormat,
			locale: {
				format,
				separator
			}
		})
		if(predefined){
			config.ranges = datepickerRanges;
		}
		return config;
	},
	initDateRangePicker: function(obj, config = {}) {
		const mergedConfig = {
			...{
				buttonClasses: 'btn btn-sm',
				applyClass: 'btn-primary',
				cancelClass: 'btn-secondary',
				autoUpdateInput: false,
				storeFormat: APP_CONSTANT.DATE_TIME_FORMAT,
				locale: {
					format: 'YYYY-MM-DD HH:mm:ss',
					separator: " ~ ",
				}
			},
			...config
		};

		mergedConfig.locale.cancelLabel = 'Clear';

		obj.daterangepicker(mergedConfig);

		if (!(isEmpty(config.startDate) && isEmpty(config.endDate))) {
			obj.val(config.startDate + ' ' + mergedConfig.locale.separator + ' ' + config.endDate);
		}

		obj.on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
			obj.parent().find('input[data-daterangepicker-catch=start]').val('');
			obj.parent().find('input[data-daterangepicker-catch=end]').val('');
			obj.parent().find('input[data-daterangepicker-catch=start]').trigger('change');
		});

		obj.on('apply.daterangepicker', function(ev, picker) {
			const start = picker.startDate;
			const end = picker.endDate;

			const formattedStart = start.format(mergedConfig.locale.format);
			const formattedEnd = end.format(mergedConfig.locale.format);
			obj.val(formattedStart + mergedConfig.locale.separator + formattedEnd);
			obj.parent().find('input[data-daterangepicker-catch=start]').val(start.format(mergedConfig.storeFormat));
			obj.parent().find('input[data-daterangepicker-catch=end]').val(end.format(mergedConfig.storeFormat));
			obj.parent().find('input[data-daterangepicker-catch=start]').trigger('change');
			const callbackChangeFunction = obj.attr('callback-change');
			if (callbackChangeFunction){
				fscommon.callFunction(callbackChangeFunction,ev,picker);
			}
		});
	},
	initDateRangePickers: function(element, defaultOption = {
		startDate: moment().startOf('day'),
		endDate:moment().endOf('day')
	}) {
		const self = this;

		$(element).each(function() {
			const format = $(this).attr('date-format') ?? 'YYYY-MM-DD H:mm:ss';
			const separator = $(this).attr('date-range-separator') ?? ' ~ ';
			const predefined = $(this).attr('date-predefined');
			const timePicker = $(this).attr('date-range-time') == false ? null : true;
			const timePicker24Hour = timePicker ? true : null;
			const timePickerIncrement = $(this).attr('date-range-time-increment') ?? 1;
			const startDate = $(this).attr('start') ?? defaultOption.startDate;
			const endDate = $(this).attr('end')?? defaultOption.endDate;
			const minDate = $(this).attr('min');
			const maxDate = $(this).attr('max');
			const customRange = boolVal($(this).attr('custom-range') ?? false);
			const storeFormat = $(this).attr('date-store-format');
			const timePickerSeconds = boolVal($(this).attr('time-picker-seconds') ?? true);

			const config = self.cleanObject({
				startDate,
				endDate,
				minDate,
				maxDate,
				timePicker,
				timePicker24Hour,
				timePickerIncrement,
				timePickerSeconds,
				storeFormat,
				locale: {
					format,
					separator
				}
			});

			if (predefined) {
				config.ranges = {
					'Today': [moment().utcOffset(utcOffset).startOf('day'), moment().utcOffset(utcOffset).endOf('day')],
					'Yesterday': [moment().utcOffset(utcOffset).subtract(1, 'days').startOf('day'), moment().utcOffset(utcOffset).subtract(1, 'days').endOf('day')],
					'Last 7 Days': [moment().utcOffset(utcOffset).subtract(6, 'days').startOf('day'), moment().utcOffset(utcOffset).endOf('day')],
				};
				config.showCustomRangeLabel = customRange;
			}

			self.initDateRangePicker($(this), config);
		});
	},
    formatPrice: function(money, symbol = 'VND') {
        return this.formatNumber(money, '.', ',') + ' ' + symbol;
    },
	formatMoney: function(value, currency = null, includeSymbol = true, fixedDecimals = true, minDecimals = 2, codeAsSymbol = true) {
		if (value == 'N/A' || isEmpty(value)) {
			return 'N/A';
		}

		let config = JSON.parse($('#currencies_input_mask_aliases').val());
		let currencyConfig = data_get(config, currency, {});
		let decimals = data_get(currencyConfig, 'digits', 2);
		let symbol = data_get(currencyConfig, 'symbol', '');
		let thousandSeparator = data_get(currencyConfig, 'thousandSeparator', ',');
		let decimalSeparator = data_get(currencyConfig, 'decimalSeparator', '.');
		let symbolPrefix = boolVal(data_get(currencyConfig, 'symbolPrefix', false));
		let formatted = this.formatNumber(value, decimalSeparator, thousandSeparator, fixedDecimals ? decimals : null, minDecimals);

		if (! includeSymbol) {
			return formatted;
		}

		if (codeAsSymbol) {
			symbol = currency;
		}

		return symbolPrefix ? symbol +' '+ formatted : formatted +' '+ symbol;
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

            return x1 + (! isEmpty(x2) ? dec_point + x2 : '');
    },
    parseDate: function(value, utcOffset = null, to = APP_CONSTANT.DATE_TIME_FORMAT, from = APP_CONSTANT.RAW_DATE_TIME_FORMAT) {
        let dateMoment = moment(value, from, true);

        if (! dateMoment.isValid()) {
            return value;
        }

        return dateMoment.utcOffset(utcOffset ?? 0).format(to);
	},
    convertToClientTime: function(value, utcOffset = 0, to = APP_CONSTANT.DATE_TIME_FORMAT, from = APP_CONSTANT.RAW_DATE_TIME_FORMAT) {
        const dateMoment = moment(value, from, true);

        if (! dateMoment.isValid()) {
            return value;
        }

        return dateMoment.add(utcOffset, 'minutes').format(to);
	},
	isValidDate: function(value, format = APP_CONSTANT.RAW_DATE_TIME_FORMAT) {
		const dateMoment = moment(value, format, true);

		if (! dateMoment.isValid()) {
			return false;
		}

		return true;
	},
	callFunction: function(name, ...vars) {
		if (typeof name === 'function') {
			return name(...vars);
		}

		if (typeof window[name] === 'function') {
			return window[name](...vars);
		}

		return vars ?? name;
	},
	cleanObject: function(obj) {
		return Object.entries(obj).reduce((a,[k,v]) => (v ? (a[k]=v, a) : a), {})
	},
	cleanObjectEmpty: function(obj) {
		return Object.entries(obj).reduce((a,[k,v]) => (! isEmpty(v) ? (a[k]=v, a) : a), {})
	},
	objectifyForm: function(formArray) {
		var _ = {};
		$.map(formArray, function(n) {
			const keys = n.name.match(/[a-zA-Z0-9_]+|(?=\[\])/g);
			if (keys.length > 1) {
				let tmp = _;
				pop = keys.pop();
				for (let i = 0; i < keys.length, j = keys[i]; i++) {
					tmp[j] = (!tmp[j] ? (pop == '') ? [] : {} : tmp[j]), tmp = tmp[j];
				}
				if (pop == '') tmp = (!Array.isArray(tmp) ? [] : tmp), tmp.push(n.value);
				else tmp[pop] = n.value;
			} else _[keys.pop()] = n.value;
		});
		return _;
	}
};

const fsDateHelper = {
	getStartOf: function(unit = 'day', date = null, format = APP_CONSTANT.DATE_TIME_FORMAT, withCurrentUtcOffset = true) {
		date = moment(date);

		if (! date.isValid()) {
			date = moment();
		}

		if (!withCurrentUtcOffset) {
			return date.startOf(unit).format(format);
		}

		const currentUtcOffsetMinute = currentUtcOffset.get();

		return date.utcOffset(currentUtcOffsetMinute).startOf(unit).subtract(currentUtcOffsetMinute, 'minutes').format(format);
	},
	getEndOf: function(unit = 'day', date = null, format = APP_CONSTANT.DATE_TIME_FORMAT, withCurrentUtcOffset = true) {
		date = moment(date);

		if (! date.isValid()) {
			date = moment();
		}

		if (! withCurrentUtcOffset) {
			return date.startOf(unit).format(format);
		}

		const currentUtcOffsetMinute = currentUtcOffset.get();

		return date.utcOffset(currentUtcOffsetMinute).endOf(unit).subtract(currentUtcOffsetMinute, 'minutes').format(format);
	}
}

const fstoast = {
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

const currentUtcOffset = {
	utcOffsetStorageKey: 'fs_stevephamhi_offset_utc',
	set: function(offset) {
        $.ajax({
            url: SET_UTC_OFFSET_URL,
            method: "POST",
            data: {'utc_offset' : offset}
        }).done(function() {
            location.reload();
        });
	},
	get: function() {
        return 0;
	},
	label: function() {
		return APP_CONSTANT.UTC_OFFSETS[this.get()];
	}
}

$(document).ready(function() {
    $('.k_selectpicker').selectpicker();

	// add tooltip bootstrap select
	$('.bootstrap-select').tooltip({
		title: function() {
			var title = $(this).find("select").attr("data-original-title");
			return title;
		},
		trigger: 'hover'
	});

	// Setup Select 2
	$('select.js-select2').each(function () {
		$(this).select2({
			placeholder: $(this).attr("data-original-title")
		})
	});

	// add tooltip select 2
	$("span.select2.select2-container").tooltip({
		title: function () {
			var title = $(this).prev().attr("data-original-title");
			return title;
		},
		trigger: 'hover'
	});

	$(document).on('submit', 'form', function(e) {
		let preventDouble = Boolean($(this).data('prevent-double') == false ? false : true );

		preventFormDuplicateSubmit($(this), preventDouble);
	});

	$(document).on('click', '.actionBtn', function(e) {
		e.preventDefault();
		let $this = $(this);
		let confirmable = $(this).data('confirmable');
		let confirmResult = true;
		let datatableId = $(this).data('datatable');
		let action = $(this).attr('href') ?? $(this).data('url') ?? 'javascript:;';
		let method = $(this).data('method') ?? 'get';
		let form = $($(this).data('form'));
		let formData = form.length ? form.serialize() : null;
		let successCallback = $(this).data('success-callback');
        let completeCallback = $(this).data('complete-callback');
        let overrideSuccessCallback = boolVal($(this).data('override-success-callback'));
		let successMessage = $(this).data('success-message');

		if (action == 'javascript:;') {
			return;
		}

		if (confirmable) {
			confirmResult = confirm($(this).data('confirmable'));
		}

		if (! confirmResult) {
			return;
		}

		if (datatableId) {
			let table = $(`table#${datatableId}`);
			$.ajax({
				url: action,
				method: method,
				preventRedirectOnComplete: 1,
				data: formData,
				success: function(response) {
					if (successCallback) {
                        fscommon.callFunction(successCallback, response);

                        if (overrideSuccessCallback) {
                            return;
                        }
                    } else {
						fstoast.success(successMessage ?? 'Submission is successful');
					}

					$this.closest('.modal.show').modal('hide');
					table.DataTable().ajax.reload();
					var fn = $this.data('fn')?.split(';');

					if (fn?.length) {
                        for (let i=0; i<fn.length; i++) {
                            eval(fn[i]);
                        }
                    }
				},
                complete: function(xhr, status) {
                    if (completeCallback) {
                        fscommon.callFunction(completeCallback, xhr, status);
                    }
                }
			})

			return;
		}

		$.ajax({
			url: action,
			method: method,
			data: formData,
			success: function(response) {
				// do nothing
				if (successCallback) {
                    fscommon.callFunction(successCallback, response);

                    if (overrideSuccessCallback) {
                        return;
                    }
                } else {
					fstoast.success(successMessage ?? 'Submission is successful')
				}
			},
            complete: function(xhr, status) {
                if(completeCallback) {
                    fscommon.callFunction(completeCallback, xhr, status);
                }
            }
		})
	});

	$('input[type=datetimepicker]').each(function() {
		let format = $(this).attr('date-format') ?? 'yyyy-mm-dd hh:ii';
		let startDate = $(this).attr('min');
		let endDate = $(this).attr('max');

		let config = fscommon.cleanObject({
			startDate,
			endDate,
			format
		})

		fscommon.initDatetimePicker($(this), config);
	})

	$('input[type=datepicker]').each(function() {
		let format = $(this).attr('date-format') ?? 'yyyy-mm-dd';
		let startDate = $(this).attr('min');
		let endDate = $(this).attr('max');
		let config = fscommon.cleanObject({
			startDate,
			endDate,
			format
		})

		fscommon.initDatePicker($(this), config);
	})

	$('input[type=daterangepicker]').each(function() {
		let format = $(this).attr('date-format') ?? 'YYYY-MM-DD HH:mm:ss';
		let separator = $(this).attr('date-range-separator') ?? ' ~ ';
		let predefined = $(this).attr('date-predefined');
		let timePicker = $(this).attr('date-range-time') == false ? null : true;
		let timePicker24Hour = timePicker ? true : null;
		let startDate = $(this).attr('start');
		let endDate = $(this).attr('end');
		let minDate = $(this).attr('min');
		let maxDate = $(this).attr('max');
		let storeFormat = $(this).attr('date-store-format');
		let timePickerIncrement = $(this).attr('date-range-time-increment') ?? 1;
		let timePickerSeconds = boolVal($(this).attr('time-picker-seconds') ?? true);
		let hideClearButton = boolVal($(this).attr('hide-clear-button'));

		let config = fscommon.cleanObject({
			cancelClass: hideClearButton ? 'd-none' : 'btn-secondary',
			startDate,
			endDate,
			minDate,
			maxDate,
			timePicker,
			timePicker24Hour,
			timePickerIncrement,
			timePickerSeconds,
			storeFormat,
			locale: {
				format,
				separator
			}
		})
		if(predefined){
			config.ranges = datepickerRanges;
		}

		fscommon.initDateRangePicker($(this), config);
	})

	$('input[data-type="inputmask_currency"]').each(function() {
		let element = $(this);

		let currency = element.data('currency');

		let key = element.data('key');

		let inputElement = $(`input[data-type="inputmask_currency_unmasked"][data-key="${key}"]`);

		currency = ! isEmpty(currency) ? currency : $('#defaultCurrencyCode').val();

		let maskAlias = currency in CURRENCY_INPUT_MASK_ALIASES ? currency : 'numeric';

		let value = element.val();

		let digits = element.data('digits');

		let maskOptions = fscommon.cleanObjectEmpty({
			alias: maskAlias,
			digits: digits,
			allowMinus: boolVal(element.data('allow-minus')),
			rightAlign: boolVal(element.data('right-align')),
		})

		element.inputmask(maskOptions);
		element.inputmask('setvalue', isEmpty(value) ? '' : parseFloat(value).toFixed(digits));

		inputElement.val(element.inputmask('unmaskedvalue'));
	})

	$('input[data-type="inputmask_currency"]').on('keyup change', function() {
		const key = $(this).data('key');
		$(`input[data-type="inputmask_currency_unmasked"][data-key="${key}"]`)
			.data('masked-value', $(this).val())
			.val($(this).inputmask('unmaskedvalue'));
	})

	$('input[data-type="inputmask_numeric"]').each(function() {
		let element = $(this);

		let key = element.data('key');

		let inputElement = $(`input[data-type="inputmask_numeric_unmasked"][data-key="${key}"]`);

		let value = element.val();

		let digits = element.data('digits');

		let maskOptions = fscommon.cleanObjectEmpty({
			alias: 'numeric',
			groupSeparator: '.',
			autoGroup: true,
			digitsOptional: true,
			clearMaskOnLostFocus: false,
			digits: digits,
			allowMinus: boolVal(element.data('allow-minus')),
			min: element.attr('min'),
			max: element.attr('max'),
			rightAlign: boolVal(element.data('right-align')),
		});

		element.inputmask(maskOptions);
		element.inputmask('setvalue', isEmpty(value) ? '' : parseFloat(value));

		inputElement.val(element.inputmask('unmaskedvalue'));
	})

	$('input[data-type="inputmask_numeric"]').on('keyup change', function() {
		let key = $(this).data('key');
		$(`input[data-type="inputmask_numeric_unmasked"][data-key="${key}"]`)
			.data('masked-value', $(this).val())
			.val($(this).inputmask('unmaskedvalue'))
			.prop('disabled', $(this).is(':disabled'));
	})

	$(document).on('click', '[data-modal]', function(e) {
		e.preventDefault();
		let modal = $(this).data('modal') ?? $(this).data('target');
		let url = $(this).data('request-url') ?? $(this).attr('href');
		let method = $(this).data('request-method') ?? $(this).data('method') ?? 'GET';
		if (! url) {
			$(modal).modal('show');
			return;
		}

		$(modal).html('');

		$.ajax({
			url: url,
			method: method,
			success: function(res) {
				$(modal).html(res);
				inputFormatter.formatInput();
				$(modal).modal('show');
			}
		})
	});

	$(document).on('click', 'button[type=redirect]', function(e) {
		e.preventDefault();
		let url = $(this).data('request-url') ?? $(this).attr('href');
		if (!url) {
			return window.history.back();
		}

		return window.location.href = url;
	});

	$(document).on('click', 'img.modal-image,div.modal-image', function(e) {
		let openedModal = $('.modal.show');
		let modalImage = $('#modalImage');
		let rotation = $(this).attr('data-rotation');

		modalImage.find('img').attr('src', $(this).attr('src'));

		if(rotation){
			let img = modalImage.find('img');
			img.css({
				'transform': 'rotate(' + rotation + 'deg) scale(1)',
				'-webkit-transform': 'rotate(' + rotation + 'deg) scale(1)',
				'-ms-transform': 'rotate(' + rotation + 'deg) scale(1)'
			});

		}

		if (openedModal.length) {
			openedModal.modal('hide');
			openedModal.one('hidden.bs.modal', function() {
				modalImage.modal('show');
			})

			modalImage.one('hidden.bs.modal', function() {
				openedModal.modal('show');
			})
		}
		modalImage.modal('show');
	})

	$('[data-toggle="tooltip"]').tooltip({trigger: 'hover'});

	inputFormatter.formatTypehead();
	inputFormatter.formatInput();
});

$(document).on('draw.dt', function (event, settings) {
	var api = new $.fn.dataTable.Api(settings);
	let tableElement = $(api.table().node());
	let tableId = tableElement.attr('id');
	let focusOnSearchInput = tableElement.data('auto-focus') !== undefined ? boolVal(tableElement.data('auto-focus')) : false;

	if (focusOnSearchInput) {
		$(`#${tableId}_filter:visible`).find('input[type=search]').focus();
	}

	$('.tooltip.show[role=tooltip]').remove();
	$(`#${tableId} [data-toggle="tooltip"]`).tooltip({trigger: 'hover'});
});

const inputFormatter = {
	formatInputConstant: {
		element: 'input[data-input-format]',
		key: 'data-input-format'
	},
	formatTypeheadConstant: {
		element: 'input[data-typehead]',
		key: 'data-typehead',
		queryKey: 'data-typehead-query-key',
		displayKey: 'data-typehead-display-key',
		onSelectCallback: 'data-typehead-onselect',
		onChangeCallback: 'data-typehead-onchange',
		onDisplayCallback: 'data-typehead-ondisplay',
		suggestionTemplate: 'data-typehead-suggestion-template',
	},
	format: function() {
		this.formatTypehead();
		this.formatInput();
	},
	formatType: {
		date: function(value) {
			return fscommon.parseDate(value, null, APP_CONSTANT.DATE_FORMAT)
		},
		datetime: function(value) {
			return fscommon.parseDate(value)
		},
		currency: function(value, currencyCode) {
			return fscommon.formatMoney(value, currencyCode)
		},
	},
	formatInput: function() {
		let self = this;
		$(self.formatInputConstant.element).each(function() {
			let formatString = $(this).attr(self.formatInputConstant.key);

			[formatType, formatValue] = formatString.split(':');

			let value = $(this).val();
			switch (formatType) {
				case 'date':
					value = self.formatType.date(value);
					break;
				case 'datetime':
					value = self.formatType.datetime(value);
					break;
				case 'currency':
					value = self.formatType.currency(value, formatValue);
					break;
				default:
					break;
			}

			$(this).val(value);
		})
	},
	formatTypehead: function() {
		let self = this;
		let typeaheadConstant = self.formatTypeheadConstant;
		$(typeaheadConstant.element).each(function() {
			let bloodhoundWildcard = '%QUERY';
			let requestUrl = new URL($(this).attr(typeaheadConstant.key));
			let queryKey = $(this).attr(typeaheadConstant.queryKey) || $(this).attr('name') || 'query';
			let displayKey = $(this).attr(typeaheadConstant.displayKey) || $(this).attr('name') || 'id';
			let onSelectCallback = $(this).attr(typeaheadConstant.onSelectCallback);
			let onChangeCallback = $(this).attr(typeaheadConstant.onChangeCallback);
			let onDisplayCallback = $(this).attr(typeaheadConstant.onDisplayCallback);
			let suggestionTemplate = $(this).attr(typeaheadConstant.suggestionTemplate);

			requestUrl.searchParams.set(queryKey, bloodhoundWildcard);

			let data = new Bloodhound({
				datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
				queryTokenizer: Bloodhound.tokenizers.whitespace,
				remote: {
					url: requestUrl.toString(),
					wildcard: encodeURI(bloodhoundWildcard),
					filter: function(data) {
						return data.data;
					}
				},
			});

			$(this).typeahead({
				hint: true,
				highlight: true,
				minLength: 1
			},

			fscommon.cleanObject({
				limit: 20,
				async: true,
				source: data,
				display: function(data) {
					return onDisplayCallback ? fscommon.callFunction(onDisplayCallback, data) : data[displayKey]
				},
				templates: {
					suggestion: function(data) {
						let suggestionItem = `
							<div>${data[displayKey]}</div>
						`;

						if (suggestionTemplate) {
							suggestionItem = fscommon.callFunction(suggestionTemplate, data);
						}

						return suggestionItem;
					}
				}
			}));

			if (onSelectCallback) {
				$(this).bind('typeahead:select', function(event, data) {
					return fscommon.callFunction(onSelectCallback, data, event)
				});
			}

			if (onChangeCallback) {
				$(this).bind('typeahead:change', function(event, data) {
					return fscommon.callFunction(onChangeCallback, data, event)
				});
			}
		});
	},
}
var utcOffset = currentUtcOffset.get();
var datepickerRanges = {
	// 'Today': [moment().utcOffset(utcOffset).startOf('day'), moment().utcOffset(utcOffset).endOf('day')],
	// 'Yesterday': [moment().utcOffset(utcOffset).subtract(1, 'days').startOf('day'), moment().utcOffset(utcOffset).subtract(1, 'days').endOf('day')],
	// 'Last 7 Days': [moment().utcOffset(utcOffset).subtract(6, 'days').startOf('day'), moment().utcOffset(utcOffset).endOf('day')],
	// 'Last 30 Days': [moment().utcOffset(utcOffset).subtract(29, 'days').startOf('day'), moment().utcOffset(utcOffset).endOf('day')],
	// 'This Month': [moment().utcOffset(utcOffset).startOf('month'), moment().utcOffset(utcOffset).endOf('month')],
	// 'Last Month': [moment().utcOffset(utcOffset).subtract(1, 'month').startOf('month'), moment().utcOffset(utcOffset).subtract(1, 'month').endOf('month')]
};

function preventFormDuplicateSubmit(form, prevent = true) {
	if (! prevent) {
		return;
	}

	disableFormSubmitButton(form, true);
}

function enableFormSubmitButton(selector)
{
	disableFormSubmitButton(selector, false)
}

function disableFormSubmitButton(selector, disable = true) {
	if($(selector).is('form')) {
		return $(selector).find('[type=submit]').prop('disabled', disable)
	}

	return $(selector).prop('disabled', disable)
}

const data_get = function data_get(target, path, fallback) {
	if (isEmpty(path)){
		return fallback;
	}

	let segments = Array.isArray(path) ? path : path.split('.');
	let [segment] = segments;

	let find = target;

	if(segments.length == 1) {
		return find[segment] ?? fallback;
	}
	else if (segment !== '*' && segments.length > 0) {
		if (find[segment] === null || typeof find[segment] === 'undefined') {
			find = typeof fallback === 'function' ? fallback() : fallback;
		}
		else {
			find = data_get(find[segment], segments.slice(1), fallback);
		}
	}

	else if (segment === '*') {
		const partial = segments.slice(path.indexOf('*') + 1, path.length);

		if (typeof find === 'object') {
			find = Object.keys(find).reduce((build, property) => ({
					...build,
					[property]: data_get(find[property], partial, fallback)
				}),
			{});
		}
		else {
			find = data_get(find, partial, fallback);
		}
	}

    /*-----------------------------------------------------------------------------
    |   Arrayable Requirements
    *-----------------------------------------------------------------------------
    |
    |   . All arrays are converted to objects
    |   . For Example
    |      #Code
    |        Code -> data_set({ list: ['one', 'two', 'three'], 'list.*', 'update', true });
    |
    |      #Input
    |         Input -> { list: ['one', 'two', 'three'] }
    |
    |      #During We Convert Arrays To "Indexed Objects"
    |         During -> { list: { '1': 'one', '2': 'two', '3': 'three' } }
    |
    |      #Before Output we convert "Indexed Objects" Back To Arrays
    |         From -> { list: { '1': 'update', '2': 'update', '3': 'update' } }
    |         Into -> { list: ['update', 'update', 'update'] }
    |
    |   . Arrays convert into "Indexed Objects", allowing for wildcard (*) capabilities
    |   . "Indexed Objects" are converted back into arrays before returning the updated target
    |
    */
    if (typeof find === 'object') {
        if (Object.keys(find).length > 0) {
            const isArrayTransformable = Object.keys(find).every(index => index.match(/^(0|[1-9][0-9]*)$/));

            return isArrayTransformable ? Object.values(find) : find;
        }
    } else {
        return find;
    }
};

function boolVal(val) {
    switch (val) {
        case true:
		case "true":
		case 1:
		case "1":
		case "on":
		case "yes":
            return true;
        default:
            return false;
    }
}

function isEmpty(val) {
    switch (val) {
        case '':
		case null:
		case undefined:
        case []:
            return true;
        default:
            return false;
    }
}

function getInputSelection(el) {
	let start = 0,
        end = 0,
        normalizedValue, range,
        textInputRange, len, endRange;

	if (typeof el.selectionStart == "number" && typeof el.selectionEnd == "number") {
        start = el.selectionStart;
        end = el.selectionEnd;
	} else {
        range = document.selection.createRange();
        if (range && range.parentElement() == el) {
            len = el.value.length;
            normalizedValue = el.value.replace(/\r\n/g, "\n");

            // Create a working TextRange that lives only in the input
            textInputRange = el.createTextRange();
            textInputRange.moveToBookmark(range.getBookmark());

            // Check if the start and end of the selection are at the very end
            // of the input, since moveStart/moveEnd doesn't return what we want
            // in those cases
            endRange = el.createTextRange();
            endRange.collapse(false);

            if (textInputRange.compareEndPoints("StartToEnd", endRange) > -1) {
                start = end = len;
            } else {
                start = -textInputRange.moveStart("character", -len);
                start += normalizedValue.slice(0, start).split("\n").length - 1;

                if (textInputRange.compareEndPoints("EndToEnd", endRange) > -1) {
                    end = len;
                } else {
                    end = -textInputRange.moveEnd("character", -len);
                    end += normalizedValue.slice(0, end).split("\n").length - 1;
                }
            }
        }
	}

	return {
        start: start,
        end: end
	};
}

function replaceSelectedText(el, text, selectTextAfterReplace = true, forceAppendToEnd = false) {
	el = $(el)

	if (!el[0]) {
		return;
	}

	let sel = getInputSelection(el[0]);

	if (forceAppendToEnd) {
		sel = {
			start: el.val().length,
			end: el.val().length,
		}
	}

	let val = el.val();

	let replacement = val.slice(0, sel.start) + text + val.slice(sel.end);
	el.val(replacement);
	el.trigger('change');

	el[0]?.focus();
	el[0]?.setSelectionRange(el.val()?.length, el.val()?.length);

	if (selectTextAfterReplace) {
		el[0]?.focus()
		el[0]?.setSelectionRange(sel.start, sel.start + text?.length);
	}
}

function lockResource(data = [], callback = null){
	let url = $("#resourceLockUrl").val();
	$.ajax({
		url,
		method: 'POST',
		data: data,
		success: function(response) {
			if (callback) {
				callback(response);
			}
		}
	});
}

function unlockResource(data = [],callback = null){
	window.addEventListener('beforeunload', function (event) {
		let url = $("#resourceUnLockUrl").val();
		$.ajax({
			url,
			method: 'POST',
			data: data,
			success: function(response) {
				if(callback){
					callback(response);
				}
			}
		})
	});
}

function copyToClipboard(text) {
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
}
