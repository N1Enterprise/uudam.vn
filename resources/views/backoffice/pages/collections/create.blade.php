@extends('backoffice.layouts.master')

@php
	$title = __('Collection');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __('Add Collection'),
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
		<div class="col-md-12">

			<!--begin::Portlet-->
			<div class="k-portlet k-portlet--tabs">
				<div class="k-portlet__head">
					<div class="k-portlet__head-label">
						<h3 class="k-portlet__head-title">{{ __('Add Collection') }}</h3>
					</div>
					<div class="k-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="tab" href="#mainTab" role="tab" aria-selected="true">
									{{ __('Thông tin chung') }}
								</a>
							</li>
                            <li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#setupInventoryTab" role="tab" aria-selected="true">
									{{ __('Setup Inventory') }}
								</a>
							</li>

                            <li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#setupFeaturedInventoryTab" role="tab" aria-selected="true">
									{{ __('Setup Featured Inventory') }}
								</a>
							</li>
						</ul>
					</div>
				</div>

				<!--begin::Form-->
				<form class="k-form" name="form_collections" id="form_collections" method="post" action="{{ route('bo.web.collections.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
								<div class="form-group">
									<label>{{ __('Tên') }} *</label>
									<input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" placeholder="{{ __('Nhập tên') }}" value="{{ old('name') }}" data-reference-slug="slug" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
								</div>

                                <div class="form-group">
									<label>{{ __('Đường dẫn') }} *</label>
									<input type="text" class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" name="slug" placeholder="{{ __('Nhập [SEO] tiêu đề') }}" value="{{ old('slug') }}" required>
                                    @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
								</div>

                                <div class="form-group">
									<label>{{ __('Order') }}</label>
									<input type="number" class="form-control {{ $errors->has('order') ? 'is-invalid' : '' }}" name="order" placeholder="{{ __('Nhập thứ tự ưu tiên') }}" value="{{ old('order') }}">
                                    @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
								</div>

                                <div class="form-group">
                                    <label>{{ __('Hình ảnh') }} *</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="upload_image_custom position-relative">
                                                <input type="text" data-image-ref-path="primary" data-image-ref-index="0" class="form-control image_primary_image_url" name="primary_image[path]" value="{{ old('primary_image.path') }}" placeholder="{{ __('Upload Image or Input URL') }}" style="padding-right: 104px;">
                                                <div data-image-ref-wrapper="primary" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                                    <div class="d-flex align-items-center h-100">
                                                        <img data-image-ref-img="primary" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                        <span data-image-ref-delete="primary" data-image-ref-index="0" aria-hidden="true" style="font-size: 16px; cursor: pointer;">&times;</span>
                                                    </div>
                                                </div>
                                                <label for="image_primary_image" class="btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                                    <input type="file" id="image_primary_image" data-image-ref-path="file" data-image-ref-index="0" name="primary_image[file]" class="d-none image_primary_image_file">
                                                    <i class="flaticon2-image-file"></i>
                                                    <span>{{ __('Upload') }}</span>
                                                </label>
                                            </div>
                                            <input type="hidden" class="form-control @anyerror('primary_image, primary_image.file, primary_image.path') is-invalid @endanyerror">
                                            @anyerror('primary_image, primary_image.file, primary_image.path')
                                            {{ $displayMessages() }}
                                            @endanyerror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="image_primary_image_review">
                                                <div data-image-ref-review-wrapper="primary" data-image-ref-index="0" class="d-none" style="width: 100px; height: 100px; border: 1px solid #ccc;">
                                                    <img data-image-ref-review-img="primary" data-image-ref-index="0" style="width: 100%; height: 100%;" src="" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Cover Image') }}</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="upload_image_custom position-relative">
                                                <input type="text" data-image-ref-path="cover" data-image-ref-index="0" class="form-control image_cover_image_url" name="cover_image[path]" value="{{ old('cover_image.path') }}" placeholder="{{ __('Upload Image or Input URL') }}" style="padding-right: 104px;">
                                                <div data-image-ref-wrapper="cover" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                                    <div class="d-flex align-items-center h-100">
                                                        <img data-image-ref-img="cover" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                        <span data-image-ref-delete="cover" data-image-ref-index="0" aria-hidden="true" style="font-size: 16px; cursor: pointer;">&times;</span>
                                                    </div>
                                                </div>
                                                <label for="image_cover_image" class="btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                                    <input type="file" id="image_cover_image" data-image-ref-path="file" data-image-ref-index="0" name="cover_image[file]" class="d-none image_cover_image_file">
                                                    <i class="flaticon2-image-file"></i>
                                                    <span>{{ __('Upload') }}</span>
                                                </label>
                                            </div>
                                            <input type="hidden" class="form-control @anyerror('cover_image, cover_image.file, cover_image.path') is-invalid @endanyerror">
                                            @anyerror('cover_image, cover_image.file, cover_image.path')
                                            {{ $displayMessages() }}
                                            @endanyerror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="image_cover_image_review">
                                                <div data-image-ref-review-wrapper="cover" data-image-ref-index="0" class="d-none" style="width: 100px; height: 100px; border: 1px solid #ccc;">
                                                    <img data-image-ref-review-img="cover" data-image-ref-index="0" style="width: 100%; height: 100%;" src="" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
									<label>{{ __('Cta Label') }}</label>
									<input type="text" class="form-control {{ $errors->has('cta_label') ? 'is-invalid' : '' }}" name="cta_label" placeholder="{{ __('Nhập thứ tự ưu tiên') }}" value="{{ old('cta_label') }}">
                                    @error('cta_label')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
								</div>

                                <div class="form-group">
                                    <x-content-editor id="collection_description" label="{{ __('Mô tả') }}" name="description" value="{{ old('description') }}" />
                                </div>

                                <div class="form-group">
									<label>{{ __('[SEO] Tiêu đề') }}</label>
									<input type="text" class="form-control {{ $errors->has('meta_title') ? 'is-invalid' : '' }}" name="meta_title" placeholder="{{ __('Nhập [SEO] tiêu đề') }}" value="{{ old('meta_title') }}">
                                    @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
								</div>

                                <div class="form-group">
									<label>{{ __('[SEO] Mô tả') }}</label>
									<input type="text" class="form-control {{ $errors->has('meta_description') ? 'is-invalid' : '' }}" name="meta_description" placeholder="{{ __('Nhập [SEO] mô tả') }}" value="{{ old('meta_description') }}">
                                    @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
								</div>

                                <div class="form-group row">
									<label class="col-2 col-form-label">{{ __('FE Display') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('display_on_frontend', '0') == '1'  ? 'checked' : ''}} value="1" name="display_on_frontend"/>
												<span></span>
											</label>
										</span>
									</div>
								</div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">{{ __('FE Search') }}</label>
                                    <div class="col-3">
                                        <span class="k-switch">
                                            <label>
                                                <input type="checkbox" {{ old('allow_frontend_search', '1') == '1'  ? 'checked' : '' }} value="1" name="allow_frontend_search"/>
                                                <span></span>
                                            </label>
                                        </span>
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

                            <div class="tab-pane" id="setupInventoryTab" role="tabpanel">
                                <div class="form-group">
                                    <label>{{ __('Inventory') }} *</label>
                                    <select data-actions-box="true" name="linked_inventories[]" title="--{{ __('Select Inventories') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker Display_Inventory_Selector" multiple data-selected-text-format="count > 5">
                                        @foreach($inventories as $inventory)
                                        <option
                                            value="{{ $inventory->id }}"
                                            data-tokens="{{ $inventory->id }} | {{ $inventory->title }} | {{ $inventory->sku }}"
                                            data-slug="{{ $inventory->slug }}"
                                            data-inventory-id="{{ $inventory->id }}"
                                            data-inventory-name="{{ $inventory->title }}"
                                            {{ in_array($inventory->id, old('linked_inventories', [])) ? 'selected' : '' }}
                                        >{{ $inventory->title }} (SKU: {{ $inventory->sku }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group Display_Inventory_Allowed_Holder mb-0">
                                    <div class="Display_Inventory_Holder_Content">
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="setupFeaturedInventoryTab" role="tabpanel">
                                <div class="form-group">
                                    <label>{{ __('Featured Inventories') }} *</label>
                                    <select data-actions-box="true" name="linked_featured_inventories[]" title="--{{ __('Select Featured Inventories') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker Display_Featured_Inventory_Selector" multiple data-selected-text-format="count > 5">
                                        @foreach($inventories as $inventory)
                                        <option
                                            value="{{ $inventory->id }}"
                                            data-tokens="{{ $inventory->id }} | {{ $inventory->title }} | {{ $inventory->sku }}"
                                            data-slug="{{ $inventory->slug }}"
                                            data-inventory-id="{{ $inventory->id }}"
                                            data-featured-inventory-name="{{ $inventory->title }}"
                                            {{ in_array($inventory->id, old('linked_featured_inventories', [])) ? 'selected' : '' }}
                                        >{{ $inventory->title }} (SKU: {{ $inventory->sku }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group Display_Featured_Inventory_Allowed_Holder mb-0">
                                    <div class="Display_Featured_Inventory_Holder_Content">
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
@include('backoffice.pages.collections.js-pages.handle')
@include('backoffice.pages.collections.js-pages.display-inventories')
@include('backoffice.pages.collections.js-pages.display-featured-inventories')
@endsection
