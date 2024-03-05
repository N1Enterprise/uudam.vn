@extends('backoffice.layouts.master')

@php
	$title = __('Edit Shipping Provider');

	$breadcrumbs = [
		[
			'label' => __('Shipping Providers'),
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
		<div class="col-md-9">

			<!--begin::Portlet-->
			<div class="k-portlet k-portlet--tabs">
				<div class="k-portlet__head">
					<div class="k-portlet__head-label">
						<h3 class="k-portlet__head-title">{{ __('Edit Shipping Provider') }}</h3>
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
				<form class="k-form" name="form_shipping_providers" id="form_shipping_providers" method="post" action="{{ route('bo.web.shipping-providers.update', $shippingProvider->id) }}">
					@csrf
                    @method('PUT')

					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
                                <div class="form-group">
									<label>{{ __('Tên') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Nhập tên') }}" value="{{ old('name', $shippingProvider->name) }}" required>
								</div>

								<div class="form-group">
                                    <label>{{ __('Shipping Provider') }} *</label>
                                    <select class="form-control k_selectpicker" name="code">
                                        <option value="">-- {{ __('Select Shipping Provider') }} --</option>
                                        @foreach ($providers as $provider)
                                        <option {{ old('code', $shippingProvider->code) == data_get($provider, 'code') ? 'selected' : '' }} value="{{ data_get($provider, 'code') }}">{{ data_get($provider, 'name') }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="tab-pane" id="advanceTab" role="tabpanel">
                                    <div class="form-group">
                                        <label for="parameters">{{ __('Parameters') }}</label>
                                        <div id="json_editor_params" style="height: 200px"></div>
                                        <input type="hidden" name="params" value="{{ old('params', display_json_value($shippingProvider->params)) }}">
                                    </div>
                                </div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Hoạt động') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('status', $shippingProvider->status) == '1'  ? 'checked' : ''}} value="1" name="status"/>
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

        $('form#form_shipping_providers').on('submit', function(e) {
            e.preventDefault();
            let editorMetaElement = $(`input[name="params"]`).val(editorMeta.getValue());
            $(this).append(editorMetaElement);
            $(this)[0].submit();
        })
    })
</script>
@endsection
