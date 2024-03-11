@extends('backoffice.layouts.master')

@php
	$title = __('Tạo phương thức vận chuyển');

	$breadcrumbs = [
		[
			'label' => __('Phương thức vận chuyển'),
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
						<h3 class="k-portlet__head-title">{{ __('Thông tin phương thức') }}</h3>
					</div>
					<div class="k-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="tab" href="#mainTab" role="tab" aria-selected="true">
									{{ __('Thông tin chung') }}
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#advancedTab" role="tab">
									{{ __('Thông tin nâng cao') }}
								</a>
							</li>
						</ul>
					</div>
				</div>

				<!--begin::Form-->
				<form class="k-form" name="form_shipping_options" id="form_shipping_options" method="post" action="{{ route('bo.web.shipping-options.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
                                <div class="form-group">
									<label>{{ __('Tên') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Nhập tên') }}" value="{{ old('name') }}" >
								</div>

								<div class="form-group">
									<label>{{ __('Loại vận chuyển') }} *</label>
									<select class="form-control k_selectpicker" id="type" name="type" required>
										@foreach ($shippingOptionTypeEnumLabels as $key => $label)
                                        <option {{ old('type') == $key ? 'selected' : '' }} value="{{ $key }}">{{ $label }}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group depent_on_type d-none" data-type="{{ enum('ShippingOptionTypeEnum')::SHIPPING_PROVIDER }}">
									<label>{{ __('Nhà cung cấp') }} *</label>
									<select class="form-control k_selectpicker" id="shipping_provider_id" name="shipping_provider_id">
										@foreach ($shippingProviders as $shippingProvider)
										<option value="{{ $shippingProvider->id }}" {{ old('shipping_provider_id') == $shippingProvider->id ? 'selected' : '' }}>{{ $shippingProvider->name }}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group">
									<label>{{ __('Nội dung mở rộng') }}</label>
									<textarea name="expanded_content" class="form-control" cols="30" rows="3">{{ old('expanded_content') }}</textarea>
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
                                                        <span data-image-ref-delete="logo" data-image-ref-index="0" aria-hidden="true" style="font-size: 16px; cursor: pointer;">&times;</span>
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

                                <div class="tab-pane" id="advanceTab" role="tabpanel">
                                    <div class="form-group">
                                        <label for="parameters">{{ __('Tham số') }}</label>
                                        <div id="json_editor_params" style="height: 200px"></div>
                                        <input type="hidden" name="params" value="{{ old('params', '{}') }}">
                                    </div>
                                </div>

								<div class="form-group">
									<label>{{ __('Thứ tự') }}</label>
									<input type="number" class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}" name="order" placeholder="{{ __('Nhập thứ tự ưu tiên') }}" value="{{ old('order') }}">
								</div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Hoạt động') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('status', '1') == '1'  ? 'checked' : ''}} value="1" name="status"/>
												<span></span>
											</label>
										</span>
									</div>
								</div>

								<div class="row">
									<label class="col-2 col-form-label">{{ __('Hiển thị FE') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ boolean(old('display_on_frontend'))  ? 'checked' : ''}} value="1" name="display_on_frontend" />
												<span></span>
											</label>
										</span>
									</div>
								</div>
							</div>

							<div class="tab-pane" id="advancedTab" role="tabpanel">
                                <div class="form-group">
                                    <label>{{ __('Các quốc gia được hỗ trợ') }}</label>
                                    <select data-actions-box="true" name="supported_countries[]" title="-- {{ __('Chọn quốc gia') }} --" data-size="5" data-live-search="true" class="form-control k_selectpicker Supported_Countries_Selector" multiple data-selected-text-format="count > 5">
                                        @foreach($countries as $country)
                                        <option
                                            {{ in_array($country->iso2, old("supported_countries", [])) ? 'selected' : '' }}
                                            data-tokens="{{ $country->iso2 }} | {{ $country->name }}"
                                            data-subtext="{{ $country->iso2 }}"
                                            data-country-iso2="{{ $country->iso2 }}"
                                            data-country-name="{{ $country->name }}"
                                            value="{{ $country->iso2 }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
									<div class="form-group Supported_Countries_Allowed_Holder mb-0 mt-1">
										<div class="Supported_Countries_Holder_Content"></div>
									</div>
                                </div>

								<div class="form-group">
                                    <label>{{ __('Các tỉnh được hỗ trợ') }}</label>
                                    <select data-actions-box="true" name="supported_provinces[]" title="-- {{ __('Chọn tỉnh') }} --" data-size="5" data-live-search="true" class="form-control k_selectpicker Supported_Provinces_Selector" multiple data-selected-text-format="count > 5">
                                        @foreach($provinces as $province)
                                        <option
                                            {{ in_array($province->code, old("supported_provinces", [])) ? 'selected' : '' }}
                                            data-tokens="{{ $province->code }} | {{ $province->full_name }}"
                                            data-province-code="{{ $province->code }}"
                                            data-province-name="{{ $province->full_name }}"
                                            value="{{ $province->code }}">{{ $province->full_name }}</option>
                                        @endforeach
                                    </select>
									<div class="form-group Supported_Provinces_Allowed_Holder mb-0 mt-1">
										<div class="Supported_Provinces_Holder_Content"></div>
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

@include('backoffice.pages.shipping-options.js-pages.handle')
@include('backoffice.pages.shipping-options.js-pages.supported-countries')
@include('backoffice.pages.shipping-options.js-pages.supported-provinces')

<script>
	/** @class App\Enum\ShippingOptionTypeEnum */
	const SHIPPING_OPTION_TYPE_ENUM = {
		NONE_AMOUNT: 1,
		SHIPPING_PROVIDER: 2,
		SHIPPING_ZONE: 3,
	};

    $(document).ready(function () {
        let editorMeta = ace.edit($('#json_editor_params')[0], {
            mode: "ace/mode/json",
            theme: 'ace/theme/tomorrow',
            value: $(`input[name="params"]`).val()
        });	

        $('form#form_shipping_options').on('submit', function(e) {
            e.preventDefault();
            let editorMetaElement = $(`input[name="params"]`).val(editorMeta.getValue());
            $(this).append(editorMetaElement);
            $(this)[0].submit();
        });

		$('[name="type"]').on('change', function() {
			const type = $(this).val();

			$('.depent_on_type').addClass('d-none');
			$(`.depent_on_type[data-type="${type}"]`).removeClass('d-none');

			$('[name="shipping_provider_id"]').prop('disabled', type != SHIPPING_OPTION_TYPE_ENUM.SHIPPING_PROVIDER);
		});

		$('[name="type"]').trigger('change');
    });
</script>
@endsection
