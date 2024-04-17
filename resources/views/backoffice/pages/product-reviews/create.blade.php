@extends('backoffice.layouts.master')

@php
	$title = __('Tạo đánh giá');

	$breadcrumbs = [
		[
			'label' => __('Đánh giá sản phẩm'),
		],
		[
			'label' => $title
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
						<h3 class="k-portlet__head-title">{{ __('Thông tin đánh giá') }}</h3>
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
				<form class="k-form" name="form_product_reviews" id="form_product_reviews" method="post" action="{{ route('bo.web.product-reviews.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab">
								<div class="form-group">
									<label>{{ __('Tên khách hàng') }} *</label>
									<input type="text" class="form-control" name="user_name" placeholder="{{ __('Nhập tên khách hàng') }}" value="{{ old('user_name') }}" required>
								</div>

                                <div class="form-group">
									<label>{{ __('Số điện thoại') }}</label>
									<input type="text" class="form-control" name="user_phone" placeholder="{{ __('Nhập số điện thoại') }}" value="{{ old('user_phone') }}">
								</div>

                                <div class="form-group">
									<label>{{ __('E-mail') }}</label>
									<input type="text" class="form-control" name="user_email" placeholder="{{ __('Nhập e-mail') }}" value="{{ old('user_email') }}">
								</div>

                                <div class="form-group">
                                    <label>{{ __('Sản phẩm') }} *</label>
                                    <select name="product_id" title="-- {{ __('Chọn sản phẩm') }} --" class="form-control k_selectpicker" data-size="5" data-live-search="true">
                                        @foreach($categories as $category)
                                        <optgroup label="{{ $category->name }}">
                                            @foreach($category->products as $product)
                                            <option  data-tokens="{{ $product->id }} | {{ $product->name }} | {{ $product->slug }} | {{ $product->code }}" value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }} data-product-type="{{ $product->type }}">{{ $product->name }} ({{ $product->type_name }}) | {{ $product->code }}</option>
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Loại xếp hạng') }} *</label>
                                    <select name="rating_type" title="-- {{ __('Chọn loại xếp hạng') }} --" class="form-control k_selectpicker">
                                        @foreach($productReviewRatingEnumLabels as $key => $label)
                                        <option value="{{ $key }}" {{ old('rating_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="">{{ __('Đăng lúc') }}</label>
                                    <input type="datetimepicker" class="form-control @error('post_at') is-invalid @enderror" name="post_at" value="{{ old('post_at', date('Y-m-d h:i', strtotime(now()))) }}">
                                </div>

                                <div class="form-group">
									<label>{{ __('Nội dung') }} *
                                        <div><small>({{ __('Độ dài tối đa 1000 ký tự') }})</small></div>
                                    </label>

                                    <textarea name="content" rows="10" class="form-control" maxlength="1000" required>{{ old('content') }}</textarea>
								</div>

                                <div class="form-group">
                                    <label for="">{{ __('Ảnh đánh giá') }}</label>
                                    <div class="media_image_repeater">
                                        <div data-repeater-list="images">
                                            <div data-repeater-item class="k-repeater__item">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="upload_image_custom position-relative">
                                                            <input type="text" data-image-ref-path="media" data-image-ref-index="0" class="form-control media_image_path" name="path" placeholder="{{ __('Tải ảnh lên hoặc nhập URL ảnh') }}" style="padding-right: 104px;" value="{{ old('primary_image.path') }}">
                                                            <div data-image-ref-wrapper="media" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                                                <div class="d-flex align-items-center h-100">
                                                                    <img data-image-ref-img="media" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                                    <span data-image-ref-delete="media" data-image-ref-index="0" style="font-size: 16px; cursor: pointer;">&times;</span>
                                                                </div>
                                                            </div>
                                                            <label for="media_image_file_0" class="media_image_file_wapper btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                                                <input type="file" name="images[0][file]" data-image-ref-file="media" data-image-ref-index="0" class="d-none media_image_file" id="media_image_file_0" accept="image/*">
                                                                <i class="flaticon2-image-file"></i>
                                                                <span>{{ __('Tải lên') }}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-start">
                                                            <div class="image_media_image_review mr-1">
                                                                <div data-image-ref-review-wrapper="media" data-image-ref-index="0" class="d-none" style="width: 100px; height: 100px; border: 1px solid #ccc;">
                                                                    <img data-image-ref-review-img="media" data-image-ref-index="0" style="width: 100%; height: 100%;" src="" alt="">
                                                                </div>
                                                            </div>
                                                            <button type="button" data-repeater-delete class="btn btn-secondary btn-icon h-100 mr-2" style="width: 30px!important; height: 30px!important;">
                                                                <i class="la la-close"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="k-separator k-separator--space-sm"></div>
                                            </div>
                                        </div>
                                        <div class="k-repeater__add-data">
                                            <span data-repeater-create="" class="btn btn-info btn-sm">
                                                <i class="la la-plus"></i> {{ __('Thêm') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Đã mua hàng') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('is_purchased', '1') == '1'  ? 'checked' : ''}} value="1" name="is_purchased" />
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
@include('backoffice.pages.product-reviews.js-pages.handle')
@endsection
