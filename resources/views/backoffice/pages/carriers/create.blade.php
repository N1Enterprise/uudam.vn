@extends('backoffice.layouts.master')

@php
	$title = __('Carrier');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __('Add Carrier'),
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
						<h3 class="k-portlet__head-title">{{ __('Add Carrier') }}</h3>
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
				<form class="k-form" name="form_carriers" id="form_carriers" method="post" action="{{ route('bo.web.carriers.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
                                <div class="form-group">
									<label>{{ __('Name') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Enter name') }}" value="{{ old('name') }}" required>
								</div>

                                <div class="form-group">
									<label>{{ __('Email') }}</label>
									<input type="text" class="form-control" name="email" placeholder="{{ __('Enter email') }}" value="{{ old('email') }}">
								</div>

                                <div class="form-group">
									<label>{{ __('Phone') }}</label>
									<input type="text" class="form-control" name="phone" placeholder="{{ __('Enter phone') }}" value="{{ old('phone') }}">
								</div>

                                <div class="form-group">
                                    <label>{{ __('Logo Image') }}</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="upload_image_custom position-relative">
                                                <input type="text" data-image-ref-path="logo" data-image-ref-index="0" class="form-control image_logo_url" name="logo[path]" value="{{ old('logo.path') }}" placeholder="{{ __('Upload Image or Input URL') }}" style="padding-right: 104px;">
                                                <div data-image-ref-wrapper="logo" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                                    <div class="d-flex align-items-center h-100">
                                                        <img data-image-ref-img="logo" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                        <span data-image-ref-delete="logo" data-image-ref-index="0" aria-hidden="true" style="font-size: 16px; cursor: pointer;">&times;</span>
                                                    </div>
                                                </div>
                                                <label for="image_logo" class="btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                                    <input type="file" id="image_logo" data-image-ref-path="file" data-image-ref-index="0" name="logo[file]" class="d-none image_logo_file">
                                                    <i class="flaticon2-image-file"></i>
                                                    <span>{{ __('Upload') }}</span>
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
                                        <label for="parameters">{{ __('Parameters') }}</label>
                                        <div id="json_editor_params" style="height: 200px"></div>
                                        <input type="hidden" name="params" value="{{ old('params', '{}') }}">
                                    </div>
                                </div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Active') }}</label>
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
@include('backoffice.pages.carriers.js-pages.handle')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.4/ace.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        let editorMeta = ace.edit($('#json_editor_params')[0], {
            mode: "ace/mode/json",
            theme: 'ace/theme/tomorrow',
            value: $(`input[name="params"]`).val()
        });

        $('form#form_carriers').on('submit', function(e) {
            e.preventDefault();
            let editorMetaElement = $(`input[name="params"]`).val(editorMeta.getValue());
            $(this).append(editorMetaElement);
            $(this)[0].submit();
        })
    })
</script>
@endsection
