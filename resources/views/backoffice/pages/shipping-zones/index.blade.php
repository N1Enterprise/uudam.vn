@extends('backoffice.layouts.master')

@php
	$title = __('Shipping Zones');

	$breadcrumbs = [
		[
			'label' => $title,
		]
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
                    {{ __('Shipping Zones') }}
                </h3>
            </div>
            @canAny(['shipping-zones.store'])
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    @can('shipping-zones.store')
                    <a href="{{ route('bo.web.shipping-zones.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                        <i class="la la-plus"></i>
                        {{ __('Create Shipping Zones') }}
                    </a>
                    @endcan
                </div>
            </div>
            @endcan
        </div>
        <div class="k-portlet__body">
            <table id="table_shipping-zones_index" data-searching="true" data-request-url="{{ route('bo.api.shipping-zones.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-property="name">{{ __('Name') }}</th>
                        <th data-property="supported_countries" data-render-callback="renderSupportedCountriesCallback">{{ __('Supported Countries') }}</th>
                        <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Status') }}</th>
                        <th data-property="created_at">{{ __('Created At') }}</th>
                        <th data-property="updated_at">{{ __('Updated At') }}</th>
                        <th class="datatable-action" data-property="actions">{{ __('Action') }}</th>
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

    onSeeMoreCountry();

    function renderSupportedCountriesCallback(data, type, full) {
        const count = data?.length || 0;

        if (! count) {
            return;
        }

        const countriesBadge = data.map((country, index) => {
            return $('<span>', { class: `mr-1 mt-1 country-item ${count >= 25 && index >= 25 ? 'd-none' : 'd-inline-block'}` })
                    .append(`<span class="k-badge k-badge--brand k-badge--inline k-badge--outline k-badge--pill">${country}</span>`).prop('outerHTML');
        });

        const container = $('<div>', { class: 'country-see-more' }).append(countriesBadge.join(''));

        if (count >= 25) {
            container.append('<button type="button" class="btn btn-link p-1 see-more-button" style="font-size: 0.8rem;">More</button>');
        }
        return container.prop('outerHTML');
    }

    function onSeeMoreCountry() {
        $(document).on('click', '.country-see-more .see-more-button', function() {
            const isOpen = $(this).hasClass('is-open');
            $(this).text(isOpen ? 'More' : 'Less');
            $(this).toggleClass('is-open', !isOpen);
            if (isOpen) {
                $(this).parents('.country-see-more').find('.country-item:gt(24)').removeClass('d-inline-block');
                $(this).parents('.country-see-more').find('.country-item:gt(24)').addClass('d-none');
            } else {
                $(this).parents('.country-see-more').find('.country-item').removeClass('d-none');
                $(this).parents('.country-see-more').find('.country-item').addClass('d-inline-block');
            }
        });
    }
</script>
@endsection
