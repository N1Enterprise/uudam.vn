@extends('backoffice.layouts.master')

@php
	$title = 'Payments';

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => 'Payment Settings',
		],
		[
			'label' => 'Create Payment Provider',
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
						<h3 class="k-portlet__head-title">{{ __('Create Payment Provider') }}</h3>
					</div>
				</div>
				<form class="k-form" id="store_payment_provider" method="post" action="{{ route('bo.web.payment-providers.store') }}">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="form-group">
							<label>{{ __('Payment Provider Name') }} *</label>
							<input type="text" class="form-control" name="name" placeholder="{{ __('Enter payment provider name') }}" value="{{ old('name') }}" required>
						</div>

						<div class="form-group">
							<label>{{ __('Payment Provider') }} <a data-toggle="collapse" href="#class_hint" > <i class="la flaticon-light"></i> </a></label>
							<select class="form-control" name="code">
								<option value="">-- {{ __('Select Payment Provider') }} --</option>
								@foreach ($providers as $provider)
                                <option {{ old('code') == data_get($provider, 'code') ? 'selected' : '' }} value="{{ data_get($provider, 'code') }}">{{ data_get($provider, 'name') }}</option>
								@endforeach
							</select>

							@foreach ($providers as $provider)
                            <input disabled type="hidden" class="d-none" name="{{ data_get($provider, 'code') }}[parameters]" value='@json(data_get($provider, 'parameters'))'>
							@endforeach
						</div>
						<div class="form-group">
                            <label for="exampleSelect1">{{ __('Payment Type') }}</label>
                            <select class="form-control" id="payment_type" name="payment_type">
                                @foreach ($paymentTypes as $type => $label)
                                <option {{ old('payment_type') == $type ? 'selected' : '' }} data-type="{{ strtolower($label) }}" value="{{ $type }}">{{ $label }}</option>
                                @endforeach
                            </select>
						</div>
						<div class="form-group d-none class_hint_group collapse" id="class_hint">
                            <div class="k-section__content k-section__content--border">
                                <div>
                                    <div class="card card-body" id="class_hint_content" style="white-space:pre"></div>
                                </div>
                            </div>
						</div>
						<div class="form-group">
							<label>{{ __('Parameters') }}</label>
							<div class="json_editor" style="height: 200px"></div>
							<input type="hidden" name="params" value="{{ old('params', '{}') }}">
						</div>
						<div class="form-group">
							<label>{{ __('Supported Fiat Currencies')}}</label>
							<div class="k-checkbox-inline">
								@foreach ($currencies->where('type', enum('CurrencyTypeEnum')::FIAT) as $currency)
								<label class="k-checkbox">
									<input type="checkbox" {{ in_array($currency->getKey(), old('supported_currencies', [])) ? 'checked' : '' }} value="{{ $currency->getKey() }}" name="supported_currencies[]"> {{ $currency->getKey() }}
									<span></span>
								</label>
								@endforeach
							</div>
						</div>
						<div class="form-group">
							<label>{{ __('Supported Crypto Currencies') }}</label>
							<div class="k-checkbox-inline">
								@foreach ($currencies->where('type', enum('CurrencyTypeEnum')::CRYPTO) as $currency)
								<label class="k-checkbox">
									<input type="checkbox" {{ in_array($currency->getKey(), old('supported_currencies', [])) ? 'checked' : '' }} value="{{ $currency->getKey() }}" name="supported_currencies[]"> {{ $currency->getKey() }}
									<span></span>
								</label>
								@endforeach
							</div>
						</div>

						<div class="form-group row">
							<label class="col-2 col-form-label">{{ __('Status') }}</label>
							<div class="col-3">
								<span class="k-switch">
									<label>
										<input type="checkbox" {{ old('status') == 'on' ? 'checked' : ''}} name="status">
										<span></span>
									</label>
								</span>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.4/ace.js" type="text/javascript"></script>

<script>
    let editor = ace.edit($('.json_editor')[0], {
        mode: "ace/mode/json",
        theme: 'ace/theme/tomorrow',
        maxLines: Infinity,
        minLines: 15,
        value: $(`input[name="params"]`).val()
    });

    $('select[name=code]').on('change', function() {
        let code = $(this).val();
        let paymentTypeOption = $('select[name=payment_type]').find(':selected');
        let paymentType = paymentTypeOption ? paymentTypeOption.data('type') : '';
        if(paymentType === '' || code === '') {
            return;
        }
        setHint(code, paymentType);
    });

    $('select[name=payment_type]').on('change', function() {
        let code = $('select[name=code]').val();
        let paymentTypeOption = $(this).find(':selected');
        let paymentType = paymentTypeOption ? paymentTypeOption.data('type') : '';
        if(paymentType === '' || code === '') {
            return;
        }
        setHint(code, paymentType);
    });

    $('form#store_payment_provider').on('submit', function(e) {
        e.preventDefault();
        let editorElement = $(`input[name="params"]`).val(editor.getValue());
        $(this).append(editorElement);
        $(this)[0].submit();
    })

    function setHint(code, paymentType) {
        let providerParameters = JSON.parse($(`input[name="${code}[parameters]"]`).val() || '{}');
        let getParameters = providerParameters[paymentType] ?? [];

        $('.class_hint_group').removeClass('d-none');
        $('#class_hint_content').html(JSON.stringify(getParameters, null, 4));
    }
</script>
@endsection
