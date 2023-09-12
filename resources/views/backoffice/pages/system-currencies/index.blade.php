@extends('backoffice.layouts.master')

@php
	$title = 'System Setting';

	$breadcrumbs = [
		[
			'label' => $title,
		],
        [
			'label' => 'Manage Currency',
		],
	];
@endphp

@section('header')
    {{ __($title) }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
    <div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
        <div class="k-portlet k-portlet--mobile">
            <div class="k-portlet__head">
                <div class="k-portlet__head-label">
                    <h3 class="k-portlet__head-title">
                        {{__('System Currency List')}}
                    </h3>
                </div>
                @can('system-currencies.store')
                <div class="k-portlet__head-toolbar">
                    <div class="k-portlet__head-toolbar-wrapper">
                        <a href="{{ route('bo.web.system-currencies.create') }}" class="btn btn-default btn-bold btn-upper btn-font-sm">
                            <i class="flaticon2-add-1"></i>
                            {{__('Add New Currency')}}
                        </a>
                    </div>
                </div>
                @endcan
            </div>
            <div class="k-portlet__body">
                <table data-searching="true" data-order-by="6" data-request-url="{{ route('bo.api.system-currencies.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable" id="systemCurrenciesTable">
                    <thead>
                        <tr>
                            <th data-priority="1" data-property="key">{{ __('Code') }}</th>
                            <th data-priority="1" data-property="type_name" data-name="type">{{ __('Type') }}</th>
                            <th data-priority="3" data-property="name">{{ __('Name') }}</th>
                            <th data-orderable="false" data-priority="3" data-property="symbol" data-render-callback="systemCurrencyRenderSymbol">{{ __('Symbol') }}</th>
                            <th data-render-callback="systemCurrencyRenderTags" data-property="status_name">{{ __('Tags') }}</th>
                            <th data-orderable="false" data-property="decimals">{{ __('Decimals') }}</th>
                            <th data-orderable="true" data-property="order">{{ __('Order') }}</th>
                            <th data-property="created_at">{{ __('Created At') }}</th>
                            <th data-orderable="false" data-property="created_by.display">{{ __('Created By') }}</th>
                            <th data-property="updated_at">{{ __('Updated At') }}</th>
                            <th data-orderable="false" data-property="updated_by.display">{{ __('Created By') }}</th>
                            <th data-property="actions" class="datatable-action">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@component('backoffice.partials.datatable') @endcomponent

@section('js_script')
<script>
    let iconPack = {
        base: '<i class="flaticon2-settings"></i>'
    }
    $('.datatable').find('th.datatable-action').attr('data-action-icon-pack', JSON.stringify(iconPack))

    $(document).on('click', '[data-action=default]', function(e) {
        e.preventDefault();

        handleMarkAs($(this).attr('href'), "{{ __('Are you sure you want to mark this currency as a default?') }}");
    });

    $(document).on('click', '[data-action=base]', function(e) {
        e.preventDefault();

        handleMarkAs($(this).attr('href'), "{{ __('Are you sure you want to mark this currency as a base?') }}");
    });

    function systemCurrencyRenderTags(data, type, full) {
        let isDefault = boolVal(data_get(full, 'is_default'));
        let isBase = boolVal(data_get(full, 'is_base'));
        let usable = boolVal(data_get(full, 'usable'));
        let span = $('<span style="display:flex;gap:0.5rem">');

        span.append(generateBadgeElement(data_get(full, 'status_name'), null))

        if (usable) {
            span = span.append(generateBadgeElement('accent', null, 'Usable'))
        }

        if (isDefault) {
            span = span.append(generateBadgeElement('default', null))
        }

        if (isBase) {
            span = span.append(generateBadgeElement('main', null, 'Base'))
        }

        return span.prop('outerHTML')
    }

    function systemCurrencyRenderSymbol(data) {
        return $('<h2>').text(data).prop('outerHTML')
    }

    function handleMarkAs(href, confirmMsg) {
        let confirmation = confirm(confirmMsg);

        confirmation && $.ajax({
            url: href,
            method: 'put',
            preventRedirectOnComplete: 1,
            success: function(res) {
                $('#systemCurrenciesTable').DataTable().ajax.reload()
            }
        });
    }
</script>
@endsection

