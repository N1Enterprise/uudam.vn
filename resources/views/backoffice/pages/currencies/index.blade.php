@extends('backoffice.layouts.master')

@php
	$title = __('Countries');

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
                    {{ __('Countries') }}
                </h3>
            </div>
        </div>
        <div class="k-portlet__body">
            <table id="table_currencies_index" data-searching="true" data-request-url="{{ route('bo.api.currencies.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-property="name">Name</th>
                        <th data-orderable="false" data-badge data-name="type" data-property="type_name">{{ __('Type') }}</th>
                        <th data-property="used_countries" data-render-callback="renderUsedCurrenciesCallback">{{ __('Used Countries') }}</th>
                        <th data-property="code">Code</th>
                        <th data-property="symbol">Symbol</th>
                        <th data-property="decimals">Decimals</th>
                        <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Status') }}</th>
                        <th data-property="created_at">{{ __('Created At') }}</th>
                        <th data-property="updated_at">{{ __('Updated At') }}</th>
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

    function renderUsedCurrenciesCallback(data, type, full) {
        const count = data?.length || 0;

        if (! count) {
            return;
        }

        const countriesBadge = data.map((currency, index) => {
            return $('<span>', { class: `mr-1 mt-1 currency-item ${count >= 25 && index >= 25 ? 'd-none' : 'd-inline-block'}` })
                    .append(`<span class="k-badge k-badge--brand k-badge--inline k-badge--outline k-badge--pill">${currency}</span>`).prop('outerHTML');
        });

        const container = $('<div>', { class: 'currency-see-more' }).append(countriesBadge.join(''));

        if (count >= 25) {
            container.append('<button type="button" class="btn btn-link p-1 see-more-button" style="font-size: 0.8rem;">More</button>');
        }
        return container.prop('outerHTML');
    }

    function onSeeMoreCountry() {
        $(document).on('click', '.currency-see-more .see-more-button', function() {
            const isOpen = $(this).hasClass('is-open');
            $(this).text(isOpen ? 'More' : 'Less');
            $(this).toggleClass('is-open', !isOpen);
            if (isOpen) {
                $(this).parents('.currency-see-more').find('.currency-item:gt(24)').removeClass('d-inline-block');
                $(this).parents('.currency-see-more').find('.currency-item:gt(24)').addClass('d-none');
            } else {
                $(this).parents('.currency-see-more').find('.currency-item').removeClass('d-none');
                $(this).parents('.currency-see-more').find('.currency-item').addClass('d-inline-block');
            }
        });
    }
</script>
@endsection
