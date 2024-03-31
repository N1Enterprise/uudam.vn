@extends('backoffice.layouts.master')

@php
	$title = __('Tạo tuỳ chọn thanh toán');

	$breadcrumbs = [
		[
			'label' => __('Cài đặt thanh toán'),
		],
		[
			'label' => __('Tuỳ chọn thanh toán'),
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
		<div class="col-md-6">
			<!--begin::Portlet-->
			<div class="k-portlet k-portlet--tabs">
				<div class="k-portlet__head">
					<div class="k-portlet__head-label">
						<h3 class="k-portlet__head-title">{{ __('Thông tin tuỳ chọn thanh toán') }}</h3>
					</div>
					<div class="k-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="tab" href="#mainTab">
									{{ __('Thông tin chung') }}
								</a>
							</li>
						</ul>
					</div>
				</div>
				<form class="k-form" id="store_payment_option" method="post" action="{{ route('bo.web.payment-options.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab">
								<div class="form-group">
									<label>{{ __('Tiền tệ') }} *</label>
									<select name="currency_code" id="currency_code" data-size="5" class="form-control k_selectpicker" data-live-search="true" required>
										<option default value="">-- {{ __('Chọn tiền tệ') }} --</option>
										@foreach ($__CONFIGURABLE_FIAT_CURRENCIES->groupBy('type_name') as $type => $options)
										<optgroup label="{{ $type }}">
											@foreach ($options as $option)
                                            <option
                                                {{ old('currency_code') == $option->getKey() ? 'selected' : ''}}
                                                data-type="{{ $option->type }}"
                                                title="{{ $option->code }} - {{ $option->name }}"
                                                value="{{$option->getKey()}}">{{$option->code}}
                                            </option>
											@endforeach
										</optgroup>
										@endforeach
									</select>
								</div>

								<div class="form-group">
									<label>{{ __('Loại tùy chọn thanh toán') }} *</label>
									<select class="form-control k_selectpicker" id="type" name="type" required>
										@foreach ($paymentOptionTypeEnumLabels as $key => $label)
                                        <option {{ old('type') == $key ? 'selected' : '' }} value="{{ $key }}">{{ $label }}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group depent_on_type d-none" data-type="2">
									<label>{{ __('Nhà cung cấp thanh toán') }} *</label>
									<select class="form-control k_selectpicker" id="payment_provider_id" name="payment_provider_id"></select>
								</div>

								<div class="form-group online_banking_code_wrapper d-none">
									<label>{{ __('Ngân hàng trực tuyến') }} *</label>
									<select class="form-control k_selectpicker" id="online_banking_code" name="online_banking_code"></select>
								</div>

								<div class="form-group">
									<label>{{ __('Tên tùy chọn thanh toán') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Nhập tên tùy chọn thanh toán') }}" value="{{ old('name') }}" >
								</div>

                                <div class="form-group">
                                    <label>{{ __('Logo') }}</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="upload_image_custom position-relative">
                                                <input type="text" data-image-ref-path="logo" data-image-ref-index="0" class="form-control image_logo_url" name="logo[path]" value="{{ old('logo.path') }}" placeholder="{{ __('Tải ảnh lên hoặc nhập URL ảnh') }}" style="padding-right: 104px;">
                                                <div data-image-ref-wrapper="logo" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                                    <div class="d-flex align-items-center h-100">
                                                        <img data-image-ref-img="logo" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                        <span data-image-ref-delete="logo" data-image-ref-index="0" style="font-size: 16px; cursor: pointer;">&times;</span>
                                                    </div>
                                                </div>
                                                <label for="image_logo" class="btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                                    <input type="file" id="image_logo" data-image-ref-path="file" data-image-ref-index="0" name="logo[file]" class="d-none image_logo_file">
                                                    <i class="flaticon2-image-file"></i>
                                                    <span>{{ __('Tải lên') }}</span>
                                                </label>
                                            </div>
                                            <input type="hidden" class="form-control @anyerror('logo, logo.file, logo.path') is-invalid @endanyerror">
                                            @anyerror('logo, logo.file, logo.path')
                                            {{ $displayMessages() }}
                                            @endanyerror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="image_logo_review">
                                                <div data-image-ref-review-wrapper="logo" data-image-ref-index="0" class="d-none" style="width: 100px; height: 100px; border: 1px solid #ccc;">
                                                    <img data-image-ref-review-img="logo" data-image-ref-index="0" style="width: 100%; height: 100%;" src="" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

								<div class="form-group">
									<label>{{ __('Số tiền tối thiểu') }}</label>
                                    <x-number-input
                                        allow-minus="false"
                                        key="min_amount"
                                        name="min_amount"
                                        class="form-control {{ $errors->has('min_amount') ? 'is-invalid' : '' }}"
                                        value='{{ old("min_amount") }}'
                                    />
								</div>

								<div class="form-group">
									<label>{{ __('Số tiền tối đa') }}</label>
                                    <x-number-input
                                        allow-minus="false"
                                        key="max_amount"
                                        name="max_amount"
                                        class="form-control {{ $errors->has('max_amount') ? 'is-invalid' : '' }}"
                                        value='{{ old("max_amount") }}'
                                    />
								</div>

                                <div class="form-group">
									<label>{{ __('Nội dung mở rộng') }}</label>
									<textarea name="expanded_content" class="form-control" cols="30" rows="3">{{ old('expanded_content') }}</textarea>
								</div>

                                <div class="tab-pane" id="advanceTab">
                                    <div class="form-group">
                                        <label for="parameters">{{ __('Tham số') }}</label>
                                        <div id="json_editor_params" style="height: 200px"></div>
                                        <input type="hidden" name="params" value="{{ old('params', '{}') }}">
                                    </div>
                                </div>

								<div class="row">
									<div class="col-8 col-sm-4">
										<label class="col-form-label">{{ __('Trạng thái') }}</label>
									</div>
									<div class="col-4 col-sm-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('status') == 'on'  ? 'checked' : ''}} name="status" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
								<div class="row">
									<div class="col-8 col-sm-4">
										<label class="col-form-label">{{ __('Hiển thị FE') }}</label>
									</div>
									<div class="col-4 col-sm-3">
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
							<button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
							<button type="redirect" class="btn btn-secondary">{{ __('Huỷ') }}</button>
						</div>
					</div>
				</form>
				<input type="hidden" id="input_payment_provider" value='@json($paymentProviders)'>
				<input type="hidden" id="input_old_payment_provider" value="{{ old('payment_provider_id') }}">
				<input type="hidden" id="input_old_online_banking_code" value="{{ old('online_banking_code') }}">
				<!--end::Form-->
			</div>
		</div>
	</div>
</div>
@endsection

@section('js_script')
@include('backoffice.pages.payment-options.js-pages.handle')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.4/ace.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        let editorMeta = ace.edit($('#json_editor_params')[0], {
            mode: "ace/mode/json",
            theme: 'ace/theme/tomorrow',
            value: $(`input[name="params"]`).val()
        });

        $('form#store_payment_option').on('submit', function(e) {
            e.preventDefault();
            let editorMetaElement = $(`input[name="params"]`).val(editorMeta.getValue());
            $(this).append(editorMetaElement);
            $(this)[0].submit();
        })
    })
</script>
<script>
    const PAYMENT_PROVIDERS = JSON.parse( $('#input_payment_provider').val() );

    /** @class App\Enum\PaymentOptionTypeEnum */
    const PAYMENT_OPTION_TYPE = {
        PAYMENT_PROVIDER: 2,
        CASH_ON_DELIVERY: 3,
    };

    $(document).ready(function() {
        $('[name="currency_code"]').trigger('change');
        $('[name="type"]').trigger('change');
    });

    $('[name="currency_code"]').on('change', function() {
        reloadDependenceElement($(this).val());
    });

    $('[name="type"]').on('change', function() {
        $('select[name="online_banking_code"]').empty();
        $('.depent_on_type').addClass('d-none');

        const type = $(this).val();

        if (type == PAYMENT_OPTION_TYPE.PAYMENT_PROVIDER) {
            $('[name="payment_provider_id"]').trigger('change');
            $('[name="payment_provider_id"]').parents('.depent_on_type').removeClass('d-none');
        } else {
            $('.online_banking_code_wrapper').addClass('d-none');
        }
    });

    $('[name="payment_provider_id"]').on('change', function() {
        const value = $(this).val();

        const params = $(this).find('option:selected').data('params');

        if (! params) {
            return;
        }

        const currencyCodeSelected = $('[name="currency_code"]').find(':selected');

        $('.online_banking_code_wrapper').removeClass('d-none');

        const paymentChannels = params.payment_channel ?? [];

        $('select[name="online_banking_code"]').empty();

        const paymentChannelOption = [];

        for (bankCode in paymentChannels) {
            let bankGroupLabel = bankCode
                .toLowerCase()
                .replaceAll('_', ' ')
                .split(' ')
                .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                .join(' ');

            let bankGroupElement = $('<optgroup>').attr('label', bankGroupLabel).data('type', bankCode).addClass('text-capitalize');
            let bankOptions = [];
            let onlineBankSelected = $('#input_old_online_banking_code').val();
            for (let option in paymentChannels[bankCode]) {
                let bankOptionElement = $('<option>').attr('selected', onlineBankSelected == option).attr('value', option).text(paymentChannels[bankCode][option]);
                bankOptions.push(bankOptionElement);
            }
            bankGroupElement.append(bankOptions);
            paymentChannelOption.push(bankGroupElement);
        }

        $('select[name="online_banking_code"]').append(paymentChannelOption);
        $('select[name="online_banking_code"]').selectpicker('refresh');
    });

    function reloadDependenceElement(currencyCode) {
        $('[name="payment_provider_id"]').html('');

        const paymentProviderOptions = PAYMENT_PROVIDERS
            .map(function(item) {
                let selected = $('input#input_old_payment_provider').val() == item.id;
                let params = JSON.stringify(item.params);

                return $(`<option value="${item.id}" data-params='${params}'>`).text(item.name).prop('selected', selected);
            });

        $('[name="payment_provider_id"]').append(paymentProviderOptions);
        $('[name="payment_provider_id"]').selectpicker('refresh');
    }
</script>
@endsection
