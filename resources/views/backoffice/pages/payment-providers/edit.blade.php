@extends('backoffice.layouts.master')

@php
	$title = __('Chỉnh sửa đơn vị thanh toán');

	$breadcrumbs = [
		[
			'label' => __('Cài đặt thanh toán'),
		],
		[
			'label' => __('Đơn vị thanh toán'),
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
	<div class="row">
		<div class="col-md-6">

			<!--begin::Portlet-->
			<div class="k-portlet k-portlet--tabs">
				<div class="k-portlet__head">
					<div class="k-portlet__head-label">
						<h3 class="k-portlet__head-title">{{ __('Thông tin đơn vị thanh toán') }}</h3>
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

				<!--begin::Form-->
				<form class="k-form" name="form_payment-providers" id="form_payment-providers" method="post" action="{{ route('bo.web.payment-providers.update', $paymentProvider->id) }}">
					@csrf
                    @method('PUT')
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab">
                                <div class="form-group">
									<label>{{ __('Tên') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Nhập tên') }}" value="{{ old('name', $paymentProvider->name) }}" required>
								</div>

                                <div class="form-group">
                                    <label>{{ __('Nhà cung cấp') }} *</label>
                                    <select class="form-control k_selectpicker" name="code">
                                        <option value="">-- {{ __('Chọn nhà cung cấp') }} --</option>
                                        @foreach ($providers as $provider)
                                        <option {{ old('code', $paymentProvider->code) == data_get($provider, 'code') ? 'selected' : '' }} value="{{ data_get($provider, 'code') }}">{{ data_get($provider, 'name') }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Loại thanh toán') }}</label>
                                    <select class="form-control k_selectpicker" id="payment_type" name="payment_type">
                                        @foreach ($paymentTypeEnumLabels as $key => $label)
                                        <option {{ old('payment_type', $paymentProvider->payment_type) == $key ? 'selected' : '' }} value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="tab-pane" id="advanceTab">
                                    <div class="form-group">
                                        <label for="parameters">{{ __('Tham số') }}</label>
                                        <div id="json_editor_params" style="height: 200px"></div>
                                        <input type="hidden" name="params" value="{{ old('params', display_json_value($paymentProvider->params)) }}">
                                    </div>
                                </div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Hoạt động') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('status', boolean($paymentProvider->status) ? '1' : '0') == '1'  ? 'checked' : ''}} value="1" name="status"/>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.4/ace.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        let editorMeta = ace.edit($('#json_editor_params')[0], {
            mode: "ace/mode/json",
            theme: 'ace/theme/tomorrow',
            value: $(`input[name="params"]`).val()
        });

        $('form#form_payment-providers').on('submit', function(e) {
            e.preventDefault();
            let editorMetaElement = $(`input[name="params"]`).val(editorMeta.getValue());
            $(this).append(editorMetaElement);
            $(this)[0].submit();
        })
    })
</script>
@endsection
