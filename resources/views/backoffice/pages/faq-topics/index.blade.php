@extends('backoffice.layouts.master')

@php
	$title = __('Chủ đề hỏi đáp');

	$breadcrumbs = [
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
        @include('backoffice.partials.message')
        <div class="k-portlet k-portlet--mobile">
            <div class="k-portlet__head">
                <div class="k-portlet__head-label">
                    <h3 class="k-portlet__head-title">
                        {{ __('Danh sách chủ đề hỏi đáp') }}
                    </h3>
                </div>
                @canAny(['faq-topics.store'])
                <div class="k-portlet__head-toolbar">
                    <div class="k-portlet__head-toolbar-wrapper">
                        @can('faq-topics.store')
                        <a href="{{ route('bo.web.faq-topics.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                            <i class="la la-plus"></i>
                            {{ __('Tạo chủ đề hỏi đáp') }}
                        </a>
                        @endcan
                    </div>
                </div>
                @endcan
            </div>
            <div class="k-portlet__body">
                <table id="table_faq_topics_index" data-searching="true" data-request-url="{{ route('bo.api.faq-topics.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                    <thead>
                        <tr>
                            <th data-property="id">{{ __('ID') }}</th>
                            <th data-property="name">{{ __('Tên') }}</th>
                            <th data-property="order">{{ __('Thứ tự') }}</th>
                            <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Trạng thái') }}</th>
                            <th data-property="created_at">{{ __('Ngày tạo') }}</th>
                            <th data-property="updated_at">{{ __('Ngày cập nhật') }}</th>
                            <th class="datatable-action" data-property="actions">{{ __('Hành động') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@component('backoffice.partials.datatable') @endcomponent

@section('js_script')
<script>
    onDelete();

    function onDelete() {
        $(document).on('click', '[data-action=delete]', function(e) {
            e.preventDefault();

            let confirmation = confirm("{{ __('Bạn có chắc chắn muốn xóa chủ đề Câu hỏi thường gặp này ?') }}");

            if(!confirmation) {
                return;
            }

            $.ajax({
                url: $(this).attr('href'),
                method: 'delete',
                preventRedirectOnComplete: 1,
                success: function(res) {
                    $('#table_faq_topics_index').DataTable().ajax.reload()
                }
            });
        });
    }
</script>
@endsection
