@extends('backoffice.layouts.master')

@php
	$title = __('System Setting');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __('Manage Currency'),
			'href' => route('bo.web.system-currencies.index')
		],
		[
			'label' => __('Edit Currency'),
		]
	];
@endphp

@section('header')
    {{ __($title) }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')

<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
	<div class="row">
		<div class="col-md-6">
			<!--begin::Portlet-->
			<div class="k-portlet">
				<div class="k-portlet__head">
					<div class="k-portlet__head-label">
						<h3 class="k-portlet__head-title">{{ __('Edit Currency') }}</h3>
					</div>
				</div>
				<form class="k-form" method="post" action="{{ route('bo.web.system-currencies.edit', $systemCurrency->getKey()) }}" id="system_currency_form">
					@csrf
					@method('put')
					<div class="k-portlet__body">
						@include('backoffice.partials.message')

						<div class="form-group">
							<label>{{ __('Tên') }} *</label>
							<input type="text" class="form-control" name="name" value="{{ old('name', $systemCurrency->name) }}" required>
						</div>

						<div class="form-group row">
							<div class="col-md-6">
								<label>{{ __('Order') }}</label>
								<input type="number" class="form-control" name="order" value="{{ old('order', $systemCurrency->order) }}">
							</div>

							<div class="col-md-6">
								<label>{{ __('Symbol') }}</label>
								<input type="text" class="form-control" name="symbol" value="{{ old('symbol', $systemCurrency->symbol) }}">
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-6">
								<label>{{ __('Code') }}</label>
								<input type="text" class="form-control" name="code" disabled value="{{ old('code', $systemCurrency->code) }}">
							</div>

							<div class="col-md-6">
								<label>{{ __('Decimals') }}</label>
								<input type="number" readonly max="18" min="0" class="form-control" name="decimals" value="{{ old('decimals', $systemCurrency->decimals) }}">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-2 col-form-label">{{ __('Trạng thái') }}</label>
							<div class="col-3">
								<span class="k-switch">
									<label>
										<input type="hidden" name="status" value="0">

										<input type="checkbox" value="1" {{ old('status', $systemCurrency->status) == 1 ? 'checked' : ''}} name="status" />
										<span></span>
									</label>
								</span>
							</div>
						</div>
					</div>
					<div class="k-portlet__foot">
						<div class="k-form__actions">
							<button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
							<button type="redirect" class="btn btn-secondary">{{ __('Huỷ') }}</button>
						</div>
					</div>
				</form>

				<input type="hidden" name="systemCurrencyType" disabled value="{{ $systemCurrency->type }}">

				<!--end::Form-->
			</div>
		</div>
	</div>
</div>
@endsection
@section('js_script')
<script>
	$('[data-toggle="popover"]').popover();
</script>
@endsection
