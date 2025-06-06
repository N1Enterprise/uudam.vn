@extends('backoffice.layouts.master')

@php
	$title = __('Tuỳ chọn thanh toán');

	$breadcrumbs = [
		[
			'label' => __('Cài đặt thanh toán'),
		],
		[
			'label' => $title,
		],
	];
@endphp

@section('header')
{{ __($title) }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent
{{-- @section('breadcrumb')
@if(! empty($items))
<div class="k-content__head-breadcrumbs">
	<a href="#" class="k-content__head-breadcrumb-home"><i class="flaticon2-shelter"></i></a>
	@foreach ($items as $item)

		@php
			$rawLabel = data_get($item, 'label');
			$active = data_get($item, 'active', false);
			$ignoreTranslation = data_get($item, 'ignoreTranslation', false);
			$label = $ignoreTranslation ?  $rawLabel : __($rawLabel);
		@endphp

		@if (! $loop->last)
        <span class="k-content__head-breadcrumb-separator"></span>
        <a href="{{ data_get($item, 'href') }}" class="k-content__head-breadcrumb-link">{{ $label }}</a>
		@else
        <span class="k-content__head-breadcrumb-separator"></span>
        <a href="{{ data_get($item, 'href') }}" class="k-content__head-breadcrumb-link {{ $active ? 'k-content__head-breadcrumb-link--active' : '' }}">{{ $label }}</a>
		@endif
	@endforeach
</div>
@endif
@endsection --}}


@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
	<div class="k-portlet k-portlet--mobile">
		<div class="k-portlet__head">
			<div class="k-portlet__head-label">
				<h3 class="k-portlet__head-title">
					{{__('Danh sách tuỳ chọn thanh toán')}}
				</h3>
			</div>

            @can('payment-options.store')
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    <a href="{{ route('bo.web.payment-options.create') }}" class="btn btn-default btn-bold btn-upper btn-font-sm">
                        <i class="flaticon2-add-1"></i>
                        {{__('Tạo tuỳ chọn thanh toán')}}
                    </a>

                </div>
            </div>
            @endcan
		</div>
		<div class="k-portlet__body">
			<!--begin: Datatable -->
			<table data-request-url="{{ route('bo.api.payment-options.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable fs-table-object" id="k_table_1">
				<thead>
					<tr>
						<th data-property="id">{{ __('ID') }}</th>
                        <th data-orderable="false" data-property="logo" data-render-callback="renderLogoImage">{{ __('Logo') }}</th>
						<th data-property="name">{{ __('Tên') }}</th>
						<th data-name="type" data-property="type_name" width="100">{{ __('Loại tùy chọn') }}</th>
						<th data-property="payment_provider.name" width="100">{{ __('Nhà cung cấp') }}</th>
						<th data-name="currency_code" data-property="currency.code" width="100">{{ __('Tiền tệ') }}</th>
                        <th data-property="order">{{ __('Thứ tự') }}</th>
						<th data-badge data-name="status" data-property="status_name" width="100">{{ __('Trạng thái') }}</th>
						<th data-property="created_at" width="100">{{ __('Ngày tạo') }}</th>
						<th data-property="updated_at" width="100">{{ __('Ngày cập nhật') }}</th>
						<th class="datatable-action" data-property="actions">{{ __('Hành động') }}</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>

			<!--end: Datatable -->
		</div>
	</div>
</div>
@endsection

@component('backoffice.partials.datatable') @endcomponent

@section('js_script')
<script>
    function renderLogoImage(data, type, full) {
        const image = $('<img>', {
            src: data,
            width: 80,
            height: 'auto',
        });

        return image.prop('outerHTML');
    }
</script>
@endsection
