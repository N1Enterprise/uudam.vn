@extends('backoffice.layouts.master')

@php
	$title = __('Shipping Rates');

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

    @include('backoffice.pages.shipping-rates.partials.index-search-form')

    <div class="k-portlet k-portlet--mobile">
        <div class="k-portlet__head">
            <div class="k-portlet__head-label">
                <h3 class="k-portlet__head-title">
                    {{ __('Shipping Rates') }}
                </h3>
            </div>
            @canAny(['shipping-rates.store'])
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    @can('shipping-rates.store')
                    <a href="{{ route('bo.web.shipping-rates.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                        <i class="la la-plus"></i>
                        {{ __('Create Shipping Rates') }}
                    </a>
                    @endcan
                </div>
            </div>
            @endcan
        </div>
        <div class="k-portlet__body">
            <table id="table-shipping-rates-index" data-searching="true" data-request-url="{{ route('bo.api.shipping-rates.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-property="name">{{ __('Tên') }}</th>
                        <th data-property="delivery_takes">{{ __('Delivery Takes') }}</th>
                        <th data-orderable="false" data-property="shipping_zone.name">{{ __('Shipping Zone') }}</th>
                        <th data-orderable="false" data-badge data-name="type" data-property="type_name">{{ __('Type') }}</th>
                        <th data-name="minimum" data-property="minimum_formatted">{{ __('Minimum') }}</th>
                        <th data-name="maximum" data-property="maximum_formatted">{{ __('Maximum') }}</th>
                        <th data-property="rate" data-render-callback="renderRateCallback">{{ __('Rate') }}</th>
                        <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Trạng thái') }}</th>
                        <th data-property="created_at">{{ __('Ngày tạo') }}</th>
                        <th data-property="updated_at">{{ __('Ngày cập nhật') }}</th>
                        <th class="datatable-action" data-property="actions">{{ __('Hành động') }}</th>
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
    function renderRateCallback(data, type, full) {
        if (+ (data) == 0) {
            return "{{ __('Free Shippinng') }}";
        }

        return parseFloat(data);
    }

    onDelete();

    function onDelete() {
        $(document).on('click', '[data-action=delete]', function(e) {
            e.preventDefault();

            let confirmation = confirm("{{ __('Are you sure you want to delete this shipping rate value?') }}");

            if(! confirmation) {
                return;
            }

            $.ajax({
                url: $(this).attr('href'),
                method: 'delete',
                preventRedirectOnComplete: 1,
                success: function(res) {
                    $('#table-shipping-rates-index').DataTable().ajax.reload();
                }
            });
        });
    }
</script>
@endsection
