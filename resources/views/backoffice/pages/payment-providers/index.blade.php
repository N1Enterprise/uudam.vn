@extends('backoffice.layouts.master')

@php
	$title = __('Đơn vị thanh toán');

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

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
	<div class="k-portlet k-portlet--mobile">
		<div class="k-portlet__head">
			<div class="k-portlet__head-label">
				<h3 class="k-portlet__head-title">
					{{__('Danh sách đơn vị thanh toán')}}
				</h3>
			</div>

            @can('payment-providers.store')
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    <a href="{{ route('bo.web.payment-providers.create') }}" class="btn btn-default btn-bold btn-upper btn-font-sm">
                        <i class="flaticon2-add-1"></i>
                        {{__('Tạo đơn vị thanh toán')}}
                    </a>

                </div>
            </div>
            @endcan
		</div>
		<div class="k-portlet__body">
			<!--begin: Datatable -->
			<table data-request-url="{{ route('bo.api.payment-providers.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable fs-table-object" id="k_table_1">
				<thead>
					<tr>
						<th data-property="id">{{ __('ID') }}</th>
						<th data-property="name">{{ __('Tên') }}</th>
						<th data-property="code">{{ __('Code') }}</th>
						<th data-name="payment_type" data-property="payment_type_name">{{ __('Loại') }}</th>
						<th data-badge data-name="status" data-property="status_name">{{ __('Trạng thái') }}</th>
						<th data-property="created_at">{{ __('Ngày tạo') }}</th>
						<th data-property="updated_at">{{ __('Ngày cập nhật') }}</th>
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
