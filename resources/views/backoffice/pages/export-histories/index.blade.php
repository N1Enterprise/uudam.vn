@extends('backoffice.layouts.master')

@php
	$title = 'Systems';

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __('Export History'),
		]
	];
@endphp

@section('header')
    {{ __($title) }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
	<div class="k-portlet">
		<div class="k-portlet__head">
			<div class="k-portlet__head-label">
				<h3 class="k-portlet__head-title">{{ __('Search') }}</h3>
			</div>
		</div>

		<!--begin::Form-->
		<form class="k-form k-form--label-right" data-datatable="index_export_history_table" id="search_export_history" method="GET">
			<div class="k-portlet__body">
				<div class="form-group row">
					<div class="col-lg-4">
						<label>{{ __('Created Date Period') }}</label>
						<div>
							<div class="input-group pull-right">
								<input type="daterangepicker" class="form-control" placeholder="{{ __('Select Date Range') }}" value="" readonly>
								<div class="input-group-append">
									<span class="input-group-text">
										<i class="la la-calendar-check-o"></i>
									</span>
								</div>
								<input type="hidden" data-daterangepicker-catch="start" name="created_at_range[]">
								<input type="hidden" data-daterangepicker-catch="end" name="created_at_range[]">
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<label>{{ __('Export By') }}</label>
						<div class="input-group">
							<div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="la la-user"></i>
                                </span>
                            </div>
							<input type="text" class="form-control" name="export_by">
						</div>
					</div>
				</div>
			</div>
			<div class="k-portlet__foot">
				<div class="k-form__actions">
					<div class="row">
						<div class="col-lg-6">
							<button type="submit" class="btn btn-primary" id="btnSearch">{{ __('Search') }}</button>
							<button type="reset" class="btn btn-secondary">{{ __('Reset') }}</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<!--end::Form-->
	</div>
	<div class="k-portlet k-portlet--mobile">
		<div class="k-portlet__head">
			<div class="k-portlet__head-label">
				<h3 class="k-portlet__head-title">
					{{__('Export History')}}
				</h3>
			</div>
		</div>
		<div class="k-portlet__body">
			<!--begin: Datatable -->
			<table id="index_export_history_table" data-request-url="{{ route('bo.api.export-history.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable fs-table-object" data-btn-reload="true">
				<thead>
					<tr>
						<th data-property="id">{{ __('ID') }}</th>
						<th data-name="requested_by_id" data-property="requested_by.display">{{ __('Export By') }}</th>
						<th data-property="page">{{ __('Page') }}</th>
						<th data-property="file_name">{{ __('File Name') }}</th>
						<th data-property="created_at">{{ __('Created At') }}</th>
						<th data-property="updated_at">{{ __('Updated At') }}</th>
						<th data-badge="true" data-property="status">{{ __('Status') }}</th>
						<th class="datatable-action" data-property="actions">{{ __('Action') }}</th>
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
    $('.datatable').find('th.datatable-action').attr('data-action-icon-pack', JSON.stringify({
        download: '<i class="la flaticon-download"></i>',
    }));

    $(document).ready(function() {
        $(document).on('click', 'a[data-action=processing], a[data-action=reload]', function(e) {
            e.preventDefault();
        });

        $(document).on('click', 'a[data-action=download]', function(e) {
            e.preventDefault()
            let url = $(this).attr('href');
            $.ajax({
                url,
                method: 'GET',
                success: function(response) {
                    window.location.href = response;
                },
            });
        });
    })
</script>
@endsection
