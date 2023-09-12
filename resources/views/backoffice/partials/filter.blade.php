@if(!empty($items))
<div class="k_selectpicker_filter" data-original-title="{{ __('Add filter') }}" data-toggle="tooltip">
    <div class="dropdown dropdown-inline">
        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-md" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-solid fa-filter"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(29px, 29px, 0px);">
            <ul class="k-nav">
                <li class="k-nav__section k-nav__section--first">
                    <span class="k-nav__section-text">{{ __('Add filter') }}</span>
                </li>
                @foreach($items as $key => $item)
                <li data-index="{{ $key }}" data-name="{{ data_get($item, 'name') }}" data-type="{{ data_get($item, 'type') }}" class="k-nav__item filter_selection">
                    <a data-index="{{ $key }}" data-name="{{ data_get($item, 'name') }}" data-type="{{ data_get($item, 'type') }}" class="k-nav__link">{{ data_get($item, 'label') }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@push('js_pages')
<script>
    var fscommon = fscommon || {};
    let filters = JSON.parse('{!! json_encode($items) !!}' || {});
    let filterInputs = JSON.parse('{!! json_encode(Arr::pluck($items, "name")) !!}' || {});
    let place_to_append = '{{ $placeToAppend ?? "filter_place_content" }} ';

    $('body').tooltip({
        selector: '.tooltip-element',
        container: 'body',
        trigger: 'hover'
    });

    $(document).on('click', '.filter_selection ', function(e) {
        var input_type = $(this).data('type');
        var input_index = $(this).data('index');
        appendElement(input_type, input_index);
    });

    $(document).on('click', '.btn-delete-filter', function() {
        var elementParent = $(this).attr('remove-warp');
        $(elementParent).tooltip('hide');
        $(elementParent).remove();
    });

    function appendSelect(input_index, old_value = '') {
        var options = filters[input_index].value || '';
        var defaults = filters[input_index].default || [];
        var input_title = filters[input_index].label || '';
        var input_name = filters[input_index].name || '';
        var wrapper_class = filters[input_index].wrapper_class || 'col-lg-3 form-group';
        var html_option = '';

        if ($('select[name="' + input_name + '"]').length > 0) {
            return;
        }

        html_option = generateOption(defaults, old_value);
        html_option = html_option + generateOption(options, old_value);

        var selectEl = $(
            '<div id="warp_' + input_name + '" class="' + wrapper_class + '" >' +
            '<div class="input-group">' +
            '<select class="k_selectpicker tooltip-element form-control"  data-original-title="' + input_title + '" data-toggle="tooltip" name="' + input_name + '">' + html_option + '</select>' +
            '<div class="input-group-append"><button remove-warp="#warp_' + input_name + '"  class="btn-delete-filter btn  btn-hover-metal btn-icon">' +
            '<i class="la la-remove"></i>' +
            '</button></div>' +
            '</div>' +
            '</div>'
        );

        $("." + place_to_append).append(selectEl);
        $('.k_selectpicker').selectpicker();
        $('.bootstrap-select').tooltip({
            title: function() {
                var title = $(this).find("select").attr("data-original-title")
                return title;
            },
            trigger: 'hover'
        });
    }

    function appendDateRangPicker(input_index, old_value = '') {
        var options = filters[input_index].value;
        var defaults = filters[input_index].default || [];
        var input_title = filters[input_index].label || '';
        var input_name = filters[input_index].name || '';
        var wrapper_class = filters[input_index].wrapper_class || 'col-lg-3 form-group';
        var range_name = filters[input_index].rangeName || 'created_at';
        var start_date = '';
        var end_date = '';

        if (typeof prefillFilterTableParams[range_name + '_range'] != 'undefined') {
            var date_rage_selected = prefillFilterTableParams[range_name + '_range'];
            start_date = date_rage_selected[0];
            end_date = date_rage_selected[1];
        }

        if ($('input[name="' + input_name + '"]').length > 0) {
            return;
        }

        var datePicker = $(
            '<div id="warp_' + input_name + '" class="' + wrapper_class + ' tooltip-element " data-original-title="' + input_title + '" data-toggle="tooltip">' +
            '<div>' +
            '<div class="input-group pull-right">' +
            '<input type="daterangepicker" class="form-control ' + input_name + '" placeholder="' + input_title + '" value="' + old_value + '" name="' + input_name + '" readonly>' +
            '<div class="input-group-append">' +
            '<span class="input-group-text">' +
            '<i class="la la-calendar-check-o"></i>' +
            '</span>' +
            '</div>' +
            '<div class="input-group-append"><button remove-warp="#warp_' + input_name + '"  class="btn-delete-filter btn  btn-hover-metal btn-icon">' +
            '<i class="la la-remove"></i>' +
            '</button></div>' +
            '<input type="hidden" data-daterangepicker-catch="start"  name="' + range_name + '_range[]" value="' + start_date + '"> ' +
            '<input type="hidden" data-daterangepicker-catch="end" name="' + range_name + '_range[]" value="' + end_date + '">' +
            '</div>' +
            '</div>' +
            '</div>'
        );
        var inputNameEl = 'input[name=' + input_name + ']';
        $("." + place_to_append).append(datePicker);

        var date_range_config = fscommon.initDateRangePickerDefault(inputNameEl);
        fscommon.initDateRangePicker($(inputNameEl), date_range_config);
    }

    function appendInput(input_index, old_value = '') {
        var input_title = filters[input_index].label || '';
        var input_name = filters[input_index].name || '';
        var wrapper_class = filters[input_index].wrapper_class || 'col-lg-3 form-group';
        if ($('input[name="' + input_name + '"]').length > 0) {
            return;
        }
        var inputElement = $('<div id="warp_' + input_name + '" class=" tooltip-element ' + wrapper_class + ' "   data-original-title="' + input_title + '" data-toggle="tooltip">' +
            '<div class="input-group">' +
            '<input type="text"  class="form-control ' + input_name + '"  placeholder="' + input_title + '" value="' + old_value + '" name="' + input_name + '" >' +
            '<div class="input-group-append"><button remove-warp="#warp_' + input_name + '"  class="btn-delete-filter btn  btn-hover-metal btn-icon">' +
            '<i class="la la-remove"></i>' +
            '</button></div>' +
            '</div>' +
            '</div>')
        $("." + place_to_append).append(inputElement);

    }

    function appendCheckBox(input_index, old_value = '') {
        var input_title = filters[input_index].label || '';
        var input_name = filters[input_index].name || '';
        var wrapper_class = filters[input_index].wrapper_class || 'col-lg-3 form-group';

        if ($('input[name="' + input_name + '"]').length > 0) {
            return;
        }
        var checkbookOption = {
            'type': 'checkbox',
            'name': input_name,
            value: 1
        };
        if (old_value.length > 0) {
            checkbookOption.checked = true;
        }
        var inputElement = $("<div>", {
            'class': wrapper_class,
            'id': 'warp_' + input_name
        });
        var checkBoxElement = $("<input/>", checkbookOption);
        var div = $("<div>", {
            'class': 'k-checkbox-inline'
        });
        var label = $('<label>', {
            'class': 'k-checkbox',
            text: input_title
        });
        var buttonRemove = $('<button remove-warp="#warp_' + input_name + '"  class="btn-delete-filter btn  btn-hover-metal btn-icon">' +
            '<i class="la la-remove"></i>' +
            '</button></div>')

        inputElement.append(div.append(label.append(checkBoxElement, $('<span>')), buttonRemove));

        $("." + place_to_append).append(inputElement);
    }

    function appendElement(input_type, input_index, old_value = '') {
        old_value = $.fn.dataTable.render.text().display(old_value);
        switch (input_type) {
            case 'select':
                appendSelect(input_index, old_value);
                break;
            case 'dateRangePicker':
                appendDateRangPicker(input_index, old_value);
                break;
            case 'text':
                appendInput(input_index, old_value);
                break;
            case 'checkbox':
                appendCheckBox(input_index, old_value);
                break;
        }
    }

    function generateOption(options, selectedValue = null) {
        html_option = '';
        for (var key in options) {
            var selected = '';
            var optionName = $.fn.dataTable.render.text().display(options[key]);
            if (selectedValue == key) {
                selected = 'selected';
            }
            html_option = html_option + '<option ' + selected + ' value="' + key + '">' + optionName + '</option>';
        }
        return html_option;

    }

    let prefillFilterTableParams = JSON.parse(localStorage.getItem(getPrefillStorageKey('{{ $tableName }}')) || '{}');

    for (var index in filterInputs) {
        if (typeof prefillFilterTableParams[filterInputs[index]] != 'undefined') {
            var element = filters[index];;
            var input_type = element.type;
            var input_index = index;
            var old_value = prefillFilterTableParams[filterInputs[index]];
            if (old_value) {
                appendElement(input_type, input_index, old_value);
            }
        }
    }
</script>
@endpush
<style>
    .filter_body {
        position: relative;
    }

    .filter_content,
    .filter_place_content {
        padding-right: 50px;
    }

    .filter_selection {
        cursor: pointer;
    }

    .k_selectpicker_filter {
        top: 0px;
        position: absolute;
        right: 0px;
    }

    .input-group .bootstrap-select {
        flex: 1 1 auto;
        width: 1% !important;
    }
</style>
@endif
