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

@section('style')
<style>
    .note-toolbar-wrapper.panel-default {
        margin-bottom: 10px!important;
    }
    #form_builder_dom.styled {
        padding: 10px 35px;
        border: 1px solid #ebedf2;
        border-radius: 3px;
    }
    .ce-block__content,
    .ce-toolbar__content {
        max-width: unset!important;
    }
    .codex-editor__redactor {
        padding-bottom: 0px!important;
        min-height: 200px;
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
									<input type="text" class="form-control" name="name" placeholder="{{ __('Enter name') }}" value="{{ old('name', $page->name) }}" required>
								</div>

                                <div class="form-group">
                                    <label>{{ __('Type') }}</label>
                                    <div class="k-radio-inline">
                                        <label class="k-radio">
                                            <input type="radio" name="has_custom_redirect_url" {{ !empty(old('slug', $page->slug)) ? 'checked' : empty(old('custom_redirect_url', $page->custom_redirect_url)) ? 'checked' : '' }} value="0"> {{ __('Slug') }}
                                            <span></span>
                                        </label>
                                        <label class="k-radio">
                                            <input type="radio" name="has_custom_redirect_url" {{ !empty(old('custom_redirect_url', $page->custom_redirect_url)) ? 'checked' : '' }} value="1"> {{ __('Redirect Url') }}
                                            <span></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group" data-url-type-tab-key="0">
									<label>{{ __('Slug') }} *</label>
									<input type="text" class="form-control" name="slug" placeholder="{{ __('Enter Slug') }}" value="{{ old('slug', $page->slug) }}" required>
								</div>

                                <div class="form-group d-none" data-url-type-tab-key="1">
									<label>{{ __('Custom Redirect Url') }} *</label>
									<input type="text" class="form-control" name="custom_redirect_url" placeholder="{{ __('Enter Custom Redirect Url') }}" value="{{ old('custom_redirect_url', $page->custom_redirect_url) }}" required disabled>
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
                                    <label for="">{{ __('Description') }}</label>
                                    <div id="form_builder_dom" class="styled"></div>
                                    <input type="hidden" name="description" data-builder-ref="form_builder_dom" value="{{ old('description', json_encode($page->description)) }}">
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
									<label class="col-2 col-form-label">{{ __('Has Contact Form') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('has_contact_form', boolean($page->has_contact_form) ? '1' : '0') == '1'  ? 'checked' : ''}} value="1" name="has_contact_form"/>
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
												<input type="checkbox" {{ old('status', boolean($page->status) ? '1' : '0') == '1'  ? 'checked' : ''}} value="1" name="status"/>
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
@include('backoffice.pages.category-groups.js-pages.content-builder')
@include('backoffice.pages.category-groups.js-pages.handle')
<script>
    onChangeUrlType();

    function onChangeUrlType() {
        $('[name="has_custom_redirect_url"]').on('change', function() {
            const type = $(this).val();
            $('[data-url-type-tab-key]').addClass('d-none');
            $('[data-url-type-tab-key]').find('input').prop('disabled', true);
            $(`[data-url-type-tab-key="${type}"]`).removeClass('d-none');
            $(`[data-url-type-tab-key="${type}"]`).find('input').prop('disabled', false);

            if (!!(type)) {
                $('[name="name"]').trigger('change');
            }
        });
    }

    $('[name="has_custom_redirect_url"] checked').trigger('change');
</script>
@endsection
