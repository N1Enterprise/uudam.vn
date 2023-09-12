@extends('backoffice.layouts.master')

@php
	$title = 'System Setting';

	$breadcrumbs = [
		[
			'label' => $title,
		],
        [
			'label' => 'Manage Blockchain Network',
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
                        {{__('Blockchain Network List')}}
                    </h3>
                </div>
                @can('blockchain-networks.store')
                <div class="k-portlet__head-toolbar">
                    <div class="k-portlet__head-toolbar-wrapper">
                        <a href="{{ route('bo.web.blockchain-networks.create') }}" class="btn btn-default btn-bold btn-upper btn-font-sm">
                            <i class="flaticon2-add-1"></i>
                            {{__('Add Blockchain Network')}}
                        </a>
                    </div>
                </div>
                @endcan
            </div>
            <div class="k-portlet__body">
                <table data-searching="true" data-request-url="{{ route('bo.api.blockchain-networks.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable" id="blockchainNetworksTable">
                    <thead>
                        <tr>
                            <th data-priority="1" data-property="id">{{ __('id') }}</th>
                            <th data-priority="2" data-property="name">{{ __('Name') }}</th>
                            <th data-priority="2" data-property="long_name">{{ __('Long Name') }}</th>
                            <th data-priority="2" data-property="network_code">{{ __('Network Code') }}</th>
                            <th data-badge data-name="status" data-property="status_name">{{ __('Status') }}</th>
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
        function systemCurrencyRenderCode(data, type, full) {
            let isDefault = boolVal(data_get(full, 'is_default'))

            let span = $('<span>').text(`${data} `)

            if(isDefault) {
                span = span.append(generateBadgeElement('default', null))
            }

            return span.prop('outerHTML')
        }

        function systemCurrencyRenderSymbol(data) {
            return $('<h2>').text(data).prop('outerHTML')
        }
    </script>
@endsection
