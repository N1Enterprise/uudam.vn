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

@section('style')
<style>
.upload_image_custom_append_icon {
    top: 50%;
    right: 0;
    transform: translate(-6%, -50%);
    color: #4346ce!important;
    border: 1px solid #4346ce!important;
}
</style>
@endsection

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
									{{ __('Main') }}
								</a>
							</li>
						</ul>
					</div>
				</div>

				<!--begin::Form-->
				<form class="k-form" name="form_shipping_providers" id="form_shipping_providers" method="post" action="{{ route('bo.web.shipping-providers.update', $shippingProvider->id) }}" enctype="multipart/form-data">
					@csrf
					@method('PUT')

					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
                                <div class="form-group">
									<label>{{ __('Name') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Enter name') }}" value="{{ old('name', $shippingProvider->name) }}" required>
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

                                <div class="form-group">
                                    <label>{{ __('Logo Image') }}</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="upload_image_custom position-relative">
                                                <input type="text" data-image-ref-path="logo" data-image-ref-index="0" class="form-control image_logo_url" name="logo[path]" value="{{ old('logo.path', $shippingProvider->logo) }}" placeholder="{{ __('Upload Image or Input URL') }}" style="padding-right: 104px;">
                                                <div data-image-ref-wrapper="logo" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                                    <div class="d-flex align-items-center h-100">
                                                        <img data-image-ref-img="logo" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                        <span data-image-ref-delete="logo" data-image-ref-index="0" aria-hidden="true" style="font-size: 16px; cursor: pointer;">&times;</span>
                                                    </div>
                                                </div>
                                                <label for="image_logo" class="btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                                    <input type="file" id="image_logo" data-image-ref-path="file" data-image-ref-index="0" name="logo[file]" class="d-none image_logo_file">
                                                    <i class="flaticon2-image-file"></i>
                                                    <span>{{ __('Upload') }}</span>
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

                                <div class="tab-pane" id="advanceTab" role="tabpanel">
                                    <div class="form-group">
                                        <label for="parameters">{{ __('Parameters') }}</label>
                                        <div id="json_editor_params" style="height: 200px"></div>
                                        <input type="hidden" name="params" value="{{ old('params', display_json_value($shippingProvider->params)) }}">
                                    </div>
                                </div>

								<div class="form-group">
                                    <label>{{ __('Supported Countries') }}</label>
                                    <select data-actions-box="true" name="supported_countries[]" title="--{{ __('Select Country') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker Supported_Countries_Selector" multiple data-selected-text-format="count > 5">
                                        @foreach($countries as $country)
                                        <option
                                            {{ in_array($country->iso2, old('supported_countries', $shippingProvider->supported_countries ?? [])) ? 'selected' : '' }}
                                            data-tokens="{{ $country->iso2 }} | {{ $country->name }}"
                                            data-subtext="{{ $country->iso2 }}"
                                            data-country-iso2="{{ $country->iso2 }}"
                                            data-country-name="{{ $country->name }}"
                                            value="{{ $country->iso2 }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
									<div class="form-group Supported_Countries_Allowed_Holder mb-0 mt-1">
										<div class="Supported_Countries_Holder_Content">
										</div>
									</div>
                                </div>

								<div class="form-group">
                                    <label>{{ __('Supported Provinces') }}</label>
                                    <select data-actions-box="true" name="supported_provinces[]" title="--{{ __('Select Country') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker Supported_Provinces_Selector" multiple data-selected-text-format="count > 5">
                                        @foreach($provinces as $province)
                                        <option
                                            {{ in_array($province->code, old('supported_provinces', $shippingProvider->supported_provinces ?? [])) ? 'selected' : '' }}
                                            data-tokens="{{ $province->code }} | {{ $province->full_name }}"
                                            data-province-code="{{ $province->code }}"
                                            data-province-name="{{ $province->full_name }}"
                                            value="{{ $province->code }}">{{ $province->full_name }}</option>
                                        @endforeach
                                    </select>
									<div class="form-group Supported_Provinces_Allowed_Holder mb-0 mt-1">
										<div class="Supported_Provinces_Holder_Content">
										</div>
									</div>
                                </div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Active') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('status', '1') == '1'  ? 'checked' : ''}} value="1" name="status"/>
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
@include('backoffice.pages.shipping-providers.js-pages.handle')
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
@include('backoffice.pages.shipping-providers.js-pages.supported-countries')
@include('backoffice.pages.shipping-providers.js-pages.supported-provinces')
@endsection
