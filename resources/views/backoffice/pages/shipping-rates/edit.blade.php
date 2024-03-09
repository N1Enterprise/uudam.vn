@extends('backoffice.layouts.master')

@php
	$title = __('Chỉnh sửa giá cước vận chuyển');

	$breadcrumbs = [
		[
			'label' => __('Giá cước vận chuyển'),
		],
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
	<div class="row">
		<div class="col-md-12">

			<!--begin::Portlet-->
			<div class="k-portlet k-portlet--tabs">
				<div class="k-portlet__head">
					<div class="k-portlet__head-label">
						<h3 class="k-portlet__head-title">{{ __('Chỉnh sửa giá cước vận chuyển') }}</h3>
					</div>
					<div class="k-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="tab" href="#mainTab" role="tab" aria-selected="true">
									{{ __('Thông tin chung') }}
								</a>
							</li>
						</ul>
					</div>
				</div>

				<!--begin::Form-->
				<form class="k-form" name="form_shipping_zones" id="form_shipping_zones" method="post" action="{{ route('bo.web.shipping-rates.update', $shippingRate->id) }}">
					@csrf
                    @method('PUT')
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
                                <div class="form-group">
									<label>{{ __('Tên') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Nhập tên') }}" value="{{ old('name', $shippingRate->name) }}" required>
								</div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Khu vực') }} *</label>
                                        <select name="shipping_zone_id" title="-- {{ __('Chọn khu vực vận chuyển') }} --" data-size="5" data-live-search="true" class="form-control k_selectpicker" data-selected-text-format="count > 5">
                                            @foreach($shippingZones as $shippingZone)
                                            <option {{ $shippingZone->id == old('shipping_zone_id', $shippingRate->shipping_zone_id) ? 'selected' : '' }} data-tokens="{{ $shippingZone->name }}" value="{{ $shippingZone->id }}">{{ $shippingZone->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="form-group">
									<label>{{ __('Thời gian vận chuyển') }} *</label>
									<input type="text" class="form-control" name="delivery_takes" placeholder="{{ __('2-5 ngày') }}" value="{{ old('delivery_takes', $shippingRate->delivery_takes) }}" required>
								</div>

                                <div class="form-group">
                                    <label>{{ __('Thể loại') }}</label>
                                    <div class="form-group">
                                        <select name="type" class="form-control k_selectpicker">
                                            <option value="">--- {{ __('Chọn loại') }} ---</option>
                                            @foreach($shippingRateTypeEnumLabels as $key => $label)
                                            <option value="{{ $key }}" {{ old('type', $shippingRate->type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row d-none" data-tab-select-by-type="1">
                                    <div class="col-md-6">
                                        <label>{{ __('Giá thấp nhất') }} *</label>
                                        <div class="input-group">
                                            <x-number-input allow-minus="false" key="minimum" name="minimum" class="form-control" value='{{ old("minimum", $shippingRate->minimum) }}' required />
                                            <div class="input-group-append">
                                                <span class="input-group-text">$</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Giá tối đa') }}</label>
                                        <div class="input-group">
                                            <x-number-input allow-minus="false" key="maximum" name="maximum" class="form-control" value='{{ old("maximum", $shippingRate->maximum) }}' />
                                            <div class="input-group-append">
                                                <span class="input-group-text">$</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row d-none" data-tab-select-by-type="2">
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Trọng lượng tối thiểu') }} *</label>
                                        <div class="input-group">
                                            <input type="number" name="minimum" class="form-control" value="{{ old('minimum', round($shippingRate->minimum, 2)) }}" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">g</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>{{ __('Trọng lượng tối đa') }}</label>
                                        <div class="input-group">
                                            <input type="number" name="maximum" class="form-control" value="{{ old('maximum', $shippingRate->maximum ? round($shippingRate->maximum, 2) : '') }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">g</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Tỷ lệ') }} *</label>
                                    <x-number-input allow-minus="false" key="rate" name="rate" class="form-control" value='{{ old("rate", $shippingRate->rate) }}' required />
                                    <div id="is_free_shipping" class="mt-2 text-success d-none">{{ __('Miễn phí vận chuyển') }}</div>
                                </div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Hoạt động') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('status', boolean($shippingRate->status) ? '1' : '0') == '1'  ? 'checked' : ''}} value="1" name="status" />
												<span></span>
											</label>
										</span>
									</div>
								</div>

                                <div class="row">
									<div class="col-2">
										<label class="col-form-label">{{ __('FE Hiển thị') }}</label>
									</div>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('display_on_frontend', boolean($shippingRate->display_on_frontend) ? '1' : '0') == '1'  ? 'checked' : ''}} value="1" name="display_on_frontend" />
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

    $('[data-key="rate"]').on('change', function() {
        const rate = $('[name="rate"]').val();

        $('#is_free_shipping').toggleClass('d-none', rate > 0);
    });

    $('[data-key="rate"]').trigger('change');
</script>
@endsection
