@extends('backoffice.layouts.master')

@php
	$title = __('Shipping Rate');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __('Add Shipping Rate'),
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
		<div class="col-md-12">

			<!--begin::Portlet-->
			<div class="k-portlet k-portlet--tabs">
				<div class="k-portlet__head">
					<div class="k-portlet__head-label">
						<h3 class="k-portlet__head-title">{{ __('Add Shipping Rate') }}</h3>
					</div>
					<div class="k-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="tab" href="#mainTab" role="tab" aria-selected="true">
									{{ __('Main') }}
								</a>
							</li>
						</ul>
					</div>
				</div>

				<!--begin::Form-->
				<form class="k-form" name="form_shipping_zones" id="form_shipping_zones" method="post" action="{{ route('bo.web.shipping-rates.store') }}">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
                                <div class="form-group">
									<label>{{ __('Name') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Enter name') }}" value="{{ old('name') }}" required>
								</div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Shipping Zone') }} *</label>
                                        <select name="shipping_zone_id" title="--{{ __('Select Shipping Zone') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker" data-selected-text-format="count > 5">
                                            @foreach($shippingZones as $shippingZone)
                                            <option {{ $shippingZone->id == old('shipping_zone_id') ? 'selected' : '' }} data-tokens="{{ $shippingZone->name }}" value="{{ $shippingZone->id }}">{{ $shippingZone->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Carrier') }} *</label>
                                        <select name="carrier_id" title="--{{ __('Select Carrier') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker" data-selected-text-format="count > 5">
                                            @foreach($carriers as $carrier)
                                            <option {{ $carrier->id == old('carrier_id') ? 'selected' : '' }} data-tokens="{{ $carrier->name }}" value="{{ $carrier->id }}">{{ $carrier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
									<label>{{ __('Delivery Takes') }} *</label>
									<input type="text" class="form-control" name="delivery_takes" placeholder="{{ __('2-5 days') }}" value="{{ old('delivery_takes') }}" required>
								</div>

                                <div class="form-group">
                                    <label>{{ __('Type') }}</label>
                                    <div class="form-group">
                                        <select name="type" class="form-control k_selectpicker">
                                            <option value="">--- {{ __('Select Type') }} ---</option>
                                            @foreach($shippingRateTypeEnumLabels as $key => $label)
                                            <option value="{{ $key }}" {{ old('type', $loop->index == 0 ? $key : null) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row d-none" data-tab-select-by-type="1">
                                    <div class="col-md-6">
                                        <label>{{ __('Minimum Price') }} *</label>
                                        <div class="input-group">
                                            <x-number-input allow-minus="false" key="minimum" name="minimum" class="form-control" value='{{ old("minimum") }}' />
                                            <div class="input-group-append">
                                                <span class="input-group-text">$</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Maximum Price') }} *</label>
                                        <div class="input-group">
                                            <x-number-input allow-minus="false" key="maximum" name="maximum" class="form-control" value='{{ old("maximum") }}' />
                                            <div class="input-group-append">
                                                <span class="input-group-text">$</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row d-none" data-tab-select-by-type="2">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Minimum Weight') }} *</label>
                                        <div class="input-group">
                                            <input type="number" name="minimum" class="form-control" value="{{ old('minimum') }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">g</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Maximum Weight') }} *</label>
                                        <div class="input-group">
                                            <input type="number" name="maximum" class="form-control" value="{{ old('maximum') }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">g</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Rate') }} *</label>
                                    <x-number-input allow-minus="false" key="rate" name="rate" class="form-control" value='{{ old("rate") }}' required />
                                </div>

                                <div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Free Shipping') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('rate') == '0'  ? 'checked' : '' }} value="0" name="free_shipping" />
												<span></span>
											</label>
										</span>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Active') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('status', '1') == '1'  ? 'checked' : ''}} value="1" name="status" />
												<span></span>
											</label>
										</span>
									</div>
								</div>

                                <div class="row">
									<div class="col-2">
										<label class="col-form-label">{{ __('Display on Front End') }}</label>
									</div>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('display_on_frontend') || is_null(old('display_on_frontend')) == '1'  ? 'checked' : ''}} value="1" name="display_on_frontend"/>
												<span></span>
											</label>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="k-portlet__foot">
						<div class="k-form__actions">
							<button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
							<button type="redirect" class="btn btn-secondary">{{ __('Cancel') }}</button>
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
    $(document).ready(function() {
        $('[name="type"]').trigger('change');
        $('[name="free_shipping"]').trigger('change');
    });

    $('[name="type"]').on('change', function() {
        const value = $(this).val();

        $('[data-tab-select-by-type]').addClass('d-none');
        $('[data-tab-select-by-type]').find('input').prop('disabled', true);

        $(`[data-tab-select-by-type="${value}"]`).removeClass('d-none');
        $(`[data-tab-select-by-type="${value}"]`).find('input').prop('disabled', false);

        $.each($('[data-tab-select-by-type].d-none'), function(index, element) {
            $(element).find('input').val('');
            $(element).find('input').attr('value', '');
        });
    });

    $('[name="free_shipping"]').on('change', function() {
        const checked = $(this).is(':checked');
        const rate = $('[name="rate"]').val();

        $('[name="rate"]').prop('disabled', checked);
        $('[name="rate"]').val(
            !checked && rate != '0' ? rate : 0
        );
    });
</script>
@endsection
