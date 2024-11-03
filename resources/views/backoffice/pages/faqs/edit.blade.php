@extends('backoffice.layouts.master')

@php
	$title = __('Chỉnh sửa câu hỏi thường gặp');

	$breadcrumbs = [
		[
			'label' => __('Câu hỏi thường gặp'),
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
						<h3 class="k-portlet__head-title">{{ __('Thông tin câu hỏi thường gặp') }}</h3>
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
				<form class="k-form" name="form_faqs" id="form_faqs" method="post" action="{{ route('bo.web.faqs.update', $faq->id) }}">
					@csrf
                    @method('PUT')
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab">
                                <div class="form-group">
									<label>{{ __('Câu hỏi') }} *</label>
									<input type="text" class="form-control" name="question" placeholder="{{ __('Nhập câu hỏi') }}" value="{{ old('question', $faq->question) }}" required>
								</div>

                                <div class="form-group">
                                    <x-content-editor id="faq_answer" label="{{ __('Câu trả lời') }}" name="answer" value="{{ old('answer', $faq->answer) }}" />
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Chủ đề') }} *</label>
                                    <select name="faq_topic_id" title="-- {{ __('Chọn chủ đề') }} --" class="form-control k_selectpicker">
                                        @foreach($faqTopics as $faqTopic)
                                        <option value="{{ $faqTopic->id }}" {{ old('faq_topic_id', $faq->faq_topic_id) == $faqTopic->id ? 'selected' : '' }}>{{ $faqTopic->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('group_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
									<label>{{ __('Thứ tự') }}</label>
									<input type="number" class="form-control" name="order" placeholder="{{ __('Nhập thứ tự ưu tiên') }}" value="{{ old('order', $faq->order) }}">
								</div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Hoạt động') }}</label>
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
