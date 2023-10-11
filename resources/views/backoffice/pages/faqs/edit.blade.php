@extends('backoffice.layouts.master')

@php
	$title = __('Faq');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __('Edit Faq'),
		]
	];
@endphp

@section('header')
	{{ __($title) }}
@endsection

@section('style')
<style>
    .upload_image_custom_append_icon {
        top: 50%;
        right: 0;
        transform: translate(-6%, -50%);
        color: #4346ce!important;
        border: 1px solid #4346ce!important;
    }
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

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
	<div class="row">
		<div class="col-md-6">

			<!--begin::Portlet-->
			<div class="k-portlet k-portlet--tabs">
				<div class="k-portlet__head">
					<div class="k-portlet__head-label">
						<h3 class="k-portlet__head-title">{{ __('Edit Faq') }}</h3>
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
				<form class="k-form" name="form_faqs" id="form_faqs" method="post" action="{{ route('bo.web.faqs.update', $faq->id) }}">
					@csrf
                    @method('PUT')
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
                                <div class="form-group">
									<label>{{ __('Question') }} *</label>
									<input type="text" class="form-control" name="question" placeholder="{{ __('Enter question') }}" value="{{ old('question', $faq->question) }}" required>
								</div>

                                <div class="form-group">
                                    <label for="">{{ __('Answer') }}</label>
                                    <div id="form_builder_dom" class="styled"></div>
                                    <input type="hidden" name="answer" data-builder-ref="form_builder_dom" value="{{ old('answer', json_encode($faq->answer)) }}">
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Topic') }} *</label>
                                    <select name="faq_topic_id" title="--{{ __('Select Topic') }}--" class="form-control k_selectpicker">
                                        @foreach($faqTopics as $faqTopic)
                                        <option value="{{ $faqTopic->id }}" {{ old('faq_topic_id', $faq->faq_topic_id) == $faqTopic->id ? 'selected' : '' }}>{{ $faqTopic->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('group_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
									<label>{{ __('Order') }}</label>
									<input type="number" class="form-control" name="order" placeholder="{{ __('Enter Order') }}" value="{{ old('order', $faq->order) }}">
								</div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Active') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('status', boolean($faq->status) ? '1' : '0') == '1'  ? 'checked' : ''}} value="1" name="status"/>
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
@include('backoffice.pages.faqs.js-pages.content-builder')
@include('backoffice.pages.faqs.js-pages.handle')
@endsection
