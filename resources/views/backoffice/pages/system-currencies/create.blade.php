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
			'label' => __('Add New Currency'),
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
						<h3 class="k-portlet__head-title">{{ __('Add New Currency') }}</h3>
					</div>
				</div>

				<form id="system_currency_form" class="k-form" method="post" action="{{ route('bo.web.system-currencies.store') }}">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="form-group">
							<label>{{ __('Currency') }} *</label>
							<select name="currency_id" id="currency_id" data-size="5" class="form-control k_selectpicker" data-live-search="true" required>
								<option default value="">--{{ __('Select Currency') }}--</option>
								@foreach ($currencies as $type => $options)
								<optgroup label="{{ $type }}">
									@foreach ($options as $option)
                                    <option
                                        {{ old('currency_id') == $option->id ? 'selected' : ''}}
                                        data-currency-name="{{ $option->name }}"
                                        data-currency-type="{{ $option->type }}"
                                        data-currency-code="{{ $option->code }}"
                                        data-currency-symbol="{{ $option->symbol }}"
                                        data-currency-decimals="{{ $option->decimals }}"
                                        title="{{ $option->code }} - {{ $option->name }}"
                                        data-tokens="{{ $type }}|{{ $option->name }}|{{ $option->code }}"
                                        data-subtext="{{ $option->name }}"
                                        value="{{ $option->id }}">{{ $option->code }}</option>
									@endforeach
								</optgroup>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label>{{ __('Tên') }} *</label>
							<input type="text" class="form-control" name="name" placeholder="{{ __('Nhập tên') }}" value="{{ old('name') }}" required>
						</div>

						<div class="form-group row">
							<div class="col-md-6">
								<label>{{ __('Order') }}</label>
								<input type="number" class="form-control" name="order" value="{{ old('order') }}">
							</div>

							<div class="col-md-6">
								<label>{{ __('Symbol') }}</label>
								<input type="text" class="form-control" name="symbol" value="{{ old('symbol') }}">
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-6">
								<label>{{ __('Code') }}</label>
								<input type="text" class="form-control" name="code" disabled value="{{ old('code') }}">
							</div>

							<div class="col-md-6">
								<label>{{ __('Decimals') }}</label>
								<input type="number" readonly class="form-control" name="decimals" max="18" min="0" value="{{ old('decimals') }}">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-2 col-form-label">{{ __('Trạng thái') }}</label>
							<div class="col-3">
								<span class="k-switch">
									<label>
										<input type="checkbox" value="1" {{ boolean(old('status'))  ? 'checked' : ''}} name="status" />
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

				<!--end::Form-->
			</div>
		</div>
	</div>
</div>
@endsection

@section('js_script')
<script>
    $('[data-toggle="popover"]').popover();

    $(document).ready(function() {
		$('#system_currency_form select[name="currency_id"]').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
			let selectedOption = $(this).find(':selected');

			$('#system_currency_form').find('input[name="name"]').val(selectedOption.data('currency-name'));
			$('#system_currency_form').find('input[name="code"]').val(selectedOption.data('currency-code'));
			$('#system_currency_form').find('input[name="symbol"]').val(selectedOption.data('currency-symbol'));
			$('#system_currency_form').find('input[name="decimals"]').val(selectedOption.data('currency-decimals'));
		});
	});
</script>
@endsection
