@extends('backoffice.layouts.master')

@php
	$title = __('Quản lí khu vực vận chuyển');

	$breadcrumbs = [
		[
			'label' => __('Khu vực vận chuyển'),
		],
		[
			'label' => $title
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
		<div class="col-md-12">

			<!--begin::Portlet-->
			<div class="k-portlet k-portlet--tabs">
				<div class="k-portlet__head">
					<div class="k-portlet__head-label">
						<h3 class="k-portlet__head-title">{{ __('Tạo khu vực vận chuyển') }}</h3>
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
				<form class="k-form" name="form_shipping_zones" id="form_shipping_zones" method="post" action="{{ route('bo.web.shipping-zones.store') }}">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
                                <div class="form-group">
									<label>{{ __('Tên') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Nhập tên') }}" value="{{ old('name') }}" required>
								</div>

                                <div class="form-group">
                                    <label>{{ __('Quốc gia hỗ trợ') }}</label>
                                    <select data-actions-box="true" name="supported_countries[]" title="--{{ __('Chọn quốc gia') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker Supported_Countries_Selector" multiple data-selected-text-format="count > 5">
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
									<div class="form-group Supported_Countries_Allowed_Holder mb-0">
										<div class="Supported_Countries_Holder_Content">
										</div>
									</div>
                                </div>

								<div class="form-group">
                                    <label>{{ __('Tỉnh/TP hỗ trợ') }}</label>
                                    <select data-actions-box="true" name="supported_provinces[]" title="--{{ __('Chọn Tỉnh/TP') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker Supported_Provinces_Selector" multiple data-selected-text-format="count > 5" multiple>
                                        @foreach($provinces as $province)
										<option
											{{ in_array($province->code, old("supported_provinces", [])) ? 'selected' : '' }}
											data-tokens="{{ $province->code }} | {{ $province->full_name }}"
											data-province-code="{{ $province->code }}"
											data-province-name="{{ $province->full_name }}"
											value="{{ $province->code }}">{{ $province->full_name }}</option>
                                        @endforeach
                                    </select>
									<div class="form-group Supported_Provinces_Allowed_Holder mb-0">
										<div class="Supported_Provinces_Holder_Content"></div>
									</div>
                                </div>

								<div class="form-group">
                                    <label>{{ __('Quận/Huyện hỗ trợ') }}</label>
                                    <select data-actions-box="true" name="supported_districts[]" title="--{{ __('Chọn Quận/Huyện') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker Supported_Districts_Selector" multiple data-selected-text-format="count > 5" multiple disabled data-districts='@json($districts)'>
										{{-- Render --}}
									</select>
									<div class="form-group Supported_Districts_Allowed_Holder mb-0">
										<div class="Supported_Districts_Holder_Content"></div>
									</div>
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
@include('backoffice.pages.shipping-zones.js-pages.supported-countries')
@include('backoffice.pages.shipping-zones.js-pages.supported-provinces')
@include('backoffice.pages.shipping-zones.js-pages.supported-districts')
@include('backoffice.pages.shipping-zones.js-pages.handle')
@endsection
