@extends('backoffice.layouts.master')

@php
	$title = __('Chỉnh sửa trang');

	$breadcrumbs = [
		[
			'label' => __('Trang'),
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
						<h3 class="k-portlet__head-title">{{ __('Thông tin trang') }}</h3>
					</div>
					<div class="k-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="tab" href="#mainTab" role="tab">
									{{ __('Thông tin chung') }}
								</a>
							</li>
						</ul>
					</div>
				</div>

				<!--begin::Form-->
				<form class="k-form" name="form_pages" id="form_pages" method="post" action="{{ route('bo.web.pages.update', $page->id) }}">
					@csrf
                    @method('PUT')
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
								<div class="form-group">
									<label>{{ __('Tên') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Nhập tên') }}" value="{{ old('name', $page->name) }}" data-reference-slug="slug" required>
								</div>

                                <div class="form-group">
                                    <label>{{ __('Hiển thị tại') }} *</label>
                                    <select data-actions-box="true" name="display_in[]" title="-- {{ __('Chọn trang để hiển thị') }} --" data-size="5" data-live-search="true" class="form-control k_selectpicker" multiple data-selected-text-format="count > 5" required>
                                        @foreach($pageDisplayInEnumLabels as $key => $label)
                                        <option
                                            {{ in_array($key, old("display_in", data_get($page, 'display_in', []))) ? 'selected' : '' }}
                                            data-tokens="{{ $key }} | {{ $label }}"
                                            data-subtext="{{ $key }}"
                                            data-name="{{ $label }}"
                                            value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
									<label>{{ __('Đường dẫn') }} *</label>
									<input type="text" class="form-control" name="slug" placeholder="{{ __('Nhập [SEO] tiêu đề') }}" value="{{ old('slug', $page->slug) }}" required>
								</div>

                                <div class="form-group">
									<label>{{ __('Tiêu đề') }} *</label>
									<input type="text" class="form-control" name="title" placeholder="{{ __('Nhập tiêu đề') }}" value="{{ old('title', $page->title) }}" required>
								</div>

                                <div class="form-group">
									<label>{{ __('Thứ tự') }}</label>
									<input type="number" class="form-control" name="order" placeholder="{{ __('Nhập thứ tự ưu tiên') }}" value="{{ old('order', $page->order) }}">
								</div>

                                <div class="form-group">
                                    <x-content-editor id="page_content" label="{{ __('Nội dung') }}" name="content" value="{{ old('content', $page->content) }}" />
                                </div>

                                <div class="form-group">
									<label>{{ __('[SEO] Tiêu đề') }}</label>
									<input type="text" class="form-control" name="meta_title" placeholder="{{ __('Nhập [SEO] tiêu đề') }}" value="{{ old('meta_title', $page->meta_title) }}">
								</div>

                                <div class="form-group">
									<label>{{ __('[SEO] Mô tả') }}</label>
									<input type="text" class="form-control" name="meta_description" placeholder="{{ __('Nhập [SEO] mô tả') }}" value="{{ old('meta_description', $page->meta_description) }}">
								</div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Hoạt động') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('status', boolean($page->status) ? '1' : '0') == '1'  ? 'checked' : ''}} value="1" name="status"/>
												<span></span>
											</label>
										</span>
									</div>
								</div>

                                <div class="row">
									<div class="col-2">
										<label class="col-form-label">{{ __('Hiển thị FE') }}</label>
									</div>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ boolean(old('display_on_frontend', $page->display_on_frontend)) ? 'checked' : ''}} value="1" name="display_on_frontend" />
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
