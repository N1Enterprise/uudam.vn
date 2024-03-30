@extends('backoffice.layouts.master')

@php
	$title = __('Chỉnh sửa nhóm menu');

	$breadcrumbs = [
		[
			'label' => __('Nhóm menu'),
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
						<h3 class="k-portlet__head-title">{{ __('Thông tin nhóm menu') }}</h3>
					</div>
					<div class="k-portlet__head-toolbar">
						<ul class="nav nav-tabs nav-tabs-bold nav-tabs-line nav-tabs-line-brand" role="tablist">
							<li class="nav-item">
								<a class="nav-link active show" data-toggle="tab" href="#mainTab" role="tab">
									{{ __('Thông tin chung') }}
								</a>
							</li>
                            <li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#advanceTab" role="tab">
									{{ __('Nâng cao') }}
								</a>
							</li>
						</ul>
					</div>
				</div>

				<!--begin::Form-->
				<form class="k-form" name="form_menu_groups" id="form_menu_groups" method="post" action="{{ route('bo.web.menu-groups.update', $menuGroup->id) }}">
					@csrf
                    @method('PUT')
					<div class="k-portlet__body">
						@include('backoffice.partials.message')
						<div class="tab-content">
							<div class="tab-pane active show" id="mainTab" role="tabpanel">
								<div class="form-group">
									<label>{{ __('Tên') }} *</label>
									<input type="text" class="form-control" name="name" placeholder="{{ __('Nhập tên') }}" value="{{ old('name', $menuGroup->name) }}" required>
								</div>

                                <div class="form-group">
									<label>{{ __('Chuyển hướng URL') }}</label>
									<input type="text" class="form-control" name="redirect_url" placeholder="{{ __('Nhập Url chuyển hướng') }}" value="{{ old('redirect_url', $menuGroup->redirect_url) }}">
								</div>

                                <div class="form-group">
									<label>{{ __('Thứ tự') }}</label>
									<input type="number" class="form-control" name="order" placeholder="{{ __('Nhập thứ tự ưu tiên') }}" value="{{ old('order', $menuGroup->order) }}">
								</div>

								<div class="form-group row">
									<label class="col-2 col-form-label">{{ __('Hiển thị FE') }}</label>
									<div class="col-3">
										<span class="k-switch">
											<label>
												<input type="checkbox" {{ old('display_on_frontend', boolean($menuGroup->display_on_frontend)) == '1'  ? 'checked' : ''}} value="1" name="display_on_frontend" />
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
												<input type="checkbox" {{ old('status', boolean($menuGroup->status)) == '1'  ? 'checked' : ''}} value="1" name="status"/>
												<span></span>
											</label>
										</span>
									</div>
								</div>
							</div>
                            <div class="tab-pane" id="advanceTab" role="tabpanel">
                                <div class="form-group">
									<label for="gameCode">{{ __('Behavior') }}</label>
									<div id="json_editor_params" style="height: 200px"></div>
									<input type="hidden" name="params" value="{{ old('params', display_json_value($menuGroup->params)) }}">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.4/ace.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        let editorMeta = ace.edit($('#json_editor_params')[0], {
            mode: "ace/mode/json",
            theme: 'ace/theme/tomorrow',
            value: $(`input[name="params"]`).val()
        });

        $('form#form_menu_groups').on('submit', function(e) {
            e.preventDefault();
            let editorMetaElement = $(`input[name="params"]`).val(editorMeta.getValue());
            $(this).append(editorMetaElement);
            $(this)[0].submit();
        });
    });
</script>
@endsection
