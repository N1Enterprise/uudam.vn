@extends('backoffice.layouts.master')

@php
	$title = __('Category');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __('Edit Category'),
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
						<h3 class="k-portlet__head-title">{{ __('Edit Category') }}</h3>
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
				<form class="k-form" name="update_category" id="update_category" method="post" action="{{ route('bo.web.categories.update', $category->id) }}" enctype="multipart/form-data">
					@csrf
                    @method('put')
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
								<div class="form-group">
									<label>{{ __('Name') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Enter name') }}" value="{{ old('name', $category->name) }}" required>
								</div>

                                <div class="form-group">
									<label>{{ __('Slug') }} *</label>
									<input type="text" class="form-control" name="slug" placeholder="{{ __('Enter Slug') }}" value="{{ old('slug', $category->slug) }}" required>
								</div>

                                <div class="form-group">
                                    <label>{{ __('Category Group') }} *</label>
                                    <select name="category_group_id" placeholder="{{ __('Category Group') }}" data-original-title="{{ __('Category Group') }}" data-toggle="tooltip" data-live-search="true" class="form-control k_selectpicker" required>
                                        <option value="">--{{ __('Select Category Group') }}--</option>
                                        @foreach($categoryGroups as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_group_id', $category->category_group_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
									<label>{{ __('Order') }}</label>
									<input type="number" class="form-control" name="order" placeholder="{{ __('Enter Order') }}" value="{{ old('order', $category->order) }}">
								</div>

                                <div class="form-group">
									<label>{{ __('Icon Image') }}</label>
									<input type="file" class="form-control" name="icon_image" placeholder="{{ __('Enter Icon Image') }}" value="{{ old('icon_image') }}">

                                    <div class="image_review mt-2">
                                        <img src="{{ $category->icon_image }}" width="100" height="100" alt="Icon Image">
                                    </div>
								</div>

                                <div class="form-group">
									<label>{{ __('Description') }}</label>
                                    <textarea unselectable="on" name="description" rows="3" class="form-control">{{ old('description', $category->description) }}</textarea>
								</div>

                                <div class="form-group">
									<label>{{ __('Meta Title') }}</label>
									<input type="text" class="form-control" name="meta_title" placeholder="{{ __('Enter Meta Title') }}" value="{{ old('meta_title', $category->meta_title) }}">
								</div>

                                <div class="form-group">
									<label>{{ __('Meta Description') }}</label>
									<input type="text" class="form-control" name="meta_description" placeholder="{{ __('Enter Meta Description') }}" value="{{ old('meta_description') }}">
								</div>

                                <div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Feature') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('featured', boolean($category->featured) ? 1 : 0) == '1'  ? 'checked' : ''}} value="1" name="featured"/>
												<span></span>
											</label>
										</span>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Active') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('status', boolean($category->status) ? 1 : 0) == '1'  ? 'checked' : ''}} value="1" name="status"/>
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

@endsection
