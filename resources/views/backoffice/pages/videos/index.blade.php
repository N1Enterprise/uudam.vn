@extends('backoffice.layouts.master')

@php
	$title = __('Video');

	$breadcrumbs = [
		[
			'label' => $title,
		],
	];
@endphp

@section('header')
{{ __($title) }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
	<div class="k-portlet k-portlet--mobile">
		<div class="k-portlet__head">
			<div class="k-portlet__head-label">
				<h3 class="k-portlet__head-title">
					{{__('Danh sách video')}}
				</h3>
			</div>

            @can('videos.store')
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    <a href="{{ route('bo.web.videos.create') }}" class="btn btn-default btn-bold btn-upper btn-font-sm">
                        <i class="flaticon2-add-1"></i>
                        {{__('Tạo video')}}
                    </a>

                </div>
            </div>
            @endcan
		</div>
		<div class="k-portlet__body">
			<!--begin: Datatable -->
			<table id="table-video" data-request-url="{{ route('bo.api.videos.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable fs-table-object">
				<thead>
					<tr>
						<th data-property="id">{{ __('ID') }}</th>
						<th data-property="name">{{ __('Tên') }}</th>
						<th data-property="order">{{ __('Tứ tự') }}</th>
						<th data-orderable="false" data-property="thumbnail" data-render-callback="renderCallbackThumbnail">{{ __('Thumbnail') }}</th>
						<th data-badge data-name="video_category_id" data-link="category.actions.update" data-link-target="_blank" data-property="category.name">{{ __('Danh mục') }}</th>
						<th data-badge data-name="type" data-property="type_name">{{ __('Loại') }}</th>
						<th data-badge data-name="status" data-property="status_name">{{ __('Trạng thái') }}</th>
						<th data-badge data-name="display_on_frontend" data-property="display_on_frontend_name">{{ __('Hiển thị FE') }}</th>
						<th data-property="created_at">{{ __('Ngày tạo') }}</th>
						<th data-property="updated_at">{{ __('Ngày cập nhật') }}</th>
						<th data-orderable="false" data-property="created_by.name">{{ __('Người tạo') }}</th>
                        <th data-orderable="false" data-property="updated_by.name">{{ __('Người cập nhật') }}</th>
						<th class="datatable-action" data-property="actions">{{ __('Hành động') }}</th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>

			<!--end: Datatable -->
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

            let confirmation = confirm("{{ __('Bạn có chắc chắn muốn xóa video này ?') }}");

            if (! confirmation) {
                return;
            }

            $.ajax({
                url: $(this).attr('href'),
                method: 'delete',
                preventRedirectOnComplete: 1,
                success: function(res) {
                    $('#table-video').DataTable().ajax.reload();
                }
            });
        });
    }

    function renderCallbackThumbnail(data, type, full) {
        const image = $('<img>', {
            src: data,
            width: 80,
            height: 80,
        });

        return image.prop('outerHTML');
    }
</script>
@endsection
