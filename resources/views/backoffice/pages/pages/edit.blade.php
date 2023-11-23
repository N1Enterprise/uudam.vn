@extends('backoffice.layouts.master')

@php
	$title = __('Page');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __('Edit Page'),
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
						<h3 class="k-portlet__head-title">{{ __('Edit Page') }}</h3>
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
				<form class="k-form" name="form_pages" id="form_pages" method="post" action="{{ route('bo.web.pages.update', $page->id) }}">
					@csrf
                    @method('PUT')
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
								<div class="form-group">
									<label>{{ __('Name') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Enter name') }}" value="{{ old('name', $page->name) }}" data-reference-slug="slug" required>
								</div>

                                <div class="form-group">
                                    <label>{{ __('Display In') }} *</label>
                                    <select data-actions-box="true" name="display_in[]" title="--{{ __('Select the page to display') }}--" data-size="5" data-live-search="true" class="form-control k_selectpicker" multiple data-selected-text-format="count > 5" required>
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
									<label>{{ __('Slug') }} *</label>
									<input type="text" class="form-control" name="slug" placeholder="{{ __('Enter Slug') }}" value="{{ old('slug', $page->slug) }}" required>
								</div>

                                <div class="form-group">
									<label>{{ __('Title') }} *</label>
									<input type="text" class="form-control" name="title" placeholder="{{ __('Enter title') }}" value="{{ old('title', $page->title) }}" required>
								</div>

                                <div class="form-group">
									<label>{{ __('Order') }}</label>
									<input type="number" class="form-control" name="order" placeholder="{{ __('Enter Order') }}" value="{{ old('order', $page->order) }}">
								</div>

                                <div class="form-group">
                                    <x-content-editor id="page_content" label="Content" name="content" value="{{ old('content', $page->content) }}" />
                                </div>

                                <div class="form-group">
									<label>{{ __('Meta Title') }}</label>
									<input type="text" class="form-control" name="meta_title" placeholder="{{ __('Enter Slug') }}" value="{{ old('meta_title', $page->meta_title) }}">
								</div>

                                <div class="form-group">
									<label>{{ __('Meta Description') }}</label>
									<input type="text" class="form-control" name="meta_description" placeholder="{{ __('Enter Slug') }}" value="{{ old('meta_description', $page->meta_description) }}">
								</div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Active') }}</label>
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
										<label class="col-form-label">{{ __('Display on Front End') }}</label>
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
