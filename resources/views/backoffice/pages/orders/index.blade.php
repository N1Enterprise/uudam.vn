@extends('backoffice.layouts.master')

@php
	$title = __('Orders');

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
        @include('backoffice.partials.message')
        <div class="k-portlet k-portlet--mobile">
            <div class="k-portlet__head">
                <div class="k-portlet__head-label">
                    <h3 class="k-portlet__head-title">
                        {{ __('Order') }}
                    </h3>
                </div>
                @canAny(['orders.store'])
                <div class="k-portlet__head-toolbar">
                    <div class="k-portlet__head-toolbar-wrapper">
                        @can('orders.store')
                        <a href="{{ route('bo.web.orders.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                            <i class="la la-plus"></i>
                            {{ __('Create Order') }}
                        </a>
                        @endcan
                    </div>
                </div>
                @endcan
            </div>
            <div class="k-portlet__body">
                <table id="table_orders_index" data-searching="true" data-request-url="{{ route('bo.api.orders.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                    <thead>
                        <tr>
                            <th data-property="id">{{ __('ID') }}</th>

                            <th data-property="order_code">{{ __('Order Code') }}</th>
                            <th data-orderable="false" data-property="user.name">{{ __('User Name') }}</th>
                            <th data-property="fullname">{{ __('Full Name') }}</th>
                            <th data-property="email">{{ __('E-mail') }}</th>
                            <th data-property="phone">{{ __('Phone Number') }}</th>

                            <th data-property="total_item">{{ __('Total Item') }}</th>
                            <th data-property="total_quantity">{{ __('Total Quantity') }}</th>

                            <th data-orderable="false" data-badge data-name="payment_status" data-property="payment_status_name">{{ __('Payment Status') }}</th>
                            <th data-orderable="false" data-badge data-name="order_status" data-property="order_status_name">{{ __('Order Status') }}</th>

                            <th data-orderable="false" data-property="created_by.name">{{ __('Created By') }}</th>
                            <th data-orderable="false" data-property="updated_by.name">{{ __('Updated By') }}</th>

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
