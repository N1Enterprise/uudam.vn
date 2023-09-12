$(document).ready(function () {

    $.each($('.datatable'), function(index, element) {
        var tableElement = $(element);
        var searching = Boolean($(tableElement).data('searching') == false ? false : true );
        var scrollX = Boolean($(tableElement).data('scroll-x') == true ? true : false );
        var serverSide = tableElement.data('server-side') == false ? false : true;
        var hasPermission = isEmpty(tableElement.data('has-permission')) ? true : boolVal(tableElement.data('has-permission'));
        let defaultOrder = tableElement.data('default-order')?  tableElement.data('default-order'):'desc';
        let orderBy = tableElement.data('order-by')?  tableElement.data('order-by'):0;
        let btnReload = Boolean($(tableElement).data('btn-reload') == true ? true : false );
        let btnExportCSV = $(tableElement).data('btn-export-csv');
        let hasButton = false;
        let buttons = [];
        let searchPlaceholder = $(tableElement).data('search-placeholder') ?? '';
        let preInitCallback = tableElement.data('pre-init-callback');
        let tableId = tableElement.attr('id');
        let pagingType = tableElement.data('paging-type') ?? 'simple_numbers';
        let pageLength = tableElement.data('page-length');
        let deferLoading = tableElement.data('defer-loading');
        let ignoreSearchStorage = boolVal(tableElement.data('ignore-search-storage'));
        let tabIndex = tableElement.data('tab-index') ?? 0;

        let ajax = {
            url: getRequestURL(tableElement),
            data: function (d) {
                return setRequestParams(tableElement, d, serverSide);
            },
            cache: true,
            dataSrc: function (res) {
                return parseDatatableResponse(res);
            },
        }

        if(!serverSide) {
            ajax = {
                url: getRequestURL(tableElement),
                data: function (d) {
                    return setRequestParams(tableElement, d, serverSide);
                },
                cache: true,
            }
        }

        if(btnReload) {
            buttons.push('reload')
        }

        if(btnExportCSV) {
            hasButton = true;
            buttons.push('csv')
        }

        let groupColumn = tableElement.data('group-column');

        let datatableOptions = {
            "ajax": ajax,
            "searchDelay": 500,
            "bStateSave": false,
            "columns": getColumns(tableElement),
            "order" : [[ orderBy, defaultOrder ]],
            "lengthMenu": [
                [10, 20, 50, 100],
                [10, 20, 50, 100]
            ],
            "scrollX": scrollX,
            "processing": true,
            "serverSide": serverSide,
            "paging": true,
            "pagingType": pagingType,
            "lengthChange": true,
            "pageLength": pageLength ?? 10,
            "searching": searching,
            "responsive": true,
            "info": true,
            "tabIndex": tabIndex,
            "columnDefs": [
                {"targets": 'datatable-action', "defaultContent": "", "responsivePriority": 2},
                {"targets": '_all', "defaultContent": "N/A", "render": $.fn.dataTable.render.text()},
                {"targets": groupColumn, "visible": false},
            ],
            "dom": `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'${pagingType == 'simple' ? '' : 'i'}><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            "buttons": buttons,
            "language": {
                "searchPlaceholder": searchPlaceholder
            },
            "initComplete":function(){
                setTimeout(function(){
                    tableElement.resize();
                },1500);
            }
        }
        if(deferLoading){
            datatableOptions['deferLoading'] = 0;
        }

        // Row Group

        let countColumn = tableElement.find('th').length;

        if (typeof groupColumn != 'undefined') {
            datatableOptions.drawCallback = function ( settings ) {
                var api = this.api();
                var rows = api.rows( {page:'current'} ).nodes();
                var last=null;
                api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                    if ( last !== group ) {
                        $(rows).eq( i ).before(
                            '<tr class="group"><td colspan="'+(countColumn - 1 )+'">'+group+'</td></tr>'
                        );

                        last = group;
                    }
                } );
            }
        }

        let infoCallback = tableElement.data('info');

        if(infoCallback){
            datatableOptions['infoCallback'] = function(settings, start, end, max, total, pre){
                return fscommon.callFunction(infoCallback,element,settings, start,  end, max, total, pre)
            };
        }


        if(!hasPermission) {
            datatableOptions.data = [];
            datatableOptions.serverSide = false;
            datatableOptions.searching = false;
            delete datatableOptions.ajax;
            delete datatableOptions.columns;
            datatableOptions.language.zeroRecords = "You don't have permission to see this."
        }

        !ignoreSearchStorage && tableElement.on('preInit.dt', function(e, settings) {
            let formPrefillData = JSON.parse(localStorage.getItem(getPrefillStorageKey(tableId)) || '{}')
            fscommon.callFunction(preInitCallback, e, settings, formPrefillData)
        })

        tableElement.dataTable(datatableOptions);

        !ignoreSearchStorage && tableElement.on('init.dt', function(e, settings, data) {
            let formPrefillData = JSON.parse(localStorage.getItem(getPrefillStorageKey(tableId)) || '{}')
            let api = new $.fn.dataTable.Api(settings);

            params = api?.ajax?.params();

            api.search(data_get(formPrefillData, 'query'))
            api.page.len(data_get(formPrefillData, 'per_page', pageLength))
            api.page((data_get(formPrefillData, 'page', 1) - 1)).draw(false)
        })

        !ignoreSearchStorage && tableElement.on('draw.dt', function(e, settings) {
            $(tableElement.DataTable().row(0).node()).find('td:first-child').attr('colspan', 1)

            let api = new $.fn.dataTable.Api(settings);

            params = api?.ajax?.params();

            let formPrefillData = JSON.parse(localStorage.getItem(getPrefillStorageKey(tableId)) || '{}')

            let isResetForm = boolVal(data_get(formPrefillData, 'reset_form', false))

            if(params.draw == 1 || isResetForm) {
                api.page((data_get(params, 'page', 1) - 1))
            } else {
                localStorage.setItem(getPrefillStorageKey(tableId), JSON.stringify(api?.ajax?.params() || '{}'))
            }
        })

        tableElement.DataTable().on('responsive-resize', function(e, settings) {
            setTimeout(function () {
                $(tableElement.DataTable().row(0).node()).find('td:first-child').attr('colspan', 1)
            }, 500);
        });
    });
});

// Reload dataable when user submit search form
$("form[data-datatable]").on('submit', function(event) {
    event.preventDefault();
    let form = $(this);
    let tableId = $(this).data('datatable');
    removeRequestParams(tableId, 'reset_form');

    if(boolVal(form.attr('data-clear-query-string'))) {
        $(`table#${tableId}`).DataTable().ajax.url(
            $(`table#${tableId}`).DataTable().ajax.url().split('?')[0]
        )
    }

    $(`table#${tableId}`).DataTable().ajax.reload(function(data) {
        form.find(':submit').prop('disabled', false)
    });
}).on('reset', function(event, defaultParams, shouldReloadData = true ) {
    let form = $(this);

    preventFormDuplicateSubmit(form)

    let tableId = form.attr('data-datatable') ?? 'dt_'+ normalize(location.pathname);
    let ignoreSearchStorage = boolVal($(`table#${tableId}`).data('ignore-search-storage'))
    ! ignoreSearchStorage && localStorage.setItem(getPrefillStorageKey(tableId), JSON.stringify({...defaultParams, ... { reset_form: 1}}))

    if(boolVal(form.attr('data-clear-query-string'))) {
        $(`table#${tableId}`).DataTable().ajax.url(
            $(`table#${tableId}`).DataTable().ajax.url().split('?')[0]
        )
    }

    $(`table#${tableId}`).DataTable().clear()

    $(this).find(':input[type=hidden]').val('').trigger('change');
    $(this).find('select.k_selectpicker').selectpicker('val', '')
    $(this).find('select.k_selectpicker').selectpicker('refresh')
    $(this).find('.select2-hidden-accessible').val('')
    $(this).find('.select2-hidden-accessible').trigger('change')
    if (shouldReloadData) {
        setTimeout(function(){
            $(`table#${tableId}`).DataTable().ajax.reload(function(data) {
                disableFormSubmitButton(form, false)
            });
        },50);
    }
});

$("form[data-datatable]").each(function(i, e) {
    let tableId = $(this).attr('data-datatable') ?? 'dt_'+ normalize(location.pathname);
    let ignoreSearchStorage = boolVal($(`table#${tableId}`).data('ignore-search-storage'))

    let formPrefillData = JSON.parse(localStorage.getItem(getPrefillStorageKey(tableId)) || '{}')

    if(ignoreSearchStorage) {
        formPrefillData = {}
    }

    if($.isEmptyObject(formPrefillData)) {
        return;
    }

    $(this).find(':input').each(function(i, input) {
        let $input = $(input)
        let inputName = $input.attr('name')

        if($input.data('daterangepicker-catch') == 'start') {
            inputName = normalize(inputName)
            let value = data_get(formPrefillData, inputName+'.0')

            if(! isEmpty(value)) {
                $input.val(fscommon.convertToClientTime(value, currentUtcOffset.get(), APP_CONSTANT.DATE_TIME_FORMAT, APP_CONSTANT.DATE_TIME_FORMAT))
            }

            return;
        }else if($input.data('daterangepicker-catch') == 'end') {
            inputName = normalize(inputName)

            let startOfDateRange = data_get(formPrefillData, inputName+'.0')
            let endOfDateRange = data_get(formPrefillData, inputName+'.1')

            if(isEmpty(endOfDateRange)) {
                return;
            }

            let daterangepickerElement = $input.parent().find('input[type="daterangepicker"]');


            let startDate = fscommon.convertToClientTime(startOfDateRange, currentUtcOffset.get(), APP_CONSTANT.DATE_TIME_FORMAT, APP_CONSTANT.DATE_TIME_FORMAT)
            let endDate = fscommon.convertToClientTime(endOfDateRange, currentUtcOffset.get(), APP_CONSTANT.DATE_TIME_FORMAT, APP_CONSTANT.DATE_TIME_FORMAT)
            $input.val(endDate)

            daterangepickerElement.attr('start', startDate)
            daterangepickerElement.attr('end', endDate)

            if(startOfDateRange && endOfDateRange) {
                daterangepickerElement.val(startDate + ' ~ ' + endDate)
            }

            return;
        }else if($input.attr('type') == 'checkbox') {
            inputName = normalize(inputName)
            let values = data_get(formPrefillData, inputName)

            if(Array.isArray(values) && values.length) {
                if($.inArray($input.val(), values) !== -1) {
                    $input.prop('checked', true)
                }
            }else {
                $input.prop('checked', boolVal(values))
            }

            return;
        }else if($input.attr('type') == 'radio') {
            if(data_get(formPrefillData, inputName) == $input.val()) {
                $input.prop('checked', true)
            }

            return;
        } else if ($input.is("select")) {
            if($input.prop('multiple')) {
                $input.val(data_get(formPrefillData, inputName.replace('[]', '')));
            }else if($input.attr("select2-input")){
                var value = data_get(formPrefillData, inputName);
                var text = data_get(formPrefillData, inputName+'_text');
                var $newOption = $("<option selected='selected'></option>").val(value).text(text)
                $input.append($newOption);
                $input.val(data_get(formPrefillData, inputName));
                $input.trigger('change');
            }else {
                let value = data_get(formPrefillData, inputName)
                $input.val(value)
                $input.on('loaded.bs.select', function() {
                    $input.selectpicker('val', value)
                })
            }
        }
        else {
            $input.val(data_get(formPrefillData, inputName))
        }


    })
})

function getPrefillStorageKey(tableId = '') {
    if(isEmpty(tableId)) {
        return 'dt_prefill_' + normalize(location.pathname);
    }

    return 'dt_prefill_' + tableId + '_' + normalize(location.pathname);
}

function parseDatatableResponse(response) {
    if(isEmpty(response.total)) {
        response.recordsTotal = (response.current_page + 1) * response.per_page;
        response.recordsFiltered = (response.current_page + 1) * response.per_page;

        if(! response?.has_more) {
            response.recordsTotal = 0;
            response.recordsFiltered = 0;
        }

        return response.data;
    }

    response.recordsTotal = response.total;
    response.recordsFiltered = response.total;

    return response.data;
}

function getColumns(tableElement) {

    var columns = tableElement.find('th');
    var datatableColumns = [];
    if(columns.length === 0) {
        columns = tableElement.find('.datatable-column');
    }

    $.each(columns, (key, column) => {
        var priorityProperty = $(column).data('priority-property');
        var property = $(column).data('property');
        var name = $(column).data('name') ?? property;
        if(priorityProperty) {
            property = priorityProperty;
            name = $(column).data('priority-name') ?? property;
        }
        var orderable = $(column).data('orderable');
        var renderCallback = $(column).data('render-callback');
        var isActionColumn = $(column).hasClass('datatable-action');
        var badge = $(column).data('badge');
        var link = $(column).data('link');
        var type = $(column).data('type') ?? 'string';
        var link = $(column).data('link');
        var sort = $(column).data('sort');

        var columnObject = {
            'orderable' : (orderable !== undefined && orderable == false) ? false : true,
            'data' : property,
            'name' : name,
            'type' : type,
            'className': name,
            'sort': sort
        };

        if(isActionColumn) {
            var actionIconPack = $(column).data('action-icon-pack');
            columnObject.orderable = false;
            parseActionColumn(columnObject, actionIconPack);
        } else if(typeof  link !='undefined'){
            target = $(column).data('link-target');
            // columnObject.orderable = false;
            parseLink(columnObject, link, target);
        } else if(typeof badge !== 'undefined') {
            parseBadge(badge, columnObject);
        } else if(type == 'money'){
            parseMoneyColumn(columnObject, $(column).data('currency-field'))
        } else {
            parseDateableColumn(type, columnObject);
            parseRenderCallback(renderCallback, columnObject);
        }


        var addColumnEvent = $.Event("onAddColumn");
        tableElement.trigger(addColumnEvent, [columnObject]);
        columnObject = addColumnEvent.result !== undefined ? addColumnEvent.result : columnObject;
        datatableColumns.push(columnObject);
    });

    return datatableColumns

}

function getRequestURL(tableElement) {
    return $(tableElement).data('request-url');
}

function reloadDatatableWithPayload(tableElement, payload = {}, clearDatatableForm = true, resetPagination = true) {
    let tableAjax = $(tableElement).DataTable().ajax
    let dtForm = $(`form[data-datatable="${$(tableElement).attr('id')}"]`)

    let combinedPayload = fscommon.cleanObjectEmpty(payload)

    if(clearDatatableForm) {
        dtForm.trigger('reset', [{}, false])
    }

    tableAjax.url(tableAjax.url().split('?')[0] + '?' + $.param(combinedPayload)).load(function(res) {
        disableFormSubmitButton(dtForm, false)

        dtForm.attr('data-clear-query-string', 1);
    }, resetPagination)
}

function setRequestParams(tableElement, params, isServerSide = true) {
    var datatableId = $(tableElement).attr('id');
    let ignoreSearchStorage = boolVal($(`table#${datatableId}`).data('ignore-search-storage'))
    let prefillData = ignoreSearchStorage ? {} : JSON.parse(localStorage.getItem(getPrefillStorageKey(datatableId)) || '{}')
    let isResetForm = boolVal(data_get(prefillData, 'reset_form', false))

    let strictParams = {
        draw: params.draw
    }

    if((params.draw == 1 || isResetForm) && ! $.isEmptyObject(prefillData)) {
        params = {...params, ...prefillData, ... strictParams}
    }

    if(params.draw != 1 && !isResetForm) {
        let form = $(`form[data-datatable="${datatableId}"]`);
        let otherForm = $(`form#${$(tableElement).data('form-id')}`)
        if(otherForm.length > 0){
            form = otherForm;
        }
        if (form) {
            let formData = form.serializeArray();

            $.each(formData, function (key, val) {
                let name = val.name;

                //Convert date time to server timezone
                if(fscommon.isValidDate(val.value, APP_CONSTANT.DATE_TIME_FORMAT)) {
                    let utcOffset = currentUtcOffset.get();
                    val.value = fscommon.convertToClientTime(val.value, utcOffset * -1, APP_CONSTANT.DATE_TIME_FORMAT, APP_CONSTANT.DATE_TIME_FORMAT);
                }
                if (name.includes('[]')) {
                    name = normalize(name)
                    if (!params[name]) {
                        params[name] = []
                    }

                    if (val.value) {
                        params[name].push(val.value)
                    }
                } else {
                    params[name] = val.value;
                }
            });
        }
    }


    if (isServerSide === true) {
        if (typeof (params.order[0]?.column) !== "undefined") {
            var columnIndex = params.order[0].column;
            params.order_by = params.columns[columnIndex].name;
            params.sort_by = params.order[0].dir;
        }

        if(params.draw == 1) {
            params.per_page = data_get(params, 'per_page', params.length);
            params.page = data_get(params, 'page', ((params.start / params.length) + 1));
            params.query = data_get(params, 'query', params.search['value']);
        }else {
            params.per_page = params.length
            params.page = (params.start / params.length) + 1
            params.query = params.search['value']
        }

        delete params.start;
        delete params.columns;
        // delete params.draw;
        delete params.search;
        delete params.order;
        delete params.length;
    }

    var onAddRequestParams = $.Event("onAddRequestParams");
    tableElement.trigger(onAddRequestParams, [params]);
    params = onAddRequestParams.result !== undefined ? onAddRequestParams.result : params;
    return params;
}

function removeRequestParams(tableId, param) {
    let ignoreSearchStorage = boolVal($(`table#${tableId}`).data('ignore-search-storage'))

    let formPrefillData = JSON.parse(localStorage.getItem(getPrefillStorageKey(tableId)) || '{}');
    delete formPrefillData[param];
    !ignoreSearchStorage && localStorage.setItem(getPrefillStorageKey(tableId), JSON.stringify(formPrefillData || '{}'));
}

function convertURL(url, data, param = null) {
    var parts = url.split('/').filter(part => part.startsWith(':'));

    parts.forEach(part => {
        var property = part.substring(1);
        if(param && param.hasOwnProperty(property)) {
            url = url.replace(part, param[property]);
        } else if(data && data.hasOwnProperty(property)) {
            url = url.replace(part, data[property]);
        }
    });
    return url;
}

function parseRenderCallback(callback, obj) {
    if(callback) {
        obj.render = function(data, type, full, meta) {
            if(typeof window[callback] === 'function') {
                return window[callback](data, type, full, meta);
            }

            return data ?? callback;
        }
    }
}

function parseActionColumn(obj, iconPack = null) {
    obj.render = function(data) {
        let actionElement = $('<div>');

        $.each(data, function(action, url) {
            actionElement.append(generateActionElement(action, url, iconPack, {
                'data-toggle': 'tooltip',
                'data-original-title': capitalize(action.replace(/[_-]/g, ' '))
            }));
        })

        return actionElement.html();
    }
}

function parseMoneyColumn(obj, currencyField = 'currency_code') {
    let renderCallback = function(data, type , full) {
        if(isEmpty(data)) {
            return null;
        }
        return renderMoneyElement(data, data_get(full, currencyField, data_get(full, 'currency_code', data_get(full, 'currency.key')))).prop('outerHTML')
    }

    obj.render = renderCallback;
}

function renderMoneyElement(money, currencyCode) {
    [formattedMoney, formattedCurrencyCode] = fscommon.formatMoney(money, currencyCode).split(' ');

    return $('<span>').text(formattedMoney).append(
        renderCurrencyCodeElement(formattedCurrencyCode)
    );
}

function renderCurrencyCodeElement(currencyCode) {
    return $('<small class="font-weight-bold text-muted text-secondary">').text(' '+currencyCode)
}

function parseDateableColumn(type, obj) {
    let dataType = type

    let renderCallback = function(data, type, full) {
        if(type == 'sort' && !isEmpty(data_get(obj, 'sort'))) {
            return data_get(full, data_get(obj, 'sort'));
        }

        return parseDateable(data, dataType);
    }

    obj.render = renderCallback;
}

function parseDateable(data, type) {
    if(fscommon.isValidDate(data)) {
        if(type == 'date') {
            return fscommon.parseDate(data, null, APP_CONSTANT.DATE_FORMAT);
        }else {
            return fscommon.parseDate(data);
        }
    }
    if(type == 'json') {
        return "<pre>" + JSON.stringify(data, undefined, 2) + '</pre>';
    }
    return $.fn.dataTable.render.text().display(data);
}

function parseBadge(badge, obj) {
    obj.render = function(data) {
        let divElement = $('<div>');

        divElement.append(generateBadgeElement(data, badge));

        return divElement.html();
    }
}

function parseLink(obj, key = 'url',target = null){
    obj.render = function(data, type, row, meta) {
        return $('<a>').attr('href', data_get(row, key)).attr('target',target).text(data).prop('outerHTML');
    }
}

function generateActionElement(action, url, iconPack, attributes = {}) {
    let actionIcons = {
        show: '<i class="la flaticon-eye"></i>',
        update: '<i class="la flaticon-edit-1"></i>',
        delete: '<i class="la flaticon2-trash"></i>',
        default: '<i class="la flaticon-tool-1"></i>',
    };

    actionIcons = {
        ...actionIcons, ...jsonParser(iconPack)
    }

    let element = $(`<a class="btn btn-sm btn-clean btn-icon btn-icon-md action_type_${action}" data-action="${action}">`);

    $.each(attributes, function(attrName, val) {
        element.attr(attrName, val)
    })

    element.attr('href', url).append(actionIcons[action] ?? '');

    return element;
}

function generateBadgeElement(key, classMappers = null, customText = null, tagName = 'span', ...properties) {
    if(!key) {
        return 'N/A';
    }

    let badgeMappers = APP_CONSTANT.BADGE_MAPPERS;

    let formattedKey = snakeCase(key);

    badgeMappers = {
        ...badgeMappers, ...jsonParser(classMappers)
    }

    let className = badgeMappers[formattedKey];

    let element = $(`<${tagName} style="width:max-content" ${properties} class="${className ?? ''}">`).text(customText || capitalize(key));

    return element;
}


function jsonParser(str) {
    let obj = {};

    if(str && typeof str === 'object') {
        obj = str;
    }

    if(isJSONString(str)) {
        obj = JSON.parse(str);
    }

    return obj;
}

function isJSONString(str) {
    try {
        var obj = JSON.parse(str);
        if (obj && typeof obj === 'object' && obj !== null) {
            return true;
        }
    } catch (err) {}
    return false;
}

function snakeCase(string) {
    return string && string.replace(/\W+/g, " ")
      .split(/ |\B(?=[A-Z])/)
      .map(word => word.toLowerCase())
      .join('_');
};

function normalize(string) {
    return string && string.replace(/\W+/g, " ")
      .split(/ |\B(?=[A-Z])/)
      .map(word => word.toLowerCase())
      .join('');
};

function capitalize([first, ...rest], locale = navigator.language) {
    return first.toLocaleUpperCase(locale) + rest.join('')
}

$.extend( true, $.fn.dataTable.defaults, {
    "processing": true,
    "serverSide": false,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "responsive": true,
    "info": true,
    "columnDefs": [
        {"targets": 'datatable-action', "defaultContent": "", "responsivePriority": 2},
        {"targets": '_all', "defaultContent": "N/A"},
    ],
    "searchDelay": 500,
    "bStateSave": false,
    "order" : [[ 0, "desc" ]],
    "lengthMenu": [
        [10, 20, 50, 100],
        [10, 20, 50, 100]
    ],
    "language": {

    }
} );

$.fn.dataTable.ext.buttons.reload = {
    text: '<i class="flaticon-refresh"></i>',
    className: 'btn-sm btn-circle btn-icon',
    attr: {
        "data-toggle": "tooltip",
        "data-original-title": "Reload",
        "title": "Reload"
    },
    action: function ( e, dt, button, config ) {
        dt.ajax.reload();
    }
};

$.fn.dataTable.ext.buttons.csv = {
    text: '<i class="flaticon-download"></i>',
    className: 'btn-sm btn-circle btn-icon',
    attr: {
        "data-toggle": "tooltip",
        "data-original-title": "Export CSV",
        "title": "Export CSV"
    },
    action: function ( e, dt, button, config ) {
        let tableId = dt.table().node().id;
        let url = $("#"+tableId).data('btn-export-csv');
        let data = dt.ajax.params();
        data.utc_offset = currentUtcOffset.get();
        let exportUrl = url + '?' + $.param(data);

        window.open(exportUrl,'_blank');
    }
};
